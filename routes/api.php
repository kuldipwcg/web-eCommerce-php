<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\ProductController;
// use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ShippingController;

use App\Http\Controllers\ProductColorController;
// use App\Http\Controllers\ForgotPasswordController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use App\Http\Controllers\Auth\ForgotPasswordController;


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



Route::middleware('guest:api')->group(function () {

    Route::post('signup', [UserController::class, 'signup'])->name('signup');
    Route::post('login', [UserController::class, 'login'])->name('login');
});

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('change-password', [UserController::class, 'change']);
    Route::get('profile', function (Request $r) {
        return auth()->user();
    });
});


Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.reset');

// for admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    Route::post('set', [AdminController::class, 'setAdmin']);
    Route::post('login', [AdminController::class, 'login'])->name('admin.login');


    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminController::class, 'logout']);
        Route::post('change-password', [AdminController::class, 'change']);
    });
});


//when come at login without authorization 
Route::get('login', function () {
    return response()->json([
        "status" => true,
        "msg" => 'Please Login In First'
    ]);
})->name('error');



//Banner
Route::apiResource('banners',BannerController::class);

//product size
Route::apiResource('sizes', ProductSizeController::class);

//product color
Route::apiResource('colors',ProductColorController::class);

//newsletter
Route::post('addnewsletter', [NewsLetterController::class,'store'])->name('addnewsletter');
Route::put('updatenewsletter/{id}', [NewsLetterController::class,'update'])->name('updatenewsletter');
Route::delete('deletenewsletter/{id}', [NewsLetterController::class,'destroy'])->name('destroynewsletter');


Route::apiResource('product', ProductController::class);
Route::apiResource('subcategory', SubCategoryController::class);
Route::apiResource('category', CategoryController::class);
// Route::prefix('admin')->group(function () {
Route::apiResource('products',ProductController::class);
Route::apiResource('subcategory',SubCategoryController::class);
Route::apiResource('order',OrderController::class);
Route::apiResource('category',CategoryController::class);
Route::apiResource('carts', CartController::class);


// Route::prefix('admin')->group(function () {
    
//     Route::apiResource('product',ProductController::class);

// });

// Route::prefix('web')->group(function () {

//     Route::apiResource('product',ProductController::class);

// });
// });



Route::apiResource('banners',BannerController::class);
Route::apiResource('colors',ProductColorController::class);
Route::apiResource('products',ProductController::class);
Route::apiResource('billingAddress',BillingController::class);
Route::apiResource('shippingAddress',ShippingController::class);

=======
>>>>>>> kanad_admin
