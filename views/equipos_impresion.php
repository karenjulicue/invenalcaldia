<?php
require_once '../config/database.php';

// Eliminar equipo
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM equipos_impresion  WHERE id = ?");
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
    $stmt = $conn->prepare("SELECT * FROM equipos_impresion WHERE id = ?");
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
        $_POST['tiene_puertos_LAN'],
        $_POST['tiene_wifi'],
        $_POST['serial_impre'],
        $_POST['nombre_asig_equipo'],
        $_POST['activo'],
        $_POST['ip_asignada'],
        $_POST['dependencia'],
        $_POST['oficina'],
        $_POST['lugar'],
        $_POST['esta_general_equipo'],
        $_POST['observaciones'],
        $_POST['img_frontal_equipo'],
        $_POST['img_serial_modelo'],
        $_POST['asignado_A'],
        $id
    ];
    $sql = "UPDATE equipos_impresion SET tipo_de_equipo=?, modelo=?, marca=?, tiene_puertos_LAN=?, tiene_wifi=?, serial_impre=?, nombre_asig_equipo=?, activo=?, ip_asignada=?, dependencia=?, oficina=?, lugar=?, esta_general_equipo=?, observaciones=?, img_frontal_equipo=?, img_serial_modelo=?, asignado_A=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
    header('Location: ../views/equipos_impresion.php');
    exit();
}

// Agregar nuevo equipo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_equipo'])) {
    $data = [
        $_POST['tipo_de_equipo'],
        $_POST['modelo'],
        $_POST['marca'],
        $_POST['tiene_puertos_LAN'],
        $_POST['tiene_wifi'],
        $_POST['serial_impre'],
        $_POST['nombre_asig_equipo'],
        $_POST['activo'],
        $_POST['ip_asignada'],
        $_POST['dependencia'],
        $_POST['oficina'],
        $_POST['lugar'],
        $_POST['esta_general_equipo'],
        $_POST['observaciones'],
        $_POST['img_frontal_equipo'],
        $_POST['img_serial_modelo'],
        $_POST['asignado_A']
    ];
    $sql = "INSERT INTO equipos_impresion (tipo_de_equipo, modelo, marca, tiene_puertos_LAN, tiene_wifi, serial_impre, nombre_asig_equipo, activo, ip_asignada, dependencia, oficina, lugar, esta_general_equipo, observaciones, img_frontal_equipo, img_serial_modelo, asignado_A) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
    header('Location: ../views/equipos_impresion.php');
    exit();
}
// Obtener todos los equipos
$stmt = $conn->query("SELECT * FROM equipos_impresion ORDER BY id DESC");
$equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// HTML y CSS para la interfaz
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Equipos de Impresión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style_inventario.css" rel="stylesheet">

