<?php declare(strict_types=1);

namespace App\Http\Integrations\IAPI\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAccountsRequest extends Request
{
    protected Method $method = Method::GET;
    protected ?int $page = null;

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return '/accounts';
    }

    /**
     * {@inheritDoc}
     */
    protected function defaultQuery(): array
    {
        $query = [];

        if (!is_null($this->page)) {
            $query['page'] = $this->page;
        }

        return $query;
    }
}
