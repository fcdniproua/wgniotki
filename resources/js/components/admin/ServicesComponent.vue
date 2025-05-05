<template>
    <section class="about-us-section">
        <div class="admin-section">
            <div class="section-header">
                <h2 class="bold">
                    <router-link class="menu-first" to="/admin/dashboard">Dashboard</router-link>
                    -> Usługi
                </h2>
                <button @click="showAddModal = true" class="btn-main">
                    <i class="fas fa-plus"></i> Dodaj usługę
                </button>
            </div>

            <div class="card-grid">
                <div v-for="service in services" :key="service.id" class="service-card">
                    <div class="card-icon" :style="{ background: service.color }">
                        <i :class="service.icon"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="bold">{{service.name}}</h3>
                        <span class="category">{{service.category}}</span>
                        <p>{{service.description}}</p>
                    </div>
                    <div class="card-actions">
                        <button @click="prepareEdit(service)" class="btn-icon">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button @click="deleteService(service.id)" class="btn-icon danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div v-if="showAddModal" class="modal-overlay" @click.self="closeModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="bold">{{editingId ? 'Edytuj usługę' : 'Nowa usługa'}}</h3>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nazwa usługi</label>
                            <input v-model="formData.name" type="text" class="form-input">
                        </div>

                        <div class="form-group">
                            <label>Opis</label>
                            <textarea v-model="formData.description" class="form-input" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button @click="closeModal" class="btn-secondary">Anuluj</button>
                        <button v-if="formData.id === null" @click="createService" class="btn-main">Zapisz</button>
                        <button v-else @click="updateService" class="btn-main">Zapisz</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import {onMounted, ref} from "vue";

export default {
    setup() {

        const services = ref([]);

        // const categories = ref(['IT', 'Budownictwo', 'Usługi kosmetyczne', 'Edukacja']);
        const showAddModal = ref(false);
        const isEditing = ref(false);
        const editingId = ref(null);
        const formData = ref({
            id: null,
            name: '',
            description: '',
        });

        const fetchServices = async () => {
            const response = await fetch('/get-services');
            services.value = await response.json();
        };

        const createService = async () => {
            console.log(formData);
            await fetch('/services', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    action: 'create',
                    ...formData.value
                })
            });
            await fetchServices();
            resetForm();
        };

        const updateService = async () => {
            await fetch('/services', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    action: 'update',
                    ...formData.value
                })
            });
            await fetchServices();
            resetForm();
        };

        const deleteService = async (id) => {
            if (confirm('Видалити цю послугу?')) {
                await fetch('/services', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        action: 'delete',
                        id: id
                    })
                });
                await fetchServices();
            }
        };

        const prepareEdit = (service) => {
            console.log(service)
            showAddModal.value = true;
            formData.value = {...service};
            isEditing.value = true;
        };

        const resetForm = () => {
            formData.value = {id: null, name: '', description: ''};
            isEditing.value = false;
            showAddModal.value = false;
        };

        onMounted(fetchServices);
        const closeModal = () => {
            showAddModal.value = false;
            editingId.value = null;
            formData.value = {
                id: null,
                name: '',
                description: ''
            }
        }

        return {
            services,
            formData,
            showAddModal,
            isEditing,
            editingId,
            createService,
            closeModal,
            updateService,
            prepareEdit,
            deleteService
        }
    },
}
</script>

<style scoped>
.about-us-section {
    padding: 120px 0;
    background-color: #F5F1EB;
}

.admin-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.admin-header h2 {
    font-size: 24px;
    color:  #1A1A1A;
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-main {
    background: #1A1A1A;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-main:hover {
    background: #1A1A1A;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.service-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    display: flex;
    transition: all 0.3s;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
}

.card-icon {
    width: 80px;
    min-width: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
}

.card-content {
    padding: 20px;
    flex-grow: 1;
}

.card-content h3 {
    margin: 0 0 5px 0;
    color:  #1A1A1A;
    font-size: 18px;
}

.category {
    display: inline-block;
    background: #f0f7ff;
    color: #3b82f6;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 12px;
    margin-bottom: 10px;
}

.card-actions {
    display: flex;
    flex-direction: column;
    padding: 15px;
    border-left: 1px solid #f0f4f8;
}

.btn-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: #F5F1EB;
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 5px 0;
    transition: all 0.2s;
}

.btn-icon:hover {
    background: #e2e8f0;
}

.btn-icon.danger {
    color: #ef4444;
}

.btn-icon.danger:hover {
    background: #fee2e2;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #475569;
}

.form-input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 16px;
    transition: all 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

textarea.form-input {
    min-height: 100px;
}

.btn-secondary {
    background: #f1f5f9;
    color: #475569;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: #e2e8f0;
}

@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .card-grid {
        grid-template-columns: 1fr;
    }

    .service-card {
        flex-direction: column;
    }

    .card-icon {
        width: 100%;
        height: 60px;
    }

    .card-actions {
        flex-direction: row;
        justify-content: flex-end;
        border-left: none;
        border-top: 1px solid #f0f4f8;
    }

}
</style>