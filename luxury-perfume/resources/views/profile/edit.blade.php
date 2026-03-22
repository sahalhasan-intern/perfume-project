@extends('layouts.store')

@section('title', 'Profile Settings - ELAVA Skincare')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 mt-20 min-h-[60vh]">
    <div class="mb-12">
        <h2 class="text-4xl font-serif text-[#222]">Profile Settings</h2>
        <div class="w-12 h-px bg-[#222] mt-6"></div>
    </div>

    <!-- Integrate the navigation similar to the dashboard for consistency -->
    <div class="md:grid md:grid-cols-4 md:gap-12">
        <div class="md:col-span-1 mb-8 md:mb-0">
            <div class="border-b border-[#222] pb-6 mb-6">
                <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Account settings</p>
                <h3 class="text-xl font-serif text-[#222] truncate">{{ Auth::user()->name }}</h3>
            </div>
            <nav class="space-y-4">
                <a href="{{ route('dashboard') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-[#222] group flex items-center transition">
                    <span class="w-1.5 h-1.5 bg-transparent rounded-full mr-3 group-hover:bg-gray-300 transition block"></span>
                    Dashboard
                </a>
                <a href="{{ route('orders.index') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-[#222] group flex items-center transition">
                    <span class="w-1.5 h-1.5 bg-transparent rounded-full mr-3 group-hover:bg-gray-300 transition block"></span>
                    My Orders
                </a>
                <a href="{{ route('profile.edit') }}" class="text-xs font-bold uppercase tracking-widest text-[#222] group flex items-center transition">
                    <span class="w-1.5 h-1.5 bg-[var(--color-gold)] rounded-full mr-3"></span>
                    Profile Settings
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="pt-6 mt-6 border-t border-gray-100">
                    @csrf
                    <button type="submit" class="text-xs font-bold uppercase tracking-widest text-red-500 hover:text-red-700 transition flex items-center">
                        <i class="fas fa-sign-out-alt mr-3"></i> Log Out
                    </button>
                </form>
            </nav>
        </div>
        
        <div class="mt-5 md:mt-0 md:col-span-3 space-y-8">
            <div class="p-8 bg-white border border-gray-100 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-8 bg-white border border-gray-100 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-8 bg-white border border-gray-100 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
