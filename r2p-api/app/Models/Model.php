<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @method static Builder|static query()
 */
class Model extends \MongoDB\Laravel\Eloquent\Model
{
}
