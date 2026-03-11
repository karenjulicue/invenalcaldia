<?php
require_once '../config/database.php';
session_start();
if (!isset($_SESSION['nombre']) || empty($_SESSION['nombre'])) {
    echo "No autorizado";
    exit();
}
?>
<h1>Listado de usuarios</h1>
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
                $SQL = "SELECT * FROM usuarios";
                $dato = mysqli_query($conn, $SQL);

                if ($dato && $dato->num_rows > 0) {
                    while ($fila = mysqli_fetch_array($dato)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fila['username']); ?></td>
                            <td><?php echo htmlspecialchars($fila['apellido']); ?></td>
                            <td><?php echo htmlspecialchars($fila['direccion']); ?></td>
                            <td><?php echo htmlspecialchars($fila['correo']); ?></td>
                            <td><?php echo htmlspecialchars($fila['password']); ?></td>
                            <td><?php echo htmlspecialchars($fila['role']); ?></td>
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
