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
        //GENERAR MOVIMIENTOS EN VIAJE
    }
    $manifiesto_destino = $datos_rol_origen['centro_designado'];
    setcookie('datos_manifiesto', serialize($envios), time() + 1100 , "/");
    setcookie('destino_manifiesto', serialize($manifiesto_destino), time() + 1100 , "/");
    echo "<script>
        window.open('../pages/manifiesto.php','_blank');
    </script>";
}else{ //CENTRO DISTRIBUCION
    $respuesta_envios_sucact = mysqli_query($conexion, "
    SELECT * 
    FROM envio 
    WHERE envio.sucursal_actual = {$sucursal_actual} 
      AND envio.codigo IN (
          SELECT envio_id 
          FROM movimientos 
          WHERE estados_id = 3 
          AND fecha = (
              SELECT MAX(fecha) 
              FROM movimientos mov 
              WHERE mov.envio_id = envio.codigo
          )
      )
");
    
    while($fila = mysqli_fetch_assoc($respuesta_envios_sucact)){
        $envios[] = $fila;
    }
    for($i = 0 ; $i<count($envios) ; $i++){
        $destinos[$i] = (int) $envios[$i]['sucursal_destino'];
    }
    $destinos_unic = array_unique($destinos);
    echo count($destinos);
    for($i = 0 ; $i<count($destinos) ; $i++){
        $sucursal_destino = $destinos[$i];
        $respuesta_sucdest = mysqli_query($conexion , "SELECT id,centro_designado,rol FROM sucursal WHERE sucursal.id = '$sucursal_destino'");
        //ESTE CASO ES SI EL DESTINO TIENE COMO CENTRO_DESIGNADO EL MISMO QUE NUESTRA SUCURSAL
        $datos_respuesta_sucdest = mysqli_fetch_assoc($respuesta_sucdest);
        $envioxmanifiesto = [];
        
        for($j = 0 ;  $j<count($envios) ; $j++){
            if($envios[$j]['sucursal_destino'] == $sucursal_destino){
                $envioxmanifiesto[] = $envios[$j];
                $result_query = mysqli_query($conexion, "INSERT INTO movimientos(envio_id, estados_id, fecha) VALUES ('" . $envios[$j]['codigo'] . "', 2, '$fecha')");
                echo $result_query;
            }
        }       
        
        //CENTRO A HIJO
        if($datos_respuesta_sucdest['centro_designado'] ==  $datos_rol_origen['id']){
                $manifiesto_dest = $sucursal_destino;
        }  
        else if($datos_respuesta_sucdest['rol'] == 'centro'){
            //CENTRO A CENTRO (DESTINO FINAL)
            $manifiesto_dest = $sucursal_destino;
        }
        else{
                //CENTRO A HIJO AJENO
                $manifiesto_dest = $datos_respuesta_sucdest['centro_designado'];
        }      
        
        $_SESSION['manifiestos'][] = [
            'datos' => $envioxmanifiesto,
            'destino' => $manifiesto_dest
        ];
        $manifiesto_id = count($_SESSION['manifiestos']) - 1;
        
        echo "<script>
            window.open('../pages/manifiesto.php?id={$manifiesto_id}','_blank');
        </script>";

    }
}
?>