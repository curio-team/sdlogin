<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace App\Oidc;

use League\OAuth2\Server\ResponseTypes\BearerTokenResponse;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use League\OAuth2\Server\AuthorizationServer as PassportAuthorizationServer;

class AuthorizationServer extends PassportAuthorizationServer
{

    private $encryptionKey;

     public function __construct(
        ClientRepositoryInterface $clientRepository,
        AccessTokenRepositoryInterface $accessTokenRepository,
        ScopeRepositoryInterface $scopeRepository,
        $privateKey,
        $encryptionKey,
        ResponseTypeInterface $responseType = null
    ) {
        $this->encryptionKey = $encryptionKey;
        parent::__construct();
    }

    /**
     * Get the token type that grants will return in the HTTP response.
     *
     * @return ResponseTypeInterface
     */
    protected function getResponseType()
    {
        if ($this->responseType instanceof ResponseTypeInterface === false) {
            $this->responseType = new OidcTokenResponse();
        }

        $this->responseType->setPrivateKey($this->privateKey);
        $this->responseType->setEncryptionKey($this->encryptionKey);

        return $this->responseType;
    }
}
