<?php

require_once __DIR__ . '/db.php';

const RESPALDO_MAX_BYTES = 100 * 1024 * 1024; // 100 MB
const RESPALDO_TABLAS_REQUERIDAS = [
    'unidad_operativa', 'usuarios', 'paginas', 'imagenes', 'categorias', 'enlaces', 'notas_importantes',
];

/** Carpeta donde se guardan las copias de seguridad automáticas (junto a la base de datos). */
function carpeta_respaldos(): string {
    $dir = dirname(ruta_base_datos()) . '/respaldos';
    if (!is_dir($dir) && !@mkdir($dir, 0775, true)) {
        throw new RuntimeException('No se pudo crear la carpeta de respaldos: ' . $dir);
    }
    return $dir;
}

/**
 * Genera una copia consistente de la base de datos en $destino (VACUUM INTO, seguro con la BD en uso).
 */
function crear_respaldo(PDO $pdo, string $destino): void {
    if (file_exists($destino)) {
        unlink($destino);
    }
    $pdo->exec('VACUUM INTO ' . $pdo->quote($destino));
}

function nombre_respaldo(string $prefijo = 'intranet'): string {
    return $prefijo . '_' . date('Ymd_His') . '.sqlite';
}

/**
 * Comprueba que $ruta es una base SQLite íntegra con las tablas de la intranet.
 * Lanza RuntimeException si no lo es.
 */
function validar_respaldo(string $ruta): void {
    $f = @fopen($ruta, 'rb');
    $cabecera = $f ? fread($f, 16) : '';
    if ($f) {
        fclose($f);
    }
    if ($cabecera !== "SQLite format 3\0") {
        throw new RuntimeException('El archivo no es una base de datos SQLite válida.');
    }

    try {
        $pdo = new PDO('sqlite:' . $ruta);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $integridad = $pdo->query('PRAGMA integrity_check')->fetchColumn();
        if ($integridad !== 'ok') {
            throw new RuntimeException('El respaldo está dañado (integrity_check: ' . $integridad . ').');
        }
        $tablas = $pdo->query("SELECT name FROM sqlite_master WHERE type = 'table'")->fetchAll(PDO::FETCH_COLUMN);
        $faltan = array_diff(RESPALDO_TABLAS_REQUERIDAS, $tablas);
        if ($faltan) {
            throw new RuntimeException('El archivo no parece un respaldo de la intranet; faltan tablas: ' . implode(', ', $faltan) . '.');
        }
    } catch (PDOException $e) {
        throw new RuntimeException('No se pudo leer el archivo como base de datos: ' . $e->getMessage());
    } finally {
        $pdo = null;
    }
}

/**
 * Restaura la base de datos desde $origen. Antes guarda una copia de seguridad de la BD actual
 * y devuelve su nombre. Lanza RuntimeException si algo falla.
 */
function restaurar_respaldo(PDO $pdo, string $origen): string {
    validar_respaldo($origen);

    $nombreSeguridad = nombre_respaldo('antes-de-restaurar');
    crear_respaldo($pdo, carpeta_respaldos() . '/' . $nombreSeguridad);

    // Se vuelca el respaldo dentro del archivo actual (mismo inodo): conserva propietario y permisos.
    $origenPdo = new PDO('sqlite:' . $origen);
    $origenPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $tmp = tempnam(sys_get_temp_dir(), 'rest');
    try {
        $origenPdo->exec('VACUUM INTO ' . $origenPdo->quote($tmp . '.db'));
        $origenPdo = null;
        if (!@copy($tmp . '.db', ruta_base_datos())) {
            throw new RuntimeException('No se pudo escribir la base de datos; revise los permisos. La copia previa está en respaldos/' . $nombreSeguridad);
        }
    } finally {
        @unlink($tmp);
        @unlink($tmp . '.db');
    }
    foreach (['-journal', '-wal', '-shm'] as $sufijo) {
        @unlink(ruta_base_datos() . $sufijo);
    }

    return $nombreSeguridad;
}

/** Lista los respaldos automáticos guardados, del más reciente al más antiguo. */
function listar_respaldos_guardados(): array {
    $archivos = glob(carpeta_respaldos() . '/*.sqlite') ?: [];
    rsort($archivos);
    return array_map(fn($a) => ['nombre' => basename($a), 'tamano' => filesize($a), 'fecha' => filemtime($a)], $archivos);
}

function nombre_respaldo_valido(string $n): bool {
    return (bool) preg_match('/^[A-Za-z0-9_-]+\.sqlite$/', $n);
}

function token_csrf(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function verificar_csrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(400);
        exit('Solicitud no válida (token CSRF).');
    }
}
