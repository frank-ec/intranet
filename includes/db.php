<?php

// Carpeta fuera de la raíz web donde debe vivir la base de datos (ver docs/proteger-apache.md).
const DB_DIR_EXTERNA = '/var/www/intranet-data';

/**
 * Ruta de la base de datos. Prioridad:
 *  1. Variable de entorno INTRANET_DB_PATH
 *  2. DB_DIR_EXTERNA/intranet.sqlite, si esa carpeta existe (ubicación recomendada, no accesible por web)
 *  3. db/intranet.sqlite dentro del proyecto (ubicación antigua, solo mientras no se haya migrado)
 */
function ruta_base_datos(): string {
    $entorno = getenv('INTRANET_DB_PATH');
    if ($entorno) {
        return $entorno;
    }
    if (is_dir(DB_DIR_EXTERNA)) {
        return DB_DIR_EXTERNA . '/intranet.sqlite';
    }
    return __DIR__ . '/../db/intranet.sqlite';
}

function get_db(): PDO {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $dbPath = ruta_base_datos();
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON');

    $schema = file_get_contents(__DIR__ . '/../db/schema.sql');
    $pdo->exec($schema);

    return $pdo;
}
