<template>
    <div class="services-page">
        <section class="about-us-section">
            <div class="container">
                <h2 class="section-title bold">REALIZACJE</h2>
                <p class="hero-description">Zobacz rzeczywiste efekty naszej pracy w różnych przypadkach uszkodzeń.</p>
                <div v-if="loading" class="loading-indicator">
                    Ładowanie danych...
                </div>

                <div v-if="error" class="error-message">
                    Wystąpił błąd podczas ładowania danych: {{ error }}
                </div>

                <div v-if="!loading && !error">
                    <div class="category-filters">
                        <button
                            v-for="service in services"
                            :key="service.id"
                            class="category-toggle"
                            :class="{ pressed: selectedServices.includes(service.id) }"
                            @click="toggleService(service.id)"
                        >
                            {{ service.name }}
                        </button>
                    </div>

                    <div v-if="filteredPhotos.length === 0" class="no-results">
                        Brak zdjęć dla wybranych usług.
                    </div>

                    <div v-else class="gallery">
                        <div
                            v-for="photo in paginatedPhotos"
                            :key="photo.id"
                            class="photo-card"
                            @click="openLightbox(photo)"
                        >
                            <img
                                :src="getPhotoUrl(photo)"
                                :alt="photo.original_name"
                                class="photo-image"
                                @error="handleImageError"
                            >
                            <div class="photo-info">
                                <span class="photo-service">{{ getServiceName(photo.service_id) }}</span>
                            </div>
                        </div>
                    </div>

                    <div v-if="filteredPhotos.length > 0" class="pagination">
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
            </div>
        </section>

        <!-- Lightbox для перегляду фото на весь екран -->
        <div v-if="lightboxVisible" class="lightbox" @click.self="closeLightbox">
            <div class="lightbox-content">
                <button class="lightbox-close" @click="closeLightbox">&times;</button>
                <button class="lightbox-nav lightbox-prev" @click.stop="prevPhoto" :disabled="currentPhotoIndex === 0">
                    &larr;
                </button>

                <div class="lightbox-image-container">
                    <img
                        :src="getPhotoUrl(currentPhoto)"
                        :alt="currentPhoto.original_name"
                        class="lightbox-image"
                    >
                    <div class="lightbox-info">
                        <span class="lightbox-service">{{ getServiceName(currentPhoto.service_id) }}</span>
                    </div>
                </div>

                <button class="lightbox-nav lightbox-next" @click.stop="nextPhoto" :disabled="currentPhotoIndex === filteredPhotos.length - 1">
                    &rarr;
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'DentRemovalServices',
    data() {
        return {
            services: [],
            selectedServices: [],
            photos: [],
            currentPage: 1,
            perPage: 6,
            loading: false,
            error: null,
            // Lightbox data
            lightboxVisible: false,
            currentPhoto: null,
            currentPhotoIndex: 0
        }
    },
    async created() {
        await this.fetchData();
    },
    computed: {
        filteredPhotos() {
            let filtered = this.photos.filter(photo => photo.is_gallery === 1);

            if (this.selectedServices.length === 0) {
                return filtered;
            }
            return filtered.filter(photo =>
                this.selectedServices.includes(photo.service_id)
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
        async fetchData() {
            this.loading = true;
            this.error = null;

            try {
                const servicesResponse = await axios.get('/get-services');
                this.services = Object.values(servicesResponse.data);

                const photosResponse = await axios.get('/get-photos');
                this.photos = photosResponse.data.data;
            } catch (err) {
                console.error('Error fetching data:', err);
                this.error = err.message || 'Nie udało się załadować danych';
                this.loadFallbackData();
            } finally {
                this.loading = false;
            }
        },

        findPhotoUrl(photoUrls, photoId) {
            const found = photoUrls.find(url => url.id === photoId);
            return found ? found.url : '';
        },

        getPhotoUrl(photo) {
            return `/storage/${photo.path}`;
        },

        loadFallbackData() {
            this.services = [
                { id: 4, name: "Wgniecenia na drzwiach", description: "Wgniecenia na drzwiach" }
            ];

            this.photos = [
                {
                    id: 2,
                    service_id: 4,
                    is_gallery: 1,
                    original_name: "Example photo",
                    url: "https://via.placeholder.com/300"
                }
            ];
        },

        toggleService(serviceId) {
            if (this.selectedServices.includes(serviceId)) {
                this.selectedServices = this.selectedServices.filter(id => id !== serviceId);
            } else {
                this.selectedServices.push(serviceId);
            }
            this.currentPage = 1;
        },

        getServiceName(serviceId) {
            const service = this.services.find(s => s.id === serviceId);
            return service ? service.name : 'Nieznana usługa';
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },

        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },

        handleImageError(event) {
            event.target.src = 'https://via.placeholder.com/300x200?text=Image+not+found';
        },

        // Lightbox methods
        openLightbox(photo) {
            this.currentPhoto = photo;
            this.currentPhotoIndex = this.filteredPhotos.findIndex(p => p.id === photo.id);
            this.lightboxVisible = true;
            document.body.style.overflow = 'hidden'; // Блокуємо скрол сторінки
        },

        closeLightbox() {
            this.lightboxVisible = false;
            document.body.style.overflow = ''; // Відновлюємо скрол сторінки
        },

        nextPhoto() {
            if (this.currentPhotoIndex < this.filteredPhotos.length - 1) {
                this.currentPhotoIndex++;
                this.currentPhoto = this.filteredPhotos[this.currentPhotoIndex];
            }
        },

        prevPhoto() {
            if (this.currentPhotoIndex > 0) {
                this.currentPhotoIndex--;
                this.currentPhoto = this.filteredPhotos[this.currentPhotoIndex];
            }
        },

        handleKeydown(event) {
            if (this.lightboxVisible) {
                if (event.key === 'Escape') {
                    this.closeLightbox();
                } else if (event.key === 'ArrowRight') {
                    this.nextPhoto();
                } else if (event.key === 'ArrowLeft') {
                    this.prevPhoto();
                }
            }
        }
    },
    mounted() {
        window.addEventListener('keydown', this.handleKeydown);
    },
    beforeDestroy() {
        window.removeEventListener('keydown', this.handleKeydown);
    }
}
</script>

