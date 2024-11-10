<?php declare(strict_types=1);

namespace App\OAuthClient\Results;

use App\OAuthClient\Contracts\Results\AuthorizeUriResultContract;

class AuthorizeUriResult implements AuthorizeUriResultContract
{
    protected ?string $authorizeUri = null;
    protected ?string $codeVerifier = null;

    /**
     * Set authorize uri.
     *
     * @param ?string $authorizeUri
     */
    public function setAuthorizeUri(?string $authorizeUri = null): void
    {
        $this->authorizeUri = $authorizeUri;
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthorizeUri(): string
    {
        return $this->authorizeUri;
    }

    /**
     * Set code verifier.
     *
     * @param ?string $codeVerifier
     */
    public function setCodeVerifier(?string $codeVerifier = null): void
    {
        $this->codeVerifier = $codeVerifier;
    }

    /**
     * {@inheritDoc}
     */
    public function getCodeVerifier(): ?string
    {
        return $this->codeVerifier;
    }
}
