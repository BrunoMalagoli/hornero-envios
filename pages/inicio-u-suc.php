<?php
/*
session_start();
if(!isset($_SESSION['logueado'])){
header("Location:login.php");
exit;
}
*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de Sucursal - Sistema de Gestión de Envíos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/inicio-u-suc.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="logo.png" alt="Logo de la empresa">
            </div>
            <ul class="nav-links">
                <li><a href="admision-envios.php">Admision</a></li>
                <li><a href="Captura.php">Captura</a></li>
                <li><a href="consulta-historico.php">Historico</a></li>
                <li><a href="entrega.php">Entrega</a></li>
                <li><a href="inicio-u-suc.php">Inicio</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
                <div class="line4"></div>
                <div class="line5"></div>
            </div>
        </nav>
    </header>
    <div class="container">
        <h1>Vista de Sucursal - Gestión de Envíos</h1>
        <button class="filtros-toggle">Mostrar/Ocultar Filtros</button>
        <form class="filtros" action="./inicio-u-suc.php" method="GET">
            <div class="filtro">
                <label for="filtro-codigo">Código:</label>
                <input type="text" name="filtro-codigo" id="filtro-codigo" placeholder="Buscar por código">
            </div>
            <div class="filtro">
                <label for="filtro-destino">Destino:</label>
                <input type="text" name="filtro-destino" id="filtro-destino" placeholder="Buscar por destino">
            </div>
            <div class="filtro">
                <label for="filtro-origen">Origen:</label>
                <input type="text" name="filtro-origen" id="filtro-origen" placeholder="Buscar por origen">
            </div>
            <div class="filtro">
                <label for="filtro-destinatario">Destinatario:</label>
                <input type="text" name="filtro-destinatario" id="filtro-destinatario" placeholder="Buscar por destinatario">
            </div>
            <button id="submit-filtros" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
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
                    $_SESSION['sucursal'] = 2;
                    require("../config/dbconnect.php");
                    // AGREGAR QUE EN LA TABLA SOLAMENTE MUESTRE LOS ENVIOS EN ESTADO ADMITIDO
                    $condicionales = [];
                    if(!empty($_GET['filtro-codigo'])){
                        $codigo = $_GET['filtro-codigo'];
                        $condicionales[] = "envio.codigo = '$codigo'";
                    }
                    if(!empty($_GET['filtro-destino'])){
                        $destino = mysqli_real_escape_string($conexion,$_GET['filtro-destino']);
                        $destinoU = strtoupper($destino);
                        $condicionales[] = "sucursal_destino.nombre = '$destinoU'";
                    }
                    if(!empty($_GET['filtro-origen'])){
                        $origen = mysqli_real_escape_string($conexion,$_GET['filtro-origen']);
                        $origenU = strtoupper($origen);
                        $condicionales[] = "sucursal_origen.nombre = '$origenU'";
                    }
                    if(!empty($_GET['filtro-destinatario'])){
                        $destinatario = (int)$_GET['filtro-destinatario'];
                        $condicionales[] = "envio.destinatario = '$destinatario'";
                    }
                    $sql = "
                    SELECT envio.*, sucursal_origen.nombre AS nombre_origen, sucursal_destino.nombre AS nombre_destino
                    FROM envio
                    LEFT JOIN sucursal AS sucursal_origen ON envio.sucursal_origen = sucursal_origen.id
                    LEFT JOIN sucursal AS sucursal_destino ON envio.sucursal_destino = sucursal_destino.id
                    WHERE envio.sucursal_origen = {$_SESSION['sucursal']}
                    ";
                    if (count($condicionales) > 0) {
                        $sql .= " AND " . implode(" AND ", $condicionales);
                    }
                    $respuesta_enviosxsuc = mysqli_query($conexion, $sql);
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