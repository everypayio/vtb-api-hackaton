# Widget

Чтобы собрать билд виджета надо `cp .env.example .env`, добавить настройки и собрать код:
```bash
npm run build
```

### На странице добавить код виджета

```html
<div id="container"></div>
<script src="https://static.r2pay.ru/sdk/v1/js/index.js" onload="onWidgetLoad()" async></script>

<script>
    function onWidgetLoad() {
        window.r2p.mountWidget(document.querySelector('#container'), {
            apikey: 'SOME API KEY', // получить в r2pay.ru
            account: 'SOME ACCOUNT', // получить в r2pay.ru
            // -----
            amount: '12500',
            currency: 'RUB',
            purpose: 'Тестовое назначение платежа',
            apiKey: '123123213'
        });
    }
</script>
```
