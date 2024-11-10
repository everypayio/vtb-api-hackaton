<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class WidgetCode extends Component implements HasForms
{
    use InteractsWithForms;

    public ?string $account = null;

    public ?array $data = [
        'account'  => null,
        'bank'     => '',
        'accounts' => [],
    ];
    public string $widgetCode = '';
    public Collection $bankAccounts;

    protected function prepareState()
    {
        $user = auth()->user();
        $this->data['apikey'] = $user->getApikey();
        $this->data['accounts'] = $user->accounts->pluck('shortName', 'id')->toArray();

        if (count($this->data['accounts'])) {
            $account = $user->accounts->first();
            $this->data = [
                    'account'       => $account->id,
                    'accountMasked' => $account->accountMasked,
                    'bank'          => $account->bank->only('name', 'bic'),
                    'corrAccount'   => $account->corrAccount,
                    //                    'accounts'      => $this->bankAccounts->pluck('shortName', 'id')->toArray(),
                ] + $this->data;
        }

        $this->generate();

        return $this->data;
    }

    public function mount(): void
    {
        $this->form->fill();
        $this->data = $this->prepareState();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                         TextInput::make('apikey')
                                  ->label("Ваш API-ключ виджета")
                                  ->readOnly(true),
                         Select::make('account')->options(
                             fn($state) => $this->data['accounts']
                         )->required()
                               ->getOptionLabelUsing(
                                   fn($state) => $this->data['accounts'] ?? []
                               )
                               ->reactive(),
                     ])
            ->statePath('data');
    }

    public function generate()
    {
        $this->account = $this->data['account'];
        $this->widgetCode = $this->renderWidget();
        $this->dispatch('widget-updated');
    }

    public function renderWidget()
    {
        return view('widget.source-code', $this->data);
    }

    public function render()
    {
        return view('widget.component');
    }

}
