<?php
require_once '../config/database.php';
// Eliminar equipo
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM equipos_computo WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: ../views/equipos_computo.php');
    exit();
}

// Obtener equipo para editar
$editando = false;
$equipoEditar = null;
if (isset($_GET['editar'])) {
    $editando = true;
    $id = intval($_GET['editar']);
    $stmt = $conn->prepare("SELECT * FROM equipos_computo WHERE id = ?");
    $stmt->execute([$id]);
    $equipoEditar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Procesar edición de equipo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_edicion'])) {
    $id = intval($_POST['id']);
    
    // Actualizar hardware
    $sql_hardware = "UPDATE equipos_computo_hardware SET 
        tipo_de_equipo = ?, tamaño_torre = ?, 
        modelo = ?, marca_torre = ?, estado_del_equipo = ?, 
        vida_util = ?, adaptador_de_voltaje = ?, serial_equi = ?, 
        bateria = ?, puertos = ?, tipo_de_torre = ?, tipo_de_pantalla = ?, 
        modelo_monitor = ?, puertos_monitor = ?, marca_monitor = ?, 
        estado_monitor = ?, activo_perteneciente = ?, img_frontal_equipo = ?, 
        img_serial_modelo = ?, asignado_A = ? 
        WHERE id = ?";
    
    $data_hardware = [
        $_POST['tipo_de_equipo'],
        $_POST['tamaño_torre'],
        $_POST['modelo'],
        $_POST['marca_torre'],
        $_POST['estado_del_equipo'],
        $_POST['vida_util'],
        $_POST['adaptador_de_voltaje'],
        $_POST['serial_equi'],
        $_POST['bateria'],
        $_POST['puertos'],
        $_POST['tipo_de_torre'],
        $_POST['tipo_de_pantalla'],
        $_POST['modelo_monitor'],
        $_POST['puertos_monitor'],
        $_POST['marca_monitor'],
        $_POST['estado_monitor'],
        $_POST['activo_perteneciente'],
        $_POST['img_frontal_equipo'],
        $_POST['img_serial_modelo'],
        $_POST['asignado_A'],
        $id
    ];
    
    $stmt_hardware = $conn->prepare($sql_hardware);
    $stmt_hardware->execute($data_hardware);
    
    // Actualizar software
    $sql_software = "UPDATE equipos_computo_software SET 
        sistema_operativo = ?, tipo_sist_operativo = ?, s_o_licencia = ?, 
        ofimatica = ?, office_licenciado = ?, compresor_arch_rar = ?, 
        lector_PDF = ?, Skype = ?, sistema_nomina = ?, id_web_nomina = ?, 
        backup_auto = ?, antivirus = ?, tipo_antivirus = ?, 
        nombre_asig_equipo = ? 
        WHERE equipo_hardware_id = ?";
    
    $data_software = [
        $_POST['sistema_operativo'],
        $_POST['tipo_sist_operativo'],
        $_POST['s_o_licencia'],
        $_POST['ofimatica'],
        $_POST['office_licenciado'],
        $_POST['compresor_arch_rar'],
        $_POST['lector_PDF'],
        $_POST['Skype'],
        $_POST['sistema_nomina'],
        $_POST['id_web_nomina'],
        $_POST['backup_auto'],
        $_POST['antivirus'],
        $_POST['tipo_antivirus'],
        $_POST['nombre_asig_equipo'],
        $id
    ];
    
    $stmt_software = $conn->prepare($sql_software);
    $stmt_software->execute($data_software);
    
    header('Location: ../views/equipos_computo.php');
    exit();
}

