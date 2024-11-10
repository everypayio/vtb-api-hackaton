<?php declare(strict_types=1);

namespace App\OAuthClient\Contracts\Grants;

use App\OAuthClient\Contracts\Results\AuthorizeUriResultContract;
use Psr\Http\Message\RequestInterface;

interface AuthCodeGrantContract extends GrantContract
{
    /**
     * Get authorize uri.
     *
     * @param array $query
     * @return AuthorizeUriResultContract
     */
    public function getAuthorizeUri(array $query = []): AuthorizeUriResultContract;

    /**
     * Get request.
     *
     * @param mixed $code
     * @param ?string $codeVerifier
     * @return RequestInterface
     */
    public function getRequest(mixed $code, ?string $codeVerifier = null): RequestInterface;
}
