<?php

    function calculo_Envio (){
        require("calcularDistancia.php");
        include '../config/dbconnect.php';
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){ 
            $peso = $_POST['peso'];
            $alto = $_POST['alto'];
            $ancho = $_POST['ancho'];
            $largo = $_POST['largo'];
            $valor_seguro = $_POST['valor'];
            $max_peso = 100; //kg
            $max_altura = 200; //cm
            $max_ancho = 100; //cm
            $max_largo = 150; //cm

            $mensaje = "";

            if ($peso > $max_peso) {
                $mensaje = "No se pudo realizar la cotización porque el peso excede el límite de $max_peso kg.";
                echo $mensaje;
                exit;
            } elseif ($alto > $max_altura) {
                $mensaje = "No se pudo realizar la cotización porque la altura excede el límite de $max_altura cm.";
                echo $mensaje;
                exit;
            } elseif ($ancho > $max_ancho) {
                $mensaje = "No se pudo realizar la cotización porque el ancho excede el límite de $max_ancho cm.";
                echo $mensaje;
                exit;
            } elseif ($largo > $max_largo) {
                $mensaje = "No se pudo realizar la cotización porque el largo excede el límite de $max_largo cm.";
                echo $mensaje;
                exit;
            } else {
                $resultado = 0;
                $precio_base = 4000;
                $precio_x_kg = 20;
                $precio_x_alt = 20;
                $precio_x_anc = 20;
                $precio_x_lar = 20;
                
                $sucursal_dest = mysqli_query($conexion,"SELECT * from sucursal where id ='$_POST[sucursal_destino]' or nombre ='$_POST[sucursal_destino]';");
                $respuesta = mysqli_fetch_assoc($sucursal_dest);
                $destino = "$respuesta[calle], $respuesta[numero], $respuesta[localidad]";

                $sucursal_origen = mysqli_query($conexion,"SELECT * from sucursal where id ='$_POST[sucursal_origen]' or nombre ='$_POST[sucursal_origen]';");
                $respuesta1 = mysqli_fetch_assoc($sucursal_origen);
                $origen = "$respuesta1[calle], $respuesta1[numero], $respuesta1[localidad]";

                $distancia =  obtenerDistancia($origen, $destino);
                $precio_envio = 0;
                
                if ($distancia < 0) {
                    echo "Error: la distancia no puede ser negativa.";
                    return;
                } elseif ($distancia <= 10) {
                    $precio_envio = 2000;
                } elseif ($distancia <= 15) {
                    $precio_envio = 3000;
                } elseif ($distancia <= 20) {
                    $precio_envio = 4000;
                } elseif ($distancia <= 30) {
                    $precio_envio = 5000;
                }

                $resultado = $precio_base + ($precio_x_kg * $peso) + ($precio_x_alt * $alto) + ($precio_x_anc * $ancho) + ($precio_x_lar * $largo) + $precio_envio + ($valor_seguro * 0.02);   
            } 
            return $resultado;
        }
        else echo "No se pudo realizar cotización";
}
?>