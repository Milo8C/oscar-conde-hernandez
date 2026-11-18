<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Costumers\Orders\Index;
use App\Livewire\Costumers\Orders\Show;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/orders', Index::class)->name('orders.index');
    Route::get('/orders/{order:slug}', Show::class)->name('orders.show');
});
