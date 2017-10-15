<?php

namespace App\Oidc;
use Laravel\Passport\PassportServiceProvider;
use Laravel\Passport\Bridge\ClientRepository;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\Bridge\ScopeRepository;

/*
*
*   Extending Laravel Passport to support OpenID Connect.
*   We alter the standard token response to include an id_token.
*
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
        return new AuthorizationServer(                     //App\Oidc\AuthorizationServer
            $this->app->make(ClientRepository::class),
            $this->app->make(AccessTokenRepository::class),
            $this->app->make(ScopeRepository::class),
            $this->makeCryptKey('oauth-private.key'),
            app('encrypter')->getKey()
        );
    }
}