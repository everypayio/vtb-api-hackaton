<?php declare(strict_types=1);

namespace App\OAuthClient\Contracts\Results;

interface AuthorizeUriResultContract
{
    /**
     * Get authorize uri.
     *
     * @return ?string
     */
    public function getAuthorizeUri(): ?string;

    /**
     * Get code verifier.
     *
     * @return ?string
     */
    public function getCodeVerifier(): ?string;
}
