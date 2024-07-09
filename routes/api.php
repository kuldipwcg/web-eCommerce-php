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
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\InformationSlugController;
use App\Http\Controllers\WishlistController; 
use App\Http\Controllers\ReviewController; 

// use App\Http\Controllers\ForgotPasswordController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
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
});

//wishlist 
Route::get('Get-wishlist',[WishlistController::class,'index']);

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.reset');

// for admin
Route::group(['prefix' => 'admin'], function () { 
    //admin sign up
    Route::post('login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('set', [AdminController::class, 'setAdmin']);
    	
    Route::put('update-profile', [AdminController::class, 'update']);

    Route::middleware('auth:admin')->group(function () {  
    //admin category
    Route::get('categorylist', [CategoryController::class,'show'])->name('categorylist');
    Route::post('addcategory', [CategoryController::class,'store'])->name('addcategory');
    Route::put('Update-category', [CategoryController::class,'store'])->name('Update-category');
    Route::delete('Delete-category/{id}', [CategoryController::class, 'destroy'])->name('Delete-category');
    
    //admin subcategory
    Route::get('subcategorylist', [SubCategoryController::class,'show'])->name('subcategorylist');
    Route::post('add-subcategory', [SubCategoryController::class,'store'])->name('add-subcategory');
    Route::put('update-subcategory', [SubCategoryController::class,'store'])->name('update-subcategory');
    Route::delete('Delete-subcategory/{id}', [SubCategoryController::class, 'destroy'])->name('Delete-subcategory');
    //products 
    Route::get('products-list', [ProductController::class,'index'])->name('products-list'); 
    Route::get('products-list/{id}', [ProductController::class,'show']);
    Route::post('products', [ProductController::class,'store']);
    Route::put('products/{id}', [ProductController::class,'update']);
    
    //contactus route
    Route::get('contactlist', [ContactController::class,'index'])->name('contactlist');
    Route::delete('contactlist/{id}', [ContactController::class,'destroy'])->name('Delete-contact');


    //Information slug
    // Route::get('informationslug',[InformationSlugController::class,'index'])->name('informationslug');
    // Route::put('informationslug/{informationslug}',[InformationSlugController::class,'update'])->name('informationslug');
    
    Route::post('logout', [AdminController::class, 'logout']);
    Route::post('change-password', [AdminController::class, 'change']);
    
    Route::get('subscriber', [NewsLetterController::class, 'show'])->name('subscriber');




    //newsletter 
    Route::put('Update-newsletter/{id}', [NewsLetterController::class, 'update'])->name('Update-newsletter');
    Route::delete('Delete-newsletter/{id}', [NewsLetterController::class, 'destroy'])->name('Delete-newsletter');



    //footer 
    Route::post('add-footer', [FooterController::class, 'store']);
    Route::put('update-footer', [FooterController::class, 'update']);
    Route::get('footer',[FooterController::class,'index']);

    });
});

//when come at login without authorization 
Route::get('login', function () {
    return response()->json([
        "status" => true,
        "msg" => 'Please Login In First'
    ]);
})->name('error');

//informationslug route
// Route::get('informationslug/{informationslug}',[InformationSlugController::class,'show'])->name('informationslug');

// Resource routes
Route::apiResource('user', UserController::class);
Route::apiResource('sizes', ProductSizeController::class);
Route::apiResource('colors', ProductColorController::class);
Route::apiResource('banners', BannerController::class);
Route::apiResource('category', CategoryController::class);
Route::apiResource('subcategory', SubCategoryController::class);
Route::apiResource('order', OrderController::class);
Route::apiResource('carts', CartController::class);
Route::apiResource('billingAddress', BillingController::class);
Route::apiResource('shippingAddress', ShippingController::class);
Route::apiResource('language',LanguageController::class);
Route::apiResource('sizes',ProductSizeController::class);

//contactus route
Route::post('add-contact', [ContactController::class,'store'])->name('add-contact');

//products
Route::get('products/{id}', [ProductController::class,'show'])->name('products');
Route::get('products-list', [ProductController::class,'index']);
Route::post('filter-product', [ProductController::class,'display']);

//footer route(to get footer data)
Route::get('footer',[FooterController::class,'index']);

// Newsletter routes
Route::post('addnewsletter', [NewsLetterController::class, 'store'])->name('addnewsletter');

//filter and product search
Route::post('display-product', [ProductController::class,'display']);

//cart 
Route::post('add-to-cart', [CartController::class,'store'])->name('add-to-cart');

//routes for contact details .
Route::post('addcontact', [ContactController::class,'store'])->name('addcontact');
Route::put('updatecontact/{id}', [ContactController::class,'update'])->name('updatecontact');
Route::delete('deletecontact/{id}', [ContactController::class,'destroy'])->name('destroycontact'); 

Route::apiResource('reviews', ReviewController::class);




//status
Route::put('colorstatus/{id}', [ProductColorController::class, 'colorstatus']);
Route::put('sizestatus/{id}', [ProductSizeController::class, 'sizestatus']);



Route::apiResource('cat', CategoryController::class);
