<template>
    <div class="services-page">
        <!-- Hero Section (залишається без змін) -->
        <section class="hero-section">
            <div class="container">
                <h1>Usuwanie wgnieceń</h1>
                <p>Profesjonalne usuwanie wgnieceń bez lakierowania (PDR) dla wszystkich typów pojazdów</p>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-section">
            <div class="container">
                <!-- Категорії фільтрів з новими кнопками -->
                <div class="category-filters">
                    <button
                        v-for="category in categories"
                        :key="category.id"
                        class="category-toggle"
                        :class="{ pressed: selectedCategories.includes(category.id) }"
                        @click="toggleCategory(category.id)"
                    >
                        {{ category.name }}
                    </button>
                </div>

                <!-- Галерея (залишається без змін) -->
                <div class="gallery">
                    <div
                        v-for="photo in paginatedPhotos"
                        :key="photo.id"
                        class="photo-card"
                    >
                        <div class="photo-placeholder">
                            <span>Photo {{ photo.id }}</span>
                        </div>
                        <div class="photo-info">
                            <span class="photo-category">{{ getCategoryName(photo.categoryId) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Пагінація (залишається без змін) -->
                <div class="pagination">
                    <button
                        @click="prevPage"
                        :disabled="currentPage === 1"
                        class="pagination-btn"
                    >
                        &larr;
                    </button>
                    <span class="page-info">Strona {{ currentPage }} z {{ totalPages }}</span>
                    <button
                        @click="nextPage"
                        :disabled="currentPage === totalPages"
                        class="pagination-btn"
                    >
                        &rarr;
                    </button>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: 'DentRemovalServices',
    data() {
        return {
            categories: [
                { id: 1, name: 'Drzwi' },
                { id: 2, name: 'Błotniki' },
                { id: 3, name: 'Maski' },
                { id: 4, name: 'Dachy' },
                { id: 5, name: 'Klapy bagażnika' },
                { id: 6, name: 'Progi' }
            ],
            selectedCategories: [],
            photos: [],
            currentPage: 1,
            perPage: 6
        }
    },
    created() {
        this.generateMockPhotos();
    },
    computed: {
        filteredPhotos() {
            if (this.selectedCategories.length === 0) return this.photos;
            return this.photos.filter(photo =>
                this.selectedCategories.includes(photo.categoryId)
            );
        },
        paginatedPhotos() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredPhotos.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredPhotos.length / this.perPage);
        }
    },
    methods: {
        generateMockPhotos() {
            const mockPhotos = [];
            for (let i = 1; i <= 25; i++) {
                mockPhotos.push({
                    id: i,
                    categoryId: Math.floor(Math.random() * 6) + 1,
                    imageUrl: ''
                });
            }
            this.photos = mockPhotos;
        },
        toggleCategory(categoryId) {
            if (this.selectedCategories.includes(categoryId)) {
                this.selectedCategories = this.selectedCategories.filter(id => id !== categoryId);
            } else {
                this.selectedCategories.push(categoryId);
            }
            this.currentPage = 1; // Скидаємо пагінацію при зміні фільтрів
        },
        getCategoryName(categoryId) {
            const category = this.categories.find(cat => cat.id === categoryId);
            return category ? category.name : '';
        },
        nextPage() {
            if (this.currentPage < this.totalPages) this.currentPage++;
        },
        prevPage() {
            if (this.currentPage > 1) this.currentPage--;
        }
    }
}
</script>

<style scoped>
/* Стилі для кнопок-категорій (оновлені) */
.category-toggle {
    padding: 8px 16px;
    background: #e2e8f0;
    border: 2px solid #cbd5e1;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    color: #1e293b;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin: 5px;
}

.category-toggle:hover {
    background: #cbd5e1;
}

.category-toggle.pressed {
    background: #e2e8f0;
    color: #1e293b;
    border-color: #94a3b8;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
    transform: translateY(2px);
}

.category-toggle.pressed::after {
    content: '';
    position: absolute;
    top: 1px;
    left: 1px;
    right: 1px;
    bottom: 1px;
    border-radius: 4px;
    background: rgba(0, 0, 0, 0.05);
}

/* Решта стилів залишаються без змін */
.services-page {
    font-family: 'Open Sans', sans-serif;
    color: #333;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.hero-section {
    background-color: #1e293b;
    color: white;
    padding: 80px 0;
    text-align: center;
}

/* ... (інші стилі як у вашому коді) ... */
</style>