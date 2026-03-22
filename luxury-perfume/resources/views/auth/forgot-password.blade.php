<x-guest-layout>
    <div class="mb-6">
        <h3 class="text-3xl font-playfair font-semibold text-stone-800 mb-2">Reset Password</h3>
    </div>

    <div class="mb-6 text-sm text-stone-500 leading-relaxed">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs uppercase tracking-wider text-stone-600 mb-1">{{ __('Email') }}</label>
            <input id="email" class="input-luxury block w-full text-stone-800" type="email" name="email" value="{{ old('email') }}" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600" />
        </div>

        <div class="flex items-center justify-between pt-4 mt-8">
            <a href="{{ route('login') }}" class="text-xs text-stone-500 hover:text-amber-700 uppercase tracking-widest transition">
                &larr; Back to login
            </a>

            <button type="submit" class="bg-stone-900 text-white uppercase tracking-[0.2em] text-[10px] sm:text-xs py-3 px-6 hover:bg-stone-800 transition shadow-lg hover:shadow-xl">
                {{ __('Send Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
