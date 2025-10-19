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

    // Global Search
    Route::get('/search', [App\Http\Controllers\Admin\SearchController::class, 'index'])->name('admin.search');
    Route::get('/search/autocomplete', [App\Http\Controllers\Admin\SearchController::class, 'autocomplete'])->name('admin.search.autocomplete');
    
    // Students
    Route::get('/students/{id}/report/pdf', [App\Http\Controllers\Admin\StudentReportController::class, 'exportPdf'])
        ->name('admin.students.report.pdf');
    Route::get('/students/{id}/report/preview', [App\Http\Controllers\Admin\StudentReportController::class, 'previewPdf'])
        ->name('admin.students.report.preview');
    Route::resource('students', App\Http\Controllers\Admin\StudentController::class)
        ->names('admin.students')
        ->parameters(['students' => 'id']);

    // Grades
    Route::post('grades/import', [App\Http\Controllers\Admin\GradeController::class, 'import'])->name('grades.import');
    Route::get('grades/export', [App\Http\Controllers\Admin\GradeController::class, 'export'])->name('grades.export');
    Route::resource('grades', App\Http\Controllers\Admin\GradeController::class)
        ->names('admin.grades')
        ->parameters(['grades' => 'id']);

    // Reports
    Route::resource('reports', App\Http\Controllers\Admin\ReportController::class)
        ->names('admin.reports')
        ->parameters(['reports' => 'id']);

    // Settings
    Route::resource('settings', App\Http\Controllers\Admin\SettingController::class)
        ->names('admin.settings')
        ->parameters(['settings' => 'id']);
});
