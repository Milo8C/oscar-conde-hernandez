<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Analytics\Index;


Route::middleware(['auth', 'verified', 'role:Administrador'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/analytics', Index::class)->name('analytics.index');
});
