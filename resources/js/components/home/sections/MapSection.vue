<template>
    <section class="map-section">
        <div class="map-container">
            <h2 class="section-title">Kontakt</h2>

            <div class="contact-grid">
                <div class="contact-item">
                    <div class="icon-wrapper">
                        <icon-map-pin class="contact-icon" />
                    </div>
                    <p class="contact-text">ul. Kleczkowska 18B, 50-227 Wrocław, Poland</p>
                </div>

                <div class="contact-item">
                    <div class="icon-wrapper">
                        <icon-phone class="contact-icon" />
                        <icon-phone-call class="contact-icon" />
                    </div>
                    <p class="contact-text">+48 510 631 616</p>
                </div>

                <div class="contact-item">
                    <div class="icon-wrapper">
                        <icon-mail class="contact-icon" />
                    </div>
                    <p class="contact-text">bezwgniotek@gmail.com</p>
                </div>

                <div class="contact-item">
                    <div class="icon-wrapper">
                        <icon-clock class="contact-icon" />
                    </div>
                    <div class="hours-dropdown">
                        <button class="dropdown-toggle" @click="toggleHours">
                            Godziny otwarcia
                            <icon-chevron-down class="chevron" :class="{ 'rotate-180': showHours }" />
                        </button>
                        <div class="dropdown-content" :class="{ 'show': showHours }">
                            <p><strong>Poniedziałek:</strong> 09:00 – 19:00</p>
                            <p><strong>Wtorek:</strong> 09:00 – 19:00</p>
                            <p><strong>Środa:</strong> 09:00 – 19:00</p>
                            <p><strong>Czwartek:</strong> 09:00 – 19:00</p>
                            <p><strong>Piątek:</strong> 09:00 – 19:00</p>
                            <p class="closed"><strong>Sobota:</strong> Zamknięte</p>
                            <p class="closed"><strong>Niedziela:</strong> Zamknięte</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="map-wrapper">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2505.245575373025!2d17.02124931575551!3d51.10702997957188!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470fe9e7a8e7589d%3A0x5e4c9a6b5b6a4a8f!2sKleczkowska%2018B%2C%2050-227%20Wroc%C5%82aw%2C%20Poland!5e0!3m2!1sen!2spl!4v1620000000000!5m2!1sen!2spl"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    class="google-map"
                ></iframe>
            </div>
        </div>
    </section>
</template>

<style scoped>
.map-section {
    padding: 4rem 1rem;
    background-color: #f8f9fa;
    width: 100vw;
    box-sizing: border-box;
}

.map-container {
    max-width: 1200px;
    margin: 0 auto;
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: #e67e22;
    margin-bottom: 2rem;
    text-align: center;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.contact-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 0.75rem;
}

.icon-wrapper {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

.contact-icon {
    width: 24px;
    height: 24px;
    color: #e67e22;
}

.contact-text {
    margin: 0;
    font-size: 1.1rem;
    color: #4b5563;
    word-break: break-word;
}

.hours-dropdown {
    position: relative;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.dropdown-toggle {
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    font-size: 1.1rem;
    color: #4b5563;
    background-color: #f8f9fa;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.dropdown-toggle:hover {
    background-color: #f0f0f0;
}

.chevron {
    transition: transform 0.3s ease;
    width: 16px;
    height: 16px;
}

.rotate-180 {
    transform: rotate(180deg);
}

.dropdown-content {
    display: none;
    background-color: #f8f9fa;
    width: 100%;
    max-width: 280px;
    border-radius: 8px;
    padding: 1rem;
    margin-top: 0.5rem;
    text-align: center;
}

.dropdown-content.show {
    display: block;
}

.dropdown-content p {
    margin: 0.5rem 0;
    font-size: 0.95rem;
}

.dropdown-content .closed {
    color: #dc3545;
}

.map-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.google-map {
    display: block;
    width: 100%;
    border: none;
}

/* Мобільна версія */
@media (max-width: 768px) {
    .map-section {
        padding: 2rem 1rem;
    }

    .section-title {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .contact-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .contact-item {
        gap: 0.5rem;
    }

    .contact-text {
        font-size: 1rem;
        max-width: 80%;
        margin: 0 auto;
    }

    .dropdown-toggle {
        font-size: 1rem;
        padding: 0.5rem;
    }

    .google-map {
        height: 300px;
    }
}

@media (max-width: 480px) {
    .contact-text {
        max-width: 90%;
    }

    .dropdown-content {
        max-width: 90%;
    }
}
</style>

<script setup lang="ts">
import { ref } from 'vue';
import IconPhone from "../../icon/IconPhone.vue";
import IconPhoneCall from "../../icon/IconPhoneCall.vue";
import IconMapPin from "../../icon/IconMapPin.vue";
import IconMail from "../../icon/IconMail.vue";
import IconClock from "../../icon/IconClock.vue";
import IconChevronDown from "../../icon/IconChevronDown.vue";

const showHours = ref(false);

const toggleHours = () => {
    showHours.value = !showHours.value;
};
</script>