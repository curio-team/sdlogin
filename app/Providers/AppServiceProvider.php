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

        Passport::tokensExpireIn(Carbon::now()->addMinutes(10));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(10));
    }
}
