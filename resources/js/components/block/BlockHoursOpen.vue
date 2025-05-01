<template>
    <div class="opening-hours">
        <h3 class="hours-title bold">Godziny otwarcia</h3>
        <ul class="hours-list">
            <li class="hours-item"><span class="day">Poniedziałek</span> <span class="time">09:00 – 19:00</span></li>
            <li class="hours-item"><span class="day">Wtorek</span> <span class="time">09:00 – 19:00</span></li>
            <li class="hours-item"><span class="day">Środa</span> <span class="time">09:00 – 19:00</span></li>
            <li class="hours-item"><span class="day">Czwartek</span> <span class="time">09:00 – 19:00</span></li>
            <li class="hours-item"><span class="day">Piątek</span> <span class="time">09:00 – 19:00</span></li>
            <li class="hours-item closed"><span class="day">Sobota</span> <span class="time">Zamknięte</span></li>
            <li class="hours-item closed"><span class="day">Niedziela</span> <span class="time">Zamknięte</span></li>
        </ul>
    </div>
</template>

<style>

.opening-hours {

    max-width: 300px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.hours-title {
    font-size: 1.5rem;
    color: #1e3a8a;
    margin-bottom: 15px;
    text-align: center;
}

.hours-status {
    font-weight: bold;
    color: #dc3545;
    margin-bottom: 20px;
    text-align: center;
}

.hours-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.hours-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
}

.hours-item:last-child {
    border-bottom: none;
}

.day {
    color: #495057;
    font-weight: 500;
}

.time {
    color: #212529;
}

.hours-item.closed .time {
    color: #dc3545;
}

@media (max-width: 768px) {
    .opening-hours {
        padding: 15px;
    }

    .hours-title {
        font-size: 1.3rem;
    }
}

</style>