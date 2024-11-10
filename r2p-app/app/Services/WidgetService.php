<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ExchangeRequest;
use App\Contracts\WidgetDataTransformer;

class WidgetService
{
    public function __construct(protected WidgetDataTransformer $transformer) { }

    public function forceExchange(ExchangeRequest $request)
    {
        $apikey = $request->getApikey();
        $account = $request->getAccount();
        $user = User::query()->firstOrFail(['apikey' => $apikey], "invalid apikey for user");
        $account = Account::findOrFail($account);

        if (Gate::forUser($user)->denies('view', $account)) {
            abort(403, "Unauthorized");
        }

        return ['data' => $this->transformer->transform($request, $account)];
    }
}
