<?php

namespace App\Filament\Pages\Client;

use Filament\Pages\Page;
use Filament\Facades\Filament;
use Filament\Actions\Concerns\HasWizard;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Support\Facades\FilamentIcon;
use Filament\Forms\Concerns\InteractsWithForms;

class R2PWidget extends Page
{
    use InteractsWithForms;
    use HasWizard;
    protected static ?int $navigationSort = 10;
    protected static string $routePath = '/widget';

    protected static ?string $title = 'Код виджета';
    protected static string $view = 'widget.constructor';

    protected function getActions(): array
    {
        return [];
    }

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ??
            static::$title ??
            __('filament-panels::pages/dashboard.title');
    }

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return FilamentIcon::resolve('panels::pages.dashboard.navigation-item')
            ?? (Filament::hasTopNavigation() ? 'heroicon-m-adjustments-horizontal' : 'heroicon-o-adjustments-horizontal');
    }

    public static function getRoutePath(): string
    {
        return static::$routePath;
    }

    /**
     * @return int | string | array<string, int | string | null>
     */
    public function getColumns(): int|string|array
    {
        return 1;
    }

    public function getTitle(): string|Htmlable
    {
        return static::$title ?? __('filament-panels::pages/dashboard.title');
    }

}
