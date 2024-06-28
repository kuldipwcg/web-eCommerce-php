<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\NewsLetterController;

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
Route::post('addcontact', [ContactController::class,'store'])->name('addcontact');
Route::put('updatecontact/{id}', [ContactController::class,'update'])->name('updatecontact');
Route::delete('deletecontact/{id}', [ContactController::class,'destroy'])->name('destroycontact');


//newsletter 
Route::post('addnewsletter', [NewsLetterController::class,'store'])->name('addnewsletter');
Route::put('updatenewsletter/{id}', [NewsLetterController::class,'update'])->name('updatenewsletter');
Route::delete('deletenewsletter/{id}', [NewsLetterController::class,'destroy'])->name('destroynewsletter');


// Route::prefix('admin')->group(function () {
    
//     Route::apiResource('product',ProductController::class);

// });

// Route::prefix('web')->group(function () {

//     Route::apiResource('product',ProductController::class);

// });
