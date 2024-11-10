<?php
declare(strict_types=1);

namespace App\Contracts;

use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;

interface WidgetDataTransformer
{
    public function transform(FormRequest $request, Account $account): array;
}
