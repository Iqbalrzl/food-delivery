<?php
// routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartItemController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\ImageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::get('/auth/user-id', [AuthController::class, 'getUserIdByFirebaseUid']);
Route::post('/logout', [AuthController::class, 'logout']);

// Profile
Route::get('/profile', [ProfileController::class, 'show']);
Route::put('/profile', [ProfileController::class, 'update']);
Route::get('/profile/user/{id}', [ProfileController::class, 'getByUserId']);


// Product
Route::apiResource('products', App\Http\Controllers\Api\ProductController::class);

// Admin product management
// Route::post('/products', [ProductController::class, 'store']);
// Route::put('/products/{id}', [ProductController::class, 'update']);
// Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// Cart
Route::apiResource('cart-items', App\Http\Controllers\Api\CartItemController::class);
Route::get('users/{id}/cart-items', [CartItemController::class, 'getUserCart']);
// Route::get('/cart', [CartItemController::class, 'index']);
// Route::post('/cart', [CartItemController::class, 'store']);
// Route::put('/cart/{id}', [CartItemController::class, 'update']);
// Route::delete('/cart/{id}', [CartItemController::class, 'destroy']);
// Route::delete('/cart', [CartItemController::class, 'clear']);


// Admin
Route::apiResource('admins', AdminController::class);

// Order
Route::apiResource('orders', OrderController::class);
Route::post('checkout', [OrderController::class, 'store']);
Route::get('users/{id}/orders', [OrderController::class, 'userHistory']);

// Order-Items
Route::apiResource('order-items', OrderItemController::class);

// Image
Route::post('/upload-image', [ImageController::class, 'upload']);

// Route::apiResource('users', App\Http\Controllers\Api\UserController::class);
// Route::apiResource('profiles', App\Http\Controllers\Api\ProfileController::class);
// Route::apiResource('admins', App\Http\Controllers\Api\AdminController::class);
// Route::apiResource('orders', App\Http\Controllers\Api\OrderController::class);
// Route::apiResource('order-items', App\Http\Controllers\Api\OrderItemController::class);
