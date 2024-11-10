import { JsonTransformer as RequestJsonTransformer } from './request';
import { JsonTransformer as ResponseJsonTransformer } from './response';

class TransformerFactory {
    static #requestTransformers = new Map([['json', RequestJsonTransformer]]);

    static #responseTransformers = new Map([['json', ResponseJsonTransformer]]);

    static #invalidTransformerGuard(section, schema) {
        throw new Error(`Invalid schema "${schema}" for "${section}"`);
    }

    static getTransformer(section, schema) {
        const transformers = section === 'request' ? this.#requestTransformers : this.#responseTransformers;

        const transformer = transformers.get(schema);

        if (!transformer) {
            this.#invalidTransformerGuard(section, schema);
        }

        return transformer;
    }

    static make(section, schema) {
        const Transformer = this.getTransformer(section, schema);

        return new Transformer();
    }
}

export { TransformerFactory };
