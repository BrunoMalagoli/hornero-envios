<?php
// Conexión a la base de datos
include '../config/dbconnect.php';

// Obtener la fecha actual
$fecha_actual = date('d/m/Y');

// Consulta para obtener los envíos disponibles para despachar
$query = "SELECT * FROM envio LIMIT 54"; // 54 es el máximo de envíos que caben en el formulario
$resultado = mysqli_query($conexion, $query);

// Obtener detalles de la agencia
$agencia_id = 'BUE006'; // Esto debería venir de una sesión o configuración
$query_agencia = "SELECT * FROM sucursal WHERE id = '$agencia_id'";
$resultado_agencia = mysqli_query($conexion, $query_agencia);
$agencia = mysqli_fetch_assoc($resultado_agencia);

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
                <td><?php echo $agencia['id']; ?></td>
                <td>FECHA DE CREACIÓN:</td>
                <td><?php echo $fecha_actual; ?></td>
                <td>N°MANIFIESTO:</td>
                <td><?php echo rand(100000, 999999); // Ejemplo ?></td>
            </tr>
            <tr>
                <td>NOMBRE AGENCIA:</td>
                <td><?php echo $agencia['nombre']; ?></td>
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
            <th>BULTOS</th>
            <th>N°</th>
            <th>PROD</th>
            <th>GUIA</th>
            <th>BULTOS</th>
            <th>N°</th>
            <th>PROD</th>
            <th>GUIA</th>
            <th>BULTOS</th>
        </tr>
        <?php
        $contador = 1;
        $total_envios = 0;
        $total_bultos = 0;
        while ($fila = mysqli_fetch_assoc($resultado)) {
            if ($contador % 3 == 1) echo "<tr>";
            echo "<td>" . $contador . "</td>";
            echo "<td>" . $fila['producto'] . "</td>";
            echo "<td>" . $fila['guia'] . "</td>";
            echo "<td>" . $fila['bultos'] . "</td>";
            if ($contador % 3 == 0) echo "</tr>";
            $contador++;
            $total_envios++;
            $total_bultos += $fila['bultos'];
        }
        // Rellenar las celdas vacías si es necesario
        while ($contador <= 54) {
            if ($contador % 3 == 1) echo "<tr>";
            echo "<td></td><td></td><td></td><td></td>";
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
        <p>TOTAL ENVÍOS: <?php echo $total_envios; ?></p>
        <p>TOTAL BULTOS: <?php echo $total_bultos; ?></p>
    </div>
</body>
</html>