<?php declare(strict_types=1);

namespace App\Providers;

use App\Http\Integrations\IAPI\IAPIClient;
use App\Http\Integrations\ID\IDClient;
use Illuminate\Support\ServiceProvider;

class SaloonServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->app->bind(
            IDClient::class,
            fn() => $this->makeIDClient(),
        );

        $this->app->bind(
            IAPIClient::class,
            fn() => $this->makeIAPIClient(),
        );
    }

    /**
     * Make ID client.
     *
     * @return IDClient
     */
    protected function makeIDClient(): IDClient
    {
        $config = config('services.ev-id');
        $idClient = new IDClient();

        $idClient->setBaseUrl($config['baseUrl']);

        return $idClient;
    }

    /**
     * Make IAPI client.
     *
     * @return IAPIClient
     */
    protected function makeIAPIClient(): IAPIClient
    {
        $config = config('services.ev-iapi');
        $iapiClient = new IAPIClient();

        $iapiClient->setBaseUrl($config['baseUrl']);

        return $iapiClient;
    }
}
