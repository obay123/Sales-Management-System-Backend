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

    Route::get('items/export', [ItemController::class, 'exportItems']);
    Route::apiResource('items', ItemController::class);

    Route::apiResource('invoices', InvoiceController::class);
    Route::get('invoices/export', [InvoiceController::class, 'exportInvoices']);

    Route::prefix('customers')->group(function () {
        Route::get('/export', [CustomerController::class, 'exportCustomers']);
        Route::delete('/bulk-delete', [CustomerController::class, 'bulkDelete']);
        Route::apiResource('', CustomerController::class);
    });
    Route::apiResource('salesmen', SalesmenController::class);
    Route::get('salesmen/export', [SalesmenController::class, 'exportSalesmen']);
});
