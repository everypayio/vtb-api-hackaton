<?php

declare(strict_types=1);

namespace App\Repositories;

use MongoDB\Collection;
use App\Database\CursorAdapter;

abstract class BaseMongodbRepository
{
    public function __construct(protected Collection $collection) {}

    public function fetchAll(CursorAdapter $cursor): array
    {
        return $cursor->toArray();
    }

    public function first(CursorAdapter $cursor)
    {
        return $cursor->first();
    }
}
