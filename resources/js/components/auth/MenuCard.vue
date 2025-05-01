<template>
    <router-link :to="route" class="menu-card">
        <div class="card-content" :class="color">
            <div class="card-icon">
                <i :class="['fas', icon]"></i>
            </div>
            <h3 class="bold">{{ title }}</h3>
        </div>
    </router-link>
</template>

<script setup>
defineProps({
    title: String,
    icon: String,
    color: String,
    route: String
});
</script>

<style scoped>
.menu-card {
    text-decoration: none;
}

.card-content {
    border-radius: 0.5rem;
    padding: 1.5rem;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    min-height: 180px;
    position: relative;
    overflow: hidden;
}

.card-content:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.card-content::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        to bottom right,
        rgba(255, 255, 255, 0.3),
        rgba(255, 255, 255, 0.1)
    );
    transform: rotate(30deg);
    transition: all 0.3s ease;
}

.card-content:hover::after {
    transform: rotate(30deg) translate(10%, 10%);
}

.card-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.card-icon i {
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

.card-content h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

/* Kolory kart */
.bg-blue-500 { background: #4299e1; }
.bg-green-500 { background: #48bb78; }
.bg-yellow-500 { background: #ecc94b; }
.bg-purple-500 { background: #9f7aea; }
.bg-red-500 { background: #f56565; }
.bg-gray-500 { background: #718096; }
</style>