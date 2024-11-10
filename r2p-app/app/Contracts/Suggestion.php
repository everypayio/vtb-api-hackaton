<?php

namespace App\Contracts;

interface Suggestion
{
    public function suggest(string $verb, string $query, int $limit = 10): mixed;
}
