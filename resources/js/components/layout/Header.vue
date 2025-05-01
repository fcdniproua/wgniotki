<template>
    <header class="header">
        <div class="header-container">
            <router-link to="/" class="logo">
                <logo></logo>
            </router-link>

            <nav class="main-nav">
                <ul class="nav-list">
                    <li><router-link class="menu-next bold" to="/">GLÓWNA</router-link></li>
                    <li><router-link class="menu-next bold" to="/services">USLUGI</router-link></li>
                    <li><router-link class="menu-next bold" to="/about">O NAS</router-link></li>
                    <li><router-link class="menu-next bold" to="/contact">KONTAKT</router-link></li>
                    <li v-if="isAuthenticated">
                        <router-link class="menu-next" to="/admin/dashboard">DASHBOARD</router-link>
                    </li>
                </ul>
            </nav>

            <div class="contact-item">
                <div class="contact-phone">
                    <div class="icon-wrapper">
                        <IconPhoneCall class="contact-icon" />
                    </div>
                    <p class="contact-text">
                        <button class="hero-button-1 " @click="$emit('open-contact-modal');">
                            <a :href="'tel:' + contactData.contactPhone" class="contact-link semibold">{{contactData.contactPhone}}</a>
                        </button>
                    </p>
                </div>
            </div>

            <!-- Десктопна версія кнопки -->
            <button
                v-if="!isMobile && !isAuthenticated"
                @click="showLoginModal = true"
                class="auth-btn login"
            >
                Admin
            </button>

            <button class="burger-btn" @click="toggleMenu">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </button>

            <transition name="slide">
                <nav class="mobile-menu" v-if="isMenuOpen">
                    <router-link to="/" class="mobile-logo">
                        <logo></logo>
                    </router-link>
                    <ul>
                        <li><router-link class="menu-next" to="/" @click="closeMenu">GLÓWNA</router-link></li>
                        <li><router-link class="menu-next" to="/services" @click="closeMenu">USLUGI</router-link></li>
                        <li><router-link class="menu-next" to="/about" @click="closeMenu">O NAS</router-link></li>
                        <li><router-link class="menu-next" to="/contact">KONTAKT</router-link></li>
                        <li v-if="isAuthenticated">
                            <router-link class="menu-next" to="/admin/dashboard" @click="closeMenu">DASHBOARD</router-link>
                        </li>
                        <!-- Мобільна версія кнопки -->
                        <li v-if="!isAuthenticated">
                            <button @click="openLogin" class="auth-btn login mobile">
                                Admin
                            </button>
                        </li>
                    </ul>
                </nav>
            </transition>
        </div>

        <!-- Модальне вікно логіну -->
        <AdminLoginModal
            :isVisible="showLoginModal"
            @close="showLoginModal = false"
            @login-success="handleLoginSuccess"
            style="z-index: 9999;"
        />
    </header>
</template>

<script>
import {ref, onMounted, inject} from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import AdminLoginModal from '../admin/AdminLoginModal.vue';
import IconPhoneCall from '../icon/IconPhoneCall.vue';
import Logo from "../icon/Logo.vue";

