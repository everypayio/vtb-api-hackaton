import api from '@/shared/api';
import { apiEndpoints } from '@/shared/const/apiEndpoins';

export const driversApi = api.injectEndpoints({
    endpoints: (builder) => ({
        getDrivers: builder.query({
            query: () => ({
                url: apiEndpoints.drivers.getList(),
            }),
            transformResponse(baseQueryReturnValue) {
                return baseQueryReturnValue.body;
            },
        }),
    }),
});

export const { useGetDriversQuery } = driversApi;
