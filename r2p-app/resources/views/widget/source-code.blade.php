<div id="container"></div>
<script src="https://webdem.ru/sdk/v1/js/index.js" onload="onWidgetLoad()" async></script>

<script>
    function onWidgetLoad() {
        // Инициализация виджета
        window.r2p.init({
            // Ваш API KEY
            apiKey: '{{ $apikey }}',

            // Банк {!! $bank['name'] ?? '' !!} БИК {{ $bank['bic'] ?? '' }} Корр.счет {{ $corrAccount ?? '' }}
            // Счёт для зачисления {!! $accountMasked ?? '' !!}
            account: '{{ $account ?? '' }}'
        });

        window.r2p.mountWidget(document.querySelector('#container'), {
            amount: '12500',
            currency: 'RUB',
            purpose: 'Назначение платежа согласно выставленному счету',
            payer: { // указываются реквизиты вашего плательщика
                inn: 'ИНН плательщика',
                kpp: 'КПП плательщика',
                name: 'ООО Плательщик'
            },
        });
    }
</script>
