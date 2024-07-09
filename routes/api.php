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

// use App\Http\Controllers\ForgotPasswordController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\PaymentController;

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
Route::post('signup', [UserController::class, 'signup'])->name('signup');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::middleware('guest:api')->group(function () {
    Route::post('signup', [UserController::class, 'signup'])->name('signup');
    Route::post('login', [UserController::class, 'login'])->name('login');
});

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('changePassword', [UserController::class, 'change']);
    Route::put('updateProfile', [UserController::class, 'update']);
    Route::get('profile', function (Request $r) {
        return response()->json([
            'data'=>auth()->user(),
            'dob'=>auth()->user()->dob,
        ]); 

    }); 
    //wishlist routes
    Route::get('getWishlist',[WishlistController::class,'show'])->name('getWishlist');
    Route::delete('deleteWishlist', [WishlistController::class, 'destroy']); 
    Route::post('addWishList/{id}',[WishlistController::class,'store']);
            'detail' => auth()->user(),
            'dob' => auth()->user()->dob,
        ]);
    });
});

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.reset');

// for admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::post('set', [AdminController::class, 'setAdmin']);
    Route::post('login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('contactlist', [ContactController::class, 'show'])->name('contactlist');
    Route::get('subscriber', [NewsLetterController::class, 'show'])->name('subscriber');

    //admin category
    Route::get('categorylist', [CategoryController::class, 'show'])->name('categorylist');
    Route::post('addcategory', [CategoryController::class, 'store'])->name('addcategory');

    //admin subcategory
    Route::get('subcategorylist', [SubCategoryController::class, 'show'])->name('subcategorylist');
    Route::post('addsubcategory', [SubCategoryController::class, 'store'])->name('addsubcategory');

    //footer
    Route::post('add-footer', [FooterController::class, 'store']);
    Route::put('update-footer', [FooterController::class, 'update']);

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminController::class, 'logout']);
        Route::post('change-password', [AdminController::class, 'change']);
    });
});

//when come at login without authorization
Route::get('login', function () {
    return response()->json([
        'status' => true,
        'msg' => 'Please Login In First',
    ]);
})->name('error');

// Resource routes
Route::apiResource('user', UserController::class);
Route::apiResource('banners', BannerController::class);
Route::apiResource('sizes', ProductSizeController::class);
Route::apiResource('colors', ProductColorController::class);
Route::apiResource('category', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('subcategory', SubCategoryController::class);
Route::apiResource('order', OrderController::class);
Route::apiResource('carts', CartController::class);
Route::apiResource('billingAddress', BillingController::class);
Route::apiResource('payment', PaymentController::class);
Route::apiResource('shippingAddress', ShippingController::class);
Route::apiResource('language', LanguageController::class);
Route::apiResource('informationslug', InformationSlugController::class);
Route::apiResource('sizes', ProductSizeController::class);

//footer route(to get footer data)
Route::get('footer', [FooterController::class, 'index']);

// Newsletter routes
Route::post('addnewsletter', [NewsLetterController::class, 'store'])->name('addnewsletter');
Route::put('updatenewsletter/{id}', [NewsLetterController::class, 'update'])->name('updatenewsletter');
Route::delete('deletenewsletter/{id}', [NewsLetterController::class, 'destroy'])->name('destroynewsletter');

//routes for contact details .
Route::post('addcontact', [ContactController::class, 'store'])->name('addcontact');
Route::put('updatecontact/{id}', [ContactController::class, 'update'])->name('updatecontact');
Route::delete('deletecontact/{id}', [ContactController::class, 'destroy'])->name('destroycontact');
