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
            <div class="logo-space">
                <!-- Espacio para tu logo -->
            </div>
            <form>
                <h2>INTRODUZCA SUS DATOS PARA INICIAR SESIÓN</h2>
                <div class="input-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>
                <div class="input-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="recordar" name="recordar">
                    <label for="recordar">Recordar</label>
                </div>
                <button type="submit">LOGIN</button>
            </form>
        </div>
    </div>
</body>
</html>