import { createContext, useCallback, useEffect, useMemo, useState } from 'react';
import { useSelector } from 'react-redux';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

const EchoContext = createContext();

const EchoContextProvider = ({ children }) => {
    const { stateId } = useSelector((state) => state.account);
    const [channel, setChannel] = useState(null);

    const echo = useMemo(() => {
        return new Echo({
            broadcaster: 'pusher',
            key: import.meta.env.VITE_PUSHER_KEY,
            cluster: import.meta.env.VITE_PUSHER_CLUSTER,
            forceTLS: true,
        });
    }, []);

    const initChannel = useCallback(
        (stateId) => {
            const newChannel = echo.channel(`state.${stateId}`);
            setChannel(newChannel);
        },
        [echo],
    );

    useEffect(() => {
        if (stateId) {
            initChannel(stateId);
        }
    }, [stateId, initChannel]);

    return <EchoContext.Provider value={{ echo, channel, initChannel }}>{children}</EchoContext.Provider>;
};

export { EchoContext, EchoContextProvider };
