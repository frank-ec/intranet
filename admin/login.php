<?php
require_once __DIR__ . '/../includes/auth.php';

if (usuario_autenticado()) {
    header('Location: index.php');
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usuario === '' || $password === '') {
        $error = 'Ingrese usuario y contraseña.';
    } elseif (intentar_login(get_db(), $usuario, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administración - Intranet</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login-shell">
        <div class="admin-card">
            <h2 class="text-center">Acceso administrador</h2>

            <?php if ($error): ?>
                <div class="admin-mensaje error"><?php echo htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form class="admin-form" method="post">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" required autofocus>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>

                <div class="admin-actions">
                    <button type="submit" class="btn">Ingresar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
