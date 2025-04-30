<template>
    <section class="services-section">
        <div class="services-container">
            <h3 class="services-title">Nasze prace</h3>
            <div class="slider-wrapper">
                <BlockSlider />
            </div>
        </div>
    </section>
</template>

<style scoped>
.services-section {
    background-color: #f8fafc;
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
    color: #1e293b;
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
    background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    border-radius: 4px;
}

.slider-wrapper {
    width: 100%;
    margin: 0 auto;
    padding: 2rem 0;
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
}
</style>

<script setup lang="ts">
import BlockSlider from "../../block/BlockSlider.vue";
</script>