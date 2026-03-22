@extends('layouts.store')

@section('title', $product->name . ' - ELAVA Skincare')

@section('content')

<!-- Breadcrumbs -->
<div class="bg-gray-50 border-b border-gray-100 py-4">
    <div class="container-base">
        <nav class="flex text-[10px] uppercase tracking-widest text-gray-500 space-x-2">
            <a href="{{ route('home') }}" class="hover:text-black transition">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('shop') }}" class="hover:text-black transition">Shop</a>
            <span class="mx-2">/</span>
            <span class="text-[#2F2F2F] font-bold">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<!-- Product Details -->
<div class="container-base py-16 md:py-24">
    <div class="flex flex-col md:flex-row gap-16 lg:gap-24">
        
        <!-- Left Column: Image -->
        <div class="w-full md:w-1/2">
            <div class="sticky top-28 bg-gray-50">
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-sm shadow-sm hover:scale-[1.02] transition duration-700">
            </div>
        </div>
        
        <!-- Right Column: Info -->
        <div class="w-full md:w-1/2 flex flex-col justify-center">
            
            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-3 border-b border-gray-100 inline-block pb-1">{{ $product->category->name }}</p>
            <h1 class="font-serif text-4xl lg:text-5xl text-[#2F2F2F] mb-6 leading-tight">{{ $product->name }}</h1>
            
            <p class="text-2xl text-gray-600 mb-8">${{ number_format($product->price, 2) }}</p>
            
            <div class="prose prose-sm text-gray-600 leading-loose mb-10 border-b border-gray-100 pb-10">
                <p>{{ $product->description }}</p>
            </div>

            <!-- Stock Status -->
            <div class="mb-8">
                @if($product->stock > 0)
                    <div class="flex items-center text-xs text-green-700 tracking-wide bg-green-50 px-3 py-1.5 rounded-sm inline-flex">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                        In Stock (Ships in 24hr)
                    </div>
                @else
                    <div class="flex items-center text-xs text-red-700 tracking-wide bg-red-50 px-3 py-1.5 rounded-sm inline-flex">
                        <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                        Currently Unavailable
                    </div>
                @endif
            </div>

            <!-- Add to Cart Form -->
            <div class="mb-4">
                <form action="{{ route('cart.add') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="relative w-full sm:w-32 border border-gray-200 bg-white">
                        <label for="quantity" class="sr-only">Quantity</label>
                        <select id="quantity" name="quantity" class="w-full h-14 pl-4 pr-10 text-center appearance-none outline-none focus:ring-0 text-sm bg-transparent cursor-pointer text-gray-700">
                            @for($i = 1; $i <= min(5, max(1, $product->stock)); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
                    </div>

                    <button type="submit" class="flex-grow bg-[#2F2F2F] text-white h-14 uppercase text-xs tracking-widest font-bold hover:bg-black transition disabled:opacity-50 disabled:cursor-not-allowed" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        {{ $product->stock > 0 ? 'Add to Ritual' : 'Sold Out' }}
                    </button>
                </form>
            </div>

            @if($product->stock > 0)
            <div class="mb-4">
                <form action="{{ route('buyNow', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full border border-[#2F2F2F] text-[#2F2F2F] h-14 uppercase text-xs tracking-widest font-bold hover:bg-[#2F2F2F] hover:text-white transition">
                        Buy Now
                    </button>
                </form>
            </div>
            @endif

            @php
                $wishlistIds = [];
                if(auth()->check()) {
                    $wishlistIds = \App\Models\Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray();
                }
            @endphp

            <div class="mb-12">
                <div class="wishlist-icon cursor-pointer" data-id="{{ $product->id }}">
                    <button type="button" class="wishlist-btn w-full bg-[#FAF7F2] border border-[#F5EFEB] text-[#2F2F2F] h-14 uppercase text-xs tracking-widest font-bold hover:bg-[#F5EFEB] transition flex items-center justify-center gap-2">
                        <span class="wishlist-text">{{ in_array($product->id, $wishlistIds) ? 'Remove From Wishlist' : 'Add To Wishlist' }}</span>
                        <i class="heart-icon fa-heart {{ in_array($product->id, $wishlistIds) ? 'fas text-red-500 active' : 'far text-gray-400' }}"></i>
                    </button>
                </div>
            </div>

            <!-- Accordion Details (AlpineJS) -->
            <div class="border-t border-gray-100 divide-y divide-gray-100" x-data="{ active: 1 }">
                
                <div class="py-5">
                    <button @click="active = active === 1 ? null : 1" class="flex justify-between items-center w-full text-left text-sm font-bold uppercase tracking-widest text-[#2F2F2F] hover:text-gray-500 transition">
                        Benefits
                        <span x-text="active === 1 ? '-' : '+'" class="text-xl font-light"></span>
                    </button>
                    <div x-show="active === 1" x-collapse x-cloak class="mt-4 text-sm text-gray-600 leading-relaxed font-light pb-2">
                        {{ $product->benefits ?? 'Clinically formulated for optimal results and barrier repair.' }}
                    </div>
                </div>

                <div class="py-5">
                    <button @click="active = active === 2 ? null : 2" class="flex justify-between items-center w-full text-left text-sm font-bold uppercase tracking-widest text-[#2F2F2F] hover:text-gray-500 transition">
                        Key Ingredients
                        <span x-text="active === 2 ? '-' : '+'" class="text-xl font-light"></span>
                    </button>
                    <div x-show="active === 2" x-collapse x-cloak class="mt-4 text-sm text-gray-600 leading-relaxed font-light pb-2">
                        {{ $product->ingredients ?? 'Clean, active ingredients sourced globally for purity and potency.' }}
                    </div>
                </div>

                <div class="py-5">
                    <button @click="active = active === 3 ? null : 3" class="flex justify-between items-center w-full text-left text-sm font-bold uppercase tracking-widest text-[#2F2F2F] hover:text-gray-500 transition">
                        Shipping & Returns
                        <span x-text="active === 3 ? '-' : '+'" class="text-xl font-light"></span>
                    </button>
                    <div x-show="active === 3" x-collapse x-cloak class="mt-4 text-sm text-gray-600 leading-relaxed font-light pb-2">
                        Complimentary standard shipping on all orders over $50. Unopened products can be returned within 30 days of purchase for a full refund.
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Reviews Section -->
<div class="bg-gray-50 py-16 md:py-24 border-t border-gray-100">
    <div class="container-base max-w-4xl mx-auto">
        <h2 class="font-serif text-3xl mb-12 text-[#2F2F2F] text-center">Customer Reviews</h2>
        
        @if($product->reviews && $product->reviews->count() > 0)
            <div class="space-y-8">
                @foreach($product->reviews as $review)
                    <div class="bg-white p-6 md:p-8 shadow-sm">
                        <div class="flex items-center justify-between mb-4 text-[#D4AF37] text-xs">
                            <div>
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < $review->rating)
                                        <i class="fas fa-star text-yellow-400"></i>
                                    @else
                                        <i class="far fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-gray-400 tracking-wider">{{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        <p class="text-sm text-gray-700 italic leading-relaxed mb-4">"{{ $review->comment }}"</p>
                        <p class="text-[10px] uppercase tracking-widest font-bold text-gray-500">- {{ $review->user->name ?? 'Verified Buyer' }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center bg-white p-12 border border-gray-100 shadow-sm">
                <i class="far fa-comment-dots text-3xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-sm mb-6">Be the first to review this product.</p>
                <button class="border border-[#2F2F2F] text-[#2F2F2F] px-8 py-3 text-xs uppercase tracking-widest hover:bg-[#2F2F2F] hover:text-white transition cursor-not-allowed opacity-50">Write a Review</button>
            </div>
        @endif
    </div>
</div>

<!-- Custom CSS for Alpine Transition -->
<style>
    [x-cloak] { display: none !important; }
</style>

@endsection
