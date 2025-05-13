<template>
    <section class="faq-section" id="faq">
        <div class="container">
            <h2 class="section-title bold" >Najczęściej zadawane pytania – FAQ</h2>
            <div
                class="faq-item"
                v-for="(item, index) in faqItems"
                :key="index"
                @click="toggleItem(index)"
            >
                <div class="faq-question" :class="{ 'active': activeIndex === index }">
                    <h3>{{ item.question }}</h3>
                    <span class="toggle-icon">{{ activeIndex === index ? '-' : '+' }}</span>
                </div>
                <div class="faq-answer" :class="{ 'active': activeIndex === index }">
                    <div v-html="item.answer"></div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'FAQSection',
    data() {
        return {
            activeIndex: null,
            faqItems: [
                {
                    question: "Czy można usunąć wgniotkę bez lakierowania?",
                    answer: "<p>Tak, metoda PDR (Paintless Dent Repair) pozwala na usunięcie wgniotek bez konieczności lakierowania karoserii. Warunkiem jest, aby uszkodzony nie był wcześniej szpachlowany – wtedy możemy precyzyjnie wyciągnąć lub wypchnąć wgniotkę i przywrócić pierwotny kształt karoserii.</p>"
                },
                {
                    question: "Ile kosztuje usunięcie wgniotki?",
                    answer: `
            <p>Cena zależy od:</p>
            <ul>
              <li>nakładu pracy</li>
              <li>wielkości i głębokości wgniotki,</li>
              <li>lokalizacji na aucie (np. dach, maska, klapa, drzwi, reling),</li>
              <li>dostępności od wewnątrz,</li>
              <li>typu blachy</li>
            </ul>
            <p>Typowe naprawy zaczynają się już od 100 zł, a dokładną wycenę naprawy robimy po oględzinach auta lub na podstawie zdjęć – możesz je wysłać przez formularz lub na WhatsApp.</p>
          `
                },
                {
                    question: "Czy po naprawie metodą PDR pozostają ślady?",
                    answer: "<p>Jeśli lakier nie został uszkodzony, naprawa metodą PDR nie pozostawia śladów. Element odzyskuje swój pierwotny kształt bez potrzeby lakierowania, co pozwala zachować oryginalną powłokę lakierniczą pojazdu.</p>"
                },
                {
                    question: "Czy muszę zostawić auto na kilka dni?",
                    answer: "<p>Niekoniecznie. Większość napraw wykonujemy tego samego dnia, czasem nawet w ciągu 1–3 godzin. Nie ma potrzeby zostawiania auta na długie dni – działamy sprawnie, bez zbędnych formalności.</p>"
                },
                {
                    question: "Czy oferujecie naprawy w pobliżu mnie?",
                    answer: "<p>Tak! Obsługujemy Wrocław i okolice, w tym: Krzyki, Gaj, Fabryczna, Psie Pole, Ołbin, Ołtaszyn, Brochów, Klecina, Muchobór, Tarnogaj, a także Bielany Wrocławskie, Długołęka, Kąty Wrocławskie, Siechnice i inne lokalizacje.\n" +
                        "Szukasz „usuwanie wgniotek bez lakierowania w pobliżu mnie”? Jesteś we właściwym miejscu.</p>"
                },
                {
                    question: "Jakie wgniotki da się naprawić metodą PDR?",
                    answer: `
            <p>Naprawiamy:</p>
            <ul>
              <li>Wgniotki po gradobiciu</li>
              <li>Szkody parkingowe (np. po otwarciu drzwi na ciasnym parkingu)</li>
              <li>Drobne szkody, nawet od kamieni, kasztanów, zwierząt i uderzeń rowerowych</li>
              <li>Wgniotki na masce, dachu, błotnikach, drzwiach</li>
              <li>Nawet trudne przypadki uszkodzenia dachu wokół anten (rekinek) – mamy odpowiednie doświadczenie.</li>
            </ul>`
                },
                {
                    question: "Czy naprawa PDR jest objęta ubezpieczeniem AC?",
                    answer: "<p>W wielu przypadkach tak. Jeśli posiadasz ubezpieczenie AC, warto skontaktować się z ubezpieczycielem, aby dowiedzieć się, czy naprawa metodą PDR jest objęta polisą. Wielu ubezpieczycieli akceptuje tę metodę jako skuteczną i ekonomiczną formę naprawy. Współpracujemy z firmami ubezpieczeniowymi. </p>"
                },
                {
                    question: "Co jeśli wgniotka jest trudna, w nietypowym miejscu?",
                    answer: "<p>Nie boimy się wyzwań. Specjalizujemy się w naprawach, których inni się nie podejmują. Jeżeli inni powiedzieli „tego się nie da”, my to zazwyczaj robimy – skutecznie i bezpiecznie.</p>"
                },
                {
                    question: "Jak umówić się na naprawę?",
                    answer: `
            <p>To proste:</p>
            <ol>
              <li>Zrób zdjęcie wgniotki</li>
              <li>Wyślij je przez formularz lub na WhatsApp</li>
              <li>Otrzymasz wycenę i najbliższy termin naprawy</li>
            </ol>
            <p>Terminy mamy dość krótkie: tydzień-dwa na skomplikowane wgniecenia, a często nawet na dziś lub jutro w przypadku niedużych wgniotek. Działamy elastycznie i zawsze się dogadamy.</p>
          `
                },
                {
                    question: "Czy można usunąć wgniecenie z elementu aluminiowego?",
                    answer: "<p>Tak, robimy to, możliwe jest usunięcie wgnieceń z elementów aluminiowych, jednak ze względu na twardość tego materiału, proces ten jest bardziej skomplikowany. Nie martw się, skontaktuj z nami. </p>"
                },
                {
                    question: "Czy naprawiacie karoserię pokrytą folią lub powłoką ceramiczną?",
                    answer: "<p>Tak! Wiemy, jak obchodzić się z folią i powłokami ceramicznymi. Naprawiamy wgniotki tak, aby zachować ich ochronę — bezpiecznie i bez najmniejszego śladu.\n</p>"
                },
                {
                    question: "Czy można samodzielnie usunąć wgniecenie?",
                    answer: "<p>Nie polecamy, chociaż istnieją zestawy do samodzielnego usuwania wgnieceń, brak doświadczenia i odpowiednich narzędzi może prowadzić do pogorszenia stanu karoserii. Zaleca się skorzystanie z usług profesjonalistów, pomożemy ci, wyślij zdjęcia przez formularz lub zadzwoń. </p>"
                },
                {
                    question: "Czy naprawa PDR jest możliwa w przypadku uszkodzeń na krawędziach (rantach)?",
                    answer: "<p>Tak, ale jest to bardziej skomplikowane niż w przypadku płaskich powierzchni. Naprawa wgnieceń na krawędziach wymaga większej precyzji i doświadczenia, dlatego ważne jest, aby powierzyć ją specjalistom z odpowiednim know-how. Naprawiamy to, dlatego wyślij zdjęcia przez formularz lub zadzwoń.</p>"
                },
                {
                    question: "Czy usuwacie wgniecenia z elementów wcześniej lakierowanych?\n",
                    answer: "<p>Tak, usuwamy wgniecenia także z elementów, które były już lakierowane — pod warunkiem, że nie zawierają szpachli.</p>"
                },
            ]
        }
    },
    methods: {
        toggleItem(index) {
            this.activeIndex = this.activeIndex === index ? null : index
        }
    }
}
</script>

<style scoped>
.faq-section {
    width: 100vw;
    padding: 60px 0;
    background-color: #fff;
}

.container {
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
.faq-item {
    margin-bottom: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
}

.faq-item:hover {
    border-color: #ccc;
}

.faq-question {
    padding: 20px;
    background-color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.faq-question h3 {
    margin: 0;
    font-size: 18px;
    color: #2c3e50;
}

.faq-question.active {
    background-color: #f5f5f5;
}

.toggle-icon {
    font-size: 24px;
    font-weight: bold;
    color: #2c3e50;
}

.faq-answer {
    padding: 0 20px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease, padding 0.3s ease;
    background-color: #fff;
}

.faq-answer.active {
    padding: 0 20px 20px 20px;
    max-height: 1000px;
}

.faq-answer >>> p {
    margin-bottom: 15px;
    line-height: 1.6;
}

.faq-answer >>> ul,
.faq-answer >>> ol {
    margin-bottom: 15px;
    padding-left: 20px;
}

.faq-answer >>> li {
    margin-bottom: 8px;
}

@media (max-width: 768px) {
    .section-title {
        font-size: 28px;
    }

    .faq-question h3 {
        font-size: 16px;
    }

    .faq-question {
        padding: 15px;
    }
}
</style>