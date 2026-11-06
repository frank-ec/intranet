<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/categorias.php';

/**
 * Carga una página activa junto con sus enlaces (sueltos y agrupados por categoría).
 * Devuelve null si la página no existe o está inactiva.
 */
function cargar_contenido_pagina(PDO $pdo, string $slug): ?array {
    $stmt = $pdo->prepare('SELECT * FROM paginas WHERE slug = ? AND activa = 1');
    $stmt->execute([$slug]);
    $pagina = $stmt->fetch();
    if (!$pagina) {
        return null;
    }

    $categorias = obtener_categorias_pagina($pdo, $pagina['id'], true);
    $arbol = arbol_categorias($categorias);

    $stmt = $pdo->prepare(
        'SELECT e.*, i.ruta AS imagen_ruta FROM enlaces e
         LEFT JOIN imagenes i ON i.id = e.imagen_id
         WHERE e.pagina_id = ? AND e.activo = 1 ORDER BY e.orden, e.titulo'
    );
    $stmt->execute([$pagina['id']]);
    $todos = $stmt->fetchAll();

    $sueltos = [];
    $porCategoria = [];
    foreach ($todos as $enlace) {
        if ($enlace['categoria_id'] !== null) {
            $porCategoria[(int) $enlace['categoria_id']][] = $enlace;
        } else {
            $sueltos[] = $enlace;
        }
    }

    return [
        'pagina' => $pagina,
        'arbol_categorias' => $arbol,
        'enlaces_sueltos' => $sueltos,
        'enlaces_por_categoria' => $porCategoria,
    ];
}

/** Markup de enlace para menús tipo grid (clase menu-item), como en el índice. */
function enlace_html_menu(array $enlace): string {
    $target = $enlace['abrir_nueva_pestana'] ? ' target="_blank"' : '';
    $icono = $enlace['imagen_ruta']
        ? '<img class="menu-item__icon" src="' . htmlspecialchars($enlace['imagen_ruta']) . '" alt="' . htmlspecialchars($enlace['titulo']) . '">'
        : '';
    return '<li><a class="menu-item" href="' . htmlspecialchars($enlace['url']) . '"' . $target . '>'
        . $icono
        . '<span class="menu-item__label">' . htmlspecialchars($enlace['titulo']) . '</span></a></li>';
}

/** Markup de enlace para listas simples (clase link-list), como en matrices/seguros. */
function enlace_html_lista(array $enlace): string {
    $target = $enlace['abrir_nueva_pestana'] ? ' target="_blank"' : '';
    $icono = $enlace['imagen_ruta']
        ? '<img src="' . htmlspecialchars($enlace['imagen_ruta']) . '" alt="' . htmlspecialchars($enlace['titulo']) . '">'
        : '';
    return '<a href="' . htmlspecialchars($enlace['url']) . '"' . $target . '>'
        . $icono
        . '<span>' . htmlspecialchars($enlace['titulo']) . '</span></a>';
}

/** Imprime un <ul class="menu-grid"> con los enlaces sueltos (+ html extra) y una <section> por categoría. */
function render_menu_pagina(?array $contenido, string $extraLisHtml = ''): void {
    echo '<ul class="menu-grid">';
    foreach ($contenido['enlaces_sueltos'] ?? [] as $enlace) {
        echo enlace_html_menu($enlace);
    }
    echo $extraLisHtml;
    echo '</ul>';

    foreach ($contenido['arbol_categorias'] ?? [] as $categoria) {
        $enlacesCategoria = $contenido['enlaces_por_categoria'][$categoria['id']] ?? [];
        if (!$enlacesCategoria) {
            continue;
        }
        echo '<section style="margin-top: 20px; padding-left: ' . ($categoria['nivel'] * 20) . 'px;">';
        echo '<h3>' . htmlspecialchars($categoria['nombre']) . '</h3>';
        echo '<ul class="menu-grid">';
        foreach ($enlacesCategoria as $enlace) {
            echo enlace_html_menu($enlace);
        }
        echo '</ul></section>';
    }
}

/** Imprime los enlaces (sueltos y por categoría) con el markup de .link-list. */
function render_lista_pagina(?array $contenido): void {
    foreach ($contenido['enlaces_sueltos'] ?? [] as $enlace) {
        echo enlace_html_lista($enlace);
    }

    foreach ($contenido['arbol_categorias'] ?? [] as $categoria) {
        $enlacesCategoria = $contenido['enlaces_por_categoria'][$categoria['id']] ?? [];
        if (!$enlacesCategoria) {
            continue;
        }
        echo '<h3 class="text-center" style="width:100%; margin-top: 12px;">' . htmlspecialchars($categoria['nombre']) . '</h3>';
        foreach ($enlacesCategoria as $enlace) {
            echo enlace_html_lista($enlace);
        }
    }
}
