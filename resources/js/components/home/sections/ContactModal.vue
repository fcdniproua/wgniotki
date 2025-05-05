<template>
    <div class="modal-overlay" @click.self="$emit('close')">
        <div class="modal-container">
            <div class="modal-header">
                <h2 class="modal-title bold">Wyceń usługę</h2>
            </div>

            <div class="modal-content">
                <form @submit.prevent="submitForm" class="contact-form">
                    <div class="form-scrollable">
                        <div class="form-group">
                            <label>Załącz zdjęcia (max 5)</label>
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
                                    :disabled="uploadedFiles.length >= 5"
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
                                <div class="file-counter" :class="{'warning': uploadedFiles.length >= 5}">
                                    {{ uploadedFiles.length }}/5 zdjęć
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="model-group">
                                <div class="model">
                                    <label for="phone">Marka, model auta</label>
                                    <input
                                        id="brand"
                                        v-model="form.brand"
                                        type="text"
                                        placeholder="Audi A8"
                                        class="form-input"
                                    >
                                </div>
                                <div class="model">
                                    <label for="phone">Rocznik</label>
                                    <input
                                        id="model"
                                        v-model="form.model"
                                        type="text"
                                        placeholder="2020"
                                        class="form-input"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Numer telefonu</label>
                            <input
                                @input="checkPhone"
                                id="phone"
                                v-model="form.phone"
                                type="tel"
                                required
                                placeholder="123 456 789"
                                class="form-input"
                            >
                            <span style="color:red;" class="help-text"></span>
                        </div>

                        <div class="form-group">
                            <label for="phone">E-mail</label>
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                placeholder="exapmle@example.com"
                                required
                                class="form-input"
                            >
                        </div>

                        <div class="form-group">
                            <label for="name">Imię i nazwisko</label>
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                placeholder="Jakub Blaszczykowski"
                                required
                                class="form-input"
                            >
                        </div>



                        <div class="form-group">
                            <label for="message">Opis problemu</label>
                            <textarea
                                id="message"
                                v-model="form.message"
                                rows="4"
                                placeholder="Coś chcesz dodać?"
                                class="form-input"
                            ></textarea>
                        </div>
                    </div>
                    <label class="checkbox-label">
                        <input type="checkbox" name="rodo"  v-model="form.check">
                        Wyrażam zgodę na przetwarzanie moich danych osobowych zgodnie z <a href="/polityka-prywatnosci" target="_blank">Polityką prywatności</a> w celu obsługi mojego zapytania.
                    </label>
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            Wyślij
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
import { ref, onMounted } from 'vue'
import axios from "axios";

export default {
    setup() {
        const services = ref([])
        const form = ref({
            name: '',
            phone: '',
            email: '',
            brand: '',
            check: '',
            marka: '',
            model: '',
            service: '',
            message: ''
        })
        const uploadedFiles = ref([])

        const fetchServices = async () => {
            try {
                const response = await fetch('/get-services')
                services.value = await response.json()
                form.value.service = 1;
            } catch (error) {
                console.error('Error fetching services:', error)
            }
        }

        const handleFileUpload = (event) => {
            const files = Array.from(event.target.files)
            const remainingSlots = 5 - uploadedFiles.value.length

            if (files.length > remainingSlots) {
                alert(`Możesz dodać tylko ${remainingSlots} więcej zdjęć.`)
                return
            }

            uploadedFiles.value = [...uploadedFiles.value, ...files.slice(0, remainingSlots)]
        }

        const removeFile = (index) => {
            uploadedFiles.value.splice(index, 1)
        }

        // Обробка відправки форми
        const submitForm = async () => {
            if (!form.value.check) {
                alert('Aby wysłać formularz, musisz wyrazić zgodę na przetwarzanie danych osobowych zgodnie z Polityką prywatności')
                return
            }
            // Валідація обов'язкових полів
            if (!form.value.service || !form.value.email || !form.value.name || !form.value.phone) {
                alert('Wypełnij wymagane pola')
                return
            }

            try {
                const formData = new FormData()

                Object.keys(form.value).forEach(key => {
                    if (form.value[key] !== null && form.value[key] !== undefined) {
                        formData.append(key, form.value[key])
                    }
                })
                form.value.brand = form.value.brand + ' ' + form.value.marka
                formData.append('brand', form.value.brand)
                formData.append('status', 'new')
                ;[...uploadedFiles.value].forEach((item, index) => {
                    const file = item.file || item
                    if (file) {
                        formData.append(`photos[${index}]`, file)
                    }
                })

                // Відправка на сервер
                await axios.post('/send-application', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })

                alert('Dzięki za wypełnienie formularza!')
                resetForm()
                // alert(`Dziękujemy za zgłoszenie, ${form.value.name}! Zdjęcia: ${uploadedFiles.value.length}`)

            } catch (error) {
                console.error('Błąd podczas wysyłania zgłoszenia:', error)
                alert('Nie udało się wysłać zgłoszenia')
            }
        }

        const resetForm = () => {
            form.value = {
                name: '',
                phone: '',
                email: '',
                brand: '',
                marka: '',
                model: '',
                service: '',
                message: ''
            }
            uploadedFiles.value = []
        }

        const checkPhone = () => {
            if (form.value.phone.length !== 9) {
                let block = document.querySelector('.help-text');
                block.textContent = 'podaj prawidłowy numer telefonu!';
            } else {
                let block = document.querySelector('.help-text');
                block.textContent = '';
            }
        }

        onMounted(() => {
            fetchServices()
        })

        return {
            services,
            form,
            uploadedFiles,
            checkPhone,
            handleFileUpload,
            removeFile,
            submitForm,
            resetForm
        }
    }
}
</script>

