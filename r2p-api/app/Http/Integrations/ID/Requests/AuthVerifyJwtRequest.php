<?php declare(strict_types=1);

namespace App\Http\Integrations\ID\Requests;

use App\Saloon\Traits\UseBearerTokenAuthenticatorTrait;
use Saloon\Contracts\Authenticator;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class AuthVerifyJwtRequest extends Request
{
    use UseBearerTokenAuthenticatorTrait;

    protected Method $method = Method::POST;

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return '/api2/auth/verify-jwt';
    }

    /**
     * {@inheritDoc}
     */
    protected function defaultAuth(): ?Authenticator
    {
        return $this->getBearerTokenAuthenticator();
    }
}
