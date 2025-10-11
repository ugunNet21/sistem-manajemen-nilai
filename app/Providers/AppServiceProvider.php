<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Repositories\Contracts\Admin\StudentRepositoryInterface::class, \App\Repositories\Admin\StudentRepository::class);
        $this->app->bind(\App\Repositories\Contracts\Admin\GradeRepositoryInterface::class, \App\Repositories\Admin\GradeRepository::class);
        $this->app->bind(\App\Repositories\Contracts\Admin\DashboardRepositoryInterface::class,\App\Repositories\Admin\DashboardRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
