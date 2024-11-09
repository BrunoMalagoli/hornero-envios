<?php

session_start();
include("../config/dbconnect.php");
  if(!isset($_SESSION['logueado']))
  {
  header("Location:login.php");
  exit; 
 }

if(isset($_SESSION['logueado']) && $_SESSION['rol'] == 'u-suc')
 {
 header("Location:inicio-u-suc.php");
 exit; 
 }


$resultadoSucursales = mysqli_query($conexion, "SELECT id, nombre FROM sucursal ORDER BY id ASC");

$sucursales = [];
while ($sucursal = mysqli_fetch_assoc($resultadoSucursales)) {
    $sucursales[] = $sucursal;
}


    $resultadoCentros = mysqli_query($conexion, "SELECT id, nombre FROM sucursal WHERE rol = 'centro'");
    $centros = [];
    while ($centro = mysqli_fetch_assoc($resultadoCentros)) {
        $centros[] = $centro;
    }



/*REGISTRO USUARIO*/
if (isset($_POST["registrar_usuario"])) { 
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $rol = mysqli_real_escape_string($conexion, $_POST['rol']);
    $contrasena_encriptada = sha1($contrasena);

    $resultadouser = mysqli_query($conexion, "SELECT id FROM usuario WHERE u_name = '$nombre' OR email = '$email'");

    if (mysqli_num_rows($resultadouser) > 0) {
        echo "<p class='noti-err'>El usuario con ese user o email ya existe</p>";
    } else {
        if ($rol == "admin") {
            $resultadoadmin = mysqli_query($conexion, "INSERT INTO usuario (u_name, contrasena, email, rol) VALUES ('$nombre', '$contrasena_encriptada', '$email', 'admin')");
            if ($resultadoadmin === false) {
                echo "<p class='noti-err'>Error al registrarse: " . mysqli_error($conexion) . "</p>";
            } else {
                echo "<p class='noti-succ'>Registro exitoso de administrador</p>";
            }
        } else {
            $sucursal = mysqli_real_escape_string($conexion, $_POST['sucursal']);
            if (empty($sucursal)) {
                echo "<p class='noti-err'>Error: Debe seleccionar una sucursal para usuarios no administradores</p>";
            } else {
                $resultadusuario = mysqli_query($conexion, "INSERT INTO usuario (u_name, contrasena, email, rol, sucursal_id) VALUES ('$nombre', '$contrasena_encriptada', '$email', 'u-suc', '$sucursal')");
                if ($resultadusuario === false) {
                    echo "<p class='noti-err'>Error al registrarse: " . mysqli_error($conexion) . "</p>";
                } else {
                    echo "<p class='noti-succ'>Registro exitoso de usuario de sucursal</p>";
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
    $centro = mysqli_real_escape_string($conexion, $_POST['centro']);
    $resultadosucursal = mysqli_query($conexion, "SELECT id FROM sucursal WHERE nombre = '$nombre_sucursal' and calle = '$calle' and numero = '$numero' ");

    if (mysqli_num_rows($resultadosucursal) > 0) {
        echo "<p class='noti-err'>La sucursal ya existe</p>";
    } else {
        if ($rol == "sucursal") {
           
            if (empty($centro)) {
                echo "<p class='noti-err'>Error: Debe seleccionar una sucursal para usuarios no administradores</p>";
            }
            else{
                $resultadosuc = mysqli_query($conexion, "INSERT INTO sucursal (nombre, calle, numero, localidad, cp, telefono, rol, centro_designado) VALUES ('$nombre_sucursal', '$calle', $numero, '$localidad',$codigo_postal,'$telefono', 'sucursal', '$centro')");
            if ($resultadosuc === false) {
                echo "<p class='noti-err'>Error al registrar: " . mysqli_error($conexion) . "</p>";
            } else {
                echo "<p class='noti-succ'>Registro exitoso</p>";
            }    
         }
            
        } else {
            $resultadocentro = mysqli_query($conexion, "INSERT INTO sucursal (nombre, calle, numero, localidad, cp, telefono, rol) VALUES ('$nombre_sucursal', '$calle', $numero, '$localidad',$codigo_postal,'$telefono', 'centro')");
            if ($resultadocentro=== false) {
                echo "<p class='noti-err'>Error al registrar: " . mysqli_error($conexion) . "</p>";
            } else {
                echo "<p class='noti-succ'>Registro exitoso</p>";
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
            <nav class="navbar">
                <div class="logo">
                    <img src="../images/LOGO_TRANSPARENTE.png" alt="LOGO">
                </div>
                <ul class="nav-links">
                <p>USUARIO : 
                    <?php
                        echo $_SESSION['usuario'];
                    ?>
                    </p>
                    <li><a href="../services/logout.php">Cerrar Sesion</a></li>
                </ul>
                <div class="burger">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                </div>
            </nav>
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
            <div class="form-group-tipo-suc">
                <label>Rol:</label>
                <input type="radio" id="admin" name="rol" value="admin" checked>
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
             echo "<p class='noti-succ'>Usuario eliminado exitosamente</p>";
         } else {
              echo "<p class='noti-err'>Error al eliminar el usuario: " . mysqli_error($conexion) . "</p>";
            }
            }


            if (isset($_POST['actualizar_usuario'])) 
            {
                $id = mysqli_real_escape_string($conexion, $_POST['id']);
                $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
                $email = mysqli_real_escape_string($conexion, $_POST['email']);
                $rol = mysqli_real_escape_string($conexion, $_POST['rols']);
                $sucursal = isset($_POST['sucursal']) ? mysqli_real_escape_string($conexion, $_POST['sucursal']) : null;
            
                // Verificar si existe otro usuario con el mismo nombre o email y diferente ID
                $resultadouser = mysqli_query($conexion, "SELECT id FROM usuario WHERE u_name = '$nombre' OR email = '$email'");
                $res = mysqli_fetch_assoc($resultadouser);
                if ($res['id'] != $id)
                {
                    echo "<p class='noti-err'>El usuario con ese user o email ya existe</p>";
                }
                else 
                {
                 if ($rol == "admin") 
                 {
                 $resultado = mysqli_query($conexion, "UPDATE usuario SET u_name = '$nombre', email = '$email', rol = '$rol', sucursal_id = NULL WHERE id = '$id'");
                     if ($resultado) 
                    {
                      echo "<p class='noti-succ'>Actualización Exitosa de Admin</p>";
                     } else 
                    {
                    echo "<p class='noti-err'>Error al Actualizar Admin: " . mysqli_error($conexion) . "</p>";
                      }
                 } elseif ($rol == "u-suc")
                    {
                     if (empty($sucursal)) 
                     {
                     echo "<p class='noti-err'>Error: Debe seleccionar una sucursal para usuarios de sucursal</p>";
                     exit;
                     }
                     $resultado = mysqli_query($conexion, "UPDATE usuario SET u_name = '$nombre', email = '$email', rol = '$rol', sucursal_id = '$sucursal' WHERE id = '$id'");
                    if ($resultado) 
                    {
                     echo "<p class='noti-succ'>Actualización Exitosa de Usuario Sucursal</p>";
                    } 
                     else 
                    {
                      echo "<p class='noti-err'>Error al Actualizar Usuario Sucursal: " . mysqli_error($conexion) . "</p>";
                    }
                      } 
                     else 
                         {
                    echo "<p class='noti-err'>Rol no reconocido: " . $rol . "</p>";
                        }
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
                    <button type="button" onclick="editarUsuario('<?php echo $usuario['id']; ?>', '<?php echo htmlspecialchars($usuario['u_name']); ?>', '<?php echo htmlspecialchars($usuario['email']); ?>' )" class="action-btn edit-btn" ><i class="fas fa-pencil-alt"></i></button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
 </table>

 <div>
            <h2>Editar Usuario</h2>
        <form method = "POST" id="edit-user-form" style="display:none;"  >
        <div class="form-group">
            <input type="hidden" id="usuarioId" name="id">
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
        </div>
        <div class="form-group">
            <input type="text" id="edit-nombre" name="nombre" required>
            <label for="email">Email:</label>
        </div>
        <div class="form-group">
            <input type="email" id="edit-email" name="email" required>
        </div>
        <div class="form-group">
                <label>Rol:</label>
                <input type="radio" id="edit-rol" name="rols" value="admin" checked>
                <label for="admin">Administrador</label>
                <input type="radio" id="edit-rol" name="rols" value="u-suc">
                <label for="u-suc">Usuario Sucursal</label>
                <div class="form-group" id="sucursal-g" style="display:none;">
                <label for="sucursal">Sucursal:</label>
                     <select id="edit-sucursal" name="sucursal">
                         <option value="">Seleccione una sucursal</option>
                        <?php foreach ($sucursales as $sucursal): ?>
                         <option value="<?php echo $sucursal['id']; ?>"><?php echo htmlspecialchars($sucursal['nombre']); ?></option>
                         <?php endforeach; ?>
                    </select>
            </div>
        </div>
            <button type="submit" name= "actualizar_usuario">Guardar</button>
            <button type="button" onclick="cancelEditUser()">Cancelar</button>
        </form>
       </div>
</div>
</div>
            
<br>
<br>

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
            <div class="form-group locality-input-container">
                <label for="localidad">Localidad:</label>
                <input type="text" id="address-input" name="localidad" onkeyup="autocompleteAddress()" required>
                <ul id="suggestions-list"></ul>
            </div>
            <div class="form-group">
                <label for="codigo-postal">Código Postal:</label>
                <input type="text" id="codigo-postal" name="codigo-postal" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>
            <div class="form-group-tipo-suc">
                <label>Tipo:</label>
                <input type="radio" id="centro-distribucion" name="rol" value="centro-distribucion" checked>
                <label for="centro-distribucion">Centro de Distribución</label>
                <input type="radio" id="sucursal" name="rol" value="sucursal">
                <label for="sucursal">Sucursal</label>
            </div>
            <div class="form-group">
                <div class="form-group" id="centro-group" style="display:none;">
                <label for="centro">Centro de distribución:</label>
                <select id="centro" name="centro">
                  <option value="">Seleccione un Centro de Distribución</option>
                  <?php foreach ($centros as $centro): ?>
                <option value="<?php echo $centro['id']; ?>"><?php echo htmlspecialchars($centro['nombre']); ?></option>
             <?php endforeach; ?>
             </select>
                 </div>       
        </div>
            <button type="submit" name= "registrar_sucursal">REGISTRAR</button>
        </form>
        

        <?php
        $busquedaSucursal = '';
        if (isset($_POST['buscar_sucursal'])) {
       $busquedaSucursal = mysqli_real_escape_string($conexion, $_POST['buscar_sucursal']);
        }

        $resultadoSucursales = mysqli_query($conexion, "
            SELECT sucursal.*, 
                   (SELECT nombre FROM sucursal AS centro 
                    WHERE centro.id = sucursal.centro_designado 
                      AND centro.rol = 'centro') AS nombre_centro
            FROM sucursal
            WHERE sucursal.nombre LIKE '%$busquedaSucursal%'
        ");  
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
                echo "<p class='noti-err'>No se puede eliminar la sucursal porque hay usuarios asociados a ella.</p>";
            } else {
                // si no hay usuarios elimino
                $resultadoEliminar = mysqli_query($conexion, "DELETE FROM sucursal WHERE id = '$sucursal_id'");
                
                if ($resultadoEliminar) {
                    echo "<p class='noti-succ'>Sucursal eliminada exitosamente</p>";
                } else {
                    echo "<p class='noti-err'>Error al eliminar la sucursal: " . mysqli_error($conexion) . "</p>";
                }
            }
        }

        if (isset($_POST['actualizar_sucursal_confirm'])) 
        {
            $sucursal_id = mysqli_real_escape_string($conexion, $_POST['sucursal_id']);
            $nombre = mysqli_real_escape_string($conexion, $_POST['nombre-sucursal']);
            $calle = mysqli_real_escape_string($conexion, $_POST['calle']);
            $numero = filter_var($_POST['numero'], FILTER_VALIDATE_INT);
            $localidad = mysqli_real_escape_string($conexion, $_POST['localidad']);
            $codigo_postal = filter_var($_POST['codigo-postal'], FILTER_VALIDATE_INT);
            $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
            $rol = mysqli_real_escape_string($conexion, $_POST['rol']);
            $centro = mysqli_real_escape_string($conexion, $_POST['centro']);
            if (!empty($rol))
            {
                $resultado = mysqli_query($conexion, "SELECT id FROM sucursal WHERE nombre = '$nombre' AND calle = '$calle' and numero = '$numero' and id != '$sucursal_id'");
                if (mysqli_num_rows($resultado) >0)
                {     
                        echo "<p class='noti-err'>Ya existe una sucursal registrada con esos datos</p>";
                }
                else
                {
                    $sucu = mysqli_query($conexion,"SELECT rol FROM sucursal WHERE id = '$sucursal_id'");
                    $sucus = mysqli_fetch_assoc($sucu);

                    if($sucus['rol'] == "sucursal")
                    {
                        if ($rol == "sucursal")
                        {
                            if (empty($centro)) 
                            {
                             echo "<p class='noti-err'>Error: Debe seleccionar un centro de distribución</p>";
                            }
                            else
                            {
                                $resultadosucu = mysqli_query($conexion,"UPDATE sucursal SET nombre='$nombre', calle='$calle', numero=$numero, localidad='$localidad', cp='$codigo_postal', telefono='$telefono', rol = '$rol' , centro_designado = $centro WHERE id='$sucursal_id'" );
                                if ($resultadosucu === false) 
                                {
                                    echo "<p class='noti-err'>Error al actualizar: " . mysqli_error($conexion) . "</p>";
                                } 
                                else 
                                {
                                    echo "<p class='noti-succ'>Actualizacion exitosa</p>";
                                }    
                            }
                    }
                        else
                        {
                            $resultadosucu = mysqli_query($conexion,"UPDATE sucursal SET nombre='$nombre', calle='$calle', numero=$numero, localidad='$localidad', cp='$codigo_postal', telefono='$telefono', rol = '$rol' , centro_designado = NULL WHERE id='$sucursal_id'" );
                            if ($resultadosucu === false) 
                            {
                                echo "<p class='noti-err'>Error al actualizar: " . mysqli_error($conexion) . "</p>";
                            } 
                            else 
                            {
                                echo "<p class='noti-succ'>Actualizacion exitosa</p>";
                            }    
                        }


                    }
                    else
                    {
                        if ($rol == "sucursal")
                        {

                            $r = mysqli_query($conexion,"SELECT * FROM sucursal WHERE centro_designado = '$sucursal_id'");
                            if (mysqli_num_rows($r) > 0)
                            {
                                echo "<p class='noti-err'>No puede realizarse el cambio de rol ya que este centro esta asignado a una o mas sucursales</p>";
                            }
                            else
                            {
                                $resultadosucu = mysqli_query($conexion,"UPDATE sucursal SET nombre='$nombre', calle='$calle', numero=$numero, localidad='$localidad', cp='$codigo_postal', telefono='$telefono', rol = '$rol' , centro_designado = $centro WHERE id='$sucursal_id'" );
                                if ($resultadosucu === false) 
                                {
                                 echo "<p class='noti-err'>Error al actualizar: " . mysqli_error($conexion) . "</p>";
                                } 
                             else 
                             {
                                 echo "<p class='noti-succ'>Actualizacion exitosa </p>";
                                }  

                            }
                        }

                        else{
                         $resultadosucu = mysqli_query($conexion,"UPDATE sucursal SET nombre='$nombre', calle='$calle', numero=$numero, localidad='$localidad', cp='$codigo_postal', telefono='$telefono', rol = '$rol' , centro_designado = NULL WHERE id='$sucursal_id'" );
                            if ($resultadosucu === false) 
                            {
                                echo "<p class='noti-err'>Error al actualizar: " . mysqli_error($conexion) . "</p>";
                            } 
                            else 
                            {
                                echo "<p class='noti-succ'>Actualizacion exitosa</p>";
                            }  

                        }
                  
                    }

                } 
               
            }  
            else{
                echo "<p class='noti-err'>Error al actualizar, todas las sucursales deben tener un rol</p>";
            }
        }          
        ?>

        <table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Localidad</th>
            <th>Codigo Postal</th>
            <th>Teléfono</th>
            <th>Tipo</th>
            <th>Centro Designado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="tabla-sucursales">
        <?php while ($sucursal = mysqli_fetch_assoc($resultadoSucursales)): ?>
            <tr>
                <td><?php echo htmlspecialchars($sucursal['nombre']); ?></td>
                <td><?php echo htmlspecialchars($sucursal['calle'] . ' ' . $sucursal['numero']); ?></td>
                <td><?php echo htmlspecialchars($sucursal['localidad']); ?></td>
                <td><?php echo htmlspecialchars($sucursal['cp']); ?></td>
                <td><?php echo htmlspecialchars($sucursal['telefono']); ?></td>
                <td><?php echo htmlspecialchars($sucursal['rol']); ?></td>
                <td><?php echo (!empty($sucursal['nombre_centro']) ? htmlspecialchars($sucursal['nombre_centro']) : '-'); ?></td>
                <td>
                <form method="POST" style="display:inline;">
                <input type="hidden" name="sucursal_id" value="<?php echo $sucursal['id']; ?>">
                <button type="submit" name="eliminar_sucursal" class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                <button type="button" onclick="editSucursal('<?php echo $sucursal['id']; ?>', '<?php echo htmlspecialchars($sucursal['nombre']); ?>', '<?php echo htmlspecialchars($sucursal['calle']); ?>', '<?php echo htmlspecialchars($sucursal['numero']); ?>', '<?php echo htmlspecialchars($sucursal['localidad']); ?>', '<?php echo htmlspecialchars($sucursal['cp']); ?>', '<?php echo htmlspecialchars($sucursal['telefono']); ?>',)" class="action-btn edit-btn"><i class="fas fa-pencil-alt"></i></button>
                 </form>
                </td>          
            </tr>
        <?php endwhile; ?>

</tbody>
</table>

<h2>Editar Sucursal</h2>
<div class="formu" id="edit-branch-form"  style="display:none;"  >
    <div class = "formu">
    <form id="formu-edicion" method="POST">
        <input type="hidden" id="edit-sucursal-id" name="sucursal_id" >
        <div class="form-group">
            <label for="edit-nombre-sucursal">Nombre:</label>
            <input type="text" id="edit-nombre-sucursal" name="nombre-sucursal" required>
        </div>
        <div class="form-group">
            <label for="edit-calle">Calle:</label>
            <input type="text" id="edit-calle" name="calle" required>
        </div>
        <div class="form-group">
            <label for="edit-numero">Número:</label>
            <input type="text" id="edit-numero" name="numero" required>
        </div>
        <div class="form-group">
            <label for="edit-localidad">Localidad:</label>
            <input type="text" id="edit-localidad" name="localidad" required>
        </div>
        <div class="form-group">
            <label for="edit-codigo-postal">Código Postal:</label>
            <input type="text" id="edit-codigo-postal" name="codigo-postal" required>
        </div>
        <div class="form-group">
            <label for="edit-telefono">Teléfono:</label>
            <input type="text" id="edit-telefono" name="telefono" required>
        </div>
        <div class="form-group">
                <label>Tipo:</label>
                <input type="radio" id="edit-centro-distribucion" name="rol" value="centro" checked>
                <label for="edit-centro-distribucion">Centro de Distribución</label>
                <input type="radio" id="edit-sucursal" name="rol" value="sucursal">
                <label for="edit-sucursal">Sucursal</label>
                <div class="form-group" id="centro-g" style="display:none;">
                <label for="centro">Centro de distribución:</label>
                <select id="edit-centro" name="centro">
                  <option value="">Seleccione un Centro de Distribución</option>
                  <?php foreach ($centros as $centro): ?>
                <option value="<?php echo $centro['id']; ?>"><?php echo htmlspecialchars($centro['nombre']); ?></option>
             <?php endforeach; ?>
             </select>
                 </div>       
        </div>
        <button type="submit" name="actualizar_sucursal_confirm">Aceptar</button>
        <button type="button" onclick="cancelEdit()">Cancelar</button>
    </form>
  </div>
</div>



</div>
    <br><br/>
<script src="../js/script.js"></script>
<script src="../js/admin.js"></script>
<script>
    let timeoutId;

    async function autocompleteAddress() {
    const query = document.getElementById('address-input').value;
    if (query.length < 3) return; // Espera hasta que el usuario haya escrito al menos 3 caracteres.

    // Cancela cualquier solicitud anterior si el usuario sigue escribiendo
    clearTimeout(timeoutId);

    // Establece un pequeño retraso para reducir la cantidad de solicitudes
    timeoutId = setTimeout(async () => {
        const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&addressdetails=1&countrycodes=AR`;
        
        try {
            const response = await fetch(url, {
                headers: {
                    'User-Agent': 'TuApp/1.0 (tuemail@dominio.com)'  // Requerido por Nominatim
                }
            });
            const data = await response.json();

            // Limpia sugerencias previas
            document.getElementById('suggestions-list').innerHTML = '';

            // Muestra sugerencias
            data.forEach(item => {
                const suggestion = document.createElement('li');
                suggestion.textContent = item.display_name;
                suggestion.onclick = () => selectAddress(item);
                document.getElementById('suggestions-list').appendChild(suggestion);
            });
        } catch (error) {
            console.error("Error fetching address data:", error);
        }
    }, 300); // Espera 300 ms antes de hacer la solicitud
}

function selectAddress(item) {
    document.getElementById('address-input').value = item.display_name;
    console.log("Coordenadas:", item.lat, item.lon);
    document.getElementById('suggestions-list').innerHTML = ''; // Limpia la lista de sugerencias
}
</script>
</body>
</html>










