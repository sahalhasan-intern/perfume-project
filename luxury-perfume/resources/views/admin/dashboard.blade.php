@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 bg-primary rounded-lg text-black bg-pastel-pink">
            <i class="fas fa-shopping-bag fa-2x"></i>
        </div>
        <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-widest">Total Orders</h3>
            <span class="mt-1 text-2xl font-bold text-gray-900">{{ $totalOrders }}</span>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 bg-primary rounded-lg text-black bg-blue-100">
            <i class="fas fa-box fa-2x"></i>
        </div>
        <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-widest">Products</h3>
            <span class="mt-1 text-2xl font-bold text-gray-900">{{ $totalProducts }}</span>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 bg-primary rounded-lg text-black bg-green-100">
            <i class="fas fa-users fa-2x"></i>
        </div>
        <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-widest">Users</h3>
            <span class="mt-1 text-2xl font-bold text-gray-900">{{ $totalUsers }}</span>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 bg-primary rounded-lg text-black bg-yellow-100">
            <i class="fas fa-dollar-sign fa-2x"></i>
        </div>
        <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-widest">Revenue</h3>
            <span class="mt-1 text-2xl font-bold text-gray-900">${{ number_format($revenue, 2) }}</span>
        </div>
    </div>
</div>
<!-- Dashboard Widgets -> Later add charts or tables -->
@endsection
