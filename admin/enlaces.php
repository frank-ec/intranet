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
        $titulo = trim($_POST['titulo'] ?? '');
        $url = trim($_POST['url'] ?? '');
        $categoriaId = ($_POST['categoria_id'] ?? '') !== '' ? (int) $_POST['categoria_id'] : null;
        $tipo = ($_POST['tipo'] ?? 'externo') === 'interno' ? 'interno' : 'externo';
        $abrirNuevaPestana = isset($_POST['abrir_nueva_pestana']) ? 1 : 0;
        $orden = (int) ($_POST['orden'] ?? 0);
        $activo = isset($_POST['activo']) ? 1 : 0;

        $categoriasPagina = array_column(obtener_categorias_pagina($pdo, $paginaId), 'id');

        if ($titulo === '' || $url === '') {
            $mensaje = 'Título y URL son requeridos.';
            $tipoMensaje = 'error';
        } elseif ($categoriaId !== null && !in_array($categoriaId, $categoriasPagina, false)) {
            $mensaje = 'La categoría seleccionada no pertenece a esta página.';
            $tipoMensaje = 'error';
        } else {
            try {
                $imagenId = guardar_imagen_subida($pdo, $_FILES['imagen'] ?? []);

                if ($id > 0) {
                    if ($imagenId !== null) {
                        $pdo->prepare('UPDATE enlaces SET titulo=?, url=?, categoria_id=?, tipo=?, abrir_nueva_pestana=?, orden=?, activo=?, imagen_id=?, actualizado_en=datetime("now") WHERE id=?')
                            ->execute([$titulo, $url, $categoriaId, $tipo, $abrirNuevaPestana, $orden, $activo, $imagenId, $id]);
                    } else {
                        $pdo->prepare('UPDATE enlaces SET titulo=?, url=?, categoria_id=?, tipo=?, abrir_nueva_pestana=?, orden=?, activo=?, actualizado_en=datetime("now") WHERE id=?')
                            ->execute([$titulo, $url, $categoriaId, $tipo, $abrirNuevaPestana, $orden, $activo, $id]);
                    }
                    $mensaje = 'Enlace actualizado.';
                } else {
                    $pdo->prepare('INSERT INTO enlaces (pagina_id, categoria_id, titulo, url, imagen_id, tipo, abrir_nueva_pestana, orden, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)')
                        ->execute([$paginaId, $categoriaId, $titulo, $url, $imagenId, $tipo, $abrirNuevaPestana, $orden, $activo]);
                    $mensaje = 'Enlace creado.';
                }
                $tipoMensaje = 'exito';
            } catch (RuntimeException $e) {
                $mensaje = $e->getMessage();
                $tipoMensaje = 'error';
            }
        }
    } elseif ($accion === 'eliminar') {
        $id = (int) ($_POST['id'] ?? 0);
        $pdo->prepare('DELETE FROM enlaces WHERE id = ? AND pagina_id = ?')->execute([$id, $paginaId]);
        $mensaje = 'Enlace eliminado.';
        $tipoMensaje = 'exito';
    }
}

$categorias = obtener_categorias_pagina($pdo, $paginaId);
$arbolCategorias = arbol_categorias($categorias);

$enlaceEditar = null;
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare('SELECT * FROM enlaces WHERE id = ? AND pagina_id = ?');
    $stmt->execute([(int) $_GET['editar'], $paginaId]);
    $enlaceEditar = $stmt->fetch() ?: null;
}

$stmt = $pdo->prepare(
    'SELECT e.*, c.nombre AS categoria_nombre FROM enlaces e
     LEFT JOIN categorias c ON c.id = e.categoria_id
     WHERE e.pagina_id = ? ORDER BY e.orden, e.titulo'
);
$stmt->execute([$paginaId]);
$enlaces = $stmt->fetchAll();

admin_layout_inicio('Enlaces - ' . $pagina['titulo']);
admin_mensaje_flash($tipoMensaje, $mensaje);
?>

