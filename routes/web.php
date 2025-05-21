<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Http;
use App\Livewire\Customer;
use App\Livewire\ProductType;
use App\Livewire\Product;
use App\Livewire\Sale;
use App\Livewire\Stock;
use App\Livewire\Dashboard;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth', 'web'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::get('tipoProduto', ProductType::class)->name('tipoProduto.index');
    Route::get('produto', Product::class)->name('produto.index');
    Route::get('estoque', Stock::class)->name('estoque.index');
    Route::get('venda', Sale::class)->name('venda.index');
    Route::get('cliente', Customer::class)->name('cliente.index');
    Route::get('/', Dashboard::class)->name('dashboard');

});


//         Route::name('tipoProdutos')->group(function(){
//         Route::get('/', [ProductTypeController::class, 'index'])->name('index');
//         Route::post('update', [ProductTypeController::class, 'store'])->name('update');
//         Route::get("show", [ProductTypeController::class, 'show'])->name('show');
//         Route::put('update', [ProductTypeController::class, 'update'])->name('update');
//         Route::delete('destroy', [ProductTypeController::class, 'destroy'])->name('delete');
//     });

require __DIR__.'/auth.php';
