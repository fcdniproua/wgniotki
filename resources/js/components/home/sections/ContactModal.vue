<template>
    <div class="modal-overlay" @click.self="$emit('close')">
        <div class="modal-container">
            <div class="modal-content">
                <h2 class="modal-title">Skontaktuj się z nami</h2>

                <form @submit.prevent="submitForm" class="contact-form">
                    <div class="form-group">
                        <label for="name">Imię i nazwisko</label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            class="form-input"
                        >
                    </div>

                    <div class="form-group">
                        <label for="phone">Numer telefonu</label>
                        <input
                            id="phone"
                            v-model="form.phone"
                            type="tel"
                            required
                            class="form-input"
                        >
                    </div>

                    <div class="form-group">
                        <label for="service">Usługa</label>
                        <select
                            id="service"
                            v-model="form.service"
                            class="form-input"
                        >
                            <option value="">Wybierz usługę</option>
                            <option v-for="(service, index) in services" :key="index" :value="service">
                                {{ service }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Opis problemu</label>
                        <textarea
                            id="message"
                            v-model="form.message"
                            rows="4"
                            class="form-input"
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label>Załącz zdjęcia (max 3)</label>
                        <div class="file-upload-container">
                            <input
                                type="file"
                                ref="fileInput"
                                accept="image/*"
                                multiple
                                @change="handleFileUpload"
                                style="display: none"
                            >
                            <button
                                type="button"
                                @click="$refs.fileInput.click()"
                                class="upload-btn"
                                :disabled="uploadedFiles.length >= 3"
                            >
                                <i class="fas fa-cloud-upload-alt"></i> Wybierz pliki
                            </button>
                            <div class="file-list" v-if="uploadedFiles.length > 0">
                                <div v-for="(file, index) in uploadedFiles" :key="index" class="file-item">
                                    <div class="file-preview">
                                        <div class="file-icon">
                                            <i class="fas fa-image"></i>
                                        </div>
                                        <span class="file-name">{{ file.name }}</span>
                                    </div>
                                    <button type="button" @click="removeFile(index)" class="remove-file">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="file-counter" :class="{'warning': uploadedFiles.length >= 3}">
                                {{ uploadedFiles.length }}/3 zdjęć
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            Wyślij zgłoszenie
                        </button>
                        <button type="button" @click="$emit('close')" class="btn-cancel">
                            Zamknij
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: '',
                phone: '',
                service: '',
                message: ''
            },
            services: [
                'Szkody parkingowe',
                'Powypadkowe',
                'Komunikacyjne',
                'Uszkodzenia gradowe'
            ],
            uploadedFiles: []
        }
    },
    methods: {
        handleFileUpload(event) {
            const files = Array.from(event.target.files)
            const remainingSlots = 3 - this.uploadedFiles.length

            if (files.length > remainingSlots) {
                alert(`Możesz dodać tylko ${remainingSlots} więcej zdjęć.`)
                return
            }

            this.uploadedFiles = [...this.uploadedFiles, ...files.slice(0, remainingSlots)]
        },
        removeFile(index) {
            this.uploadedFiles.splice(index, 1)
        },
        submitForm() {
            // Заглушка для відправки форми
            const formData = new FormData()

            // Додаємо дані форми
            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key])
            })

            // Додаємо файли
            this.uploadedFiles.forEach((file, index) => {
                formData.append(`photos[${index}]`, file)
            })

            console.log('Form data:', formData) // Для перевірки в консолі

            alert(`Dziękujemy za zgłoszenie, ${this.form.name}! Zdjęcia: ${this.uploadedFiles.length}`)
            this.resetForm()
            this.$emit('close')
        },
        resetForm() {
            this.form = {
                name: '',
                phone: '',
                service: '',
                message: ''
            }
            this.uploadedFiles = []
        }
    }
}
</script>

<style scoped>

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
    animation: fadeIn 0.3s ease-out;
}

.modal-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    animation: slideUp 0.3s ease-out;
}

.modal-content {
    padding: 2rem;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 1.5rem;
    text-align: center;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-weight: 500;
    color: #555;
}

.form-input {
    padding: 0.8rem 1rem;
    border: 1px solid #041c32;
    border-radius: 6px;
    font-size: 1rem;
    transition: all 0.3s;
    background-color: rgba(4, 28, 50, 0.03);
}

.form-input:focus {
    outline: none;
    border-color: #041c32;
    box-shadow: 0 0 0 2px rgba(4, 28, 50, 0.2);
}

.form-input:hover {
    border-color: #e67e22;
}

textarea.form-input {
    min-height: 100px;
    resize: vertical;
}

select.form-input {
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1em;
}

/* Стилі для завантаження файлів */
.file-upload-container {
    margin-top: 0.5rem;
}

.upload-btn {
    background-color: #041c32;
    color: white;
    border: none;
    padding: 0.6rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: background-color 0.3s;
}

.upload-btn:hover {
    background-color: #e67e22;
}

.upload-btn:disabled {
    background-color: #777;
    cursor: not-allowed;
}

.file-list {
    margin-top: 0.8rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    border: 1px solid #041c32;
    border-radius: 6px;
    padding: 0.5rem;
    background-color: rgba(4, 28, 50, 0.03);
}

.file-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem;
    background-color: white;
    border-radius: 4px;
    border: 1px solid #e0e0e0;
}

.file-preview {
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.file-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #041c32;
}

.file-name {
    font-size: 0.9rem;
    color: #555;
    max-width: 250px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.remove-file {
    background: none;
    border: none;
    color: #777;
    cursor: pointer;
    padding: 0.2rem;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.remove-file:hover {
    color: white;
    background-color: #e67e22;
}

.file-counter {
    font-size: 0.85rem;
    color: #555;
    margin-top: 0.5rem;
    display: flex;
    justify-content: flex-end;
}

.file-counter.warning {
    color: #e67e22;
    font-weight: 500;
}

/* Кнопки форми */
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.btn-submit, .btn-cancel {
    flex: 1;
    padding: 0.8rem;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-submit {
    background-color: #e67e22;
    color: white;
    border: none;
}

.btn-submit:hover {
    background-color: #d35400;
}

.btn-cancel {
    background-color: white;
    color: #555;
    border: 1px solid #ddd;
}

.btn-cancel:hover {
    background-color: #f5f5f5;
}

/* Анімації */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@media (max-width: 480px) {
    .modal-container {
        width: 95%;
    }

    .modal-content {
        padding: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .file-name {
        max-width: 180px;
    }
}
</style>