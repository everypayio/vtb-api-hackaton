// vite.config.js
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';
import cssInjectedByJsPlugin from 'vite-plugin-css-injected-by-js';

export default defineConfig({
    plugins: [react(), cssInjectedByJsPlugin()],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './src'),
            '@assets': path.resolve(__dirname, './src/assets'),
        },
    },
    server: {
        host: 'r2p.loc',
        port: 3000,
    },
    build: {
        rollupOptions: {
            output: {
                globals: {
                    react: 'React',
                    'react-dom': 'ReactDOM',
                },
                chunkFileNames: 'js/[name].js',
                entryFileNames: 'js/[name].js',
                assetFileNames: ({ name }) => {
                    if (/\.(gif|jpe?g|png|svg)$/.test(name ?? '')) {
                        return 'img/[name][extname]';
                    }

                    if (/\.css$/.test(name ?? '')) {
                        return 'css/[name][extname]';
                    }

                    if (/\.(woff|woff2)$/.test(name ?? '')) {
                        return 'fonts/[name][extname]';
                    }

                    return 'assets/[name][extname]';
                },
            },
        },
    },
});
