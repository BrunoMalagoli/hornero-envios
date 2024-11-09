<?php
session_start();
require("../config/dbconnect.php");
$sucursal_actual = $_SESSION['sucursal'];
$u_id = $_SESSION['usuario_id'];
$manifiesto_destino = "";
date_default_timezone_set('America/Argentina/Buenos_Aires');
mysqli_query($conexion, "SET time_zone = '-03:00';");
$fecha= date('Y-m-d H:i:s');
//ACORDARSE DE MANDAR LOS DATOS DEL ARRAY POR COOKIES A MANIFIESTO Y TOMARLO DESDE AHI
/*
MANIFIESTO PARA CENTROS CASOS POSIBLES:
1.DE CENTRO A HIJO
2.DE CENTRO A HIJO AJENO
3.DE CENTRO A CENTRO (DESTINO FINAL)
*/
$respuesta_rol_sucursal = mysqli_query($conexion , "SELECT id, rol , centro_designado FROM sucursal WHERE sucursal.id = '$sucursal_actual'");
$datos_rol_origen = mysqli_fetch_assoc($respuesta_rol_sucursal);
$destinos = [];
$envios = [];


if($datos_rol_origen['rol'] == 'sucursal'){ //SUCURSAL 
    $respuesta_envios_sucact = mysqli_query($conexion , "SELECT * FROM envio WHERE envio.sucursal_origen = envio.sucursal_actual AND envio.sucursal_actual = {$sucursal_actual}");
    while($fila = mysqli_fetch_assoc($respuesta_envios_sucact)){
        $envios[] = $fila;
        $result_query = mysqli_query($conexion, "INSERT INTO movimientos(envio_id, estados_id, fecha) VALUES ('" . $fila['codigo'] . "', 2, '$fecha')");
    }
    $manifiesto_destino = $datos_rol_origen['centro_designado'];
    $_SESSION['manifiestos'][] = [
        'datos' => $envios,
        'destino' => $manifiesto_destino,
        'destino_final' => null
    ];
    $manifiesto_id = count($_SESSION['manifiestos']) - 1;
    echo "<script>
        window.open('../pages/manifiesto.php?id={$manifiesto_id}','_blank');
    </script>";

}else { 
    // Código de centro de distribución
    $respuesta_envios_sucact = mysqli_query($conexion, "
    SELECT * 
    FROM envio 
    WHERE envio.sucursal_actual = {$sucursal_actual} 
      AND (
          envio.codigo IN (
              -- Envíos cuyo último estado es 'EN CENTRO DE DISTRIBUCIÓN'
              SELECT envio_id 
              FROM movimientos 
              WHERE estados_id = 3 
              AND fecha = (
                  SELECT MAX(fecha) 
                  FROM movimientos mov 
                  WHERE mov.envio_id = envio.codigo
              )
          )
          OR 
          (
              -- Envíos admitidos directamente en el centro de distribución
              envio.codigo NOT IN (
                  SELECT envio_id 
                  FROM movimientos 
                  WHERE estados_id = 3
              ) 
              AND envio.sucursal_origen = envio.sucursal_actual
              AND envio.sucursal_actual = {$sucursal_actual}
          )
      )
");
    while ($fila = mysqli_fetch_assoc($respuesta_envios_sucact)) {
        $envios[] = $fila;
    }

    // Validar que $envios no esté vacío
    if (empty($envios)) {
        echo "No hay envíos disponibles.";
    } else {
        foreach ($envios as $envio) {
            $destinos[] = (int) $envio['sucursal_destino'];
        }

        $destinos_unic = array_unique($destinos);
        
        foreach ($destinos_unic as $sucursal_destino) {
            echo "Procesando destino: $sucursal_destino<br>";
            
            // Consultar datos de la sucursal de destino
            $respuesta_sucdest = mysqli_query($conexion, "SELECT id, centro_designado, rol FROM sucursal WHERE sucursal.id = '$sucursal_destino'");
            $datos_respuesta_sucdest = mysqli_fetch_assoc($respuesta_sucdest);

            // Validar que la sucursal existe y tiene datos válidos
            if (!$datos_respuesta_sucdest) {
                echo "Error: Sucursal de destino no encontrada.";
                continue;
            }
            
            $envioxmanifiesto = [];
            foreach ($envios as $envio) {
                if ($envio['sucursal_destino'] == $sucursal_destino) {
                    $envioxmanifiesto[] = $envio;
                    mysqli_query($conexion, "INSERT INTO movimientos(envio_id, estados_id, fecha) VALUES ('" . $envio['codigo'] . "', 2, '$fecha')");
                }
            }

            // Lógica para determinar `manifiesto_dest`
            if ($datos_respuesta_sucdest['centro_designado'] == $datos_rol_origen['id']) {
                // Caso centro a hijo
                $manifiesto_dest = $sucursal_destino;
            } else if ($datos_respuesta_sucdest['rol'] == 'centro') {
                // Caso centro a centro (destino final)
                $manifiesto_dest = $sucursal_destino;
            } else {
                // Caso centro a hijo ajeno
                $manifiesto_dest = $datos_respuesta_sucdest['centro_designado'];
            }

            // Guardar el manifiesto en la sesión
            $_SESSION['manifiestos'][] = [
                'datos' => $envioxmanifiesto,
                'destino' => $manifiesto_dest,
                'destino_final' => $sucursal_destino
            ];

            $manifiesto_id = count($_SESSION['manifiestos']) - 1;
            echo "<script>window.open('../pages/manifiesto.php?id={$manifiesto_id}','_blank');</script>";
        }
    }
}
?>