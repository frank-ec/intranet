<?php
// Script de una sola vez: carga en la base de datos los enlaces que hoy están
// hardcodeados en includes/enlaces.php y en las páginas estáticas, creando una
// página por cada archivo .php existente. Es seguro volver a ejecutarlo: no
// duplica páginas (slug único) ni enlaces (se verifica título+url antes de insertar).
// Uso: php db/migrar_datos_existentes.php

require_once __DIR__ . '/../includes/db.php';

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('Este script solo puede ejecutarse desde la línea de comandos.');
}

$pdo = get_db();

function obtener_o_crear_pagina(PDO $pdo, string $slug, string $titulo, int $esPrincipal, int $orden): int {
    $stmt = $pdo->prepare('SELECT id FROM paginas WHERE slug = ?');
    $stmt->execute([$slug]);
    $fila = $stmt->fetch();
    if ($fila) {
        return (int) $fila['id'];
    }
    $pdo->prepare('INSERT INTO paginas (slug, titulo, es_principal, orden) VALUES (?, ?, ?, ?)')
        ->execute([$slug, $titulo, $esPrincipal, $orden]);
    return (int) $pdo->lastInsertId();
}

function obtener_o_crear_categoria(PDO $pdo, int $paginaId, string $nombre, int $orden = 0): int {
    $stmt = $pdo->prepare('SELECT id FROM categorias WHERE pagina_id = ? AND nombre = ? AND padre_id IS NULL');
    $stmt->execute([$paginaId, $nombre]);
    $fila = $stmt->fetch();
    if ($fila) {
        return (int) $fila['id'];
    }
    $pdo->prepare('INSERT INTO categorias (pagina_id, nombre, orden) VALUES (?, ?, ?)')
        ->execute([$paginaId, $nombre, $orden]);
    return (int) $pdo->lastInsertId();
}

function obtener_o_crear_imagen(PDO $pdo, ?string $ruta): ?int {
    if (!$ruta) {
        return null;
    }
    $stmt = $pdo->prepare('SELECT id FROM imagenes WHERE ruta = ?');
    $stmt->execute([$ruta]);
    $fila = $stmt->fetch();
    if ($fila) {
        return (int) $fila['id'];
    }

    $rutaFisica = __DIR__ . '/../' . $ruta;
    $mime = is_file($rutaFisica) ? @mime_content_type($rutaFisica) : null;
    $tamanio = is_file($rutaFisica) ? filesize($rutaFisica) : null;

    $pdo->prepare('INSERT INTO imagenes (nombre_original, ruta, mime, tamanio_bytes) VALUES (?, ?, ?, ?)')
        ->execute([basename($ruta), $ruta, $mime, $tamanio]);
    return (int) $pdo->lastInsertId();
}

function cargar_enlace(PDO $pdo, int $paginaId, ?int $categoriaId, array $enlace, int $orden): void {
    $stmt = $pdo->prepare('SELECT id FROM enlaces WHERE pagina_id = ? AND titulo = ? AND url = ?');
    $stmt->execute([$paginaId, $enlace['titulo'], $enlace['url']]);
    if ($stmt->fetch()) {
        return; // ya migrado
    }

    $imagenId = obtener_o_crear_imagen($pdo, $enlace['icono'] ?? null);

    $pdo->prepare(
        'INSERT INTO enlaces (pagina_id, categoria_id, titulo, url, imagen_id, tipo, abrir_nueva_pestana, orden)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    )->execute([
        $paginaId,
        $categoriaId,
        $enlace['titulo'],
        $enlace['url'],
        $imagenId,
        $enlace['tipo'] ?? 'externo',
        !empty($enlace['target_blank']) ? 1 : 0,
        $orden,
    ]);
}

// ---------------------------------------------------------------------------
// Definición de las páginas existentes y sus enlaces
// ---------------------------------------------------------------------------

