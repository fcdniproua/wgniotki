<template>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-columns">
                    <!-- Колонка з контактами -->
                    <div class="footer-column">
                        <h3 class="footer-heading bold">Kontakt</h3>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><a href="https://www.google.com/maps?ll=51.126291,17.031129&z=16&t=m&hl=en&gl=PL&mapclient=embed&q=Kleczkowska+18b+50-227+Wroc%C5%82aw">{{contactData.address}}</a></span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <a :href="'tel:' + contactData.contactPhone">{{contactData.contactPhone}}</a>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <a :href="'mailto:' + contactData.contactEmail">{{contactData.contactEmail}}</a>
                        </div>
                    </div>

                    <!-- Колонка з годинами роботи -->
                    <div class="footer-column">
                        <h3 class="footer-heading bold">Godziny otwarcia</h3>
                        <div class="hours-item" v-for="(day,index) in contactData.openingHours" :key="index">
                            <span class="day">{{weekDays[index]}}:</span>
                            <span class="hours" v-if="day.closed === false">{{day.from}} - {{day.to}}</span>
                            <span class="hours" v-else>Zamknięte</span>
                        </div>
                    </div>

                    <!-- Колонка з соцмережами -->
                    <div class="footer-column">
                        <h3 class="footer-heading bold">Polub nas</h3>
                        <div class="social-links">
                            <a href="https://www.instagram.com/usuwanie.wgniecen.wroclaw" class="social-icon"
                               target="_blank">
                                <icon-instagram/>
                            </a>
                            <a href="https://wa.me/48510631616" class="social-icon" target="_blank"><icon-whatsapp /></a>
                            <a href="https://m.facebook.com/108648248244581" class="social-icon" target="_blank">
                                <icon-facebook/>
                            </a>

                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <div class="footer-legal">
                        <p class="copyright">
                            NIP - 8952254284 <br> REGON - 524663440
                        </p>
                        <p class="copyright">
                            © 2025 Usuwanie Wgnieceń. Wszystkie prawa zastrzeżone. | <router-link class="default-link" to="/privacy">Polityka prywatności </router-link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
import {inject, onMounted, ref} from "vue";
import IconFacebook from "../icon/IconFacebook.vue";
import IconWhatsapp from "../icon/IconWhatsapp.vue";
import IconInstagram from "../icon/IconInstagram.vue";

export default {
    name: 'AppFooter',
    components: {IconInstagram, IconWhatsapp, IconFacebook},

    setup() {
        const weekDays = ref(['Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela']);
        const contactData = inject('contactData')

        return {
            contactData,
            weekDays
        }
    },
}
</script>

<style scoped>
.default-link {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: color 0.3s;
}
.footer {
    background-color: #1A1A1A;
    color: #ffffff;
    padding: 3rem 0 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    width: 100%;
    z-index: 999;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);

}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-content {
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
}

.footer-columns {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.footer-column {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.footer-heading {
    font-size: 1.3rem;
    margin-bottom: 1rem;
    color: #DAA520;
    position: relative;
    padding-bottom: 10px;
}

.footer-heading::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 2px;
    background: #DAA520;
}

.contact-item, .hours-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 0.8rem;
}

.contact-item i, .hours-item i {
    color: #DAA520;
    width: 20px;
    text-align: center;
}

.contact-item a {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.3s;
}

.contact-item a:hover {
    color: #DAA520;
}

.day {
    font-weight: 600;
    min-width: 80px;
    display: inline-block;
}

.social-links {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.social-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: #ffffff;
    transition: all 0.3s;
}

.social-icon:hover {
    background: #DAA520;
    transform: translateY(-3px);
}

.fun-fact {
    margin-top: 2rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    text-align: center;
}

.counter {
    font-size: 1.8rem;
    font-weight: 700;
    color: #DAA520;
    margin-bottom: 0.5rem;
}

.counter i {
    margin-right: 10px;
}

.fun-fact p {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 1.5rem;
}

.footer-legal {
    text-align: center;
}

.copyright {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    color: rgba(255, 255, 255, 0.7);
}

.legal-links {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.legal-links a {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.8rem;
    text-decoration: none;
    transition: color 0.3s;
}

.legal-links a:hover {
    color: #ffffff;
}

@media (max-width: 768px) {
    .footer-columns {
        grid-template-columns: 1fr;
    }

    .footer-heading {
        font-size: 1.2rem;
    }

    .legal-links {
        gap: 1rem;
    }
}
</style>