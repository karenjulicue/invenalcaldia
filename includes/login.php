<?php
session_start();

if (isset($_SESSION['nombre'])) {
    // Si ya hay sesión, redirige a la página principal correspondiente
    if ($_SESSION['tipo'] == 'admin') {
        header("Location: ../views/admin.php");
    } else {
        header("Location: ../views/usuario.php");                                               
    }
    exit();
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              

// Marcar si hay cookies para recordarme
if(isset($_COOKIE['remember_token'])) {
    require_once '../config/database.php';


    try {
        $stmt = $conn->prepare("SELECT id, username, role, remember_token, token_expires FROM usuarios WHERE remember_token IS NOT NULL AND token_expires > NOW()");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($users as $user) {
            if(password_verify($_COOKIE['remember_token'], $user['remember_token'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['last_activity'] = time();
                
               // Regenerar token por seguridad
                $newToken = bin2hex(random_bytes(32));
                $tokenHash = password_hash($newToken, PASSWORD_DEFAULT);                     
                $expires = time() + (30 * 24 * 60 * 60); // 30 days
                
                $stmt = $conn->prepare("UPDATE usuarios SET remember_token = ?, token_expires = ? WHERE id = ?");
                $stmt->execute([$tokenHash, date('Y-m-d H:i:s', $expires), $user['id']]);
                
                setcookie('remember_token', $newToken, [
                    'expires' => $expires,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);
                
                header("Location: ../views/admin.php");
                exit();
            }
        }
        
        // Si llegamos aquí, el token no era válido
        setcookie('remember_token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    } catch (Exception $e) {
        // Registrar el error pero no mostrarlo al usuario
        error_log("Error en remember me: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../css/style_login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <h1 class="login-title">Invenalcaldia</h1>
        </div>
        
        <?php
        if(isset($_SESSION['error'])) {
            echo '<div class="error-message">' . htmlspecialchars($_SESSION['error']) . '</div>';
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])) {
            echo '<div class="success-message">' . htmlspecialchars($_SESSION['success']) . '</div>';
            unset($_SESSION['success']);
        }
        ?>
        
        <form action="validar.php" method="post" id="loginForm" autocomplete="off">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required 
                       pattern="[a-zA-Z0-9_]{3,20}" 
                       title="El usuario debe tener entre 3 y 20 caracteres y solo puede contener letras, números y guiones bajos"
                       autocomplete="username">
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required 
                       pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$"
                       title="La contraseña debe tener al menos 8 caracteres, incluir una letra, un número y un carácter especial"
                       autocomplete="current-password">
                <div class="password-strength">
                    <div class="password-strength-bar"></div>
                </div>
                <div class="password-requirements">
                    La contraseña debe tener al menos 8 caracteres, incluir una letra, un número y un carácter especial
                </div>
            </div>
            
            <div class="form-group">
                <label for="role">Rol:</label>
                <select id="role" name="role" required>
                    <option value="">Seleccione un rol</option>
                    <option value="administrador">Administrador</option>
                    <option value="usuario">Usuario</option>
                </select>
            </div>
            
            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <span>Recordarme</span>
                </label>
                <a href="reset_password.php" class="forgot-password">¿Olvidó su contraseña?</a>
            </div>
            
            <button type="submit" name="login" class="login-btn">Iniciar Sesión</button>
        </form>
    </div>

    <script>
        // Comprobador de la fortaleza de la contraseña
        const password = document.getElementById('password');
        const strengthBar = document.querySelector('.password-strength-bar');
        
        password.addEventListener('input', function() {
            const val = password.value;
            const strength = calculatePasswordStrength(val);
            
            strengthBar.style.width = strength + '%';
            strengthBar.className = 'password-strength-bar';
            
            if (strength < 33) {
                strengthBar.classList.add('strength-weak');
            } else if (strength < 66) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        });
        
        function calculatePasswordStrength(password) {
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]+/)) strength += 25;
            if (password.match(/[A-Z]+/)) strength += 25;
            if (password.match(/[0-9]+/)) strength += 25;
            if (password.match(/[^a-zA-Z0-9]+/)) strength += 25;
            
            return Math.min(strength, 100);
        }

        // Evitar el reenvío del formulario al actualizar la página
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html> 