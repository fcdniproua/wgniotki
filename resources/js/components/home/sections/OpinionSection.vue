<template>
    <section class="reviews-section">
        <div class="container">
            <h2 class="section-title bold">Opinie naszych klientów</h2>
            <p class="section-subtitle">Uwielbiamy wypielęgnowane auta!
                Budujemy zaufanie nie słowami, lecz efektami – przekonało się o tym już wielu, teraz możesz i Ty.
            </p>

            <div class="reviews-grid">
                <!-- Google Reviews -->
                <div class="review-platform">
                    <div class="platform-header">
                        <i class="fa fa-brands fa-google"></i>
                        <div class="platform-info">
                            <div class="rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-value">{{googleRating}}/5</span>
                            </div>
                            <span class="review-count">{{googleReviews.length}} opinii</span>
                        </div>
                    </div>

                    <div class="reviews-slider">
                        <div v-for="(review, index) in visibleGoogleReviews" :key="'google-'+index" class="review-card">
                            <div class="review-author">
                                <img class="author-avatar" :src="review.author_photo_url" :alt="review.author_name">
                                <div class="author-info">
                                  <a class="author-name" target="_blank" :href="review.author_url">{{review.author_name}}</a>
                                  <div class="review-rating">
                                    <span v-for="star in 5" :key="star"
                                          :class="['star', star <= review.rating ? 'filled' : '']">★</span>
                                  </div>
                                </div>
