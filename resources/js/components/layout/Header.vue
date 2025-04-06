<template>
    <header class="header">
        <div class="header-container">
            <router-link to="/" class="logo">
                Gourmet
            </router-link>


            <nav class="main-nav">
                <ul class="nav-list">
                    <li><router-link class="menu-first" to="/">Home</router-link></li>
                    <li><router-link class="menu-next" to="/about">About</router-link></li>
                    <li><router-link class="menu-next" to="/menu">Menu</router-link></li>
                    <li><router-link class="menu-next" to="/reservations">Reservations</router-link></li>
                    <li><router-link class="menu-next" to="/gallery">Gallery</router-link></li>
                    <li><router-link class="menu-next" to="/contact">Contact</router-link></li>
                </ul>
            </nav>
            <a
                class="button-40"
                role="button"
                @click="$emit('open-contact-modal')"
            >Wycen Namprawe
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </a>


            <button class="burger-btn" @click="toggleMenu">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </button>

            <transition name="slide">
                <nav class="mobile-menu" v-if="isMenuOpen">
                    <ul>
                        <li><router-link class="menu-first" to="/" @click="closeMenu">Home</router-link></li>
                        <li><router-link class="menu-next" to="/about" @click="closeMenu">About</router-link></li>
                        <li><router-link class="menu-next" to="/menu" @click="closeMenu">Menu</router-link></li>
                        <li><router-link class="menu-next" to="/reservations" @click="closeMenu">Reservations</router-link></li>
                        <li><router-link class="menu-next" to="/gallery" @click="closeMenu">Gallery</router-link></li>
                        <li><router-link class="menu-next" to="/contact" @click="closeMenu">Contact</router-link></li>
                    </ul>
                </nav>
            </transition>
        </div>
    </header>
</template>

<script>
export default {
    name: 'AppHeader',
    data() {
        return {
            isMenuOpen: false
        }
    },
    methods: {
        toggleMenu() {
            this.isMenuOpen = !this.isMenuOpen;
            document.body.style.overflow = this.isMenuOpen ? 'hidden' : '';
        },
        closeMenu() {
            this.isMenuOpen = false;
            document.body.style.overflow = '';
        }
    }
}
</script>

<style scoped>
.header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    background: #2c3e50;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    height: 70px;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    height: 100%;
}

.logo {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 700;
    color: #ffffff;
    text-decoration: none;
}

/* Десктопне меню */
.main-nav {
    display: flex;
    flex-grow: 1;
    justify-content: center;
}

.nav-list {
    display: flex;
    gap: 35px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.menu-first {
    color: #bf7f56;
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
    transition: color 0.3s;
}

.menu-next {
    color: #ffffff;
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
    transition: color 0.3s;
}

.menu-first:hover, .menu-next:hover {
    color: #e67e22;
}

/* Мобільне меню */
.burger-btn {
    display: none;
    background: none;
    border: none;
    cursor: pointer;
    padding: 10px;
    z-index: 1001;
}

.burger-line {
    display: block;
    width: 25px;
    height: 2px;
    background: #fff;
    margin: 5px 0;
    transition: all 0.3s ease;
}

.mobile-menu {
    position: fixed;
    top: 70px;
    left: 0;
    width: 100%;
    height: calc(100vh - 70px);
    background: #2c3e50;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow-y: auto;
}

.mobile-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
    width: 100%;
}

.mobile-menu li {
    margin: 20px 0;
}

.mobile-menu .menu-first, .mobile-menu .menu-next {
    text-decoration: none;
    font-size: 18px;
    font-weight: 500;
    display: block;
    padding: 10px;
}

.mobile-menu .menu-first:hover, .mobile-menu .menu-next:hover {
    color: #e67e22;
}

/* Анімації */
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.4s ease;
}

.slide-enter-from,
.slide-leave-to {
    transform: translateX(-100%);
}

/* Адаптація */
@media (max-width: 992px) {
    .main-nav,
    .header-icons {
        display: none;
    }

    .burger-btn {
        display: block;
    }

    .header-container {
        padding: 0 15px;
    }

    .button-40 {
        padding: 5px 6px !important;
        margin-right: 0px !important;
        margin-left: 30px !important;
        text-align: center;
    }
}