export default {
    components: {
        Logo,
        IconPhoneCall,
        AdminLoginModal
    },
    setup() {
        const router = useRouter();
        const showLoginModal = ref(false);
        const isMenuOpen = ref(false);
        const isMobile = ref(false);
        const isAuthenticated = ref(false);
        const adminName = ref('');
        const intendedRoute = ref(null);
        const contactData = inject('contactData')
        const checkAuth = async () => {
            try {
                const { data } = await axios.get('/admin/check-auth');
                return data.authenticated;
            } catch {
                return false;
            }
        };

        // Глобальний перехоплювач маршрутів
        router.beforeEach(async (to) => {
            if (to.meta.requiresAdmin) {
                const isAuth = await checkAuth();
                if (!isAuth) {
                    intendedRoute.value = to.fullPath;
                    showLoginModal.value = true;
                    return false; // Блокуємо навігацію
                }
            }
        });

        // Обробка успішного логіну

        const checkAuthStatus = async () => {
            try {
                const response = await axios.get('/admin/check-auth', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.data && typeof response.data === 'object') {
                    isAuthenticated.value = response.data.authenticated || false;
                    if (isAuthenticated.value) {
                        await fetchAdminData();
                    }
                }
            } catch (error) {
                console.error('Помилка перевірки авторизації:', error);
                isAuthenticated.value = false;
            }
        };

        const fetchAdminData = async () => {
            try {
                const response = await axios.get('/admin/user', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.data && response.data.name) {
                    adminName.value = response.data.name;
                }
            } catch (error) {
                console.error('Failed to fetch admin data:', error);
                adminName.value = '';
            }
        };

        const checkScreenSize = () => {
            isMobile.value = window.innerWidth <= 992;
        };

        const toggleMenu = () => {
            isMenuOpen.value = !isMenuOpen.value;
            document.body.style.overflow = isMenuOpen.value ? 'hidden' : '';
        };

        const openLogin = () => {
            showLoginModal.value = true;
            isMenuOpen.value = false;
        };

        const handleLoginSuccess = async () => {
            showLoginModal.value = false;
            await checkAuthStatus();
            if (intendedRoute.value) {
                await router.push(intendedRoute.value);
                intendedRoute.value = null;
            } else {
                await router.push('/admin/dashboard');
            }
        };

        const closeMenu = () => {
            isMenuOpen.value = false;
            document.body.style.overflow = '';
        };

        const logout = async () => {
            try {
                await axios.post('/admin/logout');
                isAuthenticated.value = false;
                adminName.value = '';
                router.push('/');
            } catch (error) {
                console.error('Logout error:', error);
            }
        };

        onMounted(() => {
            checkScreenSize();
            checkAuthStatus();
            window.addEventListener('resize', checkScreenSize);
        });

        return {
            IconPhoneCall,
            contactData,
            showLoginModal,
            isMenuOpen,
            isMobile,
            isAuthenticated,
            adminName,
            toggleMenu,
            openLogin,
            handleLoginSuccess,
            logout,
            closeMenu
        };
    }
};
</script>


<style scoped>
.header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    background: #1A1A1A;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    height: 130px;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    height: 100%;
}

.logo {

    font-size: 28px;
    font-weight: 700;
    color: #ffffff;
    text-decoration: none;
    width: 125px;
    position: fixed;
    top: 0;
}

/* Десктопне меню */
.main-nav {
    display: flex;
    flex-grow: 1;
    justify-content: center;
}

.nav-list {
    display: flex;
    gap: 35px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.menu-first {
    color: #bf7f56;
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
    transition: color 0.3s;
}

.menu-next {
    color: #ffffff;
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
    transition: color 0.3s;
}

.menu-first:hover, .menu-next:hover {
    color: #FF6700;
}

/* Мобільне меню */
.burger-btn {
    display: none;
    background: none;
    border: none;
    cursor: pointer;
    padding: 35px;
    z-index: 1001;
}

.burger-line {
    display: block;
    width: 25px;
    height: 2px;
    background: #fff;
    margin: 5px 0;
    transition: all 0.3s ease;
}

.mobile-menu {
    position: fixed;
    top: 130px;
    left: 0;
    width: 100%;
    height: calc(100vh - 130px);
    background: #1A1A1A;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow-y: auto;
}

.mobile-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
    width: 100%;
}

.mobile-menu li {
    margin: 20px 0;
}

.mobile-menu .menu-first, .mobile-menu .menu-next {
    text-decoration: none;
    font-size: 18px;
    font-weight: 500;
    display: block;
    padding: 10px;
}

.mobile-menu .menu-first:hover, .mobile-menu .menu-next:hover {
    color: #FF6700;
}

/* Анімації */
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.4s ease;
}

.slide-enter-from,
.slide-leave-to {
    transform: translateX(-100%);
}

/* Адаптація */
@media (max-width: 992px) {
    .main-nav,
    .header-icons {
        display: none;
    }

    .burger-btn {
        display: block;
    }

    .header-container {
        padding: 0 15px;
    }

    .button-40 {
        padding: 5px 6px !important;
        margin-right: 0px !important;
        margin-left: 30px !important;
        text-align: center;
        display: none!important;
    }
}

/* Анімація бургер-кнопки */
.burger-btn.active .burger-line:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
}

.burger-btn.active .burger-line:nth-child(2) {
    opacity: 0;
}

.burger-btn.active .burger-line:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
}

