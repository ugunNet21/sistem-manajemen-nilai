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
    
    Route::resource('students', App\Http\Controllers\Admin\StudentController::class)
        ->names('admin.students')
        ->parameters(['students' => 'id']);

    Route::resource('grades', App\Http\Controllers\Admin\GradeController::class)
        ->names('admin.grades')
        ->parameters(['grades' => 'id']);

    Route::resource('reports', App\Http\Controllers\Admin\ReportController::class)
        ->names('admin.reports')
        ->parameters(['reports' => 'id']);

    Route::resource('settings', App\Http\Controllers\Admin\SettingController::class)
        ->names('admin.settings')
        ->parameters(['settings' => 'id']);
});
