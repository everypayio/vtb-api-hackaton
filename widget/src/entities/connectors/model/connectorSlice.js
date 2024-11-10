import { createSlice } from '@reduxjs/toolkit';
import { connectorsApi } from '../api';

export const connectorsSlice = createSlice({
    name: 'connectors',
    initialState: {
        connectorsList: null,
        currentConnectorData: null,
        connectorId: null,
        connectorPayment: null,
    },
    reducers: {
        setList: (state, { payload }) => {
            state.connectorsList = payload;
        },
        setConnectorAccount: (state, { payload }) => {
            state.currentConnectorData = payload;
        },
        setConnectorId: (state, { payload }) => {
            state.connectorId = payload;
        },
        setConnectorPayment: (state, { payload }) => {
            state.connectorPayment = payload;
        },
    },
    extraReducers: (builder) => {
        builder.addMatcher(connectorsApi.endpoints.getConnectors.matchFulfilled, (state, { payload }) => {
            connectorsSlice.caseReducers.setList(state, {
                payload: payload,
            });
        });
        builder.addMatcher(connectorsApi.endpoints.getConnectordById.matchFulfilled, (state, { payload }) => {
            connectorsSlice.caseReducers.setConnectorAccount(state, {
                payload: payload,
            });
        });
        builder.addMatcher(connectorsApi.endpoints.getConnectors.matchFulfilled, (state, { payload }) => {
            connectorsSlice.caseReducers.setList(state, {
                payload: payload,
            });
        });
        builder.addMatcher(connectorsApi.endpoints.createPayment.matchFulfilled, (state, { payload }) => {
            connectorsSlice.caseReducers.setConnectorPayment(state, {
                payload: payload,
            });
        });
    },
});

export const { setList, setConnectorAccount, setConnectorId, setConnectorPayment } = connectorsSlice.actions;
export const { reducer: connectorsReducer } = connectorsSlice;
