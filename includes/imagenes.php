<?php

require_once __DIR__ . '/db.php';

const IMG_UPLOADS_DIR = __DIR__ . '/../img/uploads';
const IMG_UPLOADS_WEB_PATH = 'img/uploads';
const IMG_MAX_BYTES = 5 * 1024 * 1024; // 5 MB

const IMG_MIME_EXTENSIONES = [
    'image/png' => 'png',
    'image/jpeg' => 'jpg',
    'image/gif' => 'gif',
    'image/webp' => 'webp',
];

/**
 * Procesa un archivo de $_FILES y lo registra en la tabla `imagenes`.
 * Devuelve el id de la imagen nueva, o null si no se subió ningún archivo.
 * Lanza RuntimeException con un mensaje legible si el archivo no es válido.
 */
function guardar_imagen_subida(PDO $pdo, array $archivo): ?int {
    if (!isset($archivo['error']) || $archivo['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Error al subir el archivo (código ' . $archivo['error'] . ').');
    }

    if ($archivo['size'] > IMG_MAX_BYTES) {
        throw new RuntimeException('La imagen supera el tamaño máximo permitido (5 MB).');
    }

    $mime = mime_content_type($archivo['tmp_name']);
    if (!isset(IMG_MIME_EXTENSIONES[$mime])) {
        throw new RuntimeException('Formato de imagen no permitido. Use PNG, JPG, GIF o WEBP.');
    }

    if (!is_dir(IMG_UPLOADS_DIR)) {
        mkdir(IMG_UPLOADS_DIR, 0755, true);
    }

    $extension = IMG_MIME_EXTENSIONES[$mime];
    $nombreArchivo = bin2hex(random_bytes(16)) . '.' . $extension;
    $rutaDestino = IMG_UPLOADS_DIR . '/' . $nombreArchivo;

    if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        throw new RuntimeException('No se pudo guardar la imagen en el servidor.');
    }

    $stmt = $pdo->prepare(
        'INSERT INTO imagenes (nombre_original, ruta, mime, tamanio_bytes) VALUES (?, ?, ?, ?)'
    );
    $stmt->execute([
        $archivo['name'],
        IMG_UPLOADS_WEB_PATH . '/' . $nombreArchivo,
        $mime,
        $archivo['size'],
    ]);

    return (int) $pdo->lastInsertId();
}
