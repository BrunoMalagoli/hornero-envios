<?php
session_start();
include("../config/dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['mensaje'])) {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
        $email = mysqli_real_escape_string($conexion, $_POST['email']);
        $mensaje = mysqli_real_escape_string($conexion, $_POST['mensaje']);
        $fecha = date('Y-m-d H:i:s');

        $destino="horneroenvios@gmail.com";
        $asunto="Contacto desde el sitio";
        $mensaje=" Mensaje: ".$mensaje;

        $header="From: ".$nombre."<".$email.">";

        $enviado = mail($destino,$asunto,$mensaje,$header);

        if($enviado == true){
            echo "Su correo ha sido enviado.";
        }else{
            echo "Hubo un error en el envio del mail.";
        }

        $query = "INSERT INTO reclamos (descripcion, nombre, apellido, email, fecha) 
                  VALUES ('$mensaje', '$nombre', '$apellido', '$email', '$fecha')";

        if (mysqli_query($conexion, $query)) {
            $resultado = "Gracias por contactarnos, $nombre. Tu mensaje ha sido registrado.";
           } else {
                $error = "Lo sentimos, hubo un error al procesar tu solicitud. Por favor, inténtalo de nuevo más tarde.";
           }
          } else {
        $error = "Por favor, completa todos los campos del formulario.";
       }

    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - HM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/contacto.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="logo.png" alt="Logo de la empresa">
            </div>
            <ul class="nav-links">
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../index.php#servicios">Servicios</a></li>
                <li><a href="contacto.php" class="active">Contacto</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>

    <main>
        <section id="contacto" class="contact-section">
            <div class="contact-container">
                <h1>Contáctanos</h1>
                <p>Estamos aquí para ayudarte. Completa el formulario y nos pondremos en contacto contigo lo antes posible.</p>
                <form id="contactForm" action="" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" id="apellido" name="apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Enviar mensaje</button>
                </form>
            </div>
            <div class="contact-info">
                <h2>Información de contacto</h2>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Calle Principal 123, Ciudad, País</li>
                    <li><i class="fas fa-phone"></i> +1 234 567 890</li>
                    <li><i class="fas fa-envelope"></i> info@tuempresa.com</li>
                </ul>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
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
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="index.html#servicios">Servicios</a></li>
                    <li><a href="contact.html">Contacto</a></li>
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

    <script src="script.js"></script>
</body>
</html>