<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Laravel\Passport\ClientRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * The login flow as performed by sdclient: authorization code with state and PKCE, returning an id_token.
 */
class OidcFlowTest extends TestCase
{
    use RefreshDatabase;

    private const AUTHORIZE_URL = 'http://login.curio.codes/oauth/authorize';

    private const REDIRECT_URI = 'https://app.test/sdclient/callback';

    private Client $client;

    private string $clientSecret;

    private string $codeVerifier;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = app(ClientRepository::class)->createAuthorizationCodeGrantClient('Test App', [self::REDIRECT_URI]);
        $this->clientSecret = $this->client->plainSecret;
        $this->codeVerifier = Str::random(128);
    }

    private function authorizeUrl(string $state = 'state-123'): string
    {
        return self::AUTHORIZE_URL . '?' . http_build_query([
            'client_id' => $this->client->getKey(),
            'redirect_uri' => self::REDIRECT_URI,
            'response_type' => 'code',
            'state' => $state,
            'code_challenge' => rtrim(strtr(base64_encode(hash('sha256', $this->codeVerifier, true)), '+/', '-_'), '='),
            'code_challenge_method' => 'S256',
        ]);
    }

    /**
     * Authorizes the client as the given user, returning the callback's query parameters.
     */
    private function authorize(User $user, string $state = 'state-123'): array
    {
        $response = $this->actingAs($user)->get($this->authorizeUrl($state));

        // First time this user uses the app, they have to give consent
        if ($response->isOk()) {
            $response = $this->post(route('passport.authorizations.approve'), [
                'state' => $state,
                'client_id' => $this->client->getKey(),
                'auth_token' => session('authToken'),
            ]);
        }

        $location = $response->headers->get('Location');
        $this->assertStringStartsWith(self::REDIRECT_URI . '?', $location);
        parse_str(parse_url($location, PHP_URL_QUERY), $query);

        return $query;
    }

    private function exchangeCode(string $code, ?string $codeVerifier = null)
    {
        return $this->post('/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $this->client->getKey(),
            'client_secret' => $this->clientSecret,
            'redirect_uri' => self::REDIRECT_URI,
            'code' => $code,
            'code_verifier' => $codeVerifier ?? $this->codeVerifier,
        ]);
    }

    #[Test]
    public function login_returns_an_id_token_for_this_client(): void
    {
        $student = $this->getTestStudent();

        $callback = $this->authorize($student);
        $this->assertEquals('state-123', $callback['state']);

        $response = $this->exchangeCode($callback['code']);
        $response->assertOk();

        $config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText($this->clientSecret));
        $idToken = $config->parser()->parse($response->json('id_token'));

        $this->assertTrue($config->validator()->validate(
            $idToken,
            new SignedWith(new Sha256(), InMemory::plainText($this->clientSecret)),
            // sdclient compares the audience against its SD_CLIENT_ID, which is a string
            new PermittedFor((string) $this->client->getKey()),
        ));
        $this->assertEquals($student->id, json_decode($idToken->claims()->get('user'))->id);
    }

    #[Test]
    public function returning_user_is_redirected_back_with_state(): void
    {
        $student = $this->getTestStudent();
        $this->exchangeCode($this->authorize($student)['code'])->assertOk();

        // Previously authorized, so no consent screen this time
        $response = $this->actingAs($student)->get($this->authorizeUrl('second-state'));

        $response->assertRedirectContains('state=second-state');
    }

    #[Test]
    public function code_cannot_be_redeemed_without_the_pkce_verifier(): void
    {
        $callback = $this->authorize($this->getTestStudent());

        $this->exchangeCode($callback['code'], Str::random(128))
            ->assertStatus(400)
            ->assertJsonMissingPath('id_token');
    }

    #[Test]
    public function user_with_temporary_password_must_change_it_before_signing_in_to_apps(): void
    {
        $student = $this->getTestStudent();
        $student->password_force_change = now();
        $student->save();

        $response = $this->actingAs($student)->get($this->authorizeUrl());

        $response->assertRedirectContains('/users/' . $student->id . '/profile');
        $this->assertDatabaseMissing('oauth_auth_codes', ['user_id' => $student->id]);

        // After changing their password, they continue signing in to the app
        $newPassword = 'Correct-Horse-Battery-Staple-' . Str::random(8);
        $response = $this->patch(route('users.profile_update', $student), [
            'password' => 'password',
            'password_new' => $newPassword,
            'password_new_confirmation' => $newPassword,
        ]);

        $response->assertRedirectContains(self::AUTHORIZE_URL);
        $response->assertRedirectContains('state=state-123');
        $this->assertNull($student->refresh()->password_force_change);

        $this->actingAs($student)->get($this->authorizeUrl())->assertOk();
    }
}
