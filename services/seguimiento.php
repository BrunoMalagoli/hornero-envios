<?php
require("../config/dbconnect.php");

// Depuración para ver si el campo está presente en $_POST
if (empty($_POST['codigo'])) {
    echo "Error: Código de seguimiento no proporcionado.";
    exit;
}

// Escapar y usar el código
$codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);

// Consulta de envío
$resultado = mysqli_query($conexion, "SELECT * FROM envio WHERE codigo = '$codigo';");

if (!$resultado) {
    echo "Error en la consulta de envío: " . mysqli_error($conexion);
    exit;
}

if (mysqli_num_rows($resultado) == 0) {
    echo "<div class='resultadoSeguimiento'><p>No se encontraron movimientos para el código de seguimiento.</p></div>";
} else {
    $envio = mysqli_fetch_assoc($resultado); 
    $envio_id = $envio['codigo'];

    // Consulta de movimientos
    $resultado_mov = mysqli_query($conexion, "SELECT M.fecha, E.nombre FROM movimientos M, estados E WHERE M.estados_id = E.id AND M.envio_id = '$envio_id';");

    if (!$resultado_mov) {
        echo "Error en la consulta de movimientos: " . mysqli_error($conexion);
        exit;
    }

    echo '<div class="resultadoSeguimiento">
            <table>
                <thead>
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>';

    while($res = mysqli_fetch_assoc($resultado_mov)) {
        echo "<tr>
                <td>{$res['fecha']}</td>
                <td>{$res['nombre']}</td>
              </tr>";
    }

    echo '</tbody></table></div>';
}
?>