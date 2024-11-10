import { createSlice } from '@reduxjs/toolkit';

export const optionSlice = createSlice({
    name: 'option',
    initialState: {
        widgetOption: null,
    },
    reducers: {
        setWidgetOption: (state, { payload }) => {
            state.widgetOption = payload;
        },
    },
});

export const { setWidgetOption } = optionSlice.actions;
export const { reducer: optionReducer } = optionSlice;
