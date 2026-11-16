<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/admin_layout.php';
require_once __DIR__ . '/../includes/respaldo.php';

requerir_login();
$pdo = get_db();

$mensaje = null;
$tipoMensaje = null;

function enviar_descarga(string $ruta, string $nombre): void {
    header('Content-Type: application/vnd.sqlite3');
    header('Content-Disposition: attachment; filename="' . $nombre . '"');
    header('Content-Length: ' . filesize($ruta));
    header('Cache-Control: no-store');
    readfile($ruta);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verificar_csrf();
    $accion = $_POST['accion'] ?? '';

    try {
        if ($accion === 'descargar') {
            $tmp = tempnam(sys_get_temp_dir(), 'resp') ;
            try {
                crear_respaldo($pdo, $tmp);
                enviar_descarga($tmp, nombre_respaldo());
            } finally {
                @unlink($tmp);
            }
            exit;
        } elseif ($accion === 'guardar') {
            $nombre = nombre_respaldo();
            crear_respaldo($pdo, carpeta_respaldos() . '/' . $nombre);
            $mensaje = 'Respaldo guardado en el servidor: ' . $nombre;
            $tipoMensaje = 'exito';
        } elseif ($accion === 'descargar_guardado') {
            $nombre = $_POST['nombre'] ?? '';
            $ruta = carpeta_respaldos() . '/' . $nombre;
            if (!nombre_respaldo_valido($nombre) || !is_file($ruta)) {
                throw new RuntimeException('Respaldo no encontrado.');
            }
            enviar_descarga($ruta, $nombre);
            exit;
        } elseif ($accion === 'eliminar_guardado') {
            $nombre = $_POST['nombre'] ?? '';
            $ruta = carpeta_respaldos() . '/' . $nombre;
            if (!nombre_respaldo_valido($nombre) || !is_file($ruta)) {
                throw new RuntimeException('Respaldo no encontrado.');
            }
            unlink($ruta);
            $mensaje = 'Respaldo eliminado.';
            $tipoMensaje = 'exito';
        } elseif ($accion === 'restaurar' || $accion === 'restaurar_guardado') {
            if ($accion === 'restaurar') {
                $archivo = $_FILES['respaldo'] ?? [];
                if (($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                    throw new RuntimeException('Seleccione un archivo de respaldo válido (error de subida ' . ($archivo['error'] ?? '?') . ').');
                }
                if ($archivo['size'] > RESPALDO_MAX_BYTES) {
                    throw new RuntimeException('El archivo supera el tamaño máximo permitido (100 MB).');
                }
                $origen = $archivo['tmp_name'];
            } else {
                $nombre = $_POST['nombre'] ?? '';
                $origen = carpeta_respaldos() . '/' . $nombre;
                if (!nombre_respaldo_valido($nombre) || !is_file($origen)) {
                    throw new RuntimeException('Respaldo no encontrado.');
                }
            }
            $seguridad = restaurar_respaldo($pdo, $origen);
            // La tabla de usuarios pudo cambiar: se obliga a iniciar sesión de nuevo.
            cerrar_sesion();
            header('Location: login.php');
            exit;
        }
    } catch (RuntimeException | PDOException $e) {
        $mensaje = $e->getMessage();
        $tipoMensaje = 'error';
    }
}

$guardados = listar_respaldos_guardados();
$csrf = token_csrf();

admin_layout_inicio('Respaldo y restauración');
admin_mensaje_flash($tipoMensaje, $mensaje);
?>

<div class="admin-card">
    <h2>Crear respaldo</h2>
    <p>Genera una copia completa de la base de datos (páginas, categorías, enlaces, notas, unidad operativa y usuarios). <strong>No incluye los archivos</strong> de <code>img/uploads/</code> ni <code>actual.jpeg</code>; respáldelos aparte.</p>
    <form method="post" class="admin-actions">
        <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
        <button type="submit" class="btn" name="accion" value="descargar">Descargar respaldo</button>
        <button type="submit" class="btn" name="accion" value="guardar">Guardar en el servidor</button>
    </form>
</div>

<div class="admin-card">
    <h2>Restaurar desde un archivo</h2>
    <p><strong>Reemplaza toda la base de datos actual.</strong> Antes de restaurar se guarda automáticamente una copia de la base actual en el servidor, y al terminar tendrá que iniciar sesión de nuevo.</p>
    <form class="admin-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
        <input type="hidden" name="accion" value="restaurar">
        <label for="respaldo">Archivo de respaldo (.sqlite)</label>
        <input type="file" id="respaldo" name="respaldo" accept=".sqlite,.db" required>
        <div class="admin-actions">
            <button type="submit" class="btn" onclick="return confirm('Esto reemplazará TODOS los datos actuales por los del respaldo. ¿Continuar?');">Restaurar</button>
        </div>
    </form>
</div>

<div class="admin-card">
    <h2>Respaldos guardados en el servidor</h2>
    <?php if (!$guardados): ?>
        <p>No hay respaldos guardados.</p>
    <?php else: ?>
        <table class="data-table admin-table">
            <thead><tr><th>Archivo</th><th>Fecha</th><th>Tamaño</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php foreach ($guardados as $g): ?>
                <tr>
                    <td><?php echo htmlspecialchars($g['nombre']) ?></td>
                    <td><?php echo date('d-m-Y H:i', $g['fecha']) ?></td>
                    <td><?php echo number_format($g['tamano'] / 1024, 1) ?> KB</td>
                    <td>
                        <form method="post" style="display:inline">
                            <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                            <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($g['nombre']) ?>">
                            <button type="submit" class="btn" name="accion" value="descargar_guardado">Descargar</button>
                            <button type="submit" class="btn" name="accion" value="restaurar_guardado" onclick="return confirm('Esto reemplazará TODOS los datos actuales por este respaldo. ¿Continuar?');">Restaurar</button>
                            <button type="submit" class="btn" name="accion" value="eliminar_guardado" onclick="return confirm('¿Eliminar este respaldo?');">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php admin_layout_fin(); ?>
