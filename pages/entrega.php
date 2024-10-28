<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENTREGAS</title>
    <link rel="stylesheet" href="../css/entrega.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
            <nav class="navbar">
                <div class="logo">
                    <img src="../images/LOGO_TRANSPARENTE.png" alt="LOGO">
                </div>
                <ul class="nav-links">
                    <li><a href="admision-envios.php">Admision</a></l>
                    <li><a href="captura.php">Captura</a></li>
                    <li><a href="consulta-historico.php">Historico</a></li>
                    <li><a style="background-color: #170f38" href="entrega.php">Entrega</a></li>
                    <li><a href="inicio-u-suc.php">Inicio</a></li>
                    <li><a href="#">Cerrar Sesión</a></li>
                </ul>
                <div class="burger">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                </div>
            </nav>
        </header>

    <main>
        <section class="search-filter">
            <h2>Filtro de Búsqueda</h2>
            <form action="#" method="GET">
                <div class="form-row">
                    <div class="form-group">
                        <label for="numero">Código</label>
                        <input type="text" id="numero" name="filter-codigo">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="remitente">Remitente</label>
                        <input type="text" id="remitente" name="filter-remitente">
                    </div>
                    <div class="form-group">
                        <label for="destinatario">Destinatario</label>
                        <input type="text" id="destinatario" name="filter-destinatario">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-search">BUSCAR</button>
                    <button type="reset" class="btn-clear">LIMPIAR</button>
                </div>
            </form>
        </section>

        <section class="pending-deliveries">
            <h2>Envíos Pendientes de Entrega</h2>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Remitente</th>
                        <th>Origen</th>
                        <th>Destinatario</th>
                        <th>CUIL - Destinatario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    session_start();
                    require("../config/dbconnect.php");
                    if (!$conexion) {
                        die("Error de conexión: " . mysqli_connect_error());
                    }
                    
                    $_SESSION['sucursal'] = 2;
                    $sucursal_destino = $_SESSION['sucursal'];

                    if(!empty($_GET['filter-codigo'])){
                        $codigo = mysqli_real_escape_string($conexion , $_GET['filter-codigo']);
                        $condiciones[] = "envio.codigo LIKE '%$codigo%'";
                    }
                    if(!empty($_GET['filter-origen'])){
                        $origen = mysqli_real_escape_string($conexion , $_GET['filter-origen']);
                        $condiciones[] = "envio.codigo LIKE '%$origen%'";
                    }
                    $condiciones = [];
                    $query = "SELECT envio.*,
                    sucursal_de_origen.id , 
                    sucursal_de_origen.nombre AS nombre_suc_origen ,
                    movimientos.*, 
                    estados.*,  
                    cliente_remitente.nombre AS nombre_remitente, 
                    cliente_destinatario.cuil AS cuil_destinatario,
                    cliente_destinatario.nombre AS nombre_destinatario
                    FROM envio 
                    INNER JOIN movimientos ON envio.codigo = movimientos.envio_id 
                    INNER JOIN estados ON movimientos.estados_id = estados.id 
                    INNER JOIN cliente AS cliente_remitente ON cliente_remitente.id = envio.remitente
                    INNER JOIN cliente AS cliente_destinatario ON cliente_destinatario.id = envio.destinatario
                    INNER JOIN sucursal AS sucursal_de_origen ON sucursal_de_origen.id = envio.sucursal_origen 
                    WHERE envio.sucursal_destino = '$sucursal_destino' 
                    AND envio.codigo NOT IN (
                    SELECT movimientos.envio_id 
                    FROM movimientos 
                    WHERE estados_id = 5
                    ); ";
                    $resultado = mysqli_query($conexion, $query);
                    if (!$resultado) {
                        die("Error en la consulta: " . mysqli_error($conexion));
                    }
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($contenido = mysqli_fetch_assoc($resultado)) {
                            echo("
                                <tr>
                                    <td>" . htmlspecialchars($contenido['codigo']) . "</td> 
                                    <td>" . htmlspecialchars($contenido['nombre_remitente']) . "</td> 
                                    <td>" . htmlspecialchars($contenido['nombre_suc_origen']) . "</td> 
                                    <td>" . htmlspecialchars($contenido['nombre_destinatario']) . "</td> 
                                    <td>" . htmlspecialchars($contenido['cuil_destinatario']) . "</td> 
                                    <td><button value=\"{$contenido['codigo']}\" class=\"entregaEnvio action-btn\"><i class=\"fa-solid fa-arrow-right-from-bracket\"></i></button></td>
                                </tr> 
                            ");        
                        }
                    } else {
                        echo "<tr><td colspan='5'>No se encontraron resultados.</td></tr>";
                    }
                    ?>
                    <!-- Más filas de ejemplo aquí -->
                </tbody>
            </table>
        </section>
    </main>
    <script src="../js/entrega.js"></script>
</body>
</html>