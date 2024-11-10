import { createSlice } from '@reduxjs/toolkit';
import { driversApi } from '../api';

export const driversSlice = createSlice({
    name: 'drivers',
    initialState: {
        driversList: null,
    },
    reducers: {
        setDrivers: (state, { payload }) => {
            state.driversList = payload;
        },
    },
    extraReducers: (builder) => {
        builder.addMatcher(driversApi.endpoints.getDrivers.matchFulfilled, (state, { payload }) => {
            driversSlice.caseReducers.setDrivers(state, {
                payload: payload,
            });
        });
    },
});

export const { setDrivers } = driversSlice.actions;
export const { reducer: driversReducer } = driversSlice;
