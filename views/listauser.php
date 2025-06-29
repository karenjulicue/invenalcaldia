<?php
session_start();
error_reporting(0);

$validar = $_SESSION['nombre'];

if ($validar == null || $validar == '') {
    header("Location: ../includes/login.php");
    die();
}
?>

<!-- LISTADO USUARIOS PARA ADMIN Y SUPERVISOR -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="../css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts de DataTables (opcional si usas funcionalidades) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
</head>
<body>

    <h1>Listado de usuarios</h1>
    <br>
        <div>
                <a class="btn btn-success" href="../index.php">
                    Nuevo Usuario <i class="fa fa-plus"></i>
                </a>
                
            </div>
    
    <br>

    <div class="tabla-usuarios-container">
        <table class="table-usuarios">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>direccion</th>
                    <th>Correo</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conexion = mysqli_connect("localhost", "root", "", "r_user");
                $SQL = "SELECT user.id, user.nombre, user.apellido, user.direccion, user.correo, user.password, permisos.rol 
                        FROM user
                        LEFT JOIN permisos ON user.rol = permisos.id";
                $dato = mysqli_query($conexion, $SQL);

                if ($dato->num_rows > 0) {
                    while ($fila = mysqli_fetch_array($dato)) {
                        ?>
                        <tr>
                            <td><?php echo $fila['nombre']; ?></td>
                            <td><?php echo $fila['apellido']; ?></td>
                            <td><?php echo $fila['direccion']; ?></td>
                            <td><?php echo $fila['correo']; ?></td>
                            <td><?php echo $fila['password']; ?></td>
                            <td><?php echo $fila['rol']; ?></td>
                            <td class="acciones">
                                
  <a class="btn-editar" href="editar_user.php?id=<?php echo $fila['id']; ?>">
    <i class="fa fa-edit"></i> Editar
  </a>
  
  <a class="btn-eliminar" href="eliminar_user.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
    <i class="fa fa-trash-alt"></i> Eliminar
  </a>
  

                        <?php
                    }
                } else {
                    ?>
                    <tr class="text-center">
                        <td colspan="6">No existen registros</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Script JS adicional -->
    <script src="../js/user.js"></script>
</body>
</html>
