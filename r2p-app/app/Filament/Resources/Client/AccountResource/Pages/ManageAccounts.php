<?php

namespace App\Filament\Resources\Client\AccountResource\Pages;

use Filament\Panel;
use App\Filament\Resources\Client\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAccounts extends ManageRecords
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                                ->mutateFormDataUsing(function ($data) {
                                    $data['owner_id'] = auth()->id();

                                    return $data;
                                }),
        ];
    }

    public static function routes(Panel $panel): void
    {
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['owner_id'] = auth()->user()->id();
        return $data;
    }
}
