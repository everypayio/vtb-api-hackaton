import { firstStep } from '@/widgets/stepper/model/stepsSlice.js';
import { Client } from '../http/Client';

const client = new Client();

const _baseQuery = async ({ url, ...options }, getState) => {
    const stateId = getState().account.stateId;

    if (stateId) {
        client.setBaseHeader('X-State-Id', stateId);
    }

    const response = await client.sendRequest(url, options);

    const data = {
        body: response.body,
        ok: response.ok,
        statusCode: response.statusCode,
        statusText: response.statusText,
    };

    return data;
};

export const baseQuery = async ({ url, ...options }, { getState, dispatch }) => {
    const data = await _baseQuery({ url, ...options }, getState);

    if (data.ok) {
        return {
            data,
        };
    }

    if ([401, 403].includes(data.statusCode)) {
        // TODO САНЯ ПРОСТИ ПОЖАЛУЙСТА ВРЕМЯ 0:09 ТАК НАДО
        localStorage.removeItem('stateId');
        dispatch(firstStep());
    }

    return {
        error: {
            response: data,
        },
    };
};
