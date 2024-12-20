<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['peso']) && !empty($_POST['largo']) && !empty($_POST['ancho']) && !empty($_POST['alto']) && !empty($_POST['valor']) && !empty($_POST['sucursal_origen']) && !empty($_POST['sucursal_destino']) && !empty($_POST['precio'])&& !empty($_POST['descripcion']) && !empty($_POST['cuil_remitente']) && !empty($_POST['nombre_remitente']) && !empty($_POST['direccion_remitente']) && !empty($_POST['telefono_remitente']) && !empty($_POST['email_remitente']) && !empty($_POST['cuil_destinatario']) && !empty($_POST['nombre_destinatario']) && !empty($_POST['direccion_destinatario']) && !empty($_POST['telefono_destinatario']) && !empty($_POST['email_destinatario']) && !empty($_POST['metodo_pago'])){
        include '../config/dbconnect.php';
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        mysqli_query($conexion, "SET time_zone = '-03:00';");
        $fecha= date('Y-m-d H:i:s');
        $cliente_rem= mysqli_query($conexion, "INSERT INTO cliente (nombre, email, cuil, telefono) values ('$_POST[nombre_remitente]','$_POST[email_remitente]','$_POST[cuil_remitente]','$_POST[telefono_remitente]')");
        if ($cliente_rem){
            $remitente_id = mysqli_insert_id($conexion);
        }
        else echo "no se pudo guardar remitente";

        $cliente_dest= mysqli_query($conexion, "INSERT INTO cliente (nombre, email, cuil, telefono) values ('$_POST[nombre_destinatario]','$_POST[email_destinatario]','$_POST[cuil_destinatario]','$_POST[telefono_destinatario]')");
        if ($cliente_dest){
            $destinatario_id = mysqli_insert_id($conexion);
        }
        else echo "no se pudo guardar destinatario";

        $sucursal_dest = mysqli_query($conexion,"SELECT * from sucursal where nombre='$_POST[sucursal_destino]';");
        $resultado = mysqli_fetch_assoc($sucursal_dest);
        $suc_dest_id = $resultado['id'];
        $direccion_dest = "$resultado[calle], $resultado[numero]";

        $factura= mysqli_query($conexion, "INSERT INTO factura (descripcion, fecha) values ('$_POST[descripcion]','$fecha')");
        if ($factura){
            $factura_id = mysqli_insert_id($conexion);
        }
        else echo "no se pudo guardar factura";

        $sucursal_origen = mysqli_query($conexion,"SELECT * from sucursal where nombre='$_POST[sucursal_origen]';");
        $resultado = mysqli_fetch_assoc($sucursal_origen);
        $suc_orig_id = $resultado['id'];
        $direccion_origen = "$resultado[calle], $resultado[numero]";

        $envio= mysqli_query($conexion, "INSERT INTO envio (fecha, peso, alto, ancho, largo, destinatario, remitente, sucursal_destino,sucursal_actual, sucursal_origen, factura_id, precio, valor_seguro, descripcion) values ('$fecha','$_POST[peso]','$_POST[alto]','$_POST[ancho]','$_POST[largo]','$destinatario_id','$remitente_id','$suc_dest_id','$suc_orig_id','$suc_orig_id', '$factura_id','$_POST[precio]','$_POST[valor]','$_POST[descripcion]')");
        if ($envio){
            $envio_id = mysqli_insert_id($conexion);
            $etiqueta_url = "etiqueta.php?id=" . urlencode($envio_id)."&sucursal_destino=" . urlencode($_POST['sucursal_destino']) . "&sucursal_origen=" . urlencode($_POST['sucursal_origen']) . "&peso=" . urlencode($_POST['peso']) . "&nombre_destinatario=" . urlencode($_POST['nombre_destinatario']) . "&telefono_destinatario=" . urlencode($_POST['telefono_destinatario']) . "&email_destinatario=" . urlencode($_POST['email_destinatario']);
            echo "<script>
                window.open('$etiqueta_url', '_blank');
            </script>";
        }
        else echo "no se pudo guardar envio";

        $codigo_en_factura = mysqli_query($conexion, "UPDATE factura SET envio_id = '$envio_id' WHERE id = '$factura_id';");
        if ($codigo_en_factura == 0){
            echo "No se pudo cargar numero de envio en factura";
        }

        $codigo_operacion = isset($_POST['codigo_operacion']) ? $_POST['codigo_operacion'] : '';
        $pago_en_factura = mysqli_query($conexion, "UPDATE factura SET metodo_pago = '$_POST[metodo_pago]', codigo_operacion = '$codigo_operacion' WHERE id = '$factura_id';");
        if ($pago_en_factura == 0){
            echo "No se pudo cargar numero de envio en factura";
        }

        $estado= mysqli_query($conexion,"INSERT INTO movimientos (fecha, envio_id, estados_id) values ('$fecha', '$envio_id',1)");
        if ($estado){
            $estado = mysqli_insert_id($conexion);
        }
        else echo "no se pudo guardar estado";
   
    }
    else    /*{aca necesito una alerta*/
            /*header("Location:admision-envios.php");
            exit;*/
            echo "No se pudieron recibir los datos de admision de envíos";
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Factura de Envío - Hornero Envíos</title>
        <link rel="stylesheet" href="../css/factura.css">
    </head>
    <body>
        <div class="header">
            <div class="logo">
                <span class="bold"><img id="logo" src="../images/LOGO_TRANSPARENTE.png" alt="Logo"></span>
            </div>
            <div class="header-info">
                <p><span class="bold">CODIGO No.</span> <?php echo $envio_id;?></p>
                <p><span class="bold">FACTURA No.</span> 5375-<?php echo $factura_id;?> <span class="bold">Fecha:</span> <?php echo $fecha;?></p>
                <span class="bold">Teléfono:</span> 0303456
                <span class="bold">Web:</span> www.hornerito.com.ar
            </div>
        </div>

        <div class="border-box full-width">
            <div class="info-grid">
                <div>
                    <span class="bold">Inicio de actividades:</span> 09/09/2024<br>
                    <span class="bold">C.U.I.T.:</span> xx-xxxxxxx-x<br>
                </div>
                <div>
                    <span class="bold">Ingresos Brutos CM</span> xxx-xxxxxx-x<br>
                    <span class="bold">Paris 532</span><br>
                    HAEDO, BUENOS AIRES.
                </div>
            </div>
        </div>

        <div class="inline-containers" style="margin-top: 2mm;">
            <div class="border-box half-width">
                <span class="bold">SUCURSAL ORIGEN:</span><br><?php echo $_POST['sucursal_origen'];?><br>
                <?php echo $direccion_origen?><br><br>
                <span class="bold">REMITENTE:</span><br>
                <?php echo $_POST['nombre_remitente'];?><br>
                CUIL <?php echo $_POST['cuil_remitente'];?><br>
                MERLO<br>
                
            </div>
            <div class="border-box half-width">
                <span class="bold">SUCURSAL DESTINO:</span><br>
                <?php echo $_POST['sucursal_destino'];?><br>
                <?php echo $direccion_dest?><br><br>
                <span class="bold">DESTINATARIO:</span><br>
                <?php echo $_POST['nombre_destinatario'];?><br>
                CUIL <?php echo $_POST['cuil_destinatario'];?><br>
                DESTINO
            </div>
        </div>

        <div class="info-grid" style="margin-top: 2mm;">
            <div class="border-box full-width">
                <span class="bold">ENCOMIENDA</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kg: <?php echo $_POST['peso'];?>                
            </div>
            <div class="border-box full-width">
                <span class="bold">VALOR ASEGURADO $ <?php echo $_POST['valor'];?></span>
            </div>
        </div>

        <div class="price-box text-right">
            <span class="bold">TOTAL: $ <?php echo $_POST['precio'];?></span><br>
        </div>
        
    </body>
</html>