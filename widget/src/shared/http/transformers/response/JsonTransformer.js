class JsonTransformer {
    async transform(response) {
        return response.json();
    }
}

export { JsonTransformer };