<style scoped>
.checkbox-label {
    padding: 0 15px;
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
    padding: 20px;
    box-sizing: border-box;
    -webkit-overflow-scrolling: touch; /* Для плавного скролла на iOS */
}

.section-subtitle {
    font-size: 0.8rem;
    color: #64748b;
    text-align: center;
    margin-bottom: 3rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}


.modal-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    width: 100%;
    max-width: 500px;
    max-height: calc(100vh - 70px); /* Враховуємо padding overlay */
    display: flex;
    flex-direction: column;
    overflow: hidden; /* Важливо для правильного скролла */
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid #eee;
    flex-shrink: 0; /* Забороняє стискання заголовка */
}

.modal-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #DAA520;
    margin: 0;
    text-align: center;
}

.modal-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 0; /* Фікс для Firefox */
    padding: 25px 0;
    width: 100%;
}

.contact-form {
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 0; /* Фікс для Firefox */
}

.form-scrollable {
    flex: 1;
    padding: 0 20px;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch; /* Плавний скролл на iOS */
    overscroll-behavior: contain; /* Запобігає скроллу батьківського елемента */
}

.form-actions {
    padding: 15px 20px;
    background: white;
    border-top: 1px solid #eee;
    flex-shrink: 0; /* Забороняє стискання кнопок */
    display: flex;
    gap: 1rem;
}


.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1.2rem;
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
    border-color: #DAA520;
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
    background-color: #DAA520;
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
    background-color: #DAA520;
}

.file-counter {
    font-size: 0.85rem;
    color: #555;
    margin-top: 0.5rem;
    display: flex;
    justify-content: flex-end;
}

.file-counter.warning {
    color: #DAA520;
    font-weight: 500;
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
    background-color: #DAA520;
    color: white;
    border: none;
}

.btn-submit:hover {
    background-color: #DAA520;
}

.btn-cancel {
    background-color: white;
    color: #555;
    border: 1px solid #ddd;
}

.btn-cancel:hover {
    background-color: #f5f5f5;
}

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


/* Оптимізація для мобільних пристроїв */
@media (max-width: 480px) {
    .modal-overlay {
        padding: 10px;
        align-items: flex-end; /* Для кращого вигляду на мобільних */
    }

    .modal-container {
        max-height: calc(100vh - 70px);
        border-radius: 8px 8px 0 0;
    }

    .form-actions {
        flex-direction: column;
        gap: 0.5rem;
        padding: 10px;
    }

    .btn-submit, .btn-cancel {
        width: 100%;
    }

    .form-scrollable {
        padding: 0 10px;
    }

    .modal-header {
        padding: 15px 10px;
    }
}

/* Фікс для iOS, щоб клавіатура не зламала макет */
/* Специфічні стилі для iOS */
@supports (-webkit-touch-callout: none) {
    .modal-overlay {
        align-items: flex-start;
        padding-top: 20px;
        padding-bottom: 20px;
        -webkit-overflow-scrolling: touch; /* Плавний скролл */
    }

    .modal-container {
        max-height: 90vh;
        height: auto;
        border-radius: 12px;
        overflow: hidden;
    }

    .form-scrollable {
        padding-bottom: 15px;
    }

    /* Фікс для віртуальної клавіатури */
    .form-input {
        font-size: 16px; /* Запобігає масштабуванню */
    }

    /* Кнопки більшого розміру для iOS */
    .btn-submit,
    .btn-cancel {
        padding: 12px;
        min-height: 44px; /* Мінімальний розмір для iOS */
    }

    /* Фікс для input type="date" */
    input[type="date"] {
        min-height: 44px;
    }
}

.model-group {
    display: flex;
    flex-direction: row;
}
.model {
    display: flex;
    flex-direction: column;
}

.model input {
    width: 70%;
}

@media (max-width: 480px) {
    .modal-container {
        width: 95%;
    }

    .form-actions {
        flex-direction: column;
    }

    .file-name {
        max-width: 180px;
    }
}
</style>