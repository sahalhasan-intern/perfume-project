<x-guest-layout>
    <div class="mb-8 text-center sm:text-left">
        <h3 class="text-3xl font-playfair font-semibold text-[#222] mb-2">Create Account</h3>
        <p class="text-sm text-gray-500">Join ELAVA and discover your signature aura</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs uppercase tracking-wider text-gray-600 mb-1">{{ __('Name') }}</label>
            <input id="name" class="input-luxury block w-full text-[#222]" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-600" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs uppercase tracking-wider text-gray-600 mb-1">{{ __('Email') }}</label>
            <input id="email" class="input-luxury block w-full text-[#222]" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs uppercase tracking-wider text-gray-600 mb-1">{{ __('Password') }}</label>
            <input id="password" class="input-luxury block w-full text-[#222]" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs uppercase tracking-wider text-gray-600 mb-1">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="input-luxury block w-full text-[#222]" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-600" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-[#222] text-white uppercase tracking-[0.2em] text-xs py-4 hover:bg-black transition shadow-sm hover:shadow-md">
                {{ __('Register') }}
            </button>
        </div>

        <div class="text-center pt-6 border-t border-gray-200/60 mt-6">
            <p class="text-xs text-gray-500">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-[#222] font-bold hover:text-gray-600 uppercase tracking-wider ml-1 transition">Sign in</a>
            </p>
        </div>
    </form>
</x-guest-layout>
