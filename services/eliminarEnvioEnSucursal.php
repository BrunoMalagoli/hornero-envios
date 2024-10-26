<?php
require("../config/dbconnect.php");

if(isset($_GET['delete']) && !empty($_GET['delete'])){
    $codigo_env_eliminar = mysqli_real_escape_string($conexion, $_GET['delete']);
    $respuesta = mysqli_query($conexion , "DELETE FROM envio WHERE envio.codigo = '$codigo_env_eliminar'");
    if ($respuesta) {
        echo "Envío con código $codigo_env_eliminar eliminado correctamente.";
    } else {
        echo "Error al eliminar el envío: " . mysqli_error($conexion);
    }
}else{
    echo "No se encontró el codigo del envio a eliminar";
}

?>