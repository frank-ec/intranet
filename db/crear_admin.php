<?php
// Script de línea de comandos para crear o actualizar la contraseña de un usuario admin.
// Uso: php db/crear_admin.php <usuario> <password> ["Nombre completo"]

require_once __DIR__ . '/../includes/db.php';

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('Este script solo puede ejecutarse desde la línea de comandos.');
}

$usuario = $argv[1] ?? null;
$password = $argv[2] ?? null;
$nombreCompleto = $argv[3] ?? null;

if (!$usuario || !$password) {
    fwrite(STDERR, "Uso: php crear_admin.php <usuario> <password> [\"Nombre completo\"]\n");
    exit(1);
}

if (strlen($password) < 8) {
    fwrite(STDERR, "La contraseña debe tener al menos 8 caracteres.\n");
    exit(1);
}

$pdo = get_db();
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare('SELECT id FROM usuarios WHERE usuario = ?');
$stmt->execute([$usuario]);
$existente = $stmt->fetch();

if ($existente) {
    $pdo->prepare('UPDATE usuarios SET password_hash = ?, nombre_completo = ?, activo = 1 WHERE id = ?')
        ->execute([$hash, $nombreCompleto, $existente['id']]);
    echo "Contraseña actualizada para el usuario '$usuario'.\n";
} else {
    $pdo->prepare('INSERT INTO usuarios (usuario, password_hash, nombre_completo) VALUES (?, ?, ?)')
        ->execute([$usuario, $hash, $nombreCompleto]);
    echo "Usuario '$usuario' creado correctamente.\n";
}
