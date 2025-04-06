<template>
    <div class="app-container">
        <Header class="app-header" @open-contact-modal="showContact = true" />
        <main class="app-main">
            <router-view/>
        </main>
        <Footer class="app-footer" />
        <ContactModal v-if="showContact" @close="showContact = false" />
    </div>
</template>

<script>
import Header from './components/layout/Header.vue';
import Footer from './components/layout/Footer.vue';
import ContactModal from './components/home/sections/ContactModal.vue';

export default {
    name: 'AppLayout',
    components: {
        Header,
        Footer,
        ContactModal
    },
    data() {
        return {
            showContact: false
        }
    },
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
    height: 240px; /* Висота вашого футера */
}
</style>