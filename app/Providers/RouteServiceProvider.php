<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Définir la redirection après connexion en fonction du rôle
     */
    public static function redirectTo()
    {
        if (auth()->check()) {
            switch (auth()->user()->role) {
                case 'admin':
                    return '/admin/dashboard';
                case 'technician':
                    return '/technician/dashboard';
                default:
                    return '/user/dashboard';
            }
        }
        return '/login';
    }

    /**
     * Définir le chemin de redirection après connexion
     */
    public const HOME = '/dashboard';

    /**
     * Définir les configurations des routes
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
