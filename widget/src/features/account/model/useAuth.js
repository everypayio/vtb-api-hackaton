import { useCallback, useEffect, useContext } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useGetStateMutation } from '../api';
import { setStateId, setIsUserAuthorized } from './accountSlice';
import { EchoContext } from '@/entities/echo/echoContext';

function useAuth() {
    const dispatch = useDispatch();
    const { initChannel } = useContext(EchoContext);
    const { stateId, isUserAuthorized } = useSelector((state) => state.account);
    const { widgetOption } = useSelector((state) => state.option);

    const [getState] = useGetStateMutation();

    const setStoreStateId = useCallback((token) => {
        if (token) {
            localStorage.setItem('stateId', token);
        } else {
            localStorage.removeItem('stateId');
        }
    }, []);

    const getStateId = useCallback(async () => {
        const { data } = await getState({
            amount: widgetOption?.amount,
            currency: widgetOption?.currency,
            purpose: widgetOption?.purpose,
            apiKey: widgetOption?.apiKey,
            account: widgetOption?.account,
        });

        const { state_id } = data;

        if (state_id) {
            initChannel(state_id);

            setStoreStateId(state_id);
            dispatch(setStateId(state_id));
            dispatch(setIsUserAuthorized(true));
        }
    }, [dispatch, getState, initChannel, setStoreStateId, widgetOption]);

    useEffect(() => {
        if (stateId) {
            dispatch(setIsUserAuthorized(true));
            return;
        }
    }, [stateId, dispatch]);

    useEffect(() => {
        setStoreStateId(stateId);
    }, [stateId, setStoreStateId]);

    return {
        stateId,
        isUserAuthorized,
        getStateId,
    };
}

export { useAuth };
