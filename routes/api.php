<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\CartController;
use App\Models\Banner;

use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductController;
// use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;



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

Route::apiResource('userProfile',UserController::class);

Route::post('signup', [UserController::class, 'signup'])->name('signup');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::post('logout', [UserController::class, 'logout'])->name('logout')->middleware('auth:api');
Route::middleware(['auth:api'])->group(function () {


});
// for token
Route::post('oauth/token', [AccessTokenController::class, 'issueToken']);
Route::post('oauth/token/refresh', [AccessTokenController::class, 'refresh']);
Route::post('oauth/token/revoke', [AccessTokenController::class, 'revoke']);
Route::post('oauth/authorize', [TransientTokenController::class, 'store']);
Route::delete('oauth/authorize', [TransientTokenController::class, 'destroy']); 

// for admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::post('set', [AdminController::class, 'setAdmin']);
    Route::post('login', [AdminController::class, 'login']);

    Route::get('subscriber', [NewsLetterController::class, 'show']);
    Route::get('contactlist', [ContactController::class, 'show']);

    Route::group(['middleware' => ['auth', 'admin']], function () {
    });
    
    Route::post('logout', [AdminController::class, 'logout']);
    // Route::get('login',function(){

    //     return response()->json([
    //         "status"=>true,
    //         "msg"=>'Please Login first'    
    //     ]);
    // })->name('login');

});

// Route::group(['prefix' => 'mobile', 'namespace' => 'Mobile'], function () {
//     Route::post('set', [AdminController::class, 'setAdmin']);
//     Route::post('login', [AdminController::class, 'login']);
//     Route::post('logout', [AdminController::class, 'logout']);

// });


    // Route::middleware('auth:admin')->group(function () {

    //     Route::get('dashboard', [AdminController::class, 'dashboard']);
    // });


//routes for contact details .
Route::post('addcontact', [ContactController::class,'store'])->name('addcontact');
Route::put('updatecontact/{id}', [ContactController::class,'update'])->name('updatecontact');
Route::delete('deletecontact/{id}', [ContactController::class,'destroy'])->name('destroycontact');

//Banner
Route::apiResource('banners',BannerController::class);

//product size
Route::apiResource('sizes', ProductSizeController::class);

//product color
Route::apiResource('colors',ProductColorController::class);

//newsletter 
Route::post('newsletter', [NewsLetterController::class,'store'])->name('newsletter');
Route::put('updatenewsletter/{id}', [NewsLetterController::class,'update'])->name('updatenewsletter');
Route::delete('deletenewsletter/{id}', [NewsLetterController::class,'destroy'])->name('destroynewsletter');

Route::apiResource('category', CategoryController::class);
// Route::prefix('admin')->group(function () {
Route::apiResource('products',ProductController::class);
Route::apiResource('subcategory',SubCategoryController::class);
Route::apiResource('order',OrderController::class);
Route::apiResource('category',CategoryController::class);
Route::apiResource('carts', CartController::class);



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



Route::apiResource('banners',BannerController::class);
Route::apiResource('colors',ProductColorController::class);
Route::apiResource('products',ProductController::class);
Route::apiResource('billingAddress',BillingController::class);
Route::apiResource('shippingAddress',ShippingController::class);

