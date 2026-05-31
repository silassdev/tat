<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 2. Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('cost', 12, 2)->default(0);
            $table->string('color')->nullable();
            $table->string('unit')->default('pcs'); // pcs, unit, box
            $table->integer('stock')->default(0);
            $table->string('status')->default('active'); // active, inactive
            $table->timestamps();
        });

        // 3. Product Images
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->timestamps();
        });

        // 4. Carts
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_token')->nullable()->index();
            $table->timestamps();
        });

        // 5. Cart Items
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });

        // 6. Coupons
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('type')->default('percentage'); // percentage, fixed
            $table->decimal('value', 12, 2);
            $table->date('expiry_date');
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->decimal('min_order_value', 12, 2)->nullable();
            $table->timestamps();
        });

        // 7. Orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique();
            $table->decimal('total_amount', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('delivery_fee', 12, 2)->default(0);
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('pending'); // pending, paid, processing, shipped, delivered, cancelled, failed_payment
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->text('delivery_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 8. Order Items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 12, 2);
            $table->timestamps();
        });

        // 9. Payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('reference')->unique();
            $table->decimal('amount', 12, 2);
            $table->string('payment_method')->nullable(); // card, bank_transfer, etc.
            $table->string('gateway')->nullable(); // paystack, flutterwave
            $table->string('status')->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        // 10. Delivery Fees
        Schema::create('delivery_fees', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('flat'); // flat, location
            $table->string('location')->nullable();
            $table->decimal('fee', 12, 2)->default(0);
            $table->decimal('free_threshold', 12, 2)->nullable();
            $table->timestamps();
        });

        // 11. Support Tickets
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('subject');
            $table->string('status')->default('open'); // open, pending, resolved
            $table->timestamps();
        });

        // 12. Support Ticket Messages
        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // sender
            $table->text('message');
            $table->timestamps();
        });

        // 13. Admin Invitations
        Schema::create('admin_invites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role')->default('admin');
            $table->string('token')->unique();
            $table->timestamp('expires_at');
            $table->timestamps();
        });

        // 14. Email OTPs
        Schema::create('email_otps', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('otp');
            $table->timestamp('expires_at');
            $table->boolean('verified')->default(false);
            $table->timestamps();
        });

        // 15. Activity Logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event');
            $table->text('description')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('email_otps');
        Schema::dropIfExists('admin_invites');
        Schema::dropIfExists('ticket_messages');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('delivery_fees');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
