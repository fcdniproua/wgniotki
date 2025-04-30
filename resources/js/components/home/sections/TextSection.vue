<template>
    <section class="about-section">
        <div class="about-container">
            <h2 class="about-title">O nas – Usuwanie wgnieceń metodą PDR we Wrocławiu i okolicach</h2>

            <div class="about-content">
                <p>Jesteśmy ekspertami w <b class="b-text">usuwaniu wgniotek metodą PDR </b>(Paintless Dent Repair). Działamy we Wrocławiu i okolicach, oferując szybkie i profesjonalne naprawy uszkodzeń karoserii bez konieczności jej lakierowania. Nasze usługi obejmują usuwanie wgnieceń po <b class="b-text">szkodach parkingowych</b>, <b class="b-text">uszkodzeń po wypadkach</b> oraz <b class="b-text">po gradobiciu</b></p>
                <div>Naprawiamy wgniecenia na każdym elemencie karoserii:
                    <ul class="car-list">
                        <li>Drzwiach</li>
                        <li>Błotnikach</li>
                        <li>Maskach</li>
                        <li>Klapach</li>
                        <li>Dachu</li>
                        <li>Relingach</li>
                    </ul>
                </div>
                <div>
                    <h3 class="b-text">Dlaczego warto wybrać nas?</h3>
                    <ul class="car-list">
                        <li><b class="b-text">Fachowość</b> – mamy doświadczenie i know-how, które pozwala nam wykonywać naprawy, których inni się boją.</li>
                        <li><b class="b-text">Szybka naprawa, perfekcyjny efekt</b> – naprawiamy wgniotki w krótkim czasie, bez pozostawiania auta na długie dni.</li>
                        <li><b class="b-text">Atrakcyjna cena</b> – oferujemy konkurencyjne ceny, które dają Ci oszczędności bez kompromisów w jakości.</li>
                        <li><b class="b-text">Łatwość umówienia</b> – umów się na naprawę online lub telefonicznie, zrobimy to w najdogodniejszym dla Ciebie terminie.</li>
                    </ul>
                <p>Zajmujemy się naprawą samochodów wszystkich marek i modeli – niezależnie od tego, czy to <b class="b-text">uszkodzenia po kolizjach czy drobne wgniotki,
                szkody parkingowe, czy wgniecenia po gradzie </b> – poradzimy sobie z każdym problemem.
                    Zaufaj specjalistom, którzy naprawdę znają się na rzeczy i daj swojemu samochodowi drugie życie. </p>
                <p>
                    Mamy tysięcy zadowolonych klientów, którzy chwalą nas za skuteczność, szybkość i bezproblemowy proces naprawy.
                    Szukasz specjalistów, <b class="b-text">którzy naprawią wgniotki w pobliżu Ciebie?</b> Zaufaj profesjonalistom, którzy naprawdę kochają to, co robią.
                    <b class="b-text" @click="$emit('open-contact-modal')">Skontaktuj się z nami i umów wizytę jeszcze dziś!</b>
                </p>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* About Us Section - Text Only Version */
.about-section {
    padding: 80px 0;
    background-color: #f8f9fa;
    position: relative;
    width: 100vw;
}

.about-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.about-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e293b;
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
    padding-bottom: 15px;
    font-family: 'Montserrat', sans-serif;
    text-transform: uppercase;
    letter-spacing: 1.5px;
}

.about-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg, #3b82f6, #1d4ed8);
}

.about-content {
    display: flex;
    flex-direction: column;
    gap: 30px;
    font-size: 20px;
    max-width: 800px;
    margin: 0 auto;
}



.highlight {
    color: #e74c3c;
    font-weight: bold;
}
.cta {
    text-align: center;
    margin-top: 30px;
    font-size: 18px;
}
.cta a {
    color: #fff;
    background-color: #2980b9;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}
.cta a:hover {
    background-color: #3498db;
}

.b-text {
    color: #2c3e50
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .about-section {
        padding: 60px 0;
    }

    .about-title {
        font-size: 2rem;
    }


}


</style>
<script setup lang="ts">
</script>