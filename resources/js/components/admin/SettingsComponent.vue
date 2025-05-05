<template>
    <section class="about-us-section">
        <div class="admin-section">
            <h2 class="bold"> <router-link class="menu-first" to="/admin/dashboard">Dashboard</router-link> -> Ustawienia</h2>

            <div class="settings-tabs">
                <button
                    v-for="tab in tabs"
                    :key="tab.id"
                    @click="currentTab = tab.id"
                    :class="{ 'active': currentTab === tab.id }"
                    class="tab-btn"
                >
                    {{ tab.label }}
                </button>
            </div>

            <div class="tab-content">
                <!-- Kontakt -->
                <div v-if="currentTab === 'contact'" class="settings-form">
                    <div class="form-group">
                        <label>Email kontaktowy:</label>
                        <input v-model="settings.contactEmail" type="email" class="form-input">
                    </div>

                    <div class="form-group">
                        <label>Telefon:</label>
                        <input v-model="settings.contactPhone" type="tel" class="form-input">
                    </div>

                    <div class="form-group">
                        <label>Adres:</label>
                        <textarea v-model="settings.address" class="form-input"></textarea>
                    </div>
                </div>

                <!-- Godziny otwarcia -->
                <div v-if="currentTab === 'hours'" class="settings-form">
                    <div class="hours-grid">
                        <div v-for="(day, index) in weekDays" :key="day" class="day-row">
                            <span class="day-name">{{ day }}:</span>
                            <div class="day-hours">
                                <input v-model="settings.openingHours[index].from" type="time" class="time-input">
                                <span> - </span>
                                <input v-model="settings.openingHours[index].to" type="time" class="time-input">
                            </div>
                            <label class="closed-checkbox">
                                <input v-model="settings.openingHours[index].closed" type="checkbox">
                                Zamknięte
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Mapa -->
                <div v-if="currentTab === 'map'" class="settings-form">
                    <div class="form-group">
                        <label>Kod embed mapy Google:</label>
                        <textarea v-model="settings.mapEmbed" class="form-input" rows="4"></textarea>
                    </div>
                    <div class="map-preview" v-html="settings.mapEmbed"></div>
                </div>
            </div>

            <div class="settings-actions">
                <button @click="saveSettings" class="save-btn">
                    <i class="fas fa-save"></i> Zapisz zmiany
                </button>
            </div>
        </div>
    </section>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
    setup() {
        const tabs = [
            { id: 'contact', label: 'Kontakt' },
            { id: 'hours', label: 'Godziny otwarcia' },
            { id: 'map', label: 'Mapa' }
        ];

        const currentTab = ref('contact');
        const weekDays = ref(['Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela']);

        // Оновлений код в setup()

        const settings = ref({
            contactEmail: '',
            contactPhone: '',
            address: '',
            openingHours:
            [
                { from: '09:00', to: '19:00', closed: false },
                { from: '09:00', to: '19:00', closed: false },
                { from: '09:00', to: '19:00', closed: false },
                { from: '09:00', to: '19:00', closed: false },
                { from: '09:00', to: '19:00', closed: false },
                { from: '00:00', to: '00:00', closed: true },
                { from: '00:00', to: '00:00', closed: true }
            ],
            mapEmbed: ''
        });

// Додайте ці методи
        const fetchSettings = async () => {
            try {
                const response = await fetch('/get-contact');
                const data = await response.json();

                if (data.data) {
                    settings.value = {
                        contactEmail: data.data.email,
                        contactPhone: data.data.phone,
                        address: data.data.address,
                        openingHours: data.data.opening_hours,
                        mapEmbed: data.data.map_embed
                    };
                }
            } catch (error) {
                console.error('Error fetching settings:', error);
            }
        };

        const saveSettings = async () => {
            try {


                const hoursArray = Object.values(settings.value.openingHours);
                console.log(hoursArray)
                const response = await fetch('/save-contact', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },

                    body: JSON.stringify({
                        email: settings.value.contactEmail,
                        phone: settings.value.contactPhone,
                        address: settings.value.address,
                        opening_hours: settings.value.openingHours,
                        map_embed: settings.value.mapEmbed
                    })
                });

                const data = await response.json();
                alert(data.message);
            } catch (error) {
                console.error('Error saving settings:', error);
                alert('Error saving settings');
            }
        };

// Викликати при завантаженні компонента
        onMounted(() => {
            fetchSettings();
        });

        return {
            tabs,
            currentTab,
            weekDays,
            settings,
            saveSettings
        };
    }
};
</script>

<style scoped>
.about-us-section {
    padding: 120px 0;
    background-color: #F5F1EB;
}

.settings-tabs {
    display: flex;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 20px;
}

.tab-btn {
    padding: 10px 20px;
    background: none;
    border: none;
    border-bottom: 3px solid transparent;
    cursor: pointer;
    font-weight: 500;
}

.tab-btn.active {
    border-bottom-color: #1A1A1A;
    color: #1A1A1A;
}

.settings-form {
    margin: 20px 0;
}

.hours-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 85px;
}

.day-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.day-name {
    font-weight: 500;
    min-width: 100px;
}

.day-hours {
    display: flex;
    align-items: center;
    gap: 10px;
}

.time-input {
    padding: 5px;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
}

.closed-checkbox {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-left: 10px;
}

.map-preview {
    margin-top: 20px;
    width: 100%;
    min-height: 300px;
    border: 1px solid #e2e8f0;
}

.settings-actions {
    margin-top: 30px;
    display: flex;
    justify-content: flex-end;
}

.save-btn {
    background: #1A1A1A;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
}

@media (max-width: 768px) {
    .settings-tabs {
        overflow-x: auto;
    }

    .hours-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .day-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>