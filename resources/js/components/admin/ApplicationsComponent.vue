<template>
    <section class="about-us-section">
        <div class="admin-section">
            <h2 class="bold">
                <router-link class="menu-first" to="/admin/dashboard">Dashboard</router-link> -> Dodaj nowe zgłoszenie
            </h2>
            <div class="add-form">
                <div class="form-group">
                    <label for="client">Klient:</label>
                    <select v-model="newApp.client_id" id="client" class="form-control" required>
                        <option value="">Wybierz klienta</option>
                        <option v-for="client in clients" :key="client.id" :value="client.id">
                            {{ client.name }} ({{ client.email }})
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="service">Marka. model:</label>
                    <input v-model="newApp.brand" id="service" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="service">Rocznik:</label>
                    <input v-model="newApp.model" id="service" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="message">Wiadomość:</label>
                    <textarea v-model="newApp.message" id="message" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Zdjęcia uszkodzeń (maks. 5):</label>
                    <div class="photos-upload">
                        <div v-for="(photo, index) in photoUploads" :key="index" class="photo-upload-item">
                            <div v-if="photo.preview" class="photo-preview">
                                <img :src="photo.preview" alt="Podgląd zdjęcia" />
                                <button @click="removePhoto(index)" class="remove-photo-btn">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div v-else class="photo-upload-placeholder">
                                <input type="file"
                                       :id="`photo-${index}`"
                                       @change="handlePhotoUpload($event, index)"
                                       accept="image/*"
                                       class="photo-input"
                                >
                                <label :for="`photo-${index}`" class="photo-upload-label">
                                    <i class="fas fa-plus"></i>
                                    <span>Dodaj zdjęcie</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <button @click="createApplication" class="submit-btn">Dodaj zgłoszenie</button>
            </div>
            <div class="section-header">
                <h2 class="bold">Zgłoszenia</h2>
                <div class="filters">
                    <select v-model="statusFilter" class="filter-select">
                        <option value="all">Wszystkie</option>
                        <option value="new">Nowe</option>
                        <option value="in_progress">W trakcie</option>
                        <option value="completed">Zakończone</option>
                    </select>
                </div>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imię i nazwisko</th>
                        <th>Marka</th>
                        <th>Rocznik</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Zdjęcia</th>
                        <th>Akcje</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="app in filteredApplications" :key="app.id">
                        <td data-label="ID">{{ app.id }}</td>
                        <td data-label="Imię i nazwisko">{{ app.client ? app.client.name : 'N/A' }}</td>
                        <td data-label="Marka">{{ app.brand ? app.brand : 'N/A' }}</td>
                        <td data-label="Marka">{{ app.model ? app.model : 'N/A' }}</td>
                        <td data-label="Data">{{ formatDate(app.created_at) }}</td>
                        <td data-label="Status">
                            <select v-model="app.status" @change="updateStatus(app)" class="status-select">
                                <option value="new">Nowe</option>
                                <option value="in_progress">W trakcie</option>
                                <option value="completed">Zakończone</option>
                            </select>
                        </td>
                        <td data-label="Zdjęcia">
                            <span v-if="app.photos && app.photos.length > 0" class="photo-count">
                                {{ app.photos.length }}
                                <i class="fas fa-camera"></i>
                            </span>
                            <span v-else>Brak</span>
                        </td>
                        <td data-label="Akcje" class="actions">
                            <button @click="viewDetails(app)" class="action-btn view-btn">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button @click="deleteApplication(app.id)" class="action-btn delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal szczegółów -->
            <div v-if="selectedApplication" class="modal-overlay" @click.self="selectedApplication = null">
                <div class="modal-content">
                    <h3 class="bold">Szczegóły zgłoszenia #{{ selectedApplication.id }}</h3>

                    <div class="details-grid">
                        <div class="detail-item">
                            <span class="detail-label">Imię i nazwisko:</span>
                            <span class="detail-value">{{ selectedApplication.client?.name }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">{{ selectedApplication.client?.email }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Telefon:</span>
                            <span class="detail-value">{{ selectedApplication.client?.phone }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Usługa:</span>
                            <span class="detail-value">{{ selectedApplication.service }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Model:</span>
                            <span class="detail-value">{{ selectedApplication.brand }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Rocznik:</span>
                            <span class="detail-value">{{ selectedApplication.model }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Data:</span>
                            <span class="detail-value">{{ formatDate(selectedApplication.created_at) }}</span>
                        </div>

                        <div class="detail-item full-width">
                            <span class="detail-label">Wiadomość:</span>
                            <p class="detail-value">{{ selectedApplication.message }}</p>
                        </div>

                        <div v-if="selectedApplication.photos && selectedApplication.photos.length > 0" class="detail-item full-width">
                            <span class="detail-label">Zdjęcia uszkodzeń:</span>
                            <div class="photos-gallery">
                                <div v-for="(photo, index) in selectedApplication.photos"
                                     :key="index"
                                     class="photo-item"
                                     @click="openPhotoGallery(index)">
                                    <img :src="getPhotoUrl(photo.path)"
                                         :alt="`Zdjęcie ${index + 1}`"
                                         class="gallery-thumbnail" />
                                    <div class="photo-overlay">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button @click="selectedApplication = null" class="close-btn">
                            Zamknij
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal podglądu zdjęcia -->
            <div v-if="photoGallery.active" class="gallery-overlay" @click.self="closePhotoGallery">
                <div class="gallery-container">
                    <button @click="closePhotoGallery" class="gallery-close-btn">
                        <i class="fas fa-times"></i>
                    </button>

                    <div class="main-photo">
                        <img :src="currentPhoto.url"
                             :alt="`Zdjęcie ${photoGallery.currentIndex + 1}`"
                             class="gallery-photo" />
                    </div>

                    <div class="gallery-nav">
                        <button @click="prevPhoto"
                                :disabled="photoGallery.currentIndex === 0"
                                class="nav-btn prev-btn">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <div class="photo-counter">
                            {{ photoGallery.currentIndex + 1 }} / {{ selectedApplication.photos.length }}
                        </div>

                        <button @click="nextPhoto"
                                :disabled="photoGallery.currentIndex === selectedApplication.photos.length - 1"
                                class="nav-btn next-btn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="thumbnails">
                        <div v-for="(photo, index) in selectedApplication.photos"
                             :key="index"
                             @click="changePhoto(index)"
                             :class="['thumbnail', { 'active': index === photoGallery.currentIndex }]">
                            <img :src="getPhotoUrl(photo.path)" :alt="`Thumbnail ${index + 1}`" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const applications = ref([]);
        const clients = ref([]);
        const statusFilter = ref('all');
        const selectedApplication = ref(null);
        const previewPhoto = ref(null);

        const photoUploads = ref([
            { file: null, preview: null },
            { file: null, preview: null },
            { file: null, preview: null },
            { file: null, preview: null },
            { file: null, preview: null }
        ]);

        const newApp = ref({
            client_id: '',
            service: 1,
            brand: '',
            model: '',
            message: '',
            status: 'new',
            photos: []
        });

        const photoGallery = ref({
            active: false,
            currentIndex: 0
        });

        const getPhotoUrl = (path) => {
            return `/storage/${path.replace('public/', '')}`;
        };

        const handlePhotoUpload = (event, index) => {
            const file = event.target.files[0];
            if (!file) return;

            if (file.size > 5 * 1024 * 1024) {
                alert('Zdjęcie jest za duże. Maksymalny rozmiar to 5MB.');
                return;
            }

            if (!file.type.startsWith('image/')) {
                alert('Wybrany plik nie jest zdjęciem.');
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                photoUploads.value[index].file = file;
                photoUploads.value[index].preview = e.target.result;
            };
            reader.readAsDataURL(file);
        };

        const removePhoto = (index) => {
            photoUploads.value[index] = { file: null, preview: null };
        };

        const fetchApplications = async () => {
            try {
                const response = await axios.get('/get-applications', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                applications.value = response.data;
            } catch (error) {
                console.error('Error fetching applications:', error);
                alert('Nie udało się pobrać zgłoszeń');
            }
        };

        const fetchClients = async () => {
            try {
                const response = await axios.get('/get-clients');
                clients.value = response.data;
            } catch (error) {
                console.error('Error fetching clients:', error);
                alert('Nie udało się pobrać klientów');
            }
        };

        const filteredApplications = computed(() => {
            if (statusFilter.value === 'all') return applications.value;
            return applications.value.filter(app => app.status === statusFilter.value);
        });

        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            return new Date(dateString).toLocaleDateString('pl-PL');
        };

        const viewDetails = (app) => {
            selectedApplication.value = app;
        };

        const updateStatus = async (app) => {
            try {
                await axios.put(`/update-applications/${app.id}`, {
                    status: app.status
                });
            } catch (error) {
                console.error('Error updating status:', error);
                alert('Nie udało się zaktualizować statusu');
                fetchApplications();
            }
        };

        const createApplication = async () => {
            if (!newApp.value.client_id || !newApp.value.service) {
                alert('Wypełnij wymagane pola');
                return;
            }

            try {
                const formData = new FormData();
                formData.append('client_id', newApp.value.client_id);
                formData.append('service', 1);
                formData.append('brand', newApp.value.brand);
                formData.append('model', newApp.value.model);
                formData.append('message', newApp.value.message);
                formData.append('status', newApp.value.status);

                photoUploads.value.forEach((item, index) => {
                    if (item.file) {
                        formData.append(`photos[${index}]`, item.file);
                    }
                });

                await axios.post('/save-applications', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                alert('Zgłoszenie dodane');
                resetForm();
                fetchApplications();
            } catch (error) {
                console.error('Error creating application:', error);
                alert('Nie udało się dodać zgłoszenia');
            }
        };

        const resetForm = () => {
            newApp.value = {
                client_id: '',
                service: 1,
                message: '',
                status: 'new'
            };
            photoUploads.value.forEach((item, index) => {
                photoUploads.value[index] = { file: null, preview: null };
            });
        };

        const deleteApplication = async (id) => {
            if (confirm('Czy na pewno chcesz usunąć to zgłoszenie?')) {
                try {
                    await axios.delete(`/destroy-applications/${id}`);
                    applications.value = applications.value.filter(app => app.id !== id);
                } catch (error) {
                    console.error('Error deleting application:', error);
                    alert('Nie udało się usunąć zgłoszenia');
                }
            }
        };

        const currentPhoto = computed(() => {
            if (selectedApplication.value && selectedApplication.value.photos) {
                return {
                    url: getPhotoUrl(selectedApplication.value.photos[photoGallery.value.currentIndex].path)
                };
            }
            return null;
        });

        const openPhotoGallery = (index) => {
            photoGallery.value = {
                active: true,
                currentIndex: index
            };
        };

        const closePhotoGallery = () => {
            photoGallery.value.active = false;
        };

        const prevPhoto = () => {
            if (photoGallery.value.currentIndex > 0) {
                photoGallery.value.currentIndex--;
            }
        };

        const nextPhoto = () => {
            if (selectedApplication.value.photos &&
                photoGallery.value.currentIndex < selectedApplication.value.photos.length - 1) {
                photoGallery.value.currentIndex++;
            }
        };

        const changePhoto = (index) => {
            photoGallery.value.currentIndex = index;
        };

        onMounted(() => {
            fetchApplications();
            fetchClients();
        });

        return {
            applications,
            clients,
            statusFilter,
            filteredApplications,
            selectedApplication,
            newApp,
            photoUploads,
            photoGallery,
            currentPhoto,
            getPhotoUrl,
            formatDate,
            viewDetails,
            updateStatus,
            createApplication,
            deleteApplication,
            handlePhotoUpload,
            removePhoto,
            openPhotoGallery,
            closePhotoGallery,
            prevPhoto,
            nextPhoto,
            changePhoto
        };
    }
};
</script>

<style scoped>
.about-us-section {
    padding: 120px 0;
    background-color: #F5F1EB;
}

.admin-section {
    margin: 0 auto;
    padding: 0 20px;
}

.add-form {
    margin-bottom: 40px;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.filters {
    display: flex;
    gap: 10px;
}

.filter-select, .status-select {
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px solid #e2e8f0;
    font-size: 14px;
}

.table-container {
    overflow-x: auto;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 20px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.data-table th {
    background-color: #f7fafc;
    color: #4a5568;
    font-weight: 600;
    text-align: left;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
}

.data-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: middle;
}

.data-table tr:hover {
    background-color: #F5F1EB;
}

.actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 4px;
    background: transparent;
    cursor: pointer;
    transition: all 0.2s;
}

.action-btn:hover {
    transform: scale(1.1);
}

.view-btn {
    color: #3182ce;
}

.view-btn:hover {
    background-color: rgba(49, 130, 206, 0.1);
}

.delete-btn {
    color: #e53e3e;
}

.delete-btn:hover {
    background-color: rgba(229, 62, 62, 0.1);
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #4a5568;
}

.form-control {
    width: 100%;
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px solid #e2e8f0;
    font-size: 14px;
}

textarea.form-control {
    min-height: 100px;
}

.submit-btn {
    background: #38a169;
    color: white;
    padding: 10px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.2s;
}

.submit-btn:hover {
    background: #2f855a;
}

.photos-upload {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

.photo-upload-item {
    width: 120px;
    height: 120px;
    border: 2px dashed #cbd5e0;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
}

.photo-upload-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.photo-input {
    display: none;
}

.photo-upload-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    cursor: pointer;
    color: #718096;
    text-align: center;
    font-size: 12px;
}

.photo-upload-label i {
    font-size: 24px;
    margin-bottom: 5px;
}

.photo-preview {
    width: 100%;
    height: 100%;
    position: relative;
}

.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.remove-photo-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    border-radius: 8px;
    padding: 20px;
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin: 20px 0;
}

.detail-item {
    display: flex;
    flex-direction: column;
}

.detail-item.full-width {
    grid-column: span 2;
}

.detail-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 5px;
}

.detail-value {
    padding: 8px;
    background: #f7fafc;
    border-radius: 4px;
}

.close-btn {
    background:  #1A1A1A;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.photos-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 10px;
    margin-top: 10px;
}

.photo-item {
    position: relative;
    border-radius: 4px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s;
    aspect-ratio: 1/1;
}

.gallery-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.photo-item:hover .photo-overlay {
    opacity: 1;
}

.photo-overlay i {
    color: white;
    font-size: 24px;
}

.gallery-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2000;
    padding: 20px;
}

.gallery-container {
    width: 100%;
    max-width: 1200px;
    position: relative;
}

.gallery-close-btn {
    position: absolute;
    top: -40px;
    right: 0;
    background: transparent;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    z-index: 10;
}

.main-photo {
    width: 100%;
    height: 70vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}

.gallery-photo {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.gallery-nav {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    margin-bottom: 20px;
}

.nav-btn {
    background: transparent;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 10px;
    transition: all 0.3s;
}

.nav-btn:hover {
    transform: scale(1.2);
}

.nav-btn:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.photo-counter {
    color: white;
    font-size: 18px;
    min-width: 60px;
    text-align: center;
}

.thumbnails {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
    max-height: 100px;
    overflow-x: auto;
    padding: 10px 0;
}

.thumbnail {
    width: 60px;
    height: 60px;
    border: 2px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s;
}

.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.thumbnail:hover {
    transform: scale(1.1);
}

.thumbnail.active {
    border-color: #3182ce;
}

.photo-count {
    display: flex;
    align-items: center;
    gap: 5px;
}

@media (max-width: 768px) {
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .data-table {
        display: block;
    }

    .data-table thead {
        display: none;
    }

    .data-table tr {
        display: block;
        margin-bottom: 15px;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
    }

    .data-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        text-align: right;
    }

    .data-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #4a5568;
        margin-right: 10px;
    }

    .details-grid {
        grid-template-columns: 1fr;
    }

    .detail-item.full-width {
        grid-column: span 1;
    }

    .photos-upload {
        flex-direction: column;
    }

    .photo-upload-item {
        width: 100%;
        height: 150px;
    }

    .main-photo {
        height: 50vh;
    }

    .gallery-nav {
        gap: 15px;
    }

    .thumbnail {
        width: 40px;
        height: 40px;
    }

    input, textarea {
        width: 92%!important;
    }
}

input, textarea {
    width: 98%!important;
}
</style>