<x-store-layout>
    <div class="max-w-3xl mx-auto space-y-10 py-6">
        
        <!-- 1. Search Bar HUD -->
        <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
            <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
            <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

            <div class="mb-6 text-center sm:text-left select-none">
                <span class="inline-block px-3 py-1 font-mono-tech text-[9px] font-bold tracking-widest text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-lg uppercase">
                    // SHIPMENT_TRACKING_INTERFACE
                </span>
                <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2">Track Your Package Node</h2>
                <p class="text-xs text-slate-500 mt-1">Enter your custom tracking reference code to inspect real-time logistics logs.</p>
            </div>

            <form method="GET" x-data="{ code: '{{ request()->segment(3) ?? '' }}' }" :action="'/order/track/' + code" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-grow">
                    <x-text-input x-model="code" class="block w-full text-center sm:text-left font-mono-tech text-sm tracking-wider" placeholder="ORD-XXXXXXXXXX" required />
                </div>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold font-mono-tech text-xs uppercase tracking-wider rounded-xl shadow-lg transition">
                    [ Query Node ]
                </button>
            </form>
        </div>

        <!-- 2. Track Details HUD (If $order exists) -->
        @if (isset($order))
            <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative space-y-8">
                <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
                <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

                <!-- Header info -->
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-900 pb-5 select-none">
                    <div>
                        <span class="text-[9px] font-mono-tech text-slate-500 block">TRACKING_REFERENCE</span>
                        <span class="text-sm font-bold text-white font-mono-tech">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex items-center gap-3 font-mono-tech">
                        <div>
                            <span class="text-[9px] text-slate-500 block text-right">ACTIVE_STATUS</span>
                            <span class="px-2.5 py-0.5 text-[10px] font-bold border rounded uppercase tracking-wider
                                   {{ in_array($order->status, ['paid', 'processing', 'shipped', 'delivered']) ? 'border-emerald-500/20 bg-emerald-500/10 text-emerald-400' : 'border-rose-500/20 bg-rose-500/10 text-rose-400' }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Timeline HUD -->
                <div class="space-y-6">
                    <h3 class="text-xs font-bold text-slate-400 font-mono-tech uppercase tracking-wider select-none">// LOGISTICS_ACTIVE_TIMELINE</h3>
                    
                    <div class="relative pl-8 space-y-8 select-none">
                        <!-- Connecting Line -->
                        <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-slate-800"></div>

                        @php
                            $steps = [
                                'pending' => ['label' => 'Order Placed', 'desc' => 'Stock hold requested and awaiting system confirm.'],
                                'paid' => ['label' => 'Payment Secured', 'desc' => 'Paystack/Flutterwave merchant callback verified.'],
                                'processing' => ['label' => 'System Processing', 'desc' => 'Order is being packaged at the logistics warehouse node.'],
                                'shipped' => ['label' => 'In Transit', 'desc' => 'Package has left the main bay. Shipping courier is on route.'],
                                'delivered' => ['label' => 'Delivered Successfully', 'desc' => 'Logistics node successfully completed. Thank you!'],
                            ];

                            $currentStatus = $order->status;
                            $statusKeys = array_keys($steps);
                            $currentIndex = array_search($currentStatus, $statusKeys);
                            
                            // If failed or cancelled, inject custom alerts
                            if ($currentStatus === 'cancelled') {
                                $steps['cancelled'] = ['label' => 'System Terminated', 'desc' => 'This order has been cancelled. Stock returned.'];
                                $currentIndex = 4; // activate all preceding as red/grey
                            } elseif ($currentStatus === 'failed_payment') {
                                $steps['failed_payment'] = ['label' => 'Payment Node Terminated', 'desc' => 'Secure checkout payment failed. Awaiting rerun.'];
                                $currentIndex = 4;
                            }
                        @endphp

                        @foreach ($steps as $key => $step)
                            @php
                                $index = array_search($key, $statusKeys);
                                $isActive = ($index !== false && $index <= $currentIndex);
                                $isCurrent = ($currentStatus === $key);
                                
                                // Color logic
                                $nodeClass = 'border-slate-800 bg-slate-950 text-slate-600';
                                if ($isActive) {
                                    $nodeClass = 'border-emerald-500 bg-emerald-950 text-emerald-400 shadow-[0_0_10px_rgba(16,185,129,0.2)]';
                                }
                                if ($isCurrent) {
                                    $nodeClass = 'border-emerald-400 bg-emerald-500 text-slate-950 shadow-[0_0_15px_rgba(16,185,129,0.4)] animate-pulse';
                                }
                                if ($currentStatus === 'cancelled' && $key === 'cancelled') {
                                    $nodeClass = 'border-rose-500 bg-rose-950 text-rose-400';
                                }
                                if ($currentStatus === 'failed_payment' && $key === 'failed_payment') {
                                    $nodeClass = 'border-rose-500 bg-rose-950 text-rose-400';
                                }
                            @endphp

                            <div class="relative">
                                <!-- Bullet Dot -->
                                <div class="absolute -left-[30px] top-1.5 w-6 h-6 rounded-full border-2 flex items-center justify-center text-[10px] font-bold transition duration-300 {{ $nodeClass }}">
                                    @if ($isActive && !$isCurrent)
                                        ✓
                                    @else
                                        •
                                    @endif
                                </div>

                                <!-- Text -->
                                <div>
                                    <h4 class="text-xs font-bold font-mono-tech transition duration-300 {{ $isActive ? 'text-white' : 'text-slate-500' }}">
                                        {{ $step['label'] }}
                                    </h4>
                                    <p class="text-[11px] mt-0.5 leading-relaxed transition duration-300 {{ $isActive ? 'text-slate-400' : 'text-slate-600' }}">
                                        {{ $step['desc'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Package components summary -->
                <div class="pt-6 border-t border-slate-900 space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 font-mono-tech uppercase tracking-wider select-none">// SYSTEM_MANIFEST</h4>
                    <div class="space-y-3">
                        @foreach ($order->items as $item)
                            <div class="flex items-center justify-between text-xs font-mono-tech select-none">
                                <span class="text-slate-400">{{ $item->product->name }} (x{{ $item->quantity }})</span>
                                <span class="text-slate-500">${{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-store-layout>
