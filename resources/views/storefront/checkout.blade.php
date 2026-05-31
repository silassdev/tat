<x-store-layout>
    <div class="mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-mono-tech text-xs uppercase tracking-wider text-slate-500 hover:text-emerald-400 transition">
            &larr; [ Return to Storefront ]
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <!-- Left Side: Delivery Details Form (7 Columns) -->
        <div class="lg:col-span-7 bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
            <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
            <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

            <div class="mb-6">
                <span class="inline-block px-3 py-1 font-mono-tech text-[9px] font-bold tracking-widest text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-lg uppercase select-none">
                    // GATEWAY_CHECKOUT_PROTOCOL
                </span>
                <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2 select-none">Secure Order Checkout</h2>
                <p class="text-xs text-slate-500 mt-1 select-none">Provide your delivery location and specify your preferred secure local payment node.</p>
            </div>

            <form method="POST" action="{{ route('checkout.place') }}" class="space-y-6">
                @csrf

                @auth
                    <!-- Logged in Customer Info -->
                    <div class="p-4 bg-slate-900 border border-slate-800 rounded-2xl flex items-center justify-between select-none">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold flex items-center justify-center text-sm shrink-0">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-white">{{ auth()->user()->name }}</h4>
                                <p class="text-[10px] text-slate-500 font-mono-tech">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <span class="text-[9px] font-mono-tech text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded uppercase">Verified</span>
                    </div>
                @else
                    <!-- Guest Checkout Form Fields -->
                    <div class="p-5 bg-slate-900 border border-slate-850 rounded-2xl space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-2.5 mb-2 select-none">
                            <h3 class="text-xs font-bold font-mono-tech text-slate-400 uppercase tracking-wider">// GUEST_BUYER_IDENTITY</h3>
                            <a href="{{ route('login') }}" class="text-[10px] font-mono-tech text-emerald-400 hover:text-emerald-300 underline uppercase tracking-wide">
                                Sign In / Register
                            </a>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="name" :value="__('Full Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required placeholder="e.g. John Doe" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email Address')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="e.g. john@example.com" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>
                        <span class="block text-[9px] text-slate-500 font-mono-tech uppercase select-none">
                            * An account claim prompt will be presented on the success page after payment.
                        </span>
                    </div>
                @endauth

                <!-- Phone number -->
                <div>
                    <x-input-label for="phone" :value="__('Contact Phone Number')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', auth()->check() ? auth()->user()->phone : '')" required placeholder="e.g. +2348012345678" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Delivery Address -->
                <div>
                    <x-input-label for="delivery_address" :value="__('Complete Delivery Location / Address')" />
                    <textarea id="delivery_address" name="delivery_address" rows="3" required
                              class="block mt-1 w-full bg-slate-950/80 border-slate-800 dark:border-slate-800/80 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 text-slate-200 text-xs shadow-sm">{{ old('delivery_address', auth()->check() ? auth()->user()->address : '') }}</textarea>
                    @auth
                        <span class="block text-[9px] font-mono-tech text-slate-500 mt-1 uppercase select-none">Saved from your profile. You can modify it for this order.</span>
                    @endauth
                    <x-input-error :messages="$errors->get('delivery_address')" class="mt-2" />
                </div>

                <!-- Notes -->
                <div>
                    <x-input-label for="notes" :value="__('Special Handling Instructions (Optional)')" />
                    <textarea id="notes" name="notes" rows="2"
                              class="block mt-1 w-full bg-slate-950/80 border-slate-800 dark:border-slate-800/80 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 text-slate-200 text-xs shadow-sm" placeholder="e.g. Leave package with security guard.">{{ old('notes') }}</textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>

                <!-- Payment Methods Checkboxes -->
                <div>
                    <label class="block text-xs font-mono-tech font-bold text-slate-400 uppercase tracking-wider mb-3 select-none">// SECURE_LOCAL_PAYMENT_NODE</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- Paystack option -->
                        <label class="relative flex items-start p-4 border border-slate-850 rounded-2xl bg-slate-950/50 hover:bg-slate-900 cursor-pointer group transition">
                            <div class="flex items-center h-5">
                                <input type="radio" name="payment_method" value="paystack" required checked
                                       class="h-4 w-4 text-emerald-500 border-slate-700 bg-slate-950 focus:ring-emerald-500 focus:ring-offset-slate-900" />
                            </div>
                            <div class="ml-3 text-xs leading-5">
                                <strong class="font-bold text-white group-hover:text-emerald-400 transition">Paystack Secure Checkout</strong>
                                <span class="block text-slate-500 font-mono-tech text-[10px] mt-0.5">Cards, Bank Transfer, USSD</span>
                            </div>
                        </label>

                        <!-- Flutterwave option -->
                        <label class="relative flex items-start p-4 border border-slate-850 rounded-2xl bg-slate-950/50 hover:bg-slate-900 cursor-pointer group transition">
                            <div class="flex items-center h-5">
                                <input type="radio" name="payment_method" value="flutterwave" required
                                       class="h-4 w-4 text-emerald-500 border-slate-700 bg-slate-950 focus:ring-emerald-500 focus:ring-offset-slate-900" />
                            </div>
                            <div class="ml-3 text-xs leading-5">
                                <strong class="font-bold text-white group-hover:text-emerald-400 transition">Flutterwave Payment</strong>
                                <span class="block text-slate-500 font-mono-tech text-[10px] mt-0.5">Cards, Mobile Money, Web3</span>
                            </div>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-800/80">
                    <button type="submit" 
                            class="w-full py-4 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold font-mono-tech text-xs uppercase tracking-wider rounded-xl shadow-lg transition">
                        [ Lock-In Stock & Pay ${{ number_format($total, 2) }} ]
                    </button>
                    <span class="block text-center text-[10px] font-mono-tech text-slate-500 mt-2 uppercase tracking-wide select-none">
                        Immediate Stock hold applied upon checkout request submission
                    </span>
                </div>
            </form>
        </div>

        <!-- Right Side: Order Summary (5 Columns) -->
        <div class="lg:col-span-5 bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative space-y-6">
            <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
            <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

            <h3 class="text-xs font-bold text-slate-300 font-mono-tech uppercase tracking-wider select-none">// ORDER_SUMMARY_MANIFEST</h3>

            <!-- Items Stack -->
            <div class="space-y-4 max-h-[250px] overflow-y-auto pr-2">
                @foreach ($items as $item)
                    <div class="flex items-center justify-between gap-4 py-2 border-b border-slate-900 select-none">
                        <div class="flex items-center gap-3">
                            <img src="{{ $item->product->primary_image }}" alt="{{ $item->product->name }}" class="w-10 h-10 object-cover rounded bg-slate-950 border border-slate-850" />
                            <div>
                                <h4 class="text-xs font-bold text-white truncate max-w-[150px]">{{ $item->product->name }}</h4>
                                <span class="text-[9px] font-mono-tech text-slate-500 uppercase">Qty: {{ $item->quantity }} // Color: {{ $item->product->color }}</span>
                            </div>
                        </div>
                        <span class="text-xs font-mono-tech font-bold text-slate-300">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Cost Breakdown -->
            <div class="space-y-2.5 pt-4 border-t border-slate-800/85 font-mono-tech text-xs select-none">
                <div class="flex justify-between">
                    <span class="text-slate-500">SUBTOTAL</span>
                    <span class="text-slate-300">${{ number_format($subtotal, 2) }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-slate-500">DELIVERY CHARGE</span>
                    <span class="text-slate-300">
                        @if ($deliveryFee == 0.00)
                            <span class="text-emerald-400">FREE</span>
                        @else
                            ${{ number_format($deliveryFee, 2) }}
                        @endif
                    </span>
                </div>

                @if ($discount > 0.00)
                    <div class="flex justify-between text-emerald-400">
                        <span>COUPON DISCOUNT ({{ $coupon->code }})</span>
                        <span>-${{ number_format($discount, 2) }}</span>
                    </div>
                @endif

                <div class="flex justify-between text-sm font-bold text-white pt-2.5 border-t border-slate-900">
                    <span>GRAND TOTAL</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</x-store-layout>
