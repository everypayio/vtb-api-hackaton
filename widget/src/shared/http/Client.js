import { Response as MyResponse } from './Response';
import { RequestTransformerFactory, ResponseTransformerFactory } from './transformers';

class Client {
    #baseHeaders;
    #baseRequestFormat;
    #baseResponseFormat;

    constructor({ baseHeaders = {}, baseRequestFormat = 'json', baseResponseFormat = 'json' } = {}) {
        this.#baseHeaders = baseHeaders;
        this.#baseRequestFormat = baseRequestFormat;
        this.#baseResponseFormat = baseResponseFormat;
    }

    setBaseHeader(key, value) {
        this.#baseHeaders[key] = value;
    }

    removeBaseHeader(key) {
        delete this.#baseHeaders[key];
    }

    async sendRequest(url, options = {}) {
        const requestFormat = options.requestFormat || this.#baseRequestFormat;

        if (requestFormat) {
            options = RequestTransformerFactory.make(requestFormat).transform(options);
        }

        const { method = 'get', query = null, body = null } = options;
        let { responseFormat, headers = {}, fetchOptions = {} } = options;

        if (query) {
            const queryString = new URLSearchParams(query).toString();

            url += `?${queryString}`;
        }

        responseFormat = responseFormat || this.#baseResponseFormat;
        headers = { ...this.#baseHeaders, ...headers, Accept: 'application/json' };
        fetchOptions = { method, headers, body, ...fetchOptions };

        const rawResponse = await fetch(url, fetchOptions);
        const response = new MyResponse(rawResponse);

        if (responseFormat) {
            try {
                response.body = await ResponseTransformerFactory.make(responseFormat).transform(rawResponse);
            } catch (error) {
                // todo: write error hanlder
            }
        }

        return response;
    }

    post(url, options = {}) {
        return this.sendRequest(url, {
            method: 'post',
            ...options,
        });
    }

    get(url, options = {}) {
        return this.sendRequest(url, {
            method: 'get',
            ...options,
        });
    }

    put(url, options = {}) {
        return this.sendRequest(url, {
            method: 'put',
            ...options,
        });
    }

    patch(url, options = {}) {
        return this.sendRequest(url, {
            method: 'patch',
            ...options,
        });
    }

    delete(url, options = {}) {
        return this.sendRequest(url, {
            method: 'delete',
            ...options,
        });
    }
}

export { Client };
