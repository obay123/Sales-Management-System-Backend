<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SalesmenController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout'])->middleware('auth:sanctum');



 Route::apiResource('items',ItemController::class)->middleware('auth:sanctum');
 Route::apiResource('customers',CustomerController::class);
 Route::apiResource('salesmen',SalesmenController::class); 
 Route::apiResource('invoices', InvoiceController::class);


 Route::get('/salesmen/{salesman}/customers', [SalesmenController::class, 'getCustomers']);


