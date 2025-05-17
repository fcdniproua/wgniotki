<template>
    <section class="about-us-section">
        <div class="about-container">
            <h2 class="section-title bold">O NAS</h2>

            <div class="about-content">
                <div class="about-image">
<!--                    <img src="/img/warsztat.jpg" alt="Nasz warsztat" class="workshop-image">-->
                </div>

                <div class="about-text">
                    <h3 class="subtitle bold">Specjalizujemy się w <strong>usuwaniu wgnieceń metodą PDR</strong> we Wrocławiu.</h3>

                    <p class="description semibold">
                        Działamy szybko, precyzyjnie i bezpiecznie – bez szpachlowania, bez lakierowania.</p>

                    <p class="closing-text">
                        Naprawiamy <strong>wszystkie typy samochodów</strong>: miejskie, luksusowe, SUV-y i inne, youngtimery, klasyki i auta firmowe – niezależnie od marki, modelu czy kraju rejestracji.
                        <br>
                        <br>
                        <strong>Nie boimy się trudnych wyzwań</strong> – skomplikowane wgniecenia po gradobiciu, szkodach parkingowych. Uszkodzenia w trudno dostępnych miejscach?
                        Doradzimy Ci. Tam, gdzie inni mówią ‘nie da się’ – <strong>my podejmujemy się naprawy.</strong>
                        <br>
                        <br>
                        Za firmą stoi <strong>Eliasz Kowalczuk</strong> – pasjonat motoryzacji, który sam naprawia auta razem z zespołem doświadczonych techników.
                        <strong>Jesteśmy ekipą fachowców, którzy naprawdę znają się na rzeczy.</strong>
                        Doradzimy najlepsze rozwiązanie i przywrócimy Twojemu autu perfekcyjny wygląd.
                        <br>
                        <br>
                        Zadzwoń, napisz lub umów się online – działamy szybko i bez zbędnej zwłoki.

                    </p>
                </div>
            </div>
            <div class="btn-block">
                <button class="btn-primary bold" @click="showModal()">
                    Wyceń usługę
                </button>
                <router-link :to="{path: '/', hash: '#faq'}" class="btn-primary bold">F.A.Q.</router-link>
            </div>
        </div>
    </section>
    <ContactModal v-if="showContact" @close="closeModal()" />
</template>

<script>
import ContactModal from "../home/sections/ContactModal.vue";
import {inject, ref} from "vue";

export default {
    name: 'AboutPage',
    components: {ContactModal},
    setup() {
        const showContact = ref(false);
        const showModal = () => {
            showContact.value = true;
        }
        const closeModal = () => {
            showContact.value = false;
        }
        return {
            showContact,
            showModal,
            closeModal
        };
    }
}
</script>

<style scoped>

.btn-primary {
    text-align: center;
    border: 1px solid #1A1A1A;
    padding: 20px;
    border-radius: 32px;
    cursor: pointer;
    color: #1A1A1A;
    position:relative;
    top: 60px;
    transition: all 0.3s ease;
    font-size: 25px;
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
    color: #1A1A1A;
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

.btn-block {
    padding: 0 20px;
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 50px;
    margin-bottom: 25px;
}

@media (max-width: 576px) {
    .btn-block {
        padding: 0 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 20px;
        margin-top: 50px;
        margin-bottom: 25px;
    }
    .about-us-section {
        padding: 50px 0;
    }

    .section-title {
        font-size: 1.8rem;
        margin-bottom: 30px;
    }
}
</style>