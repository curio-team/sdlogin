<?php

namespace App\Oidc;

use League\OAuth2\Server\ResponseTypes;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use Psr\Http\Message\ResponseInterface;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Illuminate\Support\Facades\Auth;
use App\User;

class OidcTokenResponse extends \League\OAuth2\Server\ResponseTypes\BearerTokenResponse
{
    protected function getExtraParams(AccessTokenEntityInterface $accessToken)
    {
        
        //building the id_token:
        $user = User::find($accessToken->getUserIdentifier());
        $user->groups = $user->groups->toJson();
        $user = $user->toJson();


        $builder = (new Builder())
            ->setIssuer('https://login.amo.rocks/')
            ->setAudience($accessToken->getClient()->getIdentifier())
            ->setExpiration($accessToken->getExpiryDateTime()->getTimestamp())
            ->setIssuedAt(time())
            ->set('user', $user)
            ->sign(new Sha256(), $_POST['client_secret'])
            ->getToken();

        return array('id_token' => (string) $builder);
    }

}
