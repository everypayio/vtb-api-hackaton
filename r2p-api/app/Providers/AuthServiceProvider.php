<?php declare(strict_types=1);

namespace App\Providers;

use App\Policies\ConnectorPolicies;
use App\Policies\DriverPolicies;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerPolicies();
    }

    /**
     * Register policies.
     *
     * @return void
     */
    protected function registerPolicies(): void
    {
        $this->registerDriverPolicies();
        $this->registerConnectorPolicies();
    }

    /**
     * Register driver policies.
     *
     * @return void
     */
    protected function registerDriverPolicies(): void
    {
        Gate::define('driver.authorize', [DriverPolicies::class, 'authorize']);
    }

    /**
     * Register connector policies.
     *
     * @return void
     */
    protected function registerConnectorPolicies(): void
    {
        Gate::define('connector.listAccounts', [ConnectorPolicies::class, 'listAccounts']);
        Gate::define('connector.createPayment', [ConnectorPolicies::class, 'createPayment']);
    }
}
