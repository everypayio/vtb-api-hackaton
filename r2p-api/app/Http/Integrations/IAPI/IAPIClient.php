<?php declare(strict_types=1);

namespace App\Http\Integrations\IAPI;

use App\Saloon\Traits\UseAuthContextAuthenticatorTrait;
use App\Saloon\Traits\UseBaseUrlTrait;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class IAPIClient extends Connector
{
    use AcceptsJson;
    use UseBaseUrlTrait;
    use UseAuthContextAuthenticatorTrait;

    /**
     * {@inheritDoc}
     */
    protected function defaultAuth(): ?Authenticator
    {
        return $this->getAuthContextAuthenticator();
    }
}
