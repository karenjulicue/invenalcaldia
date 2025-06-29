<?php
session_start();
error_reporting(0);

// Validación de sesión
$validar = $_SESSION['nombre'];
if ($validar == null || $validar == '') {
    header("Location: ../includes/login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - Alcaldía Municipal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../css/style_inventario.css" rel="stylesheet">
</head>
<body id="page-top">
    <div class="header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="../assets/logo.png" alt="Logo Alcaldía" class="logo">
            <h1 class="ms-3 text-white mb-0">INVENTARIO</h1>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="search-box d-flex align-items-center me-3">
                <input type="text" class="form-control border-0 me-2" placeholder="Buscar...">
                <i class="fas fa-search text-secondary"></i>
            </div>
            <div class="dropdown" id="profileDropdown">
                    <a class="btn custom-btn btn-salir" href="../includes/_sesion/cerrarSesion.php">Cerrar sesión</a>
                </div>
        </div>
    </div>

    <div class="sidebar">
        <h2>Menú</h2>
        <ul>
            <li><a href="#" id="btnUsuariosSide">Usuarios</a></li>
        </ul>
    </div>
    
    <div class="dashboard-wrapper">
        <h1>Bienvenido Administrador, <?php echo $_SESSION['nombre']; ?></h1>
        <div class="dashboard-cards">
            <div class="card-dashboard">
                <h3>Equipos de Cómputo</h3>
                <a href="equipos_computo.php" class="resaltar-link">Ver</a>
            </div>
            <div class="card-dashboard">
                <h3>Equipos de Telefonía</h3>
                <a href="equipos_telefonia.php" class="resaltar-link">Ver</a>
            </div>
            <div class="card-dashboard">
                <h3>Equipos de Impresión</h3>
                <a href="equipos_impresion.php" class="resaltar-link">Ver</a>
            </div>
            <div class="card-dashboard">
                <h3>Equipos de Red</h3>
                <a href="equipos_red.php" class="resaltar-link">Ver</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

