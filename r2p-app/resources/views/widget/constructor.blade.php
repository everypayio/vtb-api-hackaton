<x-filament-panels::page
        @class([
            'fi-resource-view-record-page',
            'fi-resource-widget',
            'fi-resource-record-widget',
        ])
>
    <div
            wire:key="{{ $this->getId() }}.forms.{{ $this->getFormStatePath() }}"
    >
        @livewire('widget-code')
    </div>

</x-filament-panels::page>
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
@endpush
