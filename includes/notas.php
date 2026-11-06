<?php

function obtener_notas_importantes(PDO $pdo): array {
    return $pdo->query('SELECT * FROM notas_importantes ORDER BY orden, id')->fetchAll();
}

function obtener_notas_importantes_activas(PDO $pdo): array {
    return $pdo->query('SELECT * FROM notas_importantes WHERE activa = 1 ORDER BY orden, id')->fetchAll();
}
