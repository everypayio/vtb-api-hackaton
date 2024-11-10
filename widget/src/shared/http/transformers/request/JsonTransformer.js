class JsonTransformer {
    transform(options) {
        if (options.body) {
            options.body = JSON.stringify(options.body);

            options.headers = {
                ...(options.headers || {}),
                'content-type': 'application/json',
            };
        }

        return options;
    }
}

export { JsonTransformer };
