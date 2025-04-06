<header class="header">
    <div class="container">
        <!-- Лого -->
        <div class="logo">
            <a href="{{ route('home') }}">Gourmet</a>
        </div>

        <!-- Бургер-кнопка -->
        <button class="burger-btn" aria-label="Menu">
            <span class="burger-line"></span>
            <span class="burger-line"></span>
            <span class="burger-line"></span>
        </button>

        <!-- Основне меню + кнопка закриття -->
        <nav class="main-menu">
            <button class="close-btn" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <ul class="menu-list">
                <li><a href="{{-- route('home') --}}">Home</a></li>
                <li><a href="{{-- route('about') --}}">About</a></li>
                <li><a href="{{-- route('menu') --}}">Menu</a></li>
                <li><a href="{{-- route('reservations') --}}">Reservations</a></li>
                <li><a href="{{-- route('gallery') --}}">Gallery</a></li>
                <li><a href="{{-- route('contact') --}}">Contact</a></li>
            </ul>
        </nav>

        <!-- Іконки -->
        <div class="header-icons">
            <a href="#"><i class="fas fa-search"></i></a>
            <a href="#"><i class="fas fa-user"></i></a>
        </div>
    </div>
</header>