// Procesar nuevo equipo                                        
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_equipo'])) {
    // Insertar hardware primero
    $sql_hardware = "INSERT INTO equipos_computo_hardware (
        tipo_de_equipo, tamaño_torre, modelo, marca_torre,
        estado_del_equipo, vida_util, adaptador_de_voltaje, serial_equi,
        bateria, puertos, tipo_de_torre, tipo_de_pantalla, modelo_monitor,
        puertos_monitor, marca_monitor, estado_monitor, activo_perteneciente,
        img_frontal_equipo, img_serial_modelo, asignado_A
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $data_hardware = [
        $_POST['tipo_de_equipo'],
        $_POST['tamaño_torre'],
        $_POST['modelo'],
        $_POST['marca_torre'],
        $_POST['estado_del_equipo'],
        $_POST['vida_util'],
        $_POST['adaptador_de_voltaje'],
        $_POST['serial_equi'],
        $_POST['bateria'],
        $_POST['puertos'],
        $_POST['tipo_de_torre'],
        $_POST['tipo_de_pantalla'],
        $_POST['modelo_monitor'],
        $_POST['puertos_monitor'],
        $_POST['marca_monitor'],
        $_POST['estado_monitor'],
        $_POST['activo_perteneciente'],
        $_POST['img_frontal_equipo'],
        $_POST['img_serial_modelo'],
        $_POST['asignado_A']
    ];
    
    $stmt_hardware = $conn->prepare($sql_hardware);
    $stmt_hardware->execute($data_hardware);
    $hardware_id = $conn->lastInsertId();
    
    // Insertar software
    $sql_software = "INSERT INTO equipos_computo_software (
        sistema_operativo, tipo_sist_operativo, s_o_licencia, ofimatica,
        office_licenciado, compresor_arch_rar, lector_PDF, Skype,
        sistema_nomina, id_web_nomina, backup_auto, antivirus,
        tipo_antivirus, nombre_asig_equipo, equipo_hardware_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $data_software = [
        $_POST['sistema_operativo'],
        $_POST['tipo_sist_operativo'],
        $_POST['s_o_licencia'],
        $_POST['ofimatica'],
        $_POST['office_licenciado'],
        $_POST['compresor_arch_rar'],
        $_POST['lector_PDF'],
        $_POST['Skype'],
        $_POST['sistema_nomina'],
        $_POST['id_web_nomina'],
        $_POST['backup_auto'],
        $_POST['antivirus'],
        $_POST['tipo_antivirus'],
        $_POST['nombre_asig_equipo'],
        $hardware_id
    ];
    
    $stmt_software = $conn->prepare($sql_software);
    $stmt_software->execute($data_software);
    
    header('Location: ../views/equipos_computo.php');
    exit();
}
// ...código existente...

