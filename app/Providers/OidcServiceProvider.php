<?php

namespace App\Providers;

use App\Oidc\AuthorizationServer;
use Laravel\Passport\PassportServiceProvider;
use Laravel\Passport\Bridge\ClientRepository;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\Bridge\ScopeRepository;

/**
 * Extending Laravel Passport to support OpenID Connect.
 * We alter the standard token response to include an id_token.
 */
class OidcServiceProvider extends PassportServiceProvider
{
    /**
     * Make the authorization service instance.
     *
     * @return AuthorizationServer
     */
    public function makeAuthorizationServer()
    {
        return new AuthorizationServer(
            $this->app->make(ClientRepository::class),
            $this->app->make(AccessTokenRepository::class),
            $this->app->make(ScopeRepository::class),
            $this->makeCryptKey('private'),
            app('encrypter')->getKey()
        );
    }
}
