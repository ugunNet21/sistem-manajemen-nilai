<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Frontend
Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index']);


// Admin Backend
Route::prefix('admin')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
});
