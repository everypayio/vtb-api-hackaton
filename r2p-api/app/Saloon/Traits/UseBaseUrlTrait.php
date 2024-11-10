<?php declare(strict_types=1);

namespace App\Saloon\Traits;

trait UseBaseUrlTrait
{
    protected ?string $baseUrl = null;

    /**
     * Set base URL.
     *
     * @param ?string $baseUrl
     * @return void
     */
    public function setBaseUrl(?string $baseUrl = null): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * {@inheritDoc}
     */
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
