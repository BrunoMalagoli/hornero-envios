<?php
    require("../config/dbconnect.php");
    $cod_entrega = mysqli_real_escape_string($conexion, $_GET['cod_entrega']);
    $respuesta = mysqli_query($conexion, 
    "SELECT envio.*, cliente.*, sucursal_destino.nombre AS suc_destino  
    FROM envio 
    INNER JOIN cliente ON envio.destinatario = cliente.id
    INNER JOIN sucursal AS sucursal_destino ON envio.sucursal_destino = sucursal_destino.id 
    WHERE envio.codigo = '$cod_entrega'"
    );
    if($respuesta){
        $contenido = mysqli_fetch_assoc($respuesta);
    }else{
        echo "Ocurrio un error en la consulta" . mysqli_error($conexion);
    }
    $empresa = [
        'nombre' => 'HORNERO ENVIOS',
        'direccion' => 'PARIS 532',
        'telefono' => '0303456',
        'email' => 'hornero@envios.com'
    ];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Entrega</title>
    <link rel="stylesheet" href="../css/comprobante.css">
</head>
<body>
    <div class="comprobante">
        <header>
            <div class="logo">
                <img src="../images/LOGO_TRANSPARENTE.png" alt="Logo de la empresa">
            </div>
            <div class="datos-empresa">
                <h1><?php echo $empresa['nombre']; ?></h1>
                <p><?php echo $empresa['direccion']; ?></p>
                <p>Tel: <?php echo $empresa['telefono']; ?></p>
                <p>Email: <?php echo $empresa['email']; ?></p>
            </div>
        </header>

        <main>
            <h2>Comprobante de Entrega</h2>
            <div class="info-entrega">
                <div class="campo">
                    <label>Sucursal Destino:</label>
                    <span><?php echo $contenido['suc_destino']; ?></span>
                </div>
                <div class="campo">
                    <label>Fecha de Entrega:</label>
                    <span><?php echo date('d-m-Y'); ?></span>
                </div>
                <div class="campo">
                    <label>Código:</label>
                    <span><?php echo $cod_entrega; ?></span>
                </div>
                <div class="campo">
                    <label>Destinatario:</label>
                    <span><?php echo $contenido['nombre']; ?></span>
                </div>
                <div class="campo">
                    <label>CUIL Destinatario:</label>
                    <span><?php echo $contenido['cuil']; ?></span>
                </div>
            </div>

            <div class="firma-seccion">
                <div class="campo-firma">
                    <label>Firma:</label>
                    <div class="linea"></div>
                </div>
                <div class="campo-firma">
                    <label>Aclaración:</label>
                    <div class="linea"></div>
                </div>
                <div class="campo-firma">
                    <label>CUIL:</label>
                    <div class="linea"></div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>