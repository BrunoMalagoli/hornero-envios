<?php
session_start();
// Conexión a la base de datos
include '../config/dbconnect.php';

// Obtener la fecha actual
$fecha_actual = date('d/m/Y');
$sucursal_actual = $_SESSION['sucursal'];
//traigo los envios que estan admitidos en la sucursal 
$respuesta = mysqli_query($conexion , "SELECT * FROM envio WHERE sucursal_actual = '$sucursal_actual'");

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
    <div class="header">
        <h2>MANIFIESTO RESUMEN</h2>
        <table>
            <tr>
                <td>AGENCIA:</td>
                <td><?php echo $sucursal_actual; ?></td>
                <td>FECHA DE CREACIÓN:</td>
                <td><?php echo $fecha_actual; ?></td>
                <td>N°MANIFIESTO:</td>
                <td><?php echo rand(100000, 999999); // hay q ver como hacer esto ?></td>
            </tr>
            <tr>
                <td>NOMBRE AGENCIA:</td>
                <td><?php echo mysqli_fetch_assoc(mysqli_query($conexion , "SELECT nombre FROM sucursal WHERE id = '$sucursal_actual'"))['nombre']; ?></td>
                <td>FECHA DE RETIRO:</td>
                <td><?php echo $fecha_actual; ?></td>
                <td>USUARIO:</td>
                <td><?php echo $_SESSION['usuario'] ?? 'SISTEMA'; ?></td>
            </tr>
        </table>
    </div>

    <table>
        <tr>
            <th>N°</th>
            <th>PROD</th>
            <th>GUIA</th>
            <th>N°</th>
            <th>PROD</th>
            <th>GUIA</th>
            <th>N°</th>
            <th>PROD</th>
            <th>GUIA</th>
        </tr>
        <?php
        $contador = 1;
        if(mysqli_num_rows($respuesta) > 0){
            while ($fila = mysqli_fetch_assoc($respuesta)) {
                if ($contador % 3 == 1) echo "<tr>";
                echo "<td>" . $fila['codigo'] . "</td>";
                echo "<td>" . $fila['descripcion'] . "</td>";
                echo "<td>" . $fila['guia'] . "</td>";
                if ($contador % 3 == 0) echo "</tr>";
                $contador++;
            }
        }else{
            echo "No hay envios adjuntos";
        }
        // Rellenar las celdas vacías si es necesario
        while ($contador <= 54) {
            if ($contador % 3 == 1) echo "<tr>";
            echo "<td></td><td></td><td></td>";
            if ($contador % 3 == 0) echo "</tr>";
            $contador++;
        }
        ?>
    </table>

    <div class="footer">
        <table>
            <tr>
                <td>PUNTO DE VENTA</td>
                <td>TRANSPORTE</td>
                <td>ESTACIÓN</td>
            </tr>
            <tr>
                <td>
                    NOMBRE, NIT, FIRMA y FECHA
                    <div class="signature-box"></div>
                </td>
                <td>
                    NOMBRE, NIT, FIRMA y FECHA
                    <div class="signature-box"></div>
                </td>
                <td>
                    NOMBRE, NIT, FIRMA y FECHA
                    <div class="signature-box"></div>
                </td>
            </tr>
        </table>
        <p>TOTAL ENVÍOS: <?php echo mysqli_num_rows($respuesta); ?></p>
    </div>
</body>
</html>