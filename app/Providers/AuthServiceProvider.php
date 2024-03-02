<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Oidc\OidcAuthController;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

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
