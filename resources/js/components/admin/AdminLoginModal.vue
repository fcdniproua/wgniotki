<template>
    <transition name="fade">
        <div v-if="isVisible" class="modal-overlay" @click.self="close">
            <div class="modal-container">
                <div class="modal-header">
                    <h2 class="modal-title bold">Admin</h2>
                    <button class="modal-close-btn" @click="close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <div class="modal-body">
                    <form @submit.prevent="handleSubmit" class="login-form">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input
                                id="email"
                                v-model="email"
                                type="email"
                                class="form-input"
                                placeholder="admin@example.com"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input
                                id="password"
                                v-model="password"
                                type="password"
                                class="form-input"
                                placeholder="••••••••"
                                required
                            >
                        </div>

                        <div v-if="error" class="error-message">
                            {{ error }}
                        </div>

                        <button type="submit" class="submit-btn" :disabled="loading">
                            <span v-if="!loading">Login</span>
                            <span v-else class="loading-spinner"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
    props: ['isVisible'],
    emits: ['close', 'login-success'],
    setup(props, { emit }) {
        const email = ref('admin@example.com');
        const password = ref('password123');
        const error = ref('');
        const loading = ref(false);

        const close = () => {
            error.value = '';
            emit('close');
        };

        const handleSubmit = async () => {
            loading.value = true;
            error.value = '';

            try {
                await axios.get('/sanctum/csrf-cookie');
                await axios.post('/admin/login', {
                    email: email.value,
                    password: password.value
                });
                window.location.href = 'https://usuwanie-wgniecen.pro/admin/dashboard'
                emit('login-success');
            } catch (err) {
                error.value = err.response?.data?.message || 'Login failed';
            } finally {
                loading.value = false;
            }
        };

        return {
            email,
            password,
            error,
            loading,
            close,
            handleSubmit
        };
    }
};
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-container {
    background-color: white;
    border-radius: 8px;
    width: 100%;
    max-width: 400px;
    z-index: 10000;
}

.modal-header {
    padding: 20px;
    background-color: #1A1A1A;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
}

.modal-close-btn {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-body {
    padding: 25px;
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #4a5568;
}

.form-input {
    padding: 10px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
}

.error-message {
    color: #e53e3e;
    font-size: 0.875rem;
    text-align: center;
    margin-top: -10px;
}

.submit-btn {
    padding: 12px;
    background-color: #1A1A1A;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 44px;
}

.submit-btn:hover {
    background-color: #1a252f;
}

.submit-btn:disabled {
    background-color: #cbd5e0;
    cursor: not-allowed;
}

.loading-spinner {
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>