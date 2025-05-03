import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

createApp(App)
    .use(router)
    .mount('#app')

if (import.meta.env.VITE_APP_HOST) {
    window.__VITE_HMR_URL__ = `wss://${import.meta.env.VITE_APP_HOST}/`;
}

console.log('Vue initialized')