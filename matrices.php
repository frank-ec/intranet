<?php require_once('includes/paginas.php') ?>
<?php include('includes/header.php') ?>
<?php $contenido = cargar_contenido_pagina(get_db(), 'matrices') ?>
	<link rel="stylesheet" href="css/estiloseguros.css">
	<main>
		<section class="panel" style="flex: 1 1 100%;">
			<h2 class="text-center">Google Docs Online: Hojas de Cálculo, Formularios</h2>

			<div class="link-list">
				<?php render_lista_pagina($contenido) ?>
			</div>
		</section>
	</main>
<?php include('includes/footer.php') ?>
