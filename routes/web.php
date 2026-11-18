<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Dashboard;
// Route::view('/', 'welcome')->name('welcome');

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
require __DIR__ . '/products.php';
require __DIR__ . '/cart.php';
require __DIR__ . '/customers.php';
require __DIR__ . '/stripe.php';
require __DIR__ . '/orders.php';
require __DIR__ . '/analytics.php';
