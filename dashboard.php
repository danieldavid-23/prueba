<?php
require_once 'includes/config.php';
requerirLogin();
$usuario = getUsuarioActual();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mi Sistema</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container container-dashboard">
        <h2 class="dashboard-title">✅ ¡Bienvenido, <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>!</h2>
        
        <div class="info">
            <p><strong>📧 Email:</strong> <?= htmlspecialchars($_SESSION['usuario_email']) ?></p>
            <p><strong>📅 Fecha de registro:</strong> <?= $usuario['fecha_registro'] ?? 'No disponible' ?></p>
            <p><strong>🕐 Último acceso:</strong> <?= $usuario['ultimo_acceso'] ?? 'Primera vez' ?></p>
            <p><strong>🆔 ID de usuario:</strong> <?= $_SESSION['usuario_id'] ?></p>
        </div>
        
        <button onclick="location.href='logout.php'" class="btn-danger">🚪 Cerrar sesión</button>
    </div>
</body>
</html>