<template>
    <section class="about-us-section">
        <div class="clients-container">
            <div class="section-header">
                <h2 class="bold"> <router-link class="menu-first" to="/admin/dashboard">Dashboard</router-link> -> Klienci</h2>
                <button @click="openAddModal" class="add-client-btn">
                    <i class="fas fa-plus"></i> Dodaj klienta
                </button>
            </div>
            <!-- Tabela klientów -->
            <div class="table-container">
                <div class="table-header">
                    <h3 class="bold">Lista klientów</h3>
                    <div class="search-container">
                        <input v-model="searchQuery" type="text" placeholder="Szukaj klienta..." class="search-input">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imię i nazwisko</th>
                            <th>Email</th>
                            <th>Telefon</th>
                            <th class="actions-column">Akcje</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="client in filteredClients" :key="client.id">
                            <td data-label="ID">{{ client.id }}</td>
                            <td data-label="Imię i nazwisko">{{ client.name }}</td>
                            <td data-label="Email">
                                <a :href="`mailto:${client.email}`">{{ client.email }}</a>
                            </td>
                            <td data-label="Telefon">
                                <a v-if="client.phone" :href="`tel:${client.phone}`">{{ client.phone }}</a>
                                <span v-else>Brak</span>
                            </td>
                            <td data-label="Akcje" class="actions">
                                <button @click="openEditModal(client)" class="action-btn edit-btn" title="Edytuj">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button @click="confirmDelete(client.id)" class="action-btn delete-btn" title="Usuń">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="filteredClients.length === 0">
                            <td colspan="5" class="no-results">Brak wyników wyszukiwania</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal dodawania/edycji klienta -->

        <div v-if="showClientModal" class="modal-overlay" @click.self="closeModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button class="modal-close-btn" @click="closeModal">
                        <i class="fas fa-times"></i>
                    </button>

                    <h3 class="bold">{{ editMode ? 'Edytuj klienta' : 'Dodaj nowego klienta' }}</h3>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Imię i nazwisko:</label>
                            <input v-model="client.name" id="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input v-model="client.email" type="email" id="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Telefon:</label>
                            <input v-model="client.phone" id="phone" class="form-control">
                        </div>
                    </div>

                    <div v-if="message" :class="['alert', message.type === 'success' ? 'alert-success' : 'alert-error']">
                        <i :class="['alert-icon', message.type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle']"></i>
                        {{ message.text }}
                    </div>

                    <div class="modal-actions">
                        <button @click="saveClient" class="btn submit-btn">
                            {{ editMode ? 'Zapisz zmiany' : 'Dodaj klienta' }}
                        </button>
                        <button @click="closeModal" class="btn cancel-btn">
                            Anuluj
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal potwierdzenia usunięcia -->
        <div v-if="showDeleteModal" class="modal-overlay">
            <div class="modal-dialog">
                <div class="modal-content">
                    <h3 class="bold">Potwierdzenie usunięcia</h3>
                    <p>Czy na pewno chcesz usunąć tego klienta?</p>
                    <div class="modal-actions">
                        <button @click="deleteClient" class="btn confirm-btn">Tak, usuń</button>
                        <button @click="showDeleteModal = false" class="btn cancel-btn">Anuluj</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { computed, onMounted, ref } from 'vue';
import axios from 'axios';

export default {
    emits: ['client-created'],

    setup(props, { emit }) {
        const clients = ref([]);
        const searchQuery = ref('');
        const editMode = ref(false);
        const client = ref({
            id: null,
            name: '',
            email: '',
            phone: ''
        });
        const message = ref(null);
        const showDeleteModal = ref(false);
        const showClientModal = ref(false);
        const clientToDelete = ref(null);

        const fetchClients = async () => {
            try {
                const response = await axios.get('/get-clients');
                clients.value = response.data;
            } catch (error) {
                showMessage('error', 'Nie udało się pobrać listy klientów');
            }
        };

        const filteredClients = computed(() => {
            if (!searchQuery.value) return clients.value;
            const query = searchQuery.value.toLowerCase();
            return clients.value.filter(c =>
                c.name.toLowerCase().includes(query) ||
                c.email.toLowerCase().includes(query) ||
                (c.phone && c.phone.includes(query))
            );
        });

        const openAddModal = () => {
            editMode.value = false;
            client.value = { name: '', email: '', phone: '' };
            showClientModal.value = true;
        };

        const openEditModal = (clientData) => {
            editMode.value = true;
            client.value = { ...clientData };
            showClientModal.value = true;
        };

        const closeModal = () => {
            showClientModal.value = false;
            message.value = null;
        };

        const confirmDelete = (id) => {
            clientToDelete.value = id;
            showDeleteModal.value = true;
        };

        const deleteClient = async () => {
            try {
                await axios.delete(`/destroy-clients/${clientToDelete.value}`);
                clients.value = clients.value.filter(c => c.id !== clientToDelete.value);
                showMessage('success', 'Klient został usunięty');
            } catch (error) {
                showMessage('error', 'Nie udało się usunąć klienta');
            } finally {
                showDeleteModal.value = false;
            }
        };

        const saveClient = async () => {
            if (!client.value.name || !client.value.email) {
                showMessage('error', 'Wypełnij wymagane pola');
                return;
            }

            try {
                const url = editMode.value ? `/update-clients/${client.value.id}` : '/save-clients';
                const method = editMode.value ? 'put' : 'post';

                const response = await axios[method](url, client.value);

                if (editMode.value) {
                    const index = clients.value.findIndex(c => c.id === client.value.id);
                    clients.value[index] = response.data;
                } else {
                    clients.value.unshift(response.data);
                }

                showMessage('success', editMode.value ? 'Dane klienta zaktualizowane' : 'Nowy klient dodany');
                setTimeout(closeModal, 1500);
            } catch (error) {
                const errorMsg = error.response?.data?.message || 'Wystąpił błąd podczas zapisywania';
                showMessage('error', errorMsg);
            }
        };

        const showMessage = (type, text) => {
            message.value = { type, text };
            setTimeout(() => message.value = null, 5000);
        };

        onMounted(fetchClients);

        return {
            clients,
            searchQuery,
            filteredClients,
            client,
            editMode,
            message,
            showDeleteModal,
            showClientModal,
            openAddModal,
            openEditModal,
            closeModal,
            confirmDelete,
            deleteClient,
            saveClient
        };
    }
};
</script>

