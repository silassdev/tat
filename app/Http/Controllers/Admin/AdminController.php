<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\DeliveryFee;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use App\Models\AdminInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display Overview Stats Dashboard.
     */
    public function index()
    {
        $totalSales = Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])->sum('total_amount');
        $totalOrders = Order::count();
        $pendingPayments = Order::where('status', 'pending')->where('payment_status', 'pending')->count();
        $failedPayments = Order::where('status', 'failed_payment')->count();
        $outOfStockProducts = Product::where('stock', '<=', 0)->count();
        $totalUsers = User::where('role', 'user')->count();
        
        $recentActivity = ActivityLog::with('user')->latest()->limit(15)->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'pendingPayments',
            'failedPayments',
            'outOfStockProducts',
            'totalUsers',
            'recentActivity'
        ));
    }

    /**
     * Retrieve products index data.
     */
    public function productsIndex()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();
        return view('admin.dashboard', compact('products', 'categories'))->with('activeTab', 'products');
    }

    /**
     * Store a newly created product (Product CRUD).
     */
    public function productsStore(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'cost' => ['required', 'numeric', 'min:0'],
            'color' => ['nullable', 'string', 'max:50'],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:active,inactive'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'description' => $request->description,
                'price' => $request->price,
                'cost' => $request->cost,
                'color' => $request->color,
                'unit' => $request->unit,
                'stock' => $request->stock,
                'status' => $request->status,
            ]);

            // Handle images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path
                    ]);
                }
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'event' => 'product_created',
                'description' => "Product '{$product->name}' successfully created in catalog.",
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('admin.products')->with('status', 'Product successfully created and added to index.');
    }

    /**
     * Update product details (Product CRUD).
     */
    public function productsUpdate(Request $request, $id)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'cost' => ['required', 'numeric', 'min:0'],
            'color' => ['nullable', 'string', 'max:50'],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:active,inactive'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $product = Product::findOrFail($id);

        DB::transaction(function () use ($request, $product) {
            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'cost' => $request->cost,
                'color' => $request->color,
                'unit' => $request->unit,
                'stock' => $request->stock,
                'status' => $request->status,
            ]);

            // Handle images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path
                    ]);
                }
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'event' => 'product_updated',
                'description' => "Product details updated for: '{$product->name}'",
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('admin.products')->with('status', 'Product successfully updated.');
    }

    /**
     * Delete product from database catalog.
     */
    public function productsDestroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $name = $product->name;
        
        DB::transaction(function () use ($product, $request, $name) {
            // Delete actual stored files
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img->image_path);
            }
            $product->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'event' => 'product_deleted',
                'description' => "Product '{$name}' permanently purged from database directory.",
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()->route('admin.products')->with('status', 'Product permanently deleted.');
    }

    /**
     * Update order shipment status.
     */
    public function ordersUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,paid,processing,shipped,delivered,cancelled,failed_payment'],
        ]);

        $order = Order::findOrFail($id);

        DB::transaction(function () use ($request, $order) {
            $oldStatus = $order->status;
            $newStatus = $request->status;

            // Stock handling: if cancelled or failed, return stock back
            if (in_array($newStatus, ['cancelled', 'failed_payment']) && !in_array($oldStatus, ['cancelled', 'failed_payment'])) {
                foreach ($order->items as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            // If moved BACK to active status from cancelled, reserve stock again
            elseif (!in_array($newStatus, ['cancelled', 'failed_payment']) && in_array($oldStatus, ['cancelled', 'failed_payment'])) {
                foreach ($order->items as $item) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            $order->update(['status' => $newStatus]);

            // Sync payment status as helper
            if ($newStatus === 'paid' || $newStatus === 'delivered') {
                $order->update(['payment_status' => 'paid']);
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'event' => 'order_status_updated',
                'description' => "Order {$order->order_number} status updated from '{$oldStatus}' to '{$newStatus}'",
                'ip_address' => $request->ip()
            ]);
        });

        return back()->with('status', 'Order status updated successfully. System stock balances synced.');
    }

    /**
     * Toggle Customer status (Enable / Disable).
     */
    public function customersToggle(Request $request, $id)
    {
        $user = User::where('role', 'user')->findOrFail($id);
        $newStatus = $user->status === 'active' ? 'disabled' : 'active';
        
        $user->update(['status' => $newStatus]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'event' => 'customer_status_toggled',
            'description' => "Customer Account {$user->email} set to '{$newStatus}' state.",
            'ip_address' => $request->ip()
        ]);

        return back()->with('status', "Customer account status set to {$newStatus} successfully.");
    }

    /**
     * Create promotional Coupon Discount (Coupon CRUD).
     */
    public function couponsStore(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:coupons,code', 'max:50'],
            'type' => ['required', 'string', 'in:percentage,fixed'],
            'value' => ['required', 'numeric', 'min:0'],
            'expiry_date' => ['required', 'date', 'after:today'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'min_order_value' => ['nullable', 'numeric', 'min:0'],
        ]);

        Coupon::create($request->all());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'event' => 'coupon_created',
            'description' => "New coupon discount '{$request->code}' successfully generated.",
            'ip_address' => $request->ip()
        ]);

        return back()->with('status', 'Promotional coupon code created successfully.');
    }

    /**
     * Delete Coupon from database directory.
     */
    public function couponsDestroy(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $code = $coupon->code;
        $coupon->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'event' => 'coupon_deleted',
            'description' => "Coupon discount '{$code}' permanently purged from database.",
            'ip_address' => $request->ip()
        ]);

        return back()->with('status', 'Coupon code deleted successfully.');
    }

    /**
     * Update delivery charge thresholds.
     */
    public function deliveryStore(Request $request)
    {
        $request->validate([
            'fee' => ['required', 'numeric', 'min:0'],
            'free_threshold' => ['nullable', 'numeric', 'min:0'],
        ]);

        $delivery = DeliveryFee::firstOrCreate([]);
        $delivery->update([
            'type' => 'flat',
            'fee' => $request->fee,
            'free_threshold' => $request->free_threshold,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'event' => 'delivery_fee_updated',
            'description' => "Flat delivery fee set to: {$request->fee}. Free threshold set to: {$request->free_threshold}",
            'ip_address' => $request->ip()
        ]);

        return back()->with('status', 'Global delivery fee thresholds updated successfully.');
    }

    /**
     * Send Admin invitations.
     */
    public function invitesStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email', 'unique:admin_invites,email'],
        ]);

        $token = Str::random(32);
        
        AdminInvite::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'admin',
            'token' => $token,
            'expires_at' => now()->addDays(7)
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'event' => 'admin_invite_sent',
            'description' => "Admin invitation node token generated and queued for: {$request->email}",
            'ip_address' => $request->ip()
        ]);

        return back()->with('status', "Admin invitation token created. Dispatch URL: " . url('/register?invite=' . $token));
    }

    /**
     * Send replies in customer support tickets.
     */
    public function ticketsReply(Request $request, $id)
    {
        $request->validate([
            'message' => ['required', 'string'],
            'status' => ['required', 'string', 'in:open,pending,resolved'],
        ]);

        $ticket = Ticket::findOrFail($id);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        $ticket->update(['status' => $request->status]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'event' => 'ticket_replied_admin',
            'description' => "Admin replied to ticket #{$ticket->id} and marked status as '{$request->status}'",
            'ip_address' => $request->ip()
        ]);

        return back()->with('status', 'Support thread response logged successfully.');
    }
}
