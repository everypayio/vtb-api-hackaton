<?php declare(strict_types=1);

namespace App\Saloon\Traits;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;

trait UseBearerTokenAuthenticatorTrait
{
    protected ?string $accessToken = null;

    /**
     * Set access token.
     *
     * @param ?string $accessToken
     * @return void
     */
    public function setAccessToken(?string $accessToken = null): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Get bearer token authenticator.
     *
     * @return ?Authenticator
     */
    protected function getBearerTokenAuthenticator(): ?Authenticator
    {
        if (is_null($this->accessToken)) {
            return null;
        }

        return new TokenAuthenticator($this->accessToken);
    }
}
