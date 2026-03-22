@extends('layouts.store')

@section('title', 'ELAVA Skincare - Official Homepage')

@section('content')

<!-- Hero Section -->
<section class="relative w-full h-screen bg-[#F9F6F0] flex items-center justify-center overflow-hidden">
    <picture class="absolute inset-0 w-full h-full">
        <img src="/images/model_clear_skin.png" alt="Luxury Skincare" class="w-full h-full object-cover object-center" loading="lazy" decoding="async">
    </picture>

    
    <div class="container-base relative z-10 w-full flex items-center">
        <div x-data="{ reveal: false }" x-init="setTimeout(() => reveal = true, 300)" :class="reveal ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'" class="max-w-2xl text-left transition-all duration-1000 ease-out">
            <h4 class="text-sm font-bold tracking-[0.2em] text-[#8C3B44] uppercase mb-4">Discover The Secret</h4>
            <h1 class="font-serif text-5xl md:text-7xl mb-6 text-white leading-none">Reveal<br>Your<br>Natural<br>Radiance</h1>
            <a href="{{ route('shop') }}" class="inline-block bg-[#2F2F2F] text-white px-10 py-4 text-sm font-bold uppercase tracking-widest hover:bg-[#8C3B44] transition ease-in-out duration-300">
                Shop Now
            </a>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-24 bg-white">
    <div class="container-base">
        <div class="text-center mb-16">
            <h2 class="font-serif text-3xl md:text-4xl text-[#2F2F2F] mb-4">Featured Products</h2>
            <div class="w-16 h-0.5 bg-[#8C3B44] mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
                <div class="product-card group flex flex-col items-center bg-white border border-gray-100 hover:shadow-[0_25px_50px_-12px_rgba(140,59,68,0.07)] hover:-translate-y-2 transition-all duration-500 pb-6 rounded-sm overflow-hidden shadow-sm">
                    <a href="{{ route('product.show', $product->slug) }}" class="block w-full bg-[#FDFBF8] overflow-hidden shrink-0 relative mb-6">
                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image group-hover:scale-105 transition duration-500" loading="lazy" decoding="async">
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-[#2F2F2F] rounded-full shadow-sm">
                            Best Seller
                        </div>
                    </a>
                    <div class="text-center px-4 flex-grow flex flex-col w-full">
                        <div class="product-title flex-col text-center justify-center w-full">
                            <p class="text-[10px] uppercase tracking-widest text-[#8C3B44] mb-2">{{ $product->category->name ?? 'Skincare' }}</p>
                            <h3 class="text-sm font-semibold text-[#2F2F2F] mb-2 leading-tight"><a href="{{ route('product.show', $product->slug) }}" class="hover:text-[#8C3B44] transition">{{ $product->name }}</a></h3>
                        </div>
                        <div class="product-price mt-auto w-full text-center">
                            <p class="text-sm text-[#2F2F2F] font-bold mb-6">${{ number_format($product->price, 2) }}</p>
                            <form action="{{ route('cart.add') }}" method="POST" class="w-full mb-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full border border-[#2F2F2F] bg-transparent text-[#2F2F2F] py-3 text-xs uppercase tracking-widest font-bold hover:bg-[#2F2F2F] hover:text-white transition duration-300 rounded-sm">
                                    Add to Cart
                                </button>
                            </form>
                            <form action="{{ route('buyNow', $product->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full bg-[#2F2F2F] text-white py-3 text-xs uppercase tracking-widest font-bold hover:bg-[#1a1a1a] transition duration-300 rounded-sm">
                                    Buy Now
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        
        <div class="text-center mt-12">
             <a href="{{ route('shop') }}" class="inline-block border-b-2 border-transparent text-[#2F2F2F] pb-1 text-sm font-bold uppercase tracking-widest hover:border-[#2F2F2F] transition duration-300">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- Why Choose ELAVA Section -->
<section class="py-20 bg-[#FAF7F2] border-y border-gray-100">
    <div class="container-base">
        <div class="text-center mb-16">
            <h2 class="font-serif text-3xl md:text-4xl text-[#2F2F2F] mb-4">Why Choose ELAVA</h2>
            <div class="w-16 h-0.5 bg-[#8C3B44] mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 text-center">
            <div class="bg-white p-10 border border-gray-50 shadow-sm rounded-sm hover:-translate-y-2 hover:shadow-md hover:border-[#8C3B44]/10 transition-all duration-500">
                <i class="fas fa-leaf text-3xl text-[#8C3B44] mb-6 block"></i>
                <h3 class="font-bold text-sm uppercase tracking-widest mb-3 text-[#2F2F2F]">Clean Ingredients</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-light">Sourced directly from nature, strictly free of harmful toxins, parabens, and sulfates.</p>
            </div>
            <div class="bg-white p-10 border border-gray-100 shadow-sm rounded-sm hover:-translate-y-1 transition duration-300">
                <i class="fas fa-vial text-3xl text-[#8C3B44] mb-6 block"></i>
                <h3 class="font-bold text-sm uppercase tracking-widest mb-3 text-[#2F2F2F]">Clinically Proven</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-light">Formulated and rigorously tested by leading dermatologists for real, visible results.</p>
            </div>
            <div class="bg-white p-10 border border-gray-100 shadow-sm rounded-sm hover:-translate-y-1 transition duration-300">
                <i class="fas fa-paw text-3xl text-[#8C3B44] mb-6 block"></i>
                <h3 class="font-bold text-sm uppercase tracking-widest mb-3 text-[#2F2F2F]">Cruelty-Free</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-light">100% vegan formulations. We never test on animals and ethically source every element.</p>
            </div>
            <div class="bg-white p-10 border border-gray-100 shadow-sm rounded-sm hover:-translate-y-1 transition duration-300">
                <i class="fas fa-recycle text-3xl text-[#8C3B44] mb-6 block"></i>
                <h3 class="font-bold text-sm uppercase tracking-widest mb-3 text-[#2F2F2F]">Sustainable</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-light">Eco-friendly glass packaging meticulously designed for a better, healthier planet.</p>
            </div>
        </div>
    </div>
</section>

<!-- Brand Story Section -->
<section class="py-24 bg-white">
    <div class="container-base flex flex-col md:flex-row items-center gap-16">
        <div class="w-full md:w-1/2">
            <picture>
                <source srcset="https://images.unsplash.com/photo-1596755389378-c31d21fd1273?auto=format&fit=crop&w=800&q=80&fm=webp" type="image/webp">
                <img src="https://images.unsplash.com/photo-1596755389378-c31d21fd1273?auto=format&fit=crop&w=800&q=80" alt="ELAVA Brand Story" class="w-full h-[550px] object-cover shadow-sm bg-gray-50" loading="lazy" decoding="async">
            </picture>
        </div>
        <div class="w-full md:w-1/2 text-center md:text-left">
            <h4 class="text-sm font-bold tracking-[0.2em] text-[#8C3B44] uppercase mb-4">Our Heritage</h4>
            <h2 class="font-serif text-4xl md:text-5xl text-[#2F2F2F] mb-6 leading-tight">The Essence of Elava.</h2>
            <div class="text-gray-600 font-light leading-relaxed mb-8 space-y-4">
                <p>
                    Born from a passion for botanical healing, ELAVA Skincare combines ancient natural wisdom with modern clinical science. We believe that caring for your skin should be a luxurious, uncompromising ritual that brings you closer to your most authentic self.
                </p>
                <p>
                    Every serum, cleanser, and cream is meticulously crafted in small batches using only the highest grade, ethically sourced ingredients. We bring you the absolute best in skin refinement, ensuring purity and potency in every drop.
                </p>
            </div>
            <a href="{{ route('shop') }}" class="inline-block border-b-2 border-[#2F2F2F] pb-1 font-bold text-xs tracking-widest uppercase text-[#2F2F2F] hover:text-[#8C3B44] hover:border-[#8C3B44] transition">
                Discover Our Process
            </a>
        </div>
    </div>
</section>

<!-- Customer Reviews Section -->
<section class="py-24 bg-[#FDFBF8] border-t border-gray-100">
    <div class="container-base text-center">
        <h4 class="text-sm font-bold tracking-[0.2em] text-[#8C3B44] uppercase mb-4">Testimonials</h4>
        <h2 class="font-serif text-3xl md:text-4xl text-[#2F2F2F] mb-16">What Our Clients Say</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-10 border border-gray-100 shadow-sm rounded-sm text-center">
                <div class="flex justify-center text-yellow-400 text-xs space-x-1 mb-6">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <h3 class="font-serif text-xl text-[#2F2F2F] mb-4">Transformed My Skin</h3>
                <p class="text-sm text-gray-500 italic font-light leading-relaxed mb-6">"I have been using the ELAVA serum for a month, and my skin has never felt this hydrated and glowing. Truly a life-changing product for my daily routine."</p>
                <p class="text-xs uppercase tracking-widest font-bold text-[#2F2F2F]">- Sarah J.</p>
            </div>
            
            <div class="bg-white p-10 border border-gray-100 shadow-sm rounded-sm text-center">
                <div class="flex justify-center text-yellow-400 text-xs space-x-1 mb-6">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <h3 class="font-serif text-xl text-[#2F2F2F] mb-4">Luxurious Feeling</h3>
                <p class="text-sm text-gray-500 italic font-light leading-relaxed mb-6">"The textures and natural scents are unbelievable. It feels like a high-end spa treatment every night in my own bathroom. Highly recommend the cleanser."</p>
                <p class="text-xs uppercase tracking-widest font-bold text-[#2F2F2F]">- Emma W.</p>
            </div>
            
            <div class="bg-white p-10 border border-gray-100 shadow-sm rounded-sm text-center">
                <div class="flex justify-center text-yellow-400 text-xs space-x-1 mb-6">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
                <h3 class="font-serif text-xl text-[#2F2F2F] mb-4">Clean & Effective</h3>
                <p class="text-sm text-gray-500 italic font-light leading-relaxed mb-6">"It's rare to find a brand that is truly clean but still delivers visible results. My blemishes have faded and my skin tone is completely evened out."</p>
                <p class="text-xs uppercase tracking-widest font-bold text-[#2F2F2F]">- Jessica M.</p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-24 bg-[#EAE5DE] text-center px-4">
    <div class="container-base">
        <div class="max-w-2xl mx-auto">
            <h2 class="font-serif text-3xl md:text-4xl mb-4 text-[#2F2F2F] tracking-wide">Join The Elava Society</h2>
            <p class="text-sm text-[#2F2F2F] mb-10 font-light leading-relaxed">Subscribe to our newsletter for exclusive offers, early access to new launches, and expert skincare advice straight to your inbox.</p>
            <form class="flex flex-col sm:flex-row shadow-sm rounded-sm overflow-hidden border border-gray-200 bg-white">
                <input type="email" placeholder="Enter your email address" class="w-full border-none bg-white text-[#2F2F2F] placeholder-gray-400 px-6 py-4 outline-none focus:ring-0 text-sm">
                <button type="button" class="bg-[#2F2F2F] text-white px-10 py-4 text-sm font-bold uppercase tracking-widest hover:bg-black transition whitespace-nowrap">
                    Subscribe
                </button>
            </form>
        </div>
    </div>
</section>

@endsection
