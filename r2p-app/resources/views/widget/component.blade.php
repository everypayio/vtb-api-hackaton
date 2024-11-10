<div class=" space-y-4">
    <div>
        <h1 class="heading heading-1 text-xl font-semibold">Request-to-pay позволяет подключить форму для выставления платежных поручений прямо в банк-клиенте контрагента.</h1>
    </div>

    <div>
        <form wire:submit="generate" wire:change="generate">
            @if( $this->data['accounts'])

                {{ $this->form }}
            @endif
        </form>
    </div>
    @if( $this->data['accounts'] && $account )
        <x-filament::section>
            <h1>Код виджета</h1>
            @if( $this->account )
                <pre><code class="hljs javascript">{{ $widgetCode }}</code></pre>
            @endif
        </x-filament::section>
    @endif
    <x-filament-actions::modals/>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('widget-updated', () => {
            requestAnimationFrame(() => {
                document.querySelectorAll('pre code.javascript').forEach((element) => {
                    hljs.highlightElement(element);
                });
            });
        });
    })
</script>
