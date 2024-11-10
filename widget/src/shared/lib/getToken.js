function getTokenFromQuery(searchParams) {
    return {
        stateId: searchParams.get('access_token'),
    };
}

function getTokenFromStorage() {
    return {
        stateId: localStorage.getItem('stateId'),
    };
}

function getToken() {
    const searchParams = new URLSearchParams(window.location.search);
    const isTokenInQuery = searchParams.has('stateId');

    const isTokenInLocal = Boolean(localStorage.getItem('stateId'));

    if (isTokenInQuery) {
        return getTokenFromQuery(searchParams);
    } else if (isTokenInLocal) {
        return getTokenFromStorage();
    }

    return {
        stateId: null,
    };
}

export { getTokenFromQuery, getTokenFromStorage, getToken };
