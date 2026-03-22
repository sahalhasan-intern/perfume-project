@extends('layouts.store')

@section('title', 'My Orders - ELAVA Skincare')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 mt-20 min-h-[60vh]">
    <div class="mb-12">
        <h2 class="text-4xl font-serif text-[#222]">My Orders</h2>
        <div class="w-12 h-px bg-[#222] mt-6"></div>
    </div>

    @if(count($orders) > 0)
        <div class="bg-white border border-gray-100 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-xs uppercase tracking-widest text-gray-400 font-bold bg-gray-50">
                            <th class="py-4 px-6 font-medium">Order ID</th>
                            <th class="py-4 px-6 font-medium">Date</th>
                            <th class="py-4 px-6 font-medium">Items</th>
                            <th class="py-4 px-6 font-medium">Total</th>
                            <th class="py-4 px-6 font-medium">Status</th>
                            <th class="py-4 px-6 font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($orders as $order)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition" x-data="{ openModal: false }">
                                <td class="py-6 px-6 font-serif font-bold text-[#222]">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="py-6 px-6 text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="py-6 px-6 text-gray-500">{{ $order->items->sum('quantity') }} items</td>
                                <td class="py-6 px-6 font-medium text-[#222]">${{ number_format($order->total, 2) }}</td>
                                <td class="py-6 px-6">
                                    @if($order->status === 'Order Placed')
                                        <span class="bg-yellow-100 text-yellow-800 text-[10px] uppercase tracking-wider px-3 py-1 rounded-full font-bold">Order Placed</span>
                                    @elseif($order->status === 'Packed')
                                        <span class="bg-blue-100 text-blue-800 text-[10px] uppercase tracking-wider px-3 py-1 rounded-full font-bold">Packed</span>
                                    @elseif($order->status === 'Shipped')
                                        <span class="bg-indigo-100 text-indigo-800 text-[10px] uppercase tracking-wider px-3 py-1 rounded-full font-bold">Shipped</span>
                                    @elseif($order->status === 'Out for Delivery')
                                        <span class="bg-purple-100 text-purple-800 text-[10px] uppercase tracking-wider px-3 py-1 rounded-full font-bold">Out for Delivery</span>
                                    @elseif($order->status === 'Delivered')
                                        <span class="bg-green-100 text-green-800 text-[10px] uppercase tracking-wider px-3 py-1 rounded-full font-bold">Delivered</span>
                                    @elseif($order->status === 'cancelled')
                                        <span class="bg-red-100 text-red-800 text-[10px] uppercase tracking-wider px-3 py-1 rounded-full font-bold">Cancelled</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-[10px] uppercase tracking-wider px-3 py-1 rounded-full font-bold">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td class="py-6 px-6">
                                    <button @click="openModal = true" class="text-xs uppercase tracking-widest text-[#222] hover:text-[var(--color-gold)] transition border-b border-[#222] hover:border-[var(--color-gold)] pb-1">View Details</button>

                                    <!-- Modal -->
                                    <div x-show="openModal" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black/50 backdrop-blur-sm" style="display: none;" x-transition>
                                        <div @click.away="openModal = false" class="relative w-full max-w-2xl p-4 mx-auto">
                                            <div class="bg-white rounded shadow-2xl">
                                                <div class="flex items-center justify-between p-6 border-b border-gray-100">
                                                    <h3 class="text-xl font-serif text-[#222]">Order #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
                                                    <button @click="openModal = false" class="text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="p-6 space-y-6 max-h-[60vh] overflow-y-auto">
                                                    <div class="flex justify-between mb-4">
                                                        <p class="text-xs uppercase tracking-widest text-gray-500">Date: <span class="font-bold text-[#222]">{{ $order->created_at->format('M d, Y') }}</span></p>
                                                        <p class="text-xs uppercase tracking-widest text-gray-500">Status: <span class="font-bold text-[#222]">{{ ucfirst($order->status) }}</span></p>
                                                    </div>
                                                    
                                                    <!-- Order Tracking Timeline -->
                                                    <div class="py-4 mb-4 border border-gray-100 bg-gray-50 px-6">
                                                        <h4 class="text-xs font-bold uppercase tracking-widest text-[#222] mb-6">Order Progress</h4>
                                                        
                                                        @php
                                                            $statuses = ['Order Placed', 'Packed', 'Shipped', 'Out for Delivery', 'Delivered'];
                                                            $currentIndex = array_search($order->status, $statuses);
                                                            if ($currentIndex === false) $currentIndex = -1;
                                                        @endphp

                                                        <ul class="ml-2 pt-2">
                                                            @foreach($statuses as $index => $status)
                                                                <li class="relative pl-8 {{ $loop->last ? '' : 'border-l border-gray-300 pb-8' }}">
                                                                    <!-- Dot -->
                                                                    <div class="absolute -left-[11px] top-0 w-[22px] h-[22px] rounded-full border-4 border-white flex items-center justify-center
                                                                        {{ $index <= $currentIndex ? 'bg-[var(--color-gold)]' : 'bg-gray-300' }}">
                                                                        @if($index <= $currentIndex)
                                                                            <i class="fas fa-check text-[8px] text-white"></i>
                                                                        @endif
                                                                    </div>
                                                                    
                                                                    <!-- Text -->
                                                                    <div class="-mt-0.5">
                                                                        <h5 class="text-sm font-bold {{ $index <= $currentIndex ? 'text-[#222]' : 'text-gray-400' }}">{{ $status }}</h5>
                                                                        @if($index <= $currentIndex)
                                                                            <p class="text-[10px] uppercase tracking-wider text-gray-500 mt-1 font-bold">Completed</p>
                                                                        @elseif($index === $currentIndex + 1 && $currentIndex !== count($statuses) - 1)
                                                                            <p class="text-[10px] uppercase tracking-wider text-gray-400 mt-1 font-bold">Pending</p>
                                                                        @endif
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    
                                                    <div class="border border-gray-100 divide-y divide-gray-100">
                                                        @foreach($order->items as $item)
                                                            <div class="flex items-center p-4">
                                                                <img src="{{ $item->product->image ? (Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('storage/' . $item->product->image)) : 'https://images.unsplash.com/photo-1523293115678-d2906200c01a?ixlib=rb-4.0.3&w=100&q=80' }}" class="w-16 h-16 object-cover bg-gray-50 p-1">
                                                                <div class="ml-4 flex-1">
                                                                    <h6 class="text-sm font-bold text-[#222]">{{ $item->product->name }}</h6>
                                                                    <p class="text-xs text-gray-500 uppercase tracking-widest">{{ $item->product->brand ?? 'ELAVA' }}</p>
                                                                </div>
                                                                <div class="text-xs font-medium text-gray-500">{{ $item->quantity }}x</div>
                                                                <div class="ml-4 text-sm font-bold text-[#222]">${{ number_format($item->price * $item->quantity, 2) }}</div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="flex items-center justify-between p-6 border-t border-gray-100 bg-gray-50">
                                                    <span class="text-sm font-bold uppercase tracking-widest text-[#222]">Total Amount</span>
                                                    <span class="text-2xl font-serif text-[#222]">${{ number_format($order->total, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-8 flex justify-center">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-24 bg-white border border-gray-100 shadow-sm">
            <div class="mb-6 flex justify-center">
                <div class="w-24 h-24 bg-[var(--color-pink)] rounded-full flex items-center justify-center">
                    <i class="fas fa-box text-3xl text-[var(--color-gold)]"></i>
                </div>
            </div>
            <h4 class="text-2xl font-serif text-[#222] mb-3">No orders yet</h4>
            <p class="text-gray-500 font-light mb-8 max-w-md mx-auto">You haven't placed any luxury items orders yet. Once you make a purchase, it will appear here.</p>
            <a href="{{ route('shop') }}" class="bg-[#222] text-white px-8 py-4 text-xs uppercase tracking-[0.15em] hover:bg-black transition inline-block">
                Start Exploring
            </a>
        </div>
    @endif
</div>
@endsection
