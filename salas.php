<?php require_once('includes/paginas.php') ?>
<?php include('includes/header.php') ?>
<?php $contenido = cargar_contenido_pagina(get_db(), 'salas') ?>
	<link rel="stylesheet" href="css/estiloseguros.css">
	<main>
		<nav class="menu">
			<h2 class="text-center">Salas de Espera</h2>
			<?php render_menu_pagina($contenido) ?>
		</nav>


	</main>
<?php include('includes/footer.php') ?>
