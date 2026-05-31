<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hausify') }} - Dashboard</title>

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
    <body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 antialiased transition-colors duration-300">
        
        @php
            $user = auth()->user();
            $role = $user?->role ?? 'tenant';
            
            // Core theme configurations mapping role to class keys
            $themes = [
                'landlord' => [
                    'name' => 'Landlord Workspace',
                    'color' => 'emerald',
                    'text' => 'text-emerald-500',
                    'bg' => 'bg-emerald-500',
                    'bgLight' => 'bg-emerald-500/10 dark:bg-emerald-500/5',
                    'border' => 'border-emerald-500/30 dark:border-emerald-500/20',
                    'borderHover' => 'hover:border-emerald-500/50',
                    'activeNav' => 'bg-emerald-500/10 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500',
                    'badge' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20',
                ],
                'tenant' => [
                    'name' => 'Tenant Workspace',
                    'color' => 'blue',
                    'text' => 'text-blue-500',
                    'bg' => 'bg-blue-500',
                    'bgLight' => 'bg-blue-500/10 dark:bg-blue-500/5',
                    'border' => 'border-blue-500/30 dark:border-blue-500/20',
                    'borderHover' => 'hover:border-blue-500/50',
                    'activeNav' => 'bg-blue-500/10 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500',
                    'badge' => 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/20',
                ],
                'school_admin' => [
                    'name' => 'School Boarding Workspace',
                    'color' => 'purple',
                    'text' => 'text-purple-500',
                    'bg' => 'bg-purple-500',
                    'bgLight' => 'bg-purple-500/10 dark:bg-purple-500/5',
                    'border' => 'border-purple-500/30 dark:border-purple-500/20',
                    'borderHover' => 'hover:border-purple-500/50',
                    'activeNav' => 'bg-purple-500/10 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 border-purple-500',
                    'badge' => 'bg-purple-500/10 text-purple-600 dark:text-purple-400 border-purple-500/20',
                ],
                'hostel_warden' => [
                    'name' => 'Hostel Warden Workspace',
                    'color' => 'amber',
                    'text' => 'text-amber-500',
                    'bg' => 'bg-amber-500',
                    'bgLight' => 'bg-amber-500/10 dark:bg-amber-500/5',
                    'border' => 'border-amber-500/30 dark:border-amber-500/20',
                    'borderHover' => 'hover:border-amber-500/50',
                    'activeNav' => 'bg-amber-500/10 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500',
                    'badge' => 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20',
                ],
                // Fallbacks
                'superadmin' => [
                    'name' => 'System Control Panel',
                    'color' => 'rose',
                    'text' => 'text-rose-500',
                    'bg' => 'bg-rose-500',
                    'bgLight' => 'bg-rose-500/10 dark:bg-rose-500/5',
                    'border' => 'border-rose-500/30 dark:border-rose-500/20',
                    'borderHover' => 'hover:border-rose-500/50',
                    'activeNav' => 'bg-rose-500/10 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-500',
                    'badge' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-500/20',
                ],
                'manager' => [
                    'name' => 'Manager Workspace',
                    'color' => 'emerald',
                    'text' => 'text-emerald-500',
                    'bg' => 'bg-emerald-500',
                    'bgLight' => 'bg-emerald-500/10 dark:bg-emerald-500/5',
                    'border' => 'border-emerald-500/30 dark:border-emerald-500/20',
                    'borderHover' => 'hover:border-emerald-500/50',
                    'activeNav' => 'bg-emerald-500/10 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500',
                    'badge' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20',
                ],
                'accountant' => [
                    'name' => 'Accountant Workspace',
                    'color' => 'blue',
                    'text' => 'text-blue-500',
                    'bg' => 'bg-blue-500',
                    'bgLight' => 'bg-blue-500/10 dark:bg-blue-500/5',
                    'border' => 'border-blue-500/30 dark:border-blue-500/20',
                    'borderHover' => 'hover:border-blue-500/50',
                    'activeNav' => 'bg-blue-500/10 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500',
                    'badge' => 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/20',
                ],
            ];
            
            $theme = $themes[$role] ?? $themes['tenant'];
        @endphp

        <!-- Connected Tiny Squares Mesh Background (Only top header glow for dashboards) -->
        <div class="absolute inset-x-0 top-0 h-[250px] pointer-events-none z-0 overflow-hidden">
            <div class="w-full.h-full bg-tech-squares-light dark:bg-tech-squares-dark [mask-image:linear-gradient(to_bottom,black_20%,transparent_100%)] [-webkit-mask-image:linear-gradient(to_bottom,black_20%,transparent_100%)] opacity-30"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[150px] {{ $theme['bgLight'] }} blur-[80px] rounded-full"></div>
        </div>

        <div x-data="{ sidebarOpen: false, sidebarCollapsed: false, dark: false }"
             x-init="dark = document.documentElement.classList.contains('dark')"
             class="min-h-screen flex relative z-10">
            
            <!-- Mobile Sidebar Overlay -->
            <div x-show="sidebarOpen" 
                 @click="sidebarOpen = false" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden" 
                 style="display: none;">
            </div>

            <!-- SIDEBAR -->
            <aside :class="{
                        'translate-x-0': sidebarOpen,
                        '-translate-x-full': !sidebarOpen,
                        'lg:w-64': !sidebarCollapsed,
                        'lg:w-20': sidebarCollapsed
                    }"
                   class="fixed inset-y-0 left-0 w-64 lg:static lg:translate-x-0 z-50 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800/80 flex flex-col justify-between transition-all duration-300 transform shadow-xl lg:shadow-none">
                
                <div class="flex-grow flex flex-col min-h-0 overflow-y-auto scrollbar-thin">
                    <!-- Sidebar Header / Logo -->
                    <div class="h-16 flex items-center px-5 border-b border-slate-100 dark:border-slate-800 justify-between shrink-0">
                        <a href="/" class="flex items-center gap-3 group overflow-hidden">
                            <div class="relative flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-400 font-black text-white shadow-md transition-all duration-300 group-hover:scale-105">
                                H
                                <div class="absolute top-0.5 left-0.5 w-1 h-1 bg-white/40 rounded-full"></div>
                            </div>
                            <div class="transition-all duration-300" :class="{ 'opacity-0 w-0': sidebarCollapsed, 'opacity-100': !sidebarCollapsed }">
                                <span class="font-extrabold text-sm tracking-tight text-slate-900 dark:text-white block">Hausify</span>
                                <span class="text-[9px] font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider block">Workspace</span>
                            </div>
                        </a>
                        <!-- Active Status Indicator Dot -->
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shrink-0" :class="{ 'hidden': sidebarCollapsed }"></div>
                    </div>

                    <!-- Role Badge / Workspace Selector -->
                    <div class="p-4 border-b border-slate-100 dark:border-slate-800 shrink-0" :class="{ 'text-center': sidebarCollapsed }">
                        <div :class="{ 'inline-block mx-auto': sidebarCollapsed, 'flex flex-col gap-1.5': !sidebarCollapsed }">
                            <span class="text-[9px] font-bold text-slate-450 dark:text-slate-500 uppercase tracking-widest" :class="{ 'sr-only': sidebarCollapsed }">ACTIVE ACCOUNT</span>
                            <div class="px-3 py-1.5 text-xs font-bold border rounded-xl shadow-sm uppercase tracking-wide {{ $theme['badge'] }} inline-flex items-center justify-center gap-1.5 max-w-full">
                                <span class="w-1.5 h-1.5 rounded-full {{ $theme['bg'] }} shrink-0"></span>
                                <span x-show="!sidebarCollapsed" class="truncate">{{ $theme['name'] }}</span>
                                <span x-show="sidebarCollapsed shrink-0">{{ strtoupper(substr($role, 0, 2)) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Navigation Links -->
                    <nav class="p-4 space-y-6 flex-grow">
                        @if($role === 'landlord')
                            <!-- Landlord Navigation -->
                            <div class="space-y-1.5">
                                <span x-show="!sidebarCollapsed" class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-3 block">Property Management</span>
                                <div class="space-y-1">
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 {{ request()->routeIs('dashboard') ? $theme['activeNav'] . ' shadow-sm' : 'border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white' }}" title="Overview">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Overview</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Properties">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Properties</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Units & Bedspaces">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2zM4 21a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2z"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Units & Bedspaces</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Tenants">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Tenants</span>
                                    </a>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <span x-show="!sidebarCollapsed" class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-3 block">Finance & Billing</span>
                                <div class="space-y-1">
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Invoices & Bills">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Invoices & Bills</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Payments">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Payments</span>
                                    </a>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <span x-show="!sidebarCollapsed" class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-3 block">Administration</span>
                                <div class="space-y-1">
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Settings">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Settings</span>
                                    </a>
                                </div>
                            </div>
                        @elseif($role === 'tenant')
                            <!-- Tenant Navigation -->
                            <div class="space-y-1.5">
                                <span x-show="!sidebarCollapsed" class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-3 block">Tenant Operations</span>
                                <div class="space-y-1">
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 {{ request()->routeIs('dashboard') ? $theme['activeNav'] . ' shadow-sm' : 'border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white' }}" title="My Dashboard">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">My Dashboard</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Invoices & Rent">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Invoices & Rent</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Maintenance Requests">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Maintenance Requests</span>
                                    </a>
                                </div>
                            </div>
                        @elseif($role === 'school_admin')
                            <!-- School Admin Navigation -->
                            <div class="space-y-1.5">
                                <span x-show="!sidebarCollapsed" class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-3 block">Boarding Management</span>
                                <div class="space-y-1">
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 {{ request()->routeIs('dashboard') ? $theme['activeNav'] . ' shadow-sm' : 'border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white' }}" title="Dorm Overview">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Dorm Overview</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Hostel Blocks">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Hostel Blocks</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Boarding Students">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Boarding Students</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Dorm Fees">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Dorm Fees</span>
                                    </a>
                                </div>
                            </div>
                        @elseif($role === 'hostel_warden')
                            <!-- Hostel Warden Navigation -->
                            <div class="space-y-1.5">
                                <span x-show="!sidebarCollapsed" class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-3 block">Warden Management</span>
                                <div class="space-y-1">
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 {{ request()->routeIs('dashboard') ? $theme['activeNav'] . ' shadow-sm' : 'border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white' }}" title="Warden Panel">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Warden Panel</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Bed Spaces">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Bed Spaces</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Occupant Log">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Occupant Log</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="Incident Reports">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <span :class="{ 'hidden': sidebarCollapsed }">Incident Reports</span>
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- Admin / Accountant / Fallback -->
                            <div class="space-y-1">
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 {{ request()->routeIs('dashboard') ? $theme['activeNav'] . ' shadow-sm' : 'border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white' }}" title="Dashboard">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                                    <span :class="{ 'hidden': sidebarCollapsed }">Dashboard</span>
                                </a>
                            </div>
                        @endif

                        <div class="space-y-1.5">
                            <span x-show="!sidebarCollapsed" class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-3 block">Account settings</span>
                            <div class="space-y-1">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold rounded-xl border transition duration-200 border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:text-slate-900 dark:hover:text-white" title="My Profile">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span :class="{ 'hidden': sidebarCollapsed }">My Profile</span>
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>

                <!-- Sidebar Footer -->
                <div class="p-4 border-t border-slate-100 dark:border-slate-850 flex flex-col gap-2 shrink-0">
                    <div class="flex items-center gap-3 p-1.5 rounded-xl bg-slate-50 dark:bg-slate-950/60 border border-slate-100 dark:border-slate-800/60" :class="{ 'justify-center border-none bg-transparent': sidebarCollapsed }">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-500 text-white font-extrabold flex items-center justify-center text-xs shrink-0 uppercase shadow-sm">
                            {{ substr($user?->name ?? 'U', 0, 2) }}
                        </div>
                        <div class="overflow-hidden" :class="{ 'hidden': sidebarCollapsed }">
                            <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $user?->name }}</h4>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 truncate mt-0.5">{{ $user?->email }}</p>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center gap-3.5 px-3 py-2.5 text-xs font-bold border border-transparent rounded-xl text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/20 transition duration-200"
                                :class="{ 'justify-center': sidebarCollapsed }"
                                title="Logout">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span :class="{ 'hidden': sidebarCollapsed }">LOGOUT</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- MAIN WORKSPACE CONTENT CONTAINER -->
            <div class="flex-1 flex flex-col min-w-0 min-h-screen">
                
                <!-- TOP HEADER BAR -->
                <header class="h-16 bg-white/95 dark:bg-slate-900/90 backdrop-blur border-b border-slate-200 dark:border-slate-800/80 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30">
                    
                    <!-- Left actions (Sidebar Toggle) -->
                    <div class="flex items-center gap-4">
                        <!-- Desktop Sidebar Toggle -->
                        <button @click="sidebarCollapsed = !sidebarCollapsed" 
                                class="hidden lg:flex p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition"
                                aria-label="Toggle Sidebar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                        </button>

                        <!-- Mobile Sidebar Toggle -->
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="lg:hidden p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition"
                                aria-label="Toggle Menu">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <!-- Header Page Title -->
                        @isset($header)
                            {{ $header }}
                        @else
                            <h2 class="font-bold text-slate-900 dark:text-white text-base">Dashboard</h2>
                        @endisset
                    </div>

                    <!-- Right actions (Theme Toggle, Notifications, Profile) -->
                    <div class="flex items-center gap-3">
                        
                        <!-- Theme Toggle -->
                        <button @click="
                                    dark = !dark; 
                                    if(dark) { 
                                        document.documentElement.classList.add('dark'); 
                                        localStorage.setItem('theme', 'dark'); 
                                    } else { 
                                        document.documentElement.classList.remove('dark'); 
                                        localStorage.setItem('theme', 'light'); 
                                    }
                                "
                                class="p-2 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition"
                                aria-label="Toggle Theme">
                            <svg x-show="dark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                            </svg>
                            <svg x-show="!dark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>

                        <div class="h-6 w-[1px] bg-slate-200 dark:bg-slate-800"></div>

                        <!-- User Profile Info -->
                        <span class="text-xs font-mono-tech uppercase tracking-wider text-slate-500 bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 px-2.5 py-1 rounded">
                            {{ $role }} // online
                        </span>
                    </div>
                </header>

                <!-- PAGE MAIN CONTAINER -->
                <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto relative z-10">
                    @if ($user && $user->onboarded && !$user->hasVerifiedEmail())
                        @php
                            $purgeCutoff = $user->created_at->addWeek();
                            $hoursLeft = max(0, now()->diffInHours($purgeCutoff, false));
                            $daysLeft = ceil($hoursLeft / 24);
                        @endphp
                        
                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 p-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 rounded-lg text-xs font-mono-tech select-none">
                                // SUCCESS: A new digital verification node link has been dispatched to your mailbox.
                            </div>
                        @endif

                        <!-- Email Verification Alert Banner -->
                        <div class="mb-6 p-4 bg-amber-500/10 border border-amber-500/30 rounded-xl relative overflow-hidden flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <!-- Technical Grid decorations inside the banner -->
                            <div class="absolute top-1 left-1 text-amber-500/40 font-mono text-[8px] select-none pointer-events-none">+</div>
                            <div class="absolute bottom-1 right-1 text-amber-500/40 font-mono text-[8px] select-none pointer-events-none">+</div>

                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 shrink-0 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-500 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="font-mono-tech text-[9px] text-amber-500 uppercase tracking-widest block">// SEC_ALERT: UNVERIFIED_IDENTITY</span>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Email Verification Required</h4>
                                    <p class="text-xs text-slate-600 dark:text-slate-400">
                                        Verification code dispatched to <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $user->email }}</span>.
                                        @if ($hoursLeft > 0)
                                            Unverified nodes are auto-purged. Remaining grace period: <span class="font-bold text-amber-600 dark:text-amber-400 font-mono-tech">{{ $daysLeft > 1 ? "$daysLeft days" : "$hoursLeft hours" }}</span>.
                                        @else
                                            Unverified nodes are auto-purged after 7 days. Your grace period has elapsed. Deletion queue scheduled.
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 font-mono-tech shrink-0">
                                <form method="POST" action="{{ route('verification.send') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3.5 py-1.5 text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700/80 border border-slate-200 dark:border-slate-700 rounded-lg transition duration-150">
                                        [ RESEND_VERIFICATION_LINK ]
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>