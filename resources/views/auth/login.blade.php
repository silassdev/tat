<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div x-data="{ activeTab: 'otp' }" class="w-full">
        <!-- Technical Tabs Header -->
        <div class="flex border-b border-slate-200 dark:border-slate-800/80 mb-6 font-mono-tech text-[10px] font-bold tracking-wider">
            <button @click="activeTab = 'otp'" 
                    :class="activeTab === 'otp' ? 'border-b-2 border-emerald-500 text-emerald-500' : 'text-slate-500 hover:text-slate-300'"
                    class="flex-1 py-2 text-center transition-all duration-200 focus:outline-none uppercase">
                [ OTP_VERIFY ]
            </button>
            <button @click="activeTab = 'password'" 
                    :class="activeTab === 'password' ? 'border-b-2 border-emerald-500 text-emerald-500' : 'text-slate-500 hover:text-slate-300'"
                    class="flex-1 py-2 text-center transition-all duration-200 focus:outline-none uppercase">
                [ PASSWORD_ACCESS ]
            </button>
        </div>

        <!-- 1. OTP Verification Form -->
        <div x-show="activeTab === 'otp'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0">
            <div class="mb-4 text-center">
                <p class="text-xs text-slate-500">Perfect for guests checking out or logging in securely without a password.</p>
            </div>
            
            <form method="POST" action="{{ route('otp.send') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="otp_email" :value="__('Email Address')" />
                    <x-text-input id="otp_email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@domain.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <x-primary-button class="w-full justify-center">
                        {{ __('Send One-Time OTP') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- 2. Standard Password Login Form -->
        <div x-show="activeTab === 'password'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0" style="display: none;">
            <div class="mb-4 text-center">
                <p class="text-xs text-slate-500">For returning users and administrators accessing their dashboards.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="login_email" :value="__('Email Address')" />
                    <x-text-input id="login_email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="login_password" :value="__('Password')" />
                    <x-text-input id="login_password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-slate-950 border-slate-700 text-emerald-500 shadow-sm focus:ring-emerald-500 focus:ring-offset-slate-900" name="remember">
                        <span class="ms-2 text-xs text-slate-500 dark:text-slate-400">{{ __('Keep me logged in') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-xs text-slate-500 hover:text-emerald-500 rounded-md focus:outline-none" href="{{ route('password.request') }}">
                            {{ __('Forgot credentials?') }}
                        </a>
                    @endif

                    <x-primary-button>
                        {{ __('Log In') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Google OAuth Split -->
    <div class="relative flex py-5 items-center">
        <div class="flex-grow border-t border-slate-200 dark:border-slate-800"></div>
        <span class="flex-shrink mx-4 text-slate-400 dark:text-slate-500 text-[10px] font-mono-tech uppercase tracking-wider">OR</span>
        <div class="flex-grow border-t border-slate-200 dark:border-slate-800"></div>
    </div>

    <a href="{{ route('auth.google') }}" 
       class="w-full flex items-center justify-center gap-3 px-4 py-2.5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800/80 hover:border-emerald-500/50 dark:hover:border-emerald-500/50 rounded-xl font-semibold text-sm text-slate-700 dark:text-slate-200 hover:text-slate-900 dark:hover:text-white transition duration-200 relative overflow-hidden group shadow-sm">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-indigo-500/10 opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none"></div>
        
        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24">
            <path fill="#EA4335" d="M12 5.04c1.66 0 3.2.57 4.38 1.69l3.27-3.27C17.68 1.54 14.98 1 12 1 7.35 1 3.37 3.65 1.39 7.56l3.85 2.99c.96-2.87 3.66-4.51 6.76-4.51z"></path>
            <path fill="#4285F4" d="M23.49 12.27c0-.81-.07-1.59-.2-2.36H12v4.51h6.43c-.28 1.44-1.09 2.66-2.32 3.49l3.61 2.8c2.1-1.93 3.77-5.17 3.77-8.44z"></path>
            <path fill="#FBBC05" d="M5.24 14.29c-.25-.76-.39-1.57-.39-2.41s.14-1.65.39-2.41L1.39 6.48C.5 8.26 0 10.22 0 12.27s.5 4.01 1.39 5.79l3.85-2.99z"></path>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.61-2.8c-.99.66-2.23 1.06-3.67 1.06-3.1 0-5.8-2.14-6.76-5.01L1.39 16.58C3.37 20.49 7.35 23 12 23z"></path>
        </svg>
        <span class="relative z-10 font-mono-tech text-[10px] font-bold uppercase tracking-wider">{{ __('Continue with Google') }}</span>
    </a>
</x-guest-layout>
