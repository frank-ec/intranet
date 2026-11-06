<?php require_once('includes/paginas.php') ?>
<?php require_once('includes/notas.php') ?>
<?php include('includes/header.php') ?>
<?php
	$pdo = get_db();
	$contenido = cargar_contenido_pagina($pdo, 'index');
	$notas = obtener_notas_importantes_activas($pdo);
	$enlaceAdmin = '<li><a class="menu-item" href="admin/index.php">
			<img class="menu-item__icon" src="./img/lapiz.jpeg" alt="Administración"><span class="menu-item__label">Administración</span></a></li>';
?>
	<main>
		<nav class="menu">
			<?php render_menu_pagina($contenido, $enlaceAdmin) ?>
		</nav>

		<aside class="panel">
			<h4>Notas importantes</h4>

			<div class="notas-carousel" id="notas-carousel">
				<?php if ($notas): ?>
					<?php foreach ($notas as $indice => $nota): ?>
						<div class="alert nota-item<?php echo $indice === 0 ? ' activa' : '' ?>">
							<strong><?php echo htmlspecialchars($nota['titulo']) ?></strong>
							<p><?php echo nl2br(htmlspecialchars($nota['contenido'])) ?></p>
							<?php if (!empty($nota['enlace_url'])): ?>
								<p><a href="<?php echo htmlspecialchars($nota['enlace_url']) ?>" target="_blank"><?php echo htmlspecialchars($nota['enlace_texto']) ?></a></p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				<?php else: ?>
					<p>No hay notas importantes por el momento.</p>
				<?php endif; ?>
			</div>
		</aside>
	</main>
	<script src="js/notas-carousel.js" defer></script>
<?php include('includes/footer.php') ?>
