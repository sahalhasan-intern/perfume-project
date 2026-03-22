<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ELAVA Skincare - Official')</title>

    <!-- Fonts: Elegant Serif for Headings, Clean Sans for Body -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700|inter:300,400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #FDFBF8;
            color: #2F2F2F;
        }
        h1, h2, h3, h4, h5, h6, .font-serif { 
            font-family: 'Playfair Display', serif; 
        }
        .container-base {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        @media (min-width: 768px) {
            .container-base {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }

        /* Product Card Alignment Styles */
        .product-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        .product-image {
            height: 250px !important;
            width: 100%;
            object-fit: cover !important;
        }
        .product-title {
            min-height: 50px;
            display: flex;
            align-items: center;
        }
        .product-price {
            margin-top: auto;
        }
    </style>

</head>
<body class="antialiased flex flex-col min-h-screen">
    
    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="container-base flex justify-between items-center h-20">
            <!-- Left Logo -->
            <a href="{{ route('home') }}" class="font-serif text-2xl font-bold tracking-widest text-[#2F2F2F] shrink-0">
                ELAVA <span class="text-sm font-light tracking-normal italic">Skincare</span>
            </a>

            <!-- Center Menu Links -->
            <div class="hidden md:flex items-center space-x-10 text-center flex-grow justify-center">
                <a href="{{ route('home') }}" class="text-xs uppercase tracking-widest font-bold text-[#8C3B44] transition">Home</a>
                <a href="{{ route('shop') }}" class="text-xs uppercase tracking-widest font-bold text-gray-500 hover:text-[#2F2F2F] transition">Shop</a>
                <a href="{{ route('about') }}" class="text-xs uppercase tracking-widest font-bold text-gray-500 hover:text-[#2F2F2F] transition">About</a>
                <a href="{{ route('contact') }}" class="text-xs uppercase tracking-widest font-bold text-gray-500 hover:text-[#2F2F2F] transition">Contact</a>
            </div>

            <!-- Right Icons -->
            <div class="flex items-center space-x-6 md:space-x-8 shrink-0">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-xs uppercase tracking-widest font-bold text-gray-500 hover:text-[#2F2F2F] transition flex items-center">
                            Account <i class="fas fa-chevron-down text-[10px] ml-1.5"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 mt-4 w-48 bg-white border border-gray-100 shadow-lg py-2 z-50 rounded-sm">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#FDFBF8] hover:text-[#2F2F2F] transition">Admin Panel</a>
                            @endif
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#FDFBF8] hover:text-[#2F2F2F] transition">My Profile</a>
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#FDFBF8] hover:text-[#2F2F2F] transition">Orders</a>
                            <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#FDFBF8] hover:text-[#2F2F2F] transition">Wishlist</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-red-50 hover:text-red-700 transition">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-xs uppercase tracking-widest font-bold text-gray-500 hover:text-[#2F2F2F] transition hidden md:block">Sign In</a>
                    <a href="{{ route('login') }}" class="md:hidden text-gray-500 hover:text-[#2F2F2F]"><i class="fas fa-user"></i></a>
                @endauth
                
                <a href="{{ route('cart.index') }}" class="relative text-gray-500 hover:text-[#2F2F2F] transition">
                    <i class="fas fa-shopping-bag text-lg"></i>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-[#8C3B44] text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full font-bold shadow-sm">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-500 hover:text-[#2F2F2F]">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-[#F9EBEA] p-4 text-center text-sm font-medium text-[#8C3B44]">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 p-4 text-center text-sm font-medium text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <!-- Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Professional Footer -->
    <footer class="bg-white border-t border-gray-100 mt-auto pt-20 pb-10">
        <div class="container-base">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Column 1: Brand Info -->
                <div>
                    <h2 class="font-serif text-2xl font-bold tracking-widest text-[#2F2F2F] mb-6">ELAVA</h2>
                    <p class="text-sm text-gray-500 leading-relaxed font-light mb-6">
                        Luxury skincare formulated with clinically proven botanical ingredients. Cruelty-free, clean, and dedicated to revealing your natural radiance.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#8C3B44] hover:border-[#8C3B44] transition ease-in-out duration-300"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#8C3B44] hover:border-[#8C3B44] transition ease-in-out duration-300"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#8C3B44] hover:border-[#8C3B44] transition ease-in-out duration-300"><i class="fab fa-pinterest-p"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#8C3B44] hover:border-[#8C3B44] transition ease-in-out duration-300"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                
                <!-- Column 2: Quick Links -->
                <div>
                    <h3 class="text-xs uppercase tracking-widest font-bold mb-6 text-[#2F2F2F]">Shop ELAVA</h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('shop') }}" class="text-sm text-gray-500 hover:text-[#8C3B44] transition font-light">All Products</a></li>
                        <li><a href="{{ route('shop') }}?category=1" class="text-sm text-gray-500 hover:text-[#8C3B44] transition font-light">Cleansers</a></li>
                        <li><a href="{{ route('shop') }}?category=2" class="text-sm text-gray-500 hover:text-[#8C3B44] transition font-light">Serums & Oils</a></li>
                        <li><a href="{{ route('shop') }}?category=3" class="text-sm text-gray-500 hover:text-[#8C3B44] transition font-light">Moisturizers</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-[#8C3B44] transition font-light">Gift Sets</a></li>
                    </ul>
                </div>

                <!-- Column 3: Customer Care -->
                <div>
                    <h3 class="text-xs uppercase tracking-widest font-bold mb-6 text-[#2F2F2F]">Customer Care</h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-[#8C3B44] transition font-light">My Account</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-[#8C3B44] transition font-light">Track Order</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-[#8C3B44] transition font-light">Shipping & Returns</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-[#8C3B44] transition font-light">FAQ</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-[#8C3B44] transition font-light">Consultation</a></li>
                    </ul>
                </div>

                <!-- Column 4: Contact -->
                <div>
                    <h3 class="text-xs uppercase tracking-widest font-bold mb-6 text-[#2F2F2F]">Contact Us</h3>
                    <ul class="space-y-4 font-light text-sm text-gray-500">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-gray-400"></i>
                            <span>123 Beauty Avenue,<br>Paris, France 75008</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-gray-400"></i>
                            <a href="mailto:hello@elavaskincare.com" class="hover:text-[#8C3B44] transition">hello@elavaskincare.com</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-gray-400"></i>
                            <a href="tel:+1234567890" class="hover:text-[#8C3B44] transition">+1 (800) 123-4567</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center text-[10px] text-gray-400 uppercase tracking-widest font-bold">
                <p class="mb-4 md:mb-0">&copy; {{ date('Y') }} ELAVA Skincare. All Rights Reserved.</p>
                <div class="space-x-6 flex items-center">
                    <a href="#" class="hover:text-[#2F2F2F] transition">Privacy Policy</a>
                    <a href="#" class="hover:text-[#2F2F2F] transition">Terms of Service</a>
                    <!-- Decorative Payment Icons -->
                    <div class="flex space-x-2 ml-4">
                        <i class="fab fa-cc-visa text-xl"></i>
                        <i class="fab fa-cc-mastercard text-xl"></i>
                        <i class="fab fa-cc-amex text-xl"></i>
                        <i class="fab fa-cc-paypal text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.wishlist-icon').forEach(function(el) {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    @if(!auth()->check())
                        window.location.href = "{{ route('login') }}";
                        return;
                    @endif

                    let productId = this.getAttribute('data-id');
                    let icon = this.querySelector('.heart-icon');
                    let textSpan = this.querySelector('.wishlist-text');

                    fetch(`/wishlist/toggle/${productId}`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status === 'added') {
                            icon.classList.remove('far', 'text-gray-400');
                            icon.classList.add('fas', 'text-red-500', 'active');
                            if(textSpan) textSpan.innerText = 'Remove From Wishlist';
                        } else if(data.status === 'removed') {
                            icon.classList.remove('fas', 'text-red-500', 'active');
                            icon.classList.add('far', 'text-gray-400');
                            if(textSpan) textSpan.innerText = 'Add To Wishlist';
                        }
                    })
                    .catch(error => console.error('Wishlist error:', error));
                });
            });
        });
    </script>
    @yield('scripts')
    @include('components.chatbot')
</body>
</html>
