<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProductColorController;



//color
Route::apiResource('colors', ProductColorController::class);