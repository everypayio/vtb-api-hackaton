<?php declare(strict_types=1);

namespace App\Http\Integrations\IAPI\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreatePaymentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * CreatePaymentRequest constructor.
     *
     * @param array $payment
     */
    public function __construct(
        protected readonly array $payment,
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return '/payments';
    }

    /**
     * {@inheritDoc}
     */
    protected function defaultBody(): array
    {
        return $this->payment;
    }
}
