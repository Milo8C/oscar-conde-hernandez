<?php

use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome')->name('welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
require __DIR__ . '/products.php';
require __DIR__ . '/cart.php';
require __DIR__ . '/customers.php';
