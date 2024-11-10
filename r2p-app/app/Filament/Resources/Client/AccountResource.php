<?php

namespace App\Filament\Resources\Client;

use MongoDB\Laravel\Eloquent\Model;
use Facades\App\Contracts\BankHelper;
use Facades\App\Contracts\BankSuggest;
use Illuminate\Database\Eloquent\Builder as BaseBuilder;
use App\Filament\Resources\Client\AccountResource\Pages;
use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\{Select, TextInput};
use Filament\Tables\{Table, Columns\TextColumn, Actions\EditAction, Actions\DeleteAction, Actions\BulkActionGroup,
    Actions\DeleteBulkAction
};

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;
    protected static ?string $label = 'Счёт';
    protected static ?string $pluralLabel = 'счета';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static string $routePath = '/accounts';


    public static function getEloquentQuery(): BaseBuilder
    {
        return parent::getEloquentQuery()->where('owner_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        $bankSuggest = fn(string $search): array => BankSuggest::suggest('bank', $search);
        $bankOptions = fn(): array => BankSuggest::suggest('bank', '');
        $corrAccountSuggest = fn(?Model $record, Forms\Get $get): array => BankSuggest::suggest(
            'corrAccount',
            $record?->bik ?? $get('bik') ?? 'empty'
        );
        $optionLabel = fn($value) => BankHelper::byBIC($value ?? '')['description'] ?? $value;

        return $form
            ->columns(1)
            ->schema([
                         TextInput::make('title')->required(),
                         Select::make('bik')
                               ->required()
                               ->hint('Введите БИК банка')
                               ->searchable()->searchingMessage('Поиск банка...')
                               ->options($bankOptions)
                               ->getSearchResultsUsing(
                                   $bankSuggest
                               )->live()
                               ->allowHtml()
                               ->updateOptionUsing(fn(Forms\Set $set) => $set('corrAccount', null))
                               ->getOptionLabelUsing($optionLabel),

                         Select::make('corrAccount')
                               ->hidden(fn(Forms\Get $get) => empty($get('bik')) ? true : false)
                               ->live()
                               ->options($corrAccountSuggest)->required()
                               ->label('Корр.счёт'),
                         TextInput::make('number')
                                  ->hidden(fn(Forms\Get $get) => empty($get('corrAccount')) ? true : false)
                                  ->required()
                                  ->label('Счет')
                                  ->hint('Счёт вашей организации'),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          TextColumn::make('bik')->label('Банк'),
                          TextColumn::make('corrAccount')->label('Коррсчет'),
                          TextColumn::make('number')->label('Счёт'),
                      ])
            ->actions([
                          EditAction::make(),
                          DeleteAction::make(),
                      ])
            ->bulkActions([
                              BulkActionGroup::make([
                                                        DeleteBulkAction::make(),
                                                    ]),
                          ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAccounts::route('/'),
        ];
    }
}
