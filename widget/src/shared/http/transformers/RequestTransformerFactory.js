import { TransformerFactory } from './TransformerFactory';

class RequestTransformerFactory {
    static make(schema) {
        return TransformerFactory.make('request', schema);
    }
}

export { RequestTransformerFactory };
