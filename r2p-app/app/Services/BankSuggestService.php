<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Arr;
use App\Contracts\BankHelper;
use Illuminate\Support\Facades\Cache;

class BankSuggestService implements \App\Contracts\Suggestion
{
    protected BankHelper $bankHelper;

    public function __construct(BankHelper $bankHelper)
    {
        $this->bankHelper = $bankHelper;
    }

    public function suggest(string $verb, string $query, int $limit = 10): mixed
    {
        $cacheKey = implode(':', ['suggest1', $verb, $query, $limit]);

        return Cache::remember($cacheKey, env('SUGGEST_CACHE_TTL', 5), fn() => match ($verb) {
            'bank' => $this->suggestBank($query, $limit),
            'corrAccount' => $this->suggestCorrAccountByBIC($query, $limit),
        }
        );
    }

    private function suggestBank($query, int $limit): mixed
    {
        $matches = $this->bankHelper
            ->search(['bic' => $query], $limit);

        return Arr::mapWithKeys($matches, fn($match) => [$match['bic'] => $match['description']]);
    }

    private function suggestCorrAccountByBIC($query, mixed $limit): mixed
    {
        $bank = $this->bankHelper->byBIC($query);

        return $bank ? array_combine($bank['accounts'], $bank['accounts']) : [];
    }
}