.button-40 {
    position: relative;
    display: inline-block;
    padding: 15px 30px;
    margin: 40px 0;
    color: #FF6700;
    text-decoration: none;
    text-transform: uppercase;
    transition: 0.5s;
    letter-spacing: 4px;
    overflow: hidden;
    margin-right: 50px;
    cursor: pointer;
}
.button-40:hover {
    background: #FF6700;
    color: #050801;
    box-shadow: 0 0 5px #FF6700, 0 0 25px #FF6700, 0 0 50px #FF6700,
    0 0 200px #FF6700;
    -webkit-box-reflect: below 1px linear-gradient(transparent, #0005);
}
.button-40:nth-child(1) {
    filter: hue-rotate(270deg);
}
.button-40:nth-child(2) {
    filter: hue-rotate(110deg);
}
.button-40 span {
    position: absolute;
    display: block;
}
.button-40 span:nth-child(1) {
    top: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, transparent, #FF6700);
    animation: animate1 2s linear infinite;
}
@keyframes animate1 {
    0% {
        left: -100%;
    }
    50%,
    100% {
        left: 100%;
    }
}
.button-40 span:nth-child(2) {
    top: -100%;
    right: 0;
    width: 2px;
    height: 100%;
    background: linear-gradient(180deg, transparent, #FF6700);
    animation: animate2 2s linear infinite;
    animation-delay: 0.5s;
}
@keyframes animate2 {
    0% {
        top: -100%;
    }
    50%,
    100% {
        top: 100%;
    }
}
.button-40 span:nth-child(3) {
    bottom: 0;
    right: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(270deg, transparent, #FF6700);
    animation: animate3 2s linear infinite;
    animation-delay: 1s;
}
@keyframes animate3 {
    0% {
        right: -100%;
    }
    50%,
    100% {
        right: 100%;
    }
}

.button-40 span:nth-child(4) {
    bottom: -100%;
    left: 0;
    width: 2px;
    height: 100%;
    background: linear-gradient(360deg, transparent, #FF6700);
    animation: animate4 2s linear infinite;
    animation-delay: 1.5s;
}
@keyframes animate4 {
    0% {
        bottom: -100%;
    }
    50%,
    100% {
        bottom: 100%;
    }
}

.contact-item {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
}

.contact-phone {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
}

.contact-text {
    margin: 0 10px;
    text-wrap: nowrap;
}

.icon-wrapper {
    padding-top: 10px;
    padding-left: 10px;
}

.contact-link {
    color: inherit;
    text-decoration: none;
}

.admin-login-btn {
    padding: 8px 16px;
    background: #1A1A1A;
    color: white;
    border: none;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
    margin-left: 15px;
}

.admin-login-btn:hover {
    background: #1A1A1A;
    transform: translateY(-2px);
}

.hero-button-1 {
    display: inline-block;
    background-color: transparent;
    color: #FF6700; /* світліший жовтий */
    border: 2px solid #FF6700;
    font-weight: 700;
    font-size: 16px;
    padding: 12px 28px;
    border-radius: 30px;
    text-transform: uppercase;
    transition: all 0.3s ease;
    cursor: pointer;
}

.hero-button-1:hover {
    background-color: #FF6700;
    color: #1a1a1a;
}

/* Десктопна версія */
.desktop-login-btn {
    display: block;
}

.mobile-login-btn {
    display: none;
}

/* Адаптація для мобільних */
@media (max-width: 992px) {
    .desktop-login-btn {
        display: none;
    }

    .mobile-login-btn {
        display: block;
        margin-top: 20px;
    }

    .mobile-login-btn .admin-login-btn {
        width: 100%;
        padding: 12px;
        font-size: 16px;
    }
}

.admin-login-btn {
    padding: 8px 16px;
    background: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}

.admin-logout-btn {
    padding: 8px 16px;
    background: #f44336;
    color: white;
    border: none;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}

.admin-login-btn:hover,
.admin-logout-btn:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}
.mobile-logo {
    display: none;
}

.auth-btn {
    padding: 8px 16px;
    background: #1a1a1a;
    color: white;
    border: none;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}


/* Адаптація для мобільних */
@media (max-width: 992px) {
    .mobile-login-btn button {
        width: 100%;
        padding: 12px;
        font-size: 16px;
    }
    .mobile-logo {
        display: block;
        width: 180px;
        position: absolute;
        top: 0;
        z-index: 2;
        left: 24%;
    }
    .logo {
        display:none;

    }
}
</style>