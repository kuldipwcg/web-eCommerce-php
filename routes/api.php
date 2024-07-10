<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\InformationSlugController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\FooterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//User side Routes
Route::middleware('guest:api')->group(function () {
    Route::post('signup', [UserController::class, 'signup'])->name('signup');
    Route::post('login', [UserController::class, 'login'])->name('login');
});

//resource routes
Route::apiResource('contactUs', ContactController::class);
Route::apiResource('newsLetter', NewsLetterController::class);

//when come at login without authorization
Route::get('login', function () {
    return response()->json([
        'status' => true,
        'msg' => 'Please Login In First',
    ]);
})->name('error');

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('change-password', [UserController::class, 'change']);
    Route::put('update-profile', [UserController::class, 'update']);
    Route::get('profile', function (Request $r) {
        return response()->json([
            'data' => auth()->user(),
            'dob' => auth()->user()->dob,
        ]);
    });
    //cart routes
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/store', [CartController::class, 'store']);
    Route::post('cart/add', [CartController::class, 'addtocart']);
    Route::put('cart/{id}', [CartController::class, 'update']);
    Route::delete('cart/{id}', [CartController::class, 'destroy']);

    //wishlist routes
    Route::get('getWishlist', [WishlistController::class, 'show'])->name('getWishlist');
    Route::delete('deleteWishlist', [WishlistController::class, 'destroy']);
    Route::post('addWishList/{id}', [WishlistController::class, 'store']);

    // Resource routes
    Route::apiResource('user', UserController::class);
    Route::apiResource('order', OrderController::class);
    Route::apiResource('carts', CartController::class);
    Route::apiResource('billingAddress', BillingController::class);
    Route::apiResource('shippingAddress', ShippingController::class);
    Route::apiResource('reviews', ReviewController::class);

<<<<<<< HEAD
    Route::get('orderShow', [OrderController::class, 'orderShow']);
=======
    Route::get('orderShow',[OrderController::class,'orderShow']);
>>>>>>> 98c86bc (store order with order item)
});
//banner
Route::get('banners', [BannerController::class, 'index']);

//informationslug
Route::get('informationSlug/{informationslug}', [InformationSlugController::class, 'index']);

//reset password with mail
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('resetPassword', [ForgotPasswordController::class, 'updatePassword'])->name('password.reset');

//products
Route::get('products/{id}', [ProductController::class, 'show'])->name('products');
Route::get('products', [ProductController::class, 'index']);
Route::post('filterProduct', [ProductController::class, 'display']);

//footer route(to get footer data)
Route::get('footer', [FooterController::class, 'index']);

//category
Route::get('category', [CategoryController::class, 'index']);

//subcategory user side
Route::get('subcategory', [SubCategoryController::class, 'show']);
