<?php
// Datos de ejemplo (reemplaza estos con datos reales de tu sistema)
$empresa = [
    'nombre' => 'HORNERO ENVIOS',
    'direccion' => 'PARIS 532',
    'telefono' => '0303456',
    'email' => 'hornero@envios.com'
];

$entrega = [
    'sucursal_destino' => 'Sucursal Destino',
    'fecha_entrega' => date('d/m/Y'),
    'codigo' => 'COD' . rand(1000000, 9999999),
    'destinatario' => 'Nombre del Destinatario',
    'cuil_destinatario' => '20-12345678-9'
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
                    <span><?php echo $entrega['sucursal_destino']; ?></span>
                </div>
                <div class="campo">
                    <label>Fecha de Entrega:</label>
                    <span><?php echo $entrega['fecha_entrega']; ?></span>
                </div>
                <div class="campo">
                    <label>Código:</label>
                    <span><?php echo $entrega['codigo']; ?></span>
                </div>
                <div class="campo">
                    <label>Destinatario:</label>
                    <span><?php echo $entrega['destinatario']; ?></span>
                </div>
                <div class="campo">
                    <label>CUIL Destinatario:</label>
                    <span><?php echo $entrega['cuil_destinatario']; ?></span>
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