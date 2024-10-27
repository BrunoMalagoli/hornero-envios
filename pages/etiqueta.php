<?php
include '../config/dbconnect.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');
mysqli_query($conexion, "SET time_zone = '-03:00';");
$codigo = $_GET['id'];
$destino = $_GET['sucursal_destino'];
$destinatario = $_GET['nombre_destinatario'];
$origen = $_GET['sucursal_origen'];
$peso = $_GET['peso'];
$fecha = date('Y-m-d H:i:s');
$telefono = $_GET['telefono_destinatario'];
$email = $_GET['email_destinatario'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta de Envío</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <link rel="stylesheet" href="../css/etiqueta.css">
</head>
<body>
    <div class="etiqueta">
        <div class="destino"><?php echo htmlspecialchars($destino); ?></div>
        <div class="grid">
            <div class="box">CODIGO: <?php echo htmlspecialchars($codigo); ?></div>
            <div class="box">DE: <?php echo htmlspecialchars($origen); ?></div>
            <div class="box">
                FECHA: <?php echo htmlspecialchars($fecha); ?>
            </div>
            <div class="box">
                PESO: <?php echo htmlspecialchars($peso); ?> kgs.
            </div>
        </div>        
        <svg id="barcode"></svg>
            <div class="box">
                DESTINATARIO: <?php echo htmlspecialchars($destinatario); ?><br>
                TELEFONO: <?php echo htmlspecialchars($telefono); ?><br>
                EMAIL: <?php echo htmlspecialchars($email); ?><br>
                SUCURSAL DESTINO : <?php echo htmlspecialchars($destino); ?>
            </div>        
    </div>

    <script>
        JsBarcode("#barcode", "<?php echo $codigo; ?>", {
            format: "CODE128",
            width: 2,
            height: 100,
            displayValue: false
        });
    </script>
</body>
</html>