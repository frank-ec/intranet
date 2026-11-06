<?php require_once('includes/paginas.php') ?>
<?php include('includes/header.php') ?>
<?php $contenido = cargar_contenido_pagina(get_db(), 'otros') ?>
	<main>
		<nav class="menu">
			<?php render_menu_pagina($contenido) ?>
		</nav>

		<div class="intro-banner">
			<a href="index.php"><img height="100" width="600" src="./img/herramientas_informaticas2.jpg" alt="Volver al inicio"></a>
		</div>
	</main>
<?php include('includes/footer.php') ?>
