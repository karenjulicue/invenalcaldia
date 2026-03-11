<?php
require_once '../config/database.php';

$validar = $_SESSION['nombre'];

if( $validar == null || $validar == ''){

    header("Location: ./includes/login.php");                                 
    die();
       
}

// Obtener el rol del usuario
$userRole = $_SESSION['role'];
$userName = $_SESSION['username'];
if (isset($_GET['form']) && $_GET['form'] == 'nuevo_usuario') 
?>


<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>

	<link rel="stylesheet" href="./css/style_inventario.css">
</head>

<body id="page-top">
<form action="/invenalcaldia/includes/validar.php" method="POST">
<div id="login" >
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">

                            <h3 class="text-center">Registro de nuevo usuario</h3>
                            <div class="form-group">
                            <label for="username" class="form-label">Nombre *</label>
                            <input type="text"  id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                            <label for="apellido" class="form-label">Apellido *</label>
                            <input type="text"  id="apellido" name="apellido" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Correo:</label><br>
                                <input type="email" name="correo" id="correo" class="form-control" placeholder="">
                            </div>
                                
                            <div class="form-group">
                                <label for="password">Contraseña:</label><br>
                                <input type="password" name="password" id="password" class="form-control" required>
                            
                            
                            <div class="form-group">
                            <label for="role" class="form-label">Rol *</label>
                            <select id="role" name="role" class="form-select">
                                <option value="administrador">Administrador</option>
                                <option value="usuario">Usuario</option>
                                </select> 
                                <div class="mb-3">                                  
                                    
                               <input type="submit" value="Guardar"class="btn btn-success"name="registrar">
                               <a href="./views/user.php" class="btn btn-danger">Cancelar</a>
                               
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</body>
</html>