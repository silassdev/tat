<x-store-layout>
    <div x-data="{ activeSubTab: 'purchases' }" class="flex flex-col lg:flex-row gap-6 items-start">

        {{-- ===================== LEFT SIDEBAR ===================== --}}
        <aside class="w-full lg:w-64 shrink-0">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden sticky top-24">

                {{-- Customer Profile Header --}}
                <div class="p-5 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-base shadow-lg shadow-emerald-500/20 shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">Customer Portal</p>
                        </div>
                    </div>
                </div>

                {{-- Navigation Items --}}
                <nav class="p-3 space-y-0.5">
                    @php
                        $navItems = [
                            ['tab' => 'purchases', 'label' => 'My Purchases', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
                            ['tab' => 'profile',   'label' => 'Profile & Security', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                            ['tab' => 'support',   'label' => 'Support Tickets', 'icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z'],
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                        <button
                            @click="activeSubTab = '{{ $item['tab'] }}'"
                            :class="activeSubTab === '{{ $item['tab'] }}'
                                ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400'
                                : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white'"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group"
                        >
                            <svg class="w-5 h-5 shrink-0 transition-colors"
                                 :class="activeSubTab === '{{ $item['tab'] }}' ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300'"
                                 fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                            </svg>
                            <span>{{ $item['label'] }}</span>
                            <span x-show="activeSubTab === '{{ $item['tab'] }}'" class="ml-auto w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        </button>
                    @endforeach
                </nav>

                {{-- Divider + Logout --}}
                <div class="p-3 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('home') }}"
                       class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-all duration-150 group">
                        <svg class="w-5 h-5 shrink-0 text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Back to Store</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-all duration-150 group">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ===================== MAIN CONTENT ===================== --}}
        <div class="flex-1 min-w-0 space-y-6">

            {{-- ===== 1. PURCHASES TAB ===== --}}
            <div x-show="activeSubTab === 'purchases'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-6">

                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-6 sm:p-8 space-y-6">
                    <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Purchase History</h2>
                        <p class="text-xs text-slate-400 mt-1">Check the status of your orders and track delivery details.</p>
                    </div>

                    <div class="space-y-6">
                        @forelse ($orders as $order)
                            <div class="p-5 bg-slate-50 dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800/80 rounded-2xl space-y-4 shadow-xs">
                                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-3">
                                    <div>
                                        <span class="text-[10px] font-semibold text-slate-400 dark:text-slate-500 block">ORDER REFERENCE</span>
                                        <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $order->order_number }}</span>
                                    </div>
                                    <div class="flex items-center gap-6 text-xs">
                                        <div>
                                            <span class="text-[10px] text-slate-400 dark:text-slate-500 block text-right">GRAND TOTAL</span>
                                            <span class="text-slate-900 dark:text-white font-bold text-sm">${{ number_format($order->total_amount, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-slate-400 dark:text-slate-500 block text-right mb-0.5">STATUS</span>
                                            <span class="px-2.5 py-0.5 text-[10px] font-bold border rounded-full uppercase tracking-wider
                                                   {{ in_array($order->status, ['paid', 'processing', 'shipped', 'delivered']) ? 'border-emerald-500/20 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'border-rose-500/20 bg-rose-500/10 text-rose-600 dark:text-rose-400' }}">
                                                {{ $order->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Items --}}
                                <div class="space-y-3">
                                    @foreach ($order->items as $item)
                                        <div class="flex items-center justify-between text-xs">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $item->product->primary_image }}" alt="product" class="w-10 h-10 object-cover rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800" />
                                                <div>
                                                    <span class="text-slate-850 dark:text-slate-300 font-semibold truncate max-w-[200px] block">{{ $item->product->name }}</span>
                                                    <span class="text-slate-400 dark:text-slate-500">Qty: {{ $item->quantity }}</span>
                                                </div>
                                            </div>
                                            <span class="text-slate-900 dark:text-white font-bold">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Footer details & tracking --}}
                                <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex flex-wrap justify-between items-center gap-4">
                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                        Shipped to: <span class="text-slate-800 dark:text-slate-200 font-medium">{{ Str::limit($order->delivery_address, 40) }}</span>
                                    </div>
                                    <a href="{{ route('order.track', ['order_number' => $order->order_number]) }}"
                                       class="px-4 py-2 border border-slate-250 dark:border-slate-800 rounded-xl bg-white dark:bg-slate-950/40 text-slate-650 dark:text-slate-450 hover:text-emerald-600 dark:hover:text-emerald-400 font-semibold text-xs shadow-xs transition">
                                        Track Shipment
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
                                <svg class="w-12 h-12 text-slate-350 dark:text-slate-700 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1,0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0,1-1.12-1.243l1.264-12A1.125 1.125 0 0,1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1,1-.75 0 .375.375 0 0,1 .75 0Zm7.5 0a.375.375 0 1,1-.75 0 .375.375 0 0,1 .75 0Z" />
                                </svg>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">No purchases found</p>
                                <p class="text-xs text-slate-555 dark:text-slate-400 mt-1">You haven't made any purchases yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ===== 2. PROFILE TAB ===== --}}
            <div x-show="activeSubTab === 'profile'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-6"
                 style="display: none;">

                {{-- Profile Info Card --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-sm">
                    <div class="border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Profile Information</h2>
                        <p class="text-xs text-slate-400 mt-1">Update your account's profile details and delivery address.</p>
                    </div>

                    <form method="POST" action="{{ route('dashboard.profile') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Display Name')" />
                            <x-text-input id="name" class="block mt-1 w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-850 dark:text-slate-200 text-sm rounded-xl focus:border-emerald-500 focus:ring-emerald-500" type="text" name="name" :value="old('name', $user->name)" required />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Contact Phone')" />
                            <x-text-input id="phone" class="block mt-1 w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-850 dark:text-slate-200 text-sm rounded-xl focus:border-emerald-500 focus:ring-emerald-500" type="text" name="phone" :value="old('phone', $user->phone)" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Default Delivery Address')" />
                            <textarea id="address" name="address" rows="3"
                                      class="block mt-1 w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 text-slate-800 dark:text-slate-200 text-sm shadow-sm">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                            <x-primary-button class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-slate-950 dark:text-slate-950">
                                {{ __('Update Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                {{-- Password Reset Card --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-sm">
                    <div class="border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Change Password</h2>
                        <p class="text-xs text-slate-400 mt-1">Ensure your account is using a long, random password to stay secure.</p>
                    </div>

                    <form method="POST" action="{{ route('dashboard.password') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="current_password" :value="__('Current Password')" />
                            <x-text-input id="current_password" class="block mt-1 w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-850 dark:text-slate-200 text-sm rounded-xl focus:border-emerald-500 focus:ring-emerald-500" type="password" name="current_password" required />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('New Password')" />
                            <x-text-input id="password" class="block mt-1 w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-850 dark:text-slate-200 text-sm rounded-xl focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password" required autocomplete="new-password" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-850 dark:text-slate-200 text-sm rounded-xl focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password_confirmation" required />
                        </div>

                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                            <x-primary-button class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-slate-950 dark:text-slate-950">
                                {{ __('Update Password') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ===== 3. SUPPORT TICKETS TAB ===== --}}
            <div x-show="activeSubTab === 'support'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-6"
                 style="display: none;">

                {{-- Ticket History Card --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-sm">
                    <div class="border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Active Support Threads</h2>
                        <p class="text-xs text-slate-400 mt-1">Communicate with store admins regarding your inquiries.</p>
                    </div>

                    <div x-data="{ openTicketId: null }" class="space-y-6">
                        @forelse ($tickets as $ticket)
                            <div class="p-5 bg-slate-50 dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800/80 rounded-2xl space-y-4 shadow-xs">
                                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-3">
                                    <div>
                                        <span class="text-[10px] font-semibold text-slate-400 dark:text-slate-500 block">TICKET ID: #{{ sprintf('%04d', $ticket->id) }}</span>
                                        <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $ticket->subject }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-2.5 py-0.5 text-[10px] font-bold border rounded-full uppercase tracking-wider
                                               {{ $ticket->status === 'resolved' ? 'border-emerald-500/20 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'border-amber-500/20 bg-amber-500/10 text-amber-600 dark:text-amber-450' }}">
                                            {{ $ticket->status }}
                                        </span>
                                        <button @click="openTicketId = (openTicketId === {{ $ticket->id }} ? null : {{ $ticket->id }})"
                                                class="px-3.5 py-1.5 border border-slate-250 dark:border-slate-800 rounded-xl bg-white dark:bg-slate-950 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition shadow-xs">
                                            <span x-text="openTicketId === {{ $ticket->id }} ? 'Close Conversation' : 'Open Thread'">Open Thread</span>
                                        </button>
                                    </div>
                                </div>

                                {{-- Thread messages drawer inside card --}}
                                <div x-show="openTicketId === {{ $ticket->id }}" x-transition class="space-y-4 pt-2">
                                    <div class="space-y-3 max-h-[250px] overflow-y-auto pr-1">
                                        @foreach ($ticket->messages as $msg)
                                            <div class="p-3.5 border rounded-xl text-xs space-y-1 relative overflow-hidden
                                                        {{ $msg->user_id === auth()->id() ? 'border-emerald-500/10 bg-emerald-500/5 dark:bg-emerald-500/5 ml-8' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 mr-8' }}">
                                                <div class="flex justify-between items-center text-[10px] select-none">
                                                    <span class="font-bold {{ $msg->user_id === auth()->id() ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-400' }}">
                                                        {{ $msg->user_id === auth()->id() ? 'You (Customer)' : 'Support Staff' }}
                                                    </span>
                                                    <span class="text-slate-400 dark:text-slate-500">{{ $msg->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-slate-700 dark:text-slate-300 leading-relaxed font-sans mt-1">{{ $msg->message }}</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Reply form --}}
                                    @if ($ticket->status !== 'resolved')
                                        <form method="POST" action="{{ route('dashboard.tickets.reply', ['ticket' => $ticket->id]) }}" class="flex gap-2">
                                            @csrf
                                            <div class="flex-grow">
                                                <x-text-input name="message" class="block w-full py-2 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-850 dark:text-slate-200 text-sm rounded-xl focus:border-emerald-500 focus:ring-emerald-500" required placeholder="Type reply message..." />
                                            </div>
                                            <x-primary-button class="py-2 px-5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-slate-950 dark:text-slate-950 font-bold text-xs shrink-0 rounded-xl transition">
                                                Reply
                                            </x-primary-button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 border border-slate-200 dark:border-slate-800 border-dashed rounded-2xl">
                                <svg class="w-12 h-12 text-slate-350 dark:text-slate-700 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                </svg>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">No support tickets</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">If you need help, open a support ticket below.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Create Ticket Card --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-sm">
                    <div class="border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Submit Support Ticket</h2>
                        <p class="text-xs text-slate-400 mt-1">Send a message and a ticket ID will be generated for tracking.</p>
                    </div>

                    <form method="POST" action="{{ route('dashboard.tickets') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="subject" :value="__('Ticket Subject')" />
                            <x-text-input id="subject" class="block mt-1 w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-850 dark:text-slate-200 text-sm rounded-xl focus:border-emerald-500 focus:ring-emerald-500" type="text" name="subject" required placeholder="e.g. Inquiry regarding order ORD-XXXXXXXXX" />
                        </div>

                        <div>
                            <x-input-label for="message" :value="__('Message Description')" />
                            <textarea id="message" name="message" rows="3" required placeholder="Provide a detailed request..."
                                      class="block mt-1 w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 text-slate-800 dark:text-slate-200 text-sm shadow-sm"></textarea>
                        </div>

                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                            <x-primary-button class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-slate-950 dark:text-slate-950">
                                {{ __('Submit Ticket') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-store-layout>
