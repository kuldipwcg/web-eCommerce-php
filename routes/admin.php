<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\InformationSlugController;
use App\Http\Controllers\FooterController; 

// for admin

    //admin sign up
    Route::post('login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('set', [AdminController::class, 'setAdmin']);
    Route::put('update-profile', [AdminController::class, 'update']);

    Route::middleware('auth:admin')->group(function () {  
    //category
    Route::apiResource('category', CategoryController::class);
    
    //subcategory
    Route::apiResource('subcategory', SubCategoryController::class);
    
    //banner 
    Route::apiResource('banners', BannerController::class);

    //products 
    Route::apiResource('products', ProductController::class);
    
    //contactus route
    Route::apiResource('contactlist', ContactController::class);

    //newsletter route
    Route::apiResource('subscriber', NewsLetterController::class);

    //Information slug
    Route::apiResource('informationslug', InformationSlugController::class);

    //footer
    Route::apiResource('footer', FooterController::class);

    //color
    Route::apiResource('colors', ProductColorController::class);

    //size
    Route::apiResource('sizes', ProductSizeController::class);

    //for admin logout and password change
    Route::post('logout', [AdminController::class, 'logout']);
    Route::post('change-password', [AdminController::class, 'change']);

    });