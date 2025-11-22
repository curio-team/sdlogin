<?php

namespace App\Providers;

use App\Oidc\OidcAuthController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale(config('app.locale'));

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Gate::define('edit-self', function ($currentuser, $user) {
            return $currentuser->id == $user->id;
        });

        Route::group(['domain' => 'login.amo.rocks', 'middleware' => ['web', 'auth']], function () {
            Route::get('/oauth/authorize', [OidcAuthController::class, 'authorize']);
        });

        Route::group(['domain' => 'login.curio.codes', 'middleware' => ['web', 'auth']], function () {
            Route::get('/oauth/authorize', [OidcAuthController::class, 'authorize']);
        });

        Passport::tokensExpireIn(Carbon::now()->addYear());
        Passport::refreshTokensExpireIn(Carbon::now()->addYear()->addDays(60));

        // Vite must get all asset paths, or it wont properly build the assets (so no looping here)
        $backgrounds = [
            Vite::asset('resources/img/backgrounds/andras-vas-Bd7gNnWJBkU-unsplash.jpg'),
            Vite::asset('resources/img/backgrounds/lorenzo-herrera-p0j-mE6mGo4-unsplash.jpg'),
            Vite::asset('resources/img/backgrounds/lorenzo-herrera-yP89apz2TAA-unsplash.jpg'),
            Vite::asset('resources/img/backgrounds/umberto-jXd2FSvcRr8-unsplash.jpg'),
            Vite::asset('resources/img/backgrounds/codioful-formerly-gradienta-H5eYSjFGw5M-unsplash.jpg'),
        ];

        View::share('backgrounds', $backgrounds);
    }
}
