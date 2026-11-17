<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Products\Index;
use App\Livewire\Admin\Products\Index as ProductsIndex;
use App\Livewire\Admin\Products\Edit as ProductEdit;
use App\Livewire\Admin\Products\Trash as ProductsTrash;


Route::get('/', ProductsIndex::class)->name('welcome');
Route::get('products/{product}', ProductsIndex::class)->name('products.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(['role:Administrador'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('products', ProductsIndex::class)->name('products.index');
        Route::get('trash/products', ProductsTrash::class)->name('products.trash');
        Route::get('products/{product:slug}/edit', ProductEdit::class)->name('products.edit');
        Route::delete('products/{product}', Index::class)->name('products.destroy');
    });
});
