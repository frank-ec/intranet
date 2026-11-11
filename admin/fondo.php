<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/admin_layout.php';

requerir_login();

const FONDO_RUTA = __DIR__ . '/../actual.jpeg';
const FONDO_MAX_BYTES = 8 * 1024 * 1024; // 8 MB

$mensaje = null;
$tipoMensaje = null;

/** Valida la imagen subida y la guarda como JPEG en actual.jpeg. Lanza RuntimeException si falla. */
function reemplazar_fondo(array $archivo): void {
    if (!isset($archivo['error']) || $archivo['error'] === UPLOAD_ERR_NO_FILE) {
        throw new RuntimeException('Seleccione una imagen.');
    }
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Error al subir el archivo (código ' . $archivo['error'] . ').');
    }
    if ($archivo['size'] > FONDO_MAX_BYTES) {
        throw new RuntimeException('La imagen supera el tamaño máximo permitido (8 MB).');
    }

    $mime = mime_content_type($archivo['tmp_name']);
    $cargadores = [
        'image/jpeg' => 'imagecreatefromjpeg',
        'image/png'  => 'imagecreatefrompng',
        'image/webp' => 'imagecreatefromwebp',
    ];
    if (!isset($cargadores[$mime])) {
        throw new RuntimeException('Formato no permitido. Use JPG, PNG o WEBP.');
    }

    // Se recodifica siempre: garantiza un JPEG válido y descarta contenido extra del archivo.
    $imagen = @$cargadores[$mime]($archivo['tmp_name']);
    if (!$imagen) {
        throw new RuntimeException('No se pudo leer la imagen; el archivo puede estar dañado.');
    }
    // Rellena con blanco por si el PNG/WEBP tiene transparencia.
    $lienzo = imagecreatetruecolor(imagesx($imagen), imagesy($imagen));
    imagefill($lienzo, 0, 0, imagecolorallocate($lienzo, 255, 255, 255));
    imagecopy($lienzo, $imagen, 0, 0, 0, 0, imagesx($imagen), imagesy($imagen));

    $temporal = tempnam(sys_get_temp_dir(), 'fondo');
    imagejpeg($lienzo, $temporal, 92);

    // copy() sobre el archivo existente conserva su propietario y permisos.
    if (!@copy($temporal, FONDO_RUTA)) {
        unlink($temporal);
        throw new RuntimeException('No se pudo escribir actual.jpeg; revise los permisos del archivo.');
    }
    unlink($temporal);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        reemplazar_fondo($_FILES['imagen'] ?? []);
        $mensaje = 'Fondo de escritorio actualizado.';
        $tipoMensaje = 'exito';
    } catch (RuntimeException $e) {
        $mensaje = $e->getMessage();
        $tipoMensaje = 'error';
    }
}

$version = is_file(FONDO_RUTA) ? filemtime(FONDO_RUTA) : 0;

admin_layout_inicio('Fondo de escritorio');
admin_mensaje_flash($tipoMensaje, $mensaje);
?>

<div class="admin-card">
    <h2>Fondo de escritorio</h2>
    <p>La imagen que se suba reemplaza a <code>actual.jpeg</code>, que es la que descargan los usuarios desde "Fondo de Pantalla". Se acepta JPG, PNG o WEBP (máx. 8 MB) y se guarda como JPEG.</p>

    <form class="admin-form" method="post" enctype="multipart/form-data">
        <label for="imagen">Nueva imagen</label>
        <input type="file" id="imagen" name="imagen" accept="image/png,image/jpeg,image/webp" required>

        <div class="admin-actions">
            <button type="submit" class="btn" onclick="return confirm('¿Reemplazar el fondo de escritorio actual?');">Reemplazar fondo</button>
        </div>
    </form>
</div>

<div class="admin-card">
    <h2>Fondo actual</h2>
    <?php if ($version): ?>
        <img src="../actual.jpeg?v=<?php echo $version ?>" alt="Fondo de escritorio actual" style="max-width:100%; height:auto;">
        <p>Última modificación: <?php echo date('d-m-Y H:i', $version) ?></p>
    <?php else: ?>
        <p>No hay fondo cargado.</p>
    <?php endif; ?>
</div>

<?php admin_layout_fin(); ?>
