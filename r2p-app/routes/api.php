<?php

use App\Services\WidgetService;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\ExchangeRequest;

Route::group([], function () {
    Route::post('/code', function (ExchangeRequest $request, WidgetService $service) {
        $data = $service->forceExchange($request);

        return \response()->json($data);
    });
});

Route::fallback(function () {
    abort(404, 'API resource not found');
});

