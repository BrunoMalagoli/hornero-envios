<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CONSULTA HISTORICO</title>
        <link rel="stylesheet" href="../css/consulta-historico.css">
        <link rel="stylesheet" href="../css/global.css">
    </head>
    <body>
        <div class="header">
            <div class="logo-space"><img class="logo" src="../images/LOGO_TRANSPARENTE.png" alt="LOGO"></div>
            <button class="btn btn-primary">DESCONECTAR</button>
        </div>
        <div class="nav-space"></div>
        <div class="container">

            <h1>HISTÓRICO DE MOVIMIENTOS</h1>
            <form method="POST" action="">
                <div class="search-section">
                    <div class="guia-container">
                        <label for="codigo">CODIGO DE SEGUIMIENTO:</label>
                        <input type="text" id="codigo" name="codigo" pattern="[0-9]{1,12}" maxlength="12" required>
                    </div>
                    <div class="button-group">
                        <button class="btn btn-primary">BUSCAR</button>
                        <button type="reset" class="btn btn-secondary">LIMPIAR</button>
                    </div>
                </div>
            </form>
            <?php
                include '../config/dbconnect.php';

                if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['codigo'])) {
                    $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
                    
                    $consulta = mysqli_query($conexion, "SELECT * FROM envio WHERE codigo=$codigo;");

                    if (mysqli_num_rows($consulta) == 0) {
                        echo "<p class='no-results'>No se encontraron resultados para el código de seguimiento: $codigo</p>";
                    } else {
                        $envio = mysqli_fetch_assoc($consulta); 
                        $envio_id = $envio['codigo'];  
                        $consulta = mysqli_query($conexion, 
                        "SELECT m.fecha, e.nombre from movimientos m, estados e where m.estados_id = e.id and m.envio_id = $envio_id;");
                        echo "<table>
                                <thead>
                                    <tr>
                                        <th>Fecha y Hora</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>";
                        while($resultados=mysqli_fetch_assoc($consulta)) {
                            echo "<tr>
                                    <td>{$resultados['fecha']}</td>
                                    <td>{$resultados['nombre']}</td>
                                </tr>";
                        }
                        echo "</tbody></table>";
                    }
                }
            ?>    
        </div>   
    </body>
</html>