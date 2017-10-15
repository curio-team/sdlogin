<?php
namespace App\Oidc;
use Laravel\Passport\PassportServiceProvider;
use Laravel\Passport\Bridge\ClientRepository;
use Laravel\Passport\Bridge\ScopeRepository;
use League\OAuth2\Server\AuthorizationServer;

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
            $this->app->make(ClientRepository::class), //Laravel\Passport\Bridge\ClientRepository
            $this->app->make(AccessTokenRepository::class), //App\Oidc\AccesTokenRepository
            $this->app->make(ScopeRepository::class), //Laravel\Passport\Bridge\ScopeRepository
            $this->makeCryptKey('oauth-private.key'),
            app('encrypter')->getKey()
        );
    }
}