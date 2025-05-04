<template>
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="bold">Panel Administracyjny</h1>
            <div class="admin-actions">
                <button class="logout-btn" @click="logout">
                    <i class="fas fa-sign-out-alt"></i> Wyloguj
                </button>
            </div>
        </div>

        <div class="menu-grid">
            <MenuCard
                v-for="item in menuItems"
                :key="item.title"
                :title="item.title"
                :icon="item.icon"
                :color="item.color"
                :route="item.route"
            />
        </div>
    </div>
</template>

<script setup>
import MenuCard from './MenuCard.vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const menuItems = [
    { title: 'Usługi', icon: 'fa-clipboard-list', color: 'bg-blue-500', route: '/admin/services' },
    { title: 'Galeria prac', icon: 'fa-box-open', color: 'bg-green-500', route: '/admin/works' },
    { title: 'Aplikacje', icon: 'fa-users', color: 'bg-yellow-500', route: '/admin/applications' },
    { title: 'Clients', icon: 'fa-users', color: 'bg-gray-500', route: '/admin/clients' },
    { title: 'Ustawienia', icon: 'fa-cog', color: 'bg-gray-500', route: '/admin/settings' },
];

const logout = async () => {
    try {
        await axios.post('/admin/logout');
        router.push('/admin/login');
    } catch (error) {
        console.error('Błąd podczas wylogowywania:', error);
    }
};
</script>

<style scoped>


.admin-layout {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background: #f8fafc;
}

.admin-main {
    flex: 1;
    max-width: 1400px;
    width: 90%;
    margin: 0 auto;
    padding: 2rem 0;
}


.admin-container {
    min-height: 100vh;
    background: #f5f7fa;
    padding: 7rem 1rem
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.admin-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2d3748;
}

.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 4.5rem;
}

.logout-btn {
    background: #e53e3e;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.logout-btn:hover {
    background: #c53030;
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .menu-grid {
        grid-template-columns: 1fr;
    }
}
</style>