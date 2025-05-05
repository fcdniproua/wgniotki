<template>
    <section class="about-us-section">
        <h2 class="section-title bold">KONTAKT</h2>
        <MapSection :contactData="contactData" :hideTitle="true"/>
    </section>
</template>

<script>
import MapSection from "../home/sections/MapSection.vue";
import {inject, ref} from "vue";
export default {
    name: 'ContactPage',
    components: {
        MapSection,


    },
    setup() {
        const contactData = inject('contactData')

        return {
            contactData,
        };
    }
}
</script>

<style scoped>
.about-us-section {
    padding: 120px 0;
    background-color: #f8fafc;
}

.about-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e293b;
    text-align: center;
    margin-bottom: 50px;
    position: relative;
    text-transform: uppercase;
    letter-spacing: 1.5px;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 3px;
    background: linear-gradient(90deg, #DAA520, #DAA520);
}

.about-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
}

.about-image {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.workshop-image {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.3s ease;
}

.workshop-image:hover {
    transform: scale(1.03);
}

.subtitle {
    font-size: 1.5rem;
    color: #1e293b;
    margin-bottom: 25px;
    font-weight: 600;
}

.description, .closing-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #334155;
    margin-bottom: 20px;
}

.features-list {
    margin: 30px 0;
    padding: 0;
    list-style: none;
}

.feature-item {
    margin-bottom: 15px;
    font-size: 1.05rem;
    display: flex;
    align-items: flex-start;
    color: #334155;
}

.check-icon {
    color: #3b82f6;
    font-weight: bold;
    margin-right: 10px;
    font-size: 1.2rem;
}

@media (max-width: 992px) {
    .about-content {
        grid-template-columns: 1fr;
    }

    .about-image {
        max-width: 600px;
        margin: 0 auto;
    }

    .section-title {
        font-size: 2rem;
    }

    .subtitle {
        font-size: 1.3rem;
    }
}

@media (max-width: 576px) {
    .about-us-section {
        padding: 50px 0;
    }

    .section-title {
        font-size: 1.8rem;
        margin-bottom: 30px;
    }
}
</style>