
<?php

// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
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
use App\Http\Controllers\FooterController;
use App\Http\Controllers\InformationSlugController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\WishlistController;

// use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Request;
// use Illuminate\Support\Facades\Auth;

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

// routes for contact details .
Route::post('addcontact', [ContactController::class,'store'])->name('addcontact');
Route::put('updatecontact/{id}', [ContactController::class,'update'])->name('updatecontact');
Route::delete('deletecontact/{id}', [ContactController::class,'destroy'])->name('destroycontact');

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('change-password', [UserController::class, 'change']);
    Route::put('update-profile', [UserController::class, 'update']);
    Route::get('profile', function (Request $r) {
        return auth()->user();
    });

    // Route::get('wishlist',[WishlistController::class,'show']);
    // Route::delete('Delete_wishlist', [WishlistController::class, 'destroy']);
    //wishlist
    Route::get('wishlist1',[WishlistController::class,'show'])->name('wishlist');
    Route::delete('Delete_wishlist', [WishlistController::class, 'destroy']);
});
Route::get('wishlistRecords',[WishlistController::class,'index']);
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
Route::apiResource('billingAddress', BillingController::class);
Route::apiResource('shippingAddress', ShippingController::class);
Route::apiResource('language',LanguageController::class);
Route::apiResource('informationslug',InformationSlugController::class);
Route::apiResource('sizes',ProductSizeController::class);

//footer route(to get footer data)
Route::get('footer',[FooterController::class,'index']);

// Newsletter routes
Route::post('addnewsletter', [NewsLetterController::class, 'store'])->name('addnewsletter');
Route::put('updatenewsletter/{id}', [NewsLetterController::class, 'update'])->name('updatenewsletter');
Route::delete('deletenewsletter/{id}', [NewsLetterController::class, 'destroy'])->name('destroynewsletter');

//routes for contact details .
Route::post('addcontact', [ContactController::class,'store'])->name('addcontact');
Route::put('updatecontact/{id}', [ContactController::class,'update'])->name('updatecontact');
Route::delete('deletecontact/{id}', [ContactController::class,'destroy'])->name('destroycontact'); 

