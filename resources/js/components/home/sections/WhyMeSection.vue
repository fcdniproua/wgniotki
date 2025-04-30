<template>
    <section class="about-section">
        <div class="about-container">
            <h2 class="about-title">DLACZEGO MY?</h2>
            <div class="about-features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <img :src="'/img/icons8-worker-80.png'" alt="$">
                    </div>
                    <h3 class="feature-title">Fachowość</h3>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <img :src="'/img/icons8-bolt-80.png'" alt="$">
                    </div>
                    <h3 class="feature-title">Szybka naprawa</h3>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <img :src="'/img/icons8-location-80.png'" alt="$">
                    </div>
                    <h3 class="feature-title">Dobra lokalizacja</h3>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <img :src="'/img/icons8-dollar-80.png'" alt="$">
                    </div>
                    <h3 class="feature-title">Konkurencyjne ceny</h3>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <img :src="'/img/icons8-schedule-80.png'" alt="$">
                    </div>
                    <h3 class="feature-title">Łatwość umówienia</h3>
                </div>
                <!--  по три в ряд -->
                <div class="feature-item">
                    <div class="feature-icon crowd">
                        <img :src="'/img/icons8-crowd-80.png'" alt="$">
                    </div>
                    <h3 class="feature-title">Setki zadowolonych klientów</h3>
                </div>

<!--                <div class="feature-item">-->
<!--                    <div class="feature-icon">✓</div>-->
<!--                    <h3 class="feature-title">Profesjonalny zespół</h3>-->
<!--                </div>-->
<!--                -->
<!--                <div class="feature-item">-->
<!--                    <div class="feature-icon">✓</div>-->
<!--                    <h3 class="feature-title">Setki zadowolonych klientów</h3>-->
<!--                </div>-->
            </div>
        </div>
    </section>
</template>

<style scoped>
/* About Us Section - Text Only Version */
.about-section {
    padding: 80px 0;
    background-color: #fff;
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
    max-width: 800px;
    margin: 0 auto;
}

.about-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #334155;
    text-align: center;
    font-family: 'Open Sans', sans-serif;
}

.about-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 70px;
    margin-top: 40px;
}

.feature-item {
    text-align: center;
    padding: 25px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgb(108, 102, 102);
    transition: transform 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-10px);
}

.feature-icon {
    font-size: 2.5rem;
    color: #3b82f6;
    margin-bottom: 15px;
}

.feature-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #1e293b;
}

.feature-text {
    font-size: 0.95rem;
    color: #64748b;
    line-height: 1.6;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .about-section {
        padding: 60px 0;
    }

    .about-title {
        font-size: 2rem;
    }

    .about-text {
        font-size: 1rem;
    }

    .about-features {
        grid-template-columns: 1fr;
    }
}
</style>
<!--<script>-->
<!--import IconWorker from "../../icon/IconWorker.vue";-->
<!--import IconBolt from "../../icon/IconBolt.vue";-->
<!--import IconMap from "../../icon/IconMap.vue";-->
<!--import IconCrowd from "../../icon/IconCrowd.vue";-->
<!--import IconCalendar from "../../icon/IconCalendar.vue";-->
<!--</script>-->
<script setup lang="ts">
</script>