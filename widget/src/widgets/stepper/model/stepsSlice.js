import { createSlice } from '@reduxjs/toolkit';

export const stepsSlice = createSlice({
    name: 'steps',
    initialState: {
        currentStep: 0,
        steps: [
            { id: 0, component: 'Auth' },
            { id: 1, component: 'Banks' },
            { id: 2, component: 'Payment' },
            { id: 3, component: 'Success' },
        ],
    },
    reducers: {
        firstStep: state => {
            state.currentStep = 0;
        },
        nextStep: (state) => {
            state.currentStep = Math.min(state.currentStep + 1, state.steps.length - 1);
        },
        prevStep: (state) => {
            state.currentStep = Math.max(state.currentStep - 1, 0);
        },
    },
});

export const { firstStep, nextStep, prevStep } = stepsSlice.actions;
export const { reducer: stepsReducer } = stepsSlice;
