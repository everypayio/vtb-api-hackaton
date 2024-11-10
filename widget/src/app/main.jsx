import { createRoot } from 'react-dom/client';
import App from './App.jsx';
const params = { "amount": "12500", "currency": "RUB", "purpose": "Тестовое назначение платежа", "apiKey": "123123123123", "account": "accountId" };
const root = createRoot(document.getElementById('root'));
root.render(<App options={params} />);
