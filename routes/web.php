<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProductController;
use App\Livewire\ProductType;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'web'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::prefix('tipoProduto')->group(function(){
        Route::get('/', ProductType::class)->name('tipoProduto.index');
    });

})->name('tipoProduto');


//         Route::name('tipoProdutos')->group(function(){
//         Route::get('/', [ProductTypeController::class, 'index'])->name('index');
//         Route::post('update', [ProductTypeController::class, 'store'])->name('update');
//         Route::get("show", [ProductTypeController::class, 'show'])->name('show');
//         Route::put('update', [ProductTypeController::class, 'update'])->name('update');
//         Route::delete('destroy', [ProductTypeController::class, 'destroy'])->name('delete');
//     });

require __DIR__.'/auth.php';
