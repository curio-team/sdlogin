<?php

namespace App\Oidc;

use App\Models\User;
use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class OidcTokenResponse extends \League\OAuth2\Server\ResponseTypes\BearerTokenResponse
{
    protected function getExtraParams(AccessTokenEntityInterface $accessToken)
    {
        $user = User::find($accessToken->getUserIdentifier());
        $user->groups = $user->groups->toJson();
        $user = $user->toJson();

        $signingKey = InMemory::plainText($_POST['client_secret']);

        $token = (new JwtFacade())
            ->issue(
                new Sha256(),
                $signingKey,
                static fn (
                    Builder $builder,
                    DateTimeImmutable $issuedAt,
                ): Builder => $builder
                    ->issuedBy('https://login.curio.codes/')
                    ->permittedFor($accessToken->getClient()->getIdentifier())
                    ->expiresAt($accessToken->getExpiryDateTime())
                    ->issuedAt(new DateTimeImmutable())
                    ->withClaim('user', $user)
            );

        return [
            'id_token' => $token->toString(),
        ];
    }
}
