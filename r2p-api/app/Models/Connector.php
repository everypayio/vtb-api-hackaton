<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;

/**
 * @property mixed $state_id
 * @property string $driver
 * @property array $credentials
 * @property Carbon $expires_at
 */
class Connector extends Model
{
    protected $fillable = [
        'state_id',
        'driver',
        'credentials',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
