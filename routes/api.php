<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/**
 * Public routes
 */
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);
Route::post('register', [AuthController::class, 'register']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

/**
 * Auth routes
 */
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('users/auth', [UsersController::class, 'auth']);
    Route::post('users/update-password', [UsersController::class, 'updatePassword']);
    Route::resource('users', UsersController::class)->only('index', 'show', 'store', 'update');

    Route::resource('products', ProductController::class)->only('index', 'store', 'destroy', 'update');
    Route::get('products/getCategories', [ProductController::class, 'getCategories']);
    Route::get('products/getBrands', [ProductController::class, 'getBrands']);
    Route::post('products/updateProductsStatus', [ProductController::class, 'updateProductsStatus']);
});

