<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('productType', ProductTypeController::class);

Route::apiResource('product', ProductController::class);

Route::apiResource('supplier', SupplierController::class);

Route::apiResource('customer', CustomerController::class);