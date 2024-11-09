<?php
session_start();
include("../config/dbconnect.php");
if(!isset($_SESSION['logueado'])){
    header("Location:login.php");
    exit;
}

$message = ''; 

if (isset($_POST["buscar_envio"])) 
{ 
    $codigo = mysqli_real_escape_string($conexion, $_POST['codigo_envio']);
    $sucursal_usuario = $_SESSION['sucursal'];
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    mysqli_query($conexion, "SET time_zone = '-03:00';");
    $fecha = date('Y-m-d H:i:s');

    //aca busco que tipo de sucursal es
    $resultadosucursal = mysqli_query($conexion, "SELECT rol, id FROM sucursal WHERE id = '$sucursal_usuario'");
    // Actualizar la sucursal_actual en la tabla envio
    $actualizarSucActual = mysqli_query($conexion, "UPDATE envio SET sucursal_actual = '$sucursal_usuario' WHERE codigo = $codigo");
    if (mysqli_num_rows($resultadosucursal) > 0) 
    {
        $fila = mysqli_fetch_assoc($resultadosucursal);
        if ($fila['rol'] == "centro") 
        {   //aca veo se si es el centro 
            $resultadodestino = mysqli_query($conexion, "SELECT sucursal_destino FROM envio WHERE codigo = '$codigo'"); //veo cual es el destino
            if (mysqli_num_rows($resultadodestino) > 0) 
            {
                $filadestino = mysqli_fetch_assoc($resultadodestino);
                if ($filadestino['sucursal_destino'] == $sucursal_usuario)
                { // si el destino es el centro...                        
                    $resultadocentrodestino = mysqli_query($conexion, "INSERT INTO movimientos (fecha, envio_id, estados_id) VALUES ('$fecha','$codigo',4)"); //coloco el movimiento de destino
                    if ($resultadocentrodestino == false) 
                    {
                        $message = "Error al registrar captura: " . mysqli_error($conexion);
                    }
                    else {
                        $message = "Registro de captura exitoso";
                    }
                } 
                else {
                    $resultadocentrodestino = mysqli_query($conexion, "INSERT INTO movimientos (fecha, envio_id, estados_id) VALUES ('$fecha','$codigo',3)"); //coloco el movimiento de centro
                    if ($resultadocentrodestino == false) 
                    {
                        $message = "Error al registrar captura: " . mysqli_error($conexion);
                    } 
                    else {
                        $message = "Registro de captura exitoso";
                    }
                }
            }  
            else {
                $message = "El envio no existe";
            }
        }          
        else if ($fila['rol'] == "sucursal") 
        {
            $resultadodestino = mysqli_query($conexion, "SELECT sucursal_destino FROM envio WHERE codigo = '$codigo'"); //veo cual es el destino
            if (mysqli_num_rows($resultadodestino) > 0) 
            {
                $filadestino = mysqli_fetch_assoc($resultadodestino);
                if ($filadestino['sucursal_destino'] == $sucursal_usuario) 
                { // si el destino es mi sucursal
                    $resultadocentrodestino = mysqli_query($conexion, "INSERT INTO movimientos (fecha, envio_id, estados_id) VALUES ('$fecha','$codigo',4)"); //coloco el movimiento de destino
                    if ($resultadocentrodestino == false) 
                    {
                        $message = "Error al registrar captura: " . mysqli_error($conexion);
                    } 
                    else {
                        $message = "Registro de captura exitoso";
                    }
                } 
                else {
                    $message = "No se puede registrar el envio por no ser la sucursal de destino";
                }   
            }
            else {
                $message = "El envio no existe";
            }
        }
    }     
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAPTURA</title>
    <link rel="stylesheet" href="../css/captura.css">
    <link rel="stylesheet" href="../css/global.css">
</head>
<body class="main-content">
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="../images/LOGO_TRANSPARENTE.png" alt="Logo de la empresa">
            </div>
            <ul class="nav-links">
                <li><a href="admision-envios.php">Admision</a></li>
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
                <div class="line4"></div>
                <div class="line5"></div>
            </div>
        </nav>
    </header>
    <div class="window">
        <div class="top-bar">
            <h1>CAPTURA</h1>
            <div class="top-bar-right">
                
            </div>
        </div>
        <div class="content">
            <div class="section-header">
                <h2>Captura de lecturas</h2>
            </div>
            <form id="codigo-form" method="POST">
                <div class="form-group">
                    <label for="codigo-envio">Código de envio:</label>
                    <input type="text" id="codigo_envio" name="codigo_envio" required>
                </div>
                <button type="submit" class="btn btn-primary" name="buscar_envio">BUSCAR</button>
            </form>
            <?php if (!empty($message)): ?>
                <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>