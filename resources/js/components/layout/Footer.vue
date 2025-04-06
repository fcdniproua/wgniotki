<template>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
<!--                <div class="footer-logo">-->
<!--                    <router-link to="/" class="logo">Gourmet</router-link>-->
<!--                </div>-->

                <div class="footer-links">
<!--                    <nav class="footer-nav">-->
<!--                        <ul>-->
<!--                            <li><router-link to="/">Home</router-link></li>-->
<!--                            <li><router-link to="/about">About</router-link></li>-->
<!--                            <li><router-link to="/menu">Menu</router-link></li>-->
<!--                            <li><router-link to="/reservations">Reservations</router-link></li>-->
<!--                            <li><router-link to="/gallery">Gallery</router-link></li>-->
<!--                            <li><router-link to="/contact">Contact</router-link></li>-->
<!--                        </ul>-->
<!--                    </nav>-->

                    <div class="footer-legal">
                        <p class="copyright">&copy; 2025 TwojeSTO.pl - Wszelkie prawa zastrzeżone</p>
                        <div class="legal-links">
                            <router-link to="/privacy">Polityka prywatności</router-link>
                            <router-link to="/sitemap">Mapa strony</router-link>
                        </div>
                    </div>
                </div>

                <div class="footer-social">
                    <ul class="social-icons">
                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-whatsapp"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                    </ul>
                </div>


<!--                <div class="footer-social">-->
<!--                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>-->
<!--                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>-->
<!--                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>-->
<!--                </div>-->
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: 'AppFooter'
}
</script>

<style scoped>

.footer {
    background-color: #2c3e50;
    color: #ffffff;
    padding: 2.5rem 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    bottom: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
}

.footer-logo .logo {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 700;
    color: #ffffff;
    text-decoration: none;
}

.footer-links {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
}

.footer-nav ul {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.footer-nav a {
    color: #ffffff;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
}

.footer-nav a:hover {
    color: #e67e22;
}

.footer-legal {
    text-align: center;
}

.copyright {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    color: rgba(255, 255, 255, 0.7);
}

.legal-links {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.legal-links a {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.8rem;
    text-decoration: none;
    transition: color 0.3s;
}

.legal-links a:hover {
    color: #ffffff;
}

.footer-social {
    display: flex;
    gap: 1.5rem;
}

.social-icons {
    position: relative;
    display: flex;
    list-style: none;
}
.social-icons li {
    position: relative;
    margin: 0 20px;
    cursor: pointer;
}
.social-icons li a {
    position: relative;
    text-decoration: none;
    display: block;
}
.social-icons li a .fa-brands {
    font-size: 2em;
    color: #222;
    transition: 0.3s;
}
.social-icons li a::before {
    font-family: "FontAwesome";
    position: absolute;
    top: 0;
    left: 0;
    font-size: 2em;
    height: 0;
    overflow: hidden;
    transition: 0.5s ease-in-out;
}

/* Instagram */
.social-icons li:nth-child(1) a::before {
    content: "\f16d";
    background-image: linear-gradient(45deg,
    #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%,
    #bc1888 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* WhatsApp */
.social-icons li:nth-child(2) a::before {
    content: "\f232";
    color: #25D366;
}

/* Twitter */
.social-icons li:nth-child(3) a::before {
    content: "\f099";
    color: #1DA1F2;
}

/* Facebook */
.social-icons li:nth-child(4) a::before {
    content: "\f39e"; /* Оновлений код іконки Facebook */
    color: #1877F2; /* Офіційний колір Facebook */
}

.social-icons li:hover a::before {
    height: 100%;
}

/* Додаткові ефекти при наведенні */
.social-icons li:hover a .fa-brands {
    opacity: 0;
}
</style>