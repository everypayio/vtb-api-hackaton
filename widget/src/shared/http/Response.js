class Response {
    #nativeResponse;

    #statusCode;

    #statusText;

    #ok;

    #body = null;

    constructor(nativeResponse) {
        this.#nativeResponse = nativeResponse;
        this.#statusCode = nativeResponse.status;
        this.#statusText = nativeResponse.statusText;
        this.#ok = nativeResponse.ok;
    }

    get nativeResponse() {
        return this.#nativeResponse;
    }

    get statusCode() {
        return this.#statusCode;
    }

    get statusText() {
        return this.#statusText;
    }

    get ok() {
        return this.#ok;
    }

    get body() {
        return this.#body;
    }

    set body(body) {
        this.#body = body;
    }
}

export { Response };
