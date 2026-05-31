<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // If user is admin, redirect to admin dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $orders = Order::where('user_id', $user->id)
            ->with(['items.product', 'payment'])
            ->latest()
            ->get();

        $tickets = Ticket::where('user_id', $user->id)
            ->with(['messages.user'])
            ->latest()
            ->get();

        return view('dashboard.index', compact('user', 'orders', 'tickets'));
    }

    /**
     * Update user profile information.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'event' => 'profile_updated',
            'description' => "User {$user->email} updated profile details.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'Profile details successfully updated in the system directory.');
    }

    /**
     * Update user account security password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'event' => 'password_updated',
            'description' => "User {$user->email} successfully updated their password.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'Security node credentials updated successfully.');
    }

    /**
     * Create a new support ticket.
     */
    public function createTicket(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $user = Auth::user();

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'subject' => $request->subject,
            'status' => 'open',
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $request->message,
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'event' => 'ticket_created',
            'description' => "Support ticket #{$ticket->id} created: '{$ticket->subject}'",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'Support ticket submitted. Technical operators notified.');
    }

    /**
     * Reply to an existing support ticket thread.
     */
    public function replyTicket(Request $request, $ticket_id)
    {
        $request->validate([
            'message' => ['required', 'string'],
        ]);

        $user = Auth::user();
        $ticket = Ticket::where('user_id', $user->id)->findOrFail($ticket_id);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $request->message,
        ]);

        $ticket->update(['status' => 'open']);

        ActivityLog::create([
            'user_id' => $user->id,
            'event' => 'ticket_replied_customer',
            'description' => "Customer replied to support ticket #{$ticket->id}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'Reply logged successfully in thread.');
    }
}
