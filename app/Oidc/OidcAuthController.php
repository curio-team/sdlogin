<?php

namespace App\Oidc;

use Illuminate\Http\Request;
use Laravel\Passport\Bridge\User as BridgeUser;
use Laravel\Passport\Contracts\AuthorizationViewResponse;
use Laravel\Passport\Http\Controllers\AuthorizationController as PassportAuthController;
use League\OAuth2\Server\RequestTypes\AuthorizationRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;

class OidcAuthController extends PassportAuthController
{
    public function authorize(
        ServerRequestInterface $psrRequest,
        Request $request,
        ResponseInterface $psrResponse,
        AuthorizationViewResponse $viewResponse,
    ): Response|AuthorizationViewResponse {
        $authRequest = $this->withErrorHandling(
            fn(): AuthorizationRequestInterface => $this->server->validateAuthorizationRequest($psrRequest),
            ($psrRequest->getQueryParams()['response_type'] ?? null) === 'token'
        );

        $user = $request->user();
        $authRequest->setUser(new BridgeUser($user->getAuthIdentifier()));

        return $this->approveRequest($authRequest, $psrResponse);
    }
}
