<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Cart\Checkout;
use App\Livewire\Cart\Success;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', Checkout::class)->name('cart.checkout');
    Route::get('/checkout/success/{order:order_code}', Success::class)->name('cart.success');
});
