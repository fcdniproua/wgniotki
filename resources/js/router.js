import { createRouter, createWebHistory } from 'vue-router'
import HomePage from './components/pages/HomePage.vue';
import AboutPage from './components/pages/AboutPage.vue';
import ServicesPage from "./components/pages/ServicesPage.vue";
import AdminLoginModal from "./components/admin/AdminLoginModal.vue";
import Dashboard from "./components/auth/Dashboard.vue";
import ServicesComponent from "./components/admin/ServicesComponent.vue";
import ApplicationsComponent from "./components/admin/ApplicationsComponent.vue";
import WorksComponent from "./components/admin/WorksComponent.vue";
import SettingsComponent from "./components/admin/SettingsComponent.vue";
import ClientComponent from "./components/admin/ClientComponent.vue";

const routes = [
    { path: '/', name: 'Home', component: HomePage },
    { path: '/about', name: 'About', component: AboutPage },
    { path: '/services', name: 'Services', component: ServicesPage },
    { path: '/admin/login', name: 'AdminLogin', component: AdminLoginModal },
    {
        path: '/admin/dashboard',
        component: Dashboard,
        meta: { requiresAdmin: true }
    },
    {
        path: '/admin/services',
        component: ServicesComponent,
        meta: { requiresAdmin: true }
    },
    {
        path: '/admin/applications',
        component: ApplicationsComponent,
        meta: { requiresAdmin: true }
    },
    {
        path: '/admin/works',
        component: WorksComponent,
        meta: { requiresAdmin: true }
    },
    {
        path: '/admin/settings',
        component: SettingsComponent,
        meta: { requiresAdmin: true }
    },
    {
        path: '/admin/clients',
        component: ClientComponent,
        meta: { requiresAdmin: true }
    },

    // { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound } // Кращий спосіб для 404
]

const router = createRouter({
    history: createWebHistory('/'),
    routes,
    // scrollBehavior(to, from, savedPosition) {
    //
    //     return {
    //         top: 0,
    //         behavior: 'smooth'
    //     }
    // }
})

router.afterEach(() => {
    setTimeout(() => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth' // Плавна анімація
        });
    }, 100); // Невелика затримка для стабільності
});

router.beforeEach(async (to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
    const isAdminRoute = to.path.startsWith('/admin')

    if (requiresAuth && isAdminRoute) {
        try {
            // Перевіряємо автентифікацію через API
            const response = await axios.get('/admin/check-auth', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('adminToken')}`
                }
            })

            if (response.data.authenticated) {
                next()
            } else {
                // Якщо токен не валідний - очищаємо і перенаправляємо
                localStorage.removeItem('adminToken')
                localStorage.removeItem('adminAuth')
                next('/admin/login')
            }
        } catch (error) {
            // Обробка помилок мережі або сервера
            localStorage.removeItem('adminToken')
            localStorage.removeItem('adminAuth')
            next('/admin/login')
        }
    }
    else if (to.path === '/admin/login' && localStorage.getItem('adminToken')) {
        // Якщо користувач вже авторизований, але намагається увійти знову
        next('/admin/dashboard')
    }
    else {
        next()
    }
})

export default router