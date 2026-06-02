<x-store-layout>
    <div class="max-w-2xl mx-auto text-center space-y-8 py-8 relative">
        
        <!-- Glowing Success indicator -->
        <div class="relative flex h-20 w-20 items-center justify-center rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mx-auto shadow-lg select-none">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <div class="absolute top-0.5 left-0.5 w-1.5 h-1.5 bg-emerald-400/40 rounded-full"></div>
        </div>

        <div class="space-y-3">
            <span class="inline-block px-3 py-1 font-mono-tech text-[10px] font-bold tracking-widest text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-lg uppercase select-none">
                TRANSACTION_COMPLETED
            </span>
            <h1 class="text-3xl font-black text-white tracking-tight leading-tight select-none">Order Confirmed Securely!</h1>
            <p class="text-xs text-slate-400 max-w-md mx-auto leading-relaxed select-none">
                Your payment was processed successfully. The order has been locked, stock permanently reserved, and the warehouse notified for immediate processing.
            </p>
        </div>

        <!-- Order details card -->
        <div class="bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 text-left relative space-y-6">
            <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
            <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

            <div class="flex items-center justify-between border-b border-slate-900 pb-4 select-none">
                <div>
                    <span class="text-[9px] font-mono-tech text-slate-500 block">ORDER_NUMBER</span>
                    <span class="text-sm font-bold text-white font-mono-tech">{{ $order->order_number }}</span>
                </div>
                <div class="text-right">
                    <span class="text-[9px] font-mono-tech text-slate-500 block">TRANSACTION_DATE</span>
                    <span class="text-xs font-mono-tech text-slate-300">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                </div>
            </div>

            <!-- Items list -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-slate-400 font-mono-tech uppercase tracking-wider select-none">// DISPATCHED_ITEMS</h4>
                @foreach ($order->items as $item)
                    <div class="flex items-center justify-between gap-4 py-2 border-b border-slate-900 select-none">
                        <div class="flex items-center gap-3">
                            <img src="{{ $item->product->primary_image }}" alt="{{ $item->product->name }}" class="w-10 h-10 object-cover rounded bg-slate-950 border border-slate-850" />
                            <div>
                                <h4 class="text-xs font-bold text-white truncate max-w-[200px]">{{ $item->product->name }}</h4>
                                <span class="text-[9px] font-mono-tech text-slate-500 uppercase">Qty: {{ $item->quantity }} // Color: {{ $item->product->color }}</span>
                            </div>
                        </div>
                        <span class="text-xs font-mono-tech font-bold text-slate-300">${{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Cost Breakdown -->
            <div class="space-y-2.5 font-mono-tech text-xs pt-4 select-none">
                <div class="flex justify-between">
                    <span class="text-slate-500">SUBTOTAL</span>
                    <span class="text-slate-300">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">DELIVERY CHARGE</span>
                    <span class="text-slate-300">
                        @if ($order->delivery_fee == 0.00)
                            <span class="text-emerald-400">FREE</span>
                        @else
                            ${{ number_format($order->delivery_fee, 2) }}
                        @endif
                    </span>
                </div>
                <div class="flex justify-between text-sm font-bold text-white pt-2.5 border-t border-slate-900">
                    <span>GRAND TOTAL CAPTURED</span>
                    <span class="text-emerald-400">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Delivery address -->
            <div class="pt-6 border-t border-slate-900 space-y-2 text-xs">
                <h4 class="font-bold text-slate-400 font-mono-tech uppercase tracking-wider select-none">// SHIPPING_NODE</h4>
                <p class="text-slate-300 leading-relaxed font-mono-tech text-[11px]">{{ $order->delivery_address }}</p>
                <p class="text-slate-500 font-mono-tech text-[10px] uppercase">Phone node: {{ $order->phone }}</p>
            </div>
        </div>

        @if (is_null($order->user_id))
            <!-- Guest Order Claim Banner -->
            <div class="bg-gradient-to-r from-emerald-950/20 to-teal-950/20 border border-emerald-500/30 rounded-3xl p-6 sm:p-8 text-left relative overflow-hidden shadow-emerald-950/20 shadow-2xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute top-1.5 left-1.5 text-emerald-500/40 font-mono text-[9px] select-none pointer-events-none">+</div>
                <div class="absolute bottom-1.5 right-1.5 text-emerald-500/40 font-mono text-[9px] select-none pointer-events-none">+</div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 relative">
                    <div class="space-y-2">
                        <span class="inline-block px-2.5 py-0.5 font-mono-tech text-[9px] font-bold tracking-widest text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-md uppercase select-none">
                            // CLAIM_ORDER_PROTOCOL
                        </span>
                        <h3 class="text-lg font-bold text-white tracking-tight">Claim this Order & Create Account</h3>
                        <p class="text-xs text-slate-400 max-w-md leading-relaxed">
                            Verify your email <strong class="text-emerald-400 font-mono-tech">{{ $order->email }}</strong> via OTP to link your order history and set up a secure password to track shipments anytime.
                        </p>
                    </div>
                    <div class="shrink-0 font-mono-tech">
                        <form method="POST" action="{{ route('order.claim') }}">
                            @csrf
                            <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                            <button type="submit" 
                                    class="w-full sm:w-auto px-6 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold font-mono-tech text-xs uppercase tracking-wider rounded-xl shadow-lg transition">
                                [ Claim Account & Verify ]
                            </button>
                        </form>
                    </div>
                </div>
                @if ($errors->has('claim'))
                    <div class="mt-4 p-3 bg-red-950/20 border border-red-500/20 rounded-xl text-xs text-red-400 font-mono-tech">
                        {{ $errors->first('claim') }}
                    </div>
                @endif
            </div>
        @endif

        <!-- Action options -->
        <div class="flex flex-wrap gap-4 justify-center font-mono-tech text-xs uppercase pt-4">
            <a href="{{ route('order.track', ['order_number' => $order->order_number]) }}" 
               class="px-5 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold rounded-xl shadow-lg transition">
                [ Track Shipment Node ]
            </a>
            <a href="{{ route('home') }}" 
               class="px-5 py-3 bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 font-bold rounded-xl transition">
                Return to Storefront
            </a>
        </div>
    </div>
</x-store-layout>
