<?php declare(strict_types=1);

namespace App\OAuthClient\Contracts\Grants;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ThirdPartyAuthCodeGrantContract extends AuthCodeGrantContract
{
    /**
     * Get code request.
     *
     * @param string $type
     * @param mixed $userId
     * @return RequestInterface
     */
    public function getCodeRequest(string $type, mixed $userId): RequestInterface;

    /**
     * Get code.
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function getCode(RequestInterface $request): ResponseInterface;
}
