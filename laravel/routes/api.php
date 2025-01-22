<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/signin', [AuthController::class, 'signin']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);
    });
});

Route::group(['prefix' => 'category', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/', [CategoryController::class, 'create']);
    Route::put('/{id}', [CategoryController::class, 'edit']);
    Route::delete('/{id}', [CategoryController::class, 'delete']);
});
Route::get('category', [CategoryController::class, 'list'])->name('list');
Route::get('category/{id}', [CategoryController::class, 'show']);

Route::group(['prefix' => 'product'], function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [ProductController::class, 'create']);
        Route::post('/{id}', [ProductController::class, 'addToBasket']);
        Route::put('/{id}', [ProductController::class, 'edit']);
        Route::delete('/{id}', [ProductController::class, 'delete']);
    });
    Route::get('/', [ProductController::class, 'list']);
    Route::get('/{id}', [ProductController::class, 'show']);
});

Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/basket', [UserController::class, 'getBasket']);
    Route::get('/order', [UserController::class, 'getOrders']);
});

Route::post('order', [OrderController::class, 'createOrder'])->middleware('auth:sanctum');
