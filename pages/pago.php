<?php
session_start();
if(!isset($_SESSION['logueado'])){
    header("Location:login.php");
    exit;
    }
include '../config/dbconnect.php';
// Verificar si el usuario viene de admision-envios.php
if (!isset($_SESSION['acceso_pago']) || $_SESSION['acceso_pago'] !== true) {
    // Si no viene de admision-envios.php, redirigir al usuario
    header("Location: admision-envios.php");
    exit();
}
date_default_timezone_set('America/Argentina/Buenos_Aires');
mysqli_query($conexion, "SET time_zone = '-03:00';");
$fecha= date('Y-m-d H:i:s');

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pago</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/pago.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="../images/LOGO_TRANSPARENTE.png" alt="LOGO">
            </div>
            <ul class="nav-links">
                <li><a href="admision-envios.php">Admision</a></li>
                <li><a href="captura.php">Captura</a></li>
                <li><a href="consulta-historico.php">Historico</a></li>
                <li><a href="entrega.php">Entrega</a></li>
                <li><a href="inicio-u-suc.php">Inicio</a></li>
                <li><a href="../services/logout.php">Cerrar Sesión</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>
    <div class="container">
        <h1>GESTIÓN DE PAGO</h1>
        <div class="payment-form">
            <table class="envio-data">
                <tr>
                    <th>Fecha</th>
                    <th>Remitente</th>
                    <th>Sucursal Destino</th>
                    <th>Peso (kg)</th>
                    <th>Precio</th>
                </tr>
                <tr>
                    <td><?php echo $fecha; ?></td>
                    <td><?php echo $_POST['nombre_remitente']; ?></td>
                    <td><?php echo $_POST['sucursal_destino']; ?></td>
                    <td><?php echo $_POST['peso']; ?> kgs.</td>
                    <td>$<?php echo $_POST['precio']; ?></td>
                </tr>
            </table>
            <form method="POST" action="factura.php">
                <div class="form-group">
                    <label for="metodo_pago">Método de Pago:</label>
                    <select id="metodo_pago" name="metodo_pago" required>
                        <option value="">Seleccione método de pago</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="transferencia">Transferencia</option>
                    </select>
                </div>
                <div id="codigo_operacion_group" class="form-group hidden">
                    <label for="codigo_operacion">Código de Operación:</label>
                    <input type="text" id="codigo_operacion" name="codigo_operacion">
                </div>

                 <!-- campos ocultos para el envio -->
                <input type="hidden" name="peso" value="<?php echo isset($_POST['peso']) ? $_POST['peso'] : ''; ?>">
                <input type="hidden" name="largo" value="<?php echo isset($_POST['largo']) ? $_POST['largo'] : ''; ?>">
                <input type="hidden" name="ancho" value="<?php echo isset($_POST['ancho']) ? $_POST['ancho'] : ''; ?>">
                <input type="hidden" name="alto" value="<?php echo isset($_POST['alto']) ? $_POST['alto'] : ''; ?>">
                <input type="hidden" name="valor" value="<?php echo isset($_POST['valor']) ? $_POST['valor'] : ''; ?>">
                <input type="hidden" name="descripcion" value="<?php echo isset($_POST['descripcion']) ? $_POST['descripcion'] : ''; ?>">
                <input type="hidden" name="sucursal_origen" value="<?php echo $_POST['sucursal_origen']; ?>">
                <input type="hidden" name="sucursal_destino" value="<?php echo isset($_POST['sucursal_destino']) ? $_POST['sucursal_destino'] : ''; ?>">
                <input type="hidden" name="precio" value="<?php echo $_POST['precio'] ?>">
                <input type="hidden" name="cuil_remitente" value="<?php echo isset($_POST['cuil_remitente']) ? $_POST['cuil_remitente'] : ''; ?>">
                <input type="hidden" name="nombre_remitente" value="<?php echo isset($_POST['nombre_remitente']) ? $_POST['nombre_remitente'] : ''; ?>">
                <input type="hidden" name="direccion_remitente" value="<?php echo isset($_POST['direccion_remitente']) ? $_POST['direccion_remitente'] : ''; ?>">
                <input type="hidden" name="telefono_remitente" value="<?php echo isset($_POST['telefono_remitente']) ? $_POST['telefono_remitente'] : ''; ?>">
                <input type="hidden" name="email_remitente" value="<?php echo isset($_POST['email_remitente']) ? $_POST['email_remitente'] : ''; ?>">
                <input type="hidden" name="cuil_destinatario" value="<?php echo isset($_POST['cuil_destinatario']) ? $_POST['cuil_destinatario'] : ''; ?>">
                <input type="hidden" name="nombre_destinatario" value="<?php echo isset($_POST['nombre_destinatario']) ? $_POST['nombre_destinatario'] : ''; ?>">
                <input type="hidden" name="direccion_destinatario" value="<?php echo isset($_POST['direccion_destinatario']) ? $_POST['direccion_destinatario'] : ''; ?>">
                <input type="hidden" name="telefono_destinatario" value="<?php echo isset($_POST['telefono_destinatario']) ? $_POST['telefono_destinatario'] : ''; ?>">
                <input type="hidden" name="email_destinatario" value="<?php echo isset($_POST['email_destinatario']) ? $_POST['email_destinatario'] : ''; ?>"> 
                
                <div class="button-group">
                    <button id="botonPago" type="submit" class="btn btn-primary">PAGAR</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('metodo_pago').addEventListener('change', function() {
            var codigoOperacionGroup = document.getElementById('codigo_operacion_group');
            if (this.value === 'tarjeta' || this.value === 'transferencia') {
                codigoOperacionGroup.classList.remove('hidden');
                document.getElementById('codigo_operacion').required = true;
            } else {
                codigoOperacionGroup.classList.add('hidden');
                document.getElementById('codigo_operacion').required = false;
            }
        });
    </script>
</body>
</html>