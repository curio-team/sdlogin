<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('edit-self', function ($currentuser, $user) {
            return $currentuser->id == $user->id;
        });

        Passport::routes(function ($router) {
            $router->forAccessTokens();
        });
        //Passport::enableImplicitGrant();

        Route::group(['domain' => 'login.amo.rocks', 'middleware' => ['web', 'auth']], function () {
            Route::get('/oauth/authorize', '\App\Oidc\OidcAuthController@authorize');
        });
        Route::group(['domain' => 'login.curio.codes', 'middleware' => ['web', 'auth']], function () {
            Route::get('/oauth/authorize', '\App\Oidc\OidcAuthController@authorize');
        });

        Passport::tokensExpireIn(Carbon::now()->addMinutes(10));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(10));
    }
}
