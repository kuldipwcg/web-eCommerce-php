<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\UserController;

// Public routes (not requiring authentication)
Route::post('signup', [UserController::class, 'signup'])->name('signup');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    // Authenticated routes
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    // Other authenticated routes as needed
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::post('login', [AdminController::class, 'login'])->name('admin.login');

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminController::class, 'logout']);
        Route::post('change-password', [AdminController::class, 'change']);
    });
});

// Resource routes
Route::apiResource('banners', BannerController::class);
Route::apiResource('sizes', ProductSizeController::class);
Route::apiResource('colors', ProductColorController::class);
Route::apiResource('category', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('subcategory', SubCategoryController::class);
Route::apiResource('order', OrderController::class);
Route::apiResource('carts', CartController::class);
Route::apiResource('billingAddress', BillingController::class);
Route::apiResource('shippingAddress', ShippingController::class);

// Newsletter routes
Route::post('addnewsletter', [NewsLetterController::class, 'store'])->name('addnewsletter');
Route::put('updatenewsletter/{id}', [NewsLetterController::class, 'update'])->name('updatenewsletter');
Route::delete('deletenewsletter/{id}', [NewsLetterController::class, 'destroy'])->name('destroynewsletter');
