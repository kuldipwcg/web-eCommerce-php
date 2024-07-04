<?php

use App\Http\Controllers\CartController;
use App\Models\Banner;

use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\BillingController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannerController;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WishlistController;
use App\Models\Wishlist;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

// use App\Http\Controllers\ProductColorController;

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

Route::middleware('auth:api')->group(function () {
    // Route::post('/signup','UserController@signup')->name('signup');
});

//signup for user
Route::post('signup',[UserController::class,'signup'])->name('signup');
Route::post('login', [UserController::class,'login'])->name('login');

//routes for contact details .
// Route::post('addcontact', [ContactController::class,'store'])->name('addcontact');
// Route::put('updatecontact/{id}', [ContactController::class,'update'])->name('updatecontact');
// Route::delete('deletecontact/{id}', [ContactController::class,'destroy'])->name('destroycontact');

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('change-password', [UserController::class, 'change']);
    Route::put('update-profile', [UserController::class, 'update']);
    Route::get('profile', function (Request $r) {
        return auth()->user();
    });

    // Route::get('wishlist', function (Request $r) {
    //     return auth()->user();
    // });
    Route::get('wishlist',[WishlistController::class,'index']);
  
    Route::delete('Delete_wishlist', [WishlistController::class, 'destroy']);
});

Route::post('AddWishList',[WishlistController::class,'store']);

//newsletter
Route::post('addnewsletter', [NewsLetterController::class,'store'])->name('addnewsletter');
Route::put('updatenewsletter/{id}', [NewsLetterController::class,'update'])->name('updatenewsletter');
Route::delete('deletenewsletter/{id}', [NewsLetterController::class,'destroy'])->name('destroynewsletter');


// Route::prefix('admin')->group(function () {
Route::apiResource('product',ProductController::class);
Route::apiResource('subcategory',SubCategoryController::class);
Route::apiResource('order',OrderController::class);
Route::apiResource('category',CategoryController::class);
Route::apiResource('carts', CartController::class);


Route::apiResource('banners',BannerController::class);
Route::apiResource('colors',ProductColorController::class);
Route::apiResource('products',ProductController::class);
Route::apiResource('billingAddress',BillingController::class);
Route::apiResource('shippingAddress',ShippingController::class);
Route::apiResource('order',OrderController::class);
// Route::apiResource('userProfile',UserController::class)->middleware('auth:api');



// Route::prefix('admin')->group(function () {
    
//     Route::apiResource('product',ProductController::class);
//     Route::apiResource('product',ProductController::class);

// });
// });

// Route::prefix('web')->group(function () {
// Route::prefix('web')->group(function () {

//     Route::apiResource('product',ProductController::class);
//     Route::apiResource('product',ProductController::class);

// });
// });