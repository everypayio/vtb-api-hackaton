import { configureStore } from '@reduxjs/toolkit';
import { accountReducer } from '@/features/account/model/accountSlice';
import { driversReducer } from '@/entities/driver/model/driversSlice';
import { connectorsReducer } from '@/entities/connectors/model/connectorSlice';
import { stepsReducer } from '@/widgets/stepper/model/stepsSlice';
import api from '@/shared/api';
import { optionReducer } from '@/entities/options/model/optionSlice';

const store = configureStore({
    reducer: {
        [api.reducerPath]: api.reducer,
        option: optionReducer,
        steps: stepsReducer,
        account: accountReducer,
        drivers: driversReducer,
        connectors: connectorsReducer,
    },
    middleware: (getDefaultMiddleware) => getDefaultMiddleware().concat(api.middleware),
});

export { store };
