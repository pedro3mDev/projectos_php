<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Rotas de API
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        // Rotas web
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