<style scoped>

.about-us-section {
    padding: 120px 0;
    background-color: #f8fafc;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding: 0 15px;
}

.section-header h2 {
    font-size: 2rem;
    color: #2d3748;
    font-weight: 600;
}

.add-client-btn {
    background-color: #3182ce;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.add-client-btn:hover {
    background-color: #2c5282;
}

.table-container {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.table-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.table-header h3 {
    font-size: 1.25rem;
    color: #2d3748;
}

.search-container {
    position: relative;
}

.search-input {
    width: 77vw;
    padding: 0.5rem 1rem 0.5rem 2.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: border-color 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}

.data-table th {
    background-color: #f7fafc;
    color: #4a5568;
    font-weight: 600;
    text-align: left;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.data-table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: middle;
}

.data-table tr:hover {
    background-color: #f8fafc;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 2rem;
    height: 2rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 0.25rem;
    background: transparent;
    cursor: pointer;
    transition: all 0.2s;
}

.action-btn:hover {
    transform: scale(1.1);
}

.edit-btn {
    color: #3182ce;
}

.edit-btn:hover {
    background-color: rgba(49, 130, 206, 0.1);
}

.delete-btn {
    color: #e53e3e;
}

.delete-btn:hover {
    background-color: rgba(229, 62, 62, 0.1);
}

.no-results {
    text-align: center;
    padding: 2rem;
    color: #718096;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    backdrop-filter: blur(2px);
}

.modal-dialog {
    width: 100%;
    max-width: 500px;
    animation: modalFadeIn 0.3s ease-out;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-content {
    background: white;
    border-radius: 0.5rem;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    position: relative;
}

.modal-close-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    font-size: 1.25rem;
    color: #718096;
    cursor: pointer;
    transition: color 0.2s;
}

.modal-close-btn:hover {
    color: #e53e3e;
}

.modal-content h3 {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: #2d3748;
    text-align: center;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: #4a5568;
    font-size: 0.875rem;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
}

.alert {
    padding: 0.75rem 1rem;
    border-radius: 0.375rem;
    margin: 1rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-success {
    background-color: #f0fff4;
    color: #2f855a;
    border: 1px solid #c6f6d5;
}

.alert-error {
    background-color: #fff5f5;
    color: #c53030;
    border: 1px solid #fed7d7;
}

.alert-icon {
    font-size: 1rem;
}

.modal-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 1.5rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    min-width: 120px;
}

.submit-btn {
    background-color: #3182ce;
    color: white;
}

.submit-btn:hover {
    background-color: #2c5282;
}

.cancel-btn {
    background-color: #e2e8f0;
    color: #4a5568;
}

.cancel-btn:hover {
    background-color: #cbd5e0;
}

.confirm-btn {
    background-color: #e53e3e;
    color: white;
}

.confirm-btn:hover {
    background-color: #c53030;
}

.table-container {
    width: 100%;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
    table-layout: fixed;
}

.data-table th,
.data-table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    text-align: left;
    word-wrap: break-word;
}

.data-table th {
    background-color: #f7fafc;
    color: #4a5568;
    font-weight: 600;
}
.data-table tr:hover {
    background-color: #f8fafc;
}

/* Колонки з фіксованими ширинами */
.data-table th:nth-child(1) { width: 8%; }  /* ID */
.data-table th:nth-child(2) { width: 25%; } /* Imię i nazwisko */
.data-table th:nth-child(3) { width: 30%; } /* Email */
.data-table th:nth-child(4) { width: 20%; } /* Telefon */
.data-table th:nth-child(5) { width: 17%; } /* Akcje */

.actions-column {
    text-align: right;
}

/* Адаптивність для мобільних */
@media (max-width: 768px) {
    .clients-section {
        padding: 0;
    }

    .table-container {
        padding: 10px;
    }

    .data-table {
        display: block;
    }

    .data-table thead {
        display: none;
    }

    .data-table tr {
        display: block;
        width: 93vw;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
    }

    .data-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        text-align: right;
    }

    .data-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #4a5568;
        margin-right: 1rem;
    }


    /* Скидаємо фіксовані ширини для мобільних */
    .data-table th:nth-child(1),
    .data-table th:nth-child(2),
    .data-table th:nth-child(3),
    .data-table th:nth-child(4),
    .data-table th:nth-child(5) {
        width: auto;
    }

    .modal-content {
        width: 95%;
        padding: 15px;
    }
}
</style>