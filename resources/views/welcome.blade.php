<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shoper | Technical Grid Property Management Platform</title>
    <meta name="description" content="Manage rent, tenants, and maintenance through a high-performance interactive property management system.">

    <!-- Fonts: Inter and JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Inline script to prevent theme flickering on page load -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .font-mono-tech {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 antialiased transition-colors duration-300 min-h-screen flex flex-col relative">

    <!-- Reusable Connected Tiny Squares Mesh Background -->
    <x-tech-squares />

    <!-- Decoupled Sticky Technical Grid Navbar -->
    <x-navbar />

    <!-- Main Tech Grid Workspace -->
    <main class="flex-grow">

        <!-- SECTION: HERO & CORE HUDS -->
        <section class="relative border-b border-slate-200 dark:border-slate-800/60 overflow-hidden">
            <!-- Grid Lines Background -->
            <div class="absolute inset-0 flex pointer-events-none z-0">
                <div class="w-1/4 h-full border-r border-slate-200/50 dark:border-slate-900/40 hidden md:block"></div>
                <div class="w-1/4 h-full border-r border-slate-200/50 dark:border-slate-900/40 hidden md:block"></div>
                <div class="w-1/4 h-full border-r border-slate-200/50 dark:border-slate-900/40 hidden md:block"></div>
                <div class="w-1/4 h-full hidden md:block"></div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 border-l border-r border-slate-200/60 dark:border-slate-800/40 relative z-10 py-16 lg:py-24">
                
                <!-- Corner grid plus markers -->
                <div class="absolute -top-1.5 -left-1.5 text-slate-400 dark:text-slate-600 font-mono text-xs select-none pointer-events-none">+</div>
                <div class="absolute -top-1.5 -right-1.5 text-slate-400 dark:text-slate-600 font-mono text-xs select-none pointer-events-none">+</div>
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left: Technical Title & CTA -->
                    <div class="lg:col-span-7 space-y-6 fade-up-element" id="hero-left">
                        <div class="inline-flex items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-500/10 px-3 py-1.5 text-xs font-mono-tech text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">
                            <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                            SYS_STATUS // ACTIVE_RUNNING
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-[1.1]">
                            The Technical Grid for Modern <span class="bg-gradient-to-r from-emerald-500 to-teal-400 bg-clip-text text-transparent">Property Operations.</span>
                        </h1>

                        <p class="max-w-xl text-base sm:text-lg leading-relaxed text-slate-500 dark:text-slate-400">
                            Say goodbye to scattered spreadsheets. Hausify coordinates rent, tenants, lease registers, and maintenance tickets in an automated, highly-structured layout. Built for property developers, landlords, and managers who value efficiency.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 pt-2">
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-500 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-emerald-500/25 hover:bg-emerald-400 transition-all duration-200 group font-mono-tech">
                                CREATE_INSTANCE &rarr;
                            </a>
                            <a href="#features" class="inline-flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-800 bg-white/60 dark:bg-slate-900/40 px-6 py-3.5 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition duration-200 font-mono-tech">
                                LEARN_MORE //
                            </a>
                        </div>

                        <!-- System metrics inline blocks -->
                        <div class="grid grid-cols-3 gap-4 pt-6 border-t border-slate-200 dark:border-slate-800/80 max-w-xl">
                            <div class="rounded-lg border border-slate-200 dark:border-slate-800/60 bg-white/40 dark:bg-slate-900/10 p-3.5">
                                <div class="text-[10px] font-mono-tech uppercase text-slate-400 dark:text-slate-500">// UPTIME</div>
                                <div class="text-xl font-bold font-mono-tech text-slate-800 dark:text-white mt-1">99.98%</div>
                            </div>
                            <div class="rounded-lg border border-slate-200 dark:border-slate-800/60 bg-white/40 dark:bg-slate-900/10 p-3.5">
                                <div class="text-[10px] font-mono-tech uppercase text-slate-400 dark:text-slate-500">// INVOICES</div>
                                <div class="text-xl font-bold font-mono-tech text-slate-800 dark:text-white mt-1">1.2 SEC</div>
                            </div>
                            <div class="rounded-lg border border-slate-200 dark:border-slate-800/60 bg-white/40 dark:bg-slate-900/10 p-3.5">
                                <div class="text-[10px] font-mono-tech uppercase text-slate-400 dark:text-slate-500">// INTEGRITY</div>
                                <div class="text-xl font-bold font-mono-tech text-emerald-500 dark:text-emerald-400 mt-1">SECURE</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Stunning Interactive Portal Mockup (Interactive Section 1) -->
                    <div class="lg:col-span-5 relative fade-up-element" id="hero-right-interactive"
                         x-data="{ 
                            tenantName: 'Sarah Jenkins', 
                            unit: 'Unit B-04', 
                            rentPaid: true,
                            balance: 0,
                            logs: [
                                'LOG: Initialized Tenant Terminal B-04',
                                'LOG: Payment schedule synced with Mainnet',
                            ],
                            payRent() {
                                if(this.rentPaid) return;
                                this.rentPaid = true;
                                this.balance = 0;
                                this.logs.push('SYS_EVENT: Payment of ₦350,000 received');
                                this.logs.push('SMS_QUEUE: Receipt dispatched to tenant');
                            },
                            reportLeak() {
                                this.logs.push('TKT_NEW: Maintenance reported [Water Leak in Bath]');
                                this.logs.push('SYSops: Alert dispatched to Plumber [Auto-Routing]');
                                alert('Interactive Demo: Maintenance Ticket successfully created and routed to plumber!');
                            },
                            resetDemo() {
                                this.rentPaid = false;
                                this.balance = 350000;
                                this.logs.push('SYS_EVENT: Demo reset. Tenant invoice generated.');
                            }
                         }"
                    >
                        <!-- Neon ambient glow -->
                        <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-emerald-500 to-indigo-500 opacity-20 blur-xl"></div>
                        
                        <!-- Main container -->
                        <div class="relative rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-xl transition-all duration-300">
                            <!-- Technical Grid header line -->
                            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-3 mb-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                </div>
                                <span class="font-mono-tech text-[10px] text-slate-400 dark:text-slate-500">LIVE_TENANT_PORTAL_MOCK //</span>
                            </div>

                            <div class="space-y-4">
                                <!-- Tenant details block -->
                                <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span class="font-mono-tech text-[9px] text-slate-400 dark:text-slate-500">// ASSIGNED_USER</span>
                                            <h3 class="font-bold text-slate-900 dark:text-white" x-text="tenantName">Sarah Jenkins</h3>
                                            <p class="text-xs text-slate-400 dark:text-slate-500" x-text="unit">Unit B-04</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-mono-tech text-[9px] text-slate-400 dark:text-slate-500">// INVOICE_STATUS</span>
                                            <div class="mt-1">
                                                <span x-show="rentPaid" class="rounded bg-emerald-500/10 px-2 py-0.5 text-xs font-mono-tech text-emerald-500">PAID</span>
                                                <span x-show="!rentPaid" class="rounded bg-rose-500/10 px-2 py-0.5 text-xs font-mono-tech text-rose-500">UNPAID</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-800/80 flex justify-between items-center">
                                        <div>
                                            <span class="text-xs text-slate-400 dark:text-slate-500">Outstanding Balance:</span>
                                            <div class="text-lg font-black font-mono-tech text-slate-900 dark:text-white" x-text="rentPaid ? '₦0' : '₦350,000'">₦0</div>
                                        </div>
                                        <div>
                                            <button 
                                                @click="payRent()"
                                                :class="rentPaid ? 'bg-slate-200 dark:bg-slate-800 text-slate-400 cursor-not-allowed' : 'bg-emerald-500 hover:bg-emerald-400 text-white shadow-lg shadow-emerald-500/20'"
                                                class="rounded-lg px-3.5 py-1.5 text-xs font-semibold transition"
                                                x-text="rentPaid ? 'Rent Settled' : 'Pay Rent'"
                                            >
                                                Rent Settled
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Triggers -->
                                <div class="grid grid-cols-2 gap-3">
                                    <button 
                                        @click="reportLeak()"
                                        class="rounded-lg border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 p-3 text-center transition"
                                    >
                                        <span class="block text-xs font-bold text-slate-800 dark:text-white">Report Leak</span>
                                        <span class="font-mono-tech text-[9px] text-rose-400 uppercase mt-1 inline-block">[ Maint Ticket ]</span>
                                    </button>
                                    <button 
                                        @click="resetDemo()"
                                        class="rounded-lg border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 p-3 text-center transition"
                                    >
                                        <span class="block text-xs font-bold text-slate-800 dark:text-white">Regen Invoice</span>
                                        <span class="font-mono-tech text-[9px] text-amber-500 uppercase mt-1 inline-block">[ Unpay Demo ]</span>
                                    </button>
                                </div>

                                <!-- Terminal outputs logs -->
                                <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-950 p-3">
                                    <div class="flex items-center justify-between border-b border-slate-800 pb-2 mb-2">
                                        <span class="font-mono-tech text-[9px] text-emerald-400">TERMINAL_OUTPUT // SYSTEM_BUS</span>
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    </div>
                                    <div class="h-24 overflow-y-auto space-y-1 text-[10px] font-mono-tech text-slate-400 scrollbar-thin">
                                        <template x-for="(log, idx) in logs" :key="idx">
                                            <div class="truncate">
                                                <span class="text-emerald-500">&gt;</span> <span x-text="log"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- SECTION: INTERACTIVE RENT CALCULATOR (Interactive Section 2) -->
        <section class="relative border-b border-slate-200 dark:border-slate-800/60 overflow-hidden py-20 bg-slate-100/30 dark:bg-slate-950/20 transition-colors duration-300">
            <!-- Intersecting corners -->
            <div class="absolute -bottom-1.5 -left-1.5 text-slate-400 dark:text-slate-600 font-mono text-xs select-none pointer-events-none">+</div>
            <div class="absolute -bottom-1.5 -right-1.5 text-slate-400 dark:text-slate-600 font-mono text-xs select-none pointer-events-none">+</div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 border-l border-r border-slate-200/60 dark:border-slate-800/40 relative z-10">
                <div class="max-w-3xl mx-auto text-center mb-16 fade-up-element">
                    <span class="font-mono-tech text-xs uppercase tracking-widest text-emerald-500">// LIVE_OPS_CALCULATOR</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white mt-3">
                        Calculate Your Savings & Revenues
                    </h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-4 max-w-xl mx-auto">
                        Tweak the sliders to immediately estimate your monthly returns, service costs, and savings compared to traditional agent commissions.
                    </p>
                </div>

                <!-- Calculator widget container grid -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch fade-up-element"
                     x-data="{
                        units: 12,
                        rent: 250000,
                        get totalMonthly() { return this.units * this.rent },
                        get fee() { return Math.round(this.totalMonthly * 0.015) },
                        get revenue() { return this.totalMonthly - this.fee },
                        get agencyComm() { return Math.round(this.totalMonthly * 0.10) },
                        get savings() { return this.agencyComm - this.fee },
                        formatCurrency(num) {
                            return '₦' + num.toLocaleString('en-US');
                        }
                     }"
                >
                    <!-- Sliders panel -->
                    <div class="lg:col-span-7 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 sm:p-8 flex flex-col justify-between shadow-md">
                        <div>
                            <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-6 border-b border-slate-100 dark:border-slate-800 pb-3">// Parameters</h3>
                            
                            <!-- Slider 1: Units -->
                            <div class="space-y-3 mb-8">
                                <div class="flex justify-between items-center">
                                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Managed Property Units</label>
                                    <span class="font-mono-tech text-emerald-500 font-bold bg-emerald-500/10 px-2.5 py-0.5 rounded text-sm" x-text="units + ' units'">12 units</span>
                                </div>
                                <input 
                                    type="range" 
                                    min="1" 
                                    max="200" 
                                    step="1" 
                                    x-model="units"
                                    class="w-full h-1.5 bg-slate-200 dark:bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-500"
                                >
                                <div class="flex justify-between text-[10px] text-slate-400 dark:text-slate-500 font-mono-tech">
                                    <span>1 UNIT</span>
                                    <span>100 UNITS</span>
                                    <span>200 UNITS</span>
                                </div>
                            </div>

                            <!-- Slider 2: Rent -->
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Average Unit Rent (Monthly)</label>
                                    <span class="font-mono-tech text-emerald-500 font-bold bg-emerald-500/10 px-2.5 py-0.5 rounded text-sm" x-text="formatCurrency(parseInt(rent))">₦250,000</span>
                                </div>
                                <input 
                                    type="range" 
                                    min="15000" 
                                    max="1000000" 
                                    step="5000" 
                                    x-model="rent"
                                    class="w-full h-1.5 bg-slate-200 dark:bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-500"
                                >
                                <div class="flex justify-between text-[10px] text-slate-400 dark:text-slate-500 font-mono-tech">
                                    <span>₦15K</span>
                                    <span>₦500K</span>
                                    <span>₦1.0M</span>
                                </div>
                            </div>
                        </div>

                        <!-- SAVINGS SHIELD TAG -->
                        <div class="mt-8 rounded-xl border border-emerald-500/20 bg-emerald-500/5 p-4 flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-500 font-black">✔</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Hausify Standard 1.5% System Fee</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Save thousands of Naira in comparison to traditional agencies charging 8% to 15%.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Readings panel -->
                    <div class="lg:col-span-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-900 dark:bg-slate-950 text-white p-6 sm:p-8 flex flex-col justify-between shadow-xl relative overflow-hidden">
                        <!-- Technical layout glow line -->
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-indigo-500"></div>

                        <div class="space-y-6">
                            <span class="font-mono-tech text-[10px] text-slate-500 tracking-widest block uppercase">// LEDGER_PROJECTIONS</span>
                            
                            <div>
                                <div class="text-xs text-slate-400">Est. Total Monthly Inflow:</div>
                                <div class="text-3xl font-black font-mono-tech text-white mt-1" x-text="formatCurrency(totalMonthly)">₦3,000,000</div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 border-t border-slate-800 pt-4">
                                <div>
                                    <div class="text-[10px] text-slate-400 uppercase font-mono-tech">// Hausify Fee (1.5%)</div>
                                    <div class="text-lg font-bold font-mono-tech text-emerald-400 mt-1" x-text="formatCurrency(fee)">₦45,000</div>
                                </div>
                                <div>
                                    <div class="text-[10px] text-slate-400 uppercase font-mono-tech">// Net Landlord Return</div>
                                    <div class="text-lg font-bold font-mono-tech text-white mt-1" x-text="formatCurrency(revenue)">₦2,955,000</div>
                                </div>
                            </div>

                            <div class="border-t border-slate-800 pt-4 bg-slate-950/80 -mx-6 px-6 -mb-6 pb-6 rounded-b-2xl">
                                <div class="text-[10px] text-slate-400 uppercase font-mono-tech">// Save Compared to Traditional Managers (10%)</div>
                                <div class="text-2xl font-black font-mono-tech text-emerald-400 mt-2 flex items-center gap-2" x-text="formatCurrency(savings)">
                                    ₦255,000
                                </div>
                                <span class="text-[10px] text-emerald-400/80 font-mono-tech tracking-wider block mt-1">SAVINGS_RETENTION: ACTIVE</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- SECTION: FEATURE GRID -->
        <section id="features" class="relative border-b border-slate-200 dark:border-slate-800/60 py-20 transition-colors duration-300">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 border-l border-r border-slate-200/60 dark:border-slate-800/40 relative z-10">
                <div class="max-w-2xl mb-12 fade-up-element">
                    <span class="font-mono-tech text-xs uppercase tracking-widest text-emerald-500">// MODULES_CATALOG</span>
                    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white mt-2 sm:text-4xl">Everything required to pilot property operations.</h2>
                    <p class="mt-4 text-slate-500 dark:text-slate-400">
                        Consolidate rent cycles, lease registries, tenant communications, and service repairs under a highly organized technological blueprint.
                    </p>
                </div>

                <!-- 2x2 Tech Grid featuring thin borders and corner crosses -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-px bg-slate-200 dark:bg-slate-800/60 rounded-xl overflow-hidden shadow-sm">
                    <!-- Card 1 -->
                    <div class="bg-white dark:bg-slate-950 p-8 hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-all duration-300 relative group border-glow-emerald-hover">
                        <!-- Corner Crosshairs -->
                        <div class="absolute top-2 left-2 text-[9px] text-slate-300 dark:text-slate-800 font-mono select-none pointer-events-none">+</div>
                        <div class="absolute bottom-2 right-2 text-[9px] text-slate-300 dark:text-slate-800 font-mono select-none pointer-events-none">+</div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-mono-tech text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded uppercase tracking-wider">// RENT_MODULE</span>
                            <span class="font-mono-tech text-slate-300 dark:text-slate-700 text-lg font-black group-hover:text-emerald-500 transition-colors">01</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Algorithmic Rent Tracking</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                            Track tenant billing dates, invoices, and deposits automatically. Instantly sync ledger receipts and dispatch automated SMS/Email reminders to outstanding units.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white dark:bg-slate-950 p-8 hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-all duration-300 relative group border-glow-emerald-hover">
                        <!-- Corner Crosshairs -->
                        <div class="absolute top-2 left-2 text-[9px] text-slate-300 dark:text-slate-800 font-mono select-none pointer-events-none">+</div>
                        <div class="absolute bottom-2 right-2 text-[9px] text-slate-300 dark:text-slate-800 font-mono select-none pointer-events-none">+</div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-mono-tech text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded uppercase tracking-wider">// TENANT_REG</span>
                            <span class="font-mono-tech text-slate-300 dark:text-slate-700 text-lg font-black group-hover:text-emerald-500 transition-colors">02</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Tenant Registry & Leases</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                            Store unified tenant profile cards, emergency contacts, lease agreements, and tenancy histories. Seamlessly assign properties and units in seconds.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white dark:bg-slate-950 p-8 hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-all duration-300 relative group border-glow-emerald-hover">
                        <!-- Corner Crosshairs -->
                        <div class="absolute top-2 left-2 text-[9px] text-slate-300 dark:text-slate-800 font-mono select-none pointer-events-none">+</div>
                        <div class="absolute bottom-2 right-2 text-[9px] text-slate-300 dark:text-slate-800 font-mono select-none pointer-events-none">+</div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-mono-tech text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded uppercase tracking-wider">// TECH_TICKET</span>
                            <span class="font-mono-tech text-slate-300 dark:text-slate-700 text-lg font-black group-hover:text-emerald-500 transition-colors">03</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Maintenance Operations</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                            Empower tenants to lodge digital maintenance tickets with photos. Auto-route requests to plumbers or electricians, and track completion status in real-time.
                        </p>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white dark:bg-slate-950 p-8 hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-all duration-300 relative group border-glow-emerald-hover">
                        <!-- Corner Crosshairs -->
                        <div class="absolute top-2 left-2 text-[9px] text-slate-300 dark:text-slate-800 font-mono select-none pointer-events-none">+</div>
                        <div class="absolute bottom-2 right-2 text-[9px] text-slate-300 dark:text-slate-800 font-mono select-none pointer-events-none">+</div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-mono-tech text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded uppercase tracking-wider">// PAY_SYS</span>
                            <span class="font-mono-tech text-slate-300 dark:text-slate-700 text-lg font-black group-hover:text-emerald-500 transition-colors">04</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Automated Bank Receipts</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                            Support instant payments and card gateways. Let tenants verify their payments on-demand, updating landlord income ledgers without manual audits.
                        </p>
                    </div>
                </div>
            </div>
        </section>


        <!-- SECTION: LIVE STATS TICKER & LOGS (Interactive Section 3) -->
        <section class="relative border-b border-slate-200 dark:border-slate-800/60 py-20 bg-slate-100/10 dark:bg-slate-950/40 transition-colors duration-300">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 border-l border-r border-slate-200/60 dark:border-slate-800/40 relative z-10">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left: Scrolling Tech System Log Ticker -->
                    <div class="lg:col-span-5 space-y-6 fade-up-element"
                         x-data="{
                            logQueue: [
                                '[17:32:01] DB_SYS: Synchronized tenant database with Mainnet.',
                                '[17:32:15] INV-8829: Tenant John Obi paid rent for Unit C-09.',
                                '[17:32:45] TKT-0128: Leak issue resolved in Unit A-02.',
                                '[17:33:10] SYS_NOTIF: Automated invoice reminders sent to 3 units.',
                                '[17:33:45] GATEWAY: Paystack API heartbeat OK.',
                            ],
                            newLogOptions: [
                                'INV-9011: Tenant Cynthia Adams paid rent for Unit E-03.',
                                'TKT-0133: Leak ticket created for Unit A-04.',
                                'GATEWAY: Received bank webhook confirmation.',
                                'DB_SYS: Swept overdue invoices, updated 2 ledgers.',
                                'SMS_QUEUE: Dispatched rent invoice link to Unit D-12.',
                            ],
                            init() {
                                setInterval(() => {
                                    let rand = this.newLogOptions[Math.floor(Math.random() * this.newLogOptions.length)];
                                    let now = new Date();
                                    let timeStr = '[' + now.toTimeString().split(' ')[0] + '] ';
                                    this.logQueue.push(timeStr + rand);
                                    if(this.logQueue.length > 8) {
                                        this.logQueue.shift();
                                    }
                                }, 3500);
                            }
                         }"
                    >
                        <div>
                            <span class="font-mono-tech text-xs uppercase tracking-widest text-emerald-500">// LIVE_LOGS_STREAM</span>
                            <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white mt-2">SysOps Activity Stream</h2>
                            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                                Watch real-time platform triggers. Hausify's automation engine is running continuously in the background to handle invoice processing and communications.
                            </p>
                        </div>

                        <!-- Real-time Terminal Window -->
                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-950 p-5 shadow-lg relative overflow-hidden">
                            <!-- Scanning bar animation overlay -->
                            <div class="absolute top-0 left-0 w-full h-[2px] bg-emerald-500/20 animate-[pulse_2s_infinite]"></div>
                            
                            <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-3 text-xs font-mono-tech text-emerald-400">
                                <div class="flex items-center gap-1.5">
                                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>CON_SYS_BUS // STDOUT</span>
                                </div>
                                <span>POLLING: OK</span>
                            </div>

                            <div class="space-y-2 h-44 overflow-hidden font-mono-tech text-[11px] text-slate-400">
                                <template x-for="(log, index) in logQueue" :key="index">
                                    <div class="flex items-start gap-2 animate-[fadeIn_0.3s_ease-out]">
                                        <span class="text-emerald-500 select-none">&gt;&gt;</span>
                                        <span class="break-all" x-text="log"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Dynamic Statistics Ticker -->
                    <div class="lg:col-span-7 space-y-8 fade-up-element"
                         x-data="{
                            totalCollections: 18409200,
                            activeTenants: 846,
                            activeProperties: 48,
                            init() {
                                setInterval(() => {
                                    // Slow random ticking to simulate real-time payments
                                    this.totalCollections += Math.floor(Math.random() * 2000) + 500;
                                    if(Math.random() > 0.8) {
                                        this.activeTenants += 1;
                                    }
                                }, 3000);
                            }
                         }"
                    >
                        <div>
                            <span class="font-mono-tech text-xs uppercase tracking-widest text-emerald-500">// GLOBAL_INDEXER</span>
                            <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white mt-2">Dynamic System Metrics</h2>
                            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                                Real-time aggregate telemetry from all connected landlord profiles on the Hausify cluster network.
                            </p>
                        </div>

                        <!-- Statistics blocks with technical dividers -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-px bg-slate-200 dark:bg-slate-800/80 rounded-xl overflow-hidden shadow-sm">
                            
                            <div class="bg-white dark:bg-slate-950 p-6 flex flex-col justify-center">
                                <div class="text-[10px] font-mono-tech uppercase text-slate-400 dark:text-slate-500">// TOTAL_COLLECTED</div>
                                <div class="text-2xl font-black font-mono-tech text-slate-800 dark:text-white mt-2 transition-all duration-300" 
                                     x-text="'₦' + totalCollections.toLocaleString('en-US')">
                                    ₦18,409,200
                                </div>
                                <span class="text-[9px] text-emerald-500 font-mono-tech mt-1 uppercase tracking-wider">[ TICK_RECEIVING ]</span>
                            </div>

                            <div class="bg-white dark:bg-slate-950 p-6 flex flex-col justify-center">
                                <div class="text-[10px] font-mono-tech uppercase text-slate-400 dark:text-slate-500">// ACTIVE_TENANTS</div>
                                <div class="text-2xl font-black font-mono-tech text-slate-800 dark:text-white mt-2"
                                     x-text="activeTenants">
                                    846
                                </div>
                                <span class="text-[9px] text-emerald-500 font-mono-tech mt-1 uppercase tracking-wider">[ REQ_HANDLED ]</span>
                            </div>

                            <div class="bg-white dark:bg-slate-950 p-6 flex flex-col justify-center">
                                <div class="text-[10px] font-mono-tech uppercase text-slate-400 dark:text-slate-500">// HOST_NODES</div>
                                <div class="text-2xl font-black font-mono-tech text-slate-800 dark:text-white mt-2"
                                     x-text="activeProperties">
                                    48
                                </div>
                                <span class="text-[9px] text-indigo-400 font-mono-tech mt-1 uppercase tracking-wider">[ NET_SECURE ]</span>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </section>


        <!-- SECTION: OPERATIONS FLOW (How it works) -->
        <section id="how-it-works" class="relative border-b border-slate-200 dark:border-slate-800/60 py-20 transition-colors duration-300">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 border-l border-r border-slate-200/60 dark:border-slate-800/40 relative z-10">
                <div class="max-w-2xl mb-16 fade-up-element">
                    <span class="font-mono-tech text-xs uppercase tracking-widest text-emerald-500">// PIPELINE_FLOW</span>
                    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white mt-2 sm:text-4xl">Platform Operations</h2>
                    <p class="mt-4 text-slate-500 dark:text-slate-400">
                        Get configured and ready to collect payments in three highly structured workflow phases.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="rounded-xl border border-slate-200 dark:border-slate-800/80 bg-white/60 dark:bg-slate-900/10 p-6 relative group hover:border-slate-300 dark:hover:border-slate-700 transition duration-300 fade-up-element">
                        <div class="absolute -top-1.5 -left-1.5 text-slate-300 dark:text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
                        <span class="font-mono-tech text-[10px] text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded uppercase tracking-wider block w-max">PHASE_01</span>
                        <h3 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">Registry Initialization</h3>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                            Create your landlord instance, register properties, and subdivide layouts into units. Assign corresponding billing values and details.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="rounded-xl border border-slate-200 dark:border-slate-800/80 bg-white/60 dark:bg-slate-900/10 p-6 relative group hover:border-slate-300 dark:hover:border-slate-700 transition duration-300 fade-up-element">
                        <div class="absolute -top-1.5 -left-1.5 text-slate-300 dark:text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
                        <span class="font-mono-tech text-[10px] text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded uppercase tracking-wider block w-max">PHASE_02</span>
                        <h3 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">Tenant Registry Sync</h3>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                            Onboard tenants to their respective units. Upload leases, coordinate deposit receipts, and establish system reminders.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="rounded-xl border border-slate-200 dark:border-slate-800/80 bg-white/60 dark:bg-slate-900/10 p-6 relative group hover:border-slate-300 dark:hover:border-slate-700 transition duration-300 fade-up-element">
                        <div class="absolute -top-1.5 -left-1.5 text-slate-300 dark:text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
                        <span class="font-mono-tech text-[10px] text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded uppercase tracking-wider block w-max">PHASE_03</span>
                        <h3 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">Automated Settlement</h3>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                            Collect rent payments online or log bank transfers. Automatically route system maintenance tickets and handle property repairs efficiently.
                        </p>
                    </div>
                </div>
            </div>
        </section>


        <!-- SECTION: PRICING -->
        <section id="pricing" class="relative border-b border-slate-200 dark:border-slate-800/60 py-20 transition-colors duration-300">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 border-l border-r border-slate-200/60 dark:border-slate-800/40 relative z-10">
                <div class="max-w-2xl mb-16 fade-up-element">
                    <span class="font-mono-tech text-xs uppercase tracking-widest text-emerald-500">// FINANCIALS</span>
                    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white mt-2 sm:text-4xl">Straightforward Pricing</h2>
                    <p class="mt-4 text-slate-500 dark:text-slate-400">
                        Choose the node size that perfectly fits your property portfolio count.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
                    <!-- Starter Plan -->
                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/60 dark:bg-slate-900/10 p-8 flex flex-col justify-between hover:border-slate-300 dark:hover:border-slate-700 transition duration-300 fade-up-element">
                        <div>
                            <span class="font-mono-tech text-[10px] text-slate-400 dark:text-slate-500 block">// INSTANCE_SMALL</span>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mt-2">Starter Node</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">Ideal for private landlords managing a few properties.</p>
                            
                            <div class="mt-6 flex items-baseline text-slate-900 dark:text-white">
                                <span class="text-3xl font-black font-mono-tech">₦15,000</span>
                                <span class="ml-1 text-sm font-semibold text-slate-400 font-mono-tech">/MONTH</span>
                            </div>

                            <ul class="mt-6 space-y-4 text-sm text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800 pt-6">
                                <li class="flex items-center gap-2"><span class="text-emerald-500 font-mono-tech">[+]</span> Up to 15 Property Units</li>
                                <li class="flex items-center gap-2"><span class="text-emerald-500 font-mono-tech">[+]</span> Tenant & Lease Registry</li>
                                <li class="flex items-center gap-2"><span class="text-emerald-500 font-mono-tech">[+]</span> Basic Invoice Generation</li>
                                <li class="flex items-center gap-2"><span class="text-emerald-500 font-mono-tech">[+]</span> SMS Reminders</li>
                            </ul>
                        </div>
                        <a href="{{ route('register') }}" class="mt-8 block w-full text-center rounded-lg border border-slate-200 dark:border-slate-800 py-3 text-xs font-mono-tech uppercase tracking-wider text-slate-800 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            PROVISION_INSTANCE //
                        </a>
                    </div>

                    <!-- Growth Plan -->
                    <div class="rounded-2xl border-2 border-emerald-500 bg-white dark:bg-slate-900/60 p-8 flex flex-col justify-between shadow-xl relative overflow-hidden fade-up-element">
                        <!-- High-tech tag badge -->
                        <div class="absolute top-0 right-0 bg-emerald-500 text-white font-mono-tech text-[9px] uppercase tracking-widest px-4 py-1.5 rounded-bl">RECOMMENDED</div>

                        <div>
                            <span class="font-mono-tech text-[10px] text-emerald-500 block">// INSTANCE_STANDARD</span>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mt-2">Growth Node</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">For active property managers and real estate coordinators.</p>
                            
                            <div class="mt-6 flex items-baseline text-slate-900 dark:text-white">
                                <span class="text-3xl font-black font-mono-tech">₦35,000</span>
                                <span class="ml-1 text-sm font-semibold text-slate-400 font-mono-tech">/MONTH</span>
                            </div>

                            <ul class="mt-6 space-y-4 text-sm text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-800 pt-6">
                                <li class="flex items-center gap-2"><span class="text-emerald-500 font-mono-tech">[+]</span> Up to 60 Property Units</li>
                                <li class="flex items-center gap-2"><span class="text-emerald-500 font-mono-tech">[+]</span> Automated Bank Payment Webhooks</li>
                                <li class="flex items-center gap-2"><span class="text-emerald-500 font-mono-tech">[+]</span> Maintenance Ticket Dashboard</li>
                                <li class="flex items-center gap-2"><span class="text-emerald-500 font-mono-tech">[+]</span> Multi-User Access Permissions</li>
                            </ul>
                        </div>
                        <a href="{{ route('register') }}" class="mt-8 block w-full text-center rounded-lg bg-emerald-500 py-3 text-xs font-mono-tech uppercase tracking-wider text-white font-bold hover:bg-emerald-400 shadow-md shadow-emerald-500/20 transition">
                            PROVISION_INSTANCE &rarr;
                        </a>
                    </div>

                    <!-- Enterprise Plan -->
                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/60 dark:bg-slate-900/10 p-8 flex flex-col justify-between hover:border-slate-300 dark:hover:border-slate-700 transition duration-300 fade-up-element">
                        <div>
                            <span class="font-mono-tech text-[10px] text-slate-400 dark:text-slate-500 block">// INSTANCE_UNLIMITED</span>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mt-2">Enterprise Grid</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">For large estate firms, developments, and unlimited portfolios.</p>
                            
                            <div class="mt-6 flex items-baseline text-slate-900 dark:text-white">
                                <span class="text-3xl font-black font-mono-tech">CUSTOM</span>
                                <span class="ml-1 text-sm font-semibold text-slate-400 font-mono-tech">/ANNUAL</span>
                            </div>

                            <ul class="mt-6 space-y-4 text-sm text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800 pt-6">
                                <li class="flex items-center gap-2"><span class="text-emerald-500 font-mono-tech">[+]</span> Unlimited Property Units</li>
                                <li class="flex items-center gap-2"><span class="text-emerald-500 font-mono-tech">[+]</span> Custom API Deployments</li>
                                <li class="flex items-center gap-2"><span class="text-emerald-500 font-mono-tech">[+]</span> Dedicated Server Hosting Instance</li>
                                <li class="flex items-center gap-2"><span class="text-emerald-500 font-mono-tech">[+]</span> 24/7 SLA Engineering Support</li>
                            </ul>
                        </div>
                        <a href="mailto:hello@hausifyapp.com" class="mt-8 block w-full text-center rounded-lg border border-slate-200 dark:border-slate-800 py-3 text-xs font-mono-tech uppercase tracking-wider text-slate-800 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            CONTACT_SALES //
                        </a>
                    </div>
                </div>
            </div>
        </section>


        <!-- SECTION: FINAL CTA -->
        <section class="relative py-20 transition-colors duration-300">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 border-l border-r border-slate-200/60 dark:border-slate-800/40 relative z-10">
                <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-gradient-to-r from-emerald-500/10 to-indigo-500/10 p-10 lg:p-16 relative overflow-hidden fade-up-element">
                    <!-- Accent corner markers -->
                    <div class="absolute top-2 left-2 text-slate-400 dark:text-slate-700 font-mono text-[9px] select-none pointer-events-none">+</div>
                    <div class="absolute bottom-2 right-2 text-slate-400 dark:text-slate-700 font-mono text-[9px] select-none pointer-events-none">+</div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                        <div class="lg:col-span-8 space-y-4">
                            <span class="font-mono-tech text-xs uppercase tracking-widest text-emerald-500">// PROVISION_CLUSTER_NODE</span>
                            <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Ready to pilot your properties?</h2>
                            <p class="text-slate-500 dark:text-slate-400 max-w-xl">
                                Join landlords and estate firms digitizing collections, records, and maintenance logs in a neat tech-grid infrastructure.
                            </p>
                        </div>
                        <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col xl:flex-row gap-4 xl:justify-end">
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-500 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-emerald-500/25 hover:bg-emerald-400 transition-all duration-200 font-mono-tech">
                                CREATE_ACCOUNT &rarr;
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-800 bg-white/60 dark:bg-slate-900/20 px-6 py-3.5 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition duration-200 font-mono-tech">
                                SYSTEM_LOGIN //
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Decoupled Technical Grid Footer -->
    <x-footer />

    <!-- Pure JS Scroll Reveal / Viewport Fade-up Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                        // Stop observing once in view
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const fadeUpElements = document.querySelectorAll('.fade-up-element');
            fadeUpElements.forEach(el => revealObserver.observe(el));
        });
    </script>
</body>
</html>