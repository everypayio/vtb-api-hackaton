<?php declare(strict_types=1);

namespace App\State\Facades;

use App\State\Contracts\StateContract;

class AuthState extends State
{
    protected static ?StateContract $state = null;

    /**
     * Set facade root.
     *
     * @param StateContract $state
     * @return void
     */
    public static function setFacadeRoot(StateContract $state): void
    {
        static::$state = $state;
    }

    /**
     * {@inheritDoc}
     */
    public static function getFacadeRoot(): ?StateContract
    {
        return static::$state;
    }
}