$paginas = [
    [
        'slug' => 'index',
        'titulo' => 'Menú Principal',
        'es_principal' => 1,
        'orden' => 0,
        'enlaces' => [
            ['titulo' => 'Quipux', 'url' => 'https://www.gestiondocumental.gob.ec', 'icono' => 'img/quipux.jpg', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'Agendamiento - SAU', 'url' => 'https://agendamiento.msp.gob.ec/', 'icono' => 'img/sau.png', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'SAT-REC', 'url' => 'http://181.196.107.78:7474/faces/index.xhtm/', 'icono' => 'img/referencias.png', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'PRAS - MSP', 'url' => 'https://sgrdacaa.msp.gob.ec/', 'icono' => 'img/pras_msp.jpg', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'Consulta Externa', 'url' => 'http://10.12.0.12/consultaexterna/', 'icono' => 'img/agendamiento.png', 'tipo' => 'interno', 'target_blank' => true],
            ['titulo' => 'Emergencia', 'url' => 'http://10.12.0.12/emergencia/', 'icono' => 'img/emergencia.jpg', 'tipo' => 'interno', 'target_blank' => true],
            ['titulo' => 'Consulta CIE10', 'url' => 'http://10.12.0.12/busqueda_cie10', 'icono' => 'img/cie10.png', 'tipo' => 'interno', 'target_blank' => true],
            ['titulo' => 'Correo Provisional', 'url' => 'https://mail.hospitalbcayambe.online/', 'icono' => 'img/carbonio.png', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'Salas de Espera', 'url' => 'salas.php', 'icono' => 'img/salas.png', 'tipo' => 'interno', 'target_blank' => false],
            ['titulo' => 'Resultados de RX', 'url' => 'http://186.47.99.108/owncloud/', 'icono' => 'img/rx.jpeg', 'tipo' => 'externo', 'target_blank' => false],
            ['titulo' => 'Directorio Telefónico Hospital Básico Cayambe', 'url' => 'agendaTelefonica.php', 'icono' => 'img/guia-telefonica.jpg', 'tipo' => 'interno', 'target_blank' => false],
            ['titulo' => 'Fondo de Pantalla', 'url' => 'actual.jpeg', 'icono' => 'actual.jpeg', 'tipo' => 'interno', 'target_blank' => true],
            ['titulo' => 'Pedidos de Laboratorio', 'url' => 'https://dd17d10.orion-labs.com/portal/login/', 'icono' => 'img/pedido.jpeg', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'Herramientas Informáticas MSP', 'url' => 'herramientas_msp.php', 'icono' => 'img/herramientas.jpg', 'tipo' => 'interno', 'target_blank' => false],
            ['titulo' => 'Consulta de Seguros para Planillaje', 'url' => 'seguros.php', 'icono' => 'img/seguros.jpg', 'tipo' => 'interno', 'target_blank' => false],
            ['titulo' => 'ARCSA', 'url' => 'otros.php', 'icono' => 'img/arcsa.png', 'tipo' => 'interno', 'target_blank' => false],
            ['titulo' => 'Formularios en Línea', 'url' => 'matrices.php', 'icono' => 'img/matrices.jpeg', 'tipo' => 'interno', 'target_blank' => false],
            ['titulo' => 'RX HBC', 'url' => 'http://10.12.0.12/owncloud/index.php/s/2DbxZ3lZHPWwkEw', 'icono' => 'img/rx.jpeg', 'tipo' => 'interno', 'target_blank' => false],
        ],
    ],
    [
        'slug' => 'herramientas_msp',
        'titulo' => 'Herramientas Informáticas MSP',
        'es_principal' => 0,
        'orden' => 1,
        'enlaces' => [
            ['titulo' => 'MSP - RPIS', 'url' => 'https://rpis.msp.gob.ec/RPS-MSP/Home/', 'icono' => 'img/rpis.png', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'TAMEN MSP', 'url' => 'https://tamizaje.msp.gob.ec/tamen/', 'icono' => 'img/tamizaje.jpg', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'Nube Externa - Owncloud 17D10', 'url' => 'http://186.47.99.108/owncloud/', 'icono' => 'img/nube.jpg', 'tipo' => 'externo', 'target_blank' => false],
            ['titulo' => 'SIREMCA - FARMACIA', 'url' => 'http://10.12.0.11:8000/', 'icono' => 'img/farmacia.jpeg', 'tipo' => 'interno', 'target_blank' => true],
            ['titulo' => 'SIREMCA - CIE10', 'url' => 'http://10.12.0.11:8020/', 'icono' => 'img/cie10.png', 'tipo' => 'interno', 'target_blank' => true],
        ],
    ],
    [
        'slug' => 'otros',
        'titulo' => 'ARCSA',
        'es_principal' => 0,
        'orden' => 2,
        'enlaces' => [
            ['titulo' => 'ARCSA - MED', 'url' => 'https://vigiflow-eforms.who-umc.org/ec/ea', 'icono' => 'img/arcsamed.png', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'ARCSA - VAC', 'url' => 'https://vigiflow-eforms.who-umc.org/ec/vac', 'icono' => 'img/arcsavac.png', 'tipo' => 'externo', 'target_blank' => true],
        ],
    ],
    [
        'slug' => 'matrices',
        'titulo' => 'Formularios en Línea',
        'es_principal' => 0,
        'orden' => 3,
        'enlaces' => [
            ['titulo' => 'Formulario de Agendamiento Rehabilitación CST', 'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSfdV2ZDLSiFwuxNFgYLHYK84iRg95pmtNruBwlQEU7g0fIKrw/viewform', 'icono' => 'img/matrices.jpeg', 'tipo' => 'externo', 'target_blank' => true],
        ],
        'categorias' => [
            'Impresoras' => [
                ['titulo' => 'RICOH Aficio MP 301 - Farmacia (10.12.0.239)', 'url' => 'http://10.12.0.239/', 'icono' => 'img/printer.png', 'tipo' => 'interno', 'target_blank' => true],
                ['titulo' => 'RICOH IM 430 - Planillaje (10.12.0.240)', 'url' => 'http://10.12.0.240/', 'icono' => 'img/printer.png', 'tipo' => 'interno', 'target_blank' => true],
                ['titulo' => 'RICOH SP 4510SF - Secretaria (10.12.0.241)', 'url' => 'http://10.12.0.241/', 'icono' => 'img/printer.png', 'tipo' => 'interno', 'target_blank' => true],
                ['titulo' => 'RICOH MP 305+ - Hospitalización (10.12.0.242)', 'url' => 'http://10.12.0.242/', 'icono' => 'img/printer.png', 'tipo' => 'interno', 'target_blank' => true],
                ['titulo' => 'RICOH Aficio MP C2051 - Estadística (10.12.0.245)', 'url' => 'http://10.12.0.245/', 'icono' => 'img/printer.png', 'tipo' => 'interno', 'target_blank' => true],
                ['titulo' => 'RICOH MP 2554 - Consulta Externa (10.12.0.247)', 'url' => 'http://10.12.0.247/', 'icono' => 'img/printer.png', 'tipo' => 'interno', 'target_blank' => true],
                ['titulo' => 'Lexmark - Hospitalización (10.12.0.248)', 'url' => 'http://10.12.0.248/', 'icono' => 'img/printer.png', 'tipo' => 'interno', 'target_blank' => true],
            ],
        ],
    ],
    [
        'slug' => 'seguros',
        'titulo' => 'Consulta de Seguros para Planillaje',
        'es_principal' => 0,
        'orden' => 4,
        'enlaces' => [
            ['titulo' => 'Consulta de calificación de atenciones - R.P.I.S.', 'url' => 'https://coresalud.msp.gob.ec/coresalud/app.php/publico/rpis/afiliacion/consulta', 'icono' => 'img/rpis.png', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'Consulta de calificación de atenciones - IESS', 'url' => 'https://app.iess.gob.ec/gestion-calificacion-derecho-web/public/formulariosContacto.jsf', 'icono' => 'img/iess.png', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'Consulta de calificación de atenciones - ISSFA', 'url' => 'https://ias.issfa.mil.ec/consultaRPIS/Consulta.jsf', 'icono' => 'img/issfa.png', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'Consulta de calificación de atenciones - ISSPOL', 'url' => 'https://siisspolweb.isspol.org.ec/?_gl=1*13p7pch*_ga*NzQzOTYwNjE3LjE3NzY0Mzc5MDA.*_ga_LY334390X5*czE3NzY0Mzc5MDAkbzEkZzEkdDE3NzY0Mzc5NjQkajYwJGwwJGgw#/publico/consultaCobertura', 'icono' => 'img/isspol.png', 'tipo' => 'externo', 'target_blank' => true],
            ['titulo' => 'Beneficiarios de Seguros Privados - A.C.C.E.S.S.', 'url' => 'http://www.acess.gob.ec/acess-app-servicio-ciudadano/public/medicinaPrepagada/consulta.jsf', 'icono' => 'img/acess.png', 'tipo' => 'externo', 'target_blank' => true],
        ],
    ],
    [
        'slug' => 'salas',
        'titulo' => 'Salas de Espera',
        'es_principal' => 0,
        'orden' => 5,
        'enlaces' => [
            ['titulo' => 'Sala de Espera General', 'url' => 'http://10.12.0.12:8096/', 'icono' => 'img/emby.jpg', 'tipo' => 'interno', 'target_blank' => false],
            ['titulo' => 'Pacientes en Emergencia', 'url' => 'http://10.12.0.12/emergencia/indextv.php', 'icono' => 'img/manchester.jpg', 'tipo' => 'interno', 'target_blank' => false],
            ['titulo' => 'Sala de Espera Consulta Externa', 'url' => 'http://10.12.0.12/consultaexterna/turnos_sala.php', 'icono' => 'img/salas.png', 'tipo' => 'interno', 'target_blank' => false],
        ],
    ],
];

$pdo->beginTransaction();
try {
    foreach ($paginas as $datosPagina) {
        $paginaId = obtener_o_crear_pagina(
            $pdo,
            $datosPagina['slug'],
            $datosPagina['titulo'],
            $datosPagina['es_principal'],
            $datosPagina['orden']
        );

        $orden = 0;
        foreach ($datosPagina['enlaces'] as $enlace) {
            cargar_enlace($pdo, $paginaId, null, $enlace, $orden++);
        }

        foreach ($datosPagina['categorias'] ?? [] as $nombreCategoria => $enlacesCategoria) {
            $categoriaId = obtener_o_crear_categoria($pdo, $paginaId, $nombreCategoria);
            $ordenCat = 0;
            foreach ($enlacesCategoria as $enlace) {
                cargar_enlace($pdo, $paginaId, $categoriaId, $enlace, $ordenCat++);
            }
        }

        echo "Página '{$datosPagina['slug']}' procesada (id={$paginaId}).\n";
    }

    $pdo->commit();
    echo "Migración completada.\n";
} catch (Throwable $e) {
    $pdo->rollBack();
    fwrite(STDERR, 'Error en la migración: ' . $e->getMessage() . "\n");
    exit(1);
}
