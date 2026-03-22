@extends('layouts.store')

@section('title', 'About Us - ELAVA Skincare')

@section('content')
<div class="container-base py-20">
    <div class="max-w-4xl mx-auto text-center mb-16">
        <h1 class="text-5xl font-serif text-[#2F2F2F] mb-6 tracking-wide">The Story of ELAVA</h1>
        <div class="w-20 h-px bg-[#8C3B44] mx-auto mb-8"></div>
        <p class="text-gray-600 mb-8 leading-loose text-lg font-light px-4 md:px-12">
            Founded on the belief that beauty should be uncompromising, ELAVA Skincare bridges the gap between nature's purity and scientific efficacy. We craft premium, luxury formulations rigorously tested to reveal your natural radiance, allowing your skin to thrive at any age.
        </p>
        
        <div class="mt-12 w-full">
            <img src="{{ asset('images/model_applying_serum.png') }}" class="w-full h-[400px] md:h-[600px] object-cover rounded-sm border border-gray-100 shadow-sm" alt="Model applying ELAVA Skincare serum">
        </div>
    </div>

    <!-- Core Values Section -->
    <div class="bg-[#FDFBF8] py-16 px-4 md:px-12 border-y border-gray-100 mt-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-5xl mx-auto">
            <div class="text-center group p-4">
                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm mb-6 border border-gray-50 group-hover:-translate-y-2 transition duration-300">
                    <i class="fas fa-leaf text-[#8C3B44] text-xl"></i>
                </div>
                <h3 class="font-serif text-xl tracking-wide text-[#2F2F2F] mb-3">Clean Ingredients</h3>
                <p class="text-gray-500 font-light text-sm leading-relaxed">
                    We source only the highest quality botanical ingredients, ensuring every drop is free from harmful toxins, parabens, and synthetic fragrances.
                </p>
            </div>

            <div class="text-center group p-4">
                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm mb-6 border border-gray-50 group-hover:-translate-y-2 transition duration-300">
                    <i class="fas fa-flask text-[#8C3B44] text-xl"></i>
                </div>
                <h3 class="font-serif text-xl tracking-wide text-[#2F2F2F] mb-3">Clinically Proven</h3>
                <p class="text-gray-500 font-light text-sm leading-relaxed">
                    Our formulas are developed with leading dermatologists to ensure they don't just feel deeply luxurious, but deliver visible, long-lasting results.
                </p>
            </div>

            <div class="text-center group p-4">
                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm mb-6 border border-gray-50 group-hover:-translate-y-2 transition duration-300">
                    <i class="fas fa-paw text-[#8C3B44] text-xl"></i>
                </div>
                <h3 class="font-serif text-xl tracking-wide text-[#2F2F2F] mb-3">Cruelty-Free</h3>
                <p class="text-gray-500 font-light text-sm leading-relaxed">
                    We believe in beauty without harm. We are proudly certified cruelty-free, and none of our products or raw materials are ever tested on animals.
                </p>
            </div>
        </div>
    </div>
    
    <!-- Closing Statement -->
    <div class="max-w-3xl mx-auto text-center mt-20 mb-10 px-4">
        <h2 class="text-3xl font-serif text-[#2F2F2F] mb-6">Our Commitment to You</h2>
        <p class="text-gray-600 leading-relaxed font-light text-md">
            Every product in our collection is meticulously crafted to nourish, protect, and rejuvenate your skin. The ELAVA philosophy is simple: we ensure that you always feel confident, beautiful, and entirely empowered in your own skin.
        </p>
        <a href="{{ route('shop') }}" class="inline-block mt-10 px-10 py-3 bg-[#8C3B44] text-white text-sm uppercase tracking-widest font-bold hover:bg-[#2F2F2F] transition duration-300">Explore Collection</a>
    </div>
</div>
@endsection
