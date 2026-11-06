<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/admin_layout.php';
require_once __DIR__ . '/../includes/categorias.php';
require_once __DIR__ . '/../includes/imagenes.php';

requerir_login();
$pdo = get_db();

$paginaId = (int) ($_GET['pagina_id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM paginas WHERE id = ?');
$stmt->execute([$paginaId]);
$pagina = $stmt->fetch();

if (!$pagina) {
    header('Location: index.php');
    exit;
}

$mensaje = null;
$tipoMensaje = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'guardar') {
        $id = (int) ($_POST['id'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $padreId = $_POST['padre_id'] !== '' ? (int) $_POST['padre_id'] : null;
        $orden = (int) ($_POST['orden'] ?? 0);
        $activa = isset($_POST['activa']) ? 1 : 0;

        $categoriasActuales = obtener_categorias_pagina($pdo, $paginaId);

        if ($nombre === '') {
            $mensaje = 'El nombre es requerido.';
            $tipoMensaje = 'error';
        } elseif ($padreId !== null && $id > 0 && (
            $padreId === $id || in_array($padreId, ids_descendientes($categoriasActuales, $id), true)
        )) {
            $mensaje = 'No se puede asignar como categoría padre a ella misma o a uno de sus descendientes.';
            $tipoMensaje = 'error';
        } elseif ($padreId !== null && !in_array($padreId, array_column($categoriasActuales, 'id'), false)) {
            $mensaje = 'La categoría padre seleccionada no pertenece a esta página.';
            $tipoMensaje = 'error';
        } else {
            try {
                $imagenId = guardar_imagen_subida($pdo, $_FILES['imagen'] ?? []);

                if ($id > 0) {
                    if ($imagenId !== null) {
                        $pdo->prepare('UPDATE categorias SET nombre=?, padre_id=?, orden=?, activa=?, imagen_id=? WHERE id=?')
                            ->execute([$nombre, $padreId, $orden, $activa, $imagenId, $id]);
                    } else {
                        $pdo->prepare('UPDATE categorias SET nombre=?, padre_id=?, orden=?, activa=? WHERE id=?')
                            ->execute([$nombre, $padreId, $orden, $activa, $id]);
                    }
                    $mensaje = 'Categoría actualizada.';
                } else {
                    $pdo->prepare('INSERT INTO categorias (pagina_id, padre_id, nombre, imagen_id, orden, activa) VALUES (?, ?, ?, ?, ?, ?)')
                        ->execute([$paginaId, $padreId, $nombre, $imagenId, $orden, $activa]);
                    $mensaje = 'Categoría creada.';
                }
                $tipoMensaje = 'exito';
            } catch (RuntimeException $e) {
                $mensaje = $e->getMessage();
                $tipoMensaje = 'error';
            }
        }
    } elseif ($accion === 'eliminar') {
        $id = (int) ($_POST['id'] ?? 0);
        $pdo->prepare('DELETE FROM categorias WHERE id = ? AND pagina_id = ?')->execute([$id, $paginaId]);
        $mensaje = 'Categoría eliminada.';
        $tipoMensaje = 'exito';
    }
}

$categorias = obtener_categorias_pagina($pdo, $paginaId);

$categoriaEditar = null;
if (isset($_GET['editar'])) {
    foreach ($categorias as $c) {
        if ((int) $c['id'] === (int) $_GET['editar']) {
            $categoriaEditar = $c;
            break;
        }
    }
}

$excluirDeOpciones = $categoriaEditar
    ? array_merge([(int) $categoriaEditar['id']], ids_descendientes($categorias, (int) $categoriaEditar['id']))
    : [];

$arbol = arbol_categorias($categorias);

admin_layout_inicio('Categorías - ' . $pagina['titulo']);
admin_mensaje_flash($tipoMensaje, $mensaje);
?>

<p><a href="index.php">&larr; Volver a páginas</a></p>

<div class="admin-card">
    <h2><?php echo $categoriaEditar ? 'Editar categoría' : 'Nueva categoría' ?> en "<?php echo htmlspecialchars($pagina['titulo']) ?>"</h2>
    <form class="admin-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="accion" value="guardar">
        <input type="hidden" name="id" value="<?php echo $categoriaEditar['id'] ?? 0 ?>">

        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre"
               value="<?php echo htmlspecialchars($categoriaEditar['nombre'] ?? '') ?>" required>

        <label for="padre_id">Categoría padre (opcional, para crear sub-categoría)</label>
        <select id="padre_id" name="padre_id">
            <option value="">— Ninguna (categoría raíz) —</option>
            <?php foreach ($arbol as $c): ?>
                <?php if (in_array((int) $c['id'], $excluirDeOpciones, true)) continue; ?>
                <option value="<?php echo $c['id'] ?>"
                    <?php echo (isset($categoriaEditar) && (int) ($categoriaEditar['padre_id'] ?? 0) === (int) $c['id']) ? 'selected' : '' ?>>
                    <?php echo str_repeat('— ', $c['nivel']) . htmlspecialchars($c['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="imagen">Ícono (opcional)</label>
        <input type="file" id="imagen" name="imagen" accept="image/png,image/jpeg,image/gif,image/webp">

        <label for="orden">Orden</label>
        <input type="number" id="orden" name="orden" value="<?php echo $categoriaEditar['orden'] ?? 0 ?>">

        <div class="campo-checkbox">
            <input type="checkbox" id="activa" name="activa" value="1"
                <?php echo ($categoriaEditar === null || !empty($categoriaEditar['activa'])) ? 'checked' : '' ?>>
            <label for="activa">Activa</label>
        </div>

        <div class="admin-actions">
            <button type="submit" class="btn">Guardar</button>
            <?php if ($categoriaEditar): ?>
                <a class="btn btn-secondary" href="categorias.php?pagina_id=<?php echo $paginaId ?>">Cancelar</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="admin-card">
    <h2>Categorías existentes</h2>
    <table class="data-table admin-table">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Activa</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($arbol as $c): ?>
            <tr>
                <td class="<?php echo $c['nivel'] > 0 ? 'admin-categoria-nivel' : '' ?>">
                    <?php echo str_repeat('— ', $c['nivel']) . htmlspecialchars($c['nombre']) ?>
                </td>
                <td><?php echo $c['activa'] ? 'Sí' : 'No' ?></td>
                <td>
                    <a class="btn btn-secondary" href="categorias.php?pagina_id=<?php echo $paginaId ?>&editar=<?php echo $c['id'] ?>">Editar</a>
                    <form method="post" style="display:inline" onsubmit="return confirm('¿Eliminar esta categoría? Sus sub-categorías y enlaces quedarán sin categoría o se eliminarán según las reglas de la base.');">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id" value="<?php echo $c['id'] ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php admin_layout_fin(); ?>
