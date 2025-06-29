<?php
require_once '../config/database.php';
// Eliminar equipo
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM equipos_telefonia WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: ../views/equipos_telefonia.php');
    exit();
}

// Obtener equipo para editar
$editando = false;
$equipoEditar = null;
if (isset($_GET['editar'])) {
    $editando = true;
    $id = intval($_GET['editar']);
    $stmt = $conn->prepare("SELECT * FROM equipos_telefonia WHERE id = ?");
    $stmt->execute([$id]);
    $equipoEditar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Guardar edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_edicion'])) {
    $id = intval($_POST['id']);
    $data = [
        $_POST['tipo_de_equipo'],
        $_POST['modelo'],
        $_POST['marca'],
        $_POST['n_puertos_LAN'],
        $_POST['n_asignado'],
        $_POST['IMEI_IMSI2'],
        $_POST['serial_telef'],
        $_POST['esta_fisico_general'],
        $_POST['esta_de_funcionalidad'],
        $_POST['nombre_asig_equipo'],
        $_POST['activo'],
        $_POST['ip_asignada'],
        $_POST['dependencia'],
        $_POST['oficina'],
        $_POST['lugar'],
        $_POST['img_frontal_equipo'],
        $_POST['img_serial_modelo'],
        $_POST['asignado_A'],
        $id
    ];
    $sql = "UPDATE equipos_telefonia SET tipo_de_equipo=?, modelo=?, marca=?, n_puertos_LAN=?, n_asignado=?, IMEI_IMSI2=?, serial_telef=?, esta_fisico_general=?, esta_de_funcionalidad=?, nombre_asig_equipo=?, activo=?, ip_asignada=?, dependencia=?, oficina=?, lugar=?, img_frontal_equipo=?, img_serial_modelo=?, asignado_A=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
    header('Location: ../views/equipos_telefonia.php');
    exit();
}

