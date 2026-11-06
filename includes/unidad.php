<?php

require_once __DIR__ . '/db.php';

const UNIDAD_POR_DEFECTO = 'Hospital Básico Cayambe';

/** Nombre de la única unidad operativa que sirve este sitio. */
function obtener_unidad_actual(PDO $pdo): string {
    $fila = $pdo->query('SELECT nombre FROM unidad_operativa WHERE id = 1')->fetch();
    return $fila ? $fila['nombre'] : UNIDAD_POR_DEFECTO;
}

function actualizar_unidad(PDO $pdo, string $nombre): void {
    $pdo->prepare(
        'INSERT INTO unidad_operativa (id, nombre, actualizado_en) VALUES (1, ?, datetime("now"))
         ON CONFLICT(id) DO UPDATE SET nombre = excluded.nombre, actualizado_en = excluded.actualizado_en'
    )->execute([$nombre]);
}
