import { createSlice } from '@reduxjs/toolkit';
import { getToken } from '@/shared/lib/getToken';
import { accountApi } from '../api';

const initialState = {
    isUserAuthorized: false,
    payeeData: null,
    ...getToken(),
};

export const accountSlice = createSlice({
    name: 'account',
    initialState,
    reducers: {
        setStateId: (state, { payload }) => {
            state.stateId = payload;
        },
        setIsUserAuthorized: (state, { payload }) => {
            state.isUserAuthorized = payload;
        },
        setPayeeData: (state, { payload }) => {
            state.payeeData = payload;
        },
    },
    extraReducers: (builder) => {
        builder.addMatcher(accountApi.endpoints.getState.matchFulfilled, (state, { payload }) => {
            accountSlice.caseReducers.setPayeeData(state, {
                payload: payload.payeeData,
            });
        });
    },
});

export const { setStateId, setIsUserAuthorized, setPayeeData } = accountSlice.actions;
export const { reducer: accountReducer } = accountSlice;
