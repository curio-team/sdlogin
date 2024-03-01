<?php

namespace App\Oidc;

use App\Models\User;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class OidcTokenResponse extends \League\OAuth2\Server\ResponseTypes\BearerTokenResponse
{
    protected function getExtraParams(AccessTokenEntityInterface $accessToken)
    {
        $user = User::find($accessToken->getUserIdentifier());
        $user->groups = $user->groups->toJson();
        $user = $user->toJson();

        $builder = (new Builder())
            ->issuedBy('https://login.curio.codes/')
            ->permittedFor($accessToken->getClient()->getIdentifier())
            ->expiresAt($accessToken->getExpiryDateTime())
            ->issuedAt(new \DateTimeImmutable())
            ->withClaim('user', $user)
            ->getToken(new Sha256(), $_POST['client_secret']);

        return array('id_token' => (string) $builder);
    }
}
