<?php

session_start();
include("../config/dbconnect.php");
//  if(!isset($_SESSION['logueado'])){
//  header("Location:login.php");
//  exit;
//  }
$resultadoSucursales = mysqli_query($conexion, "SELECT id, nombre FROM sucursal ORDER BY id ASC");

$sucursales = [];
while ($sucursal = mysqli_fetch_assoc($resultadoSucursales)) {
    $sucursales[] = $sucursal;
}

/*REGISTRO USUARIO*/
if (isset($_POST["registrar_usuario"])) { 
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $rol = mysqli_real_escape_string($conexion, $_POST['rol']);
    $contrasena_encriptada = sha1($contrasena);

    $resultadouser = mysqli_query($conexion, "SELECT id FROM usuario WHERE u_name = '$nombre'");

    if (mysqli_num_rows($resultadouser) > 0) {
        echo "El usuario ya existe";
    } else {
        if ($rol == "admin") {
            $resultadoadmin = mysqli_query($conexion, "INSERT INTO usuario (u_name, contrasena, email, rol) VALUES ('$nombre', '$contrasena_encriptada', '$email', 'admin')");
            if ($resultadoadmin === false) {
                echo "Error al registrarse: " . mysqli_error($conexion);
            } else {
                echo "Registro exitoso de administrador";
            }
        } else {
            $sucursal = mysqli_real_escape_string($conexion, $_POST['sucursal']);
            if (empty($sucursal)) {
                echo "Error: Debe seleccionar una sucursal para usuarios no administradores";
            } else {
                $resultadusuario = mysqli_query($conexion, "INSERT INTO usuario (u_name, contrasena, email, rol, sucursal_id) VALUES ('$nombre', '$contrasena_encriptada', '$email', 'u-suc', '$sucursal')");
                if ($resultadusuario === false) {
                    echo "Error al registrarse: " . mysqli_error($conexion);
                } else {
                    echo "Registro exitoso de usuario de sucursal";
                }
            }
        }
    }
}

/*REGISTRO SUCURSAL*/

