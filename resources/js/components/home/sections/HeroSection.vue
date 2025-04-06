<template>
    <section class="hero-section">
        <div class="hero-container">
            <h2 class="hero-title">Usuwanie wgnieceń Wrocław</h2>
            <p class="hero-description">
                Szkody parkingowe, powypadkowe, komunikacyjne oraz uszkodzenia gradowe. Szybko i profesjonalnie!
            </p>
            <button class="hero-button">
                Umów się na wizytę
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
    background: url('/img/pexels-brett-sayles-1592261.jpg') center/cover no-repeat;
    color: white;
    padding: 5rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
    width: 100vw;

}

.hero-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
    position: relative;
    z-index: 2;
}


.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 75% 50%, rgba(255,255,255,0.1) 0%, transparent 30%);
    z-index: 1;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    animation: fadeInUp 0.8s ease-out;
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

.hero-button {
    background-color: white;
    color: #1e40af;
    font-weight: 600;
    padding: 0.75rem 2rem;
    border-radius: 0.375rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.8s ease-out 0.4s forwards;
    opacity: 0;
    transform: translateY(20px);
}

.hero-button:hover {
    background-color: #f3f4f6;
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.hero-button:active {
    transform: translateY(0);
}

.hero-button::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, transparent 50%, rgba(255,255,255,0.2) 100%);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.hero-button:hover::after {
    transform: translateX(100%);
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
    }

    .hero-title {
        font-size: 2rem;
    }

    .hero-description {
        font-size: 1.1rem;
    }
}
</style>