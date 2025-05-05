<template>
    <div class="main-page-container">
        <HeroSection @open-contact-modal="showModal()" />
        <SliderSection />
        <TextSection @open-contact-modal="showModal()"/>
<!--        <WhyMeSection />-->
        <CustomerReviews />
        <FAQSection />
        <MapSection :contactData="contactData"/>
        <ContactModal v-if="showContact" @close="closeModal()" />
    </div>
</template>

<script>
import HeroSection from '../home/sections/HeroSection.vue';
import MapSection from "../home/sections/MapSection.vue";
import SliderSection from "../home/sections/SliderSection.vue";
import TextSection from "../home/sections/TextSection.vue";
import CustomerReviews from "../home/sections/OpinionSection.vue";
import ContactModal from "../home/sections/ContactModal.vue";
import {inject, ref} from "vue";
import WhyMeSection from "../home/sections/WhyMeSection.vue";
import FAQSection from "../home/sections/FaqSection.vue";

export default {
    name: 'HomePage',
    components: {
        FAQSection,
        WhyMeSection,
        ContactModal,
        CustomerReviews,
        SliderSection,
        MapSection,
        HeroSection,
        TextSection,

    },
    setup() {
        const showContact = ref(false);
        const contactData = inject('contactData')
        const showModal = () => {
            showContact.value = true;
        }
        const closeModal = () => {
            showContact.value = false;
        }
        return {
            contactData,
            showContact,
            showModal,
            closeModal
        };
    }
}
</script>

<style scoped>
.main-page-container {
    width: 100%;
    min-height: calc(100vh - 310px);
    max-width: 1200px;
}
@media (max-width: 768px) {
    .main-page-container {
        padding: 0;
    }
}

.text-section {
    width: 100vw;
    display: flex;
    text-align: center;
    justify-content: center;
    align-items: center ;
    background-color: #fff;
    padding: 4rem 0;
    position: relative;
    flex: 1;
}
</style>