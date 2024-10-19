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
                 <?php
                    session_start();
                    $_SESSION['sucursal_user'] = 2;
                    $conexion = mysqli_connect("localhost" , "root", "" , "hornero") or exit("No se pudo establecer una conexión");
                    $respuesta_enviosxsuc = mysqli_query($conexion,
                     "
                    SELECT envio.*, sucursal_origen.nombre AS nombre_origen, sucursal_destino.nombre AS nombre_destino
                    FROM envio
                    LEFT JOIN sucursal AS sucursal_origen ON envio.sucursal_origen = sucursal_origen.id
                    LEFT JOIN sucursal AS sucursal_destino ON envio.sucursal_destino = sucursal_destino.id
                    WHERE envio.sucursal_origen = {$_SESSION['sucursal_user']}
                    ");
                    
                    while($result = mysqli_fetch_assoc($respuesta_enviosxsuc)){
                        echo("
                        <tr>
                            <td>{$result['codigo']}</td>
                            <td>{$result['remitente']}</td>
                            <td>{$result['destinatario']}</td>
                            <td>{$result['nombre_origen']}</td>
                            <td>{$result['nombre_destino']}</td>
                            <td>{$result['fecha']}</td>
                            <td>{$result['precio']}</td>
                            <td>Borrar</td>
                        </tr>");
                    }
                    
                    mysqli_free_result($respuesta_enviosxsuc);
                    mysqli_close($conexion);
                 ?>
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