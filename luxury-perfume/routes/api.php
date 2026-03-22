<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\admincontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::apiResource('posts', PostController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    
    // Profile
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile', [\App\Http\Controllers\Api\ProfileController::class, 'update']);
    Route::post('/profile/update', [\App\Http\Controllers\Api\ProfileController::class, 'update']);
    
    // Admin routes
    Route::middleware(['role.admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function() {
            return response()->json(['message' => 'Admin dashboard accessed securely.']);
        });
        Route::get('/products', function() {
            return response()->json(['message' => 'Admin products accessed securely.']);
        });
    });

    // Customer routes
    Route::middleware(['role.customer'])->prefix('customer')->group(function () {
        Route::get('/profile', function() {
            return response()->json(['message' => 'Customer profile accessed securely.']);
        });
        Route::get('/orders', function() {
            return response()->json(['message' => 'Customer orders accessed securely.']);
        });
    });

    // Cart
    Route::get('/cart', [\App\Http\Controllers\Api\CartController::class, 'index']);
    Route::post('/cart/add', [\App\Http\Controllers\Api\CartController::class, 'add']);
    Route::post('/cart/remove', [\App\Http\Controllers\Api\CartController::class, 'remove']);
});

// Chatbot Products API
Route::get('/products', [\App\Http\Controllers\Api\ChatbotProductController::class, 'index']);
Route::get('/products/{id}', [\App\Http\Controllers\Api\ChatbotProductController::class, 'show']);
