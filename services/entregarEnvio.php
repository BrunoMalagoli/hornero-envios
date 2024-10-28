<?php
    session_start();
    require("../config/dbconnect.php");
    $cod_entrega = $_GET['cod_entrega'];
    if (isset($cod_entrega) && !empty($cod_entrega) /*&& !empty($_SESSION['logueado'])*/ ) {
        $cod_entrega = mysqli_real_escape_string($conexion, $cod_entrega);
        $fecha = date("d-m-Y");
        $respuesta = mysqli_query($conexion, 
            "INSERT INTO movimientos(fecha,envio_id,estados_id) VALUES ('$fecha' , '$cod_entrega', 5) ;"
        );
    }
        ?>
        <?php
        header("Location: ../pages/comprobante.php?cod_entrega=" . urlencode($_GET['cod_entrega']));
        exit();
        ?>