if (isset($_POST["registrar_sucursal"])){
    $nombre_sucursal = mysqli_real_escape_string($conexion, $_POST['nombre-sucursal']);
    $calle =mysqli_real_escape_string($conexion, $_POST['calle']);
    $numero = filter_var($_POST['numero'], FILTER_VALIDATE_INT);
    $localidad =mysqli_real_escape_string($conexion, $_POST['localidad']);
    $codigo_postal = filter_var($_POST['codigo-postal'], FILTER_VALIDATE_INT);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $rol = mysqli_real_escape_string($conexion, $_POST['rol']);

    $resultadosucursal = mysqli_query($conexion, "SELECT id FROM sucursal WHERE nombre = '$nombre_sucursal' and calle = '$calle' and numero = '$numero' ");

    if (mysqli_num_rows($resultadosucursal) > 0) {
        echo "La sucursal ya existe";
    } else {
        if ($rol == "sucursal") {
            $resultadosuc = mysqli_query($conexion, "INSERT INTO sucursal (nombre, calle, numero, localidad, cp, telefono, rol) VALUES ('$nombre_sucursal', '$calle', $numero, '$localidad',$codigo_postal,'$telefono', 'sucursal')");
            if ($resultadosuc === false) {
                echo "Error al registrar: " . mysqli_error($conexion);
            } else {
                echo "Registro exitoso";
            }
        } else {
            $resultadocentro = mysqli_query($conexion, "INSERT INTO sucursal (nombre, calle, numero, localidad, cp, telefono, rol) VALUES ('$nombre_sucursal', '$calle', $numero, '$localidad',$codigo_postal,'$telefono', 'centro')");
            if ($resultadocentro=== false) {
                echo "Error al registrar: " . mysqli_error($conexion);
            } else {
                echo "Registro exitoso";
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
    <title>Panel de Administración - Sistema de Gestión de Envíos</title>
    <link rel="stylesheet" href="../css/inicio-admin.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Registro de Usuarios</h2>
        <form id="user-form" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Rol:</label>
                <input type="radio" id="admin" name="rol" value="admin">
                <label for="admin">Administrador</label>
                <input type="radio" id="u-suc" name="rol" value="u-suc">
                <label for="u-suc">U-Suc</label>
            </div>
            <div class="form-group" id="sucursal-group" style="display:none;">
                <label for="sucursal">Sucursal:</label>
                     <select id="sucursal" name="sucursal">
                         <option value="">Seleccione una sucursal</option>
                         <?php foreach ($sucursales as $sucursal): ?>
                         <option value="<?php echo $sucursal['id']; ?>"><?php echo htmlspecialchars($sucursal['nombre']); ?></option>
                         <?php endforeach; ?>
                    </select>
            </div>
            </div>
            <button type="submit" name= "registrar_usuario">REGISTRAR</button>
        </form>
        
        <?php $busqueda = '';
        if (isset($_POST['buscar'])) {
         $busqueda = mysqli_real_escape_string($conexion, $_POST['buscar']);
        }
        
        $resultadoUsuarios = mysqli_query($conexion, "
                                                SELECT u.id, u.u_name, u.email, u.rol, s.nombre AS sucursal_nombre
                                                FROM usuario u
                                                LEFT JOIN sucursal s ON u.sucursal_id = s.id
                                                WHERE u.u_name LIKE '%$busqueda%' OR u.email LIKE '%$busqueda%'
                                             ");
        ?>
        
        <div class="search-box">
        <form method="POST">
        <input type="text" name="buscar" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Buscar usuario...">
        <button type="submit">Buscar</button>
    </form>
</div>
<?php
if (isset($_POST['eliminar_usuario'])) {
    $usuario_id = mysqli_real_escape_string($conexion, $_POST['usuario_id']);
    $resultadoEliminar = mysqli_query($conexion, "DELETE FROM usuario WHERE id = '$usuario_id'");

    if ($resultadoEliminar) {
        echo "Usuario eliminado exitosamente";
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($conexion);
    }
}
?>


<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Sucursal</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="tabla-usuarios">
        <?php while ($usuario = mysqli_fetch_assoc($resultadoUsuarios)): ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario['u_name']); ?></td>
                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                <td><?php echo  htmlspecialchars($usuario['sucursal_nombre'] ? $usuario['sucursal_nombre'] : '-') . '</td>'; ?></td>
                <td>
             <form method="POST" style="display:inline;">
             <input type="hidden" name="usuario_id" value="<?php echo $usuario['id']; ?>">
             <button type="submit" name="eliminar_usuario" class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
    </form>
</td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

    <div class="container">
        <h2>Registro de Sucursal</h2>
        <form id="branch-form" method="POST">
            <div class="form-group">
                <label for="nombre-sucursal">Nombre:</label>
                <input type="text" id="nombre-sucursal" name="nombre-sucursal" required>
            </div>
            <div class="form-group">
                <label for="calle">Calle:</label>
                <input type="text" id="calle" name="calle" required>
            </div>
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" id="numero" name="numero" required>
            </div>
            <div class="form-group">
                <label for="localidad">Localidad:</label>
                <input type="text" id="localidad" name="localidad" required>
            </div>
            <div class="form-group">
                <label for="codigo-postal">Código Postal:</label>
                <input type="text" id="codigo-postal" name="codigo-postal" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label>Tipo:</label>
                <input type="radio" id="sucursal" name="rol" value="sucursal">
                <label for="sucursal">Sucursal</label>
                <input type="radio" id="centro-distribucion" name="rol" value="centro-distribucion">
                <label for="centro-distribucion">Centro de Distribución</label>
            </div>
            <button type="submit" name= "registrar_sucursal">REGISTRAR</button>
        </form>
        



        <?php
        $busquedaSucursal = '';
        if (isset($_POST['buscar_sucursal'])) {
       $busquedaSucursal = mysqli_real_escape_string($conexion, $_POST['buscar_sucursal']);
                                             }

         $resultadoSucursales = mysqli_query($conexion, "
        SELECT * FROM sucursal
        WHERE nombre LIKE '%$busquedaSucursal%'");     
        ?>





        <div class="search-box">
        <form method="POST">
        <input type="text" name="buscar_sucursal" placeholder="Buscar sucursal..." value="<?php echo isset($busquedaSucursal) ? htmlspecialchars($busquedaSucursal) : ''; ?>">
        <button type="submit">Buscar</button>
        </form>
        </div>
        
        <?php
        if (isset($_POST['eliminar_sucursal'])) {
            $sucursal_id = mysqli_real_escape_string($conexion, $_POST['sucursal_id']);
            
            // verifico si hay usuarios en la sucursal
            $resultadoVerificacion = mysqli_query($conexion, "SELECT COUNT(*) AS count FROM usuario WHERE sucursal_id = '$sucursal_id'");
            $row = mysqli_fetch_assoc($resultadoVerificacion);
            
            if ($row['count'] > 0) {
                echo "No se puede eliminar la sucursal porque hay usuarios asociados a ella.";
            } else {
                // si no hay usuarios elimino
                $resultadoEliminar = mysqli_query($conexion, "DELETE FROM sucursal WHERE id = '$sucursal_id'");
                
                if ($resultadoEliminar) {
                    echo "Sucursal eliminada exitosamente";
                } else {
                    echo "Error al eliminar la sucursal: " . mysqli_error($conexion);
                }
            }
        }
        ?>


        <table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Localidad</th>
            <th>Teléfono</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="tabla-sucursales">
        <?php while ($sucursal = mysqli_fetch_assoc($resultadoSucursales)): ?>
            <tr>
                <td><?php echo htmlspecialchars($sucursal['nombre']); ?></td>
                <td><?php echo htmlspecialchars($sucursal['calle'] . ' ' . $sucursal['numero']); ?></td>
                <td><?php echo htmlspecialchars($sucursal['localidad']); ?></td>
                <td><?php echo htmlspecialchars($sucursal['telefono']); ?></td>
                <td><?php echo htmlspecialchars($sucursal['rol']); ?></td>
                <td>
                <form method="POST" style="display:inline;">
                <input type="hidden" name="sucursal_id" value="<?php echo $sucursal['id']; ?>">
                <button type="submit" name="eliminar_sucursal" class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                 </form>
</td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
    </div>
    <br><br/>
    <a href = "logout.php" >Cerrar sesion </a>
    <script>
        document.querySelectorAll('input[name="rol"]').forEach((elem) => {
        elem.addEventListener("change", function(event) {
            var sucursalGroup = document.getElementById("sucursal-group");
            sucursalGroup.style.display = event.target.value === "u-suc" ? "block" : "none";
        });
    });

    // Manejar el envío del formulario de usuario
    document.getElementById("user-form").addEventListener("submit", function(e) {
        var rolSeleccionado = document.querySelector('input[name="rol"]:checked');
        var sucursalSelect = document.getElementById("sucursal");

        if (!rolSeleccionado) {
            e.preventDefault();
            alert("Por favor, selecciona un rol.");
        } else if (rolSeleccionado.value === "u-suc" && sucursalSelect.value === "") {
            e.preventDefault();
            alert("Por favor, selecciona una sucursal para usuarios no administradores.");
        } else {
            alert("Formulario de usuario enviado");
        }
    });

    // Manejar el envío del formulario de sucursal
    document.getElementById("branch-form").addEventListener("submit", function(e) {
        alert("Formulario de sucursal enviado");
    });
    </script>
</body>
</html>