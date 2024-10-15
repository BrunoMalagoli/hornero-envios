<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de Sucursal - Sistema de Gestión de Envíos</title>
    <link rel="stylesheet" href="../css/inicio-u-suc.css">
    <link rel="stylesheet" href="../css/global.css">
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

    <div class="container">
        <h1>Vista de Sucursal - Gestión de Envíos</h1>
        <button class="filtros-toggle">Mostrar/Ocultar Filtros</button>
        <div class="filtros">
            <div class="filtro">
                <label for="filtro-codigo">Código:</label>
                <input type="text" id="filtro-codigo" placeholder="Buscar por código">
            </div>
            <div class="filtro">
                <label for="filtro-destino">Destino:</label>
                <input type="text" id="filtro-destino" placeholder="Buscar por destino">
            </div>
            <div class="filtro">
                <label for="filtro-origen">Origen:</label>
                <input type="text" id="filtro-origen" placeholder="Buscar por origen">
            </div>
            <div class="filtro">
                <label for="filtro-destinatario">Destinatario:</label>
                <input type="text" id="filtro-destinatario" placeholder="Buscar por destinatario">
            </div>
        </div>
        <table id="tabla-envios">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Remitente</th>
                    <th>Destinatario</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Fecha</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los datos se cargarán aquí dinámicamente -->
            </tbody>
        </table>
        <div class="paginacion">
            <button id="btn-anterior" disabled>Anterior</button>
            <span id="pagina-actual">Página 1 de 1</span>
            <button id="btn-siguiente" disabled>Siguiente</button>
        </div>
    </div>

    <script src="../js/script.js"></script>
    <script src="../js/u-suc.js"></script>
</body>
</html>