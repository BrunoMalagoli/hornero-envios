<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hornero Envios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="logo.png" alt="Logo de la empresa">
            </div>
            <ul class="nav-links">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>

    <main>
        <section id="hero">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="slide1.jpg" alt="Slide 1">
                        <div class="slide-content">
                            <h1>Envíos rápidos y seguros</h1>
                            <p>Confía en nosotros para tus envíos</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img src="slide2.jpg" alt="Slide 2">
                        <div class="slide-content">
                            <h1>Cobertura nacional</h1>
                            <p>Llegamos a todos los rincones del país</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img src="slide3.jpg" alt="Slide 3">
                        <div class="slide-content">
                            <h1>Tecnología de punta</h1>
                            <p>Seguimiento en tiempo real de tus envíos</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>

        <section id="formularios">
            <div class="form-container">
                <div class="form-tabs">
                    <button class="tab-button active" data-tab="cotizar">Cotizar envío</button>
                    <button class="tab-button" data-tab="seguimiento">Seguimiento</button>
                </div>
                <form id="cotizarForm" method="POST" class="form active">
                    <h2>Cotizar envío</h2>
                    <input type="number" name="peso" placeholder="Peso (kg)" required>
                    <input type="number" name="alto" placeholder="Alto (cm)" required>
                    <input type="number" name="ancho" placeholder="Ancho (cm)" required>
                    <input type="number" name="largo" placeholder="Largo (cm)" required>
                    <input type="text" name="origen" placeholder="Origen" required>
                    <input type="text" name="destino" placeholder="Destino" required>
                    <button type="submit">Cotizar</button>
                </form>
                <div id="resultadoCotizacion"></div>
                <form id="seguimientoForm" class="form">
                    <h2>Seguimiento de envío</h2>
                    <input type="text" placeholder="Código de seguimiento" required>
                    <button type="submit">Rastrear</button>
                </form>
            </div>
        </section>

        <section id="servicios">
            <h2>Nuestros Servicios</h2>
            <div class="services-container">
                <div class="service-card">
                    <i class="fas fa-truck"></i>
                    <h3>Envío Estándar</h3> 
                    <p>Entrega en 3-5 días hábiles</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-plane"></i>
                    <h3>Envío Express</h3>
                    <p>Entrega en 1-2 días hábiles</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-box"></i>
                    <h3>Embalaje Especial</h3>
                    <p>Protección adicional para objetos frágiles</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Acerca de nosotros</h3>
                <p>Somos una empresa líder en servicios de envío, comprometida con la excelencia y la satisfacción del cliente.</p>
            </div>
            <div class="footer-section">
                <h3>Enlaces rápidos</h3>
                <ul>
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Síguenos</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2023 Tu Empresa de Envíos. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="./js/script.js"></script>
    <!-- <script>
        
    </script> -->
</body>
</html>