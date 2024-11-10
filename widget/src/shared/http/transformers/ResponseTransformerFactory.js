import { TransformerFactory } from './TransformerFactory';

class ResponseTransformerFactory {
    static make(schema) {
        return TransformerFactory.make('response', schema);
    }
}

export { ResponseTransformerFactory };
