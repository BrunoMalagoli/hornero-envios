<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENTREGAS</title>
    <link rel="stylesheet" href="../css/entrega.css">
    <link rel="stylesheet" href="../css/global.css">
</head>
<body>
    <header>
        <div class="logo"></div>
        <h1>ENTREGAS</h1>

    </header>

    <main>
        <section class="search-filter">
            <h2>Filtro de Búsqueda</h2>
            <form action="#" method="GET">
                <div class="form-row">
                    <div class="form-group">
                        <label for="numero">Número / Referencia / Localizador</label>
                        <input type="text" id="numero" name="numero">
                    </div>
                    <div class="form-group">
                        <label for="origen">Origen</label>
                        <input type="text" id="origen" name="origen">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="remitente">Remitente</label>
                        <input type="text" id="remitente" name="remitente">
                    </div>
                    <div class="form-group">
                        <label for="destinatario">Destinatario</label>
                        <input type="text" id="destinatario" name="destinatario">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="desde_fecha">Desde Fecha</label>
                        <input type="date" id="desde_fecha" name="desde_fecha">
                    </div>
                    <div class="form-group">
                        <label for="hasta_fecha">Hasta Fecha</label>
                        <input type="date" id="hasta_fecha" name="hasta_fecha">
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
                        <th>Ref. Interna</th>
                        <th>Número</th>
                        <th>Remitente</th>
                        <th>Origen</th>
                        <th>Destinatario</th>
                        <th>DNI</th>
                        <th>Fecha</th>
                        <th>Bultos</th>
                        <th>Peso</th>
                        <th>Valor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    session_start();
                    $conexion = require("../config/dbconnect.php");
                    $sucursal_destino = mysqli_real_escape_string($conexion, $_SESSION['sucursal']);

                    $query = "SELECT envio.*, movimientos.* from envio 
                    INNER JOIN movimientos 
                    ON envio.codigo = movimientos.envio_id 
                    WHERE envio.sucursal_destino = '$sucursal_destino'";
                    
                    $resultado = mysqli_query($conexion, $query);
                    while($contenido = mysqli_fetch_assoc($resultado)){
                        echo("
                            <tr>
                               <td>{$contenido['codigo']}</td> 
                               <td>{$contenido['codigo']}</td> 
                               <td>{$contenido['codigo']}</td> 
                               <td>{$contenido['codigo']}</td> 
                               <td>{$contenido['codigo']}</td> 
                               <td>{$contenido['codigo']}</td> 
                               <td>{$contenido['codigo']}</td> 
                            </tr> 
                        ");        
                    }
                    ?>
                    <!-- Más filas de ejemplo aquí -->
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>