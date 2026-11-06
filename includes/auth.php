<?php

require_once __DIR__ . '/db.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function usuario_autenticado(): ?array {
    return $_SESSION['usuario'] ?? null;
}

function requerir_login(): void {
    if (!usuario_autenticado()) {
        header('Location: login.php');
        exit;
    }
}

function intentar_login(PDO $pdo, string $usuario, string $password): bool {
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE usuario = ? AND activo = 1');
    $stmt->execute([$usuario]);
    $fila = $stmt->fetch();

    if ($fila && password_verify($password, $fila['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['usuario'] = [
            'id' => $fila['id'],
            'usuario' => $fila['usuario'],
            'nombre_completo' => $fila['nombre_completo'],
        ];
        return true;
    }

    return false;
}

function cerrar_sesion(): void {
    $_SESSION = [];
    session_destroy();
}
