@extends('layouts.store')

@section('title', 'Secure Checkout - ELAVA Skincare')

@section('content')
<div class="bg-[#FDFBF8] py-12 md:py-20 border-b border-[#F5EFEB]">
    <div class="container-base text-center inline-block w-full">
        <h1 class="font-serif text-3xl md:text-4xl text-[#2F2F2F] tracking-tight mb-2 text-center">Secure Checkout</h1>
        <p class="text-sm text-[#2F2F2F]/70 font-light">Complete your order with peace of mind.</p>
    </div>
</div>

<div class="bg-white">
    <div class="container-base py-16 md:py-24">
        
        <form action="{{ route('checkout.process') }}" method="POST" class="lg:grid lg:grid-cols-12 lg:gap-x-16 xl:gap-x-24">
            @csrf

            <!-- Left: Shipping Information -->
            <div class="lg:col-span-7">
                <div class="border-b border-gray-100 pb-10">
                    <h2 class="text-xs font-bold text-[#2F2F2F] uppercase tracking-widest border-b border-gray-100 pb-4 mb-8">Shipping Information</h2>

                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" class="block w-full border-gray-300 shadow-sm focus:ring-[#2F2F2F] focus:border-[#2F2F2F] sm:text-sm bg-white p-3 outline-none transition" required>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="shipping_address" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Full Shipping Address</label>
                            <textarea id="shipping_address" name="shipping_address" rows="3" class="block w-full border-gray-300 shadow-sm focus:ring-[#2F2F2F] focus:border-[#2F2F2F] sm:text-sm bg-white p-3 outline-none transition" required placeholder="Street address, City, ZIP code, Country"></textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="phone" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Phone Number</label>
                            <input type="tel" name="phone" id="phone" autocomplete="tel" class="block w-full border-gray-300 shadow-sm focus:ring-[#2F2F2F] focus:border-[#2F2F2F] sm:text-sm bg-white p-3 outline-none transition" required>
                        </div>
                    </div>
                </div>

                <div class="mt-10" x-data="{ payment: 'stripe' }">
                    <h2 class="text-xs font-bold text-[#2F2F2F] uppercase tracking-widest border-b border-gray-100 pb-4 mb-8">Payment Method</h2>
                    
                    <div class="space-y-4">
                        <!-- Stripe / Credit Card -->
                        <label class="relative border border-gray-200 p-5 flex cursor-pointer bg-[#FDFBF8] hover:border-[#2F2F2F] transition items-center group">
                            <input type="radio" name="payment_method" value="stripe" x-model="payment" class="peer sr-only" checked>
                            <div class="w-4 h-4 rounded-full border flex items-center justify-center mr-4 transition-all"
                                 :class="payment === 'stripe' ? 'border-[#2F2F2F] bg-[#2F2F2F]' : 'border-gray-300'">
                                <div class="w-1.5 h-1.5 rounded-full bg-white opacity-0" :class="{ 'opacity-100': payment === 'stripe' }"></div>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-[#2F2F2F] uppercase tracking-wider">Credit or Debit Card</p>
                            </div>
                            <div class="flex space-x-3 text-xl text-gray-400">
                                <i class="fab fa-cc-visa shadow-sm bg-white"></i>
                                <i class="fab fa-cc-mastercard shadow-sm bg-white"></i>
                                <i class="fab fa-stripe shadow-sm bg-white"></i>
                            </div>
                        </label>

                        <!-- Mock Stripe Input UI -->
                        <div x-show="payment === 'stripe'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="p-6 bg-white border border-t-0 border-gray-200 mt-0 shadow-inner">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Card Number</label>
                                    <input type="text" placeholder="0000 0000 0000 0000" class="block w-full border-gray-300 shadow-sm focus:ring-[#2F2F2F] focus:border-[#2F2F2F] sm:text-sm p-3 font-mono text-gray-600 transition tracking-widest">
                                </div>
                                <div class="flex space-x-4">
                                    <div class="w-1/2">
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Expiry Date</label>
                                        <input type="text" placeholder="MM / YY" class="block w-full border-gray-300 shadow-sm focus:ring-[#2F2F2F] focus:border-[#2F2F2F] sm:text-sm p-3 font-mono text-gray-600 transition tracking-widest">
                                    </div>
                                    <div class="w-1/2">
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">CVC</label>
                                        <input type="password" placeholder="123" class="block w-full border-gray-300 shadow-sm focus:ring-[#2F2F2F] focus:border-[#2F2F2F] sm:text-sm p-3 font-mono text-gray-600 transition tracking-widest">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PayPal -->
                        <label class="relative border border-gray-200 p-5 flex cursor-pointer bg-white hover:border-[#00457C] transition items-center group">
                            <input type="radio" name="payment_method" value="paypal" x-model="payment" class="peer sr-only">
                            <div class="w-4 h-4 rounded-full border flex items-center justify-center mr-4 transition-all"
                                 :class="payment === 'paypal' ? 'border-[#00457C] bg-[#00457C]' : 'border-gray-300'">
                                <div class="w-1.5 h-1.5 rounded-full bg-white opacity-0" :class="{ 'opacity-100': payment === 'paypal' }"></div>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-[#2F2F2F] uppercase tracking-wider">PayPal</p>
                            </div>
                            <div class="flex space-x-2 text-2xl">
                                <i class="fab fa-paypal text-[#00457C]"></i>
                            </div>
                        </label>
                    </div>

                    <div class="mt-8 flex items-center space-x-2 text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                        <i class="fas fa-lock"></i>
                        <span>Secure Encrypted Connection</span>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="mt-12 lg:mt-0 lg:col-span-5 border-l-0 lg:border-l border-gray-100 lg:pl-16 xl:pl-24">
                
                <h2 class="text-xs font-bold text-[#2F2F2F] uppercase tracking-widest border-b border-gray-100 pb-4 mb-8">Order Summary</h2>

                <div class="bg-white">
                    <ul role="list" class="divide-y divide-gray-100 border-b border-gray-100 mb-8">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <li class="flex py-6">
                                <div class="flex-shrink-0 bg-[#FDFBF8] p-2 border border-gray-50">
                                    <img src="{{ Str::startsWith($details['image'], 'http') ? $details['image'] : asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-16 h-20 object-cover">
                                </div>

                                <div class="ml-4 flex-1 flex flex-col justify-center">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-xs font-bold text-[#2F2F2F] uppercase tracking-wider">
                                            {{ $details['name'] }}
                                        </h4>
                                        <p class="ml-4 text-xs font-bold text-[#2F2F2F]">${{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500 font-light tracking-widest uppercase">Qty {{ $details['quantity'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    
                    <dl class="space-y-4 text-sm text-gray-600 pt-4 pb-8 border-b border-black">
                        <div class="flex justify-between items-center">
                            <dt>Subtotal</dt>
                            <dd class="font-medium text-[#2F2F2F]">${{ number_format($total, 2) }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt>Complimentary Shipping</dt>
                            <dd class="font-medium text-[#2F2F2F]">Included</dd>
                        </div>
                        <div class="flex justify-between items-center pt-6">
                            <dt class="text-xs font-bold text-[#2F2F2F] uppercase tracking-widest">Total to Pay</dt>
                            <dd class="text-xl font-serif text-[#2F2F2F] tracking-tight">${{ number_format($total, 2) }}</dd>
                        </div>
                    </dl>

                    <div class="mt-10">
                        <button type="submit" class="w-full bg-[#2F2F2F] border border-transparent shadow-sm py-4 px-4 text-xs font-bold text-white hover:bg-black uppercase tracking-widest transition">
                            Complete Order
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
