<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secure Gateway Processing - {{ $gateway }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-4">

    <!-- Glowing technical frame background -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="w-full h-full bg-tech-squares-dark opacity-10"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/5 blur-[120px] rounded-full"></div>
    </div>

    <!-- Simulated Gateway Container -->
    <div class="relative z-10 w-full max-w-md bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
        <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
        <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

        <!-- Header -->
        <div class="text-center pb-6 border-b border-slate-800/80">
            <div class="flex items-center justify-center gap-2 mb-2 select-none">
                <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 animate-pulse shrink-0"></span>
                <span class="font-mono-tech text-[10px] font-bold tracking-widest text-indigo-400 uppercase">// SECURE_MERCHANT_GATEWAY</span>
            </div>
            
            <h1 class="text-2xl font-black tracking-tight text-white uppercase">{{ $gateway }} Checkout</h1>
            <p class="text-xs text-slate-500 mt-1 select-none">Processing merchant secure checkout protocols.</p>
        </div>

        <!-- Transaction Specs -->
        <div class="py-6 border-b border-slate-800/80 space-y-4">
            <div class="p-4 bg-slate-950 border border-slate-800/80 rounded-2xl select-none">
                <div class="flex justify-between items-center text-xs font-mono-tech">
                    <span class="text-slate-500">ORDER_REF</span>
                    <span class="text-slate-300 font-bold">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between items-center text-xs font-mono-tech mt-2">
                    <span class="text-slate-500">CUSTOMER_EMAIL</span>
                    <span class="text-slate-300 truncate max-w-[200px]">{{ $order->email }}</span>
                </div>
            </div>

            <div class="flex items-center justify-between font-mono-tech">
                <span class="text-xs text-slate-500 select-none">PAYMENT_GRAND_TOTAL</span>
                <span class="text-xl font-black text-emerald-400">${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        <!-- Simulated Card details inputs -->
        <div class="py-6 space-y-4 select-none">
            <h3 class="text-xs font-bold text-slate-400 font-mono-tech uppercase tracking-wider">// ENTER_SECURE_CARD_CREDENTIALS</h3>
            
            <div class="space-y-3">
                <div>
                    <label class="block text-[10px] font-mono-tech text-slate-500 uppercase mb-1">Card Holder Name</label>
                    <input type="text" disabled value="TEST CUSTOMER" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-400 font-mono-tech outline-none" />
                </div>

                <div>
                    <label class="block text-[10px] font-mono-tech text-slate-500 uppercase mb-1">Card Number</label>
                    <input type="text" disabled value="**** **** **** 1883" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-400 font-mono-tech tracking-wider outline-none" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-mono-tech text-slate-500 uppercase mb-1">Expiry Date</label>
                        <input type="text" disabled value="12 / 30" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-400 font-mono-tech text-center outline-none" />
                    </div>
                    <div>
                        <label class="block text-[10px] font-mono-tech text-slate-500 uppercase mb-1">CVV Code</label>
                        <input type="text" disabled value="***" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-400 font-mono-tech text-center outline-none" />
                    </div>
                </div>
            </div>
        </div>

        <!-- simulated Actions -->
        <div class="pt-6 border-t border-slate-800/80 space-y-3">
            <a href="{{ $callbackUrl }}&status=success" 
               class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold font-mono-tech text-xs uppercase tracking-wider rounded-xl shadow-lg transition flex items-center justify-center">
                [ Authorize Secure Transaction ]
            </a>

            <a href="{{ $callbackUrl }}&status=failed" 
               class="w-full py-3 border border-slate-800 hover:border-rose-500/40 bg-slate-950/40 text-slate-500 hover:text-rose-500 font-mono-tech text-xs uppercase tracking-wider rounded-xl transition flex items-center justify-center">
                [ Simulate Transaction Error ]
            </a>
            
            <span class="block text-center text-[9px] font-mono-tech text-slate-600 uppercase tracking-wider select-none">
                Verified secure by Merchant digital sign node
            </span>
        </div>
    </div>
</body>
</html>