// Agregar nuevo equipo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_equipo'])) {
    $data = [
        $_POST['tipo_de_equipo'],
        $_POST['modelo'],
        $_POST['marca'],
        $_POST['n_puertos_LAN'],
        $_POST['n_asignado'],
        $_POST['IMEI_IMSI2'],
        $_POST['serial_telef'],
        $_POST['esta_fisico_general'],
        $_POST['esta_de_funcionalidad'],
        $_POST['nombre_asig_equipo'],
        $_POST['activo'],
        $_POST['ip_asignada'],
        $_POST['dependencia'],
        $_POST['oficina'],
        $_POST['lugar'],
        $_POST['img_frontal_equipo'],
        $_POST['img_serial_modelo'],
        $_POST['asignado_A']
    ];
    $sql = "INSERT INTO equipos_telefonia ( tipo_de_equipo, modelo, marca, n_puertos_LAN, n_asignado, IMEI_IMSI2, serial_telef, esta_fisico_general, esta_de_funcionalidad, nombre_asig_equipo, activo, ip_asignada, dependencia, oficina, lugar, img_frontal_equipo, img_serial_modelo, asignado_A) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
    header('Location: ../views/equipos_telefonia.php');
    exit();
}
// Obtener todos los equipos
$stmt = $conn->query("SELECT * FROM equipos_telefonia ORDER BY id DESC");
$equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// HTML y CSS para la interfaz
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Equipos de Telefonía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style_inventario.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container">
        <h2 class="mb-4">Gestión de Equipos de Telefonía</h2>
        
       <!-- Formulario para agregar/editar equipos -->
        <div class="form-section">
            <form method="POST" action="" autocomplete="off">
                <?php if($editando && $equipoEditar): ?>
                    <input type="hidden" name="id" value="<?php echo $equipoEditar['id']; ?>">
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-2 mb-2">
                        <label for="tipo_de_equipo" class="form-label">Tipo de Equipo</label>
                        <input type="text" class="form-control" id="tipo_de_equipo" name="tipo_de_equipo" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['tipo_de_equipo']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['modelo']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['marca']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="n_puertos_LAN" class="form-label">Número de Puertos LAN</label>
                        <input type="text" class="form-control" id="n_puertos_LAN" name="n_puertos_LAN" value="<?php echo $editando ? htmlspecialchars($equipoEditar['n_puertos_LAN']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="n_asignado" class="form-label">Número Asignado</label>
                        <input type="text" class="form-control" id="n_asignado" name="n_asignado" value="<?php echo $editando ? htmlspecialchars($equipoEditar['n_asignado']) : ''; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-2">
                        <label for="IMEI_IMSI2" class="form-label">IMEI/IMSI</label>
                        <input type="text" class="form-control" id="IMEI_IMSI2" name="IMEI_IMSI2" value="<?php echo $editando ? htmlspecialchars($equipoEditar['IMEI_IMSI2']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="serial_telef" class="form-label">Serial</label>
                        <input type="text" class="form-control" id="serial_telef" name="serial_telef" value="<?php echo $editando ? htmlspecialchars($equipoEditar['serial_telef']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="esta_fisico_general" class="form-label">Estado Físico General</label>
                        <input type="text" class="form-control" id="esta_fisico_general" name="esta_fisico_general" value="<?php echo $editando ? htmlspecialchars($equipoEditar['esta_fisico_general']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="esta_de_funcionalidad" class="form-label">Estado de Funcionalidad</label>
                        <input type="text" class="form-control" id="esta_de_funcionalidad" name="esta_de_funcionalidad" value="<?php echo $editando ? htmlspecialchars($equipoEditar['esta_de_funcionalidad']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="nombre_asig_equipo" class="form-label">Nombre Asignación Equipo</label>
                        <input type="text" class="form-control" id="nombre_asig_equipo" name="nombre_asig_equipo" value="<?php echo $editando ? htmlspecialchars($equipoEditar['nombre_asig_equipo']) : ''; ?>">
                    </div>
                     <div class="col-md-2 mb-2">
                        <label for="activo" class="form-label">activo</label>
                        <input type="text" class="form-control" id="activo" name= "activo" value="<?php echo $editando ? htmlspecialchars($equipoEditar['activo']) : ''; ?>">
                    </div>
                 </div> 

                <div class="row">
                    <div class="col-md-2 mb-2">
                        <label for="ip_asignada" class="form-label">IP Asignada</label>
                        <input type="text" class="form-control" id="ip_asignada" name="ip_asignada" value="<?php echo $editando ? htmlspecialchars($equipoEditar['ip_asignada']) : ''; ?>">
                    </div>
                
                    <div class="col-md-2 mb-2">
                        <label for="dependencia" class="form-label">Dependencia</label>
                        <input type="text" class="form-control" id="dependencia" name="dependencia" value="<?php echo $editando ? htmlspecialchars($equipoEditar['dependencia']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="oficina" class="form-label">Oficina</label>
                        <input type="text" class="form-control" id="oficina" name="oficina" value="<?php echo $editando ? htmlspecialchars($equipoEditar['oficina']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="lugar" class="form-label">Lugar</label>
                        <input type="text" class="form-control" id="lugar" name="lugar" value="<?php echo $editando ? htmlspecialchars($equipoEditar['lugar']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="img_frontal_equipo" class="form-label">Imagen Frontal del Equipo</label>
                        <input type="text" class="form-control" id="img_frontal_equipo" name="img_frontal_equipo" value="<?php echo $editando ? htmlspecialchars($equipoEditar['img_frontal_equipo']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="img_serial_modelo" class="form-label">Imagen Serial/Modelo</label>
                        <input type="text" class="form-control" id="img_serial_modelo" name="img_serial_modelo" value="<?php echo $editando ? htmlspecialchars($equipoEditar['img_serial_modelo']) : ''; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="asignado_A" class="form-label">Asignado A</label>
                        <input type="text" class="form-control" id="asignado_A" name="asignado_A" value="<?php echo $editando ? htmlspecialchars($equipoEditar['asignado_A']) : ''; ?>">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 text-end">
                        <?php if($editando): ?>
                            <button type="submit" name="guardar_edicion" class="btn btn-success">Guardar Cambios</button>
                            <a href="equipos_telefonia.php" class="btn btn-secondary">Cancelar</a>
                        <?php else: ?>
                            <button type="submit" name="agregar_equipo" class="btn btn-primary">Agregar Equipo</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla para mostrar equipos -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo_de_equipo</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>n_Puertos_LAN</th>
                        <th>N° Asignado</th>
                        <th>IMEI/IMSI</th>
                        <th>Serial telef</th>
                        <th>Estado Físico genera</th>
                        <th>Estado de Funcionalidad</th>
                        <th>nombre_asig_equipo</th>
                        <th>activo</th>
                        <th>ip_asignada</th>
                        <th>Dependencia</th>
                        <th>oficina</th>
                        <th>lugar</th>
                        <th>img_frontal_equipo</th>
                        <th>img_serial_modelo</th>
                        <th>Asignado A</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($equipos as $equipo): ?>
                    <tr>
                        <td><?php echo $equipo['id']; ?></td>
                        <td><?php echo $equipo['tipo_de_equipo']; ?></td>
                        <td><?php echo $equipo['modelo']; ?></td>
                        <td><?php echo $equipo['marca']; ?></td>
                        <td><?php echo $equipo['n_puertos_LAN']; ?></td>
                        <td><?php echo $equipo['n_asignado']; ?></td>
                        <td><?php echo $equipo['IMEI_IMSI2']; ?></td>
                        <td><?php echo $equipo['serial_telef']; ?></td>
                        <td><?php echo $equipo['esta_fisico_general']; ?></td>
                        <td><?php echo $equipo['esta_de_funcionalidad']; ?></td>
                        <td><?php echo $equipo['nombre_asig_equipo']; ?></td>
                        <td><?php echo $equipo['activo']; ?></td>
                        <td><?php echo $equipo['ip_asignada']; ?></td>
                        <td><?php echo $equipo['dependencia']; ?></td>
                        <td><?php echo $equipo['oficina']; ?></td>
                        <td><?php echo $equipo['lugar']; ?></td>
                        <td><?php echo $equipo['img_frontal_equipo']; ?></td>
                        <td><?php echo $equipo['img_serial_modelo']; ?></td>
                        <td><?php echo $equipo['asignado_A']; ?></td>
                        <td>
                            <a href="?editar=<?php echo $equipo['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="?eliminar=<?php echo $equipo['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este equipo?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 