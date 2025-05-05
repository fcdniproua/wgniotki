<template>
    <section class="hero-section">
        <div class="hero-container">
            <div class="desktop-header">
                <h2 class="hero-title bold"> Usuwanie wgnieceń Wrocław</h2>
            </div>
            <div class="mobile-header">
                <h2 class="hero-title bold"> Usuwanie wgnieceń</h2>

                <h2 class="hero-title bold">Wrocław</h2>
            </div>
<!--            <h2 class="hero-title bold"> Usuwanie wgnieceń Wrocław</h2>-->
            <p class="hero-description">
                Precyzyjnie usuwamy wgniecenia bez lakierowania popularną metodą PDR
            </p>
            <button class="hero-button-1" @click="$emit('open-contact-modal');">
                Wyceń usługę
            </button>
        </div>
    </section>
</template>

<style scoped>

@media (max-width: 768px) {
    .hero-section {
        min-height: calc(100vh - 260px);
    }
}

.hero-section {
    flex: 1; /* Займає доступний простір */
    display: flex;
    align-items: center;
    justify-content: center;
    background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),url('/img/pexels-gregory-costa-5733733.jpg');
    background-size: cover; /* фото покриває весь екран */
    background-position: center 100%;
    background-repeat: no-repeat; /* фото не повторюється */
    color: white;
    padding: 15rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
    width: 100vw;

}

.hero-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem 1rem;
    position: relative;
    z-index: 2;
}


.hero-section::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.4); /* чорний з 40% прозорістю */
    z-index: 1;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    animation: fadeInUp 0.8s ease-out;
    color: #DAA520;
}

.hero-description {
    font-size: 1.25rem;
    max-width: 42rem;
    margin: 0 auto 2rem;
    line-height: 1.6;
    opacity: 0.9;
    animation: fadeInUp 0.8s ease-out 0.2s forwards;
    opacity: 0;
}

.hero-button-1 {
    display: inline-block;
    background-color: transparent;
    color: #DAA520; /* світліший жовтий */
    border: 2px solid #DAA520;
    font-weight: 700;
    font-size: 16px;
    padding: 12px 28px;
    border-radius: 30px;
    text-transform: uppercase;
    transition: all 0.3s ease;
    cursor: pointer;
}

.hero-button-1:hover {
    background-color: #DAA520;
    color: #1a1a1a;
}



@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .hero-section {
        padding: 3rem 0; /* Теж видаляємо бічні відступи на мобільних */
        background-position: 50% center;
    }

    .hero-container{
        margin-bottom: 50px;
    }

    .hero-title {
        font-size: 2rem;
    }

    .hero-description {
        font-size: 1.1rem;
    }
    .desktop-header {
        display: none;
    }
    .mobile-header {
        display: block!important;
    }
}
.mobile-header {
    display: none;
}
</style>
<script setup lang="ts">
</script>