<?php

namespace App\Oidc;

use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use League\OAuth2\Server\AuthorizationServer as PassportAuthorizationServer;

class AuthorizationServer extends PassportAuthorizationServer
{
    protected function getResponseTypeOidc(): OidcTokenResponse
    {
        if ($this->responseType instanceof ResponseTypeInterface === false) {
            $this->responseType = new OidcTokenResponse();
        }

        return $this->responseType;
    }

    protected function getResponseType()
    {
        $responseType = $this->getResponseTypeOidc();

        $responseType->setPrivateKey($this->privateKey);
        $responseType->setEncryptionKey(app('encrypter')->getKey());

        return $responseType;
    }
}
