@extends('layouts.store')

@section('title', 'My Wishlist - ELAVA Skincare')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 mt-20 min-h-[60vh]">
    <div class="mb-12">
        <h2 class="text-4xl font-serif text-[#222]">My Account</h2>
        <div class="w-12 h-px bg-[#222] mt-6"></div>
    </div>

    <div class="md:grid md:grid-cols-4 md:gap-12">
        <div class="md:col-span-1 mb-8 md:mb-0">
            <div class="border-b border-[#222] pb-6 mb-6">
                <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Welcome Back</p>
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
                <a href="{{ route('profile.edit') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-[#222] group flex items-center transition">
                    <span class="w-1.5 h-1.5 bg-transparent rounded-full mr-3 group-hover:bg-gray-300 transition block"></span>
                    Profile Settings
                </a>
                <a href="{{ route('wishlist.dashboard') }}" class="text-xs font-bold uppercase tracking-widest text-[#222] group flex items-center transition">
                    <span class="w-1.5 h-1.5 bg-[#8C3B44] rounded-full mr-3"></span>
                    Wishlist
                </a>

                <form method="POST" action="{{ route('logout') }}" class="pt-6 mt-6 border-t border-gray-100">
                    @csrf
                    <button type="submit" class="text-xs font-bold uppercase tracking-widest text-red-500 hover:text-red-700 transition flex items-center">
                        <i class="fas fa-sign-out-alt mr-3"></i> Log Out
                    </button>
                </form>
            </nav>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-3">
            <!-- Wishlist Grid -->
            <div class="bg-white border border-gray-100 shadow-sm p-8 mb-8">
                <div class="flex justify-between items-end mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-2xl font-serif text-[#222]">My Wishlist</h3>
                </div>

                @if($wishlistItems->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($wishlistItems as $item)
                        @if($item->product)
                            <div class="product-card group border border-gray-100 hover:shadow-md transition duration-300 bg-white flex flex-col items-center">
                                <a href="{{ route('product.show', ['slug' => $item->product->slug]) }}" class="block w-full">
                                    <div class="overflow-hidden bg-gray-50 relative">
                                        <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="product-image group-hover:scale-105 transition duration-500">
                                    </div>
                                    <div class="p-6 product-title flex-col items-start w-full">
                                        <h4 class="font-serif text-[#222] text-sm mb-1 truncate">{{ $item->product->name }}</h4>
                                        <p class="text-xs text-gray-400">{{ $item->product->category->name ?? 'Skincare' }}</p>
                                    </div>
                                </a>
                                <div class="px-6 pb-6 pt-0 flex flex-col justify-between items-start product-price w-full mt-auto">
                                    <span class="font-bold text-[#222] text-sm mb-4">${{ number_format($item->product->price, 2) }}</span>
                                    
                                    <div class="flex gap-2 w-full">
                                        <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->product->id }}">
                                            <button type="submit" class="w-full text-center border border-[#222] text-[#222] py-2 text-[10px] uppercase font-bold tracking-widest hover:bg-[#222] hover:text-white transition rounded-sm">
                                                Add To Cart
                                            </button>
                                        </form>

                                        <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST" class="flex-none">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 border border-gray-200 text-gray-400 hover:text-red-500 hover:border-red-500 transition rounded-sm flex items-center justify-center">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="product-card group border border-gray-100 p-6 flex flex-col items-center justify-center bg-gray-50">
                                <p class="text-xs text-gray-400">Product Unavailable</p>
                            </div>
                        @endif
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="far fa-heart text-3xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Your wishlist is empty.</p>
                        <a href="{{ route('shop') }}" class="inline-block mt-4 text-xs uppercase font-bold tracking-widest text-[#222] border-b border-[#222] pb-1 hover:text-[var(--color-gold)] transition">Explore formulas</a>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
