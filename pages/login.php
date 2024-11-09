<?php
session_start();

include("../config/dbconnect.php");

$usuario = '';
$contrasena = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
        $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
        $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
        $contrasena_encriptada = sha1($contrasena);

       $res = mysqli_query($conexion, "SELECT * FROM usuario WHERE u_name = '$usuario' AND contrasena = '$contrasena_encriptada' LIMIT 1");
      
        if (mysqli_num_rows($res) == 1) {
            $_SESSION['logueado'] = true;
            $resultado = mysqli_fetch_array($res);

            if ($resultado['rol'] === 'admin') {
                header("Location: inicio-admin.php");
                $_SESSION['usuario'] = $resultado['u_name'];
                $_SESSION['rol'] = $resultado['rol'];
            } else {
                $_SESSION['sucursal'] = $resultado['sucursal_id'];
                $_SESSION['usuario'] = $resultado['u_name'];
                $_SESSION['usuario_id'] = $resultado['id'];
                $_SESSION['rol'] = $resultado['rol'];
                header("Location: inicio-u-suc.php");
            }
            exit(); 
        } else {
            echo "<strong>Usuario o contraseña incorrectos.</strong>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/global.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <div class="skyline"></div>
            <form action="" method = "post">
                <h2>INTRODUZCA SUS DATOS PARA INICIAR SESIÓN</h2>
                <div class="input-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>
                <div class="input-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                </div>
                <button type="submit">LOGIN</button>
            </form>
        </div>
    </div>
    <script src="./js/script.js"></script>
</body>
</html>