<!--                                <img :src="review.author_photo_url" alt="">-->
<!--                                <a target="_blank" :href="review.author_url">{{review.author_name}}</a>-->
                            </div>
                            <span class="review-date">{{review.relative_time}}</span>
                            <p class="review-text">"{{review.text}}"</p>

                        </div>
                    </div>

                    <button class="show-more" @click="showMoreGoogle" v-if="googleReviews.length > 2">
                        {{showMoreGoogleReviews ? 'Pokaż mniej' : `Pokaż więcej (${googleReviews.length - 2})`}}
                    </button>
                    <div class="opinion-watch">
                        <a :href="googleMapsLink" target="_blank" class="review-link">
                            Zobacz wszystkie opinie na Google
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Facebook Reviews -->
                <div class="review-platform">
                    <div class="platform-header">
                        <i class="fa fa-brands fa-facebook-f"></i>
                        <div class="platform-info">
                            <div class="rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-value">{{facebookRating}}/5</span>
                            </div>
                            <span class="review-count">{{facebookReviews.length}} opinii</span>
                        </div>
                    </div>

                    <div class="reviews-slider">
                        <div v-for="(review, index) in visibleFacebookReviews" :key="'facebook-'+index"
                             class="review-card">
                            <p class="review-text">"{{review.text}}"</p>
                            <span class="review-author">- {{review.author}}</span>
                            <span class="review-date">{{review.date}}</span>
                        </div>
                    </div>
                    <button class="show-more" @click="showMoreFacebook" v-if="facebookReviews.length > 2">
                        {{showMoreFacebookReviews ? 'Pokaż mniej' : `Pokaż więcej (${facebookReviews.length - 2})`}}
                    </button>
                    <div class="opinion-watch">
                        <a :href="facebookPageLink" target="_blank" class="review-link">
                            Zobacz wszystkie opinie na Facebook
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'CustomerReviews',
    data() {
        return {
            googleMapsLink: 'https://www.google.com/maps/place/Usuwanie+wgniece%C5%84+Wroc%C5%82aw/@51.1262895,17.0285593,17z/data=!4m18!1m9!3m8!1s0x470fe96a9263bd9d:0x2c84a327d4c65c47!2sUsuwanie+wgniece%C5%84+Wroc%C5%82aw!8m2!3d51.1262862!4d17.0311342!9m1!1b1!16s%2Fg%2F11krs6sy5v!3m7!1s0x470fe96a9263bd9d:0x2c84a327d4c65c47!8m2!3d51.1262862!4d17.0311342!9m1!1b1!16s%2Fg%2F11krs6sy5v?entry=ttu&g_ep=EgoyMDI1MDQwOC4wIKXMDSoASAFQAw%3D%3D', // Замініть на реальне посилання
            facebookPageLink: 'https://facebook.com/TwojeSTO', // Замініть на реальне посилання
            showMoreGoogleReviews: false,
            showMoreFacebookReviews: false,
            googleRating: 4.9,
            facebookRating: 5.0,
            googleReviews: [
                {
                    text: '',
                    author_name: '',
                    author_photo_url: '',
                    author_url: '',
                    author_rating: '',
                    author_time: '',
                    relative_time: '',
                    rating: '',
                }
            ],
            facebookReviews: [
                {
                    text: 'Polecam każdemu! Świetna jakość usług i miła obsługa. Wrócę na pewno.',
                    author: 'Katarzyna Nowak',
                    date: 'tydzień temu'
                },
                {
                    text: 'Najlepszy serwis w mieście! Wgniecenie zniknęło jak ręką odjął.',
                    author: 'Jan Kowalski',
                    date: '2 miesiące temu'
                },
                {
                    text: 'Szybko, profesjonalnie i w dobrej cenie. Jestem pod wrażeniem!',
                    author: 'Agnieszka Wiśniewska',
                    date: '4 miesiące temu'
                }
            ]
        }
    },
    computed: {
        visibleGoogleReviews() {
            return this.showMoreGoogleReviews
                ? this.googleReviews
                : this.googleReviews.slice(0, 2);
        },
        visibleFacebookReviews() {
            return this.showMoreFacebookReviews
                ? this.facebookReviews
                : this.facebookReviews.slice(0, 2);
        }
    },
    methods: {
        showMoreGoogle() {
            this.showMoreGoogleReviews = !this.showMoreGoogleReviews;
        },
        showMoreFacebook() {
            this.showMoreFacebookReviews = !this.showMoreFacebookReviews;
        },
        async fetchReviews() {
            this.isLoading = true;
            this.error = null;
            let facebookResponse = null;
            try {
                // Виконуємо запити паралельно
                const [googleResponse /*facebookResponse*/] = await Promise.all([
                    this.fetchGoogleReviews(),
                    // this.fetchFacebookReviews()
                ]);

                // Оновлюємо дані
                if (googleResponse) {
                    this.googleRating = googleResponse.rating;
                    this.googleReviews = googleResponse.reviews;
                }

                if (facebookResponse) {
                    this.facebookRating = facebookResponse.rating;
                    this.facebookReviews = facebookResponse.reviews;
                }
            } catch (err) {
                console.error('Error fetching reviews:', err);
                this.error = 'Failed to load reviews';
                // Можна показати повідомлення про помилку
            } finally {
                this.isLoading = false;
            }
        },

        async fetchGoogleReviews() {
            try {
                const response = await fetch('/google-reviews');
                if (!response.ok) throw new Error('Google reviews failed');
                return await response.json();
            } catch (error) {
                console.error('Google reviews error:', error);
                return null;
            }
        },

        async fetchFacebookReviews() {
            return {};
            try {
                const response = await fetch('/facebook-reviews');
                if (!response.ok) throw new Error('Facebook reviews failed');
                return await response.json();
            } catch (error) {
                console.error('Facebook reviews error:', error);
                return null;
            }
        },

        formatDate(dateString) {
            try {
                const date = new Date(dateString);
                const now = new Date();
                const diff = now - date;

                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                if (days > 0) return `${days} dni temu`;

                const hours = Math.floor(diff / (1000 * 60 * 60));
                if (hours > 0) return `${hours} godzin temu`;

                return 'przed chwilą';
            } catch (e) {
                return dateString;
            }
        }

    },
    async mounted() {
        await this.fetchReviews();
    }
}
</script>

