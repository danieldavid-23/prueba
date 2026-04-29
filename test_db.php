<?php
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test de Conexión</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { padding: 40px; }
        .container-test { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; }
        h1 { color: #667eea; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container-test">
        <h1>🔌 Probando conexión a la base de datos</h1>
        
        <?php
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
            $resultado = $stmt->fetch();
            
            echo "<div class='success'>✅ ¡Conexión exitosa!</div>";
            echo "<p>📊 Base de datos: <strong>sistema_login</strong></p>";
            echo "<p>👥 Usuarios registrados: <strong>" . $resultado['total'] . "</strong></p>";
            
            $stmt = $pdo->query("SELECT id, nombre, email, fecha_registro FROM usuarios");
            $usuarios = $stmt->fetchAll();
            
            if(count($usuarios) > 0) {
                echo "<h2>📋 Lista de usuarios registrados:</h2>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Fecha Registro</th></tr>";
                foreach($usuarios as $user) {
                    echo "<tr>";
                    echo "<td>" . $user['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($user['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                    echo "<td>" . $user['fecha_registro'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            
            echo "<p class='text-center'><a href='index.php' class='btn-primary' style='display: inline-block; text-decoration: none; width: auto; padding: 10px 20px;'>🔐 Ir al Login</a></p>";
            
        } catch(PDOException $e) {
            echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
        }
        ?>
    </div>
</body>
</html>