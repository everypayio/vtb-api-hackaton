<?php declare(strict_types=1);

namespace App\OAuthClient\Grants;

use App\OAuthClient\Contracts\Grants\ThirdPartyAuthCodeGrantContract;
use App\OAuthClient\Contracts\OAuthClientContract;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ThirdPartyAuthCodeGrant extends AuthCodeGrant implements ThirdPartyAuthCodeGrantContract
{
    /**
     * {@inheritDoc}
     * @param string $authCodeUri
     */
    public function __construct(
        OAuthClientContract       $client,
        protected readonly string $authCodeUri,
        string                    $authorizeUri,
        string                    $redirectUri,
    )
    {
        parent::__construct($client, $authorizeUri, $redirectUri);
    }

    /**
     * {@inheritDoc}
     */
    protected function getAuthorizeUriBaseQuery(array $query): array
    {
        $query = parent::getAuthorizeUriBaseQuery($query);
        $query['response_type'] = 'third_party_code';

        return $query;
    }

    /**
     * {@inheritDoc}
     */
    protected function getCredentialsBody(mixed $code, ?string $codeVerifier = null): array
    {
        $body = parent::getCredentialsBody($code, $codeVerifier);
        $body['grant_type'] = 'third_party_authorization_code';

        return $body;
    }

    /**
     * {@inheritDoc}
     */
    public function getCodeRequest(string $type, mixed $userId): RequestInterface
    {
        $headers = [
            'Authorization' => "Basic {$this->client->getBasicAuthToken()}",
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];

        $body = json_encode([
            'type'    => $type,
            'user_id' => $userId,
        ]);

        return new Request('POST', $this->authCodeUri, $headers, $body);
    }

    /**
     * {@inheritDoc}
     * @throws ClientExceptionInterface
     */
    public function getCode(RequestInterface $request): ResponseInterface
    {
        return $this->client->getHttpClient()->sendRequest($request);
    }
}
