<?php
session_start(); // Agrega esto antes de cualquier uso de $_SESSION
require_once '../config/database.php';

// Validar sesión y rol
if (!isset($_SESSION['nombre']) || empty($_SESSION['nombre'])) {
    header("Location: ../includes/login.php");
    exit();
}

// Opcional: solo permitir acceso a ciertos roles
// if (!in_array($_SESSION['role'], ['administrador'])) {
//     header("Location: ../index.php");
//     exit();
// }
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
    <link rel="stylesheet" href="../css/style_inventario.css"> 
    
    <!-- Scripts de DataTables (opcional si usas funcionalidades) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
</head>
<body>
<form action="/invenalcaldia/includes/validar.php" method="POST"></form>

    <h1>Listado de usuarios</h1>
    <br>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'administrador'): ?>
        <div>
            <a class="btn btn-success" href="includes/registro_usuario.php">
                Nuevo Usuario <i class="fa fa-plus"></i>
            </a>
        </div>
    <?php endif; ?>
    
    <br>

    <div class="tabla-usuarios-container">
        <table class="table-usuarios">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = mysqli_connect("localhost", "root", "", "invenalcaldia");
                if (!$conn) {
                    echo '<tr><td colspan="7">Error de conexión a la base de datos</td></tr>';
                } else {
                    $SQL = "SELECT usuarios.id, usuarios.username, usuarios.apellido, usuarios.direccion, usuarios.correo, usuarios.password, permisos.role as username_rol FROM usuarios LEFT JOIN permisos ON usuarios.role = permisos.id";
                    $dato = mysqli_query($conn, $SQL);

                    if ($dato && $dato->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($dato)) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($fila['apellido']); ?></td>
                                <td><?php echo htmlspecialchars($fila['direccion']); ?></td>
                                <td><?php echo htmlspecialchars($fila['correo']); ?></td>
                                <td><?php echo htmlspecialchars($fila['password']); ?></td>
                                <td><?php echo htmlspecialchars($fila['nombre_rol']); ?></td>
                                <td class="acciones">
                                    <a class="btn-editar" href="includes/editar_user.php?id=<?php echo $fila['id']; ?>">
                                        <i class="fa fa-edit"></i> Editar
                                    </a>
                                    <a class="btn-eliminar" href="includes/eliminar_user.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                                        <i class="fa fa-trash-alt"></i> Eliminar
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr class="text-center">
                            <td colspan="7">No existen registros</td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Script JS adicional -->
    <script src="../js/user.js"></script>
</body>
</html>