@extends('layouts.store')

@section('title', 'Your Wishlist - ELAVA Skincare')

@section('content')
<div class="bg-[#FDFBF8] py-12 md:py-20 border-b border-[#F5EFEB]">
    <div class="container-base text-center inline-block w-full">
        <h1 class="font-serif text-4xl text-[#2F2F2F] tracking-tight mb-2 text-center">Your Wishlist</h1>
        <p class="text-sm text-[#2F2F2F]/70 font-light">Your curated skincare favorites saved for later.</p>
    </div>
</div>

<div class="container-base py-16 md:py-24">
    @if($wishlistItems && $wishlistItems->count() > 0)
        <div class="max-w-4xl mx-auto">
            <ul role="list" class="divide-y divide-gray-100 border-t border-b border-gray-100">
                @foreach($wishlistItems as $item)
                    <li class="flex py-8 sm:py-10 items-center">
                        <!-- Image -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('product.show', $item->product->slug) }}">
                                <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-32 h-40 object-cover object-center bg-gray-50 p-2 shadow-sm hover:scale-[1.02] transition">
                            </a>
                        </div>

                        <!-- Details -->
                        <div class="ml-6 flex-1 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                            <div class="mb-4 sm:mb-0">
                                <h3 class="text-sm font-medium text-[#2F2F2F]">
                                    <a href="{{ route('product.show', $item->product->slug) }}" class="hover:text-gray-500">{{ $item->product->name }}</a>
                                </h3>
                                <p class="mt-1 text-xs text-gray-500 uppercase tracking-widest">${{ number_format($item->product->price, 2) }}</p>
                            </div>

                            <div class="flex items-center space-x-4 w-full sm:w-auto">
                                <!-- Add to Cart -->
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1 sm:flex-none">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full sm:w-auto border border-[#2F2F2F] text-[#2F2F2F] px-6 py-2.5 text-xs uppercase tracking-widest font-bold hover:bg-[#2F2F2F] hover:text-white transition duration-300">
                                        Add To Cart
                                    </button>
                                </form>

                                <!-- Remove -->
                                <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 inline-flex text-gray-400 hover:text-red-500 transition" title="Remove">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20 bg-white border border-gray-100 shadow-sm max-w-3xl mx-auto">
            <i class="far fa-heart text-5xl text-gray-200 mb-6"></i>
            <h3 class="text-xl font-serif text-[#2F2F2F] mb-2">Your wishlist is empty</h3>
            <p class="text-sm text-gray-500 mb-8 max-w-sm mx-auto font-light leading-relaxed">Save your favorite skincare items for a rainy day.</p>
            <a href="{{ route('shop') }}" class="btn-primary">
                Explore The Collection
            </a>
        </div>
    @endif
</div>
@endsection
