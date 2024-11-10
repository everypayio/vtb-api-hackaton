<?php declare(strict_types=1);

namespace App\OAuthClient\Contracts;

use App\OAuthClient\Contracts\Grants\AuthCodeGrantContract;
use App\OAuthClient\Contracts\Grants\ThirdPartyAuthCodeGrantContract;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface OAuthClientContract
{
    /**
     * Get HTTP client.
     *
     * @return ?ClientInterface
     */
    public function getHttpClient(): ?ClientInterface;

    /**
     * Get client id.
     *
     * @return ?string
     */
    public function getClientId(): ?string;

    /**
     * Get client secret.
     *
     * @return ?string
     */
    public function getClientSecret(): ?string;

    /**
     * Get scopes as string.
     *
     * @return string
     */
    public function getScopesAsString(): string;

    /**
     * Determinate is scopes exists.
     *
     * @return bool
     */
    public function hasScopes(): bool;

    /**
     * Get basic auth token.
     *
     * @return string
     */
    public function getBasicAuthToken(): string;

    /**
     * Get token request.
     *
     * @param array $body
     * @return RequestInterface
     */
    public function getTokenRequest(array $body = []): RequestInterface;

    /**
     * Get token.
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function getToken(RequestInterface $request): ResponseInterface;

    /**
     * Get auth code grant.
     *
     * @return ?AuthCodeGrantContract
     */
    public function getAuthCodeGrant(): ?AuthCodeGrantContract;

    /**
     * Get third party auth code grant.
     *
     * @return ?ThirdPartyAuthCodeGrantContract
     */
    public function getThirdPartyAuthCodeGrant(): ?ThirdPartyAuthCodeGrantContract;
}
