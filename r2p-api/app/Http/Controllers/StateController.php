<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\State\Facades\State;
use Illuminate\Http\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\HttpFoundation\Response;

class StateController
{
    /**
     * Store.
     *
     * @param Request $request
     * @return Response
     * @throws ClientExceptionInterface
     */
    public function store(Request $request): Response
    {
        $validateApiKeyConfig = config('app.validateApiKey');

        $payment = [
            'amount'   => $request->get('amount'),
            'currency' => $request->get('currency'),
            'purpose'  => $request->get('purpose'),
        ];

        /** @var ClientInterface $client */
        $client = app(ClientInterface::class);

        $validateApiKeyRequest = new \GuzzleHttp\Psr7\Request(
            method: 'POST',
            uri: $validateApiKeyConfig['url'],
            headers: [
                'X-Auth-Token' => $validateApiKeyConfig['authToken'],
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
            body: json_encode([
                'api_key' => $request->get('apiKey'),
                'data'    => [
                    'account' => $request->get('account'),
                    'payment' => $payment,
                ],
            ]),
        );

        $validateApiKeyResponse = $client->sendRequest($validateApiKeyRequest);

        if ($validateApiKeyResponse->getStatusCode() >= 400) {
            return response(
                status: $validateApiKeyResponse->getStatusCode(),
                headers: [
                    'X-Proxy' => 'true',
                ],
            );
        }

        $validateApiKeyData = json_decode($validateApiKeyResponse->getBody()->getContents(), true)['data'];

        $payeeData = [
            'payee'        => $validateApiKeyData['payee'],
            'payeeAgent'   => $validateApiKeyData['payeeAgent'],
            'payeeAccount' => $validateApiKeyData['payeeAccount'],
        ];

        $state = State
            ::initialize(array_merge($payment, $payeeData, [
                'authContext' => base64_encode(json_encode([
                    'scopes' => [
                        'iapi/third-parties',
                    ],
                ])),
            ]))
            ->ttl(3600)
            ->save();

        return response([
            'state_id'  => $state->getId(),
            'payeeData' => $payeeData,
        ], 201);
    }
}
