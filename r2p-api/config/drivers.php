<?php declare(strict_types=1);

return [
    'alfa' => [
        'isAvailable' => env('ALFA_IS_AVAILABLE', false),
        'iconUrl'     => env('ALFA_ICON_URL'),
    ],

    'modul' => [
        'isAvailable' => env('MODUL_IS_AVAILABLE', false),
        'iconUrl'     => env('MODUL_ICON_URL'),
    ],

    'sber' => [
        'isAvailable' => env('SBER_IS_AVAILABLE', false),
        'iconUrl'     => env('SBER_ICON_URL'),
    ],

    'tinkoff' => [
        'isAvailable' => env('TINKOFF_IS_AVAILABLE', false),
        'iconUrl'     => env('TINKOFF_ICON_URL'),
    ],

    'tochka' => [
        'isAvailable' => env('TOCHKA_IS_AVAILABLE', false),
        'iconUrl'     => env('TOCHKA_ICON_URL'),
    ],

    'vtb-f46be96d-c67a-43fe-a4d3-8a71eee0c7c4' => [
        'isAvailable' => env('VTB_IS_AVAILABLE', false),
        'iconUrl'     => env('VTB_ICON_URL'),
    ],
];
