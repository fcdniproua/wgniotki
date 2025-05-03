import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import { defineConfig } from 'vite'

export default defineConfig({
    base: 'https://usuwanie-wgniecen.pro/build/assets/',
    build: {
        manifest: 'manifest.json',
        outDir: 'public/build',
        rollupOptions: {
            input: 'resources/js/app.js',
        },
        emptyOutDir: true,
    },
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css'], // додай CSS
            refresh: true,
        }),
        vue(),
    ],
})



// import laravel from "laravel-vite-plugin";
// import vue from "@vitejs/plugin-vue";
// import {defineConfig} from "vite";
// import tailwindcss from 'tailwindcss';
// import autoprefixer from 'autoprefixer';
//
// export default defineConfig({
//     base: '/build/', // базовий префікс для ресурсів у продакшн-збірці
//
//     build: {
//         manifest: true,
//         outDir: 'public/build',
//         rollupOptions: {
//             input: 'resources/js/app.js'
//         }
//     },
//
//     server: {
//         host: '0.0.0.0',  // Обов'язково для Docker
//         port: 5173,       // Порт всередині контейнера
//         strictPort: true, // Не шукати вільні порти
//         cors: {
//             origin: ['http://192.168.233.172:8080','http://127.0.0.1:8080'], // або '*', але не бажано для продакшну
//             methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
//         },
//         hmr: {
//             // host: '127.0.0.1',
//             host: '192.168.233.172',
//             clientPort: 5173  // Порт для Hot Module Replacement
//         }
//     },
//     plugins: [
//         laravel({
//             input: ['resources/js/app.js'],
//             refresh: true,
//         }),
//         vue(),
//     ],
//     resolve: {
//         alias: {
//             '@': '/resources/js',
//         },
//     },
//     css: {
//         postcss: {
//             plugins: [
//                 tailwindcss,
//                 autoprefixer,
//             ],
//         },
//     },
// });