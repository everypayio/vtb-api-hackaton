<?php

namespace App\Transformers;

use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Support\Number;
use App\Contracts\WidgetDataTransformer as TransformerInterface;
use Illuminate\Foundation\Http\FormRequest;

class WidgetDataTransformer implements TransformerInterface
{
    protected $data = [
        "data" => [
            "payee"        => [
                "inn"  => "ИНН",
                "kpp"  => "КПП если есть",
                "name" => "ООО Получатель платежа",
            ],
            "payeeAgent"   => [
                "bic"         => "БИК",
                "corrAccount" => "корр счёт",
                "name"        => "Имя банка получателя",
            ],
            "payeeAccount" => "номер счета Получателя в банке",
            "payer"        => [
                "inn"  => "ИНН",
                "kpp"  => "КПП если есть",
                "name" => "ООО Плательщик платежа",
            ],
            "payerAgent"   => [
                "bic"         => "БИК",
                "corrAccount" => "корр счёт",
                "name"        => "Имя банка плательщика",
            ],
            "payerAccount" => "номер счета Плательщика в банке",
            "payment"      => [
                "amount"   => 1234.67,
                "purpose"  => "Назначение платежа",
                "priority" => 5,
                "number"   => 123,
            ],
        ],
    ];

    public function transform(FormRequest $request, Account $account): array
    {
        $payee = array_filter([
                                  'inn'  => $account->owner->organization['inn'] ?? null,
                                  'kpp'  => $account->owner->organization['kpp'] ?? null,
                                  'name' => $account->owner->organization['name'] ?? null,
                              ])
            + $request->json('data.payee', []);

        $payeeAgent = [
            'bic'         => $account->bik,
            'name'        => $account->bank->name,
            'corrAccount' => $account->corrAccount,
        ];
        $payeeAccount = $account->number;

        $payer = $request->json('data.payer');
        $payerAccount = $request->json('data.payerAccount');
        $payerAgent = $request->json('data.payee');

        $payment = $request->json('data.payment') + ['paymentPriority' => 5, 'number' => random_int(1, 500)];

        return array_filter(compact('payee', 'payeeAgent', 'payeeAccount', 'payer', 'payerAgent', 'payerAccount', 'payment'));
    }
}
