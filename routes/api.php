<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\LanguageController;
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

//when come at login without authorization 
Route::get('login', function () {
    return response()->json([
        "status" => true,
        "msg" => 'Please Login In First'
    ]);
})->name('error'); 

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('change-password', [UserController::class, 'change']);
    Route::put('update-profile', [UserController::class, 'update']);
    Route::get('profile', function (Request $r) {
        
        return response()->json([
            'data'=>auth()->user(),
            'dob'=>auth()->user()->dob,
        ]); 

    }); 
    //wishlist routes
    Route::get('show-wishlist',[WishlistController::class,'show'])->name('show-wishlist');
    Route::delete('Delete-wishlist', [WishlistController::class, 'destroy']); 
    Route::post('Add-WishList/{id}',[WishlistController::class,'store']);

    // Resource routes
    Route::apiResource('user', UserController::class);
    Route::apiResource('order', OrderController::class);
    Route::apiResource('carts', CartController::class);
    Route::apiResource('billingAddress', BillingController::class);
    Route::apiResource('shippingAddress', ShippingController::class);
    Route::apiResource('reviews', ReviewController::class);
});
//resource routes
Route::apiResource('language',LanguageController::class);
Route::apiResource('contactUs',ContactController::class);
Route::apiResource('newsLetter', NewsLetterController::class);
Route::get('banners', [BannerController::class,'index']);
Route::get('informationslug', [InformationSlugController::class,'index']);

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.reset');

//products
Route::get('products/{id}', [ProductController::class,'show'])->name('products');
Route::get('products', [ProductController::class,'index']);
Route::post('filter-product', [ProductController::class,'display']);

//footer route(to get footer data)
Route::get('footer',[FooterController::class,'index']);

//filter and product search(shop page)
Route::post('display-product', [ProductController::class,'display']);

//cart 
Route::post('add-to-cart', [CartController::class,'store'])->name('add-to-cart');

//category
Route::get('category', [SubCategoryController::class,'index']);

//subcategory user side
Route::get('subcategory', [SubCategoryController::class,'show']);