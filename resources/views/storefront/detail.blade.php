<x-store-layout>
    <!-- Floating Back Node -->
    <div class="mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-mono-tech text-xs uppercase tracking-wider text-slate-500 hover:text-emerald-400 transition">
            &larr; [ Return to Storefront ]
        </a>
    </div>

    <!-- Product Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <!-- Left Side: Images Display (7 Columns) -->
        <div class="lg:col-span-7 space-y-4">
            <div class="relative w-full aspect-video rounded-3xl overflow-hidden bg-slate-950 border border-slate-800 shadow-2xl relative select-none">
                <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
                <div class="absolute top-2 left-2 px-3 py-1 rounded-lg border border-slate-850 bg-slate-950/80 backdrop-blur font-mono-tech text-[9px] uppercase tracking-wider text-slate-400">
                    Category // {{ $product->category->name }}
                </div>
            </div>

            <!-- Alternative images slots (simulated grid) -->
            <div class="grid grid-cols-3 gap-4 select-none">
                <div class="aspect-video rounded-xl overflow-hidden bg-slate-950 border border-emerald-500/20 p-0.5 relative group cursor-pointer">
                    <img src="{{ $product->primary_image }}" alt="Thumbnail 1" class="w-full h-full object-cover rounded-lg group-hover:scale-105 transition" />
                </div>
                <div class="aspect-video rounded-xl overflow-hidden bg-slate-950 border border-slate-850 hover:border-slate-700/60 p-0.5 relative group cursor-pointer opacity-60 hover:opacity-100 transition">
                    <img src="{{ $product->primary_image }}" alt="Thumbnail 2" class="w-full h-full object-cover rounded-lg" />
                </div>
                <div class="aspect-video rounded-xl overflow-hidden bg-slate-950 border border-slate-850 hover:border-slate-700/60 p-0.5 relative group cursor-pointer opacity-60 hover:opacity-100 transition">
                    <img src="{{ $product->primary_image }}" alt="Thumbnail 3" class="w-full h-full object-cover rounded-lg" />
                </div>
            </div>
        </div>

        <!-- Right Side: Details Control Panel (5 Columns) -->
        <div class="lg:col-span-5 relative bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl flex flex-col justify-between"
             x-data="{ qty: 1 }">
            <!-- HUD grids crosshair decoration -->
            <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
            <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

            <div class="space-y-6">
                <!-- Brand Badge -->
                <span class="inline-block px-3 py-1 font-mono-tech text-[9px] font-bold tracking-widest text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-lg uppercase select-none">
                    // SKU_SYS_ID: {{ sprintf('%06d', $product->id) }}
                </span>

                <!-- Title & Meta -->
                <div class="space-y-1.5">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">{{ $product->name }}</h1>
                    
                    <div class="flex items-center gap-4 text-xs font-mono-tech pt-2">
                        @if ($product->stock <= 0)
                            <span class="text-rose-500 font-bold">[ STOCK_OUT ]</span>
                        @else
                            <span class="text-emerald-400 font-bold">[ IN_STOCK ]</span>
                            <span class="text-slate-500" x-text="'QTY_AVAILABLE: ' + {{ $product->stock }}">QTY_AVAILABLE: 0</span>
                        @endif
                    </div>
                </div>

                <!-- Price Tag -->
                <div class="py-4 border-y border-slate-800/80 flex items-center justify-between font-mono-tech">
                    <div>
                        <span class="text-[9px] text-slate-500 block">STANDARD_PRICE_USD</span>
                        <span class="text-2xl font-black text-white">${{ number_format($product->price, 2) }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] text-slate-500 block">PACKAGING_UNIT</span>
                        <span class="text-xs font-bold text-slate-300 uppercase">1 x {{ $product->unit }}</span>
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <h3 class="text-xs font-bold text-slate-300 font-mono-tech uppercase tracking-wider select-none">// PRODUCT_SPECIFICATIONS</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">{{ $product->description }}</p>
                </div>

                <!-- Technical parameters -->
                <table class="w-full text-xs font-mono-tech border border-slate-800 bg-slate-950/30 rounded-xl overflow-hidden select-none">
                    <tr class="border-b border-slate-800">
                        <td class="px-4 py-2.5 text-slate-500 uppercase">Color Index</td>
                        <td class="px-4 py-2.5 text-slate-300">{{ $product->color ?? 'Standard Spectrum' }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2.5 text-slate-500 uppercase">Shipping Metric</td>
                        <td class="px-4 py-2.5 text-slate-300">Local Symlink Linked</td>
                    </tr>
                </table>
            </div>

            <!-- Action panel -->
            <div class="pt-8 border-t border-slate-800/80 mt-8 space-y-4">
                @if ($product->stock > 0)
                    <!-- Selector -->
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono-tech text-slate-400 uppercase select-none">// QUANTITY_SELECTION</span>
                        <div class="flex items-center gap-3">
                            <button @click="if(qty > 1) qty--" class="w-8 h-8 border border-slate-800 hover:border-emerald-500/30 rounded-lg bg-slate-900 text-slate-400 hover:text-white transition flex items-center justify-center font-bold font-mono-tech">-</button>
                            <span class="text-sm font-mono-tech font-bold text-white w-6 text-center" x-text="qty">1</span>
                            <button @click="if(qty < {{ $product->stock }}) qty++" class="w-8 h-8 border border-slate-800 hover:border-emerald-500/30 rounded-lg bg-slate-900 text-slate-400 hover:text-white transition flex items-center justify-center font-bold font-mono-tech">+</button>
                        </div>
                    </div>

                    <button @click="$dispatch('add-product-to-cart', { productId: {{ $product->id }}, quantity: qty })"
                            class="w-full py-4 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold font-mono-tech text-xs uppercase tracking-wider rounded-xl shadow-lg transition select-none">
                        [ Secure Lock-In Cart ]
                    </button>
                @else
                    <button disabled 
                            class="w-full py-4 bg-slate-900 text-slate-600 font-bold font-mono-tech text-xs uppercase tracking-wider rounded-xl border border-slate-800 cursor-not-allowed select-none">
                        [ Out of Stock System ]
                    </button>
                @endif
            </div>
        </div>
    </div>
</x-store-layout>
