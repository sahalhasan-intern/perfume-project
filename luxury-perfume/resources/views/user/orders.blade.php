@extends('layouts.store')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900 uppercase tracking-widest">My Account</h3>
                <nav class="mt-8 space-y-1">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-home text-gray-400 group-hover:text-gray-500 mr-3"></i> Dashboard
                    </a>
                    <a href="{{ route('orders.index') }}" class="bg-gray-100 text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-box text-gray-500 mr-3"></i> My Orders
                    </a>
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-user text-gray-400 group-hover:text-gray-500 mr-3"></i> Profile Settings
                    </a>
                </nav>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-100">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">All Orders</h3>
                </div>
                <div class="border-t border-gray-200">
                    @if($orders->count() > 0)
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($orders as $order)
                                <li>
                                    <div class="px-4 py-4 sm:px-6 flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-black truncate">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                                            <p class="text-sm text-gray-500 mt-1">{{ $order->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <p class="text-sm font-bold">${{ number_format($order->total, 2) }}</p>
                                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 uppercase mt-1">
                                                {{ $order->status }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-10">
                            <i class="fas fa-box-open text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">You haven't placed any orders yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
