<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\UsesUlid;
use MongoDB\Laravel\Eloquent\DocumentModel;

abstract class Model extends \MongoDB\Laravel\Eloquent\Model {
    use UsesUlid;
    use DocumentModel;
    protected $primaryKey = "_id";
    protected $keyType = 'string';

}
