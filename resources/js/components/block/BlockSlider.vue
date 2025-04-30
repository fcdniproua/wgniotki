<template>
    <div class="sliders-container" :class="{ 'mobile-view': isMobile }">
        <div class="before-after-slider-wrapper">
            <!-- Перший слайдер (код залишається без змін) -->
            <div class="slider-navigation" :class="{ 'mobile-layout': isMobile }">
                <button
                    v-if="!isMobile"
                    @click="prevSlide(1)"
                    :disabled="currentIndex_1 === 0"
                    class="triangle-arrow left-arrow"
                />

                <div class="slider-container">
                    <div
                        class="before-after-container"
                        ref="container1"
                        @mousedown="startDrag"
                        @touchstart.passive="handleTouchStart"
                        @touchmove.passive="handleTouchMove"
                        @touchend="handleTouchEnd"
                    >
                        <div class="image-wrapper">
                            <img class="after-image" :src="currentSlide_1.afterImage" alt="Стало">
                            <img
                                class="before-image"
                                :src="currentSlide_1.beforeImage"
                                alt="Було"
                                :style="{ clipPath: `inset(0 ${100 - handlePosition_1}% 0 0)` }"
                            >
                        </div>
                        <div
                            class="slider-handle"
                            :style="{ left: `${handlePosition_1}%` }"
                            @mousedown="startDrag"
                        ></div>
                        <div class="labels">
                            <span class="label">Przed</span>
                            <span class="label">Po</span>
                        </div>
                    </div>
                </div>

                <button
                    v-if="!isMobile"
                    @click="nextSlide(1)"
                    :disabled="currentIndex_1 === slides_1.length - 1"
                    class="triangle-arrow right-arrow"
                />
            </div>

            <div class="mobile-controls" v-if="isMobile">
                <button @click="prevSlide(1)" :disabled="currentIndex_1 === 0">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span class="mobile-counter">{{ currentIndex_1 + 1 }} / {{ slides_1.length }}</span>
                <button @click="nextSlide(1)" :disabled="currentIndex_1 === slides_1.length - 1">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="before-after-slider-wrapper">
            <!-- Другий слайдер (код залишається без змін) -->
            <div class="slider-navigation" :class="{ 'mobile-layout': isMobile }">
                <button
                    v-if="!isMobile"
                    @click="prevSlide(2)"
                    :disabled="currentIndex_2 === 0"
                    class="triangle-arrow left-arrow"
                />

                <div class="slider-container">
                    <div
                        class="before-after-container"
                        ref="container2"
                        @mousedown="startDrag"
                        @touchstart.passive="handleTouchStart"
                        @touchmove.passive="handleTouchMove"
                        @touchend="handleTouchEnd"
                    >
                        <div class="image-wrapper">
                            <img class="after-image" :src="currentSlide_2.afterImage" alt="Стало">
                            <img
                                class="before-image"
                                :src="currentSlide_2.beforeImage"
                                alt="Було"
                                :style="{ clipPath: `inset(0 ${100 - handlePosition_2}% 0 0)` }"
                            >
                        </div>
                        <div
                            class="slider-handle"
                            :style="{ left: `${handlePosition_2}%` }"
                            @mousedown="startDrag"
                        ></div>
                        <div class="labels">
                            <span class="label">Przed</span>
                            <span class="label">Po</span>
                        </div>
                    </div>
                </div>

                <button
                    v-if="!isMobile"
                    @click="nextSlide(2)"
                    :disabled="currentIndex_2 === slides_2.length - 1"
                    class="triangle-arrow right-arrow"
                />
            </div>

            <div class="mobile-controls" v-if="isMobile">
                <button @click="prevSlide(2)" :disabled="currentIndex_2 === 0">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span class="mobile-counter">{{ currentIndex_2 + 1 }} / {{ slides_2.length }}</span>
                <button @click="nextSlide(2)" :disabled="currentIndex_2 === slides_2.length - 1">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: 'BeforeAfterSlider',
    data() {
        return {
            slidersData: [],
            slides_1: [],
            slides_2: [],
            currentIndex_1: 0,
            currentIndex_2: 0,
            handlePosition_1: 50,
            handlePosition_2: 50,
            isDragging: false,
            isMobile: false,
            touchStartX: 0,
            activeSlider: 1
        }
    },
    computed: {
        currentSlide_1() {
            return this.slides_1[this.currentIndex_1] || {};
        },
        currentSlide_2() {
            return this.slides_2[this.currentIndex_2] || {};
        }
    },
    mounted() {
        this.checkMobile();
        this.fetchSliders();
        window.addEventListener('resize', this.checkMobile);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.checkMobile);
        document.removeEventListener('mousemove', this.handleMove);
        document.removeEventListener('mouseup', this.stopDrag);
    },
    methods: {
        fetchSliders() {
            axios.get('/get-slider')
                .then(response => {
                    this.slidersData = response.data;
                    this.prepareSliders();
                })
                .catch(error => {
                    console.error('Error fetching sliders:', error);
                    this.slides_1 = [
                        {
                            beforeImage: 'img/1830126de_web_2880.jpg',
                            afterImage: 'img/A220768_web_2880.jpg'
                        },
                        {
                            beforeImage: 'img/A244681_web_960.jpg',
                            afterImage: 'img/chris-hardy-_-rVRTYZuLM-unsplash.jpg'
                        }
                    ];
                    this.slides_2 = [
                        {
                            beforeImage: 'https://via.placeholder.com/800x400/3357FF/FFFFFF?text=Було',
                            afterImage: 'https://via.placeholder.com/800x400/F033FF/FFFFFF?text=Стало'
                        }
                    ];
                });
        },
        prepareSliders() {
            if (this.slidersData.slider_1) {
                this.slides_1 = this.createBeforeAfterPairs(this.slidersData.slider_1);
            }
            if (this.slidersData.slider_2) {
                this.slides_2 = this.createBeforeAfterPairs(this.slidersData.slider_2);
            }
        },
        createBeforeAfterPairs(photos) {
            const pairs = [];
            const tagMap = {};

            photos.forEach(photo => {
                if (!photo.slider_tag) return;

                if (!tagMap[photo.slider_tag]) {
                    tagMap[photo.slider_tag] = [];
                }
                if (tagMap[photo.slider_tag].length < 2) {
                    tagMap[photo.slider_tag].push(photo);
                }
            });

            for (const tag in tagMap) {
                const photosWithTag = tagMap[tag];
                if (photosWithTag.length === 2) {
                    photosWithTag.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                    pairs.push({
                        beforeImage: '/storage/' + photosWithTag[0].path,
                        afterImage: '/storage/' + photosWithTag[1].path
                    });
                }
            }

            return pairs.length > 0 ? pairs : [
                {
                    beforeImage: 'https://via.placeholder.com/800x400/3357FF/FFFFFF?text=Було',
                    afterImage: 'https://via.placeholder.com/800x400/F033FF/FFFFFF?text=Стало'
                }
            ];
        },
        checkMobile() {
            this.isMobile = window.innerWidth <= 768;
        },
        startDrag(e) {
            this.isDragging = true;
            this.activeSlider = e.target.closest('.before-after-container') === this.$refs.container1 ? 1 : 2;
            document.addEventListener('mousemove', this.handleMove);
            document.addEventListener('mouseup', this.stopDrag);
            this.updateHandlePosition(e.clientX);
        },
        stopDrag() {
            this.isDragging = false;
            document.removeEventListener('mousemove', this.handleMove);
            document.removeEventListener('mouseup', this.stopDrag);
        },
        handleMove(e) {
            if (!this.isDragging) return;
            this.updateHandlePosition(e.clientX);
        },
        handleTouchStart(e) {
            this.touchStartX = e.touches[0].clientX;
            this.isDragging = true;
            this.activeSlider = e.target.closest('.before-after-container') === this.$refs.container1 ? 1 : 2;
            this.updateHandlePosition(this.touchStartX);
        },
        handleTouchMove(e) {
            if (!this.isDragging) return;
            this.updateHandlePosition(e.touches[0].clientX);
        },
        handleTouchEnd() {
            this.isDragging = false;
        },
        updateHandlePosition(clientX) {
            const container = this.activeSlider === 1 ? this.$refs.container1 : this.$refs.container2;
            if (!container) return;

            const rect = container.getBoundingClientRect();
            let x = clientX - rect.left;
            x = Math.max(0, Math.min(x, rect.width));
            const position = (x / rect.width) * 100;

            if (this.activeSlider === 1) {
                this.handlePosition_1 = position;
            } else {
                this.handlePosition_2 = position;
            }
        },
        nextSlide(sliderNumber) {
            if (sliderNumber === 1 && this.currentIndex_1 < this.slides_1.length - 1) {
                this.currentIndex_1++;
                this.handlePosition_1 = 50;
            } else if (sliderNumber === 2 && this.currentIndex_2 < this.slides_2.length - 1) {
                this.currentIndex_2++;
                this.handlePosition_2 = 50;
            }
        },
        prevSlide(sliderNumber) {
            if (sliderNumber === 1 && this.currentIndex_1 > 0) {
                this.currentIndex_1--;
                this.handlePosition_1 = 50;
            } else if (sliderNumber === 2 && this.currentIndex_2 > 0) {
                this.currentIndex_2--;
                this.handlePosition_2 = 50;
            }
        }
    }
}
</script>

