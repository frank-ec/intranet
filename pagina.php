<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/paginas.php';

$pdo = get_db();
$contenido = cargar_contenido_pagina($pdo, $_GET['slug'] ?? '');

if (!$contenido) {
    http_response_code(404);
    include('includes/header.php');
    echo '<main><div class="admin-card"><p>Página no encontrada.</p></div></main>';
    include('includes/footer.php');
    exit;
}

$pagina = $contenido['pagina'];
$sinEnlaces = !$contenido['enlaces_sueltos'] && !$contenido['arbol_categorias'];
?>
<?php include('includes/header.php') ?>
	<main>
		<nav class="menu">
			<h2 class="text-center"><?php echo htmlspecialchars($pagina['titulo']) ?></h2>
			<?php if ($pagina['descripcion']): ?>
				<p class="text-center"><?php echo htmlspecialchars($pagina['descripcion']) ?></p>
			<?php endif; ?>

			<?php if ($sinEnlaces): ?>
				<p class="text-center">Esta página todavía no tiene enlaces.</p>
			<?php else: ?>
				<?php render_menu_pagina($contenido) ?>
			<?php endif; ?>
		</nav>

		<div class="intro-banner">
			<a href="index.php"><img height="60" src="img/logoMSP.gif" alt="Volver al inicio"></a>
		</div>
	</main>
<?php include('includes/footer.php') ?>
