<?php declare(strict_types=1);

namespace App\OAuthClient\Contracts;

interface OAuthManagerContract
{
    /**
     * Get client.
     *
     * @param string $client
     * @return OAuthClientContract
     */
    public function getClient(string $client): OAuthClientContract;
}
