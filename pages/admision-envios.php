<?php
session_start();
$sucursal = $_SESSION["sucursal"];
$_SESSION['acceso_pago'] = true;
include("../config/dbconnect.php");

if(!isset($_SESSION['logueado'])){
header("Location:login.php");
exit;
}


$precio = 0; 
$mostrarFormulario = false; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] === 'ver_precio') {
            // Calculamos el precio
            include '../services/funciones.php';
            if (!empty($_POST['peso']) && !empty($_POST['largo']) && !empty($_POST['ancho']) && !empty($_POST['alto'])) {
                $precio = calculo_Envio($_POST);
                $mostrarFormulario = true; 
            }
        }
    }
}

function obtenerValor($campo) {
    return isset($_POST[$campo]) ? htmlspecialchars($_POST[$campo]) : '';
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admisión de Envíos</title>
        <link rel="stylesheet" href="../css/admision.css">
        <link rel="stylesheet" href="../css/global.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
    </head>
    <body>
        <header>
            <nav class="navbar">
                <div class="logo">
                    <img src="../images/LOGO_TRANSPARENTE.png" alt="LOGO">
                </div>
                <ul class="nav-links">
                    <li><a style="background-color: #170f38" href="admision-envios.php">Admision</a></l>
                    <li><a href="captura.php">Captura</a></li>
                    <li><a href="consulta-historico.php">Historico</a></li>
                    <li><a href="entrega.php">Entrega</a></li>
                    <li><a href="inicio-u-suc.php">Inicio</a></li>
                    <p>USUARIO : 
                    <?php
                        require("../config/dbconnect.php");
                        $sucursal_actual = $_SESSION['sucursal'];
                        echo mysqli_fetch_assoc(mysqli_query($conexion , "SELECT nombre FROM sucursal WHERE id = '$sucursal_actual'"))['nombre'] . " (" . $sucursal_actual . ")";
                    ?>
                    </p>
                    <li><a href="../services/logout.php">Cerrar Sesión</a></li>
                </ul>
                <div class="burger">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                </div>
            </nav>
        </header>
        <div class="main-container">
            <h1>ADMISIÓN DE ENVÍOS</h1>
            
            
            <form method="post" action="">
                <div class="bordered-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Origen</label>
                            <input type="text" name="sucursal_origen" 
                            value="<?php require('../config/dbconnect.php'); 
                            $respuesta = mysqli_query($conexion , "SELECT nombre from sucursal WHERE sucursal.id = '" . $_SESSION['sucursal'] . "'");
                            echo mysqli_fetch_assoc($respuesta)['nombre'] ; //trae el nombre de la sucursal?>" readonly> 
                        </div>
                        <div class="form-group">
                            <label>Destino</label>
                                <select name="sucursal_destino" required>
                                    <option value="">Seleccione un destino</option>
                                    <?php
                                    include '../config/dbconnect.php';
                                    $consulta = mysqli_query($conexion, "SELECT nombre FROM sucursal;");
                                    if ($consulta) {
                                        while($resultados = mysqli_fetch_assoc($consulta)) {
                                            $selected = ($resultados['nombre'] == obtenerValor('sucursal_destino')) ? 'selected' : '';
                                            echo '<option value="' . $resultados['nombre'] . '" ' . $selected . '>' . $resultados['nombre'] . '</option>';
                                        }
                                    } else {
                                        echo '<option>No hay sucursales disponibles</option>';
                                    }
                                    ?>
                                </select>
                        </div>
                        <div class="form-group">
                            <label>Fecha Envío</label>
                            <input type="text" name="fecha" value="<?php echo date('d/m/Y'); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Peso (Kg)</label>
                            <input type="text" name="peso" pattern="[0-9]+" maxlength="2" placeholder="Kg." required value="<?php echo obtenerValor('peso'); ?>">
                        </div>
                        <div class="form-group">
                            <label>Largo (cm)</label>
                            <input type="text" name="largo" pattern="[0-9]+" maxlength="3" placeholder="Cm." required value="<?php echo obtenerValor('largo'); ?>">
                        </div>
                        <div class="form-group">
                            <label>Ancho (cm)</label>
                            <input type="text" name="ancho" pattern="[0-9]+" maxlength="3" placeholder="Cm." required value="<?php echo obtenerValor('ancho'); ?>">
                        </div>
                        <div class="form-group">
                            <label>Alto (cm)</label>
                            <input type="text" name="alto" pattern="[0-9]+" maxlength="3" placeholder="Cm." required value="<?php echo obtenerValor('alto'); ?>">
                        </div>
                        <div class="form-group">
                            <label>Valor Mercancía</label>
                            <input type="text" name="valor" pattern="[0-9]+" maxlength="6" placeholder="Valor en $" required value="<?php echo obtenerValor('valor'); ?>">
                        </div>
                    </div>
                </div>

                <div class="bottom-section">
                    <div class="bottom-fields">
                        <div class="form-group">
                            <label>Descripción General</label>
                            <input type="text" name="descripcion" value="<?php echo obtenerValor('descripcion'); ?>" required>
                        </div>
                    </div>
                    <div class="view-price-btn">
                        <button type="submit" class="btn btn-save" name="accion" value="ver_precio">VER PRECIO</button>
                    </div>
                </div>
            </form>                           
                <!-- Muestra el precio -->
                <div class="price-box">
                    HORNERO ENVÍOS<br>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($precio) && $precio > 0) {
                        echo "<p>Precio: \$$precio</p>";
                    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'ver_precio') {
                        echo "<p>Por favor, complete todos los campos para calcular el precio.</p>";
                    }
                    ?>
                </div>
            
            <form id="senderReceiverForm" method="POST" action="pago.php" target="_blank" onsubmit="return validarGuardar()">        
                <!-- Sección de remitente y destinatario -->
                <div class="sender-receiver-section">
                    <div class="rol-form-section">
                        <h2>REMITENTE</h2>
                        <div class="form-group">
                            <label>CUIL</label>
                            <input type="text" name="cuil_remitente" required>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre_remitente" required>
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" name="direccion_remitente" required>
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" name="telefono_remitente" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email_remitente" required>
                        </div>
                    </div>
                    <div class="rol-form-section">
                        <h2>DESTINATARIO</h2>
                        <div class="form-group">
                            <label>CUIL</label>
                            <input type="text" name="cuil_destinatario" required>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre_destinatario" required>
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" name="direccion_destinatario" required>
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" name="telefono_destinatario" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email_destinatario" required>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" name="peso" value="<?php echo isset($_POST['peso']) ? $_POST['peso'] : ''; ?>">
                <input type="hidden" name="largo" value="<?php echo isset($_POST['largo']) ? $_POST['largo'] : ''; ?>">
                <input type="hidden" name="ancho" value="<?php echo isset($_POST['ancho']) ? $_POST['ancho'] : ''; ?>">
                <input type="hidden" name="alto" value="<?php echo isset($_POST['alto']) ? $_POST['alto'] : ''; ?>">
                <input type="hidden" name="valor" value="<?php echo isset($_POST['valor']) ? $_POST['valor'] : ''; ?>">
                <input type="hidden" name="descripcion" value="<?php echo isset($_POST['descripcion']) ? $_POST['descripcion'] : ''; ?>">
                <input type="hidden" name="sucursal_origen" value="<?php echo $_POST['sucursal_origen']; ?>">
                <input type="hidden" name="sucursal_destino" value="<?php echo isset($_POST['sucursal_destino']) ? $_POST['sucursal_destino'] : ''; ?>">
                <input type="hidden" name="precio" value="<?php echo $precio; ?>">
                <!-- Botón para guardar -->
                <div class="buttons">
                    <button type="submit" class="btn btn-save" name="accion" value="guardar">GUARDAR</button>
                </div>
            </form>
        </div>

        <script>
        function validarGuardar() {
            var precio = <?php echo $precio; ?>;
            if (precio <= 0) {
                alert('Por favor, calcule el precio antes de guardar.');
                return false;
            }
            // Si el precio es válido, recargamos la página actual después de un breve retraso
            setTimeout(function() {
                window.location.href = window.location.pathname;
            }, 100);
            return true;
        }

        // Mostrar u ocultar el formulario según el valor de $mostrarFormulario
        document.addEventListener('DOMContentLoaded', function() {
            var senderReceiverForm = document.getElementById('senderReceiverForm');
            senderReceiverForm.style.display = <?php echo $mostrarFormulario ? "'block'" : "'none'"; ?>;
        });
        
        </script>
        <script src="../js/script.js"></script>
    </body>
</html>