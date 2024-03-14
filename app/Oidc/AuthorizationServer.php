<?php

namespace App\Oidc;

use League\OAuth2\Server\AuthorizationServer as PassportAuthorizationServer;

class AuthorizationServer extends PassportAuthorizationServer
{
    protected function getResponseType()
    {
        $responseType = new OidcTokenResponse();

        $responseType->setPrivateKey($this->privateKey);
        $responseType->setEncryptionKey(app('encrypter')->getKey());

        return $this->responseType = $responseType;
    }
}
