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
    <title>Sistema de Inventario - Alcaldía Municipal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .nav-link {
            color: #333 !important;
        }
        .nav-link:hover {
            color: #0286fa !important;
        }
        .user-info {
            color: #666;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="bi bi-building"></i> Alcaldía Municipal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="inventarioDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-box"></i> Inventario
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href=" ../views/equipos_computo.php">Equipos de computo</a></li>
                            <li><a class="dropdown-item" href=" ../views/equipos_telefonia.php">Equipos de telefonia</a></li>
                            <li><a class="dropdown-item" href=" ../views/equipos_impresion.php">Equipos de impresion</a></li>
                            <li><a class="dropdown-item" href=" ../views/equipos_red.php">Equipos de red</a></li>
                            <!-- Agregar más opciones de inventario aquí -->
                        </ul>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="user-info me-3">
                        <i class="bi bi-person-circle"></i> <?php echo $_SESSION['nombre']; ?>
                    </div>
                    <a href="../views/admin.php" class="nav-link">
                        <i class="bi bi-house"></i> inicio
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Agrega esto antes de </body> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>