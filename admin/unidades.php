<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/admin_layout.php';
require_once __DIR__ . '/../includes/unidad.php';

requerir_login();
$pdo = get_db();

$mensaje = null;
$tipoMensaje = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    if ($nombre === '') {
        $mensaje = 'El nombre es requerido.';
        $tipoMensaje = 'error';
    } else {
        actualizar_unidad($pdo, $nombre);
        $mensaje = 'Nombre de la unidad operativa actualizado.';
        $tipoMensaje = 'exito';
    }
}

$nombreActual = obtener_unidad_actual($pdo);

admin_layout_inicio('Unidad Operativa');
admin_mensaje_flash($tipoMensaje, $mensaje);
?>

<div class="admin-card">
    <h2>Unidad Operativa</h2>
    <p>Este sitio sirve a una sola unidad operativa. Su nombre se muestra en el encabezado de toda la intranet.</p>
    <form class="admin-form" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombreActual) ?>" required>

        <div class="admin-actions">
            <button type="submit" class="btn">Guardar</button>
        </div>
    </form>
</div>

<?php admin_layout_fin(); ?>
