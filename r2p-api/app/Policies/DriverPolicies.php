<?php declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

class DriverPolicies
{
    /**
     * Determinate is user can authorize driver.
     *
     * @param ?User $user
     * @param string $driverId
     * @return bool
     */
    public function authorize(?User $user, string $driverId): bool
    {
        return config("drivers.$driverId.isAvailable");
    }
}
