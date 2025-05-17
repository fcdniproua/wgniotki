<template>
    <section class="about-section">
        <div class="about-container">
            <h2 class="about-title bold">O nas – Usuwanie wgnieceń metodą PDR we Wrocławiu</h2>

            <div class="about-content">
                <p>Jesteśmy ekspertami w <b class="b-text">usuwaniu wgniotek metodą PDR </b>(Paintless Dent Repair). Działamy we Wrocławiu, oferując szybkie i profesjonalne naprawy uszkodzeń karoserii bez konieczności jej lakierowania. Nasze usługi obejmują usuwanie wgnieceń po <b class="b-text">szkodach parkingowych</b>, <b class="b-text">uszkodzeń po wypadkach</b> oraz <b class="b-text">po gradobiciu</b></p>
                <div>Naprawiamy wgniecenia na wszystkich elementach karoserii, takich jak:
                    <ul class="car-list">
                        <li>drzwi</li>
                        <li>błotniki</li>
                        <li>maska</li>
                        <li>klapa</li>
                        <li>dach</li>
                        <li>relingi</li>
                    </ul>
                </div>
                <div>
                    <h3 class="b-text bold">Dlaczego warto wybrać nas?</h3>
                    <ul class="car-list">
                        <li><b class="b-text">Fachowość</b> – mamy duże doświadczenie i wyspecjalizowane umiejętności praktyczne, które pozwalają nam wykonywać naprawy, których inni się boją.</li>
                        <li><b class="b-text">Szybka naprawa, znakomity efekt</b> – naprawiamy wgniotki w krótkim czasie,bez konieczności pozostawiania auta w serwisie na długie dni.</li>
                        <li><b class="b-text">Atrakcyjna cena</b> – oferujemy konkurencyjne ceny,które pozwalają Ci zaoszczędzić pieniądze bez obawy o jakości usługi.</li>
                        <li><b class="b-text">Łatwy kontakt</b> – umów się na naprawę online lub telefonicznie, na pewno znajdziemy dla Ciebie dogodny termin.</li>
                    </ul>
                <p>Zajmujemy się naprawą samochodów wszystkich marek i modeli – niezależnie od tego, są to <b class="b-text">uuszkodzenia po kolizjach, drobne wgniotki, szkody parkingowe, czy też wgniecenia po gradzie  </b> – poradzimy sobie z każdym problemem.
                    Zaufaj specjalistom, którzy naprawdę znają się na rzeczy i daj swojemu samochodowi drugie życie. </p>
                <p>
                    Mamy tysiące zadowolonych klientów, którzy chwalą nas za  skuteczny, szybki i bezproblemowy proces naprawy.
                    Szukasz specjalistów, <b class="b-text">którzy naprawią wgniotki blisko Ciebie?</b> Zaufaj profesjonalistom, którzy naprawdę kochają to, co robią.
                    <b class="b-text" @click="$emit('open-contact-modal')" style="cursor: pointer; color: #DAA520">Skontaktuj się z nami i umów wizytę jeszcze dziś!</b>
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
    color: #1A1A1A;
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
    padding-bottom: 15px;

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
    background: linear-gradient(90deg, #DAA520, #DAA520);
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
    color: #1A1A1A
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