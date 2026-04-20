<?php 

// Url al servidores externos
$server17d10 ='<a href="http://186.47.99.108'; // DD17D10  servidor publico
$serverorion ='<a href="https://dd17d10.orion-labs.com'; // ORION servidor publico
		
	$uo = "Hospital Básico Cayambe";
	$localserver ='<a href="http://10.12.0.12'; // HBC servidor local
	
	// Tarjetero indice  HBC 
	$tarjetero = $localserver.'/consultaexterna/" target="_blank"><img align="center"
			 border="3" height="50" width="80" src="./img/agendamiento.png"><span>Consulta Externa</span></a>';

	/// Triaje de Emergencia
	$triaje = $localserver.'/emergencia/" target="_blank"><img align="center"
			 border="3" height="50" width="80" src="./img/emergencia.jpg"><span>Emergencia</span></a>';


	$triajeTV = $localserver.'/emergencia/indextv.php"><img align="center"
			 border="3" height="50" width="80" src="./img/manchester.jpg"><span>Pacientes en Emergencia</span></a>';		 

	$rxResultados = $server17d10.'/owncloud/"><img align="center"
			 border="3" height="50" width="80" src="./img/rx.jpeg"><span>Resultados de RX</span></a>';
	
	$stockFarmacia = '';
	
	$biblioteca = '';
	
	$cie10 = $localserver.'/busqueda_cie10" target="_blank"><img align="center"
	border="3" height="50" width="80" src="./img/cie10.png"><span>Consulta CIE10</span></a>';
		

	$fondo = $server17d10.'/public/actual.jpeg" target="_blank"><img align="center" border="3" height="50" width="80"
			 src="http://186.47.99.108/public/actual.jpeg"><span>Fondo de Pantalla</span></a>';
	
	$labPedidos = $serverorion.'/" target="_blank"><img align="center"
			 border="3" height="50" width="80" src="./img/pedido.jpeg"><span>Pedidos de Laboratorio</span></a>';  
	  
	
    $dirTelefonico = '<a href="agendaTelefonica.php" ><img align="center" border="3" height="50" width="80" src="./img/guia-telefonica.jpg">
	<span>Directorio Telefónico '.$uo.'</span></a>';
	
	$zimbra = '<a href="https://mail.hbc.gob.ec:8443/" target="_blank"><img align="center" border="3" height="50" width="80" src="img/zimbra.jpg">
	<span>Correo Institucional - Zimbra </span></a>';

	$nubeInterna = '';

	$infochanel = $localserver.':8096/"><img align="center"
	border="3" height="50" width="80" src="./img/emby.jpg"><span>Sala de Espera General </span></a>';

	$consultaExterna = $localserver.'/consultaexterna/"><img align="center"
	border="3" height="50" width="80" src="./img/llamar.jpeg"><span>Consulta Externa</span></a>';

	$sala1 = $localserver.'/consultaexterna/turnos_sala.php"><img align="center"
	border="3" height="50" width="80" src="./img/salas.png"><span>Sala de Espera Consulta Externa </span></a>';

	$siremcaFarmacia = '<a href="http://10.12.0.11:8000/" target="_blank"><img align="center" border="3" height="50" width="80" src="img/farmacia.jpeg">
	<span>SIREMCA- FARMACIA</span></a>';

	$siremcaCie10 = '<a href="http://10.12.0.11:8020/" target="_blank"><img align="center" border="3" height="50" width="80" src="img/cie10.png">
	<span>SIREMCA- CIE10</span></a>';
	

   // Enlaces para la pagina de herramientas MSP

	$pras = '<a href="https://sgrdacaa.msp.gob.ec/" target="_blank"><img align="center" border="3" height="50" width="80" src="img/pras_msp.jpg"><span>PRAS - MSP</span></a>';  

	$tamizaje = '<a href="https://tamizaje.msp.gob.ec/tamen/" target="_blank"><img align="center" border="3" height="50" width="80" src="img/tamizaje.jpg"><span>TAMEN MSP</span></a>';

	$satRec = '<a href="http://181.196.107.78:7474/faces/index.xhtm/" target="_blank"><img align="center" border="3" height="50" width="80" src="img/referencias.png">
	<span>SAT-REC</span></a>';

	$nubeExterna = '<a href="http://186.47.99.108/owncloud/" ><img align="center" border="3" height="50" width="80" src="img/nube.jpg"><span>Nube Externa - Owncloud 17D10</span></a>';

	// Enlaces a matrices en linea HBC
	$fisioCst = '<a href="https://docs.google.com/forms/d/e/1FAIpQLSfdV2ZDLSiFwuxNFgYLHYK84iRg95pmtNruBwlQEU7g0fIKrw/viewform" target="_blank">
	<img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span> FORMULARIO DE AGENDAMIENTO REHABILITACIÓN CST</span></a>';
	
	// Enlaces impresoras
	$ip239 = '<a href="http://10.12.0.239/" target="_blank">
	<img align="center" border="3" height="50" width="100" src="img/printer.png"><span>RICOH Aficio MP 301 - Farmacia (10.12.0.239)</span></a>';
	
	$ip240 = '<a href="http://10.12.0.240/" target="_blank">
	<img align="center" border="3" height="50" width="100" src="img/printer.png"><span>RICOH IM 430 - Planillaje (10.12.0.240)</span></a>';
	
	$ip241 = '<a href="http://10.12.0.241/" target="_blank">
	<img align="center" border="3" height="50" width="100" src="img/printer.png"><span> RICOH SP 4510SF - Secretaria (10.12.0.241) </span></a>';

	$ip242 = '<a href="http://10.12.0.242/" target="_blank">
	<img align="center" border="3" height="50" width="100" src="img/printer.png"><span>RICOH MP 305+ - Hospitalización (10.12.0.242) </span></a>';

	$ip245 = '<a href="http://10.12.0.245/" target="_blank">
	<img align="center" border="3" height="50" width="100" src="img/printer.png"><span>RICOH Aficio MP C2051 - Estadística (10.12.0.245) </span></a>';

	$ip247 = '<a href="http://10.12.0.247/" target="_blank">
	<img align="center" border="3" height="50" width="100" src="img/printer.png"><span>RICOH  - Consulta Externa (10.12.0.247) </span></a>';

	$ip248 = '<a href="http://10.12.0.248/" target="_blank">
	<img align="center" border="3" height="50" width="100" src="img/printer.png"><span>Lexmark - Hospitalización (10.12.0.248) </span></a>';
?>