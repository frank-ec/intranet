<?php require_once('includes/paginas.php') ?>
<?php include('includes/header.php') ?>
<?php $contenido = cargar_contenido_pagina(get_db(), 'seguros') ?>
	<link rel="stylesheet" href="css/estiloseguros.css">
	<main>
		<section class="panel" style="flex: 1 1 100%;">
			<h2 class="text-center">Consulta de Seguros Vigentes</h2>

			<div class="link-list">
				<?php render_lista_pagina($contenido) ?>
			</div>
		</section>
	</main>
<?php include('includes/footer.php') ?>
