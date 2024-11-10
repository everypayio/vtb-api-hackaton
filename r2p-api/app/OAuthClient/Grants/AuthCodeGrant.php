<?php declare(strict_types=1);

namespace App\OAuthClient\Grants;

use App\OAuthClient\Contracts\Grants\AuthCodeGrantContract;
use App\OAuthClient\Contracts\OAuthClientContract;
use App\OAuthClient\Contracts\Results\AuthorizeUriResultContract;
use App\OAuthClient\Results\AuthorizeUriResult;
use Exception;
use Psr\Http\Message\RequestInterface;

class AuthCodeGrant extends Grant implements AuthCodeGrantContract
{
    protected array $additionalQuery = [];
    protected string $authorizeUriScopeKey = 'scope';
    protected bool $usesPKCE = false;

    /**
     * AuthCodeGrant constructor.
     *
     * @param OAuthClientContract $client
     * @param string $authorizeUri
     * @param string $redirectUri
     */
    public function __construct(
        protected readonly OAuthClientContract $client,
        protected readonly string              $authorizeUri,
        protected readonly string              $redirectUri,
    )
    {
    }

    /**
     * Set additional query.
     *
     * @param array $additionalQuery
     * @return static
     */
    public function additionalQuery(array $additionalQuery = []): static
    {
        $this->additionalQuery = $additionalQuery;

        return $this;
    }

    /**
     * Use PKCE.
     *
     * @param bool $usesPKCE
     * @return static
     */
    public function usePKCE(bool $usesPKCE = true): static
    {
        $this->usesPKCE = $usesPKCE;

        return $this;
    }

    /**
     * {@inheritDoc}
     * @throws Exception
     */
    public function getAuthorizeUri(array $query = []): AuthorizeUriResultContract
    {
        $result = new AuthorizeUriResult();
        $query = $this->getAuthorizeUriBaseQuery($query);

        if ($this->client->hasScopes() && !isset($query['scope'])) {
            $query[$this->authorizeUriScopeKey] = $this->client->getScopesAsString();
        }

        if ($this->usesPKCE && !isset($query['code_challenge'])) {
            $codeVerifier = bin2hex(random_bytes(64));
            $codeChallenge = hash('SHA256', $codeVerifier, true);
            $codeChallenge = rtrim(strtr(base64_encode($codeChallenge), '+/', '-_'), '=');

            $query['code_challenge'] = $codeChallenge;
            $query['code_challenge_method'] = 'S256';

            $result->setCodeVerifier($codeVerifier);
        }

        $query = http_build_query(array_merge($query));

        $result->setAuthorizeUri("$this->authorizeUri?$query");

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function getRequest(mixed $code, ?string $codeVerifier = null): RequestInterface
    {
        return $this->client->getTokenRequest($this->getCredentialsBody($code, $codeVerifier));
    }

    /**
     * Get authorize uri base query.
     *
     * @param array $query
     * @return array
     */
    protected function getAuthorizeUriBaseQuery(array $query): array
    {
        return array_merge([
            'client_id'     => $this->client->getClientId(),
            'redirect_uri'  => $this->redirectUri,
            'response_type' => 'code',
        ], $this->additionalQuery, $query);
    }

    /**
     * Get credentials body.
     *
     * @param mixed $code
     * @param ?string $codeVerifier
     * @return array
     */
    protected function getCredentialsBody(mixed $code, ?string $codeVerifier = null): array
    {
        $body = [
            'grant_type'    => 'authorization_code',
            'client_id'     => $this->client->getClientId(),
            'client_secret' => $this->client->getClientSecret(),
            'code'          => $code,
            'redirect_uri'  => $this->redirectUri,
        ];

        if (!is_null($codeVerifier)) {
            $body['code_verifier'] = $codeVerifier;
        }

        return $body;
    }
}
