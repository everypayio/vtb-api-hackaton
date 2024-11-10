<?php declare(strict_types=1);

namespace App\Providers;

use App\Constants\OAuthConstants;
use App\OAuthClient\Contracts\OAuthClientContract;
use App\OAuthClient\Contracts\OAuthManagerContract;
use App\OAuthClient\Grants\AuthCodeGrant;
use App\OAuthClient\Grants\ThirdPartyAuthCodeGrant;
use App\OAuthClient\OAuthClient;
use App\OAuthClient\OAuthClientManager;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;

class OAuthServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->app->singleton(OAuthManagerContract::class, OAuthClientManager::class);

        // Clients
        $this->registerClient(OAuthConstants::CLIENT_EV_ID, [$this, 'makeEvIdClient']);
    }

    /**
     * Register client.
     *
     * @param string $name
     * @param callable $creator
     * @return void
     */
    protected function registerClient(string $name, callable $creator): void
    {
        $abstract = 'oauth.clients.' . $name;
        $config = config('oauth.clients.' . $name);

        $this->app->singleton($abstract, fn() => $creator($config));
    }

    /**
     * Make everypay id client.
     *
     * @param array $config
     * @return OAuthClientContract
     * @throws BindingResolutionException
     */
    protected function makeEvIdClient(array $config): OAuthClientContract
    {
        $client = (new OAuthClient())
            ->httpClient($this->app->make(ClientInterface::class))
            ->clientId($config['clientId'])
            ->clientSecret($config['clientSecret'])
            ->tokenUri($config['tokenUrl'])
            ->scopes($config['scopes']);

        $authCodeGrant = (new AuthCodeGrant(
            $client,
            $config['authorizeUrl'],
            $config['redirectUrl'],
        ))->usePKCE();

        $thirdPartyAuthCodeGrant = (new ThirdPartyAuthCodeGrant(
            $client,
            $config['authCodeUrl'],
            $config['authorizeUrl'],
            $config['redirectUrl'],
        ))->usePKCE();

        return $client
            ->setAuthCodeGrant($authCodeGrant)
            ->setThirdPartyAuthCodeGrant($thirdPartyAuthCodeGrant);
    }
}
