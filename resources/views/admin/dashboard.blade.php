<x-store-layout>
    <div x-data="{ activeTab: 'overview' }" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Sidebar Navigation for Admin (3 Columns) -->
        <div class="lg:col-span-3 bg-slate-950/40 border border-slate-800 rounded-3xl p-6 shadow-2xl relative font-mono-tech text-xs select-none">
            <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
            <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

            <div class="mb-6 text-center border-b border-slate-900 pb-4">
                <div class="w-12 h-12 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 font-bold flex items-center justify-center text-base mx-auto mb-2 shrink-0">
                    A
                </div>
                <h4 class="text-sm font-bold text-white tracking-tight truncate">Store Administrator</h4>
                <span class="text-[10px] text-indigo-400 tracking-wider block">// ROOT_CONTROL_NODE</span>
            </div>

            <!-- Dashboard Modules Tabs -->
            <div class="flex flex-col gap-1.5">
                <button @click="activeTab = 'overview'" 
                        :class="activeTab === 'overview' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-slate-900 hover:text-white'"
                        class="w-full text-left px-4 py-2.5 border rounded-xl font-bold uppercase tracking-wider transition">
                    [ Overview Stats ]
                </button>
                <button @click="activeTab = 'products'" 
                        :class="activeTab === 'products' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-slate-900 hover:text-white'"
                        class="w-full text-left px-4 py-2.5 border rounded-xl font-bold uppercase tracking-wider transition">
                    [ Product CRUD ]
                </button>
                <button @click="activeTab = 'orders'" 
                        :class="activeTab === 'orders' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-slate-900 hover:text-white'"
                        class="w-full text-left px-4 py-2.5 border rounded-xl font-bold uppercase tracking-wider transition">
                    [ Manage Orders ]
                </button>
                <button @click="activeTab = 'customers'" 
                        :class="activeTab === 'customers' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-slate-900 hover:text-white'"
                        class="w-full text-left px-4 py-2.5 border rounded-xl font-bold uppercase tracking-wider transition">
                    [ Customers List ]
                </button>
                <button @click="activeTab = 'coupons'" 
                        :class="activeTab === 'coupons' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-slate-900 hover:text-white'"
                        class="w-full text-left px-4 py-2.5 border rounded-xl font-bold uppercase tracking-wider transition">
                    [ Coupons CRUD ]
                </button>
                <button @click="activeTab = 'delivery'" 
                        :class="activeTab === 'delivery' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-slate-900 hover:text-white'"
                        class="w-full text-left px-4 py-2.5 border rounded-xl font-bold uppercase tracking-wider transition">
                    [ Delivery Fee ]
                </button>
                <button @click="activeTab = 'support'" 
                        :class="activeTab === 'support' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-slate-900 hover:text-white'"
                        class="w-full text-left px-4 py-2.5 border rounded-xl font-bold uppercase tracking-wider transition">
                    [ Support Chat ]
                </button>
                <button @click="activeTab = 'invites'" 
                        :class="activeTab === 'invites' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-slate-900 hover:text-white'"
                        class="w-full text-left px-4 py-2.5 border rounded-xl font-bold uppercase tracking-wider transition">
                    [ Invite Admin ]
                </button>
                <button @click="activeTab = 'logs'" 
                        :class="activeTab === 'logs' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-slate-900 hover:text-white'"
                        class="w-full text-left px-4 py-2.5 border rounded-xl font-bold uppercase tracking-wider transition">
                    [ System Logs ]
                </button>
            </div>
        </div>

        <!-- Right Side: Active Modules HUD (9 Columns) -->
        <div class="lg:col-span-9 space-y-6">

            <!-- 1. Overview Tab -->
            <div x-show="activeTab === 'overview'" x-transition class="space-y-6">
                <!-- Stats widgets -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 font-mono-tech select-none">
                    <div class="bg-slate-950/40 border border-slate-800 rounded-2xl p-5 shadow-lg">
                        <span class="text-[9px] text-slate-500 block">TOTAL_REVENUE</span>
                        <span class="text-2xl font-black text-emerald-400 block mt-1">${{ number_format($totalSales, 2) }}</span>
                    </div>
                    <div class="bg-slate-950/40 border border-slate-800 rounded-2xl p-5 shadow-lg">
                        <span class="text-[9px] text-slate-500 block">CONFIRMED_ORDERS</span>
                        <span class="text-2xl font-black text-white block mt-1">{{ $totalOrders }} runs</span>
                    </div>
                    <div class="bg-slate-950/40 border border-slate-800 rounded-2xl p-5 shadow-lg">
                        <span class="text-[9px] text-slate-500 block">OUT_OF_STOCK</span>
                        <span class="text-2xl font-black text-rose-400 block mt-1">{{ $outOfStockProducts }} units</span>
                    </div>
                </div>

                <!-- Recent Activity Logs widget -->
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h3 class="text-xs font-bold text-white font-mono-tech uppercase tracking-wider mb-5 select-none">// RECENT_NODE_LOGS</h3>
                    
                    <div class="space-y-4 font-mono-tech text-[10px]">
                        @forelse ($recentActivity as $log)
                            <div class="p-3 bg-slate-900/40 border border-slate-850 rounded-xl flex items-center justify-between gap-4">
                                <div>
                                    <span class="text-emerald-400 font-bold block">{{ strtoupper($log->event) }}</span>
                                    <span class="text-slate-400 block mt-0.5">{{ $log->description }}</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="text-slate-600 block">{{ $log->created_at->format('Y-m-d H:i:s') }}</span>
                                    <span class="text-slate-500 block text-[9px]">IP: {{ $log->ip_address }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 text-center py-6 select-none">No system logs collected yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- 2. Product CRUD Tab -->
            @isset($products)
            <div x-show="activeTab === 'products'" x-transition class="space-y-6">
                <!-- A. Products List Table -->
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-xs font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// PRODUCTS_INDEX_DIR</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs font-mono-tech text-slate-300">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-500 text-left">
                                    <th class="pb-3 uppercase">Product</th>
                                    <th class="pb-3 uppercase">Category</th>
                                    <th class="pb-3 uppercase">Price / Cost</th>
                                    <th class="pb-3 uppercase text-center">Stock</th>
                                    <th class="pb-3 uppercase text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-900">
                                @foreach ($products as $prod)
                                    <tr class="group">
                                        <td class="py-3.5 pr-3">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $prod->primary_image }}" alt="img" class="w-8 h-8 object-cover rounded bg-slate-950 border border-slate-800" />
                                                <div>
                                                    <span class="font-bold text-white block group-hover:text-emerald-400 transition">{{ $prod->name }}</span>
                                                    <span class="text-[10px] text-slate-500 block">COL: {{ $prod->color ?? 'None' }} // UNT: {{ $prod->unit }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-3 text-slate-400">{{ $prod->category->name }}</td>
                                        <td class="py-3.5 px-3">
                                            <span class="text-white font-bold">${{ number_format($prod->price, 2) }}</span>
                                            <span class="text-[10px] text-slate-600 block">Cost: ${{ number_format($prod->cost, 2) }}</span>
                                        </td>
                                        <td class="py-3.5 px-3 text-center">
                                            <span class="px-2 py-0.5 rounded border font-bold
                                                   {{ $prod->stock <= 0 ? 'border-rose-500/20 bg-rose-500/10 text-rose-400' : 'border-slate-800 text-slate-300' }}">
                                                {{ $prod->stock }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 pl-3 text-right">
                                            <form method="POST" action="{{ route('admin.products.destroy', ['product' => $prod->id]) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 border border-transparent hover:border-rose-500/30 hover:bg-rose-950/20 rounded text-rose-500 font-bold tracking-widest text-[9px] transition uppercase">
                                                    Purge
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- B. Create Product Form -->
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-xs font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// ADD_NEW_PRODUCT_RECORD</h2>

                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="category_id" :value="__('Select Category')" />
                                <select id="category_id" name="category_id" required
                                        class="block mt-1 w-full bg-slate-950 border-slate-800 text-slate-300 text-xs rounded-xl focus:border-emerald-500 focus:ring-emerald-500">
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="prod_name" :value="__('Product Display Name')" />
                                <x-text-input id="prod_name" class="block mt-1 w-full" type="text" name="name" required placeholder="e.g. CyberX Keyboard" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="prod_price" :value="__('Retail Price ($)')" />
                                <x-text-input id="prod_price" class="block mt-1 w-full" type="number" step="0.01" name="price" required placeholder="0.00" />
                            </div>
                            <div>
                                <x-input-label for="prod_cost" :value="__('System Cost ($)')" />
                                <x-text-input id="prod_cost" class="block mt-1 w-full" type="number" step="0.01" name="cost" required placeholder="0.00" />
                            </div>
                            <div>
                                <x-input-label for="prod_stock" :value="__('System Stock Units')" />
                                <x-text-input id="prod_stock" class="block mt-1 w-full" type="number" name="stock" required placeholder="0" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="prod_color" :value="__('Product Color Spectrum')" />
                                <x-text-input id="prod_color" class="block mt-1 w-full" type="text" name="color" placeholder="e.g. Matte Gray" />
                            </div>
                            <div>
                                <x-input-label for="prod_unit" :value="__('Product Packaging Unit')" />
                                <x-text-input id="prod_unit" class="block mt-1 w-full" type="text" name="unit" required placeholder="e.g. pcs, box, packet" />
                            </div>
                            <div>
                                <x-input-label for="prod_status" :value="__('Active State Status')" />
                                <select id="prod_status" name="status" required
                                        class="block mt-1 w-full bg-slate-950 border-slate-800 text-slate-300 text-xs rounded-xl focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="active">Active System</option>
                                    <option value="inactive">Inactive Hold</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="prod_desc" :value="__('Product Specifications Details')" />
                            <textarea id="prod_desc" name="description" rows="3" required placeholder="Specify technical properties..."
                                      class="block mt-1 w-full bg-slate-950/80 border-slate-800 dark:border-slate-800/80 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 text-slate-200 text-xs shadow-sm"></textarea>
                        </div>

                        <div>
                            <x-input-label for="prod_images" :value="__('Upload Media Images (Multiple)')" />
                            <input id="prod_images" type="file" name="images[]" multiple class="block mt-1 w-full text-xs text-slate-500 font-mono-tech border border-slate-800 bg-slate-950 rounded-xl p-2 focus:border-emerald-500" />
                        </div>

                        <div class="pt-2 border-t border-slate-900">
                            <x-primary-button>
                                {{ __('Commit Product to Catalogue') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            @endisset

            <!-- 3. Orders Tab -->
            @php
                $allOrders = \App\Models\Order::with(['items.product', 'payment'])->latest()->get();
            @endphp
            <div x-show="activeTab === 'orders'" x-transition class="space-y-6" style="display: none;">
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-xs font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// ORDERS_TRACKING_AND_LOGISTICS</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs font-mono-tech text-slate-300">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-500 text-left">
                                    <th class="pb-3 uppercase">Order Ref</th>
                                    <th class="pb-3 uppercase">Client Details</th>
                                    <th class="pb-3 uppercase">Total Captured</th>
                                    <th class="pb-3 uppercase">Logistics State</th>
                                    <th class="pb-3 uppercase text-right">Commit State</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-900">
                                @foreach ($allOrders as $o)
                                    <tr>
                                        <td class="py-3.5 pr-3 font-bold text-white">{{ $o->order_number }}</td>
                                        <td class="py-3.5 px-3 text-slate-400">
                                            <span class="block text-white">{{ $o->email }}</span>
                                            <span class="block text-[10px] text-slate-500">{{ $o->phone }}</span>
                                        </td>
                                        <td class="py-3.5 px-3">
                                            <span class="block text-white font-bold">${{ number_format($o->total_amount, 2) }}</span>
                                            <span class="block text-[9px] text-slate-600 uppercase">Gateway: {{ $o->payment ? $o->payment->gateway : 'pending' }}</span>
                                        </td>
                                        <td class="py-3.5 px-3">
                                            <span class="px-2 py-0.5 text-[9px] font-bold border rounded uppercase tracking-wider
                                                   {{ in_array($o->status, ['paid', 'processing', 'shipped', 'delivered']) ? 'border-emerald-500/20 bg-emerald-500/10 text-emerald-400' : 'border-rose-500/20 bg-rose-500/10 text-rose-400' }}">
                                                {{ $o->status }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 pl-3 text-right">
                                            <form method="POST" action="{{ route('admin.orders.status', ['order' => $o->id]) }}" class="flex gap-2 justify-end">
                                                @csrf
                                                <select name="status" class="bg-slate-950 border border-slate-850 text-slate-400 text-[10px] rounded-lg p-1 focus:border-emerald-500 focus:outline-none">
                                                    <option value="pending" {{ $o->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="paid" {{ $o->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                    <option value="processing" {{ $o->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="shipped" {{ $o->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                    <option value="delivered" {{ $o->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                    <option value="cancelled" {{ $o->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    <option value="failed_payment" {{ $o->status === 'failed_payment' ? 'selected' : '' }}>Failed</option>
                                                </select>
                                                <button type="submit" class="px-2 py-1 border border-slate-850 hover:border-emerald-500/30 rounded text-slate-300 hover:text-emerald-400 text-[9px] font-bold tracking-wider uppercase transition">
                                                    Sync
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

            <!-- 4. Customers Tab -->
            @php
                $customers = \App\Models\User::where('role', 'user')->latest()->get();
            @endphp
            <div x-show="activeTab === 'customers'" x-transition class="space-y-6" style="display: none;">
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-xs font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// CUSTOMERS_MEMBERSHIP_DIRECTORY</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs font-mono-tech text-slate-300">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-500 text-left">
                                    <th class="pb-3 uppercase">Customer</th>
                                    <th class="pb-3 uppercase">Phone</th>
                                    <th class="pb-3 uppercase">Address</th>
                                    <th class="pb-3 uppercase">Active State</th>
                                    <th class="pb-3 uppercase text-right">Commit State</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-900">
                                @foreach ($customers as $c)
                                    <tr>
                                        <td class="py-3.5 pr-3 font-bold text-white">
                                            <span>{{ $c->name }}</span>
                                            <span class="block text-[10px] text-slate-500 font-normal mt-0.5">{{ $c->email }}</span>
                                        </td>
                                        <td class="py-3.5 px-3 text-slate-400">{{ $c->phone ?? 'N/A' }}</td>
                                        <td class="py-3.5 px-3 text-slate-400 max-w-[150px] truncate">{{ $c->address ?? 'N/A' }}</td>
                                        <td class="py-3.5 px-3">
                                            <span class="px-2.5 py-0.5 text-[9px] font-bold border rounded uppercase tracking-wider
                                                   {{ $c->status === 'active' ? 'border-emerald-500/20 bg-emerald-500/10 text-emerald-400' : 'border-rose-500/20 bg-rose-500/10 text-rose-400' }}">
                                                {{ $c->status }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 pl-3 text-right">
                                            <form method="POST" action="{{ route('admin.customers.toggle', ['user' => $c->id]) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2 py-1 border border-slate-850 hover:border-slate-700 rounded text-slate-400 hover:text-white text-[9px] font-bold uppercase transition">
                                                    {{ $c->status === 'active' ? 'Disable Account' : 'Enable Account' }}
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

            <!-- 5. Coupons Tab -->
            @php
                $coupons = \App\Models\Coupon::latest()->get();
            @endphp
            <div x-show="activeTab === 'coupons'" x-transition class="space-y-6" style="display: none;">
                <!-- A. Coupons List -->
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-xs font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// PROMOTIONAL_COUPON_CODES</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs font-mono-tech text-slate-300">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-500 text-left">
                                    <th class="pb-3 uppercase">Coupon Code</th>
                                    <th class="pb-3 uppercase">Discount Value</th>
                                    <th class="pb-3 uppercase">Usage Stats</th>
                                    <th class="pb-3 uppercase">Expiry Node</th>
                                    <th class="pb-3 uppercase text-right">Purge</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-900">
                                @foreach ($coupons as $cp)
                                    <tr>
                                        <td class="py-3.5 pr-3 font-bold text-white uppercase tracking-wider">{{ $cp->code }}</td>
                                        <td class="py-3.5 px-3 text-emerald-400 font-bold">
                                            @if ($cp->type === 'percentage')
                                                {{ $cp->value }}% Off
                                            @else
                                                ${{ $cp->value }} Off
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-3 text-slate-400">
                                            Used: {{ $cp->used_count }} / {{ $cp->usage_limit ?? 'Infinite' }}
                                        </td>
                                        <td class="py-3.5 px-3 text-slate-500">{{ $cp->expiry_date }}</td>
                                        <td class="py-3.5 pl-3 text-right">
                                            <form method="POST" action="{{ route('admin.coupons.destroy', ['coupon' => $cp->id]) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 border border-transparent hover:border-rose-500/30 hover:bg-rose-950/20 rounded text-rose-500 font-bold tracking-widest text-[9px] transition uppercase">
                                                    Purge
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- B. Create Coupon Form -->
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-xs font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// CREATE_DISCOUNT_NODE</h2>

                    <form method="POST" action="{{ route('admin.coupons.store') }}" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="cp_code" :value="__('Coupon Reference Code')" />
                                <x-text-input id="cp_code" class="block mt-1 w-full uppercase" type="text" name="code" required placeholder="LAUNCH10" />
                            </div>
                            <div>
                                <x-input-label for="cp_type" :value="__('Discount Formula')" />
                                <select id="cp_type" name="type" required
                                        class="block mt-1 w-full bg-slate-950 border-slate-800 text-slate-300 text-xs rounded-xl focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="percentage">Percentage Rate (%)</option>
                                    <option value="fixed">Fixed Rate Value ($)</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="cp_value" :value="__('Rate Value')" />
                                <x-text-input id="cp_value" class="block mt-1 w-full" type="number" step="0.01" name="value" required placeholder="0.00" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="cp_expiry" :value="__('Expiry Limit Date')" />
                                <x-text-input id="cp_expiry" class="block mt-1 w-full" type="date" name="expiry_date" required />
                            </div>
                            <div>
                                <x-input-label for="cp_limit" :value="__('Total Max Usages')" />
                                <x-text-input id="cp_limit" class="block mt-1 w-full" type="number" name="usage_limit" placeholder="Infinite" />
                            </div>
                            <div>
                                <x-input-label for="cp_min" :value="__('Min Order Value ($)')" />
                                <x-text-input id="cp_min" class="block mt-1 w-full" type="number" step="0.01" name="min_order_value" placeholder="0.00" />
                            </div>
                        </div>

                        <div class="pt-2 border-t border-slate-900">
                            <x-primary-button>
                                {{ __('Commit Coupon Node') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 6. Delivery Fee Tab -->
            @php
                $deliverySettings = \App\Models\DeliveryFee::first() ?? new \App\Models\DeliveryFee(['fee' => 15.00, 'free_threshold' => 150.00]);
            @endphp
            <div x-show="activeTab === 'delivery'" x-transition class="space-y-6" style="display: none;">
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-xs font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// LOGISTICS_SHIPPING_COST_NODE</h2>

                    <form method="POST" action="{{ route('admin.delivery.store') }}" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="del_fee" :value="__('Flat Delivery Rate Fee ($)')" />
                                <x-text-input id="del_fee" class="block mt-1 w-full" type="number" step="0.01" name="fee" :value="$deliverySettings->fee" required />
                            </div>
                            <div>
                                <x-input-label for="del_free" :value="__('Free Shipping Purchase Threshold ($)')" />
                                <x-text-input id="del_free" class="block mt-1 w-full" type="number" step="0.01" name="free_threshold" :value="$deliverySettings->free_threshold" />
                            </div>
                        </div>

                        <div class="pt-2 border-t border-slate-900">
                            <x-primary-button>
                                {{ __('Save Delivery Settings') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 7. Support Chat Tab -->
            @php
                $allTickets = \App\Models\Ticket::with(['messages.user'])->latest()->get();
            @endphp
            <div x-show="activeTab === 'support'" x-transition class="space-y-6" style="display: none;">
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-xs font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// ADMIN_SUPPORT_CHAT_GATEWAY</h2>

                    <div x-data="{ adminOpenTicketId: null }" class="space-y-6">
                        @forelse ($allTickets as $t)
                            <div class="p-4 bg-slate-900/50 border border-slate-800 rounded-2xl relative space-y-4">
                                <div class="flex items-center justify-between border-b border-slate-950 pb-3">
                                    <div>
                                        <span class="text-[9px] font-mono-tech text-slate-500 block">TICKET_REF</span>
                                        <span class="text-xs font-bold text-white font-mono-tech">#{{ sprintf('%04d', $t->id) }} // {{ $t->subject }}</span>
                                        <span class="text-[10px] text-slate-500 block mt-0.5">Author: {{ $t->user ? $t->user->email : 'Guest' }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-2 py-0.5 text-[9px] font-bold border rounded uppercase tracking-wider
                                               {{ $t->status === 'resolved' ? 'border-emerald-500/20 bg-emerald-500/10 text-emerald-400' : 'border-indigo-500/20 bg-indigo-500/10 text-indigo-400' }}">
                                            {{ $t->status }}
                                        </span>
                                        <button @click="adminOpenTicketId = (adminOpenTicketId === {{ $t->id }} ? null : {{ $t->id }})" 
                                                class="px-2.5 py-1 border border-slate-850 hover:border-slate-700 rounded-lg bg-slate-950/40 text-[9px] font-mono-tech uppercase font-bold text-slate-400 hover:text-white transition">
                                            <span x-text="adminOpenTicketId === {{ $t->id }} ? '[ CLOSE ]' : '[ RESPOND ]'">[ RESPOND ]</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Messages Thread Drawer -->
                                <div x-show="adminOpenTicketId === {{ $t->id }}" x-transition class="space-y-4 pt-2">
                                    <div class="space-y-3 max-h-[200px] overflow-y-auto pr-1">
                                        @foreach ($t->messages as $msg)
                                            <div class="p-3 border rounded-xl text-xs space-y-1 relative overflow-hidden
                                                        {{ $msg->user_id === auth()->id() ? 'border-indigo-500/10 bg-indigo-500/5 ml-8' : 'border-slate-800 bg-slate-950/40 mr-8' }}">
                                                <div class="flex justify-between items-center text-[9px] font-mono-tech select-none">
                                                    <span class="{{ $msg->user_id === auth()->id() ? 'text-indigo-400' : 'text-slate-500' }}">
                                                        {{ $msg->user_id === auth()->id() ? '// SYSTEM_ADMIN' : '// CUSTOMER' }}
                                                    </span>
                                                    <span class="text-slate-600">{{ $msg->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-slate-300 leading-relaxed font-sans">{{ $msg->message }}</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Reply form -->
                                    <form method="POST" action="{{ route('admin.tickets.reply', ['ticket' => $t->id]) }}" class="space-y-3 pt-3 border-t border-slate-950">
                                        @csrf
                                        
                                        <div class="flex items-center justify-between text-xs font-mono-tech">
                                            <span class="text-slate-500 uppercase select-none">// RESOLUTION_NODE_STATE</span>
                                            <select name="status" class="bg-slate-950 border border-slate-850 text-slate-400 text-[10px] rounded-lg p-1 focus:border-emerald-500 focus:outline-none">
                                                <option value="open" {{ $t->status === 'open' ? 'selected' : '' }}>Keep Open</option>
                                                <option value="pending" {{ $t->status === 'pending' ? 'selected' : '' }}>Set Pending</option>
                                                <option value="resolved" {{ $t->status === 'resolved' ? 'selected' : '' }}>Mark Resolved</option>
                                            </select>
                                        </div>

                                        <div class="flex gap-2">
                                            <div class="flex-grow">
                                                <x-text-input name="message" class="block w-full py-2 font-mono-tech text-xs" required placeholder="Type reply message..." />
                                            </div>
                                            <x-primary-button class="py-2 px-4 select-none shrink-0 font-mono-tech text-[10px]">
                                                Transmit
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 border border-slate-800 border-dashed rounded-2xl select-none">
                                <p class="text-xs font-mono-tech text-slate-500 uppercase tracking-widest">// NO_TICKET_LOGS</p>
                                <p class="text-xs text-slate-600 mt-1">There are no customer support threads logged in directories.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- 8. Invite Admin Tab -->
            @php
                $invites = \App\Models\AdminInvite::latest()->get();
            @endphp
            <div x-show="activeTab === 'invites'" x-transition class="space-y-6" style="display: none;">
                <!-- A. invites Form -->
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-xs font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// INVITE_ADMINISTRATIVE_OPERATOR</h2>

                    <form method="POST" action="{{ route('admin.invites.store') }}" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="inv_name" :value="__('Operator Name')" />
                                <x-text-input id="inv_name" class="block mt-1 w-full" type="text" name="name" required placeholder="e.g. Sarah Connor" />
                            </div>
                            <div>
                                <x-input-label for="inv_email" :value="__('Operator Email')" />
                                <x-text-input id="inv_email" class="block mt-1 w-full" type="email" name="email" required placeholder="sarah@shop.com" />
                            </div>
                        </div>

                        <div class="pt-2 border-t border-slate-900">
                            <x-primary-button>
                                {{ __('Generate Invite Token') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <!-- B. Token list -->
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-xs font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// ACTIVE_INVITATION_TOKENS</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs font-mono-tech text-slate-300">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-500 text-left">
                                    <th class="pb-3 uppercase">Name / Email</th>
                                    <th class="pb-3 uppercase">Token ID</th>
                                    <th class="pb-3 uppercase text-right">Expiration Limit</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-900">
                                @foreach ($invites as $inv)
                                    <tr>
                                        <td class="py-3.5 pr-3 font-bold text-white">
                                            <span>{{ $inv->name }}</span>
                                            <span class="block text-[10px] text-slate-500 font-normal mt-0.5">{{ $inv->email }}</span>
                                        </td>
                                        <td class="py-3.5 px-3 text-emerald-400 font-mono-tech select-all">
                                            {{ $inv->token }}
                                        </td>
                                        <td class="py-3.5 pl-3 text-right text-slate-500 font-bold uppercase">
                                            @if ($inv->isValid())
                                                Active // Exp {{ $inv->expires_at }}
                                            @else
                                                Expired
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 9. Logs Tab -->
            @php
                $allLogs = \App\Models\ActivityLog::with('user')->latest()->get();
            @endphp
            <div x-show="activeTab === 'logs'" x-transition class="space-y-6" style="display: none;">
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-xs font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// COMPREHENSIVE_SYSTEM_AUDIT_LOGS</h2>

                    <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 font-mono-tech text-[10px]">
                        @foreach ($allLogs as $lg)
                            <div class="p-3 bg-slate-900/40 border border-slate-850 rounded-xl flex items-center justify-between gap-4">
                                <div>
                                    <span class="text-emerald-400 font-bold block">{{ strtoupper($lg->event) }}</span>
                                    <span class="text-slate-400 block mt-0.5">{{ $lg->description }}</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="text-slate-600 block">{{ $lg->created_at->format('Y-m-d H:i:s') }}</span>
                                    <span class="text-slate-500 block text-[9px]">IP: {{ $lg->ip_address }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-store-layout>
