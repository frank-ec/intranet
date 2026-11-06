<?php
require_once __DIR__ . '/unidad.php';
$uo = obtener_unidad_actual(get_db());
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Intranet - <?php echo $uo; ?></title>
	<link rel="stylesheet" href="css/estilos.css">
</head>
<body>
	<div id="contenedor">
		<header>
			<a class="logo" href="index.php"><img src="img/logoMSP.gif" alt="Logo MSP"></a>
			<h1><?php echo $uo; ?></h1>
			<p class="fecha">Fecha actual: <?php echo date('d-m-Y'); ?></p>
		</header>
