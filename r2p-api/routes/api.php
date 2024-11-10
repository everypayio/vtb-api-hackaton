<?php declare(strict_types=1);

use App\Http\Controllers\ConnectorController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;

Route::prefix('/state')->group(function () {
    Route
        ::post('/', [StateController::class, 'store'])
        ->name('api.state.store');
});

Route::middleware('auth.state')->group(function () {
    Route::prefix('/drivers')->group(function () {
        Route
            ::get('/', [DriverController::class, 'list'])
            ->name('api.drivers.list');
    });

    Route::prefix('/connectors')->group(function () {
//        TODO temporary remove
//        Route
//            ::get('/', [ConnectorController::class, 'list'])
//            ->name('api.connectors.list');

        Route::prefix('/{connector}')->group(function () {
            Route
                ::get('/accounts', [ConnectorController::class, 'listAccounts'])
                ->name('api.connectors.listAccounts');

            Route
                ::post('/payments', [ConnectorController::class, 'createPayment'])
                ->name('api.connectors.createPayment');
        });
    });
});
