<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\DeliveryFee;
use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed default accounts
        User::create([
            'name' => 'Store Admin',
            'email' => 'admin@shop.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'John Customer',
            'email' => 'customer@shop.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // 2. Seed Categories
        $categories = [
            ['name' => 'Computers & Laptops', 'slug' => 'computers-laptops'],
            ['name' => 'Smartphones & Gadgets', 'slug' => 'smartphones-gadgets'],
            ['name' => 'High-end Audio', 'slug' => 'high-end-audio'],
            ['name' => 'Smart Home', 'slug' => 'smart-home'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // 3. Seed Products
        $products = [
            [
                'category_slug' => 'computers-laptops',
                'name' => 'CyberX Pro Blade Laptop',
                'description' => 'Unleash incredible raw power with the CyberX Pro Blade. Boasting an ultra-fast processor, 32GB high-speed memory, and a custom liquid cooled GPU. Perfect for graphics programming, compiling large scale codebases, and rendering high fidelity models.',
                'price' => 1899.99,
                'cost' => 1450.00,
                'color' => 'Titanium Slate',
                'unit' => 'pcs',
                'stock' => 15,
            ],
            [
                'category_slug' => 'computers-laptops',
                'name' => 'NovaCore Ultra Compact PC',
                'description' => 'The ultimate custom small form-factor desktop computer. Packs a massive 12-core processor and a sleek liquid cooling rig in a beautiful transparent glassmorphic chassis.',
                'price' => 1249.99,
                'cost' => 980.00,
                'color' => 'Midnight Blue',
                'unit' => 'pcs',
                'stock' => 8,
            ],
            [
                'category_slug' => 'smartphones-gadgets',
                'name' => 'Aether 6S Foldable Phone',
                'description' => 'Transform how you interact. A gorgeous high-refresh rate folding AMOLED screen, premium glass build, triple lens dynamic back camera, and next-generation battery cell technology.',
                'price' => 999.99,
                'cost' => 750.00,
                'color' => 'Emerald Glow',
                'unit' => 'pcs',
                'stock' => 24,
            ],
            [
                'category_slug' => 'smartphones-gadgets',
                'name' => 'Nexus Watch Tech Pro',
                'description' => 'A sleek, tactical wearable designed to keep you updated. Features an active display, real-time health diagnostics, integrated dual GPS, and a beautiful tactile digital dial.',
                'price' => 299.99,
                'cost' => 180.00,
                'color' => 'Tactical Slate',
                'unit' => 'pcs',
                'stock' => 45,
            ],
            [
                'category_slug' => 'high-end-audio',
                'name' => 'Aura Pro Studio Headphones',
                'description' => 'Experience studio-grade acoustic performance. Zero distortion hybrid active noise cancellation, custom spatial acoustic mapping, and premium lambskin leather ear cups.',
                'price' => 349.99,
                'cost' => 210.00,
                'color' => 'Matte Black',
                'unit' => 'pcs',
                'stock' => 30,
            ],
            [
                'category_slug' => 'smart-home',
                'name' => 'Omni Hub Smart Speaker',
                'description' => 'Control your environment. The Omni Hub features responsive voice control, 360-degree premium surround speaker system, and dynamic ambient HSL lighting that responds to music.',
                'price' => 149.99,
                'cost' => 95.00,
                'color' => 'Frost White',
                'unit' => 'pcs',
                'stock' => 60,
            ],
        ];

        foreach ($products as $prod) {
            $cat = Category::where('slug', $prod['category_slug'])->first();
            unset($prod['category_slug']);
            $prod['category_id'] = $cat->id;
            $prod['slug'] = Str::slug($prod['name']);
            $prod['status'] = 'active';

            Product::create($prod);
        }

        // 4. Seed Delivery Fees
        DeliveryFee::create([
            'type' => 'flat',
            'fee' => 15.00,
            'free_threshold' => 150.00,
        ]);

        // 5. Seed Coupons
        Coupon::create([
            'code' => 'TECHLAUNCH10',
            'type' => 'percentage',
            'value' => 10.00,
            'expiry_date' => now()->addDays(30),
            'usage_limit' => 100,
            'min_order_value' => 50.00,
        ]);

        Coupon::create([
            'code' => 'WELCOME25',
            'type' => 'fixed',
            'value' => 25.00,
            'expiry_date' => now()->addDays(60),
            'usage_limit' => 50,
            'min_order_value' => 100.00,
        ]);
    }
}
