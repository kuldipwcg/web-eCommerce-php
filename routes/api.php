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
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\FooterController;

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


Route::post('signup', [UserController::class, 'signup'])->name('signup');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {

Route::post('logout', [UserController::class, 'logout'])->name('logout');

});
// for token

//signup for user
Route::post('signup',[UserController::class,'signup'])->name('signup');
Route::post('login', [UserController::class,'login'])->name('login');

//footer route user side 


Route::middleware('guest:api')->group(function () {

    Route::post('signup', [UserController::class, 'signup'])->name('signup');
    Route::post('login', [UserController::class, 'login'])->name('login');
});

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('change-password', [UserController::class, 'change']);
    Route::get('profile', function (Request $r) {
        return response()->json([
            'detail'=>auth()->user(),
            'dob'=>auth()->user()->dob,
        ]);
    }); 
    Route::put('update-profile', [UserController::class, 'update']);
});


Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.reset');

// for admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::post('set', [AdminController::class, 'setAdmin']);
    Route::post('login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('contactlist', [ContactController::class, 'show'])->name('contactlist');
    Route::get('subscriber', [NewsLetterController::class, 'show'])->name('subscriber');
    //admin footer
    Route::post('footeradd', [FooterController::class, 'store'])->name('footeradd');
    Route::put('updatefooter', [FooterController::class, 'update'])->name('updatefooter');
    Route::get('footer',[FooterController::class,'index']);
    //admin category
    Route::get('categorylist', [CategoryController::class,'show'])->name('categorylist');
    Route::post('addcategory', [CategoryController::class,'store'])->name('addcategory');
    
    //admin subcategory
    Route::get('subcategorylist', [SubCategoryController::class,'show'])->name('subcategorylist');
    Route::post('addsubcategory', [SubCategoryController::class,'store'])->name('addsubcategory');

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminController::class, 'logout']);
        Route::post('change-password', [AdminController::class, 'change']);
    });

});

Route::group(['prefix' => 'mobile', 'namespace' => 'Mobile'], function () {
    Route::post('set', [AdminController::class, 'setAdmin']);
    Route::post('login', [AdminController::class, 'login']);
    Route::post('logout', [AdminController::class, 'logout']);

});


    // Route::middleware('auth:admin')->group(function () {

    //     Route::get('dashboard', [AdminController::class, 'dashboard']);
    // });




//routes for contact details .
Route::post('addcontact', [ContactController::class,'store'])->name('addcontact');
Route::put('updatecontact/{id}', [ContactController::class,'update'])->name('updatecontact');
Route::delete('deletecontact/{id}', [ContactController::class,'destroy'])->name('destroycontact');


//newsletter 
Route::post('addnewsletter', [NewsLetterController::class,'store'])->name('addnewsletter');
Route::put('updatenewsletter/{id}', [NewsLetterController::class,'update'])->name('updatenewsletter');
Route::delete('deletenewsletter/{id}', [NewsLetterController::class,'destroy'])->name('destroynewsletter');

//contact us
Route::post('addcontact', [ContactController::class,'store'])->name('addcontact');
Route::put('updatecontact/{id}', [ContactController::class,'update'])->name('updatecontact');
Route::delete('deletecontact/{id}', [ContactController::class,'destroy'])->name('destroycontact'); 

Route::apiResource('product', ProductController::class);
Route::apiResource('subcategory', SubCategoryController::class);
Route::apiResource('category', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('subcategory', SubCategoryController::class);
Route::apiResource('order', OrderController::class);
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



