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

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [UserController::class, 'logout']);

    Route::prefix('items')->group(function () {
    Route::get('/export', [ItemController::class, 'exportItems']);
    Route::apiResource('', ItemController::class);
    Route::delete('/bulk-delete', [ItemController::class, 'bulkDelete']);
    });

    Route::prefix('invoices')->group(function () {
    Route::apiResource('', InvoiceController::class);
    Route::get('/export', [InvoiceController::class, 'exportInvoices']);
    Route::delete('/bulk-delete', [InvoiceController::class, 'bulkDelete']);
    });

    Route::prefix('customers')->group(function () {
        Route::get('/export', [CustomerController::class, 'exportCustomers']);
        Route::delete('/bulk-delete', [CustomerController::class, 'bulkDelete']);
        Route::apiResource('', CustomerController::class);
    });

    Route::prefix('saleman')->group(function () {
    Route::apiResource('', SalesmenController::class);
    Route::get('/export', [SalesmenController::class, 'exportSalesmen']);
    Route::delete('/bulk-delete', [SalesmenController::class, 'bulkDelete']);
    });
});
