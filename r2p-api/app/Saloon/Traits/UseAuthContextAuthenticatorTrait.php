<?php declare(strict_types=1);

namespace App\Saloon\Traits;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\HeaderAuthenticator;

trait UseAuthContextAuthenticatorTrait
{
    protected ?string $authContext = null;

    /**
     * Set auth context.
     *
     * @param ?string $authContext
     * @return void
     */
    public function setAuthContext(?string $authContext = null): void
    {
        $this->authContext = $authContext;
    }

    /**
     * Get auth context authenticator.
     *
     * @return ?Authenticator
     */
    protected function getAuthContextAuthenticator(): ?Authenticator
    {
        if (is_null($this->authContext)) {
            return null;
        }

        return new HeaderAuthenticator(
            $this->authContext,
            'X-Auth-Context',
        );
    }
}
