<?php declare(strict_types=1);


return [
    'clients' => [
        'default' => [
            'clientId'     => env('ID_CLIENT_ID'),
            'clientSecret' => env('ID_CLIENT_SECRET'),
            'authCodeUrl'  => env('ID_AUTH_CODE_URL'),
            'authorizeUrl' => env('ID_AUTHORIZE_URL'),
            'tokenUrl'     => env('ID_TOKEN_URL'),
            'redirectUrl'  => env('ID_REDIRECT_URI'),
            'scopes'       => [
                'widget' => env('ID_SCOPES_WIDGET'),
                'iapi'   => env('ID_SCOPES_IAPI'),
            ],
        ],
    ],
];
