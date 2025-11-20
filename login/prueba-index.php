

<?php
// Login handler: verifica credenciales contra la tabla `users` en la BD
session_start();
require_once __DIR__ . '/../database/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Si no es POST, redirigir al formulario de login
    header('Location: login.php');
    exit;
}

$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['pass'] ?? '';

if ($usuario === '' || $password === '') {
    header('Location: login.php?error=1');
    exit;
}

// Buscar usuario por username o email
$stmt = $mysqli->prepare('SELECT id, username, password_hash FROM users WHERE username = ? OR email = ? LIMIT 1');
if (!$stmt) {
    // Error de BD: mostrar genérico
    header('Location: login.php?error=1');
    exit;
}
$stmt->bind_param('ss', $usuario, $usuario);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    // usuario no encontrado
    header('Location: login.php?error=1');
    exit;
}

// Verificar contraseña (asumimos password_hash almacenado con password_hash())
if (!password_verify($password, $user['password_hash'])) {
    header('Location: login.php?error=1');
    exit;
}

// Autenticación exitosa
$_SESSION['verificado'] = 'si';
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];

// Redirigir a la página protegida o al index
header('Location: ../index.php');
exit;

?>