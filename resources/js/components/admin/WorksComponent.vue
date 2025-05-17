<template>
    <section class="about-us-section">
        <div class="admin-section">
            <div class="section-header">
                <h2 class="bold"> <router-link class="menu-first" to="/admin/dashboard">Dashboard</router-link> -> Galeria Prac</h2>
                <button @click="showUploadModal = true" class="add-btn">
                    <i class="fas fa-upload"></i> Dodaj nowe zdjęcie
                </button>
            </div>

            <div class="gallery-grid">
                <div v-for="photo in photos" :key="photo.id" class="gallery-item">
                    <img :src="getImageUrl(photo.path)" :alt="photo.slider_tag" class="work-image">
                    <div class="work-info">
                        <h3 class="bold">{{ photo.slider_tag || 'Brak tytułu' }}</h3>
                        <p>{{ photo.is_gallery ? 'Galeria' : 'Zwykłe zdjęcie' }}</p>
                        <div class="work-actions">
                            <button @click="editPhoto(photo)" class="edit-btn">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button @click="deletePhoto(photo.id)" class="delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                            <label class="slider-checkbox">
                                <input
                                    type="checkbox"
                                    v-model="photo.slider_1"
                                    :true-value="1"
                                    :false-value="0"
                                    @change="updateSliderStatus(photo)"
                                >
                                <span>Slider 1</span>
                            </label>
                            <label class="slider-checkbox">
                                <input
                                    type="checkbox"
                                    v-model="photo.slider_2"
                                    :true-value="1"
                                    :false-value="0"
                                    @change="updateSliderStatus(photo)"
                                >
                                <span>Slider 2</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Photo Modal -->
            <div v-if="showUploadModal" class="modal-overlay" @click.self="closeModal">
                <div class="modal-content">
                    <h3 class="bold">{{ editingId ? 'Edytuj zdjęcie' : 'Dodaj nowe zdjęcie' }}</h3>

                    <div class="form-group">
                        <label>Wybierz zdjęcie:</label>
                        <input
                            type="file"
                            @change="handleFileUpload"
                            accept="image/*"
                            ref="fileInput"
                            :required="!editingId"
                        >
                    </div>

                    <div v-if="previewImage" class="image-preview">
                        <img :src="previewImage" alt="Podgląd">
                    </div>

                    <div class="form-group">
                        <label>Tag slidera (wymagany jeśli slider aktywny):</label>
                        <input v-model="photoForm.slider_tag" type="text" class="form-input">
                    </div>

                    <div class="form-group">
                        <label>Usluga:</label>
                        <select v-model="photoForm.service_id" class="form-input" required>
                            <option v-for="app in applications" :value="app.id" :key="app.id">
                                {{ app.name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input v-model="photoForm.slider_1" type="checkbox" :true-value="1" :false-value="0">
                            Slider 1
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input v-model="photoForm.slider_2" type="checkbox" :true-value="1" :false-value="0">
                            Slider 2
                        </label>
                    </div>

                    <div class="modal-actions">
                        <button @click="savePhoto" class="save-btn" :disabled="isSaving">
                            {{ isSaving ? 'Zapisywanie...' : 'Zapisz' }}
                        </button>
                        <button @click="closeModal" class="cancel-btn">
                            Anuluj
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const photos = ref([]);
        const applications = ref([]);
        const showUploadModal = ref(false);
        const editingId = ref(null);
        const previewImage = ref(null);
        const isSaving = ref(false);

        const photoForm = ref({
            service_id: '',
            slider_1: 0,
            slider_2: 0,
            slider_tag: '',
            is_gallery: 1,
            photo: null
        });

        const fetchPhotos = async () => {
            try {
                const response = await axios.get('/get-photos');
                photos.value = response.data.data;
            } catch (error) {
                console.error('Error fetching photos:', error);
                alert('Wystąpił błąd podczas ładowania zdjęć');
            }
        };

        const fetchServices = async () => {
            try {
                const response = await axios.get('/get-services');
                applications.value = response.data;
            } catch (error) {
                console.error('Error fetching applications:', error);
            }
        };

        const getImageUrl = (path) => {
            return path.startsWith('http') ? path : `/storage/${path}`;
        };

        const handleFileUpload = (event) => {
            const file = event.target.files[0];
            if (file) {
                photoForm.value.photo = file;
                previewImage.value = URL.createObjectURL(file);
            }
        };

        const savePhoto = async () => {
            // Validate slider tag when slider is active
            if ((photoForm.value.slider_1 || photoForm.value.slider_2) && !photoForm.value.slider_tag) {
                alert('Tag slidera jest wymagany gdy slider jest aktywny');
                return;
            }

            isSaving.value = true;

            try {
                const formData = new FormData();
                for (const key in photoForm.value) {
                    if (photoForm.value[key] !== null) {
                        formData.append(key, photoForm.value[key]);
                    }
                }

                if (editingId.value) {
                    await axios.post(`/update-photos/${editingId.value}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                } else {
                    await axios.post('/save-photos', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                }

                await fetchPhotos();
                closeModal();
            } catch (error) {
                console.error('Error saving photo:', error);
                alert('Wystąpił błąd podczas zapisywania zdjęcia');
            } finally {
                isSaving.value = false;
            }
        };

        const editPhoto = (photo) => {
            editingId.value = photo.id;
            photoForm.value = {
                application_id: photo.application_id,
                service_id: photo.service_id,
                slider_1: photo.slider_1,
                slider_2: photo.slider_2,
                slider_tag: photo.slider_tag,
                is_gallery: photo.is_gallery,
                photo: null
            };
            previewImage.value = getImageUrl(photo.path);
            showUploadModal.value = true;
        };

        const deletePhoto = async (id) => {
            if (confirm('Czy na pewno chcesz usunąć to zdjęcie?')) {
                try {
                    await axios.delete(`/destroy-photos/${id}`);
                    await fetchPhotos();
                } catch (error) {
                    console.error('Error deleting photo:', error);
                    alert('Wystąpił błąd podczas usuwania zdjęcia');
                }
            }
        };

        const updateSliderStatus = async (photo) => {
            try {
                await axios.post(`/update-photos/${photo.id}`, {
                    slider_1: photo.slider_1,
                    slider_2: photo.slider_2,
                    slider_tag: photo.slider_tag || null
                });
            } catch (error) {
                console.error('Error updating slider status:', error);
                alert('Wystąpił błąd podczas aktualizacji slidera');
            }
        };

        const closeModal = () => {
            showUploadModal.value = false;
            editingId.value = null;
            previewImage.value = null;
            photoForm.value = {
                application_id: '',
                slider_1: 0,
                slider_2: 0,
                slider_tag: '',
                is_gallery: 1,
                photo: null
            };
        };

        onMounted(() => {
            fetchPhotos();
            fetchServices();
        });

        return {
            photos,
            applications,
            showUploadModal,
            editingId,
            previewImage,
            photoForm,
            isSaving,
            getImageUrl,
            handleFileUpload,
            savePhoto,
            editPhoto,
            deletePhoto,
            updateSliderStatus,
            closeModal
        };
    }
};
</script>

<style scoped>
/* Your existing styles remain the same */
.about-us-section {
    padding: 120px 0;
    background-color: #F5F1EB;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.gallery-item {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.work-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.work-info {
    padding: 15px;
}

.work-info h3 {
    margin: 0 0 5px 0;
    font-size: 18px;
}

.work-actions {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.slider-checkbox {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-left: auto;
    white-space: nowrap;
}

.image-preview {
    margin: 15px 0;
}

.image-preview img {
    max-width: 100%;
    max-height: 200px;
    border-radius: 4px;
}

@media (max-width: 768px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}
</style>