<x-store-layout>
    <!-- Real-time HUD Telemetry Ticker -->
    <div class="mb-6 bg-slate-950/80 border border-emerald-500/20 rounded-2xl p-3 px-4 flex flex-wrap items-center justify-between gap-4 shadow-lg text-[10px] font-mono-tech tracking-wider text-slate-400 select-none">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-emerald-400 font-bold uppercase">SYSTEMS_ACTIVE // SECURE_NODE</span>
        </div>
        <div class="flex flex-wrap items-center gap-6">
            <div class="flex items-center gap-1.5">
                <span class="text-slate-500">DB_STATUS:</span>
                <span class="text-emerald-400">SYNCED</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="text-slate-500">STOCK_RESERVATION:</span>
                <span class="text-emerald-400">AUTO_LOCK_ON</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="text-slate-500">NODE_LATENCY:</span>
                <span class="text-slate-300" x-data="{ latency: '12ms' }" x-init="setInterval(() => { latency = Math.floor(Math.random() * 8 + 8) + 'ms' }, 3000)" x-text="latency">12ms</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="text-slate-500">SECURE_PAYMENTS:</span>
                <span class="text-emerald-400">ENABLED</span>
            </div>
        </div>
    </div>

    <!-- 1. Technical Hero Section -->
    <div class="relative rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-white/40 dark:bg-slate-950/40 p-8 sm:p-12 mb-12 shadow-2xl relative">
        <div class="absolute inset-0 bg-tech-squares-light dark:bg-tech-squares-dark opacity-10"></div>
        <div class="absolute top-1.5 left-1.5 text-slate-300 dark:text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
        <div class="absolute bottom-1.5 right-1.5 text-slate-300 dark:text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

        <div class="max-w-xl relative z-10 space-y-4">
            <span class="inline-block px-3 py-1 font-mono-tech text-[10px] font-bold tracking-widest text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-full uppercase">
                SECURE COMMERCE_PROTOCOL_INIT
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-slate-900 dark:text-white leading-tight">
                High-End Technical <span class="bg-gradient-to-r from-emerald-500 to-teal-400 dark:from-emerald-400 dark:to-teal-300 bg-clip-text text-transparent">Gadgets & Systems</span>
            </h1>
            <p class="text-sm text-slate-605 dark:text-slate-400 leading-relaxed">
                Securely order high-performance laptops, custom small form-factor rigs, spatial audio units, and automated home smart devices with immediate stock lock-in.
            </p>
            <div class="pt-2 flex flex-wrap gap-4 font-mono-tech text-xs uppercase">
                <a href="#products-grid" class="px-5 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold rounded-xl shadow-lg transition">
                    Explore Catalog
                </a>
                <a href="{{ route('order.track.index') }}" class="px-5 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-xl transition">
                    Track Shipment
                </a>
            </div>
        </div>

        <div class="absolute right-0 bottom-0 top-0 w-1/3 hidden lg:block opacity-40">
            <!-- Simulated HUD glowing design -->
            <div class="w-full h-full bg-tech-squares-light dark:bg-tech-squares-dark bg-center opacity-30"></div>
        </div>
    </div>

    <!-- 1.5. Interactive System Configurator Panel -->
    <div x-data="{ 
            selectedWorkload: 'workstation',
            recommendations: {
                workstation: {
                    name: 'CyberX Pro Blade Laptop',
                    price: 1899.99,
                    id: 1,
                    desc: 'Liquid cooled GPU system designed for large codebase compilations, deep learning, and advanced graphics workflows.',
                    spec: '32GB RAM // Core-i9 Extreme // RTX 5080 Node',
                    badge: 'AI & COMPUTE RIG'
                },
                mobile: {
                    name: 'Aether 6S Foldable Phone',
                    price: 999.99,
                    id: 3,
                    desc: 'Dual-folding AMOLED display with dynamic high refresh rate, integrated secure hardware enclave, and triple-lens matrix.',
                    spec: '12GB LPDDR5X // 512GB UFS 4.0 // 5G Node',
                    badge: 'SECURE COMMUNICATOR'
                },
                audio: {
                    name: 'Aura Pro Studio Headphones',
                    price: 349.99,
                    id: 5,
                    desc: 'Studio-grade spatial audio layout with real-time acoustic mapping, high-fidelity transducers, and premium build material.',
                    spec: '0.01% THD // Hybrid ANC // 40h Battery',
                    badge: 'SPATIAL MONITORING'
                },
                automation: {
                    name: 'Omni Hub Smart Speaker',
                    price: 149.99,
                    id: 6,
                    desc: 'Automate your environment. The Omni Hub integrates responsive local voice command arrays with multi-zone HSL lighting controls.',
                    spec: '360° Array // Zigbee 3.0 // Ambient Sync',
                    badge: 'ENVIRONMENT CONTROL'
                }
            }
         }"
         class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 mb-12 shadow-2xl relative">
        <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
        <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <!-- Selector Columns (5 Columns) -->
            <div class="lg:col-span-5 space-y-4">
                <div>
                    <span class="inline-block px-2.5 py-0.5 font-mono-tech text-[9px] font-bold tracking-widest text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-md uppercase select-none">
                        // SECURE_SYSTEM_CONFIGURATOR
                    </span>
                    <h2 class="text-xl font-bold text-white tracking-tight mt-1.5">Configure Target Workload</h2>
                    <p class="text-xs text-slate-400 mt-1">Select your primary execution workload, and our neural selector will suggest the optimum system node configuration.</p>
                </div>

                <div class="space-y-2.5 font-mono-tech">
                    <button @click="selectedWorkload = 'workstation'" 
                            :class="selectedWorkload === 'workstation' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-slate-800 bg-slate-950/40 text-slate-400 hover:border-slate-700'"
                            class="w-full flex items-center justify-between p-3.5 border rounded-xl text-[10px] font-semibold transition uppercase text-left group">
                        <span>[ 01 // Heavy Compute & AI ]</span>
                        <span class="opacity-0 group-hover:opacity-100 transition-opacity">&rarr;</span>
                    </button>

                    <button @click="selectedWorkload = 'mobile'" 
                            :class="selectedWorkload === 'mobile' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-slate-800 bg-slate-950/40 text-slate-400 hover:border-slate-700'"
                            class="w-full flex items-center justify-between p-3.5 border rounded-xl text-[10px] font-semibold transition uppercase text-left group">
                        <span>[ 02 // Secure Mobile Ops ]</span>
                        <span class="opacity-0 group-hover:opacity-100 transition-opacity">&rarr;</span>
                    </button>

                    <button @click="selectedWorkload = 'audio'" 
                            :class="selectedWorkload === 'audio' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-slate-800 bg-slate-950/40 text-slate-400 hover:border-slate-700'"
                            class="w-full flex items-center justify-between p-3.5 border rounded-xl text-[10px] font-semibold transition uppercase text-left group">
                        <span>[ 03 // Acoustic Monitoring ]</span>
                        <span class="opacity-0 group-hover:opacity-100 transition-opacity">&rarr;</span>
                    </button>

                    <button @click="selectedWorkload = 'automation'" 
                            :class="selectedWorkload === 'automation' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-slate-800 bg-slate-950/40 text-slate-400 hover:border-slate-700'"
                            class="w-full flex items-center justify-between p-3.5 border rounded-xl text-[10px] font-semibold transition uppercase text-left group">
                        <span>[ 04 // Smart Node Control ]</span>
                        <span class="opacity-0 group-hover:opacity-100 transition-opacity">&rarr;</span>
                    </button>
                </div>
            </div>

            <!-- Recommendation Display Column (7 Columns) -->
            <div class="lg:col-span-7 bg-slate-950/80 border border-slate-800/80 rounded-2xl p-6 relative overflow-hidden flex flex-col justify-between min-h-[300px]">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 opacity-40 pointer-events-none"></div>
                <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

                <div class="space-y-4 relative z-10">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-0.5 rounded-lg border border-slate-800 bg-slate-950 font-mono-tech text-[9px] uppercase tracking-wider text-slate-400"
                              x-text="'STATUS // RECOMMENDED_' + recommendations[selectedWorkload].badge">
                        </span>
                        <span class="text-[10px] font-mono-tech text-emerald-400 font-bold animate-pulse">MATCH_FOUND</span>
                    </div>

                    <div class="space-y-2">
                        <h3 class="text-xl font-bold text-white tracking-tight" x-text="recommendations[selectedWorkload].name">CyberX Pro Blade Laptop</h3>
                        <p class="text-xs text-slate-400 leading-relaxed font-sans" x-text="recommendations[selectedWorkload].desc"></p>
                    </div>

                    <div class="p-3 bg-slate-900/60 border border-slate-850 rounded-xl space-y-1">
                        <span class="text-[9px] font-mono-tech text-slate-500 uppercase block">HARDWARE_SPECIFICATIONS</span>
                        <span class="text-xs text-emerald-400 font-mono-tech block font-semibold" x-text="recommendations[selectedWorkload].spec"></span>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-900 mt-6 flex items-center justify-between relative z-10 shrink-0">
                    <div>
                        <span class="text-[9px] font-mono-tech text-slate-500 block">NODE_VALUE</span>
                        <span class="text-lg font-black text-white font-mono-tech" x-text="'$' + recommendations[selectedWorkload].price"></span>
                    </div>
                    
                    <button @click="$dispatch('add-product-to-cart', { productId: recommendations[selectedWorkload].id, quantity: 1 })"
                            class="px-5 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold font-mono-tech text-xs uppercase tracking-wider rounded-xl shadow-lg transition">
                        [ Reserve Config Node ]
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Category Navigation Bar -->
    <div class="mb-8 font-mono-tech" id="products-grid">
        <h3 class="text-xs uppercase text-slate-500 dark:text-slate-400 block mb-4 tracking-widest select-none">// CATALOGUE_FILTER_NODES</h3>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('home') }}" 
               class="px-4 py-2 border rounded-xl text-xs font-semibold transition uppercase tracking-wider
                      {{ !request()->has('category') ? 'border-emerald-500 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'border-slate-200 dark:border-slate-800 bg-white/40 dark:bg-slate-950/40 text-slate-500 dark:text-slate-400 hover:border-slate-350 dark:hover:border-slate-705 hover:text-slate-900 dark:hover:text-white' }}">
                [ All Systems ]
            </a>

            @foreach ($categories as $cat)
                <a href="{{ route('home', ['category' => $cat->slug]) }}" 
                   class="px-4 py-2 border rounded-xl text-xs font-semibold transition uppercase tracking-wider
                          {{ request()->query('category') === $cat->slug ? 'border-emerald-500 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'border-slate-200 dark:border-slate-800 bg-white/40 dark:bg-slate-950/40 text-slate-500 dark:text-slate-400 hover:border-slate-355 dark:hover:border-slate-705 hover:text-slate-900 dark:hover:text-white' }}">
                    [ {{ $cat->name }} ]
                </a>
            @endforeach
        </div>
    </div>

    <!-- 3. Product Catalog Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($products as $product)
            <div class="relative bg-white/40 dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700/80 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 flex flex-col justify-between group overflow-hidden">
                <!-- Glowing corner accent on hover -->
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 blur-[25px] opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none rounded-full"></div>
                
                <div>
                    <!-- Primary Tech Square Image Wrapper -->
                    <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-950 border border-slate-200 dark:border-slate-800/80 mb-4 select-none shrink-0">
                        <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
                        
                        <!-- HUD style badge for Category / Stock -->
                        <div class="absolute top-2 left-2 px-2.5 py-0.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-950/80 backdrop-blur font-mono-tech text-[9px] uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            {{ $product->category->name }}
                        </div>
                        
                        @if ($product->stock <= 0)
                            <div class="absolute inset-0 bg-white/80 dark:bg-slate-950/80 backdrop-blur-sm flex items-center justify-center font-mono-tech text-xs uppercase font-bold text-rose-600 dark:text-rose-500 tracking-wider">
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
                            <h3 class="font-bold text-sm text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition truncate">{{ $product->name }}</h3>
                        </div>
                        <p class="text-xs text-slate-650 dark:text-slate-400 leading-relaxed line-clamp-3 min-h-[54px]">{{ $product->description }}</p>
                        
                        <!-- Metadata values -->
                        <div class="flex flex-wrap gap-2 pt-2 text-[10px] font-mono-tech text-slate-400 dark:text-slate-500">
                            <span class="px-2 py-0.5 rounded border border-slate-200 dark:border-slate-800 bg-white/40 dark:bg-slate-950/40">COL: {{ $product->color ?? 'N/A' }}</span>
                            <span class="px-2 py-0.5 rounded border border-slate-200 dark:border-slate-800 bg-white/40 dark:bg-slate-950/40">UNT: 1{{ $product->unit }}</span>
                        </div>
                    </div>
                </div>

                <!-- Price and Button Section -->
                <div class="pt-5 mt-5 border-t border-slate-200 dark:border-slate-800/80 flex items-center justify-between shrink-0">
                    <div>
                        <span class="text-[9px] font-mono-tech text-slate-400 dark:text-slate-500 block">UNIT_PRICE</span>
                        <span class="text-base font-black text-slate-900 dark:text-white font-mono-tech">${{ number_format($product->price, 2) }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('product.detail', ['slug' => $product->slug]) }}" 
                           class="p-2.5 border border-slate-200 dark:border-slate-800 hover:border-slate-350 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-xl bg-white/50 dark:bg-slate-950/50 hover:bg-slate-50 dark:hover:bg-slate-900 transition flex items-center justify-center"
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
                                    class="px-4 py-2.5 bg-slate-100 dark:bg-slate-900 text-slate-450 dark:text-slate-600 text-xs font-bold font-mono-tech uppercase tracking-wider rounded-xl border border-slate-200 dark:border-slate-800 cursor-not-allowed">
                                [ Out ]
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 border border-slate-200 dark:border-slate-800 border-dashed rounded-3xl">
                <svg class="w-12 h-12 text-slate-300 dark:text-slate-700 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h4 class="font-bold text-slate-900 dark:text-white mb-1 font-mono-tech uppercase text-xs tracking-widest">// NO_PRODUCTS_FOUND</h4>
                <p class="text-xs text-slate-500 dark:text-slate-500">There are no systems configured matching this filter in the active directory.</p>
            </div>
        @endforelse
    </div>

    <!-- 4. Interactive Technical Specifications Protocol (FAQ Accordion) -->
    <div class="mt-16 bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative" x-data="{ openFaq: 1 }">
        <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
        <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

        <div class="mb-8">
            <span class="inline-block px-2.5 py-0.5 font-mono-tech text-[9px] font-bold tracking-widest text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-md uppercase select-none">
                // SYSTEM_SECURITY_FAQ
            </span>
            <h2 class="text-xl font-bold text-white tracking-tight mt-1.5">Secure Shopping Protocols</h2>
            <p class="text-xs text-slate-500 mt-1">Learn how our technical infrastructure safeguards your checkout and secures system nodes.</p>
        </div>

        <div class="space-y-4">
            <!-- FAQ Item 1 -->
            <div class="border border-slate-850 rounded-2xl bg-slate-950/50 overflow-hidden transition-all duration-300">
                <button @click="openFaq = (openFaq === 1 ? null : 1)" 
                        class="w-full flex items-center justify-between p-5 text-left font-mono-tech text-[10px] uppercase tracking-wider text-slate-350 hover:text-white transition">
                    <span>[ Protocol 01 // Stock Reservation Engine ]</span>
                    <svg class="w-4 h-4 transform transition-transform duration-200" :class="openFaq === 1 ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openFaq === 1" x-transition class="p-5 pt-0 text-xs text-slate-400 leading-relaxed border-t border-slate-900/60 font-sans">
                    Our platform executes an immediate database stock holding lock-in upon checkout request submission. This ensures that your system node is permanently reserved for your session while processing payments through Paystack or Flutterwave secure gateways, preventing stock racing.
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="border border-slate-850 rounded-2xl bg-slate-950/50 overflow-hidden transition-all duration-300">
                <button @click="openFaq = (openFaq === 2 ? null : 2)" 
                        class="w-full flex items-center justify-between p-5 text-left font-mono-tech text-[10px] uppercase tracking-wider text-slate-355 hover:text-white transition">
                    <span>[ Protocol 02 // Post-Payment Guest Account Claiming ]</span>
                    <svg class="w-4 h-4 transform transition-transform duration-200" :class="openFaq === 2 ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openFaq === 2" x-transition class="p-5 pt-0 text-xs text-slate-400 leading-relaxed border-t border-slate-900/60 font-sans">
                    Guests can complete their purchases instantly without entering passwords. Once payment is captured, they can securely claim the transaction node by verifying their email via a single-use OTP token and setting a custom password to track orders.
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="border border-slate-850 rounded-2xl bg-slate-950/50 overflow-hidden transition-all duration-300">
                <button @click="openFaq = (openFaq === 3 ? null : 3)" 
                        class="w-full flex items-center justify-between p-5 text-left font-mono-tech text-[10px] uppercase tracking-wider text-slate-355 hover:text-white transition">
                    <span>[ Protocol 03 // Persistent Profile Delivery Nodes ]</span>
                    <svg class="w-4 h-4 transform transition-transform duration-200" :class="openFaq === 3 ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openFaq === 3" x-transition class="p-5 pt-0 text-xs text-slate-400 leading-relaxed border-t border-slate-900/60 font-sans">
                    Whenever an order is successfully finalized, the shipping location is automatically saved to your profile credentials. On subsequent orders, the checkout form will auto-fill your delivery coordinates, which you can always view or update within your private dashboard profile manager.
                </div>
            </div>
        </div>
    </div>
</x-store-layout>
