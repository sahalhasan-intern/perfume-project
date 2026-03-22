<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ELAVA Skincare') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700|inter:300,400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --color-cream: #FCFBF9;
                --color-beige: #F5EFEB;
                --color-pink: #F9EBEA;
                --color-charcoal: #222222;
                --color-gold: #BCA37F;
            }
            body { font-family: 'Inter', sans-serif; background-color: var(--color-beige); }
            .font-playfair { font-family: 'Playfair Display', serif; }
            .glass-panel {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.5);
            }
            .input-luxury {
                background-color: transparent !important;
                border: none !important;
                border-bottom: 1px solid #d1d5db !important;
                border-radius: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                box-shadow: none !important;
                transition: border-color 0.3s ease;
            }
            .input-luxury:focus {
                border-bottom-color: var(--color-charcoal) !important;
                ring: 0 !important;
                outline: none !important;
            }
        </style>
    </head>
    <body class="font-sans text-[#222] antialiased selection:bg-[#222] selection:text-white">
        <div class="min-h-screen flex flex-col lg:flex-row">
            
            <!-- Left Side / Branding (Hidden on small screens) -->
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-white items-center justify-center">
                <!-- Background Image -->
                <div class="absolute inset-0 z-0">
                    <img src="https://images.unsplash.com/photo-1615397323282-eeb39589d701?q=80&w=1200&auto=format&fit=crop" alt="ELAVA Skincare Products" class="object-cover w-full h-full mix-blend-multiply">
                    <div class="absolute inset-0 bg-[#F9EBEA]/30"></div>
                </div>
                <!-- Overlay Content -->
                <div class="relative z-10 text-center px-12 text-[#222] max-w-lg">
                    <h2 class="text-5xl font-playfair font-bold mb-6 tracking-wide drop-shadow-sm">ELAVA</h2>
                    <p class="text-lg text-gray-700 font-light tracking-[0.2em] uppercase mb-8">Awaken Your True Radiance</p>
                    <div class="w-24 h-px bg-[#222] mx-auto"></div>
                </div>
            </div>

            <!-- Right Side / Form -->
            <div class="w-full lg:w-1/2 flex flex-col min-h-screen px-6 py-12 lg:px-16 relative overflow-y-auto">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-[#F9EBEA] blur-3xl pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-white blur-3xl pointer-events-none"></div>

                <!-- Spacer -->
                <div class="flex-grow"></div>

                <div class="w-full max-w-md mx-auto relative z-10 my-8">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden text-center mb-10">
                        <a href="{{ route('home') }}">
                            <h2 class="text-4xl font-playfair font-bold tracking-wide text-[#222]">ELAVA</h2>
                            <p class="text-[0.65rem] text-gray-500 tracking-[0.3em] uppercase mt-2">Skincare</p>
                        </a>
                    </div>

                    <!-- Desktop Home link optional -->
                    <div class="hidden lg:block absolute top-0 right-0 -mr-8 -mt-16">
                        <a href="{{ route('home') }}" class="text-xs tracking-widest text-gray-400 hover:text-[#222] transition uppercase pb-1 border-b border-transparent hover:border-[#222]">Return to Store</a>
                    </div>

                    <!-- Slot Content -->
                    <div class="glass-panel rounded-2xl p-8 sm:p-10 shadow-sm">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Spacer -->
                <div class="flex-grow"></div>
            </div>

        </div>
    </body>
</html>
