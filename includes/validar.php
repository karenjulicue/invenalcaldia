<?php
session_start();
require_once '../config/database.php';

// Código para procesar el inicio de sesión
if(isset($_POST['login'])) {
    // Validar los datos de entrada
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    
    if(empty($username) || empty($password) || empty($role)) {
        $_SESSION['error'] = "Todos los campos son obligatorios";
        header('Location: login.php');
        exit();
    }
    
    try {
        // Verificar si el usuario existe en la base de datos
        $stmt = $conn->prepare("SELECT id, username, password, role FROM usuarios WHERE username = ? AND role = ?");
        $stmt->execute([$username, $role]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);                                     
        
        if($user && $password === $user['password']) {
            // Inicio de sesión exitoso
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nombre'] = $user['username']; // Para compatibilidad con el código existente
            $_SESSION['last_activity'] = time();
            
            // Si se seleccionó "Recordarme"
            if(isset($_POST['remember']) && $_POST['remember'] == 'on') {
                $token = bin2hex(random_bytes(32));
                $tokenHash = password_hash($token, PASSWORD_DEFAULT);
                $expires = time() + (30 * 24 * 60 * 60); // 30 días
                
                $stmt = $conn->prepare("UPDATE usuarios SET remember_token = ?, token_expires = ? WHERE id = ?");
                $stmt->execute([$tokenHash, date('Y-m-d H:i:s', $expires), $user['id']]);
                
                setcookie('remember_token', $token, [
                    'expires' => $expires,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);
            }
            
            // Redirigir según el rol
            if($user['role'] == 'administrador') {
                header('Location: ../views/admin.php');
            } else if($user['role'] == 'usuario') {
                header('Location: ../views/usuario.php');
            }
            exit();
        } else {
            // Credenciales inválidas
            $_SESSION['error'] = "Usuario, contraseña o rol incorrectos";
            header('Location: ../includes/login.php');
            exit();
        }
    } catch(PDOException $e) {
        echo 'Error SQL: ' . $e->getMessage();
        exit();
        // Registrar el error sin mostrarlo al usuario
        error_log("Error de inicio de sesión: " . $e->getMessage());
        $_SESSION['error'] = "Ocurrió un error durante el inicio de sesión. Por favor, inténtelo de nuevo.";
        header('Location: login.php');
        exit();
    }
}

if(isset($_POST['registrar'])){

    if(strlen($_POST['username']) >=1  && strlen($_POST['password'])  >=1 && strlen($_POST['role']) >= 1 ){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']); 
    
    // Usar consulta preparada con PDO
    $consulta = "INSERT INTO usuarios (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($consulta);
    $stmt->execute([$username, $password, $role]);
    header('Location: ../views/admin.php'); 
  }
}

?>



<?php
require_once '../config/database.php';

if(isset($_POST['mostrar'])){

    if(strlen($_POST['username']) >=1 && strlen($_POST['apellido'])  >=1 && strlen($_POST['direccion'])  >=1 && strlen($_POST['correo'])  >=1 
    && strlen($_POST['contraseña'])  >=1 && strlen($_POST['role']) >= 1 ){

    $nombre = trim($_POST['username']);
    $descripcion = trim($_POST['apellido']);
    $estado = trim($_POST['direccion']);
    $estado = trim($_POST['correo']);
    $fecha_creacion = trim($_POST['contraseña']);
    $fecha_actualizacion = trim($_POST['role']);

    $consulta= "INSERT INTO lista_usuarios (username, apellido, direccion, correo, contraseña, rol)
    VALUES ('$username', '$apellido', '$dirreccion', '$correo', '$contraseña', '$role')";

    mysqli_query($conn, $consulta);
    mysqli_close($conn);

    header('Location: ../views/admin.php');
  }
}
?>