<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/shop', [PageController::class, 'shop'])->name('shop');
Route::get('/product/{slug}', [PageController::class, 'product'])->name('product.show');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Auth Routes (via Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [UserDashboardController::class, 'orders'])->name('orders.index');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/buy-now/{id}', [CheckoutController::class, 'buyNow'])->name('buyNow');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/user/wishlist', [WishlistController::class, 'dashboardIndex'])->name('wishlist.dashboard');
});

// Admin Routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    
    // Categories
    Route::get('/categories', [AdminDashboardController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminDashboardController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{id}', [AdminDashboardController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminDashboardController::class, 'deleteCategory'])->name('categories.destroy');


    // Products
    Route::get('/products', [AdminDashboardController::class, 'products'])->name('products.index');
    Route::post('/products', [AdminDashboardController::class, 'storeProduct'])->name('products.store');
    Route::put('/products/{id}', [AdminDashboardController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [AdminDashboardController::class, 'deleteProduct'])->name('products.destroy');

    // Orders
    Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('orders.index');
    Route::put('/orders/{id}', [AdminDashboardController::class, 'updateOrderStatus'])->name('orders.update');
});

require __DIR__.'/auth.php';
