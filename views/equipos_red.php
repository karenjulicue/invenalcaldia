<?php
require_once '../config/database.php';
// Eliminar equipo
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM equipos_red WHERE id = ?");
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
    $stmt = $conn->prepare("SELECT * FROM equipos_red WHERE id = ?");
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
        $_POST['n_puertos_LAN_optica'],
        $_POST['n_de_fibras'],
        $_POST['serial_red'],
        $_POST['nombre_asig_equipo'],
        $_POST['propietario_activo'],
        $_POST['ip_asignado'],
        $_POST['identi_de_red_SSID'],
        $_POST['clave_wifi'],
        $_POST['dependencia'],
        $_POST['lugar'],
        $_POST['img_frontal_equipo'],
        $_POST['img_serial_modelo'],
        $_POST['asignado_A'],
        $id
    ];
    $sql = "UPDATE equipos_red SET tipo_de_equipo=?, modelo=?, marca=?, n_puertos_LAN_optica=?, n_de_fibras=?, serial_red=?, nombre_asig_equipo=?, propietario_activo=?, ip_asignado=?, identi_de_red_SSID=?, clave_wifi=?, dependencia=?, lugar=?, img_frontal_equipo=?, img_serial_modelo=?, asignado_A=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
    header('Location: ../views/equipos_red.php');
    exit();
}

// Agregar nuevo equipo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_equipo'])) {
    $data = [
        $_POST['tipo_de_equipo'],
        $_POST['modelo'],
        $_POST['marca'],
        $_POST['n_puertos_LAN_optica'],
        $_POST['n_de_fibras'],
        $_POST['serial_red'],
        $_POST['nombre_asig_equipo'],
        $_POST['propietario_activo'],
        $_POST['ip_asignado'],
        $_POST['identi_de_red_SSID'],
        $_POST['clave_wifi'],
        $_POST['dependencia'],
        $_POST['lugar'],
        $_POST['img_frontal_equipo'],
        $_POST['img_serial_modelo'],
        $_POST['asignado_A']
    ];
    $sql = "INSERT INTO equipos_red (tipo_de_equipo, modelo, marca, n_puertos_LAN_optica, n_de_fibras, serial_red, nombre_asig_equipo, propietario_activo, ip_asignado, identi_de_red_SSID, clave_wifi, dependencia, lugar, img_frontal_equipo, img_serial_modelo, asignado_A) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
    header('Location: ../views/equipos_red.php');
    exit();
}

