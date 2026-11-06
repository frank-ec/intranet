<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/admin_layout.php';
require_once __DIR__ . '/../includes/notas.php';

requerir_login();
$pdo = get_db();

$mensaje = null;
$tipoMensaje = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'guardar') {
        $id = (int) ($_POST['id'] ?? 0);
        $titulo = trim($_POST['titulo'] ?? '');
        $contenido = trim($_POST['contenido'] ?? '');
        $enlaceUrl = trim($_POST['enlace_url'] ?? '');
        $enlaceTexto = trim($_POST['enlace_texto'] ?? '');
        $orden = (int) ($_POST['orden'] ?? 0);
        $activa = isset($_POST['activa']) ? 1 : 0;

        if ($titulo === '' || $contenido === '') {
            $mensaje = 'Título y contenido son requeridos.';
            $tipoMensaje = 'error';
        } elseif ($enlaceUrl !== '' && $enlaceTexto === '') {
            $mensaje = 'Si agrega un enlace, indique el texto que se mostrará.';
            $tipoMensaje = 'error';
        } else {
            $enlaceUrl = $enlaceUrl !== '' ? $enlaceUrl : null;
            $enlaceTexto = $enlaceTexto !== '' ? $enlaceTexto : null;

            if ($id > 0) {
                $pdo->prepare('UPDATE notas_importantes SET titulo=?, contenido=?, enlace_url=?, enlace_texto=?, orden=?, activa=?, actualizado_en=datetime("now") WHERE id=?')
                    ->execute([$titulo, $contenido, $enlaceUrl, $enlaceTexto, $orden, $activa, $id]);
                $mensaje = 'Nota actualizada.';
            } else {
                $pdo->prepare('INSERT INTO notas_importantes (titulo, contenido, enlace_url, enlace_texto, orden, activa) VALUES (?, ?, ?, ?, ?, ?)')
                    ->execute([$titulo, $contenido, $enlaceUrl, $enlaceTexto, $orden, $activa]);
                $mensaje = 'Nota creada.';
            }
            $tipoMensaje = 'exito';
        }
    } elseif ($accion === 'eliminar') {
        $id = (int) ($_POST['id'] ?? 0);
        $pdo->prepare('DELETE FROM notas_importantes WHERE id = ?')->execute([$id]);
        $mensaje = 'Nota eliminada.';
        $tipoMensaje = 'exito';
    }
}

$notaEditar = null;
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare('SELECT * FROM notas_importantes WHERE id = ?');
    $stmt->execute([(int) $_GET['editar']]);
    $notaEditar = $stmt->fetch() ?: null;
}

$notas = obtener_notas_importantes($pdo);

admin_layout_inicio('Notas importantes');
admin_mensaje_flash($tipoMensaje, $mensaje);
?>

<div class="admin-card">
    <h2><?php echo $notaEditar ? 'Editar nota' : 'Nueva nota' ?></h2>
    <form class="admin-form" method="post">
        <input type="hidden" name="accion" value="guardar">
        <input type="hidden" name="id" value="<?php echo $notaEditar['id'] ?? 0 ?>">

        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo"
               value="<?php echo htmlspecialchars($notaEditar['titulo'] ?? '') ?>" required>

        <label for="contenido">Contenido</label>
        <textarea id="contenido" name="contenido" rows="4" required><?php echo htmlspecialchars($notaEditar['contenido'] ?? '') ?></textarea>

        <label for="enlace_url">Enlace al curso (opcional)</label>
        <input type="text" id="enlace_url" name="enlace_url" placeholder="https://capacitacion2.msp.gob.ec/..."
               value="<?php echo htmlspecialchars($notaEditar['enlace_url'] ?? '') ?>">

        <label for="enlace_texto">Texto del enlace</label>
        <input type="text" id="enlace_texto" name="enlace_texto" placeholder="Ej. Cursos"
               value="<?php echo htmlspecialchars($notaEditar['enlace_texto'] ?? '') ?>">

        <label for="orden">Orden</label>
        <input type="number" id="orden" name="orden" value="<?php echo $notaEditar['orden'] ?? 0 ?>">

        <div class="campo-checkbox">
            <input type="checkbox" id="activa" name="activa" value="1"
                <?php echo ($notaEditar === null || !empty($notaEditar['activa'])) ? 'checked' : '' ?>>
            <label for="activa">Activa</label>
        </div>

        <div class="admin-actions">
            <button type="submit" class="btn">Guardar</button>
            <?php if ($notaEditar): ?>
                <a class="btn btn-secondary" href="notas.php">Cancelar</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="admin-card">
    <h2>Notas existentes</h2>
    <p>Las notas activas se muestran en la página principal y van rotando automáticamente.</p>
    <table class="data-table admin-table">
        <thead>
        <tr>
            <th>Título</th>
            <th>Enlace</th>
            <th>Orden</th>
            <th>Activa</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($notas as $n): ?>
            <tr>
                <td><?php echo htmlspecialchars($n['titulo']) ?></td>
                <td><?php echo $n['enlace_texto'] ? htmlspecialchars($n['enlace_texto']) : '—' ?></td>
                <td><?php echo (int) $n['orden'] ?></td>
                <td><?php echo $n['activa'] ? 'Sí' : 'No' ?></td>
                <td>
                    <a class="btn btn-secondary" href="notas.php?editar=<?php echo $n['id'] ?>">Editar</a>
                    <form method="post" style="display:inline" onsubmit="return confirm('¿Eliminar esta nota?');">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id" value="<?php echo $n['id'] ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php admin_layout_fin(); ?>
