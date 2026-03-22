@extends('layouts.store')

@section('title', 'Shop - ELAVA Skincare')

@section('content')
<div class="bg-[#FDFBF8] py-12 md:py-20 border-b border-[#F5EFEB]">
    <div class="container-base text-center inline-block w-full">
        <h1 class="font-serif text-4xl text-[#2F2F2F] tracking-tight mb-4 text-center">Shop The Collection</h1>
        <p class="text-sm text-[#2F2F2F]/70 max-w-lg mx-auto font-light leading-relaxed">Discover our full range of clean, clinical skincare designed for real results.</p>
    </div>
</div>

<div class="container-base py-12 md:py-16">
    
    <!-- Top Filters -->
    <div class="mb-12 flex flex-col md:flex-row justify-between items-center border-b border-[#F5EFEB] pb-6 gap-6">
        <form action="{{ route('shop') }}" method="GET" id="filter-form" class="w-full flex flex-col md:flex-row gap-6 justify-between items-center">
            
            <div class="flex items-center space-x-4">
                <span class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Category</span>
                <select name="category" onchange="document.getElementById('filter-form').submit()" class="text-sm border border-gray-200 bg-white py-2 px-4 outline-none cursor-pointer text-[#2F2F2F] font-medium shadow-sm hover:border-[#2F2F2F] transition rounded-sm">
                    <option value="">All Collections</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-4">
                    <span class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Sort By</span>
                    <select name="sort" onchange="document.getElementById('filter-form').submit()" class="text-sm border border-gray-200 bg-white py-2 px-4 outline-none cursor-pointer text-[#2F2F2F] font-medium shadow-sm hover:border-[#2F2F2F] transition rounded-sm">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                        <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>Price: Low - High</option>
                        <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>Price: High - Low</option>
                    </select>
                </div>
                
                <div class="hidden md:block pl-6 border-l border-gray-200 text-xs text-gray-400 uppercase tracking-widest font-bold">
                    {{ $products->total() }} results
                </div>
            </div>
            
        </form>
    </div>

    <!-- Product Grid -->
    <div>
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="product-card bg-white group cursor-pointer border border-transparent hover:border-gray-100 transition duration-500 overflow-hidden shadow-sm hover:shadow-md">
                        <a href="{{ route('product.show', $product->slug) }}" class="block mb-4 overflow-hidden relative p-1 bg-white">
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image group-hover:scale-105 transition duration-700 ease-in-out">
                        </a>
                        <div class="p-6 pt-2 text-center flex-grow flex flex-col">
                            <div class="product-title flex-col text-center justify-center w-full">
                                <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">{{ $product->category->name }}</p>
                                <h3 class="text-sm font-medium text-[#2F2F2F] mb-3 leading-tight"><a href="{{ route('product.show', $product->slug) }}" class="hover:text-[#8C3B44] transition">{{ $product->name }}</a></h3>
                            </div>
                            <div class="product-price mt-auto text-center w-full">
                                <p class="text-sm text-[#2F2F2F] font-medium mb-6">${{ number_format($product->price, 2) }}</p>
                                <form action="{{ route('cart.add') }}" method="POST" class="w-full mb-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full border border-[#2F2F2F] text-[#2F2F2F] py-3 text-xs uppercase tracking-widest font-bold hover:bg-[#2F2F2F] hover:text-white transition duration-300">
                                        Add to Cart
                                    </button>
                                </form>
                                <form action="{{ route('buyNow', $product->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full bg-[#2F2F2F] text-white py-3 text-xs uppercase tracking-widest font-bold hover:bg-[#1a1a1a] transition duration-300">
                                        Buy Now
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            
            <!-- Pagination -->
            <div class="mt-16 flex justify-center border-t border-[#F5EFEB] pt-10">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-24 bg-white border border-[#F5EFEB] shadow-sm max-w-2xl mx-auto mt-10">
                <i class="fas fa-search text-4xl text-gray-200 mb-4"></i>
                <h3 class="text-xl font-serif text-[#2F2F2F] mb-2">No products found</h3>
                <p class="text-sm text-gray-500 mb-8 font-light">We couldn't find any products matching your current filters.</p>
                <a href="{{ route('shop') }}" class="btn-primary hover:-translate-y-1 transform shadow-sm">Clear Filters</a>
            </div>
        @endif
    </div>
</div>
@endsection
