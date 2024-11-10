<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\CursorAdapter;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface BankRepositoryInterface
{
    public function search(array $filter, ?int $limit = null): CursorAdapter;

    public function byBIC(string $bic): ?array;

    public function find(string $id): array|null|object;
}
