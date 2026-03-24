<?php

namespace App\Providers;

use App\Oidc\AuthorizationServer;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider;
use Laravel\Passport\Bridge\ClientRepository;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\Bridge\ScopeRepository;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;

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
    protected function makeAuthorizationServer(?ResponseTypeInterface $responseType = null): AuthorizationServer
    {
        return tap(new AuthorizationServer(
            $this->app->make(ClientRepository::class),
            $this->app->make(AccessTokenRepository::class),
            $this->app->make(ScopeRepository::class),
            $this->makeCryptKey('private'),
            Passport::tokenEncryptionKey($this->app->make('encrypter')),
            $responseType ?? Passport::$authorizationServerResponseType
        ), function (AuthorizationServer $server): void {
            $server->setDefaultScope(Passport::$defaultScope);
            $server->revokeRefreshTokens(Passport::$revokeRefreshTokenAfterUse);
        });
    }
}
