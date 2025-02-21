<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SalesmenController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::post('/items',[ItemController::class,'store']);
// Route::get('/items',[ItemController::class,'index']);
// Route::put('/items/{itemId}',[ItemController::class,'update']);
// Route::get('/items/{itemId}',[ItemController::class,'show']);
// Route::delete('/items/{itemId}',[ItemController::class,'destroy']); 

 Route::apiResource('items',ItemController::class);
 Route::apiResource('customers',CustomerController::class);
 Route::apiResource('salesmen',SalesmenController::class); 

 Route::get('salesmen/{code}/customers', [SalesmenController::class,'GetCustomers']);


