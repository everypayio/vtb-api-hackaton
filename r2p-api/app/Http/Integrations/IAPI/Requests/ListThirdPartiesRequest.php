<?php declare(strict_types=1);

namespace App\Http\Integrations\IAPI\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListThirdPartiesRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return '/parties';
    }
}
