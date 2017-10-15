<?php

namespace App\Oidc;
use League\OAuth2\Server\ResponseTypes\BearerTokenResponse;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use League\OAuth2\Server\AuthorizationServer as PassportAuthorizationServer;

class AuthorizationServer extends PassportAuthorizationServer
{
    protected function getResponseType()
    {
        if ($this->responseType instanceof ResponseTypeInterface === false) {
            $this->responseType = new OidcTokenResponse();
        }

        $this->responseType->setPrivateKey($this->privateKey);
        $this->responseType->setEncryptionKey(app('encrypter')->getKey());

        return $this->responseType;
    }
}
