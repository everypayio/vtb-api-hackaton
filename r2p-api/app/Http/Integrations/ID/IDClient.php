<?php declare(strict_types=1);

namespace App\Http\Integrations\ID;

use App\Saloon\Traits\UseBaseUrlTrait;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class IDClient extends Connector
{
    use AcceptsJson;
    use UseBaseUrlTrait;
}
