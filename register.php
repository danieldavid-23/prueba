<?php
require_once 'includes/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    
    if (empty($nombre) || empty($email) || empty($password)) {
        $error = 'Todos los campos son obligatorios';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email no válido';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres';
    } elseif ($password !== $confirm) {
        $error = 'Las contraseñas no coinciden';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'El email ya está registrado';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$nombre, $email, $hash])) {
                $success = '✅ ¡Registro exitoso! <a href="index.php">Inicia sesión aquí</a>';
            } else {
                $error = 'Error al registrar';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Mi Sistema</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container container-register">
        <h2>📝 Registro de Usuario</h2>
        
        <?php if($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Nombre completo:</label>
                <input type="text" name="nombre" placeholder="Juan Pérez" required>
            </div>
            
            <div class="form-group">
                <label>Correo electrónico:</label>
                <input type="email" name="email" placeholder="juan@ejemplo.com" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" placeholder="Mínimo 6 caracteres" required>
            </div>
            
            <div class="form-group">
                <label>Confirmar contraseña:</label>
                <input type="password" name="confirm_password" placeholder="Repite tu contraseña" required>
            </div>
            
            <button type="submit" class="btn-success">Registrarse</button>
        </form>
        
        <p class="text-center">
            ¿Ya tienes cuenta? <a href="index.php">Inicia sesión</a>
        </p>
    </div>
</body>
</html>