<?php declare(strict_types=1);

namespace App\OAuthClient;

use App\OAuthClient\Contracts\Grants\AuthCodeGrantContract;
use App\OAuthClient\Contracts\Grants\ThirdPartyAuthCodeGrantContract;
use App\OAuthClient\Contracts\OAuthClientContract;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class OAuthClient implements OAuthClientContract
{
    protected ?ClientInterface $httpClient = null;
    protected ?string $clientId = null;
    protected ?string $clientSecret = null;
    protected ?string $tokenUri = null;
    protected array $scopes = [];
    protected ?string $scopesAsString = null;
    protected string $scopeSeparator = ' ';
    protected ?string $basicAuthToken = null;
    protected ?AuthCodeGrantContract $authCodeGrant = null;
    protected ?ThirdPartyAuthCodeGrantContract $thirdPartyAuthCodeGrant = null;

    /**
     * Set HTTP client.
     *
     * @param ?ClientInterface $httpClient
     * @return static
     */
    public function httpClient(?ClientInterface $httpClient = null): static
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpClient(): ?ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * Set client id.
     *
     * @param ?string $clientId
     * @return static
     */
    public function clientId(?string $clientId = null): static
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    /**
     * Set client secret.
     *
     * @param ?string $clientSecret
     * @return static
     */
    public function clientSecret(?string $clientSecret = null): static
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getClientSecret(): ?string
    {
        return $this->clientSecret;
    }

    /**
     * Set token uri.
     *
     * @param ?string $tokenUri
     * @return static
     */
    public function tokenUri(?string $tokenUri = null): static
    {
        $this->tokenUri = $tokenUri;

        return $this;
    }

    /**
     * Set scopes.
     *
     * @param array $scopes
     * @return static
     */
    public function scopes(array $scopes = []): static
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getScopesAsString(): string
    {
        if (is_null($this->scopesAsString)) {
            $this->scopesAsString = implode($this->scopeSeparator, $this->scopes);
        }

        return $this->scopesAsString;
    }

    /**
     * {@inheritDoc}
     */
    public function hasScopes(): bool
    {
        return !empty($this->scopes);
    }

    /**
     * {@inheritDoc}
     */
    public function getBasicAuthToken(): string
    {
        if (is_null($this->basicAuthToken)) {
            $token = $this->clientId;

            if (!is_null($this->clientSecret)) {
                $token = "$token:$this->clientSecret";
            }

            $this->basicAuthToken = base64_encode($token);
        }

        return $this->basicAuthToken;
    }

    /**
     * {@inheritDoc}
     */
    public function getTokenRequest(array $body = []): RequestInterface
    {
        return new Request(
            'POST',
            $this->tokenUri,
            $this->getTokenRequestHeaders(),
            $this->prepareTokenRequestBody($body),
        );
    }

    /**
     * {@inheritDoc}
     * @throws ClientExceptionInterface
     */
    public function getToken(RequestInterface $request): ResponseInterface
    {
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Set auth code grant.
     *
     * @param AuthCodeGrantContract $authCodeGrant
     * @return static
     */
    public function setAuthCodeGrant(AuthCodeGrantContract $authCodeGrant): static
    {
        $this->authCodeGrant = $authCodeGrant;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthCodeGrant(): ?AuthCodeGrantContract
    {
        return $this->authCodeGrant;
    }

    /**
     * Set third party auth code grant.
     *
     * @param ?ThirdPartyAuthCodeGrantContract $thirdPartyAuthCodeGrant
     * @return static
     */
    public function setThirdPartyAuthCodeGrant(?ThirdPartyAuthCodeGrantContract $thirdPartyAuthCodeGrant = null): static
    {
        $this->thirdPartyAuthCodeGrant = $thirdPartyAuthCodeGrant;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getThirdPartyAuthCodeGrant(): ?ThirdPartyAuthCodeGrantContract
    {
        return $this->thirdPartyAuthCodeGrant;
    }

    /**
     * Get token request headers.
     *
     * @return string[]
     */
    protected function getTokenRequestHeaders(): array
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept'       => 'application/json',
        ];
    }

    /**
     * Prepare token request body.
     *
     * @param array $body
     * @return mixed
     */
    protected function prepareTokenRequestBody(array $body): mixed
    {
        return http_build_query($body);
    }
}
