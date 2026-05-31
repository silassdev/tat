<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shop') }} - Storefront</title>

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Inline script to prevent theme flickering -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .font-mono-tech {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 antialiased min-h-screen flex flex-col relative overflow-x-hidden"
      x-data="cartManager()"
      x-init="initCart()">

    <!-- Technical connected mesh background -->
    <div class="absolute inset-x-0 top-0 h-[500px] pointer-events-none z-0 overflow-hidden">
        <div class="w-full h-full bg-tech-squares-light dark:bg-tech-squares-dark opacity-30 dark:opacity-20"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[700px] h-[250px] bg-emerald-500/10 blur-[100px] rounded-full"></div>
    </div>

    <!-- 1. Header Bar -->
    <header class="sticky top-0 z-40 bg-white/70 dark:bg-slate-950/70 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <div class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 font-black text-white shadow-lg shadow-emerald-500/20 transition-all duration-300 group-hover:scale-105">
                    S
                    <div class="absolute top-0.5 left-0.5 w-1 h-1 bg-white/40 rounded-full"></div>
                </div>
                <div>
                    <span class="font-bold text-sm tracking-widest text-slate-900 dark:text-white uppercase block">SHOP.IO</span>
                    <span class="text-[9px] font-mono-tech text-emerald-600 dark:text-emerald-400 block tracking-widest">// SECURE_NODE</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex items-center gap-6 font-mono-tech text-xs uppercase tracking-wider">
                <a href="{{ route('home') }}" class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition">Storefront</a>
                <a href="{{ route('order.track.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition">Track Order</a>
                <a href="#" class="text-slate-400 dark:text-slate-500 cursor-not-allowed">Support</a>
            </nav>

            <!-- Right Controls -->
            <div class="flex items-center gap-4">
                <!-- Theme Toggle Button -->
                <div x-data="{ dark: document.documentElement.classList.contains('dark') }">
                    <button 
                        @click="
                            dark = !dark; 
                            if(dark) { 
                                document.documentElement.classList.add('dark'); 
                                localStorage.setItem('theme', 'dark'); 
                            } else { 
                                document.documentElement.classList.remove('dark'); 
                                localStorage.setItem('theme', 'light'); 
                            }
                        "
                        class="p-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-950/50 hover:bg-slate-50 dark:hover:bg-slate-900 text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center justify-center group"
                        aria-label="Toggle Theme"
                    >
                        <!-- Sun Icon (visible in Dark mode) -->
                        <svg x-show="dark" class="w-5 h-5 transition-transform duration-300 group-hover:rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                        <!-- Moon Icon (visible in Light mode) -->
                        <svg x-show="!dark" class="w-5 h-5 transition-transform duration-300 group-hover:-rotate-12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </div>

                <!-- Shopping Cart Toggle Button -->
                <button @click="cartOpen = true" 
                        class="relative p-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-950/50 hover:bg-slate-50 dark:hover:bg-slate-900 transition flex items-center gap-2 group">
                    <svg class="w-5 h-5 text-slate-500 dark:text-slate-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="text-xs font-mono-tech font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded-full shrink-0" 
                          x-text="cart.total_quantity">0</span>
                </button>

                <!-- Auth Button -->
                @auth
                    <a href="{{ route('dashboard') }}" 
                       class="px-4 py-2 bg-white/50 dark:bg-slate-950/50 hover:bg-slate-50 dark:hover:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-emerald-500/40 rounded-xl text-xs font-mono-tech uppercase font-bold tracking-wider text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 rounded-xl text-xs font-mono-tech uppercase font-bold tracking-wider transition shadow-lg shadow-emerald-500/10">
                        [ Login / Sign Up ]
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 relative z-10">
        <!-- Error Alerts -->
        @if ($errors->any())
            <div class="mb-8 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl text-xs font-mono-tech relative overflow-hidden select-none">
                <div class="absolute top-1 left-1 text-rose-500/30">+</div>
                <strong class="block uppercase mb-1">// SEC_ERROR: SYSTEM_VALIDATION_FAILED</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-xs font-mono-tech relative overflow-hidden select-none">
                <div class="absolute top-1 left-1 text-emerald-500/30">+</div>
                <strong>// NODE_MESSAGE: {{ strtoupper(session('status')) }}</strong>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white/80 dark:bg-slate-950/80 border-t border-slate-200 dark:border-slate-800/80 py-8 relative z-10 text-center font-mono-tech text-xs text-slate-400 dark:text-slate-600">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} SHOP.IO. All operations monitored securely under Node.js logs.</p>
        </div>
    </footer>

    <!-- 2. Interactive slide-over Cart Drawer -->
    <div x-show="cartOpen" 
         class="fixed inset-0 z-50 overflow-hidden" 
         style="display: none;">
        
        <!-- Backdrop blur -->
        <div x-show="cartOpen"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="cartOpen = false" 
             class="absolute inset-0 bg-slate-950/50 dark:bg-slate-950/70 backdrop-blur-sm transition-opacity"></div>

        <div class="absolute inset-y-0 right-0 max-w-full flex pl-10">
            <div x-show="cartOpen"
                 x-transition:enter="transform transition ease-out duration-300 sm:duration-400"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-md bg-white dark:bg-slate-950 border-l border-slate-200 dark:border-slate-800 flex flex-col shadow-2xl relative">
                
                <!-- Corner Grid Crosshairs -->
                <div class="absolute top-1.5 left-1.5 text-slate-300 dark:text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
                <div class="absolute bottom-1.5 right-1.5 text-slate-300 dark:text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

                <!-- Header -->
                <div class="h-16 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-6 shrink-0">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-mono-tech">// SHOPPING_CART</h2>
                        <span class="text-[10px] text-slate-450 dark:text-slate-500 font-mono-tech" x-text="cart.total_quantity + ' items listed'">0 items listed</span>
                    </div>
                    <button @click="cartOpen = false" class="p-2 border border-slate-200 dark:border-slate-800 hover:border-rose-500/40 rounded-xl bg-slate-50 dark:bg-slate-900 text-slate-450 dark:text-slate-400 hover:text-rose-400 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Items list -->
                <div class="flex-grow overflow-y-auto p-6 space-y-4">
                    <template x-for="item in cart.items" :key="item.id">
                        <div class="flex items-center gap-4 p-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl relative group">
                            <img :src="item.image" :alt="item.name" class="w-14 h-14 object-cover rounded-lg bg-slate-100 dark:bg-slate-950 border border-slate-200 dark:border-slate-800" />
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate" x-text="item.name">Product Name</h4>
                                <p class="text-[10px] text-emerald-600 dark:text-emerald-400 font-mono-tech mt-0.5" x-text="'$' + item.price + ' / unit'"></p>
                                
                                <!-- Quantity controls -->
                                <div class="flex items-center gap-2 mt-2">
                                    <button @click="changeQty(item, -1)" class="w-6 h-6 border border-slate-200 dark:border-slate-800 hover:border-emerald-500/30 rounded bg-white dark:bg-slate-950 text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white transition flex items-center justify-center">-</button>
                                    <span class="text-xs font-mono-tech font-bold text-slate-900 dark:text-white" x-text="item.quantity">1</span>
                                    <button @click="changeQty(item, 1)" class="w-6 h-6 border border-slate-200 dark:border-slate-800 hover:border-emerald-500/30 rounded bg-white dark:bg-slate-950 text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white transition flex items-center justify-center">+</button>
                                </div>
                            </div>
                            <!-- Remove -->
                            <button @click="removeItem(item)" class="p-1.5 border border-transparent group-hover:border-rose-500/20 rounded bg-white dark:bg-slate-950 text-slate-450 dark:text-slate-500 group-hover:text-rose-500 transition self-start">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </template>
                    
                    <div x-show="cart.count === 0" class="text-center py-12 space-y-3">
                        <svg class="w-12 h-12 text-slate-300 dark:text-slate-700 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="text-xs font-mono-tech text-slate-400 dark:text-slate-500 uppercase tracking-widest">// CART_VACANT_NODE</p>
                    </div>
                </div>

                <!-- Footer Summary -->
                <div class="p-6 border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950/90 shrink-0 space-y-4">
                    <div class="flex items-center justify-between font-mono-tech">
                        <span class="text-xs text-slate-450 dark:text-slate-500">SUBTOTAL</span>
                        <span class="text-base font-bold text-slate-900 dark:text-white" x-text="'$' + cart.subtotal.toFixed(2)">$0.00</span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <a href="{{ route('checkout') }}" 
                           class="w-full flex items-center justify-center py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold font-mono-tech text-xs uppercase tracking-wider rounded-xl shadow-lg transition"
                           :class="{ 'opacity-50 pointer-events-none': cart.count === 0 }">
                            [ PROCEED_TO_CHECKOUT &rarr; ]
                        </a>
                        <button @click="cartOpen = false" 
                                class="w-full py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 rounded-xl font-mono-tech text-xs uppercase text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition">
                            Continue Browsing
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Loading Spinner -->
    <x-overlapping-dots type="global" text="Syncing shop node..." />

    <!-- Alpine Cart Manager Script -->
    <script>
        function cartManager() {
            return {
                cartOpen: false,
                cart: {
                    items: [],
                    count: 0,
                    total_quantity: 0,
                    subtotal: 0.00
                },
                initCart() {
                    this.fetchCart();
                    
                    // Listen to global add-to-cart events
                    window.addEventListener('add-product-to-cart', (e) => {
                        this.addProduct(e.detail.productId, e.detail.quantity);
                    });
                },
                fetchCart() {
                    fetch('/cart')
                        .then(res => res.json())
                        .then(data => {
                            this.cart = data;
                        });
                },
                addProduct(productId, quantity) {
                    const loader = document.getElementById('global-loader');
                    if (loader) loader.classList.add('active');
                    
                    fetch('/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ product_id: productId, quantity: quantity })
                    })
                    .then(res => {
                        if (!res.ok) {
                            return res.json().then(err => { throw new Error(err.error || 'Failed to add item') });
                        }
                        return res.json();
                    })
                    .then(data => {
                        this.cart = data;
                        this.cartOpen = true;
                    })
                    .catch(err => {
                        alert(err.message);
                    })
                    .finally(() => {
                        if (loader) loader.classList.remove('active');
                    });
                },
                changeQty(item, increment) {
                    const newQty = item.quantity + increment;
                    if (newQty < 1) return;
                    
                    fetch('/cart/update', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ item_id: item.id, quantity: newQty })
                    })
                    .then(res => {
                        if (!res.ok) {
                            return res.json().then(err => { throw new Error(err.error || 'Failed to update') });
                        }
                        return res.json();
                    })
                    .then(data => {
                        this.cart = data;
                    })
                    .catch(err => {
                        alert(err.message);
                    });
                },
                removeItem(item) {
                    fetch('/cart/remove', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ item_id: item.id })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.cart = data;
                    });
                }
            }
        }
    </script>
</body>
</html>
