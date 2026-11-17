<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Cart\Checkout;
use App\Livewire\Cart\Success;

Route::get('/checkout', Checkout::class)->name('cart.checkout');
Route::get('/checkout/success', Success::class)->name('cart.success');