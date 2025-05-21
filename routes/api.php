<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\ProductTypeApiController;
use App\Http\Controllers\CustomerApiController;
use App\Http\Controllers\StockApiController;
use App\Http\Controllers\SaleApiController;
use App\Livewire\ProductType;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('cliente', CustomerApiController::class);

Route::apiResource('tipoProduto', ProductTypeApiController::class);

Route::apiResource('produto', ProductApiController::class);

Route::apiResource('estoque', StockApiController::class);

Route::apiResource('venda', SaleApiController::class);

// Route::apiResource('cliente', CustomerApiController::class);

// Route::get('tipoProdutos', ProductType::class)->name('tipoProdutos.index');

Route::get('tipoProdutos', function(){
    dd(Auth::user());
})->name('tipoProdutos.index');

