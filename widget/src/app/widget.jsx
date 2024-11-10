import { createRoot } from 'react-dom/client';
import App from './App.jsx';

class WidgetR2P {
    constructor() {}

    _mountWidget(container, params) {
        if (container) {
            const domNode = container;
            const root = createRoot(domNode);
            root.render(<App options={params} />);
        } else {
            console.error('Контейнер для виджета не найден.');
        }
    }

    mountWidget(containerIdOrElement, params) {
        let container;
        if (typeof containerIdOrElement === 'string') {
            container = document.getElementById(containerIdOrElement);
        } else if (containerIdOrElement instanceof HTMLElement) {
            container = containerIdOrElement;
        } else {
            console.error('Неверный тип аргумента. Ожидается строка (id) или DOM-элемент.');
            return;
        }

        this._mountWidget(container, params);
    }
}

const r2p = new WidgetR2P();
window.r2p = r2p;
