<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "INSERT INTO equipos (
            marca_temporal, tipo_equipo, tamano_torre, modelo, marca, 
            estado_equipo, vida_util, adaptador_voltaje, bateria, 
            serial_equi, puertos, observaciones, tipo_pantalla, 
            modelo_pantalla, puertos_pantalla, categoria_id
        ) VALUES (
            NOW(), :tipo_equipo, :tamano_torre, :modelo, :marca,
            :estado_equipo, :vida_util, :adaptador_voltaje, :bateria,
            :serial_equi, :puertos, :observaciones, :tipo_pantalla,
            :modelo_pantalla, :puertos_pantalla, :categoria_id
        )";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($_POST);
        
        header('Location: index.php');
        exit;
    } catch(PDOException $e) {
        $error = "Error al guardar: " . $e->getMessage();
    }
}

$categorias = $conn->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Equipo - Inventario Alcaldía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Agregar Nuevo Equipo</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipo de Equipo</label>
                    <input type="text" name="tipo_equipo" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select" required>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria['id']; ?>">
                                <?php echo $categoria['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tamaño Torre</label>
                    <input type="text" name="tamano_torre" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Modelo</label>
                    <input type="text" name="modelo" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Marca</label>
                    <input type="text" name="marca" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Estado del Equipo</label>
                    <select name="estado_equipo" class="form-select" required>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                        <option value="En reparación">En reparación</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Vida Útil (años)</label>
                    <input type="number" name="vida_util" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Serial</label>
                    <input type="text" name="serial" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Adaptador de Voltaje</label>
                    <input type="text" name="adaptador_voltaje" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Batería</label>
                    <input type="text" name="bateria" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Puertos</label>
                    <input type="text" name="puertos" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo de Pantalla</label>
                    <input type="text" name="tipo_pantalla" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Modelo de Pantalla</label>
                    <input type="text" name="modelo_pantalla" class="form-control">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="3"></textarea>
                </div>
            </div>
            
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Guardar Equipo</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 