<?php declare(strict_types=1);

namespace App\OAuthClient;

use App\OAuthClient\Contracts\OAuthClientContract;
use App\OAuthClient\Contracts\OAuthManagerContract;

class OAuthClientManager implements OAuthManagerContract
{
    /**
     * {@inheritDoc}
     */
    public function getClient(string $client): OAuthClientContract
    {
        return app("oauth.clients.$client");
    }
}
