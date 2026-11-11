<?php require_once('includes/paginas.php') ?>
<?php include('includes/header.php') ?>
<?php $contenido = cargar_contenido_pagina(get_db(), 'otros') ?>
	<main>
		<nav class="menu">
			<?php render_menu_pagina($contenido) ?>
		</nav>
	</main>
<?php include('includes/footer.php') ?>
