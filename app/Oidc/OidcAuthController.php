<?php
namespace App\Oidc;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\ClientRepository;
use Psr\Http\Message\ServerRequestInterface;
use \Laravel\Passport\Http\Controllers\AuthorizationController as PassportAuthController;

class OidcAuthController extends PassportAuthController
{

	public function authorize(ServerRequestInterface $psrRequest,
                              Request $request,
                              ClientRepository $clients,
                              TokenRepository $tokens)
    {
        return $this->withErrorHandling(function () use ($psrRequest, $request, $clients, $tokens) {
            
            $authRequest = $this->server->validateAuthorizationRequest($psrRequest);
            $user = $request->user();
        	return $this->approveRequest($authRequest, $user);

        });
    }

}