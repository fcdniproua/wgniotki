import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import {defineConfig} from "vite";
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

export default defineConfig({
    server: {
        host: '0.0.0.0',  // Обов'язково для Docker
        port: 5173,       // Порт всередині контейнера
        strictPort: true, // Не шукати вільні порти
        hmr: {
            clientPort: 5173  // Порт для Hot Module Replacement
        }
    },
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    css: {
        postcss: {
            plugins: [
                tailwindcss,
                autoprefixer,
            ],
        },
    },
});