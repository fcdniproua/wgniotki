<template>
    <div class="app-container">
        <Header class="app-header" />
        <main class="app-main">
            <router-view/>
        </main>
        <Footer class="app-footer" />
    </div>
</template>

<script>
import Header from './components/layout/Header.vue';
import Footer from './components/layout/Footer.vue';
import ContactModal from './components/home/sections/ContactModal.vue';
import {onMounted, ref} from "vue";

import { provide } from 'vue';

export default {
    name: 'AppLayout',
    components: {
        Header,
        Footer,
        ContactModal
    },
    setup() {

        const form = ref({
            contactEmail: '',
            contactPhone: '',
            address: '',
            openingHours: {},
            mapEmbed: ''
        });

        provide('contactData', form);

        const fetchSettings = async () => {
            try {
                const response = await fetch('/get-contact');
                const data = await response.json();

                if (data.data) {
                    form.value = {
                        contactEmail: data.data.email,
                        contactPhone: data.data.phone,
                        address: data.data.address,
                        openingHours: data.data.opening_hours,
                        mapEmbed: data.data.map_embed
                    };

                }
            } catch (error) {
                console.error('Error fetching settings:', error);
            }
        };

        onMounted(() => {
            fetchSettings();
        });

        return [
            form,
        ];
    }
}
</script>

<style>
html, body {
    font-family: 'Roboto', sans-serif;
    height: 100%;
    margin: 0;
    padding: 0;
}

.app-container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.app-header {
    height: 70px; /* Висота вашого хедера */
}

.app-main {
    flex: 1;
    padding: 20px 0; /* Додаткові відступи */
}

.app-footer {
    height: 100%; /* Висота вашого футера */
}

body.modal-open {
    overflow: hidden;
    position: fixed;
    width: 100%;
}

/* Заборонити скролл при відкритій модалці */
body.modal-open {
    overflow: hidden;
}

/* Główne style admina */
.admin-section {
    background: white;
    border-radius: 8px;
    padding: 10px 50px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

h2 {
    color: #1A1A1A;
    margin-bottom: 20px;
    font-size: 1.5rem;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: #4a5568;
}

.form-input {
    width: 90%;
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

textarea.form-input {
    min-height: 100px;
    resize: vertical;
}

/* Przyciski */
.add-btn, .save-btn {
    background: #1A1A1A;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.add-btn:hover, .save-btn:hover {
    background: #1a252f;
    transform: translateY(-1px);
}

.delete-btn {
    background: #e53e3e;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s;
}

.delete-btn:hover {
    background: #c53030;
}

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    padding: 25px;
    border-radius: 8px;
    width: 90%;
    max-width: 700px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

/* Responsywność */
@media (max-width: 768px) {
    .admin-section {
        padding: 15px;
    }

    .modal-content {
        width: 91%;
        padding: 15px;
    }
}
</style>