<template>
    <section class="map-section">
        <div class="map-container">
            <h2 class="section-title bold" v-if="!hideTitle">Kontakt</h2>

            <div class="contact-grid">
                <div class="contact-item">
                    <div class="icon-wrapper">
                        <a href="https://www.google.com/maps?ll=51.126291,17.031129&z=16&t=m&hl=en&gl=PL&mapclient=embed&q=Kleczkowska+18b+50-227+Wroc%C5%82aw" target="_blank"><icon-map-pin class="contact-icon" /></a>
                    </div>
                    <a href="https://www.google.com/maps?ll=51.126291,17.031129&z=16&t=m&hl=en&gl=PL&mapclient=embed&q=Kleczkowska+18b+50-227+Wroc%C5%82aw" target="_blank"> <p class="contact-text">ul. Kleczkowska 18B, 50-227 Wrocław, Poland</p></a>
                </div>

                <div class="contact-item">
                    <div class="icon-wrapper">
                        <IconPhoneCall class="contact-icon" />
                    </div>
                    <p class="contact-text"><a  class="contact-text" href="tel:48510631616">510 631 616</a></p>
                </div>
            </div>

            <h2 class="section-subtitle semibold">Polub nasze strony </h2>

            <div class="contact-grid">
                <div class="contact-item">
                    <ul class="social-icons">
                        <li><a href="https://www.instagram.com/usuwanie.wgniecen.wroclaw" target="_blank"><icon-instagram /></a></li>
                        <li><a href="https://wa.me/48510631616" target="_blank"><icon-whatsapp /></a></li>
                        <li><a href="https://m.facebook.com/108648248244581" target="_blank"><icon-facebook /></a></li>
                    </ul>
                </div>
            </div>


            <div class="map-wrapper" v-html="mapEmbed"></div>
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
    background: linear-gradient(90deg, #3b82f6, #1d4ed8);
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
    color: #FF6700;
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

.social-icons {
    position: relative;
    display: flex;
    list-style: none;
    justify-content: center;
    padding: 0;
}
.social-icons li {
    position: relative;
    margin: 0 20px;
    cursor: pointer;
}
.social-icons li a {
    position: relative;
    text-decoration: none;
    display: block;
}
.social-icons li a .fa-brands {
    font-size: 4em;
    color: #222;
    transition: 0.3s;
}

.section-subtitle {
    font-size: 1.8rem;
    color: #64748b;
    text-align: center;
    margin-bottom: 3rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

</style>

<script>
import IconPhone from "../../icon/IconPhone.vue";
import IconPhoneCall from "../../icon/IconPhoneCall.vue";
import IconMapPin from "../../icon/IconMapPin.vue";
import IconMail from "../../icon/IconMail.vue";
import IconClock from "../../icon/IconClock.vue";
import IconChevronDown from "../../icon/IconChevronDown.vue";
import IconFacebook from "../../icon/IconFacebook.vue";
import IconInstagram from "../../icon/IconInstagram.vue";
import IconWhatsapp from "../../icon/IconWhatsapp.vue";

export default {
    components: {
        IconWhatsapp,
        IconInstagram,
        IconFacebook,
        IconPhone,
        IconPhoneCall,
        IconMapPin,
        IconClock,
        IconChevronDown,
        IconMail,
    },
    props: {
        mapEmbed: {
            type: String,
            required: true,
            default: ''
        },
        hideTitle: {
            type: Boolean,
            default: false
        }
    }
}
</script>