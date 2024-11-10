<?php

declare(strict_types=1);

namespace App\Contracts;

interface BankHelper
{
    public function byId(string $id);
    public function byBIC(string $bic);
    public function search(array $query, $limit = null): array;
}
