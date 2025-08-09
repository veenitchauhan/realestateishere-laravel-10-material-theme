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
});
