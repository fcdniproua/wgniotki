<template>
    <div class="main-page-container">
        <HeroSection />
        <ServiceGallery />
        <section class="text-section">
            <div>
                <span>
                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                    totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                    Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit,
                    sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est,
                    qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit,
                    sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.
                    Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea
                    commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae
                    consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
                </span>
            </div>
        </section>
        <MapSection />
        <OpinionSection />
    </div>
</template>

<script>
import HeroSection from '../home/sections/HeroSection.vue';
import ServiceGallery from '../home/sections/ServiceGallery.vue';
import MapSection from "../home/sections/MapSection.vue";

export default {
    name: 'HomePage',
    components: {
        MapSection,
        HeroSection,
        ServiceGallery
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