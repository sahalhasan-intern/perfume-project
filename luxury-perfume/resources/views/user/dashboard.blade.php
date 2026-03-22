@extends('layouts.store')

@section('title', 'My Dashboard - ELAVA Skincare')

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
                <a href="{{ route('dashboard') }}" class="text-xs font-bold uppercase tracking-widest {{ !request('category') ? 'text-[#222]' : 'text-gray-400' }} group flex items-center transition">
                    <span class="w-1.5 h-1.5 {{ !request('category') ? 'bg-[var(--color-gold)]' : 'bg-transparent' }} rounded-full mr-3"></span>
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
                <a href="{{ route('wishlist.dashboard') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-[#222] group flex items-center transition">
                    <span class="w-1.5 h-1.5 bg-transparent rounded-full mr-3 group-hover:bg-gray-300 transition block"></span>
                    Wishlist
                </a>

                <!-- Category Filtering -->
                <div class="pt-6 mt-6 border-t border-gray-100">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-[#222] mb-4">Categories</h4>
                    
                    @foreach($categoriesGrouped as $group => $cats)
                        @if($cats->count() > 0)
                            <div class="mb-4">
                                <p class="text-[10px] uppercase font-bold tracking-wider text-gray-400 mb-2">{{ $group }}</p>
                                <div class="space-y-2 pl-2">
                                    @foreach($cats as $cat)
                                        <a href="{{ route('dashboard', ['category' => $cat->slug]) }}" 
                                           class="block text-xs text-gray-500 hover:text-[#222] transition {{ isset($selectedCategory) && $selectedCategory->id == $cat->id ? 'text-[#222] font-semibold flex items-center' : '' }}">
                                            @if(isset($selectedCategory) && $selectedCategory->id == $cat->id)
                                                <span class="w-1 h-1 bg-[var(--color-gold)] rounded-full mr-1.5"></span>
                                            @endif
                                            {{ $cat->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <!-- End Category Filtering -->
                
                <form method="POST" action="{{ route('logout') }}" class="pt-6 mt-6 border-t border-gray-100">
                    @csrf
                    <button type="submit" class="text-xs font-bold uppercase tracking-widest text-red-500 hover:text-red-700 transition flex items-center">
                        <i class="fas fa-sign-out-alt mr-3"></i> Log Out
                    </button>
                </form>
            </nav>

        </div>
        
        <div class="mt-5 md:mt-0 md:col-span-3">
            <!-- Products Dashboard Grid -->
            <div class="bg-white border border-gray-100 shadow-sm p-8 mb-8">
                <div class="flex justify-between items-end mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-2xl font-serif text-[#222]">
                        {{ $selectedCategory ? $selectedCategory->name : 'Our Collection' }}
                    </h3>
                    @if($selectedCategory)
                        <a href="{{ route('dashboard') }}" class="text-xs uppercase tracking-widest font-bold text-[#222] border-b border-[#222] pb-1 hover:text-[var(--color-gold)] hover:border-[var(--color-gold)] transition">View All</a>
                    @endif
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="product-card group border border-gray-100 hover:shadow-md transition duration-300 bg-white">
                                <a href="{{ route('product.show', ['slug' => $product->slug]) }}" class="block">
                                    <div class="overflow-hidden bg-gray-50 relative">
                                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image group-hover:scale-105 transition duration-500">
                                    </div>
                                    <div class="p-6 product-title flex-col items-start w-full">
                                        <h4 class="font-serif text-[#222] text-sm mb-1 truncate">{{ $product->name }}</h4>
                                        <p class="text-xs text-gray-400">{{ $product->category->name ?? 'Skincare' }}</p>
                                    </div>
                                </a>
                                <div class="px-6 pb-6 pt-0 flex justify-between items-center product-price w-full">
                                    <span class="font-bold text-[#222] text-sm">${{ number_format($product->price, 2) }}</span>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <button type="submit" class="text-xs uppercase font-bold tracking-widest text-[#222] hover:text-[var(--color-gold)] transition">Add</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach


                    </div>
                    
                    <div class="mt-8">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-boxes text-3xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No products found in this category.</p>
                    </div>
                @endif
            </div>

            <!-- Recent Orders -->
            <div class="bg-white border border-gray-100 shadow-sm p-8">
                <div class="flex justify-between items-end mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-xl font-serif text-[#222]">Recent Orders</h3>
                    <a href="{{ route('orders.index') }}" class="text-xs uppercase tracking-widest font-bold text-[#222] border-b border-[#222] pb-1 hover:text-[var(--color-gold)] hover:border-[var(--color-gold)] transition">View All</a>
                </div>
                
                <div>
                    @if($orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-100 text-xs uppercase tracking-widest text-gray-400 font-bold bg-gray-50">
                                        <th class="py-4 px-6 font-medium">Order ID</th>
                                        <th class="py-4 px-6 font-medium">Date</th>
                                        <th class="py-4 px-6 font-medium">Total</th>
                                        <th class="py-4 px-6 font-medium">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @foreach($orders->take(5) as $order)
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                            <td class="py-6 px-6 font-serif font-bold text-[#222]">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                            <td class="py-6 px-6 text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="py-6 px-6 font-medium text-[#222]">${{ number_format($order->total, 2) }}</td>
                                            <td class="py-6 px-6">
                                                <span class="bg-gray-100 text-gray-800 text-[10px] uppercase tracking-wider px-3 py-1 rounded-full font-bold">{{ ucfirst($order->status) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-500 font-light text-sm">You haven't placed any orders yet.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                <div class="bg-[var(--color-pink)] p-8">
                    <h4 class="text-lg font-serif text-[#222] mb-3">ELAVA Society</h4>
                    <p class="text-sm text-gray-600 font-light mb-6 line-clamp-3">You are a valued member of the ELAVA Society. Enjoy complimentary shipping on all orders and exclusive early access to our newest luxury botanical discoveries.</p>
                    <a href="{{ route('shop') }}" class="text-xs uppercase tracking-widest font-bold text-[#222] border-b border-[#222] pb-1 hover:text-[var(--color-gold)] transition">Shop Now</a>
                </div>
                <div class="bg-[var(--color-beige)] p-8">
                    <h4 class="text-lg font-serif text-[#222] mb-3">Skin Consultation</h4>
                    <p class="text-sm text-gray-600 font-light mb-6 line-clamp-3">Not sure what your skin needs? Discover your perfect ritual tailored to awaken your skin's true radiance and timeless beauty.</p>
                    <a href="#" class="text-xs uppercase tracking-widest font-bold text-[#222] border-b border-[#222] pb-1 hover:text-[var(--color-gold)] transition">Take the Quiz</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
