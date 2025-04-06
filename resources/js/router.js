import { createRouter, createWebHistory } from 'vue-router'
import HomePage from './components/pages/Home.vue';
import AboutPage from './components/pages/About.vue';

const routes = [
    { path: '/',name: 'Home', component: HomePage },
    { path: '/about', name: 'About', component: AboutPage }
]

export default createRouter({
    history: createWebHistory(),
    routes
})