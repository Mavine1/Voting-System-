<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class);

// Route::apiResource('cart', CartController::class);

Route::get('cart', [CartController::class, 'index']);
Route::post('cart', [CartController::class, 'addToCart']);
Route::delete('cart/remove', [CartController::class, 'removeFromCart']);


//orders
Route::post('orders', [CartController::class, 'store']);
Route::get('orders', [OrderController::class, 'index']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
