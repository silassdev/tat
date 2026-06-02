<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// Storefront & Cart routes (accessible to everyone)
Route::get('/', [StorefrontController::class, 'index'])->name('home');
Route::get('/product/{slug}', [StorefrontController::class, 'showProduct'])->name('product.detail');
Route::get('/cart', [StorefrontController::class, 'getCart'])->name('cart.index');
Route::post('/cart/add', [StorefrontController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [StorefrontController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [StorefrontController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/contact', [StorefrontController::class, 'showContact'])->name('contact');
Route::post('/contact', [StorefrontController::class, 'submitContact']);

// OTP Onboarding / Unified Entry flow
Route::middleware('guest')->group(function () {
    Route::post('/otp/send', [OtpController::class, 'sendOtp'])->name('otp.send');
    Route::get('/otp/verify', [OtpController::class, 'showVerify'])->name('otp.verify');
    Route::post('/otp/verify', [OtpController::class, 'verifyOtp']);
    Route::post('/order/claim', [OtpController::class, 'claimOrder'])->name('order.claim');
});

// Forced Password Creation for OTP guest logins
Route::middleware('auth')->group(function () {
    Route::get('/auth/setup-password', [OtpController::class, 'showSetupPassword'])->name('password.setup');
    Route::post('/auth/setup-password', [OtpController::class, 'setupPassword']);
});

// Checkout Flow
Route::get('/checkout', [StorefrontController::class, 'checkout'])->name('checkout');
Route::post('/checkout/order', [StorefrontController::class, 'placeOrder'])->name('checkout.place');
Route::get('/order/success/{order_number}', [StorefrontController::class, 'orderSuccess'])->name('order.success');
Route::get('/order/track', [StorefrontController::class, 'trackOrderIndex'])->name('order.track.index');
Route::get('/order/track/{order_number}', [StorefrontController::class, 'trackOrder'])->name('order.track');

// Payment Gateways Initializer & Callbacks
Route::get('/payment/paystack/initialize/{order_id}', [StorefrontController::class, 'initializePaystack'])->name('payment.paystack.init');
Route::get('/payment/paystack/callback', [StorefrontController::class, 'paystackCallback'])->name('payment.paystack.callback');
Route::get('/payment/flutterwave/initialize/{order_id}', [StorefrontController::class, 'initializeFlutterwave'])->name('payment.flutterwave.init');
Route::get('/payment/flutterwave/callback', [StorefrontController::class, 'flutterwaveCallback'])->name('payment.flutterwave.callback');

// User Dashboard (Requires email OTP confirmation/auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile');
    Route::post('/dashboard/password', [DashboardController::class, 'updatePassword'])->name('dashboard.password');
    Route::post('/dashboard/tickets', [DashboardController::class, 'createTicket'])->name('dashboard.tickets');
    Route::post('/dashboard/tickets/{ticket}/reply', [DashboardController::class, 'replyTicket'])->name('dashboard.tickets.reply');
});

// Admin Dashboard & Backoffice (Requires auth & admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Product CRUD
    Route::get('/products', [AdminController::class, 'productsIndex'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'productsCreate'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'productsStore'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'productsEdit'])->name('admin.products.edit');
    Route::put('/products/{product}', [AdminController::class, 'productsUpdate'])->name('admin.products.update');
    Route::delete('/products/{product}', [AdminController::class, 'productsDestroy'])->name('admin.products.destroy');
    
    // Order Management
    Route::get('/orders', [AdminController::class, 'ordersIndex'])->name('admin.orders');
    Route::post('/orders/{order}/status', [AdminController::class, 'ordersUpdateStatus'])->name('admin.orders.status');
    
    // User / Customer management
    Route::get('/customers', [AdminController::class, 'customersIndex'])->name('admin.customers');
    Route::post('/customers/{user}/toggle', [AdminController::class, 'customersToggle'])->name('admin.customers.toggle');
    Route::put('/customers/{user}', [AdminController::class, 'customersUpdate'])->name('admin.customers.update');
    
    // Coupon Management
    Route::get('/coupons', [AdminController::class, 'couponsIndex'])->name('admin.coupons');
    Route::post('/coupons', [AdminController::class, 'couponsStore'])->name('admin.coupons.store');
    Route::delete('/coupons/{coupon}', [AdminController::class, 'couponsDestroy'])->name('admin.coupons.destroy');
    
    // Delivery Settings
    Route::get('/delivery', [AdminController::class, 'deliveryIndex'])->name('admin.delivery');
    Route::post('/delivery', [AdminController::class, 'deliveryStore'])->name('admin.delivery.store');
    
    // Chat / Support Ticket Admin System
    Route::get('/tickets', [AdminController::class, 'ticketsIndex'])->name('admin.tickets');
    Route::get('/tickets/{ticket}', [AdminController::class, 'ticketsShow'])->name('admin.tickets.show');
    Route::post('/tickets/{ticket}/reply', [AdminController::class, 'ticketsReply'])->name('admin.tickets.reply');
    
    // Admin Invitations
    Route::get('/invites', [AdminController::class, 'invitesIndex'])->name('admin.invites');
    Route::post('/invites', [AdminController::class, 'invitesStore'])->name('admin.invites.store');
    
    // Activity Logs
    Route::get('/logs', [AdminController::class, 'logsIndex'])->name('admin.logs');
});

require __DIR__.'/auth.php';
