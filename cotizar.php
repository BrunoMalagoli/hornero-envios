<?php

    $peso = $_POST['peso'];
    $alto = $_POST['alto'];
    $ancho = $_POST['ancho'];
    $largo = $_POST['largo'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];

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
        $precio_base = 1000;
        $precio_x_kg = 5;
        $precio_x_alt = 2;
        $precio_x_anc = 3;
        $precio_x_lar = 2;

        $resultado = $precio_base + ($precio_x_kg * $peso) + ($precio_x_alt * $alto) + ($precio_x_anc * $ancho) + ($precio_x_lar * $largo);            
    }
    
    echo "El precio total es $resultado";
?>