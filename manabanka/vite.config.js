import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    // Railway: /. Local XAMPP: set VITE_BASE=/dashboard/manabanka/ in .env before npm run build
    base: process.env.VITE_BASE || '/',
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
