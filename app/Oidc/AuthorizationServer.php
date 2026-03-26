<?php

namespace App\Oidc;

use League\OAuth2\Server\AuthorizationServer as PassportAuthorizationServer;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;

class AuthorizationServer extends PassportAuthorizationServer
{
    protected function getResponseType(): ResponseTypeInterface
    {
        $responseType = new OidcTokenResponse();

        $responseType->setPrivateKey($this->privateKey);
        $responseType->setEncryptionKey(app('encrypter')->getKey());

        return $this->responseType = $responseType;
    }
}
