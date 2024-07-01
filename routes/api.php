<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProductColorController;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\TransientTokenController;

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
Route::middleware('guest:api')->group(function () {
    Route::post('signup', [UserController::class, 'signup'])->name('signup');
    Route::post('login', [UserController::class, 'login'])->name('login');
    

});
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::get('profile', function (Request $r) {
        return auth()->user();
    });
});

// for admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::post('set', [AdminController::class, 'setAdmin']);
    Route::post('login', [AdminController::class, 'login'])->name('admin.login');

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminController::class, 'logout']);
    });
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
// Route::post('addcontact', [ContactController::class,'store'])->name('addcontact');
// Route::put('updatecontact/{id}', [ContactController::class,'update'])->name('updatecontact');
// Route::delete('deletecontact/{id}', [ContactController::class,'destroy'])->name('destroycontact');


//newsletter 
Route::post('addnewsletter', [NewsLetterController::class, 'store'])->name('addnewsletter');
Route::put('updatenewsletter/{id}', [NewsLetterController::class, 'update'])->name('updatenewsletter');
Route::delete('deletenewsletter/{id}', [NewsLetterController::class, 'destroy'])->name('destroynewsletter');


// Route::prefix('admin')->group(function () {
Route::apiResource('product', ProductController::class);
Route::apiResource('subcategory', SubCategoryController::class);
Route::apiResource('category', CategoryController::class);
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