<style scoped>

.about-us-section {
    padding: 120px 0;
    background-color: #f8fafc;
}

/* Стилі залишаються незмінними, як у попередньому варіанті */
.services-page {
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

.hero-section h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
}

.hero-section p {
    font-size: 1.2rem;
    opacity: 0.9;
}

.services-section {
    padding: 7em;
}

.loading-indicator,
.error-message,
.no-results {
    text-align: center;
    padding: 40px;
    font-size: 1.2rem;
    color: #64748b;
}

.error-message {
    color: #ef4444;
}

.category-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 30px;
    justify-content: center;
}

.category-toggle {
    margin: 5px;
}

.gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.photo-card {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.photo-card:hover {
    transform: translateY(-5px);
}

.photo-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}

.photo-info {
    padding: 15px;
    background-color: white;
}

.photo-service {
    display: inline-block;
    padding: 5px 10px;
    background-color: #f1f5f9;
    border-radius: 4px;
    font-size: 0.9rem;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin-top: 30px;
}

.pagination-btn {
    padding: 8px 16px;
    background-color: #3b82f6;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.pagination-btn:hover:not(:disabled) {
    background-color: #2563eb;
}

.pagination-btn:disabled {
    background-color: #cbd5e1;
    cursor: not-allowed;
}

.page-info {
    font-weight: 600;
}

@media (max-width: 768px) {
    .hero-section {
        padding: 60px 0;
    }

    .hero-section h1 {
        font-size: 2rem;
    }

    .gallery {
        grid-template-columns: 1fr;
    }

    .category-filters {
        justify-content: flex-start;
    }

    .category-toggle {
        margin: 3px;
    }
}

/* Стилі для кнопок-категорій */
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
    color: #DAA520;
    border-color: #DAA520;
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

.lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    cursor: pointer;
}

.lightbox-content {
    position: relative;
    max-width: 90%;
    max-height: 90%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-image-container {
    position: relative;
    max-width: 100%;
    max-height: 80vh;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.lightbox-image {
    max-width: 100%;
    max-height: calc(80vh - 50px);
    object-fit: contain;
    cursor: default;
}

.lightbox-info {
    margin-top: 15px;
    color: white;
    text-align: center;
    padding: 10px;
    background-color: rgba(0, 0, 0, 0.7);
    border-radius: 4px;
}

.lightbox-service {
    font-size: 1.2rem;
}

.lightbox-close {
    position: absolute;
    top: -40px;
    right: 0;
    background: none;
    border: none;
    color: white;
    font-size: 2rem;
    cursor: pointer;
    padding: 5px 15px;
}

.lightbox-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.5);
    border: none;
    color: white;
    font-size: 2rem;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-nav:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.lightbox-prev {
    left: -70px;
}

.lightbox-next {
    right: -70px;
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

.hero-description {
    color: #1A1A1A;
    font-size: 1.25rem;
    max-width: 53rem;
    margin: 0 auto 2rem;
    line-height: 1.6;
    opacity: 0.9;
    animation: fadeInUp 0.8s ease-out 0.2s forwards;
    text-align: center;
}


@media (max-width: 768px) {
    .about-us-section {
        padding: 50px 0;
    }

    .hero-description {
        font-size: 1.1rem;
    }

    .section-title {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .lightbox-prev {
        left: 10px;
    }

    .lightbox-next {
        right: 10px;
    }

    .lightbox-close {
        top: 10px;
        right: 10px;
    }

    .lightbox-image {
        max-height: 60vh;
    }
}
</style>