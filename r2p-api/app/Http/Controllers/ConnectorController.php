<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Integrations\IAPI\IAPIClient;
use App\Http\Integrations\IAPI\Requests\CreatePaymentRequest;
use App\Http\Integrations\IAPI\Requests\GetAccountsRequest;
use App\Http\Integrations\ID\IDClient;
use App\Http\Integrations\ID\Requests\AuthVerifyJwtRequest;
use App\Models\Connector;
use App\State\Facades\AuthState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ConnectorController
{
    /**
     * List.
     *
     * @return Response
     */
    public function list(): Response
    {
        $connectors = Connector
            ::query()
            ->forOwner(AuthState::get('authContext.parsed.userId'))
            ->get();

        $connectors = $connectors->map(function (Connector $connector) {
            return [
                'id'       => $connector->getKey(),
                'owner_id' => $connector->owner_id,
                'driver'   => $connector->driver,
            ];
        });

        return response([
            'connectors' => [
                'items' => $connectors,
            ],
        ]);
    }

    /**
     * List accounts.
     *
     * @param Connector $connector
     * @param IDClient $idClient
     * @param IAPIClient $iapiClient
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     * @throws Throwable
     * @throws JsonException
     */
    public function listAccounts(
        Connector  $connector,
        IDClient   $idClient,
        IAPIClient $iapiClient,
    ): Response
    {
        Gate::authorize('connector.listAccounts', $connector);

        // TODO ??? =====>
        $authVerifyJwtRequest = new AuthVerifyJwtRequest();

        $authVerifyJwtRequest->setAccessToken($connector->credentials['access_token']);

        $authVerifyJwtResponse = $idClient->send($authVerifyJwtRequest);

        $authVerifyJwtResponse->throw();
        // TODO ??? <=====
        $iapiClient->setAuthContext($authVerifyJwtResponse->header('X-Auth-Context'));

        $getAccountsRequest = new GetAccountsRequest();
        $getAccountsResponse = $iapiClient->send($getAccountsRequest);

        $getAccountsResponse->throw();

        return response($getAccountsResponse->json());
    }

    /**
     * Create payment.
     *
     * @param Request $request
     * @param Connector $connector
     * @param IDClient $idClient
     * @param IAPIClient $iapiClient
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     * @throws Throwable
     * @throws JsonException
     */
    public function createPayment(
        Request    $request,
        Connector  $connector,
        IDClient   $idClient,
        IAPIClient $iapiClient,
    ): Response
    {
        // TODO validate request
        Gate::authorize('connector.createPayment', $connector);

        // TODO ??? =====>
        $authVerifyJwtRequest = new AuthVerifyJwtRequest();

        $authVerifyJwtRequest->setAccessToken($connector->credentials['access_token']);

        $authVerifyJwtResponse = $idClient->send($authVerifyJwtRequest);

        $authVerifyJwtResponse->throw();
        // TODO ??? <=====
        $iapiClient->setAuthContext($authVerifyJwtResponse->header('X-Auth-Context'));

        $payment = [
            'Data' => [
                'consentId'  => 'f86697df-6b3e-4e98-956e-72c52f585ab1',
                'Initiation' => [
                    'instructionIdentification' => 'ac4f9c3e-fad8-4a01-8f62-ad78e17d5467',
                    'endToEndIdentification'    => '248bbd01-5d23-417d-83d9-9b0608491898',
                    'localInstrument'           => 'tmpVal1',
                    'debtorAccountId'           => $request->get('debtorAccountId'),
                    'InstructedAmount'          => [
                        'amount'   => AuthState::get('amount'),
                        'currency' => AuthState::get('currency'),
                    ],
                    'PaymentContext'            => [
                        'paymentPurpose'  => AuthState::get('purpose'),
                        'paymentPriority' => 5,
                        'forSign'         => 'PaymentForSign',
                    ],
                    'CreditorParty'             => [
                        'name' => AuthState::get('payee.name'),
                        'inn'  => AuthState::get('payee.inn'),
                    ],
                    'CreditorAgent'             => [
                        'schemeName'     => 'RU.CBR.BIK',
                        'identification' => AuthState::get('payeeAgent.bic'),
                        'corrAccount'    => AuthState::get('payeeAgent.corrAccount'),
                    ],
                    'CreditorAccount'           => [
                        'schemeName'     => 'RU.CBR.BBAN',
                        'identification' => AuthState::get('payeeAccount'),
                    ],
                ],
            ],
            'Risk' => [
                'paymentContextCode' => 'EcommerceServices',
            ],
        ];

        $getAccountsRequest = new CreatePaymentRequest($payment);
        $getAccountsResponse = $iapiClient->send($getAccountsRequest);

        $getAccountsResponse->throw();

        return response($getAccountsResponse->json());
    }
}
