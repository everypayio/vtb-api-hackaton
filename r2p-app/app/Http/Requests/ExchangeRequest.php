<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExchangeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'api_key'         => 'required|exists:users,apikey',
            'data'            => 'required',
            'data.account'    => "required",
            //'data.payerAccount' => "required",
            'data.payment'    => [
                'amount'   => 'required',
                'purpose'  => 'required',
                'currency' => 'required',
            ],
            'data.payer'      => [
                //"inn"  => "required",
                //"kpp"  => "required",
                //"name" => "required",
            ],
            "data.payerAgent" => [
                //"bic"         => "required",
                //"corrAccount" => "required",
            ],
            //"http_referer"
        ];
    }

    public function getApikey()
    {
        return $this->json('api_key');
    }

    public function getAccount()
    {
        return $this->json('data.account');
    }

}
