<?php declare(strict_types=1);

namespace App\State\Facades;

use App\State\Contracts\StateContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static StateContract initialize(array $state = [])
 * @method static StateContract prepare(string $id)
 * @method static StateContract save()
 * @method static string|null getId()
 * @method static StateContract set(string $key, mixed $value)
 * @method static StateContract merge(string $key, array $state)
 * @method static mixed get(?string $key = null, mixed $default = null)
 *
 * @see StateContract
 * @see \App\State\State
 */
class State extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return StateContract::class;
    }
}
