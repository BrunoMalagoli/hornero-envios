<?php
session_start();
if(!isset($_SESSION['logueado'])){
header("Location:login.php");
exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de Sucursal - Sistema de Gestión de Envíos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/inicio-u-suc.css">
</head>
<body>
        <nav class="navbar">
            <div class="logo">
                <img src="../images/LOGO_TRANSPARENTE.png" alt="Logo de la empresa">
            </div>
            <ul class="nav-links">
                    <li><a href="admision-envios.php">Admision</a></l>
                    <li><a href="captura.php">Captura</a></li>
                    <li><a href="consulta-historico.php">Historico</a></li>
                    <li><a href="entrega.php">Entrega</a></li>
                    <li><a style="background-color: #170f38" href="inicio-u-suc.php">Inicio</a></li>
                    <p>USUARIO : 
                    <?php
                        require("../config/dbconnect.php");
                        $sucursal_actual = $_SESSION['sucursal'];
                        echo mysqli_fetch_assoc(mysqli_query($conexion , "SELECT nombre FROM sucursal WHERE id = '$sucursal_actual'"))['nombre'] . " (" . $sucursal_actual . ")";
                    ?>
                    </p>
                    <li><a href="../services/logout.php">Cerrar Sesión</a></li>
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
                    require("../config/dbconnect.php");
                    // AGREGAR QUE EN LA TABLA SOLAMENTE MUESTRE LOS ENVIOS EN ESTADO ADMITIDO
                    $condicionales = [];
                    if(!empty($_GET['filtro-codigo'])){
                        $codigo = $_GET['filtro-codigo'];
                        $condicionales[] = "envio.codigo LIKE '$codigo%'";
                    }
                    if(!empty($_GET['filtro-destino'])){
                        $destino = mysqli_real_escape_string($conexion,$_GET['filtro-destino']);
                        $destinoU = strtoupper($destino);
                        $condicionales[] = "sucursal_destino.nombre LIKE '%$destinoU%'";
                    }
                    if(!empty($_GET['filtro-origen'])){
                        $origen = mysqli_real_escape_string($conexion,$_GET['filtro-origen']);
                        $origenU = strtoupper($origen);
                        $condicionales[] = "sucursal_origen.nombre LIKE '%$origenU%'";
                    }
                    if(!empty($_GET['filtro-destinatario'])){
                        $destinatario = (int)$_GET['filtro-destinatario'];
                        $condicionales[] = "envio.destinatario LIKE '%$destinatario%'";
                    }
                    $sql = "
                    SELECT envio.*, 
                        sucursal_origen.nombre AS nombre_origen, 
                        sucursal_destino.nombre AS nombre_destino,
                        sucursal_intermedia.id AS suc_intermedia_id,
                        movimientos.*
                    FROM envio
                    LEFT JOIN sucursal AS sucursal_origen ON envio.sucursal_origen = sucursal_origen.id
                    LEFT JOIN sucursal AS sucursal_destino ON envio.sucursal_destino = sucursal_destino.id
                    INNER JOIN movimientos ON movimientos.envio_id = envio.codigo
                    INNER JOIN sucursal AS sucursal_intermedia ON sucursal_intermedia.id = {$_SESSION['sucursal']}
                    WHERE 
                        (
                            envio.sucursal_origen = {$_SESSION['sucursal']} 
                            AND movimientos.estados_id = 1
                            AND envio.codigo NOT IN (
                                SELECT envio_id 
                                FROM movimientos 
                                WHERE estados_id != 1
                            )
                        )
                        OR 
                        (
                            envio.sucursal_actual = {$_SESSION['sucursal']}
                            AND envio.sucursal_origen != {$_SESSION['sucursal']}
                            AND envio.sucursal_destino != {$_SESSION['sucursal']}
                            AND movimientos.estados_id = 3
                            AND envio.codigo NOT IN (
                                SELECT envio_id 
                                FROM movimientos 
                                WHERE estados_id IN (4, 5, 6)
                            )
                            AND movimientos.fecha = (
                                SELECT MAX(mov.fecha)
                                FROM movimientos mov
                                WHERE mov.envio_id = envio.codigo
                            )
                        )

                "; //COMPARAR ENVIO.SUCURSAL_ACTUAL CON SUCURSAL.CENTRO_DESIGNADO
                    if (count($condicionales) > 0) {
                        $sql .= " AND " . implode(" AND ", $condicionales);
                    }
                    $respuesta_enviosxsuc = mysqli_query($conexion, $sql);
                    while($result = mysqli_fetch_assoc($respuesta_enviosxsuc)){
                        $respuesta_remitente = mysqli_query($conexion , "SELECT C.nombre FROM cliente C INNER JOIN envio E ON '$result[remitente]' = C.id");
                        $respuesta_destinatario = mysqli_query($conexion , "SELECT C.nombre FROM cliente C INNER JOIN envio E ON '$result[destinatario]' = C.id");
                        $nombre_remitente = mysqli_fetch_assoc($respuesta_remitente)['nombre'];
                        $nombre_destinatario = mysqli_fetch_assoc($respuesta_destinatario)['nombre'];
                        echo("
                        <tr>
                            <td>{$result['codigo']}</td>
                            <td>{$nombre_remitente}</td>
                            <td>{$nombre_destinatario}</td>
                            <td>{$result['nombre_origen']}</td>
                            <td>{$result['nombre_destino']}</td>
                            <td>{$result['fecha']}</td>
                            <td>{$result['precio']}</td>
                            <td><button value=\"{$result['codigo']}\" class=\"eliminarEnvioEnSucursal action-btn delete-btn\"><i class=\"fas fa-trash\"></i></button></td>
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
        <div class="buttonWrapper">
            <button id="botonManifiesto" class="action-btn"
                onclick="window.open('../services/gestionManifiestos.php'); window.location.reload();">
            Generar manifiesto
            </button>
        </div>
    </div>

    <script src="../js/script.js"></script>
    <script src="../js/u-suc.js"></script>
</body>
</html>