<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\ActivityLog;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OtpController extends Controller
{
    /**
     * Send OTP verification code to the guest/user email.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $email = $request->email;
        $otp = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Save OTP to database
        EmailOtp::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10),
            'verified' => false,
        ]);

        // Send Email
        try {
            Mail::to($email)->send(new SendOtpMail($otp));
            ActivityLog::create([
                'event' => 'otp_sent',
                'description' => "OTP code sent to email: {$email}",
                'ip_address' => $request->ip(),
            ]);
        } catch (\Exception $e) {
            // Log fallback or error
            ActivityLog::create([
                'event' => 'otp_send_failed',
                'description' => "Failed to send OTP to: {$email}. Error: {$e->getMessage()}",
                'ip_address' => $request->ip(),
            ]);
            return back()->withErrors(['email' => 'Failed to send OTP email. Please verify your SMTP settings in .env: ' . $e->getMessage()]);
        }

        // Store email in session
        session(['checkout_email' => $email]);

        return redirect()->route('otp.verify');
    }

    /**
     * Show OTP verification screen.
     */
    public function showVerify()
    {
        $email = session('checkout_email');
        if (!$email) {
            return redirect()->route('login')->withErrors(['email' => 'Please enter your email to receive an OTP code.']);
        }

        return view('auth.verify-otp', ['email' => $email]);
    }

    /**
     * Verify the entered OTP and authenticate/onboard.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $email = session('checkout_email');
        if (!$email) {
            return redirect()->route('login');
        }

        $otpRecord = EmailOtp::where('email', $email)
            ->where('verified', false)
            ->latest()
            ->first();

        if (!$otpRecord || $otpRecord->otp !== $request->otp || $otpRecord->isExpired()) {
            ActivityLog::create([
                'event' => 'otp_verify_failed',
                'description' => "Failed OTP verification attempt for: {$email}",
                'ip_address' => $request->ip(),
            ]);
            return back()->withErrors(['otp' => 'The verification code is invalid or has expired.']);
        }

        // Mark OTP as verified
        $otpRecord->update(['verified' => true]);

        ActivityLog::create([
            'event' => 'otp_verified',
            'description' => "Successfully verified OTP for: {$email}",
            'ip_address' => $request->ip(),
        ]);

        // Find or create User
        $user = User::where('email', $email)->first();
        $isNewUser = false;

        if (!$user) {
            $isNewUser = true;
            // Create temporary guest account
            $user = User::create([
                'name' => 'Guest User',
                'email' => $email,
                'role' => 'user',
                'status' => 'active',
                'password' => Hash::make(Str::random(16)), // Temp password, will force password creation
            ]);
            $user->email_verified_at = now();
            $user->save();

            ActivityLog::create([
                'user_id' => $user->id,
                'event' => 'guest_user_created',
                'description' => "Temporary guest account created for: {$email}",
                'ip_address' => $request->ip(),
            ]);
        }

        // Login user
        Auth::login($user);

        // Merge activities (guest cart items) into user cart
        $this->mergeGuestCart($user);

        // Redirect flow
        if ($isNewUser || !$user->password || Hash::needsRehash($user->password) || $user->name === 'Guest User') {
            session(['must_set_password' => true]);
            return redirect()->route('password.setup');
        }

        return $this->redirectBasedOnRole($user);
    }

    /**
     * Show force password setup screen.
     */
    public function showSetupPassword()
    {
        if (!Auth::check() || !session('must_set_password')) {
            return redirect()->route('login');
        }

        return view('auth.setup-password', ['user' => Auth::user()]);
    }

    /**
     * Store forced password and complete onboarding.
     */
    public function setupPassword(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        session()->forget('must_set_password');

        ActivityLog::create([
            'user_id' => $user->id,
            'event' => 'password_setup_complete',
            'description' => "User {$user->email} completed password onboarding.",
            'ip_address' => $request->ip(),
        ]);

        return $this->redirectBasedOnRole($user);
    }

    /**
     * Merge guest cart into user cart.
     */
    private function mergeGuestCart(User $user)
    {
        $sessionToken = session()->getId();
        $guestCart = Cart::where('session_token', $sessionToken)->first();

        if ($guestCart) {
            // Find or create authenticated user cart
            $userCart = Cart::firstOrCreate(['user_id' => $user->id]);

            foreach ($guestCart->items as $item) {
                // Check if user already has item in cart
                $existingItem = CartItem::where('cart_id', $userCart->id)
                    ->where('product_id', $item->product_id)
                    ->first();

                if ($existingItem) {
                    $existingItem->increment('quantity', $item->quantity);
                    $item->delete();
                } else {
                    $item->update(['cart_id' => $userCart->id]);
                }
            }

            // Delete guest cart
            $guestCart->delete();
        }
    }

    /**
     * Redirect logic based on user roles.
     */
    private function redirectBasedOnRole(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        // If checkout redirect is set
        if (session()->has('checkout_redirect')) {
            session()->forget('checkout_redirect');
            return redirect()->route('checkout');
        }

        return redirect()->intended(route('dashboard'));
    }
}
