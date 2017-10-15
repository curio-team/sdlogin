<?php

namespace App\Oidc;

use League\OAuth2\Server\ResponseTypes;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use Psr\Http\Message\ResponseInterface;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class OidcTokenResponse extends \League\OAuth2\Server\ResponseTypes\BearerTokenResponse
{
    protected function getExtraParams(AccessTokenEntityInterface $accessToken)
    {
        
        $builder = (new Builder())
            ->setIssuer('https://login.amo.rocks/')
            ->setAudience($accessToken->getClient()->getIdentifier())
            ->setExpiration($accessToken->getExpiryDateTime()->getTimestamp())
            ->setIssuedAt(time())
            ->set('blaat', 'hoi')
            ->sign(new Sha256(), $_POST['client_secret'])
            ->getToken();

        return array('id_token' => (string) $builder);
    }

}
