const BASE_URL = import.meta.env.VITE_BASE_URL;
const AUTH_URL = `${BASE_URL}/oauth/authorize`;

const BASE_API_URL = `${BASE_URL}/api`;
const BASE_DRIVERS_URL = `${BASE_API_URL}/drivers`;
const BASE_CONNECTORS_URL = `${BASE_API_URL}/connectors`;
const DRIVERS_URL = `${BASE_URL}/drivers`;

const apiEndpoints = {
    accounts: {
        login: (stateId) => `${AUTH_URL}?state=${stateId}`,
        getState: () => `${BASE_API_URL}/state`,
    },

    drivers: {
        getList: () => `${BASE_DRIVERS_URL}`,
        prepareStateNotApi: (driver, stateId) => `${DRIVERS_URL}/${driver}/authorize?state=${stateId}`,
    },

    connectors: {
        getList: () => BASE_CONNECTORS_URL,
        getById: (id) => `${BASE_CONNECTORS_URL}/${id}/accounts`,
        createPayment: (id) => `${BASE_CONNECTORS_URL}/${id}/payments`,
    },
};

export { apiEndpoints };
