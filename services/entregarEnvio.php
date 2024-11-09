<?php
    session_start();
    require("../config/dbconnect.php");
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    mysqli_query($conexion, "SET time_zone = '-03:00';");
    $cod_entrega = $_GET['cod_entrega'];
    if (isset($cod_entrega) && !empty($cod_entrega) && !empty($_SESSION['logueado']) ) {
        $cod_entrega = mysqli_real_escape_string($conexion, $cod_entrega);
        $fecha = date('Y-m-d H:i:s');
        $respuesta = mysqli_query($conexion, 
            "INSERT INTO movimientos(fecha,envio_id,estados_id) VALUES ('$fecha' , '$cod_entrega', 5) ;"
        );
    }
?>