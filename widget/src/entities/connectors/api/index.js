import api from '@/shared/api';
import { apiEndpoints } from '@/shared/const/apiEndpoins';

export const connectorsApi = api.injectEndpoints({
    endpoints: (builder) => ({
        getConnectors: builder.query({
            query: () => ({
                url: apiEndpoints.connectors.getList(),
            }),
            transformResponse(baseQueryReturnValue) {
                return baseQueryReturnValue.body.connectors.items;
            },
        }),
        getConnectordById: builder.query({
            query: (id) => ({
                url: apiEndpoints.connectors.getById(id),
            }),
            transformResponse(baseQueryReturnValue) {
                return baseQueryReturnValue.body;
            },
        }),
        createPayment: builder.mutation({
            query: ({ id, body }) => ({
                url: apiEndpoints.connectors.createPayment(id),
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
    useGetConnectorsQuery,
    useLazyGetConnectorsQuery,
    useGetConnectordByIdQuery,
    useLazyGetConnectordByIdQuery,
    useCreatePaymentMutation,
} = connectorsApi;
