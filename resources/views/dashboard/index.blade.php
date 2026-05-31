<x-store-layout>
    <div x-data="{ activeSubTab: 'purchases' }" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Side: Navigation Controls (3 Columns) -->
        <div class="lg:col-span-3 bg-slate-950/40 border border-slate-800 rounded-3xl p-6 shadow-2xl relative font-mono-tech text-xs select-none">
            <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
            <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

            <div class="mb-6 text-center border-b border-slate-900 pb-4">
                <div class="w-12 h-12 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold flex items-center justify-center text-base mx-auto mb-2 shrink-0">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h4 class="text-sm font-bold text-white tracking-tight truncate">{{ $user->name }}</h4>
                <span class="text-[10px] text-slate-500 tracking-wider truncate block">{{ $user->email }}</span>
            </div>

            <!-- Tab Buttons -->
            <div class="flex flex-col gap-2">
                <button @click="activeSubTab = 'purchases'" 
                        :class="activeSubTab === 'purchases' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-slate-900 hover:text-white'"
                        class="w-full text-left px-4 py-3 border rounded-xl font-bold uppercase tracking-wider transition">
                    [ My Purchases ]
                </button>
                <button @click="activeSubTab = 'profile'" 
                        :class="activeSubTab === 'profile' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-slate-900 hover:text-white'"
                        class="w-full text-left px-4 py-3 border rounded-xl font-bold uppercase tracking-wider transition">
                    [ Profile & Security ]
                </button>
                <button @click="activeSubTab = 'support'" 
                        :class="activeSubTab === 'support' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-slate-900 hover:text-white'"
                        class="w-full text-left px-4 py-3 border rounded-xl font-bold uppercase tracking-wider transition">
                    [ Support Tickets ]
                </button>
            </div>
        </div>

        <!-- Right Side: Tab Contents (9 Columns) -->
        <div class="lg:col-span-9 space-y-6">

            <!-- 1. Purchases Tab -->
            <div x-show="activeSubTab === 'purchases'" x-transition class="space-y-6">
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-lg font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// USER_PURCHASE_HISTORY</h2>

                    <div class="space-y-6">
                        @forelse ($orders as $order)
                            <div class="p-5 bg-slate-900/50 border border-slate-800 rounded-2xl relative space-y-4">
                                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-950 pb-3">
                                    <div>
                                        <span class="text-[9px] font-mono-tech text-slate-500 block">ORDER_REF</span>
                                        <span class="text-xs font-bold text-white font-mono-tech">{{ $order->order_number }}</span>
                                    </div>
                                    <div class="flex items-center gap-4 text-xs font-mono-tech">
                                        <div>
                                            <span class="text-[9px] text-slate-500 block text-right">GRAND_TOTAL</span>
                                            <span class="text-white font-bold">${{ number_format($order->total_amount, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-[9px] text-slate-500 block text-right">STATUS</span>
                                            <span class="px-2 py-0.5 text-[9px] font-bold border rounded uppercase tracking-wider
                                                   {{ in_array($order->status, ['paid', 'processing', 'shipped', 'delivered']) ? 'border-emerald-500/20 bg-emerald-500/10 text-emerald-400' : 'border-rose-500/20 bg-rose-500/10 text-rose-400' }}">
                                                {{ $order->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Items -->
                                <div class="space-y-3">
                                    @foreach ($order->items as $item)
                                        <div class="flex items-center justify-between text-xs font-mono-tech">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $item->product->primary_image }}" alt="product" class="w-8 h-8 object-cover rounded bg-slate-950 border border-slate-850" />
                                                <span class="text-slate-400 truncate max-w-[200px]">{{ $item->product->name }} (x{{ $item->quantity }})</span>
                                            </div>
                                            <span class="text-slate-300 font-bold">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Footer details & tracking -->
                                <div class="pt-3 border-t border-slate-950 flex flex-wrap justify-between items-center gap-4">
                                    <div class="text-[10px] font-mono-tech text-slate-500">
                                        Shipped to: <span class="text-slate-400">{{ Str::limit($order->delivery_address, 40) }}</span>
                                    </div>
                                    <a href="{{ route('order.track', ['order_number' => $order->order_number]) }}"
                                       class="px-3.5 py-1.5 border border-slate-850 hover:border-emerald-500/30 rounded-xl bg-slate-950/40 text-slate-400 hover:text-emerald-400 font-mono-tech text-[10px] uppercase font-bold tracking-wider transition">
                                        [ Track Logistics Node ]
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 border border-slate-800 border-dashed rounded-2xl select-none">
                                <p class="text-xs font-mono-tech text-slate-500 uppercase tracking-widest">// NO_PURCHASE_FILES</p>
                                <p class="text-xs text-slate-600 mt-1">You haven't initialized any purchase checkout runs yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- 2. Profile Tab -->
            <div x-show="activeSubTab === 'profile'" x-transition class="space-y-6" style="display: none;">
                
                <!-- A. Profile CRUD Card -->
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-lg font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// UPDATE_PROFILE_DIRECTORY</h2>

                    <form method="POST" action="{{ route('dashboard.profile') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Display Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Contact Phone')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $user->phone)" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Default Delivery Address')" />
                            <textarea id="address" name="address" rows="3"
                                      class="block mt-1 w-full bg-slate-950/80 border-slate-800 dark:border-slate-800/80 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 text-slate-200 text-xs shadow-sm">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="pt-2 border-t border-slate-900">
                            <x-primary-button>
                                {{ __('Update Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <!-- B. Security password change Card -->
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-lg font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// SECURITY_CREDENTIALS_REKEY</h2>

                    <form method="POST" action="{{ route('dashboard.password') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="current_password" :value="__('Current Password')" />
                            <x-text-input id="current_password" class="block mt-1 w-full" type="password" name="current_password" required />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('New Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        </div>

                        <div class="pt-2 border-t border-slate-900">
                            <x-primary-button>
                                {{ __('Update Password') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 3. Support Tickets Tab -->
            <div x-show="activeSubTab === 'support'" x-transition class="space-y-6" style="display: none;">
                
                <!-- A. Tickets list & interactive thread drawer -->
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-lg font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// SUPPORT_TICKETS_DIRECTORY</h2>

                    <div x-data="{ openTicketId: null }" class="space-y-6">
                        @forelse ($tickets as $ticket)
                            <div class="p-4 bg-slate-900/50 border border-slate-800 rounded-2xl relative space-y-4">
                                <div class="flex items-center justify-between border-b border-slate-950 pb-3">
                                    <div>
                                        <span class="text-[9px] font-mono-tech text-slate-500 block">TICKET_ID</span>
                                        <span class="text-xs font-bold text-white font-mono-tech">#{{ sprintf('%04d', $ticket->id) }} // {{ $ticket->subject }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-2 py-0.5 text-[9px] font-bold border rounded uppercase tracking-wider
                                               {{ $ticket->status === 'resolved' ? 'border-emerald-500/20 bg-emerald-500/10 text-emerald-400' : 'border-indigo-500/20 bg-indigo-500/10 text-indigo-400' }}">
                                            {{ $ticket->status }}
                                        </span>
                                        <button @click="openTicketId = (openTicketId === {{ $ticket->id }} ? null : {{ $ticket->id }})" 
                                                class="px-2.5 py-1 border border-slate-850 hover:border-slate-700 rounded-lg bg-slate-950/40 text-[9px] font-mono-tech uppercase font-bold text-slate-400 hover:text-white transition">
                                            <span x-text="openTicketId === {{ $ticket->id }} ? '[ CLOSE ]' : '[ OPEN ]'">[ OPEN ]</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Thread messages drawer inside card -->
                                <div x-show="openTicketId === {{ $ticket->id }}" x-transition class="space-y-4 pt-2">
                                    <div class="space-y-3 max-h-[200px] overflow-y-auto pr-1">
                                        @foreach ($ticket->messages as $msg)
                                            <div class="p-3 border rounded-xl text-xs space-y-1 relative overflow-hidden
                                                        {{ $msg->user_id === auth()->id() ? 'border-emerald-500/10 bg-emerald-500/5 ml-8' : 'border-slate-800 bg-slate-950/40 mr-8' }}">
                                                <div class="flex justify-between items-center text-[9px] font-mono-tech select-none">
                                                    <span class="{{ $msg->user_id === auth()->id() ? 'text-emerald-400' : 'text-slate-500' }}">
                                                        {{ $msg->user_id === auth()->id() ? '// CUSTOMER' : '// SYSTEM_ADMIN' }}
                                                    </span>
                                                    <span class="text-slate-600">{{ $msg->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-slate-300 leading-relaxed font-sans">{{ $msg->message }}</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Reply form -->
                                    @if ($ticket->status !== 'resolved')
                                        <form method="POST" action="{{ route('dashboard.tickets.reply', ['ticket' => $ticket->id]) }}" class="flex gap-2">
                                            @csrf
                                            <div class="flex-grow">
                                                <x-text-input name="message" class="block w-full py-2 font-mono-tech text-xs" required placeholder="Type reply message..." />
                                            </div>
                                            <x-primary-button class="py-2 px-4 select-none shrink-0 font-mono-tech text-[10px]">
                                                Reply
                                            </x-primary-button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 border border-slate-800 border-dashed rounded-2xl select-none">
                                <p class="text-xs font-mono-tech text-slate-500 uppercase tracking-widest">// NO_TICKET_FILES</p>
                                <p class="text-xs text-slate-600 mt-1">There are no open customer support threads logged.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- B. Open Support Ticket Card -->
                <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
                    <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>
                    <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] pointer-events-none">+</div>

                    <h2 class="text-lg font-bold text-white uppercase tracking-wider font-mono-tech mb-6 select-none">// CREATE_NEW_TICKET_THREAD</h2>

                    <form method="POST" action="{{ route('dashboard.tickets') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="subject" :value="__('Ticket Subject')" />
                            <x-text-input id="subject" class="block mt-1 w-full" type="text" name="subject" required placeholder="e.g. Inquiry regarding order ORD-XXXXXXXXX" />
                        </div>

                        <div>
                            <x-input-label for="message" :value="__('Message description')" />
                            <textarea id="message" name="message" rows="3" required placeholder="Provide a detailed request..."
                                      class="block mt-1 w-full bg-slate-950/80 border-slate-800 dark:border-slate-800/80 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 text-slate-200 text-xs shadow-sm"></textarea>
                        </div>

                        <div class="pt-2 border-t border-slate-900">
                            <x-primary-button>
                                {{ __('Submit Ticket') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-store-layout>
