<x-store-layout>
    <div x-data="{ activeTab: 'overview', sidebarOpen: false, sidebarCollapsed: false }" class="relative lg:flex gap-6 items-start w-full">

        {{-- Mobile Backdrop Overlay --}}
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"
             style="display: none;"></div>

        {{-- ===================== LEFT SIDEBAR ===================== --}}
        <aside :class="{
                   'translate-x-0': sidebarOpen,
                   '-translate-x-full': !sidebarOpen,
                   'lg:w-64': !sidebarCollapsed,
                   'lg:w-20': sidebarCollapsed
               }"
               class="fixed inset-y-0 left-0 w-72 lg:w-64 lg:static lg:translate-x-0 z-50 bg-white dark:bg-slate-900 border-r lg:border border-slate-200 dark:border-slate-800 lg:rounded-2xl shadow-xl lg:shadow-sm flex flex-col justify-between transition-all duration-300 transform lg:sticky lg:top-24 shrink-0">

            <div>
                {{-- Admin Profile Header --}}
                <div class="p-5 border-b border-slate-100 dark:border-slate-800 flex transition-all duration-300"
                     :class="sidebarCollapsed ? 'flex-col items-center gap-4 justify-center' : 'flex-row items-center justify-between gap-3'">
                    <div class="flex items-center" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center text-white font-bold text-base shadow-lg shadow-violet-500/20 shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="overflow-hidden transition-all duration-300" x-show="!sidebarCollapsed">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white truncate max-w-[120px]">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">Store Administrator</p>
                        </div>
                    </div>

                    {{-- Desktop Collapse Arrow button --}}
                    <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden lg:flex p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        <svg class="w-4 h-4 transform transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    {{-- Mobile Close Button --}}
                    <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Navigation Items --}}
                <nav class="p-3 space-y-0.5">
                    @php
                        $navItems = [
                            ['tab' => 'overview',   'label' => 'Overview',       'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                            ['tab' => 'products',   'label' => 'Products',       'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                            ['tab' => 'orders',     'label' => 'Orders',         'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                            ['tab' => 'customers',  'label' => 'Customers',      'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                            ['tab' => 'coupons',    'label' => 'Coupons',        'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                            ['tab' => 'delivery',   'label' => 'Delivery',       'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                            ['tab' => 'support',    'label' => 'Support',        'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                            ['tab' => 'invites',    'label' => 'Invite Admin',   'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'],
                            ['tab' => 'logs',       'label' => 'System Logs',    'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                        <button
                            @click="activeTab = '{{ $item['tab'] }}'; if(window.innerWidth < 1024) sidebarOpen = false;"
                            :class="activeTab === '{{ $item['tab'] }}'
                                ? 'bg-violet-50 dark:bg-violet-500/10 text-violet-700 dark:text-violet-400'
                                : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white'"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group"
                            :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                            title="{{ $item['label'] }}"
                        >
                            <svg class="w-5 h-5 shrink-0 transition-colors"
                                 :class="activeTab === '{{ $item['tab'] }}' ? 'text-violet-600 dark:text-violet-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300'"
                                 fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                            </svg>
                            <span x-show="!sidebarCollapsed" x-transition>{{ $item['label'] }}</span>
                            <span x-show="activeTab === '{{ $item['tab'] }}' && !sidebarCollapsed" class="ml-auto w-1.5 h-1.5 rounded-full bg-violet-500"></span>
                        </button>
                    @endforeach
                </nav>
            </div>

            {{-- Divider + Logout --}}
            <div class="p-3 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-1">
                <a href="{{ route('home') }}"
                   :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                   class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-all duration-150 group"
                   title="Back to Store">
                    <svg class="w-5 h-5 shrink-0 text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition>Back to Store</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                            :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-all duration-150 group"
                            title="Sign Out">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition>Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ===================== MAIN CONTENT ===================== --}}
        <div class="flex-1 min-w-0 w-full space-y-6">

            {{-- Mobile Dashboard Trigger Bar --}}
            <div class="lg:hidden flex items-center justify-between p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="p-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="text-sm font-bold text-slate-800 dark:text-white">Dashboard Menu</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 text-[10px] font-bold border border-violet-500/20 bg-violet-500/10 text-violet-600 dark:text-violet-400 rounded-full uppercase tracking-wider">
                        Admin
                    </span>
                </div>
            </div>

            {{-- ===== 1. OVERVIEW TAB ===== --}}
            <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">

                {{-- Page Title --}}
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white">Dashboard Overview</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Welcome back. Here's what's happening in your store.</p>
                </div>

                {{-- Stats Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Revenue</span>
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">${{ number_format($totalSales, 2) }}</p>
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 font-medium">Confirmed sales</p>
                    </div>
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Orders</span>
                            <div class="w-8 h-8 rounded-lg bg-violet-50 dark:bg-violet-500/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalOrders }}</p>
                        <p class="text-xs text-violet-600 dark:text-violet-400 mt-1 font-medium">Confirmed orders</p>
                    </div>
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Out of Stock</span>
                            <div class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-rose-500 dark:text-rose-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $outOfStockProducts }}</p>
                        <p class="text-xs text-rose-500 dark:text-rose-400 mt-1 font-medium">Products need restocking</p>
                    </div>
                </div>

                {{-- Recent Activity --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Recent Activity</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Latest events across the store</p>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($recentActivity as $log)
                            <div class="px-6 py-4 flex items-start justify-between gap-4">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 w-2 h-2 rounded-full bg-violet-500 shrink-0"></div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900 dark:text-white capitalize">{{ $log->event }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $log->description }}</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-xs text-slate-400">{{ $log->created_at->format('M d, H:i') }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $log->ip_address }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-10 text-center">
                                <svg class="w-10 h-10 text-slate-300 dark:text-slate-700 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                <p class="text-sm text-slate-400">No activity logs yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ===== 2. PRODUCTS TAB ===== --}}
            @isset($products)
            <div x-show="activeTab === 'products'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display:none;">

                {{-- Page Title --}}
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white">Products</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage your product catalogue.</p>
                </div>

                {{-- Products Table --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">All Products</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-slate-600 dark:text-slate-300">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50 text-left">
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Price / Cost</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Stock</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($products as $prod)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $prod->primary_image }}" alt="{{ $prod->name }}" class="w-9 h-9 object-cover rounded-lg bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700" />
                                                <div>
                                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $prod->name }}</p>
                                                    <p class="text-xs text-slate-400 mt-0.5">{{ $prod->color ?? 'No color' }} &middot; {{ $prod->unit }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $prod->category->name }}</td>
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-slate-900 dark:text-white">${{ number_format($prod->price, 2) }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Cost: ${{ number_format($prod->cost, 2) }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $prod->stock <= 0 ? 'bg-rose-100 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300' }}">
                                                {{ $prod->stock }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form method="POST" action="{{ route('admin.products.destroy', ['product' => $prod->id]) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-medium text-rose-500 hover:text-rose-700 dark:hover:text-rose-400 transition px-3 py-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-500/10">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Add Product Form --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Add New Product</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Fill in the details below to add a product to the catalogue.</p>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="category_id" :value="__('Category')" />
                                    <select id="category_id" name="category_id" required class="block mt-1 w-full bg-white dark:bg-slate-950 border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-sm rounded-xl focus:border-violet-500 focus:ring-violet-500">
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="prod_name" :value="__('Product Name')" />
                                    <x-text-input id="prod_name" class="block mt-1 w-full" type="text" name="name" required placeholder="e.g. Wireless Keyboard" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="prod_price" :value="__('Retail Price ($)')" />
                                    <x-text-input id="prod_price" class="block mt-1 w-full" type="number" step="0.01" name="price" required placeholder="0.00" />
                                </div>
                                <div>
                                    <x-input-label for="prod_cost" :value="__('Cost Price ($)')" />
                                    <x-text-input id="prod_cost" class="block mt-1 w-full" type="number" step="0.01" name="cost" required placeholder="0.00" />
                                </div>
                                <div>
                                    <x-input-label for="prod_stock" :value="__('Stock Units')" />
                                    <x-text-input id="prod_stock" class="block mt-1 w-full" type="number" name="stock" required placeholder="0" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="prod_color" :value="__('Color')" />
                                    <x-text-input id="prod_color" class="block mt-1 w-full" type="text" name="color" placeholder="e.g. Space Gray" />
                                </div>
                                <div>
                                    <x-input-label for="prod_unit" :value="__('Unit Type')" />
                                    <x-text-input id="prod_unit" class="block mt-1 w-full" type="text" name="unit" required placeholder="e.g. pcs, box, pack" />
                                </div>
                                <div>
                                    <x-input-label for="prod_status" :value="__('Status')" />
                                    <select id="prod_status" name="status" required class="block mt-1 w-full bg-white dark:bg-slate-950 border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-sm rounded-xl focus:border-violet-500 focus:ring-violet-500">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <x-input-label for="prod_desc" :value="__('Description')" />
                                <textarea id="prod_desc" name="description" rows="3" required placeholder="Describe the product..."
                                          class="block mt-1 w-full bg-white dark:bg-slate-950 border-slate-300 dark:border-slate-700 rounded-xl focus:border-violet-500 focus:ring-violet-500 text-slate-800 dark:text-slate-200 text-sm shadow-sm"></textarea>
                            </div>
                            <div>
                                <x-input-label for="prod_images" :value="__('Product Images')" />
                                <input id="prod_images" type="file" name="images[]" multiple class="block mt-1 w-full text-sm text-slate-500 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 rounded-xl p-2 focus:border-violet-500" />
                            </div>
                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                                <x-primary-button>Add Product to Catalogue</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endisset

            {{-- ===== 3. ORDERS TAB ===== --}}
            @php $allOrders = \App\Models\Order::with(['items.product', 'payment'])->latest()->get(); @endphp
            <div x-show="activeTab === 'orders'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display:none;">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white">Orders</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Track and manage all customer orders.</p>
                </div>
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">All Orders</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-slate-600 dark:text-slate-300">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50 text-left">
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Order</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Update</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($allOrders as $o)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                        <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">{{ $o->order_number }}</td>
                                        <td class="px-6 py-4">
                                            <p class="font-medium text-slate-900 dark:text-white">{{ $o->email }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">{{ $o->phone }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-slate-900 dark:text-white">${{ number_format($o->total_amount, 2) }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5 capitalize">via {{ $o->payment ? $o->payment->gateway : 'pending' }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ in_array($o->status, ['paid', 'processing', 'shipped', 'delivered']) ? 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'bg-rose-100 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400' }}">
                                                {{ ucfirst($o->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form method="POST" action="{{ route('admin.orders.status', ['order' => $o->id]) }}" class="flex gap-2 justify-end items-center">
                                                @csrf
                                                <select name="status" class="bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-xs rounded-lg px-2 py-1.5 focus:border-violet-500 focus:outline-none">
                                                    @foreach (['pending','paid','processing','shipped','delivered','cancelled','failed_payment'] as $s)
                                                        <option value="{{ $s }}" {{ $o->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="px-3 py-1.5 border border-slate-300 dark:border-slate-700 hover:border-violet-500 rounded-lg text-xs font-medium text-slate-600 dark:text-slate-300 hover:text-violet-600 dark:hover:text-violet-400 transition">Save</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== 4. CUSTOMERS TAB ===== --}}
            @php $customers = \App\Models\User::where('role', 'user')->latest()->get(); @endphp
            <div x-show="activeTab === 'customers'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display:none;">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white">Customers</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">View and manage customer accounts.</p>
                </div>
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Registered Customers</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-slate-600 dark:text-slate-300">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50 text-left">
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Phone</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Address</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($customers as $c)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-slate-900 dark:text-white">{{ $c->name }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">{{ $c->email }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $c->phone ?? '—' }}</td>
                                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400 max-w-[180px] truncate">{{ $c->address ?? '—' }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $c->status === 'active' ? 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'bg-rose-100 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400' }}">
                                                {{ ucfirst($c->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form method="POST" action="{{ route('admin.customers.toggle', ['user' => $c->id]) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-xs font-medium {{ $c->status === 'active' ? 'text-rose-500 hover:text-rose-700' : 'text-emerald-600 hover:text-emerald-700' }} transition px-3 py-1.5 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800">
                                                    {{ $c->status === 'active' ? 'Disable' : 'Enable' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== 5. COUPONS TAB ===== --}}
            @php $coupons = \App\Models\Coupon::latest()->get(); @endphp
            <div x-show="activeTab === 'coupons'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display:none;">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white">Coupons</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Create and manage discount coupon codes.</p>
                </div>
                {{-- Coupon List --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Active Coupons</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-slate-600 dark:text-slate-300">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50 text-left">
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Code</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Discount</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Usage</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Expires</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($coupons as $cp)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                        <td class="px-6 py-4 font-mono font-bold text-slate-900 dark:text-white tracking-wider">{{ $cp->code }}</td>
                                        <td class="px-6 py-4 font-semibold text-emerald-600 dark:text-emerald-400">
                                            {{ $cp->type === 'percentage' ? $cp->value . '% Off' : '$' . $cp->value . ' Off' }}
                                        </td>
                                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $cp->used_count }} / {{ $cp->usage_limit ?? '∞' }}</td>
                                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $cp->expiry_date }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <form method="POST" action="{{ route('admin.coupons.destroy', ['coupon' => $cp->id]) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-medium text-rose-500 hover:text-rose-700 transition px-3 py-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-500/10">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Create Coupon --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Create New Coupon</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.coupons.store') }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="cp_code" :value="__('Coupon Code')" />
                                    <x-text-input id="cp_code" class="block mt-1 w-full uppercase" type="text" name="code" required placeholder="LAUNCH10" />
                                </div>
                                <div>
                                    <x-input-label for="cp_type" :value="__('Discount Type')" />
                                    <select id="cp_type" name="type" required class="block mt-1 w-full bg-white dark:bg-slate-950 border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-sm rounded-xl focus:border-violet-500 focus:ring-violet-500">
                                        <option value="percentage">Percentage (%)</option>
                                        <option value="fixed">Fixed Amount ($)</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="cp_value" :value="__('Value')" />
                                    <x-text-input id="cp_value" class="block mt-1 w-full" type="number" step="0.01" name="value" required placeholder="0.00" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="cp_expiry" :value="__('Expiry Date')" />
                                    <x-text-input id="cp_expiry" class="block mt-1 w-full" type="date" name="expiry_date" required />
                                </div>
                                <div>
                                    <x-input-label for="cp_limit" :value="__('Max Usages')" />
                                    <x-text-input id="cp_limit" class="block mt-1 w-full" type="number" name="usage_limit" placeholder="Unlimited" />
                                </div>
                                <div>
                                    <x-input-label for="cp_min" :value="__('Min Order Value ($)')" />
                                    <x-text-input id="cp_min" class="block mt-1 w-full" type="number" step="0.01" name="min_order_value" placeholder="0.00" />
                                </div>
                            </div>
                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                                <x-primary-button>Create Coupon</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ===== 6. DELIVERY TAB ===== --}}
            @php $deliverySettings = \App\Models\DeliveryFee::first() ?? new \App\Models\DeliveryFee(['fee' => 15.00, 'free_threshold' => 150.00]); @endphp
            <div x-show="activeTab === 'delivery'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display:none;">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white">Delivery Settings</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure shipping fees and free delivery thresholds.</p>
                </div>
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Shipping Configuration</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.delivery.store') }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="del_fee" :value="__('Flat Delivery Fee ($)')" />
                                    <x-text-input id="del_fee" class="block mt-1 w-full" type="number" step="0.01" name="fee" :value="$deliverySettings->fee" required />
                                </div>
                                <div>
                                    <x-input-label for="del_free" :value="__('Free Shipping Threshold ($)')" />
                                    <x-text-input id="del_free" class="block mt-1 w-full" type="number" step="0.01" name="free_threshold" :value="$deliverySettings->free_threshold" />
                                </div>
                            </div>
                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                                <x-primary-button>Save Delivery Settings</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ===== 7. SUPPORT TAB ===== --}}
            @php $allTickets = \App\Models\Ticket::with(['messages.user'])->latest()->get(); @endphp
            <div x-show="activeTab === 'support'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display:none;">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white">Support Tickets</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Respond to customer support requests.</p>
                </div>
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">All Tickets</h2>
                    </div>
                    <div x-data="{ adminOpenTicketId: null }" class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($allTickets as $t)
                            <div class="p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs font-mono text-slate-400">#{{ sprintf('%04d', $t->id) }}</span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $t->status === 'resolved' ? 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'bg-violet-100 dark:bg-violet-500/10 text-violet-700 dark:text-violet-400' }}">
                                                {{ ucfirst($t->status) }}
                                            </span>
                                        </div>
                                        <p class="font-semibold text-slate-900 dark:text-white text-sm">{{ $t->subject }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">From: {{ $t->user ? $t->user->email : 'Guest' }}</p>
                                    </div>
                                    <button @click="adminOpenTicketId = (adminOpenTicketId === {{ $t->id }} ? null : {{ $t->id }})"
                                            class="px-3 py-1.5 border border-slate-200 dark:border-slate-700 hover:border-violet-400 rounded-lg text-xs font-medium text-slate-500 dark:text-slate-400 hover:text-violet-600 dark:hover:text-violet-400 transition shrink-0">
                                        <span x-text="adminOpenTicketId === {{ $t->id }} ? 'Close' : 'Reply'">Reply</span>
                                    </button>
                                </div>

                                <div x-show="adminOpenTicketId === {{ $t->id }}" x-transition class="mt-4 space-y-4">
                                    {{-- Messages --}}
                                    <div class="space-y-3 max-h-60 overflow-y-auto">
                                        @foreach ($t->messages as $msg)
                                            <div class="p-3 rounded-xl text-sm {{ $msg->user_id === auth()->id() ? 'bg-violet-50 dark:bg-violet-500/10 ml-8 text-violet-900 dark:text-violet-200' : 'bg-slate-50 dark:bg-slate-800 mr-8 text-slate-700 dark:text-slate-300' }}">
                                                <p class="text-xs font-semibold mb-1 {{ $msg->user_id === auth()->id() ? 'text-violet-600 dark:text-violet-400' : 'text-slate-400' }}">
                                                    {{ $msg->user_id === auth()->id() ? 'Admin' : 'Customer' }} &middot; {{ $msg->created_at->diffForHumans() }}
                                                </p>
                                                <p>{{ $msg->message }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- Reply Form --}}
                                    <form method="POST" action="{{ route('admin.tickets.reply', ['ticket' => $t->id]) }}" class="space-y-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                                        @csrf
                                        <div class="flex items-center justify-between">
                                            <label class="text-xs font-medium text-slate-500 dark:text-slate-400">Set ticket status</label>
                                            <select name="status" class="bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs rounded-lg px-2 py-1.5 focus:border-violet-500 focus:outline-none">
                                                <option value="open" {{ $t->status === 'open' ? 'selected' : '' }}>Keep Open</option>
                                                <option value="pending" {{ $t->status === 'pending' ? 'selected' : '' }}>Set Pending</option>
                                                <option value="resolved" {{ $t->status === 'resolved' ? 'selected' : '' }}>Mark Resolved</option>
                                            </select>
                                        </div>
                                        <div class="flex gap-2">
                                            <x-text-input name="message" class="block flex-1 py-2 text-sm" required placeholder="Type your reply..." />
                                            <x-primary-button class="shrink-0">Send</x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <svg class="w-10 h-10 text-slate-300 dark:text-slate-700 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                <p class="text-sm text-slate-400">No support tickets yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ===== 8. INVITE ADMIN TAB ===== --}}
            @php $invites = \App\Models\AdminInvite::latest()->get(); @endphp
            <div x-show="activeTab === 'invites'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display:none;">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white">Invite Admin</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Send invite tokens to new administrators.</p>
                </div>
                {{-- Invite Form --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Generate Invite</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.invites.store') }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="inv_name" :value="__('Name')" />
                                    <x-text-input id="inv_name" class="block mt-1 w-full" type="text" name="name" required placeholder="e.g. Sarah Connor" />
                                </div>
                                <div>
                                    <x-input-label for="inv_email" :value="__('Email Address')" />
                                    <x-text-input id="inv_email" class="block mt-1 w-full" type="email" name="email" required placeholder="admin@shop.com" />
                                </div>
                            </div>
                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                                <x-primary-button>Generate Invite Token</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- Invite Tokens List --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Pending Invitations</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-slate-600 dark:text-slate-300">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50 text-left">
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Name / Email</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Token</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Expires</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($invites as $inv)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-slate-900 dark:text-white">{{ $inv->name }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">{{ $inv->email }}</p>
                                        </td>
                                        <td class="px-6 py-4 font-mono text-xs text-violet-600 dark:text-violet-400 select-all">{{ $inv->token }}</td>
                                        <td class="px-6 py-4 text-right">
                                            @if ($inv->isValid())
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400">Active</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">Expired</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== 9. SYSTEM LOGS TAB ===== --}}
            @php $allLogs = \App\Models\ActivityLog::with('user')->latest()->get(); @endphp
            <div x-show="activeTab === 'logs'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display:none;">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white">System Logs</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Full activity audit trail for the store.</p>
                </div>
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Activity Logs</h2>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-800 max-h-[600px] overflow-y-auto">
                        @foreach ($allLogs as $lg)
                            <div class="px-6 py-4 flex items-start justify-between gap-4 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="mt-1.5 w-2 h-2 rounded-full bg-violet-400 shrink-0"></div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900 dark:text-white capitalize">{{ $lg->event }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $lg->description }}</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-xs text-slate-400">{{ $lg->created_at->format('M d, Y H:i') }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $lg->ip_address }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>{{-- end main content --}}
    </div>{{-- end flex container --}}
</x-store-layout>
