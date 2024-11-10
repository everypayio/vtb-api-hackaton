<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Constants\OAuthConstants;
use App\Events\AuthorizedEvent;
use App\Http\Integrations\ID\IDClient;
use App\Http\Integrations\ID\Requests\AuthVerifyJwtRequest;
use App\Models\Connector;
use App\OAuthClient\Facades\OAuthClientManager;
use App\State\Facades\AuthState;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class OAuthController
{
    /**
     * Authorize.
     *
     * @return Response
     */
    public function authorize(): Response
    {
        $oauthProvider = OAuthConstants::CLIENT_EV_ID;
        $scopes = config("oauth.clients.$oauthProvider.scopes.widget");

        $authorizeUrlResult = OAuthClientManager
            ::getClient($oauthProvider)
            ->getAuthCodeGrant()
            ->getAuthorizeUri([
                'state' => AuthState::getId(),
                'scope' => $scopes,
            ]);

        AuthState::merge('oauth', [
            'target'       => 'user',
            'codeVerifier' => $authorizeUrlResult->getCodeVerifier(),
        ])->save();

        return redirect($authorizeUrlResult->getAuthorizeUri());
    }

    /**
     * Callback.
     *
     * @param Request $request
     * @return mixed
     * @throws FatalRequestException
     * @throws RequestException
     * @throws Throwable
     */
    public function callback(Request $request): mixed
    {
        $oauthTarget = AuthState::get('oauth.target');

        if ($oauthTarget === 'user') {
            return $this->callbackUser($request);
        }

        if ($oauthTarget === 'driver') {
            return $this->callbackDriver($request);
        }

        abort(419);
    }

    /**
     * Handle callback for user.
     *
     * @param Request $request
     * @return View
     * @throws FatalRequestException
     * @throws RequestException
     * @throws Throwable
     */
    protected function callbackUser(Request $request): View
    {
        /** @var IDClient $idClient */
        $idClient = app(IDClient::class);
        $oauthClient = OAuthClientManager::getClient(OAuthConstants::CLIENT_EV_ID);

        $getTokenRequest = $oauthClient
            ->getAuthCodeGrant()
            ->getRequest(
                $request->get('code'),
                AuthState::get('oauth.codeVerifier'),
            );

        $credentialsResponse = $oauthClient->getToken($getTokenRequest);

        // TODO validate response

        $credentials = json_decode($credentialsResponse->getBody()->getContents(), true);
        $authVerifyJwtRequest = new AuthVerifyJwtRequest();

        $authVerifyJwtRequest->setAccessToken($credentials['access_token']);

        $authVerifyJwtResponse = $idClient->send($authVerifyJwtRequest);

        $authVerifyJwtResponse->throw();

        $rawAuthContext = $authVerifyJwtResponse->header('X-Auth-Context');

        AuthState::set('user', [
            'credentials' => $credentials,
        ]);

        AuthState::set('authContext', [
            'raw'    => $rawAuthContext,
            'parsed' => json_decode(base64_decode($rawAuthContext), true),
        ]);

        AuthState::save();
        event(new AuthorizedEvent(AuthState::getId(), true));

        return view('closer');
    }

    /**
     * Handle callback for driver.
     *
     * @param Request $request
     * @return View
     */
    protected function callbackDriver(Request $request): View
    {
        $oauthClient = OAuthClientManager::getClient(OAuthConstants::CLIENT_EV_ID);

        $getTokenRequest = $oauthClient
            ->getThirdPartyAuthCodeGrant()
            ->getRequest(
                $request->get('code'),
                AuthState::get('oauth.codeVerifier'),
            );

        $credentialsResponse = $oauthClient->getToken($getTokenRequest);

        // TODO validate response

        $credentials = json_decode($credentialsResponse->getBody()->getContents(), true);

        $expiresAt = Carbon
            ::now()
            ->addSeconds($credentials['expires_in'])
            ->subMinutes(15);

        /** @var Connector $connector */
        $connector = Connector::query()->create([
            'state_id'    => AuthState::getId(),
            'driver'      => AuthState::get('oauth.driverId'),
            'credentials' => $credentials,
            'expires_at'  => $expiresAt,
        ]);

        event(new AuthorizedEvent(AuthState::getId(), true, [
            'connectorId' => $connector->getKey(),
        ]));

        return view('closer');
    }
}
