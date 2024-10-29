<?php
session_start();
require("../config/dbconnect.php");

if(isset($_GET['delete']) && !empty($_GET['delete']) && isset($_SESSION['logueado'])){
    $codigo_env_eliminar = mysqli_real_escape_string($conexion, $_GET['delete']);
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    mysqli_query($conexion, "SET time_zone = '-03:00';");
    $fecha= date('Y-m-d H:i:s');
    $respuesta = mysqli_query($conexion , "INSERT INTO movimientos (envio_id , fecha , estados_id) VALUES('$codigo_env_eliminar' , '$fecha', 6)");
    if ($respuesta) {
        echo "Envío con código $codigo_env_eliminar eliminado correctamente.";
    } else {
        echo "Error al eliminar el envío: " . mysqli_error($conexion);
    }
}else{
    echo "No se encontró el codigo del envio a eliminar";
}

?>