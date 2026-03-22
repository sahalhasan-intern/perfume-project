@extends('layouts.store')

@section('title', 'Contact Us - ELAVA Skincare')

@section('content')
<div class="container-base py-16">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-serif text-[#2F2F2F] mb-6 text-center">Contact Us</h1>
        <p class="text-gray-600 mb-12 text-center">
            Have any questions or concerns? Speak to our customer care team or find us at our physical location. We'd love to hear from you.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <h3 class="text-2xl font-serif text-[#2F2F2F] mb-4">Get in Touch</h3>
                <ul class="space-y-4 font-light text-gray-600">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-[#8C3B44]"></i>
                        <span>123 Beauty Avenue,<br>Paris, France 75008</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3 text-[#8C3B44]"></i>
                        <a href="mailto:hello@elavaskincare.com" class="hover:text-[#8C3B44] transition">hello@elavaskincare.com</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone mr-3 text-[#8C3B44]"></i>
                        <a href="tel:+1234567890" class="hover:text-[#8C3B44] transition">+1 (800) 123-4567</a>
                    </li>
                </ul>
            </div>
            
            <div>
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#8C3B44] focus:ring-[#8C3B44] sm:text-sm" placeholder="Your Name">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#8C3B44] focus:ring-[#8C3B44] sm:text-sm" placeholder="Your Email">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea id="message" name="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#8C3B44] focus:ring-[#8C3B44] sm:text-sm" placeholder="Your Message"></textarea>
                    </div>
                    <button type="button" class="w-full bg-[#8C3B44] text-white px-6 py-3 rounded-md hover:bg-[#6b2c33] transition focus:outline-none">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
