<?php declare(strict_types=1);

namespace App\Providers;

use App\State\Contracts\StateContract;
use App\State\RedisState;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        // Service providers
        $this->app->register(OAuthServiceProvider::class);
        $this->app->register(SaloonServiceProvider::class);

        // Singletons
        $this->app->singleton(StateContract::class, fn() => $this->makeRedisState());

        // Binds
        $this->app->bind(ClientInterface::class, Client::class);
    }

    /**
     * Make redis state.
     *
     * @return RedisState
     */
    protected function makeRedisState(): RedisState
    {
        $config = config('services.state.redis');

        return (new RedisState(
            prefix: $config['prefix'],
        ));
    }
}
