<?php

function admin_layout_inicio(string $titulo): void {
    $usuario = usuario_autenticado();
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($titulo) ?> - Administración</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-shell">
        <div class="admin-topbar">
            <nav>
                <a href="index.php">Páginas</a>
                <a href="notas.php">Notas importantes</a>
                <a href="unidades.php">Unidad Operativa</a>
            </nav>
            <div>
                <span>Hola, <?php echo htmlspecialchars($usuario['nombre_completo'] ?: $usuario['usuario']) ?></span>
                &middot; <a href="logout.php">Cerrar sesión</a>
                &middot; <a href="../index.php">Ver intranet</a>
            </div>
        </div>
    <?php
}

function admin_layout_fin(): void {
    ?>
    </div>
</body>
</html>
    <?php
}

function admin_mensaje_flash(?string $tipo, ?string $texto): void {
    if (!$texto) {
        return;
    }
    $clase = $tipo === 'error' ? 'error' : 'exito';
    echo '<div class="admin-mensaje ' . $clase . '">' . htmlspecialchars($texto) . '</div>';
}