// Obtener todos los equipos
$stmt = $conn->query("SELECT * FROM equipos_red ORDER BY id DESC");
$equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Equipos de Red</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style_inventario.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container">
        <h2 class="mb-4">Gestión de Equipos de Red</h2>
        
        <!-- Formulario para agregar/editar equipos -->
        <div class="form-section">
            <form method="POST" action="" autocomplete="off">
                <?php if($editando && $equipoEditar): ?>
                    <input type="hidden" name="id" value="<?php echo $equipoEditar['id']; ?>">
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="tipo_de_equipo" class="form-label">Tipo de Equipo</label>
                        <select class="form-control" id="tipo_de_equipo" name="tipo_de_equipo" required>
                            <option value="">Seleccione...</option>
                            <option value="Router" <?php echo ($editando && $equipoEditar['tipo_de_equipo'] == 'Router') ? 'selected' : ''; ?>>Router</option>
                            <option value="Switch" <?php echo ($editando && $equipoEditar['tipo_de_equipo'] == 'Switch') ? 'selected' : ''; ?>>Switch</option>
                            <option value="Access Point" <?php echo ($editando && $equipoEditar['tipo_de_equipo'] == 'Access Point') ? 'selected' : ''; ?>>Access Point</option>
                            <option value="Modem" <?php echo ($editando && $equipoEditar['tipo_de_equipo'] == 'Modem') ? 'selected' : ''; ?>>Modem</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['modelo']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['marca']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="n_puertos_LAN_optica" class="form-label">Número de Puertos LAN/Óptica</label>
                        <input type="text" class="form-control" id="n_puertos_LAN_optica" name="n_puertos_LAN_optica" value="<?php echo $editando ? htmlspecialchars($equipoEditar['n_puertos_LAN_optica']) : ''; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="n_de_fibras" class="form-label">Número de Fibras</label>
                        <input type="text" class="form-control" id="n_de_fibras" name="n_de_fibras" value="<?php echo $editando ? htmlspecialchars($equipoEditar['n_de_fibras']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="serial_red" class="form-label">Serial</label>
                        <input type="text" class="form-control" id="serial_red" name="serial_red" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['serial_red']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="nombre_asig_equipo" class="form-label">Nombre Asignación Equipo</label>
                        <input type="text" class="form-control" id="nombre_asig_equipo" name="nombre_asig_equipo" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['nombre_asig_equipo']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="propietario_activo" class="form-label">Propietario Activo</label>
                        <input type="text" class="form-control" id="propietario_activo" name="propietario_activo" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['propietario_activo']) : ''; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="ip_asignado" class="form-label">IP Asignada</label>
                        <input type="text" class="form-control" id="ip_asignado" name="ip_asignado" value="<?php echo $editando ? htmlspecialchars($equipoEditar['ip_asignado']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="identi_de_red_SSID" class="form-label">Identificador de Red (SSID)</label>
                        <input type="text" class="form-control" id="identi_de_red_SSID" name="identi_de_red_SSID" value="<?php echo $editando ? htmlspecialchars($equipoEditar['identi_de_red_SSID']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="clave_wifi" class="form-label">Clave WiFi</label>
                        <input type="text" class="form-control" id="clave_wifi" name="clave_wifi" value="<?php echo $editando ? htmlspecialchars($equipoEditar['clave_wifi']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="dependencia" class="form-label">Dependencia</label>
                        <input type="text" class="form-control" id="dependencia" name="dependencia" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['dependencia']) : ''; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="lugar" class="form-label">Lugar</label>
                        <input type="text" class="form-control" id="lugar" name="lugar" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['lugar']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="img_frontal_equipo" class="form-label">Imagen Frontal del Equipo</label>
                        <input type="text" class="form-control" id="img_frontal_equipo" name="img_frontal_equipo" value="<?php echo $editando ? htmlspecialchars($equipoEditar['img_frontal_equipo']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="img_serial_modelo" class="form-label">Imagen Serial/Modelo</label>
                        <input type="text" class="form-control" id="img_serial_modelo" name="img_serial_modelo" value="<?php echo $editando ? htmlspecialchars($equipoEditar['img_serial_modelo']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="asignado_A" class="form-label">Asignado A</label>
                        <input type="text" class="form-control" id="asignado_A" name="asignado_A" value="<?php echo $editando ? htmlspecialchars($equipoEditar['asignado_A']) : ''; ?>">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <?php if($editando): ?>
                            <button type="submit" name="guardar_edicion" class="btn btn-primary">Guardar Cambios</button>
                            <a href=" ../views/equipos_red.php" class="btn btn-secondary">Cancelar</a>
                        <?php else: ?>
                            <button type="submit" name="agregar_equipo" class="btn btn-success">Agregar Equipo</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de equipos -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo de Equipo</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Puertos LAN/Óptica</th>
                        <th>Fibras</th>
                        <th>Serial</th>
                        <th>Nombre Asignación equipo</th>
                        <th>propietario Activo</th>
                        <th>IP Asignada</th>
                        <th>Identificador de red SSID</th>
                        <th>Clave WiFi</th>
                        <th>Dependencia</th>
                        <th>Lugar</th>
                        <th>Imagen Frontal</th>
                        <th>Imagen Serial Modelo</th>
                        <th>Asignado A</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipos as $equipo): ?>
                    <tr>
                        <td><?php echo $equipo['id']; ?></td>
                        <td><?php echo $equipo['tipo_de_equipo']; ?></td>
                        <td><?php echo $equipo['modelo']; ?></td>
                        <td><?php echo $equipo['marca']; ?></td>
                        <td><?php echo $equipo['n_puertos_LAN_optica']; ?></td>
                        <td><?php echo $equipo['n_de_fibras']; ?></td>
                        <td><?php echo $equipo['serial_red']; ?></td>
                        <td><?php echo $equipo['nombre_asig_equipo']; ?></td>
                        <td><?php echo $equipo['propietario_activo']; ?></td>
                        <td><?php echo $equipo['ip_asignado']; ?></td>
                        <td><?php echo $equipo['identi_de_red_SSID']; ?></td>
                        <td><?php echo $equipo['clave_wifi']; ?></td>
                        <td><?php echo $equipo['dependencia']; ?></td>
                        <td><?php echo $equipo['lugar']; ?></td>
                        <td><?php echo $equipo['img_frontal_equipo']; ?></td>
                        <td><?php echo $equipo['img_serial_modelo']; ?></td>
                        <td><?php echo $equipo['asignado_A']; ?></td>
                        <td>
                            <a href="?editar=<?php echo $equipo['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="?eliminar=<?php echo $equipo['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este equipo?')">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 