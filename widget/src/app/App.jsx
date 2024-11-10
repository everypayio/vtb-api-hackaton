import { Provider } from 'react-redux';
import { Theme, presetGpnDefault } from '@consta/uikit/Theme';
import { store } from '@/shared/store';
import { AuthContextProvider } from '@/features/account/ui/AuthContext';
import { EchoContextProvider } from '@/entities/echo/echoContext';
import MainPage from '@/pages/main';
import '@/shared/styles/index.scss';

function App({ options }) {
    return (
        <Provider store={store}>
            <Theme preset={presetGpnDefault}>
                <EchoContextProvider>
                    <AuthContextProvider>
                        <MainPage options={options} />
                    </AuthContextProvider>
                </EchoContextProvider>
            </Theme>
        </Provider>
    );
}

export default App;
