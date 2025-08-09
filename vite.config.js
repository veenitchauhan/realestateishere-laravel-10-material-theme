import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/properties/common.js',
                'resources/js/properties/create.js', 
                'resources/js/properties/edit.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        cors: {
            origin: ['http://realestateishere.local', 'http://localhost', 'http://127.0.0.1:8000'],
            credentials: true
        }
    }
});
