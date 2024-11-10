<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Constants\OAuthConstants;
use App\Http\Integrations\IAPI\IAPIClient;
use App\Http\Integrations\IAPI\Requests\ListThirdPartiesRequest;
use App\OAuthClient\Facades\OAuthClientManager;
use App\State\Facades\AuthState;
use Illuminate\Support\Facades\Gate;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DriverController
{
    /**
     * List.
     *
     * @param IAPIClient $iapiClient
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     * @throws Throwable
     * @throws JsonException
     */
    public function list(IAPIClient $iapiClient): Response
    {
        $iapiClient->setAuthContext(AuthState::get('authContext'));

        $listThirdPartiesRequest = new ListThirdPartiesRequest();
        $listThirdPartiesResponse = $iapiClient->send($listThirdPartiesRequest);

        $listThirdPartiesResponse->throw();

        $drivers = $listThirdPartiesResponse->json();

        for ($i = 0; $i < count($drivers); $i++) {
            $drivers[$i] = array_merge($drivers[$i], config("drivers.{$drivers[$i]['id']}", []));
        }

        return response($drivers);
    }

    /**
     * Authorize.
     *
     * @param string $driverId
     * @return Response
     */
    public function authorize(string $driverId): Response
    {
        Gate::authorize('driver.authorize', $driverId);

        $userId = config('app.internalUserId');
        $oauthProvider = OAuthConstants::CLIENT_EV_ID;
        $thirdPartyAuthCodeGrant = OAuthClientManager::getClient($oauthProvider)->getThirdPartyAuthCodeGrant();
        $codeRequest = $thirdPartyAuthCodeGrant->getCodeRequest('internal', $userId);
        $codeResponse = $thirdPartyAuthCodeGrant->getCode($codeRequest);

        // TODO validate response

        $code = json_decode($codeResponse->getBody()->getContents(), true)['code'];
        $scopes = config("oauth.clients.$oauthProvider.scopes.iapi");

        $authorizeUrlResult = $thirdPartyAuthCodeGrant
            ->getAuthorizeUri([
                'state'       => AuthState::getId(),
                'scope'       => $scopes,
                'third_party' => $driverId,
                'code'        => $code,
            ]);

        AuthState::merge('oauth', [
            'target'       => 'driver',
            'codeVerifier' => $authorizeUrlResult->getCodeVerifier(),
            'driverId'     => $driverId,
        ])->save();

        return redirect($authorizeUrlResult->getAuthorizeUri());
    }
}
