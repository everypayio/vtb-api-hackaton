import api from '@/shared/api';
import { apiEndpoints } from '@/shared/const/apiEndpoins';

export const accountApi = api.injectEndpoints({
    endpoints: (builder) => ({
        login: builder.query({
            query: (stateId) => ({
                url: apiEndpoints.accounts.login(stateId),
            }),
            transformResponse(baseQueryReturnValue) {
                return baseQueryReturnValue.body;
            },
        }),
        getState: builder.mutation({
            query: (body) => ({
                url: apiEndpoints.accounts.getState(),
                method: 'post',
                body,
            }),
            transformResponse(baseQueryReturnValue) {
                return baseQueryReturnValue.body;
            },
        }),
    }),
});

export const {
    useLazyLoginQuery,
    useGetStateMutation,
    useLazyGetStateQuery,
} = accountApi;
