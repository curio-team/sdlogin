<?php
/**
 * OAuth 2.0 Bearer Token Response.
 *
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace App\Oidc;

use League\OAuth2\Server\ResponseTypes;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use Psr\Http\Message\ResponseInterface;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Rsa\Sha256;

class OidcTokenResponse extends \League\OAuth2\Server\ResponseTypes\BearerTokenResponse
{
    protected function getExtraParams(AccessTokenEntityInterface $accessToken)
    {
        
        $builder = (new Builder())
            ->setIssuer('https://login.amo.rocks/')
            ->setAudience($accessToken->getClient()->getIdentifier())
            ->setExpiration($accessToken->getExpiryDateTime()->getTimestamp())
            ->setIssuedAt(time())
            ->set('blaat', 'boeheee')
            ->sign(new Sha256(), new Key($privateKey->getKeyPath(), $privateKey->getPassPhrase()))
            ->getToken();
            
        return array('id_token' => (string) $builder);
    }

}
