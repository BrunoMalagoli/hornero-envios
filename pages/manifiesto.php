<?php
session_start();
// Conexión a la base de datos
include '../config/dbconnect.php';

// Fecha actual
$fecha_actual = date('d/m/Y');
$sucursal_actual = $_SESSION['sucursal'];
$u_id = $_SESSION['usuario_id'];
$manifiesto_destino = "";
//traigo los envios que estan admitidos en la sucursal 
// $respuesta = mysqli_query($conexion , "SELECT * FROM envio WHERE sucursal_actual = '$sucursal_actual'");
// if (!$respuesta) {
//     echo "Error en la consulta: " . mysqli_error($conexion);
// }
// $envios = [];
// while ($fila = mysqli_fetch_assoc($respuesta)) {
//     $envios[] = $fila;
// }
/**/ 
$manifiesto_id = $_GET['id'];
if(isset($_SESSION['manifiestos'][$manifiesto_id])) {
    $manifiesto = $_SESSION['manifiestos'][$manifiesto_id];
    $envios = $manifiesto['datos'];
    $destino_manifiesto = $manifiesto['destino'];
    $destino_final = $manifiesto['destino_final'];
} else {
    echo "Manifiesto no encontrado";
}

//inserto el manifiesto
$manifiesto= mysqli_query($conexion, "INSERT INTO manifiesto (fecha, sucursal_id , usuario_id) values ('$fecha_actual' , '$sucursal_actual' ,'$u_id')");
if ($manifiesto){
    $manifiesto_id = mysqli_insert_id($conexion);
}
else echo "no se pudo guardar manifiesto";
$total_envios = count($envios);
for($z = 0; $z<$total_envios ; $z++){
    $actualizado = mysqli_query($conexion, "UPDATE envio SET manifiesto_id = $manifiesto_id, manifiesto_sucursal_id = $sucursal_actual WHERE envio.codigo = '{$envios[$z]['codigo']}'");
        
    if (!$actualizado) {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }
}
// Calcular el número total de páginas
$envios_por_pagina = 54;
$total_paginas = ceil($total_envios / $envios_por_pagina);
// Función para generar una página del manifiesto
function generarPagina($envios, $inicio, $fin, $numero_pagina, $total_paginas) {
    global $fecha_actual , $conexion , $sucursal_actual , $respuesta_envios_sucact , $manifiesto_id, $destino_manifiesto , $destino_final;
    ?>
    <div class="pagina">
        <div class="header">
            <h2 class="titulo">MANIFIESTO RESUMEN</h2>
            <table>
                <tr>
                    <td>SUCURSAL:</td>
                    <td><?php echo mysqli_fetch_assoc(mysqli_query($conexion , "SELECT nombre FROM sucursal WHERE id = '$sucursal_actual'"))['nombre'] . " (" . $sucursal_actual . ")"; ?></td>
                    <td>FECHA DE CREACIÓN:</td>
                    <td><?php echo $fecha_actual; ?></td>
                    <td>N°MANIFIESTO:</td>
                    <td><?php echo $manifiesto_id; ?></td>
                </tr>
                <tr>
                    <td>DESTINO:</td>
                    <td><?php 
                    $consulta = mysqli_query($conexion, "SELECT nombre FROM sucursal WHERE id = $destino_manifiesto");
                    $nombre_sucursal = mysqli_fetch_assoc($consulta)['nombre'];
                    echo $nombre_sucursal . " (" . $destino_manifiesto . ")";?></td> 
                    <td>DESTINO FINAL:</td>
                    <td><?php echo $destino_final != null ? mysqli_fetch_assoc(mysqli_query($conexion , "SELECT nombre FROM sucursal WHERE id = '$destino_final'"))['nombre'] . " (" . $destino_final . ")" : ""  ?></td>
                    <td>USUARIO:</td>
                    <td><?php echo $_SESSION['usuario']; ?></td>
                </tr>
            </table>
        </div>

        <div class="tablas-container">
            <?php
            $envios_pagina = array_slice($envios, $inicio, $fin - $inicio);
            $envios_por_tabla = ceil(count($envios_pagina) / 3);
            for ($tabla = 0; $tabla < 3; $tabla++) {
                echo '<table class="tabla-envios">';
                echo '<tr><th>N°</th><th>GUIA</th></tr>';
                for ($i = 0; $i < $envios_por_tabla; $i++) {
                    $indice = $tabla * $envios_por_tabla + $i;
                    if ($indice < count($envios_pagina)) {
                        echo '<tr>';
                        echo '<td>' . ($inicio + $indice + 1) . '</td>';
                        echo '<td>' . $envios_pagina[$indice]['codigo'] . '</td>';
                        echo '</tr>';
                    }
                }
                echo '</table>';
            }
            
            ?>
        </div>

        <?php if ($numero_pagina == $total_paginas) { ?>
            <div class="footer">
                <table>
                    <tr>
                        <td>TRANSPORTE</td>
                    </tr>
                    <tr>
                        <td>
                            NOMBRE, NIT, FIRMA y FECHA
                            <div class="signature-box"></div>
                        </td>
                    </tr>
                </table>
                <p>TOTAL ENVÍOS: <?php echo count($envios) ?></p>
            </div>
        <?php } ?>
        <div class="numero-pagina">Página <?php echo $numero_pagina; ?> de <?php echo $total_paginas; ?></div>
    </div>
    <?php
}

// Generar todas las páginas
for ($pagina = 1; $pagina <= $total_paginas; $pagina++) {
    $inicio = ($pagina - 1) * $envios_por_pagina;
    $fin = min($inicio + $envios_por_pagina, $total_envios);
    generarPagina($envios, $inicio, $fin, $pagina, $total_paginas);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manifiesto Resumen</title>
    <link rel="stylesheet" href="../css/manifiesto.css">
</head>
<body>
    <?php
    // El contenido se genera dinámicamente en el bucle anterior
    ?>
</body>
</html>