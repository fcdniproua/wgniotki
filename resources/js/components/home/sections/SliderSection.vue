<template>
    <section class="services-section">
        <div class="services-container">
            <br>
            <h3 class="services-title bold">REALIZACJE</h3>
            <div class="slider-wrapper">
                <BlockSlider />
                <router-link to="/services" class="btn-primary">Zobacz więcej</router-link>
            </div>
        </div>
    </section>
</template>

<style scoped>
.services-section {
    background-color: #F5F1EB;
    padding: 0; /* Збільшив відступи */
    width: 100vw;
    text-align: center;
}

.services-container {
    margin: 0 auto;
    padding: 0; /* Збільшив бічні відступи */
    width: 100%;
}

.services-title {
    font-size: 2.5rem; /* Збільшив розмір шрифту */
    font-weight: 700;
    color: #DAA520;
    text-align: center;
    margin-bottom: 4rem; /* Збільшив відступ знизу */
    position: relative;
    display: inline-block;
}

.services-title::after {
    content: '';
    position: absolute;
    bottom: -15px; /* Збільшив відстань підкреслення */
    left: 0;
    width: 100%;
    height: 4px; /* Збільшив товщину лінії */
    background: linear-gradient(90deg, #DAA520, #DAA520);
    border-radius: 4px;
}

.slider-wrapper {
    width: 100%;
    margin: 0 auto;
    padding: 2rem 0;
    height: 600px;
}

/* Адаптація для мобільних пристроїв */
@media (max-width: 768px) {
    .services-section {
        padding: 0;
    }

    .services-container {
        padding: 0;
    }

    .services-title {
        font-size: 2rem;
        margin-bottom: 3rem;
    }

    .slider-wrapper {
        height: 850px;
    }
}
.btn-primary {
    border: 1px solid #1A1A1A;
    padding: 20px;
    border-radius: 32px;
    cursor: pointer;
    color: #1A1A1A;
    position:relative;
    top: 60px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    border: 1px solid #1A1A1A;
    background-color: #1A1A1A;
    color: #fff;
    padding: 20px;
    border-radius: 32px;
    cursor: pointer;
    position:relative;
    top: 60px;
}
</style>

<script setup lang="ts">
import BlockSlider from "../../block/BlockSlider.vue";
</script>