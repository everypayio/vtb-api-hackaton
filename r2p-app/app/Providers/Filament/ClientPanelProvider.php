<?php

namespace App\Providers\Filament;

use Filament\Support\Assets\Theme;
use App\Filament\Pages\Client\R2PWidget;
use App\Filament\Pages\Client\SortUsers;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Resources\Client\AccountResource\Pages\ManageAccounts;

class ClientPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()->spa()
            ->id('client')
            ->login()
            ->path('')
            ->registration()
            ->passwordReset()
            ->profile()
            ->unsavedChangesAlerts()
            ->discoverResources(in: app_path('Filament/Resources/Client'), for: 'App\\Filament\\Resources\\Client')
            ->discoverPages(in: app_path('Filament/Pages/Client'), for: 'App\\Filament\\Pages\\Client')
            ->pages([
                        Pages\Dashboard::class,
                        R2PWidget::class,
                    ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                          Widgets\AccountWidget::class,
                          Widgets\FilamentInfoWidget::class,
                      ])
            ->middleware([
                             EncryptCookies::class,
                             AddQueuedCookiesToResponse::class,
                             StartSession::class,
                             AuthenticateSession::class,
                             ShareErrorsFromSession::class,
                             VerifyCsrfToken::class,
                             SubstituteBindings::class,
                             DisableBladeIconComponents::class,
                             DispatchServingFilamentEvent::class,
                         ])
            ->authMiddleware([
                                 Authenticate::class,
                             ]);
    }
}