<p><a href="index.php">&larr; Volver a páginas</a></p>

<div class="admin-card">
    <h2><?php echo $enlaceEditar ? 'Editar enlace' : 'Nuevo enlace' ?> en "<?php echo htmlspecialchars($pagina['titulo']) ?>"</h2>
    <form class="admin-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="accion" value="guardar">
        <input type="hidden" name="id" value="<?php echo $enlaceEditar['id'] ?? 0 ?>">

        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo"
               value="<?php echo htmlspecialchars($enlaceEditar['titulo'] ?? '') ?>" required>

        <label for="url">URL</label>
        <input type="text" id="url" name="url" placeholder="https://... o una ruta interna como salas.php"
               value="<?php echo htmlspecialchars($enlaceEditar['url'] ?? '') ?>" required>

        <label for="tipo">Tipo</label>
        <select id="tipo" name="tipo">
            <option value="externo" <?php echo ($enlaceEditar['tipo'] ?? 'externo') === 'externo' ? 'selected' : '' ?>>Externo (otro sitio)</option>
            <option value="interno" <?php echo ($enlaceEditar['tipo'] ?? '') === 'interno' ? 'selected' : '' ?>>Interno (dentro de la intranet)</option>
        </select>

        <label for="categoria_id">Categoría (opcional)</label>
        <select id="categoria_id" name="categoria_id">
            <option value="">— Sin categoría —</option>
            <?php foreach ($arbolCategorias as $c): ?>
                <option value="<?php echo $c['id'] ?>"
                    <?php echo (isset($enlaceEditar) && (int) ($enlaceEditar['categoria_id'] ?? 0) === (int) $c['id']) ? 'selected' : '' ?>>
                    <?php echo str_repeat('— ', $c['nivel']) . htmlspecialchars($c['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="imagen">Ícono (opcional)</label>
        <input type="file" id="imagen" name="imagen" accept="image/png,image/jpeg,image/gif,image/webp">

        <label for="orden">Orden</label>
        <input type="number" id="orden" name="orden" value="<?php echo $enlaceEditar['orden'] ?? 0 ?>">

        <div class="campo-checkbox">
            <input type="checkbox" id="abrir_nueva_pestana" name="abrir_nueva_pestana" value="1"
                <?php echo ($enlaceEditar === null || !empty($enlaceEditar['abrir_nueva_pestana'])) ? 'checked' : '' ?>>
            <label for="abrir_nueva_pestana">Abrir en pestaña nueva</label>
        </div>

        <div class="campo-checkbox">
            <input type="checkbox" id="activo" name="activo" value="1"
                <?php echo ($enlaceEditar === null || !empty($enlaceEditar['activo'])) ? 'checked' : '' ?>>
            <label for="activo">Activo</label>
        </div>

        <div class="admin-actions">
            <button type="submit" class="btn">Guardar</button>
            <?php if ($enlaceEditar): ?>
                <a class="btn btn-secondary" href="enlaces.php?pagina_id=<?php echo $paginaId ?>">Cancelar</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="admin-card">
    <h2>Enlaces existentes</h2>
    <table class="data-table admin-table">
        <thead>
        <tr>
            <th>Título</th>
            <th>URL</th>
            <th>Categoría</th>
            <th>Activo</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($enlaces as $e): ?>
            <tr>
                <td><?php echo htmlspecialchars($e['titulo']) ?></td>
                <td><?php echo htmlspecialchars($e['url']) ?></td>
                <td><?php echo htmlspecialchars($e['categoria_nombre'] ?? '') ?></td>
                <td><?php echo $e['activo'] ? 'Sí' : 'No' ?></td>
                <td>
                    <a class="btn btn-secondary" href="enlaces.php?pagina_id=<?php echo $paginaId ?>&editar=<?php echo $e['id'] ?>">Editar</a>
                    <form method="post" style="display:inline" onsubmit="return confirm('¿Eliminar este enlace?');">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id" value="<?php echo $e['id'] ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php admin_layout_fin(); ?>