/* Анімація бургер-кнопки */
.burger-btn.active .burger-line:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
}

.burger-btn.active .burger-line:nth-child(2) {
    opacity: 0;
}

.burger-btn.active .burger-line:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
}

.button-40 {
    position: relative;
    display: inline-block;
    padding: 15px 30px;
    margin: 40px 0;
    color: #e67e22;
    text-decoration: none;
    text-transform: uppercase;
    transition: 0.5s;
    letter-spacing: 4px;
    overflow: hidden;
    margin-right: 50px;
    cursor: pointer;
}
.button-40:hover {
    background: #e67e22;
    color: #050801;
    box-shadow: 0 0 5px #e67e22, 0 0 25px #e67e22, 0 0 50px #e67e22,
    0 0 200px #e67e22;
    -webkit-box-reflect: below 1px linear-gradient(transparent, #0005);
}
.button-40:nth-child(1) {
    filter: hue-rotate(270deg);
}
.button-40:nth-child(2) {
    filter: hue-rotate(110deg);
}
.button-40 span {
    position: absolute;
    display: block;
}
.button-40 span:nth-child(1) {
    top: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, transparent, #e67e22);
    animation: animate1 2s linear infinite;
}
@keyframes animate1 {
    0% {
        left: -100%;
    }
    50%,
    100% {
        left: 100%;
    }
}
.button-40 span:nth-child(2) {
    top: -100%;
    right: 0;
    width: 2px;
    height: 100%;
    background: linear-gradient(180deg, transparent, #e67e22);
    animation: animate2 2s linear infinite;
    animation-delay: 0.5s;
}
@keyframes animate2 {
    0% {
        top: -100%;
    }
    50%,
    100% {
        top: 100%;
    }
}
.button-40 span:nth-child(3) {
    bottom: 0;
    right: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(270deg, transparent, #e67e22);
    animation: animate3 2s linear infinite;
    animation-delay: 1s;
}
@keyframes animate3 {
    0% {
        right: -100%;
    }
    50%,
    100% {
        right: 100%;
    }
}

.button-40 span:nth-child(4) {
    bottom: -100%;
    left: 0;
    width: 2px;
    height: 100%;
    background: linear-gradient(360deg, transparent, #e67e22);
    animation: animate4 2s linear infinite;
    animation-delay: 1.5s;
}
@keyframes animate4 {
    0% {
        bottom: -100%;
    }
    50%,
    100% {
        bottom: 100%;
    }
}

/*.button-40 {
    --glow-color: rgba(255, 153, 0, 0.8); !* Помаранчеве світіння *!
    --glow-spread-color: rgba(0, 78, 146, 0.6); !* Темно-синій відтінок *!
    --enhanced-glow-color: rgba(255, 179, 71, 0.8); !* Яскраво-помаранчевий *!
    --btn-color: rgb(230, 115, 0); !* Основний помаранчевий колір *!

    border: .25em solid var(--glow-color);
    padding: 1em 3em;
    color: white;
    font-size: 15px;
    font-weight: bold;
    background-color: var(--btn-color);
    border-radius: 1em;
    outline: none;
    box-shadow:
        0 0 1em .25em var(--glow-color),
        0 0 4em 1em var(--glow-spread-color),
        inset 0 0 .75em .25em var(--glow-color);
    text-shadow: 0 0 .5em var(--glow-color);
    position: relative;
    transition: all 0.3s;
    cursor: pointer;
}

.button-40::after {
    pointer-events: none;
    content: "";
    position: absolute;
    top: 120%;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: var(--glow-spread-color);
    filter: blur(2em);
    opacity: .7;
    transform: perspective(1.5em) rotateX(35deg) scale(1, .6);
}

.button-40:hover {
    color: var(--btn-color);
    background-color: var(--enhanced-glow-color);
    box-shadow:
        0 0 1em .25em var(--glow-color),
        0 0 4em 2em var(--glow-spread-color),
        inset 0 0 .75em .25em var(--glow-color);
}

.button-40:active {
    box-shadow:
        0 0 0.6em .25em var(--glow-color),
        0 0 2.5em 2em var(--glow-spread-color),
        inset 0 0 .5em .25em var(--glow-color);
    transform: translateY(2px);
}*/
</style>


