<template>
    <section class="about-us-section">
        <h2 class="section-title bold">Polityka Prywatności</h2>
        <div class="about-text">
            <p>Niniejsza polityka prywatności określa zasady przetwarzania danych osobowych przekazywanych przez Użytkowników za pośrednictwem formularza kontaktowego dostępnego na stronie internetowej <a href="https://www.usuwanie-wgniecen.pro" target="_blank">www.usuwanie-wgniecen.pro</a>.</p>

            <h2>1. Administrator danych osobowych</h2>
            <p>
                Administratorem danych osobowych jest:<br>
                <strong>USUWANIE WGNIECEŃ ILLIA KOVALCHUK</strong><br>
                ul. Kleczkowska 18B, 50-227 Wrocław<br>
                NIP: 8952254284, REGON: 524663440<br>
                e-mail: <a href="mailto:support@usuwanie-wgniecen.pro">support@usuwanie-wgniecen.pro</a>
            </p>

            <h2>2. Zakres przetwarzanych danych</h2>
            <p>Przetwarzamy dane osobowe podane dobrowolnie przez Użytkownika w formularzu kontaktowym, tj.:</p>
            <ul>
                <li>imię i nazwisko,</li>
                <li>adres e-mail,</li>
                <li>numer telefonu.</li>
            </ul>

            <h2>3. Cel i podstawa prawna przetwarzania</h2>
            <p>Dane przetwarzane są w celu:</p>
            <ul>
                <li>udzielenia odpowiedzi na przesłane zapytanie,</li>
                <li>kontaktu handlowego i przedstawienia oferty (jeśli dotyczy).</li>
            </ul>
            <p>Podstawą prawną przetwarzania danych jest zgoda Użytkownika (art. 6 ust. 1 lit. a RODO).</p>

            <h2>4. Dobrowolność podania danych</h2>
            <p>Podanie danych jest dobrowolne, ale niezbędne do realizacji celu, jakim jest kontakt zwrotny z Użytkownikiem.</p>

            <h2>5. Okres przechowywania danych</h2>
            <p>Dane będą przetwarzane przez okres niezbędny do realizacji celu kontaktu, a następnie mogą być przechowywane przez okres przedawnienia roszczeń lub do czasu wycofania zgody.</p>

            <h2>6. Odbiorcy danych</h2>
            <p>Dane mogą być powierzane zaufanym podmiotom przetwarzającym, takim jak dostawcy hostingu, poczty elektronicznej czy systemów CRM – wyłącznie w zakresie niezbędnym do świadczenia usług.</p>

            <h2>7. Prawa osoby, której dane dotyczą</h2>
            <p>Użytkownik ma prawo do:</p>
            <ul>
                <li>dostępu do swoich danych,</li>
                <li>ich sprostowania,</li>
                <li>usunięcia („prawo do bycia zapomnianym”),</li>
                <li>ograniczenia przetwarzania,</li>
                <li>przenoszenia danych,</li>
                <li>wniesienia sprzeciwu,</li>
                <li>cofnięcia zgody w dowolnym momencie (bez wpływu na zgodność z prawem przetwarzania przed cofnięciem).</li>
            </ul>
            <p>W celu realizacji powyższych praw prosimy o kontakt: <a href="mailto:bezwgniotek@gmail.com">bezwgniotek@gmail.com</a>.</p>

            <h2>8. Skarga do organu nadzorczego</h2>
            <p>Użytkownik ma prawo wniesienia skargi do Prezesa Urzędu Ochrony Danych Osobowych, jeśli uzna, że przetwarzanie jego danych narusza przepisy RODO.</p>

            <h2>9. Zabezpieczenia</h2>
            <p>Administrator stosuje odpowiednie środki techniczne i organizacyjne w celu zapewnienia bezpieczeństwa danych osobowych, zgodnie z obowiązującymi przepisami prawa.</p>

            <h2>10. Dodatkowe informacje o przetwarzaniu danych</h2>
            <p>Dane Użytkowników mogą być zapisywane w systemie CRM w celu utrzymania kontaktu, historii korespondencji oraz personalizacji ofert marketingowych (profilowanie).</p>
            <p>Dane nie będą przekazywane osobom trzecim bez wyraźnej zgody, z wyjątkiem podmiotów świadczących usługi IT i marketingowe na rzecz Administratora.</p>
        </div>
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
    background-color: #F5F1EB;
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

.about-text {
    padding: 50px;
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