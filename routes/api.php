<?php

use App\Models\Banner;

use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSizeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannerController;
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
    Route::post('/signup','UserController@signup')->name('signup');
});


Route::post('signup',[UserController::class,'signup'])->name('signup');
Route::post('login', [UserController::class,'login'])->name('login');



Route::apiResource('productsize', ProductSizeController::class);

Route::apiResource('productColors',ProductColorController::class);

Route::apiResource('banners', BannerController::class);

// Route::prefix('admin')->group(function () {

//     Route::apiResource('product',ProductController::class);
Route::prefix('admin')->group(function () {
    
    // Route::apiResource('product',ProductController::class);

// });
    // Route::apiResource('productsize', ProductSizeController::class);
});

// Route::prefix('web')->group(function () {

//     Route::apiResource('product',ProductController::class);
    // Route::apiResource('product',ProductController::class);

// });

    