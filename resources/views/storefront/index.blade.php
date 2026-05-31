<x-store-layout>
    <!-- 1. Technical Hero Section -->
    <div class="relative rounded-3xl overflow-hidden border border-slate-800 bg-slate-950/40 p-8 sm:p-12 mb-12 shadow-2xl relative">
        <div class="absolute inset-0 bg-tech-squares-dark opacity-10"></div>
        <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
        <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

        <div class="max-w-xl relative z-10 space-y-4">
            <span class="inline-block px-3 py-1 font-mono-tech text-[10px] font-bold tracking-widest text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-full uppercase">
                // SECURE_COMMERCE_PROTOCOL_INIT
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight">
                High-End Technical <span class="bg-gradient-to-r from-emerald-400 to-teal-300 bg-clip-text text-transparent">Gadgets & Systems</span>
            </h1>
            <p class="text-sm text-slate-400 leading-relaxed">
                Securely order high-performance laptops, custom small form-factor rigs, spatial audio units, and automated home smart devices with immediate stock lock-in.
            </p>
            <div class="pt-2 flex flex-wrap gap-4 font-mono-tech text-xs uppercase">
                <a href="#products-grid" class="px-5 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold rounded-xl shadow-lg transition">
                    Explore Catalog
                </a>
                <a href="{{ route('order.track.index') }}" class="px-5 py-3 bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 font-bold rounded-xl transition">
                    Track Shipment
                </a>
            </div>
        </div>

        <div class="absolute right-0 bottom-0 top-0 w-1/3 hidden lg:block opacity-40">
            <!-- Simulated HUD glowing design -->
            <div class="w-full h-full bg-tech-squares-dark bg-center opacity-30"></div>
        </div>
    </div>

    <!-- 2. Category Navigation Bar -->
    <div class="mb-8 font-mono-tech" id="products-grid">
        <h3 class="text-xs uppercase text-slate-400 block mb-4 tracking-widest select-none">// CATALOGUE_FILTER_NODES</h3>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('home') }}" 
               class="px-4 py-2 border rounded-xl text-xs font-semibold transition uppercase tracking-wider
                      {{ !request()->has('category') ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-slate-800 bg-slate-950/40 text-slate-400 hover:border-slate-700 hover:text-white' }}">
                [ All Systems ]
            </a>

            @foreach ($categories as $cat)
                <a href="{{ route('home', ['category' => $cat->slug]) }}" 
                   class="px-4 py-2 border rounded-xl text-xs font-semibold transition uppercase tracking-wider
                          {{ request()->query('category') === $cat->slug ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-slate-800 bg-slate-950/40 text-slate-400 hover:border-slate-700 hover:text-white' }}">
                    [ {{ $cat->name }} ]
                </a>
            @endforeach
        </div>
    </div>

    <!-- 3. Product Catalog Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($products as $product)
            <div class="relative bg-slate-950/40 border border-slate-800 hover:border-slate-700/80 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 flex flex-col justify-between group overflow-hidden">
                <!-- Glowing corner accent on hover -->
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 blur-[25px] opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none rounded-full"></div>
                
                <div>
                    <!-- Primary Tech Square Image Wrapper -->
                    <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-slate-950 border border-slate-800/80 mb-4 select-none shrink-0">
                        <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
                        
                        <!-- HUD style badge for Category / Stock -->
                        <div class="absolute top-2 left-2 px-2.5 py-0.5 rounded-lg border border-slate-800 bg-slate-950/80 backdrop-blur font-mono-tech text-[9px] uppercase tracking-wider text-slate-400">
                            {{ $product->category->name }}
                        </div>
                        
                        @if ($product->stock <= 0)
                            <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center font-mono-tech text-xs uppercase font-bold text-rose-500 tracking-wider">
                                [ OUT_OF_STOCK ]
                            </div>
                        @elseif ($product->stock <= 5)
                            <div class="absolute bottom-2 right-2 px-2.5 py-0.5 rounded-lg border border-rose-500/30 bg-rose-950/80 backdrop-blur font-mono-tech text-[9px] font-bold uppercase tracking-wider text-rose-400 animate-pulse">
                                Low Stock: {{ $product->stock }}
                            </div>
                        @else
                            <div class="absolute bottom-2 right-2 px-2.5 py-0.5 rounded-lg border border-emerald-500/20 bg-emerald-950/80 backdrop-blur font-mono-tech text-[9px] uppercase tracking-wider text-emerald-400">
                                In Stock
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-sm text-white group-hover:text-emerald-400 transition truncate">{{ $product->name }}</h3>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed line-clamp-3 min-h-[54px]">{{ $product->description }}</p>
                        
                        <!-- Metadata values -->
                        <div class="flex flex-wrap gap-2 pt-2 text-[10px] font-mono-tech text-slate-500">
                            <span class="px-2 py-0.5 rounded border border-slate-800 bg-slate-950/40">COL: {{ $product->color ?? 'N/A' }}</span>
                            <span class="px-2 py-0.5 rounded border border-slate-800 bg-slate-950/40">UNT: 1{{ $product->unit }}</span>
                        </div>
                    </div>
                </div>

                <!-- Price and Button Section -->
                <div class="pt-5 mt-5 border-t border-slate-800/80 flex items-center justify-between shrink-0">
                    <div>
                        <span class="text-[9px] font-mono-tech text-slate-500 block">UNIT_PRICE</span>
                        <span class="text-base font-black text-white font-mono-tech">${{ number_format($product->price, 2) }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('product.detail', ['slug' => $product->slug]) }}" 
                           class="p-2.5 border border-slate-800 hover:border-slate-700 hover:text-emerald-400 rounded-xl bg-slate-950/50 hover:bg-slate-900 transition flex items-center justify-center"
                           title="View details">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>

                        @if ($product->stock > 0)
                            <button @click="$dispatch('add-product-to-cart', { productId: {{ $product->id }}, quantity: 1 })"
                                    class="px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 text-xs font-bold font-mono-tech uppercase tracking-wider rounded-xl shadow-lg transition">
                                [ Add ]
                            </button>
                        @else
                            <button disabled 
                                    class="px-4 py-2.5 bg-slate-900 text-slate-600 text-xs font-bold font-mono-tech uppercase tracking-wider rounded-xl border border-slate-800 cursor-not-allowed">
                                [ Out ]
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 border border-slate-800 border-dashed rounded-3xl">
                <svg class="w-12 h-12 text-slate-700 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h4 class="font-bold text-white mb-1 font-mono-tech uppercase text-xs tracking-widest">// NO_PRODUCTS_FOUND</h4>
                <p class="text-xs text-slate-500">There are no systems configured matching this filter in the active directory.</p>
            </div>
        @endforelse
    </div>
</x-store-layout>
