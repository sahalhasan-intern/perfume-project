@extends('layouts.store')

@section('title', 'Your Cart - ELAVA Skincare')

@section('content')
<div class="bg-[#FDFBF8] py-12 md:py-20 border-b border-[#F5EFEB]">
    <div class="container-base text-center inline-block w-full">
        <h1 class="font-serif text-4xl text-[#2F2F2F] tracking-tight mb-2 text-center">Shopping Bag</h1>
        <p class="text-sm text-[#2F2F2F]/70 font-light">Your curated skincare ritual awaits.</p>
    </div>
</div>

<div class="container-base py-16 md:py-24">
    @if(session('cart') && count(session('cart')) > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            <!-- Left: Cart Items -->
            <div class="lg:col-span-8">
                <ul role="list" class="divide-y divide-gray-100 border-t border-b border-gray-100">
                    @php $total = 0; @endphp
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        <li class="flex py-8 sm:py-10">
                            <!-- Image -->
                            <div class="flex-shrink-0">
                                <a href="{{ route('product.show', $details['slug'] ?? \Illuminate\Support\Str::slug($details['name'])) }}">
                                    <img src="{{ Str::startsWith($details['image'], 'http') ? $details['image'] : asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-32 h-40 object-cover object-center bg-gray-50 p-2 shadow-sm hover:scale-[1.02] transition">
                                </a>
                            </div>

                            <!-- Details -->
                            <div class="ml-6 flex-1 flex flex-col justify-between">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-sm font-medium text-[#2F2F2F]">
                                            <a href="{{ route('product.show', $details['slug'] ?? \Illuminate\Support\Str::slug($details['name'])) }}" class="hover:text-gray-500">{{ $details['name'] }}</a>
                                        </h3>
                                        <p class="mt-1 text-xs text-gray-500 uppercase tracking-widest">${{ number_format($details['price'], 2) }}</p>

                                    </div>
                                    <form action="{{ route('cart.remove') }}" method="POST">

                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="-m-2 p-2 inline-flex text-gray-400 hover:text-red-500 transition">
                                            <span class="sr-only">Remove</span>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="mt-6 flex flex-1 items-end justify-between">
                                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        
                                        <div class="border border-gray-200 bg-white flex items-center h-10">
                                            <label for="quantity-{{ $id }}" class="sr-only">Quantity</label>
                                            <select id="quantity-{{ $id }}" name="quantity" class="w-20 pl-4 py-2 text-center outline-none text-xs bg-transparent cursor-pointer text-gray-700" onchange="this.form.submit()">
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}" {{ $details['quantity'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </form>
                                    <p class="text-sm font-medium text-[#2F2F2F] tracking-wide">${{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Right: Order Summary -->
            <div class="mt-16 bg-[#FDFBF8] p-8 lg:mt-0 lg:col-span-4 border border-[#F5EFEB] shadow-sm">
                <h2 id="summary-heading" class="text-sm font-bold text-[#2F2F2F] uppercase tracking-widest mb-6">Order Summary</h2>

                <dl class="space-y-4 border-b border-gray-100 pb-6">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Subtotal</dt>
                        <dd class="text-sm font-medium text-[#2F2F2F] tracking-wide">${{ number_format($total, 2) }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="flex flex-col">
                            <span class="text-sm text-gray-600">Complimentary Shipping</span>
                        </dt>
                        <dd class="text-sm font-medium tracking-wide">Included</dd>
                    </div>
                </dl>

                <div class="flex items-center justify-between pt-6 mb-8">
                    <dt class="text-sm font-bold text-[#2F2F2F] uppercase tracking-widest">Total</dt>
                    <dd class="text-lg font-serif text-[#2F2F2F]">${{ number_format($total, 2) }}</dd>
                </div>

                <a href="{{ route('checkout.index') }}" class="w-full bg-[#2F2F2F] text-white py-4 text-xs font-bold uppercase tracking-widest hover:bg-black transition text-center block shadow-sm border border-[#2F2F2F]">
                    Secure Checkout
                </a>
                
                <div class="mt-6 flex items-center justify-center space-x-2 text-gray-400">
                    <i class="fas fa-lock text-[10px]"></i>
                    <span class="text-[10px] uppercase tracking-widest font-bold">Encrypted & Secure</span>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20 bg-white border border-gray-100 shadow-sm max-w-3xl mx-auto">
            <i class="fas fa-shopping-bag text-5xl text-gray-200 mb-6"></i>
            <h3 class="text-xl font-serif text-[#2F2F2F] mb-2">Your ritual bag is empty</h3>
            <p class="text-sm text-gray-500 mb-8 max-w-sm mx-auto font-light leading-relaxed">It seems you haven't selected any luxury skincare formulas yet.</p>
            <a href="{{ route('shop') }}" class="btn-primary">
                Explore The Collection
            </a>
        </div>
    @endif
</div>
@endsection