</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container">
        <h2 class="mb-4">Gestión de Equipos de Impresión</h2>
        
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
                            <option value="Laser" <?php echo ($editando && $equipoEditar['tipo_de_equipo'] == 'Laser') ? 'selected' : ''; ?>>Laser</option>
                            <option value="Inyección" <?php echo ($editando && $equipoEditar['tipo_de_equipo'] == 'Inyección') ? 'selected' : ''; ?>>Inyección</option>
                            <option value="Matricial" <?php echo ($editando && $equipoEditar['tipo_de_equipo'] == 'Matricial') ? 'selected' : ''; ?>>Matricial</option>
                            <option value="Multifuncional" <?php echo ($editando && $equipoEditar['tipo_de_equipo'] == 'Multifuncional') ? 'selected' : ''; ?>>Multifuncional</option>
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
                </div>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="tiene_puertos_LAN" class="form-label">Tiene Puertos LAN</label>
                        <select class="form-control" id="tiene_puertos_LAN" name="tiene_puertos_LAN" required>
                            <option value="">Seleccione...</option>
                            <option value="SI" <?php echo ($editando && $equipoEditar['tiene_puertos_LAN'] == 'SI') ? 'selected' : ''; ?>>Sí</option>
                            <option value="NO" <?php echo ($editando && $equipoEditar['tiene_puertos_LAN'] == 'NO') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="tiene_wifi" class="form-label">Tiene WiFi</label>
                        <select class="form-control" id="tiene_wifi" name="tiene_wifi" required>
                            <option value="">Seleccione...</option>
                            <option value="SI" <?php echo ($editando && $equipoEditar['tiene_wifi'] == 'SI') ? 'selected' : ''; ?>>Sí</option>
                            <option value="NO" <?php echo ($editando && $equipoEditar['tiene_wifi'] == 'NO') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="serial_impre" class="form-label">Serial impre</label>
                        <input type="text" class="form-control" id="serial_impre" name="serial_impre" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['serial_impre']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="nombre_asig_equipo" class="form-label">Nombre Asignación Equipo</label>
                        <input type="text" class="form-control" id="nombre_asig_equipo" name="nombre_asig_equipo" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['nombre_asig_equipo']) : ''; ?>">
                    </div>
                    
                    <div class="col-md-3 mb-2">
                        <label for="activo" class="form-label">Activo</label>
                        <input type="text" class="form-control" id="activo" name="activo" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['Activo']) : ''; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="ip_asignada" class="form-label">IP Asignada</label>
                        <input type="text" class="form-control" id="ip_asignada" name="ip_asignada" value="<?php echo $editando ? htmlspecialchars($equipoEditar['ip_asignada']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="dependencia" class="form-label">Dependencia</label>
                        <input type="text" class="form-control" id="dependencia" name="dependencia" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['dependencia']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="oficina" class="form-label">Oficina</label>
                        <input type="text" class="form-control" id="oficina" name="oficina" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['oficina']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="lugar" class="form-label">Lugar</label>
                        <input type="text" class="form-control" id="lugar" name="lugar" required value="<?php echo $editando ? htmlspecialchars($equipoEditar['lugar']) : ''; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="esta_general_equipo" class="form-label">Estado General del Equipo</label>
                        <select class="form-control" id="esta_general_equipo" name="esta_general_equipo" required>
                            <option value="">Seleccione...</option>
                            <option value="Excelente" <?php echo ($editando && $equipoEditar['esta_general_equipo'] == 'Excelente') ? 'selected' : ''; ?>>Excelente</option>
                            <option value="Bueno" <?php echo ($editando && $equipoEditar['esta_general_equipo'] == 'Bueno') ? 'selected' : ''; ?>>Bueno</option>
                            <option value="Regular" <?php echo ($editando && $equipoEditar['esta_general_equipo'] == 'Regular') ? 'selected' : ''; ?>>Regular</option>
                            <option value="Malo" <?php echo ($editando && $equipoEditar['esta_general_equipo'] == 'Malo') ? 'selected' : ''; ?>>Malo</option>
                        </select>
                    </div>
                   
                    <div class="col-md-3 mb-2">
                        <label for="img_frontal_equipo" class="form-label">imagen Frontal</label>
                        <input type="text" class="form-control" id="img_frontal_equipo" name="img_frontal_equipo" value="<?php echo $editando ? htmlspecialchars($equipoEditar['img_frontal_equipo']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="img_serial_modelo" class="form-label">imagen Serial/Modelo</label>
                        <input type="text" class="form-control" id="img_serial_modelo" name="img_serial_modelo" value="<?php echo $editando ? htmlspecialchars($equipoEditar['img_serial_modelo']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="asignado_A" class="form-label">Asignado A</label>
                        <input type="text" class="form-control" id="asignado_A" name="asignado_A" value="<?php echo $editando ? htmlspecialchars($equipoEditar['asignado_A']) : ''; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"><?php echo $editando ? htmlspecialchars($equipoEditar['observaciones']) : ''; ?></textarea>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <?php if($editando): ?>
                            <button type="submit" name="guardar_edicion" class="btn btn-primary">Guardar Cambios</button>
                            <a href="equipos_impresion.php" class="btn btn-secondary">Cancelar</a>
                        <?php else: ?>
                            <button type="submit" name="agregar_equipo" class="btn btn-success">Agregar Equipo</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de equipos -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo de quipo</th>
                        <th>modelo</th>
                        <th>marca</th>
                        <th>tiene puertos LAN</th>
                        <th>tiene wifi</th>
                        <th>serial impresora</th>
                        <th>nombre asig equipo</th>
                        <th>activo</th>
                        <th>ip asignada</th>
                        <th>dependencia</th>
                        <th>oficina</th>
                        <th>lugar</th>
                        <th>estado general</th>
                        <th>observaciones</th>
                        <th>imagen frontal equipo</th>
                        <th>imagen serial modelo</th>
                        <th>asigando A</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($equipos as $equipo): ?>
                    <tr>
                        <td><?php echo $equipo['id']; ?></td>
                        <td><?php echo $equipo['tipo_de_equipo']; ?></td>
                        <td><?php echo $equipo['modelo']; ?></td>
                        <td><?php echo $equipo['marca']; ?></td>
                        <td><?php echo $equipo['tiene_puertos_LAN']; ?></td>
                        <td><?php echo $equipo['tiene_wifi']; ?></td>
                        <td><?php echo $equipo['serial_impre']; ?></td>
                        <td><?php echo $equipo['nombre_asig_equipo']; ?></td>
                        <td><?php echo $equipo['activo']; ?></td>
                        <td><?php echo $equipo['ip_asignada']; ?></td>
                        <td><?php echo $equipo['dependencia']; ?></td>
                        <td><?php echo $equipo['oficina']; ?></td>
                        <td><?php echo $equipo['lugar']; ?></td>
                        <td><?php echo $equipo['esta_general_equipo']; ?></td>
                        <td><?php echo $equipo['observaciones']; ?></td>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 