// Obtener todos los equipos (CAMBIA ESTA PARTE)
$stmt = $conn->query("
    SELECT h.*, s.*
    FROM equipos_computo_hardware h
    LEFT JOIN equipos_computo_software s ON h.id = s.equipo_hardware_id
    ORDER BY h.id DESC
");
$equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ...código existente...

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Equipos de Cómputo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style_inventario.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container">
        <h2 class="mb-4">Gestión de Equipos de Cómputo</h2>
        
        <!-- Formulario para agregar/editar equipos -->
        <div class="form-section">
            <form method="POST" action="" autocomplete="off">
                <?php if($editando && $equipoEditar): ?>
                    <input type="hidden" name="id" value="<?php echo $equipoEditar['id']; ?>">
                <?php endif; ?>
                
                <!-- Sección de Hardware -->
                <h4 class="mb-3">Información de Hardware</h4>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="tipo_de_equipo" class="form-label">Tipo de Equipo</label>
                        <select class="form-control" id="tipo_de_equipo" name="tipo_de_equipo" required>
                            <option value="">Seleccione...</option>
                            <option value="Desktop" <?php echo ($editando && $equipoEditar['tipo_de_equipo'] == 'Desktop') ? 'selected' : ''; ?>>Desktop</option>
                            <option value="Laptop" <?php echo ($editando && $equipoEditar['tipo_de_equipo'] == 'Laptop') ? 'selected' : ''; ?>>Laptop</option>
                            <option value="All-in-One" <?php echo ($editando && $equipoEditar['tipo_de_equipo'] == 'All-in-One') ? 'selected' : ''; ?>>All-in-One</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="tamaño_torre" class="form-label">Tamaño Torre</label>
                        <select class="form-control" id="tamaño_torre" name="tamaño_torre" required>
                            <option value="">Seleccione...</option>
                            <option value="tamaño_torre" <?php echo ($editando && $equipoEditar['tamaño_torre'] == 'E-ATX(305mm X 330mm)') ? 'selected' : ''; ?>> ATX(305mm X 330mm)</option>
                            <option value="tamaño_torre" <?php echo ($editando && $equipoEditar['tamaño_torre'] == 'ATX(305mm X 244mm)') ? 'selected' : ''; ?>> ATX(305mm X 244mm)</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" required 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['modelo']) : ''; ?>">
                    </div>
                    
                    <div class="col-md-3 mb-2">
                        <label for="marca_torre" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca_torre" name="marca_torre" required 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['marca_torre']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="estado_del_equipo" class="form-label">Estado del equipo</label>
                        <select class="form-control" id="estado_del_equipo" name="estado_del_equipo" required>
                            <option value="">Seleccione...</option>
                            <option value="Bueno">Bueno</option>
                            <option value="Regular">Regular</option>
                            <option value="Malo">Malo</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="vida_util" class="form-label">Vida útil</label>
                        <input type="text" class="form-control" id="vida_util" name="vida_util" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="adaptador_de_voltaje" class="form-label">Adaptador de voltaje</label>
                        <input type="text" class="form-control" id="adaptador_de_voltaje" name="adaptador_de_voltaje" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="serial_equi" class="form-label">Serial</label>
                        <input type="text" class="form-control" id="serial_equi" name="serial_equi" required 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['serial_equi']) : ''; ?>">
                    </div>

                     <div class="col-md-3 mb-2">
                        <label for="bateria" class="form-label">Bateria</label>
                        <select class="form-control" id="bateria" name="bateria" required>
                            <option value="">Seleccione...</option>
                            <option value="no aplica" <?php echo ($editando && $equipoEditar['bateria'] == 'no aplica') ? 'selected' : ''; ?>> No Aplica</option>
                            <option value="si,buen estado" <?php echo ($editando && $equipoEditar['bateria'] == 'si,buen estado') ? 'selected' : ''; ?>>Si,Buen Estado</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="puertos" class="form-label">Puertos</label>
                        <input type="text" class="form-control" id="puertos" name="puertos" required 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['puertos']) : ''; ?>">
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="tipo_de_torre" class="form-label">Tipo de Torre</label>
                        <select class="form-control" id="tipo_de_torre" name="tipo_de_torre" required>
                            <option value="">Seleccione...</option>
                            <option value="torre completa" <?php echo ($editando && $equipoEditar['tipo_de_torre'] == 'torre completa') ? 'selected' : ''; ?>> Torre Completa</option>
                            <option value="torre media" <?php echo ($editando && $equipoEditar['tipo_de_torre'] == 'torre media') ? 'selected' : ''; ?>>Torre media</option>
                            <option value="minitorre" <?php echo ($editando && $equipoEditar['tipo_de_torre'] == 'Minitorre') ? 'selected' : ''; ?>>Minitorre</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="tipo_de_pantalla" class="form-label">Tipo de Pantalla</label>
                        <select class="form-control" id="tipo_de_pantalla" name="tipo_de_pantalla" required>
                            <option value="">Seleccione...</option>
                            <option value="LCD" <?php echo ($editando && $equipoEditar['tipo_de_pantalla'] == 'LCD') ? 'selected' : ''; ?>>LCD</option>
                            <option value="LED" <?php echo ($editando && $equipoEditar['tipo_de_pantalla'] == 'LED') ? 'selected' : ''; ?>>LED</option>
                            <option value="OLED" <?php echo ($editando && $equipoEditar['tipo_de_pantalla'] == 'OLED') ? 'selected' : ''; ?>>OLED</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="modelo_monitor" class="form-label">Modelo Monitor</label>
                        <input type="text" class="form-control" id="modelo_monitor" name="modelo_monitor" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['modelo_monitor']) : ''; ?>">
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="puertos_monitor" class="form-label">Puertos Monitor</label>
                        <input type="text" class="form-control" id="puertos_monitor" name="puertos_monitor" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['puertos_monitor']) : ''; ?>">
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="marca_monitor" class="form-label">Marca Monitor</label>
                        <select class="form-control" id="marca_monitor" name="marca_monitor" required>
                            <option value="">Seleccione...</option>
                            <option value="Samsung" <?php echo ($editando && $equipoEditar['marca_monitor'] == 'Samsung') ? 'selected' : ''; ?>>Samsung</option>
                            <option value="LG" <?php echo ($editando && $equipoEditar['marca_monitor'] == 'LG') ? 'selected' : ''; ?>>LG</option>
                            <option value="Dell" <?php echo ($editando && $equipoEditar['marca_monitor'] == 'Dell') ? 'selected' : ''; ?>>Dell</option>
                            <option value="HP" <?php echo ($editando && $equipoEditar['marca_monitor'] == 'HP') ? 'selected' : ''; ?>>HP</option>
                            <option value="Janus" <?php echo ($editando && $equipoEditar['marca_monitor'] == 'Janus') ? 'selected' : ''; ?>>Janus</option>
                            <option value="Acer" <?php echo ($editando && $equipoEditar['marca_monitor'] == 'Acer') ? 'selected' : ''; ?>>Acer</option>
                            <option value="Asus" <?php echo ($editando && $equipoEditar['marca_monitor'] == 'Asus') ? 'selected' : ''; ?>>Asus</option>
                            <option value="Noc" <?php echo ($editando && $equipoEditar['marca_monitor'] == 'Noc') ? 'selected' : ''; ?>>Noc</option>
                            <option value="Lenovo" <?php echo ($editando && $equipoEditar['marca_monitor'] == 'Lenovo') ? 'selected' : ''; ?>>Lenovo</option>
                            <option value="Kalley" <?php echo ($editando && $equipoEditar['marca_monitor'] == 'Kalley') ? 'selected' : ''; ?>>Kalley</option>
                            <option value="Otro" <?php echo ($editando && $equipoEditar['marca_monitor'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                            </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="estado_monitor" class="form-label">Estado Monitor</label>
                        <select class="form-control" id="estado_monitor" name="estado_monitor" required>
                            <option value="">Seleccione...</option>
                            <option value="buen estado" <?php echo ($editando && $equipoEditar['estado_monitor'] == 'buen estado') ? 'selected' : ''; ?>>Buen Estado</option>
                            <option value="estado regular" <?php echo ($editando && $equipoEditar['estado_monitor'] == 'estado regular') ? 'selected' : ''; ?>>Regular</option>
                            <option value="En reparación" <?php echo ($editando && $equipoEditar['estado_monitor'] == 'En reparación') ? 'selected' : ''; ?>>En reparación</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="activo_perteneciente" class="form-label">Activo perteneciente</label>
                        <input type="text" class="form-control" id="activo_perteneciente" name="activo_perteneciente" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['activo_perteneciente']) : ''; ?>">
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="img_frontal_equipo" class="form-label">Imagen Frontal del Equipo</label>
                        <input type="text" class="form-control" id="img_frontal_equipo" name="img_frontal_equipo" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['img_frontal_equipo']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="img_serial_modelo" class="form-label">Imagen Serial y Modelo</label>
                        <input type="text" class="form-control" id="img_serial_modelo" name="img_serial_modelo" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['img_serial_modelo']) : ''; ?>">            
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="asignado_A" class="form-label">Asignado A</label>
                        <input type="text" class="form-control" id="asignado_A" name="asignado_A" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['asignado_A']) : ''; ?>">
                    </div>
                    
                </div>    

                <!-- Sección de Software -->
                <h4 class="mb-3 mt-4">Información de Software</h4>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="sistema_operativo" class="form-label">Sistema Operativo</label>
                        <input type="text" class="form-control" id="sistema_operativo" name="sistema_operativo" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['sistema_operativo']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="tipo_sist_operativo" class="form-label">Tipo de Sistema Operativo</label>
                        <select class="form-control" id="tipo_sist_operativo" name="tipo_sist_operativo">
                            <option value="">Seleccione...</option>
                            <option value="si" <?php echo ($editando && $equipoEditar['tipo_sist_operativo'] == 'si') ? 'selected' : ''; ?>>Si</option>
                            <option value="no" <?php echo ($editando && $equipoEditar['tipo_sist_operativo'] == 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="s_o_licenciado" class="form-label">Sistema Operativo licenciado</label>
                        <input type="text" class="form-control" id="s_o_licenciado" name="s_o_licenciado" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['s_o_licenciado']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="ofimatica" class="form-label">Ofimática</label>
                        <select class="form-control" id="ofimatica" name="ofimatica">
                            <option value="">Seleccione...</option>
                            <option value="Office 2016" <?php echo ($editando && $equipoEditar['ofimatica'] == 'Office 2016') ? 'selected' : ''; ?>>Office 2016</option>
                            <option value="Otro" <?php echo ($editando && $equipoEditar['ofimatica'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                        </select> 
                              
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="office_licenciado" class="form-label">Office Licenciado</label>
                        <input type="text" class="form-control" id="office_licenciado" name="office_licenciado" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['office_licenciado']) : ''; ?>">
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="compresor_arch_rar" class="form-label">Compresor de Archivos (RAR)</label>
                        <input type="text" class="form-control" id="compresor_arch_rar" name="compresor_arch_rar" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['compresor_arch_rar']) : ''; ?>">
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="lector_PDF" class="form-label">Lector de PDF</label>
                        <input type="text" class="form-control" id="lector_PDF" name="lector_PDF" 
                           value="<?php echo $editando ? htmlspecialchars($equipoEditar['lector_PDF']) : ''; ?>">
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="Skype" class="form-label">Skype</label>
                        <input type="text" class="form-control" id="Skype" name="Skype" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['Skype']) : ''; ?>">
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="sistema_nomina" class="form-label">Sistema de Nómina</label>
                        <input type="text" class="form-control" id="sistema_nomina" name="sistema_nomina" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['sistema_nomina']) : ''; ?>"> 
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="id_web_nomina" class="form-label">ID Web Nómina</label>
                        <input type="text" class="form-control" id="id_web_nomina" name="id_web_nomina" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['id_web_nomina']) : ''; ?>">
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="backup_auto" class="form-label">Backup Automático</label>
                        <select class="form-control" id="backup_auto" name="backup_auto">
                            <option value="">Seleccione...</option>
                            <option value="Sí" <?php echo ($editando && $equipoEditar['backup_auto'] == 'Sí') ? 'selected' : ''; ?>>Sí</option>
                            <option value="No" <?php echo ($editando && $equipoEditar['backup_auto'] == 'No') ? 'selected' : ''; ?>>No</option>   
                        </select>
                    </div>      
                    <div class="col-md-3 mb-2">
                        <label for="antivirus" class="form-label">Antivirus</label>
                        <input type="text" class="form-control" id="antivirus" name="antivirus" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['antivirus']) : ''; ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="tipo_antivirus" class="form-label">Tipo de Antivirus</label>
                        <select class="form-control" id="tipo_antivirus" name="tipo_antivirus">
                            <option value="">Seleccione...</option>
                            <option value="Gratuito" <?php echo ($editando && $equipoEditar['tipo_antivirus'] == 'Gratuito') ? 'selected' : ''; ?>>Gratuito</option>
                            <option value="Licenciado" <?php echo ($editando && $equipoEditar['tipo_antivirus'] == 'Licenciado') ? 'selected' : ''; ?>>Licenciado</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="nombre_asig_equipo" class="form-label">Nombre Asignación equipo</label>
                        <input type="text" class="form-control" id="nombre_asig_equipo" name="nombre_asig_equipo" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['nombre_asig_equipo']) : ''; ?>">
                    </div>
                    <?php if ($editando): ?>
                    <div class="col-md-3 mb-2">
                        <label for="equipo_hardware_id" class="form-label">ID Hardware</label>
                        <input type="text" class="form-control" id="equipo_hardware_id" name="equipo_hardware_id" 
                               value="<?php echo $editando ? htmlspecialchars($equipoEditar['equipo_hardware_id']) : ''; ?>">                          
                    </div> 
                    <?php endif; ?>          
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <?php if($editando): ?>
                            <button type="submit" name="guardar_edicion" class="btn btn-primary">Guardar Cambios</button>
                            <a href=" ../views/equipos_computo.php" class="btn btn-secondary">Cancelar</a>
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
                        <th>tipo de equipo</th>
                        <th>tamaño torre</th>
                        <th>Modelo</th>
                        <th>Marca torre</th>
                        <th>Estado del equipo</th>
                        <th>Vida útil</th>
                        <th>Adaptador de voltaje</th>
                        <th>Serial equipo</th>
                        <th>Batería</th>
                        <th>Puertos</th>
                        <th>Tipo de torre</th>
                        <th>Tipo de pantalla</th>
                        <th>Modelo monitor</th>
                        <th>Puertos monitor</th>
                        <th>Marca monitor</th>
                        <th>Estado monitor</th>
                        <th>Activo perteneciente</th>
                        <th>Sistema Operativo</th>
                        <th>tipo sistema operativo</th>
                        <th>S.O. Licencia</th>
                        <th>Ofimática</th>
                        <th>Office Licenciado</th>
                        <th>Compresor de Archivos (Rar)</th>
                        <th>Lector PDF</th>
                        <th>Skype</th>
                        <th>Sistema Nómina</th>
                        <th>ID Web Nómina</th>
                        <th>Backup Automático</th>
                        <th>antivirus</th>
                        <th>Tipo Antivirus</th>
                        <th>Nombre Asignación equipo</th>
                        <th>equipo hardware ID</th>
                        <th>imagen frontal equipo</th>
                        <th>imagen serial modelo</th>
                        <th>Asignado A</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($equipos as $equipo): ?>
                        <tr>
                            <td><?php echo $equipo['id']; ?></td>
                            <td><?php echo $equipo['tipo_de_equipo']; ?></td>
                            <td><?php echo $equipo['tamaño_torre']; ?></td>
                            <td><?php echo $equipo['modelo']; ?></td>
                            <td><?php echo $equipo['marca_torre']; ?></td>
                            <td><?php echo $equipo['estado_del_equipo']; ?></td>
                            <td><?php echo $equipo['vida_util']; ?></td>
                            <td><?php echo $equipo['adaptador_de_voltaje']; ?></td>
                            <td><?php echo $equipo['bateria']; ?></td>
                            <td><?php echo $equipo['puertos']; ?></td>
                            <td><?php echo $equipo['tipo_de_torre']; ?></td>
                            <td><?php echo $equipo['tipo_de_pantalla']; ?></td>
                            <td><?php echo $equipo['modelo_monitor']; ?></td>
                            <td><?php echo $equipo['puertos_monitor']; ?></td>
                            <td><?php echo $equipo['marca_monitor']; ?></td>
                            <td><?php echo $equipo['estado_monitor']; ?></td>
                            <td><?php echo $equipo['activo_perteneciente']; ?></td>
                            <td><?php echo $equipo['sistema_operativo']; ?></td>
                            <td><?php echo $equipo['tipo_sist_operativo']; ?></td>
                            <td><?php echo $equipo['s_o_licencia']; ?></td>
                            <td><?php echo $equipo['ofimatica']; ?></td>
                            <td><?php echo $equipo['office_licenciado']; ?></td>
                            <td><?php echo $equipo['compresor_arch_rar']; ?></td>
                            <td><?php echo $equipo['lector_PDF']; ?></td>
                            <td><?php echo $equipo['Skype']; ?></td>
                            <td><?php echo $equipo['sistema_nomina']; ?></td>
                            <td><?php echo $equipo['id_web_nomina']; ?></td>
                            <td><?php echo $equipo['backup_auto']; ?></td>
                            <td><?php echo $equipo['antivirus']; ?></td>
                            <td><?php echo $equipo['tipo_antivirus']; ?></td>
                            <td><?php echo $equipo['nombre_asig_equipo']; ?></td>
                            <td><?php echo $equipo['equipo_hardware_id']; ?></td>
                            <td><?php echo $equipo['img_frontal_equipo']; ?></td>
                            <td><?php echo $equipo['img_serial_modelo']; ?></td>
                            <td><?php echo $equipo['asignado_A']; ?></td>
                            <td>
                                <a href="?editar=<?php echo $equipo['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="?eliminar=<?php echo $equipo['id']; ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Está seguro de eliminar este equipo?')">Eliminar</a>
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