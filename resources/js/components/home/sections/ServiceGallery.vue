<template>
    <section class="services-section">
        <div class="services-container">
            <h3 class="services-title bold">Nasze usługi</h3>
            <div class="services-grid">
                <div v-for="n in 8" :key="n" class="service-card">
                    <div class="service-image">
                        <span>Zdjęcie {{ n }}</span>
                    </div>
                    <div class="service-name">Nazwa usługi {{ n }}</div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.services-section {
    background-color: #F5F1EB;
    padding: 4rem 0;
    position: relative;
    flex: 1; /* Займає доступний простір */
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100vw;
}

.services-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.services-title {
    font-size: 2rem;
    font-weight: 700;
    color: #DAA520;
    text-align: center;
    margin-bottom: 3rem;
    position: relative;
    display: inline-block;
    left: 50%;
    transform: translateX(-50%);
}

.services-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #DAA520, #DAA520);
    border-radius: 3px;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.service-card {
    background: white;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: relative;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.service-image {
    height: 180px;
    background-color: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.service-image::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(29, 78, 216, 0.1) 100%);
}

.service-image span {
    font-weight: 600;
    color: #64748b;
    z-index: 1;
}

.service-name {
    padding: 1.25rem;
    text-align: center;
    font-weight: 600;
    color: #334155;
    font-size: 0.95rem;
}

@media (min-width: 768px) {
    .services-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }

    .service-image {
        height: 200px;
    }

    .service-name {
        font-size: 1rem;
        padding: 1.5rem;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.service-card:nth-child(1) { animation: fadeIn 0.5s ease 0.1s forwards; opacity: 0; }
.service-card:nth-child(2) { animation: fadeIn 0.5s ease 0.2s forwards; opacity: 0; }
.service-card:nth-child(3) { animation: fadeIn 0.5s ease 0.3s forwards; opacity: 0; }
.service-card:nth-child(4) { animation: fadeIn 0.5s ease 0.4s forwards; opacity: 0; }
.service-card:nth-child(5) { animation: fadeIn 0.5s ease 0.5s forwards; opacity: 0; }
.service-card:nth-child(6) { animation: fadeIn 0.5s ease 0.6s forwards; opacity: 0; }
.service-card:nth-child(7) { animation: fadeIn 0.5s ease 0.7s forwards; opacity: 0; }
.service-card:nth-child(8) { animation: fadeIn 0.5s ease 0.8s forwards; opacity: 0; }
</style>