<?php declare(strict_types=1);

namespace App\Policies;

use App\Models\Connector;
use App\Models\User;
use App\State\Facades\AuthState;

class ConnectorPolicies
{
    /**
     * Determinate is user can list accounts.
     *
     * @param ?User $user
     * @param Connector $connector
     * @return bool
     */
    public function listAccounts(?User $user, Connector $connector): bool
    {
        return $this->isOwner($connector) && config("drivers.$connector->driver.isAvailable");
    }

    /**
     * Determinate is user can create payment.
     *
     * @param ?User $user
     * @param Connector $connector
     * @return bool
     */
    public function createPayment(?User $user, Connector $connector): bool
    {
        return $this->isOwner($connector) && config("drivers.$connector->driver.isAvailable");
    }

    /**
     * Determinate is user owner of connector.
     *
     * @param Connector $connector
     * @return bool
     */
    protected function isOwner(Connector $connector): bool
    {
        return $connector->state_id === AuthState::getId();
    }
}
