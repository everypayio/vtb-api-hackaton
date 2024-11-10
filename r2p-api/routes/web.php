<?php declare(strict_types=1);

use App\Http\Controllers\DriverController;
use App\Http\Controllers\OAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.state')->group(function () {
    Route::prefix('/oauth')->group(function () {
//        TODO temporary remove
//        Route
//            ::get('/authorize', [OAuthController::class, 'authorize'])
//            ->name('oauth.authorize');

        Route
            ::get('/callback', [OAuthController::class, 'callback'])
            ->name('oauth.callback');
    });

    Route::prefix('/drivers')->group(function () {
        Route::prefix('/{driver}')->group(function () {
            Route
                ::get('/authorize', [DriverController::class, 'authorize'])
                ->name('drivers.authorize');
        });
    });
});
