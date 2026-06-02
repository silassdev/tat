<x-store-layout>
    <div class="mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-mono-tech text-xs uppercase tracking-wider text-slate-500 hover:text-emerald-400 transition">
            &larr; [ Return to Storefront ]
        </a>
    </div>

    <div class="max-w-2xl mx-auto bg-slate-950/40 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative">
        <!-- Grid decor plus markers -->
        <div class="absolute top-1.5 left-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>
        <div class="absolute bottom-1.5 right-1.5 text-slate-800 font-mono text-[9px] select-none pointer-events-none">+</div>

        <div class="mb-6">
            <span class="inline-block px-3 py-1 font-mono-tech text-[9px] font-bold tracking-widest text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-lg uppercase select-none">
                CONTACT US TODAY
            </span>
            <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2 select-none">Secure Communication Node</h2>
            <p class="text-xs text-slate-500 mt-1 select-none">Transmit your inquiry directly to our administrator mailbox. All channels are monitored.</p>
        </div>

        <form method="POST" action="{{ route('contact') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="e.g. John Doe" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="e.g. john@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Subject -->
            <div>
                <x-input-label for="subject" :value="__('Subject / Inquiries')" />
                <x-text-input id="subject" class="block mt-1 w-full" type="text" name="subject" :value="old('subject')" required placeholder="e.g. Bulk hardware ordering request" />
                <x-input-error :messages="$errors->get('subject')" class="mt-2" />
            </div>

            <!-- Message -->
            <div>
                <x-input-label for="message" :value="__('Message')" />
                <textarea id="message" name="message" rows="5" required placeholder="Write details here..."
                          class="block mt-1 w-full bg-slate-950/80 border-slate-800 dark:border-slate-800/80 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 text-slate-200 text-xs shadow-sm">{{ old('message') }}</textarea>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-800/80">
                <button type="submit" 
                        class="w-full py-4 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold font-mono-tech text-xs uppercase tracking-wider rounded-xl shadow-lg transition">
                   Send Message
                </button>
            </div>
        </form>
    </div>
</x-store-layout>
