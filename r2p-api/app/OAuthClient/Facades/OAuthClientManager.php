<?php declare(strict_types=1);

namespace App\OAuthClient\Facades;

use App\OAuthClient\Contracts\OAuthClientContract;
use App\OAuthClient\Contracts\OAuthManagerContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static OAuthClientContract getClient(string $client)
 *
 * @see OAuthManagerContract
 * @see \App\OAuthClient\OAuthClientManager
 */
class OAuthClientManager extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return OAuthManagerContract::class;
    }
}
