<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center sm:text-left">
        <h3 class="text-3xl font-playfair font-semibold text-[#222] mb-2">Welcome Back</h3>
        <p class="text-sm text-gray-500">Sign in to your account to continue</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs uppercase tracking-wider text-gray-600 mb-1">{{ __('Email') }}</label>
            <input id="email" class="input-luxury block w-full text-[#222]" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs uppercase tracking-wider text-gray-600 mb-1">{{ __('Password') }}</label>
            <input id="password" class="input-luxury block w-full text-[#222]" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-sm border-gray-300 text-[#222] focus:ring-[#222] bg-transparent" name="remember">
                <span class="ms-2 text-xs text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-gray-500 hover:text-[#222] transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-[#222] text-white uppercase tracking-[0.2em] text-xs py-4 hover:bg-black transition shadow-sm hover:shadow-md">
                {{ __('Log in') }}
            </button>
        </div>
        
        <div class="text-center pt-6 border-t border-gray-200/60 mt-6">
            <p class="text-xs text-gray-500">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-[#222] font-bold hover:text-gray-600 uppercase tracking-wider ml-1 transition">Create one</a>
            </p>
        </div>
    </form>
</x-guest-layout>
