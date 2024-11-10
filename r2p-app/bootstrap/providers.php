<?php

use App\Providers\DBServiceProvider;
use MongoDB\Laravel\MongoDBServiceProvider;
use App\Providers\Filament\ClientPanelProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    ClientPanelProvider::class,
    MongoDBServiceProvider::class,
    DBServiceProvider::class,
];
