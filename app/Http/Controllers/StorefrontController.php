<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\DeliveryFee;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StorefrontController extends Controller
{
    /**
     * Display storefront homepage.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        
        $query = Product::where('status', 'active')->with('images');
        
        if ($request->has('category') && $request->category !== '') {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        $products = $query->latest()->get();

        return view('storefront.index', compact('categories', 'products'));
    }

    /**
     * Display single product details.
     */
    public function showProduct($slug)
    {
        $product = Product::where('slug', $slug)->where('status', 'active')->with('images')->firstOrFail();
        return view('storefront.detail', compact('product'));
    }

    /**
     * Get or create active cart for guest/user.
     */
    private function resolveCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }
        
        // Guest cart based on session
        $sessionToken = session()->getId();
        return Cart::firstOrCreate(['session_token' => $sessionToken]);
    }

    /**
     * Get current cart data in JSON for Alpine.js dynamic widget.
     */
    public function getCart()
    {
        $cart = $this->resolveCart();
        $items = CartItem::where('cart_id', $cart->id)->with('product.images')->get();

        $subtotal = 0;
        $formattedItems = [];

        foreach ($items as $item) {
            $subtotal += $item->product->price * $item->quantity;
            $formattedItems[] = [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'slug' => $item->product->slug,
                'price' => (float)$item->product->price,
                'quantity' => $item->quantity,
                'stock' => $item->product->stock,
                'image' => $item->product->primary_image,
                'subtotal' => (float)($item->product->price * $item->quantity),
            ];
        }

        return response()->json([
            'items' => $formattedItems,
            'count' => count($formattedItems),
            'total_quantity' => $items->sum('quantity'),
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * Add product to cart.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->resolveCart();
        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json(['error' => 'Insufficient stock available.'], 422);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->quantity;
            if ($product->stock < $newQty) {
                return response()->json(['error' => 'Cannot add more. Exceeds available stock.'], 422);
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return $this->getCart();
    }

    /**
     * Update cart item quantity.
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'item_id' => ['required', 'exists:cart_items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cartItem = CartItem::findOrFail($request->item_id);
        $product = Product::findOrFail($cartItem->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json(['error' => 'Insufficient stock available.'], 422);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return $this->getCart();
    }

    /**
     * Remove item from cart.
     */
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'item_id' => ['required', 'exists:cart_items,id'],
        ]);

        $cartItem = CartItem::findOrFail($request->item_id);
        $cartItem->delete();

        return $this->getCart();
    }

    /**
     * Display checkout screen.
     */
    public function checkout()
    {
        $cart = $this->resolveCart();
        $items = CartItem::where('cart_id', $cart->id)->get();

        if ($items->isEmpty()) {
            return redirect()->route('home')->withErrors(['cart' => 'Your shopping cart is empty.']);
        }

        // Calculate delivery fees
        $deliverySettings = DeliveryFee::first() ?? new DeliveryFee(['fee' => 15.00, 'free_threshold' => 150.00]);
        $subtotal = $cart->total;
        $deliveryFee = ($subtotal >= $deliverySettings->free_threshold) ? 0.00 : $deliverySettings->fee;
        
        $coupon = null;
        $discount = 0.00;
        
        if (session()->has('coupon_code')) {
            $coupon = Coupon::where('code', session('coupon_code'))->first();
            if ($coupon && $coupon->isValidForValue($subtotal)) {
                $discount = $coupon->calculateDiscount($subtotal);
            } else {
                session()->forget('coupon_code');
            }
        }

        $total = max(0, $subtotal + $deliveryFee - $discount);

        return view('storefront.checkout', compact('items', 'subtotal', 'deliveryFee', 'discount', 'total', 'coupon'));
    }

    /**
     * Complete checkout and place the order with stock reservation.
     */
    public function placeOrder(Request $request)
    {
        $rules = [
            'phone' => ['required', 'string', 'max:20'],
            'delivery_address' => ['required', 'string'],
            'payment_method' => ['required', 'string', 'in:paystack,flutterwave'],
            'notes' => ['nullable', 'string'],
        ];

        if (!Auth::check()) {
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['email'] = ['required', 'string', 'email', 'max:255'];
        }

        $request->validate($rules);

        $user = Auth::user();
        $cart = $this->resolveCart();
        $cartItems = CartItem::where('cart_id', $cart->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home');
        }

        if ($user) {
            $user->update([
                'address' => $request->delivery_address,
                'phone' => $request->phone,
            ]);
        } else {
            session([
                'guest_name' => $request->name,
                'guest_email' => $request->email,
            ]);
        }

        // 1. Immediate Stock Reservation and validation
        DB::beginTransaction();
        try {
            foreach ($cartItems as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if ($product->stock < $item->quantity) {
                    DB::rollBack();
                    return back()->withErrors(['stock' => "Stock issue: '{$product->name}' only has {$product->stock} items left. Please adjust your cart quantity."]);
                }
                
                // Reserve stock immediately
                $product->decrement('stock', $item->quantity);
            }

            // Calculate costs
            $deliverySettings = DeliveryFee::first() ?? new DeliveryFee(['fee' => 15.00, 'free_threshold' => 150.00]);
            $subtotal = $cart->total;
            $deliveryFee = ($subtotal >= $deliverySettings->free_threshold) ? 0.00 : $deliverySettings->fee;
            
            $coupon = null;
            $discount = 0.00;
            
            if (session()->has('coupon_code')) {
                $coupon = Coupon::where('code', session('coupon_code'))->first();
                if ($coupon && $coupon->isValidForValue($subtotal)) {
                    $discount = $coupon->calculateDiscount($subtotal);
                    $coupon->increment('used_count');
                }
            }

            $total = max(0, $subtotal + $deliveryFee - $discount);

            // Create Order
            $order = Order::create([
                'user_id' => $user ? $user->id : null,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total_amount' => $total,
                'coupon_id' => $coupon ? $coupon->id : null,
                'status' => 'pending',
                'payment_status' => 'pending',
                'delivery_address' => $request->delivery_address,
                'phone' => $request->phone,
                'email' => $user ? $user->email : $request->email,
                'notes' => $request->notes,
            ]);

            // Save Order Items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // Clear Cart
            CartItem::where('cart_id', $cart->id)->delete();
            session()->forget('coupon_code');

            DB::commit();

            ActivityLog::create([
                'user_id' => $user ? $user->id : null,
                'event' => 'order_placed',
                'description' => "Order {$order->order_number} successfully placed. Total: {$order->total_amount}",
                'ip_address' => $request->ip(),
            ]);

            // Redirect to appropriate Payment Gateway Initializer
            if ($request->payment_method === 'paystack') {
                return redirect()->route('payment.paystack.init', ['order_id' => $order->id]);
            } else {
                return redirect()->route('payment.flutterwave.init', ['order_id' => $order->id]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['checkout' => 'Checkout failed. Please try again. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Initialize Paystack Payment.
     */
    public function initializePaystack($order_id)
    {
        $order = Order::findOrFail($order_id);
        return view('payment.gateway', [
            'order' => $order,
            'gateway' => 'Paystack',
            'callbackUrl' => route('payment.paystack.callback', ['reference' => 'PAY-' . strtoupper(Str::random(12)), 'order_id' => $order->id])
        ]);
    }

    /**
     * Paystack Callback processing.
     */
    public function paystackCallback(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $status = $request->status ?? 'success';

        if ($status === 'success') {
            DB::transaction(function () use ($order, $request) {
                $order->update([
                    'status' => 'paid',
                    'payment_status' => 'paid'
                ]);

                Payment::create([
                    'order_id' => $order->id,
                    'reference' => $request->reference ?? 'REF-' . Str::random(10),
                    'amount' => $order->total_amount,
                    'payment_method' => 'card',
                    'gateway' => 'paystack',
                    'status' => 'completed',
                    'paid_at' => now()
                ]);
            });

            ActivityLog::create([
                'user_id' => $order->user_id,
                'event' => 'payment_success_paystack',
                'description' => "Successful Paystack payment captured for Order: {$order->order_number}",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('order.success', ['order_number' => $order->order_number]);
        } else {
            // Payment failed
            DB::transaction(function () use ($order) {
                $order->update([
                    'status' => 'failed_payment',
                    'payment_status' => 'failed'
                ]);

                // Return stock back
                foreach ($order->items as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            });

            ActivityLog::create([
                'user_id' => $order->user_id,
                'event' => 'payment_failed_paystack',
                'description' => "Failed Paystack payment for Order: {$order->order_number}",
                'ip_address' => $request->ip(),
            ]);

            // Notify admin via standard Log/Activity hook (email logs simulated or triggered)
            return redirect()->route('dashboard')->withErrors(['payment' => 'Your Paystack payment failed. The order has been cancelled and stock returned.']);
        }
    }

    /**
     * Initialize Flutterwave Payment.
     */
    public function initializeFlutterwave($order_id)
    {
        $order = Order::findOrFail($order_id);
        return view('payment.gateway', [
            'order' => $order,
            'gateway' => 'Flutterwave',
            'callbackUrl' => route('payment.flutterwave.callback', ['reference' => 'FLW-' . strtoupper(Str::random(12)), 'order_id' => $order->id])
        ]);
    }

    /**
     * Flutterwave Callback processing.
     */
    public function flutterwaveCallback(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $status = $request->status ?? 'success';

        if ($status === 'success') {
            DB::transaction(function () use ($order, $request) {
                $order->update([
                    'status' => 'paid',
                    'payment_status' => 'paid'
                ]);

                Payment::create([
                    'order_id' => $order->id,
                    'reference' => $request->reference ?? 'REF-' . Str::random(10),
                    'amount' => $order->total_amount,
                    'payment_method' => 'card',
                    'gateway' => 'flutterwave',
                    'status' => 'completed',
                    'paid_at' => now()
                ]);
            });

            ActivityLog::create([
                'user_id' => $order->user_id,
                'event' => 'payment_success_flutterwave',
                'description' => "Successful Flutterwave payment captured for Order: {$order->order_number}",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('order.success', ['order_number' => $order->order_number]);
        } else {
            // Payment failed
            DB::transaction(function () use ($order) {
                $order->update([
                    'status' => 'failed_payment',
                    'payment_status' => 'failed'
                ]);

                // Return stock back
                foreach ($order->items as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            });

            ActivityLog::create([
                'user_id' => $order->user_id,
                'event' => 'payment_failed_flutterwave',
                'description' => "Failed Flutterwave payment for Order: {$order->order_number}",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('dashboard')->withErrors(['payment' => 'Your Flutterwave payment failed. The order has been cancelled and stock returned.']);
        }
    }

    /**
     * Success page.
     */
    public function orderSuccess($order_number)
    {
        $order = Order::where('order_number', $order_number)->with('items.product')->firstOrFail();
        return view('storefront.success', compact('order'));
    }

    /**
     * Track Order Form.
     */
    public function trackOrderIndex()
    {
        return view('storefront.track');
    }

    /**
     * Perform tracking lookups.
     */
    public function trackOrder($order_number)
    {
        $order = Order::where('order_number', $order_number)->with('items.product')->first();
        if (!$order) {
            return redirect()->route('order.track.index')->withErrors(['order_number' => 'The order reference code was not found.']);
        }

        return view('storefront.track', compact('order'));
    }

    /**
     * Display Contact view.
     */
    public function showContact()
    {
        return view('storefront.contact');
    }

    /**
     * Handle Contact form submission.
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $adminEmail = 'admin@shop.com';

        try {
            // Send email using FQCN Mail facade
            \Illuminate\Support\Facades\Mail::raw(
                "A new contact message has been received from your store:\n\n" .
                "Name: {$request->name}\n" .
                "Email: {$request->email}\n" .
                "Subject: {$request->subject}\n\n" .
                "Message:\n{$request->message}",
                function ($message) use ($request, $adminEmail) {
                    $message->to($adminEmail)
                        ->subject("Secure Storefront Contact: " . $request->subject)
                        ->replyTo($request->email);
                }
            );

            ActivityLog::create([
                'user_id' => auth()->id(),
                'event' => 'contact_message_sent',
                'description' => "Contact message sent by {$request->email} subject: {$request->subject}",
                'ip_address' => $request->ip(),
            ]);

            return back()->with('status', 'Your contact message has been sent successfully. Our admin node has been notified.');
        } catch (\Exception $e) {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'event' => 'contact_message_failed',
                'description' => "Failed to send contact message from {$request->email}. Error: " . $e->getMessage(),
                'ip_address' => $request->ip(),
            ]);

            return back()->withInput()->withErrors(['contact' => 'Failed to transmit contact details: ' . $e->getMessage()]);
        }
    }
}