<style scoped>
.reviews-section {
    padding: 5rem 0;
    background-color: #F5F1EB;
    width: 100vw;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #DAA520;
    text-align: center;
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #64748b;
    text-align: center;
    margin-bottom: 3rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.reviews-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.review-platform {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.platform-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
}

.platform-logo {
    width: 50px;
    height: 50px;
    margin-right: 15px;
}

.platform-info {
    display: flex;
    flex-direction: column;
}

.rating {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.stars {
    color: #FFD700;
    font-size: 1.2rem;
    letter-spacing: 2px;
    margin-right: 10px;
}

.rating-value {
    font-weight: 600;
    color: #1e293b;
    font-size: 1rem;
}

.review-count {
    font-size: 0.9rem;
    color: #64748b;
}

.reviews-slider {
    margin-bottom: 1.5rem;
}

.review-card {
    padding: 1rem 0;
    border-bottom: 1px solid #e2e8f0;
}

.review-card:last-child {
    border-bottom: none;
}

.review-text {
    font-size: 1rem;
    line-height: 1.7;
    color: #334155;
    margin-bottom: 0.5rem;
    font-style: italic;
}

.review-author {
    display: block;
    font-weight: 600;
    color: #1e293b;
    font-size: 0.9rem;
}

.review-date {
    display: block;
    font-size: 0.8rem;
    color: #64748b;
    margin-top: 0.3rem;
}

.show-more {
    background: none;
    border: none;
    color: #3b82f6;
    font-weight: 600;
    cursor: pointer;
    padding: 0.5rem 0;
    margin: 1rem 0;
    display: inline-block;
}

.show-more:hover {
    text-decoration: underline;
}

.review-link {
    display: inline-flex;
    align-items: center;
    color: #3b82f6;
    text-decoration: none;
    font-weight: 600;
    margin-top: 1rem;
    transition: color 0.3s ease;
}

.review-link:hover {
    color: #2563eb;
}

.review-link i {
    margin-left: 8px;
    transition: transform 0.3s ease;
}

.review-link:hover i {
    transform: translateX(5px);
}

.google-review .review-link {
    color: #4285F4;
}

.facebook-review .review-link {
    color: #1877F2;
}

@media (max-width: 768px) {
    .reviews-section {
        padding: 3rem 0;
    }

    .section-title {
        font-size: 2rem;
    }

    .reviews-grid {
        grid-template-columns: 1fr;
    }

    .platform-logo {
        width: 40px;
        height: 40px;
    }
}

.fa-brands {
    font-size: 50px;
    padding: 0 10px;
}

.opinion-watch {
    display: flex;
    justify-content: space-around;
}


.reviews-container {
    max-width: 800px;
    margin: 0 auto;

}

.review-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    padding: 24px;
    margin-bottom: 20px;
    transition: transform 0.3s ease;
}

.review-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.review-author {
    display: flex;
    align-items: center;
    gap: 12px;
}

.author-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #f0f0f0;
}

.author-info {
    display: flex;
    flex-direction: column;
}

.author-name {
    font-weight: 600;
    color: #2d3748;
    text-decoration: none;
    transition: color 0.2s;
}

.author-name:hover {
    color: #4a5568;
    text-decoration: underline;
}

.review-rating {
    margin-top: 4px;
}

.star {
    color: #e2e8f0;
    font-size: 16px;
}

.star.filled {
    color: #fbbf24;
}

.review-date {
    color: #718096;
    font-size: 14px;
}

.review-content {
    margin-top: 12px;
}

.review-text {
    color: #4a5568;
    line-height: 1.6;
    margin: 0;
    font-size: 15px;
}

/* Адаптація для мобільних */
@media (max-width: 640px) {
    .review-header {
        flex-direction: column;
        gap: 8px;
    }

    .review-date {
        align-self: flex-start;
        margin-left: 60px; /* Відступ під аватар */
    }
}

</style>