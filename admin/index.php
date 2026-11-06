<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/admin_layout.php';

requerir_login();
$pdo = get_db();

$mensaje = null;
$tipoMensaje = null;

function slug_valido(string $slug): bool {
    return (bool) preg_match('/^[a-z0-9]+(-[a-z0-9]+)*$/', $slug);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'guardar') {
        $id = (int) ($_POST['id'] ?? 0);
        $slug = trim($_POST['slug'] ?? '');
        $titulo = trim($_POST['titulo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $esPrincipal = isset($_POST['es_principal']) ? 1 : 0;
        $orden = (int) ($_POST['orden'] ?? 0);
        $activa = isset($_POST['activa']) ? 1 : 0;

        if ($titulo === '' || !slug_valido($slug)) {
            $mensaje = 'Título requerido y slug solo puede tener letras minúsculas, números y guiones.';
            $tipoMensaje = 'error';
        } else {
            try {
                if ($id > 0) {
                    $stmt = $pdo->prepare(
                        'UPDATE paginas SET slug=?, titulo=?, descripcion=?, es_principal=?, orden=?, activa=?, actualizado_en=datetime("now") WHERE id=?'
                    );
                    $stmt->execute([$slug, $titulo, $descripcion, $esPrincipal, $orden, $activa, $id]);
                    $mensaje = 'Página actualizada.';
                } else {
                    $stmt = $pdo->prepare(
                        'INSERT INTO paginas (slug, titulo, descripcion, es_principal, orden, activa) VALUES (?, ?, ?, ?, ?, ?)'
                    );
                    $stmt->execute([$slug, $titulo, $descripcion, $esPrincipal, $orden, $activa]);
                    $mensaje = 'Página creada.';
                }
                $tipoMensaje = 'exito';
            } catch (PDOException $e) {
                $mensaje = str_contains($e->getMessage(), 'UNIQUE')
                    ? 'Ya existe una página con ese slug.'
                    : 'Error al guardar: ' . $e->getMessage();
                $tipoMensaje = 'error';
            }
        }
    } elseif ($accion === 'eliminar') {
        $id = (int) ($_POST['id'] ?? 0);
        $pdo->prepare('DELETE FROM paginas WHERE id = ?')->execute([$id]);
        $mensaje = 'Página eliminada.';
        $tipoMensaje = 'exito';
    }
}

$paginaEditar = null;
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare('SELECT * FROM paginas WHERE id = ?');
    $stmt->execute([(int) $_GET['editar']]);
    $paginaEditar = $stmt->fetch() ?: null;
}

$paginas = $pdo->query('SELECT * FROM paginas ORDER BY orden, titulo')->fetchAll();

admin_layout_inicio('Páginas');
admin_mensaje_flash($tipoMensaje, $mensaje);
?>

<div class="admin-card">
    <h2><?php echo $paginaEditar ? 'Editar página' : 'Nueva página' ?></h2>
    <form class="admin-form" method="post">
        <input type="hidden" name="accion" value="guardar">
        <input type="hidden" name="id" value="<?php echo $paginaEditar['id'] ?? 0 ?>">

        <label for="slug">Slug (identificador en la URL)</label>
        <input type="text" id="slug" name="slug" placeholder="ej. farmacia-insumos"
               value="<?php echo htmlspecialchars($paginaEditar['slug'] ?? '') ?>" required>

        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo"
               value="<?php echo htmlspecialchars($paginaEditar['titulo'] ?? '') ?>" required>

        <label for="descripcion">Descripción (opcional)</label>
        <textarea id="descripcion" name="descripcion" rows="2"><?php echo htmlspecialchars($paginaEditar['descripcion'] ?? '') ?></textarea>

        <label for="orden">Orden</label>
        <input type="number" id="orden" name="orden" value="<?php echo $paginaEditar['orden'] ?? 0 ?>">

        <div class="campo-checkbox">
            <input type="checkbox" id="es_principal" name="es_principal" value="1"
                <?php echo !empty($paginaEditar['es_principal']) ? 'checked' : '' ?>>
            <label for="es_principal">Es el menú principal (index)</label>
        </div>

        <div class="campo-checkbox">
            <input type="checkbox" id="activa" name="activa" value="1"
                <?php echo ($paginaEditar === null || !empty($paginaEditar['activa'])) ? 'checked' : '' ?>>
            <label for="activa">Activa</label>
        </div>

        <div class="admin-actions">
            <button type="submit" class="btn">Guardar</button>
            <?php if ($paginaEditar): ?>
                <a class="btn btn-secondary" href="index.php">Cancelar</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="admin-card">
    <h2>Páginas existentes</h2>
    <table class="data-table admin-table">
        <thead>
        <tr>
            <th>Título</th>
            <th>Slug</th>
            <th>Principal</th>
            <th>Activa</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($paginas as $p): ?>
            <tr>
                <td><?php echo htmlspecialchars($p['titulo']) ?></td>
                <td><?php echo htmlspecialchars($p['slug']) ?></td>
                <td><?php echo $p['es_principal'] ? 'Sí' : '' ?></td>
                <td><?php echo $p['activa'] ? 'Sí' : 'No' ?></td>
                <td>
                    <a class="btn" href="categorias.php?pagina_id=<?php echo $p['id'] ?>">Categorías</a>
                    <a class="btn" href="enlaces.php?pagina_id=<?php echo $p['id'] ?>">Enlaces</a>
                    <a class="btn btn-secondary" href="index.php?editar=<?php echo $p['id'] ?>">Editar</a>
                    <form method="post" style="display:inline" onsubmit="return confirm('¿Eliminar esta página y todos sus enlaces/categorías?');">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id" value="<?php echo $p['id'] ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                    <?php if (!$p['es_principal']): ?>
                        <a class="btn btn-secondary" href="../pagina.php?slug=<?php echo htmlspecialchars($p['slug']) ?>" target="_blank">Ver</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php admin_layout_fin(); ?>
