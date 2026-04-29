<?php
// Configuración de la base de datos
$host = '127.0.0.1';
$port = '3306';
$dbname = 'sistema_login';
$user = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estaLogueado() {
    return isset($_SESSION['usuario_id']);
}

function requerirLogin() {
    if (!estaLogueado()) {
        header('Location: index.php');
        exit;
    }
}

function getUsuarioActual() {
    global $pdo;
    if (!estaLogueado()) return null;
    
    $stmt = $pdo->prepare("SELECT id, nombre, email, fecha_registro, ultimo_acceso FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    return $stmt->fetch();
}
?>