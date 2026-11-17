<?php

use Illuminate\Support\Facades\Route;
use App\livewire\Admin\Costumers\Index;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(['role:Administrador'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/costumers', Index::class)->name('costumers.index');
    });
});
