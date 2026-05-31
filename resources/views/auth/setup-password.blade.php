<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white uppercase tracking-wider font-mono-tech">// ACCOUNT_CREATION_SECURE</h2>
        <p class="text-xs text-slate-500 mt-1">Please secure your account by choosing a display name and password.</p>
    </div>

    <form method="POST" action="{{ route('password.setup') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Display Name / Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name ?? '')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Create Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="At least 8 characters" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Save & Go to Dashboard') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
