<?php

namespace App\Providers;

use App\Http\Middleware\EnsureUserAuthenticated;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::aliasMiddleware('auth.custom', EnsureUserAuthenticated::class);
        Route::aliasMiddleware('gest', RedirectIfAuthenticated::class);
    }
}