<style scoped>
.sliders-container {
    display: flex;
    gap: 20px;
    margin: 0 auto;
    padding: 20px;
}

.sliders-container.mobile-view {
    flex-direction: column;
    gap: 40px;
}

.before-after-slider-wrapper {
    flex: 1;
}

.slider-navigation {
    display: flex;
    align-items: center;
    gap: 20px;
}

.slider-navigation.mobile-layout {
    display: block;
}

.slider-container {
    flex-grow: 1;
    position: relative;
}

.before-after-container {
    position: relative;
    height: 400px;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    touch-action: none;
}

.image-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
}

.after-image, .before-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    pointer-events: none;
    user-select: none;
}

.before-image {
    z-index: 2;
}

.slider-handle {
    position: absolute;
    width: 4px;
    height: 100%;
    background: white;
    top: 0;
    z-index: 3;
    cursor: ew-resize;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    transform: translateX(-50%);
    touch-action: none;
}

.slider-handle:after {
    content: '';
    position: absolute;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: white;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
}

.labels {
    position: absolute;
    bottom: 20px;
    width: 100%;
    display: flex;
    justify-content: space-between;
    z-index: 4;
    padding: 0 20px;
    box-sizing: border-box;
}

.label {
    background: rgba(0,0,0,0.6);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 14px;
}

.triangle-arrow {
    width: 0;
    height: 0;
    border-style: solid;
    background: transparent;
    border-color: transparent;
    cursor: pointer;
    padding: 0;
    transition: all 0.2s ease;
    pointer-events: auto;
}

.left-arrow {
    border-width: 20px 30px 20px 0;
    border-right-color: #1e293b;
}

.right-arrow {
    border-width: 20px 0 20px 30px;
    border-left-color: #1e293b;
}

.triangle-arrow:hover:not(:disabled) {
    opacity: 0.8;
}

.triangle-arrow:disabled {
    opacity: 0.2;
    cursor: not-allowed;
}

.mobile-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
}

.mobile-controls button {
    background: #1e293b;
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.mobile-controls button:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.mobile-counter {
    font-weight: 600;
    color: #1e293b;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .before-after-container {
        height: 300px;
    }
}

@media (max-width: 480px) {
    .before-after-container {
        height: 250px;
    }

    .labels {
        bottom: 10px;
        padding: 0 10px;
    }

    .label {
        font-size: 12px;
        padding: 3px 10px;
    }

    .slider-handle:after {
        width: 25px;
        height: 25px;
    }
}
</style>