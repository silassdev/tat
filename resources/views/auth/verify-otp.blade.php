<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white uppercase tracking-wider font-mono-tech">// EMAIL_VERIFICATION_REQUIRED</h2>
        <p class="text-xs text-slate-500 mt-1">We sent a 6-digit OTP code to verify your identity. Check your inbox: <strong class="text-slate-700 dark:text-slate-300">{{ $email }}</strong></p>
    </div>

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <!-- OTP Code -->
        <div>
            <x-input-label for="otp" :value="__('Enter Verification Code')" />
            <x-text-input id="otp" class="block mt-1 w-full text-center font-mono-tech text-xl tracking-[10px]" type="text" name="otp" required autofocus placeholder="######" maxlength="6" autocomplete="off" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="mt-6 flex flex-col gap-3">
            <x-primary-button class="w-full justify-center">
                {{ __('Verify & Continue') }}
            </x-primary-button>

            <div class="text-center mt-2">
                <a href="{{ route('login') }}" class="underline text-xs text-slate-500 hover:text-emerald-500 transition duration-150">
                    {{ __('Use another email') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
