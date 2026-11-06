<?php

function obtener_categorias_pagina(PDO $pdo, int $paginaId, bool $soloActivas = false): array {
    $sql = 'SELECT * FROM categorias WHERE pagina_id = ?';
    if ($soloActivas) {
        $sql .= ' AND activa = 1';
    }
    $sql .= ' ORDER BY orden, nombre';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$paginaId]);
    return $stmt->fetchAll();
}

/**
 * Aplana el árbol de categorías en orden jerárquico, agregando 'nivel' (0 = raíz).
 */
function arbol_categorias(array $categorias, ?int $padreId = null, int $nivel = 0): array {
    $resultado = [];
    foreach ($categorias as $cat) {
        $catPadre = $cat['padre_id'] !== null ? (int) $cat['padre_id'] : null;
        if ($catPadre === $padreId) {
            $cat['nivel'] = $nivel;
            $resultado[] = $cat;
            $resultado = array_merge($resultado, arbol_categorias($categorias, (int) $cat['id'], $nivel + 1));
        }
    }
    return $resultado;
}

/**
 * Ids de todas las categorías descendientes de $categoriaId (sin incluirla a ella misma).
 * Útil para evitar que una categoría se asigne como hija de su propio descendiente.
 */
function ids_descendientes(array $categorias, int $categoriaId): array {
    $hijos = array_filter($categorias, fn($c) => (int) $c['padre_id'] === $categoriaId);
    $ids = [];
    foreach ($hijos as $hijo) {
        $ids[] = (int) $hijo['id'];
        $ids = array_merge($ids, ids_descendientes($categorias, (int) $hijo['id']));
    }
    return $ids;
}
