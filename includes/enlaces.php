<?php 
// Parametriza la UO
$unidadOperativa = 2; // 1 para HBC, 2 para CST

// Url al servidores externos
$server17d10 ='<a href="http://186.47.99.108'; // DD17D10  servidor publico
$serverCst ='<a href="http://190.152.10.78'; // DD17D10  servidor publico
$serverorion ='<a href="https://dd17d10.orion-labs.com'; // ORION servidor publico
		
if ($unidadOperativa == 1) {
	$uo = "Hospital Básico Cayambe";
	$localserver ='<a href="http://10.12.0.12'; // HBC servidor local
	// Tarjetero indice  HBC no existe
	$tarjetero = '';
	/// Triaje de Emergencia
	$triaje = $localserver.'/triaje/"><img align="center"
			 border="3" height="50" width="80" src="./img/triaje.png"><span>Triaje de Emergencia</span></a>';
	$triajeTV = $localserver.'/triaje/indextv.php"><img align="center"
			 border="3" height="50" width="80" src="./img/manchester.jpg"><span>Pacientes en Emergencia</span></a>';		 

	$rxResultados = $server17d10.'/cloud/"><img align="center"
			 border="3" height="50" width="80" src="./img/rx.jpeg"><span>Resultados de RX</span></a>';
	
	$stockFarmacia = '';
	
	$biblioteca = '';

	$recortar = '';

	$cie10 = $serverCst.'/busqueda_cie10"><img align="center"
	border="3" height="50" width="80" src="./img/cie10.png"><span>Consulta CIE10</span></a>';	
			 
	$contrareferencias = $serverCst.'/contrareferencias/"><img align="center"
			 border="3" height="50" width="80" src="./img/contrareferencia.jpeg"><span>Contrareferencias</span></a>';
	
	$fondo = $server17d10.'/fondos/actual.jpeg" target="_blank"><img align="center" border="3" height="50" width="80"
			 src="http://186.47.99.108/fondos/actual.jpeg"><span>Fondo de Pantalla Institucional</span></a>';
	
	$labPedidos = $serverorion.'/"><img align="center"
			 border="3" height="50" width="80" src="./img/pedido.jpeg"><span>Pedidos de Laboratorio</span></a>';  
		   
	$labResultados = $serverCst.'/resultados/"><img align="center"
			 border="3" height="50" width="80" src="./img/laboratorio.png"><span>Resultados de Laboratorio</span></a>';		 		 		 
	
	$controlImpresoras = '';
	
    $dirTelefonico = '<a href="agendaTelefonica.php" ><img align="center" border="3" height="50" width="80" src="./img/guia-telefonica.jpg">
	<span>Directorio Telefónico '.$uo.'</span></a>';
	
	$zimbra = '<a href="https://mail.hbc.gob.ec:8443/" target="_blank"><img align="center" border="3" height="50" width="80" src="img/zimbra.jpg">
	<span>Correo Institucional - Zimbra </span></a>';

	$nubeInterna = '';

	$infochanel = $localserver.':8096/"><img align="center"
	border="3" height="50" width="80" src="./img/emby.jpg"><span>Sala de Espera General </span></a>';

	$consultaExterna = $localserver.'/consultaexterna/"><img align="center"
	border="3" height="50" width="80" src="./img/llamar.jpeg"><span>Consulta Externa</span></a>';

	$sala1 = $localserver.'/consultaexterna/turnos_ce_sala.html"><img align="center"
	border="3" height="50" width="80" src="./img/salas.png"><span>Sala de Espera Consulta Externa </span></a>';

	// Enlaces a matrices en linea HBC

	$pruebasRapidas = '<a href="https://docs.google.com/forms/d/e/1FAIpQLSdyZTleAY7MNK-sTvFvG0N31RLePiFbyq1uqp_o29qarGXZLQ/viewform" target="_blank">
	<img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span> Reporte de Inconformidades de Laboratorio Clínico</span></a>';
		
	
  }

  if ($unidadOperativa == 2) {
	$uo = "Centro de Salud Tabacundo Tipo C";
	$localserver ='<a href="http://172.22.67.200'; // CST servidor local
	$contingenciaserver ='<a href="http://172.22.67.7'; // CST servidor local

	// Tarjetero indice 
	$tarjetero = $localserver.'/tarjetero/"><img align="center"
			 border="3" height="50" width="80" src="./img/tarjetero.jpeg"><span>Tarjetero indice</span></a>';
	// Consulta externa 
	$cexterna = $localserver.'/consultaexterna/"><img align="center"
			 border="3" height="50" width="80" src="./img/calendario.jpg"><span>Consulta Externa</span></a>';
			 
			 
	/// Triaje de Emergencia
	$triaje = $localserver.'/triaje/"><img align="center"
			 border="3" height="50" width="80" src="./img/triaje.png"><span>Triaje de Emergencia</span></a>';
	$triajeTV = $localserver.'/triaje/indextv.php"><img align="center"
			 border="3" height="50" width="80" src="./img/manchester.jpg"><span>Sala de Espera Emergencia</span></a>';
	$cst_emergencia = $localserver.'/emergencia/"><img align="center"
			 border="3" height="50" width="80" src="./img/emergencia.jpg"><span>Servicio de Emergencia</span></a>';

	//		 

	$rxResultados = $serverCst.'/nextcloud/"><img align="center"
			 border="3" height="50" width="80" src="./img/rx.jpeg"><span>Resultados de RX</span></a>';
	
	$stockFarmacia = $serverCst.'/nextcloud/index.php/s/r8tLxPe4BDYsDZi"><img align="center"
			 border="3" height="50" width="80" src="./img/farmacia.jpeg"><span>Stock de Farmacia</span></a>';		 
			 
	$biblioteca = $localserver.'/resultados/index.php/s/ZYJp9AsFNAHCsqS" target="_blank"><img align="center" border="3"
			  height="50" width="80" src="img/biblioteca1.jpg"><span>Biblioteca Virtual CST</span></a>';
	
	$recortar = $localserver.'/images/index.php"><img align="center"
			  border="3" height="50" width="80" src="./img/recortar.png"><span>Comprimir Imágenes</span></a>';
	
	$cie10 = $serverCst.'/busqueda_cie10"><img align="center"
			  border="3" height="50" width="80" src="./img/cie10.png"><span>Consulta CIE10</span></a>';		  		  		 

	$contrareferencias = $serverCst.'/contrareferencias/"><img align="center"
			 border="3" height="50" width="80" src="./img/contrareferencia.jpeg"><span>Contrareferencias</span></a>';
	
	$fondo = $server17d10.'/fondos/actual.jpeg" target="_blank"><img align="center" border="3" height="50" width="80"
			 src="http://186.47.99.108/fondos/actual.jpeg"><span>Fondo de Pantalla Institucional</span></a>';
	
	$labPedidos = $serverorion.'/"><img align="center"
			 border="3" height="50" width="80" src="./img/pedido.jpeg"><span>Pedidos de Laboratorio</span></a>';  
		   
	$labResultados = $serverCst.'/resultados/"><img align="center"
			 border="3" height="50" width="80" src="./img/laboratorio.png"><span>Resultados de Laboratorio</span></a>';		 
	
	$controlImpresoras = '<a href="https://docs.google.com/forms/d/e/1FAIpQLSdlSQaYAqcUF4ZZyXezk6z4CVSZW5XYogb1sRv5VpAW-rBtVw/viewform?usp=sf_link" ><img align="center" border="3" height="50" width="80"
	  		src="./img/control_impresoras.jpg"><span>Control de Impresoras CST.</span></a>';		 
			 
	$dirTelefonico = '<a href="agendaTelefonica.php" ><img align="center" border="3" height="50" width="80" src="./img/guia-telefonica.jpg">
			 <span>Directorio Telefónico '.$uo.'</span></a>';
	
	$zimbra = '<a href="https://mail.17d10.mspz2.gob.ec/" target="_blank"><img align="center" border="3" height="50" width="80" src="img/zimbra.jpg">
			<span>Correo Institucional - Zimbra </span></a>';
	
	$nubeInterna = '<a href="http://190.152.10.78/nextcloud/index.php" target="_blank"><img align="center" border="3"
			height="50" width="80" src="img/nextcloud.png"><span>Nube Interna - NextCloud CST</span></a>';

	$infochanel = $contingenciaserver.':8096/"><img align="center"
			border="3" height="50" width="80" src="./img/emby.jpg"><span>Sala de Espera General </span></a>';

	$consultaExterna = $localserver.'/consultaexterna/"><img align="center"
			border="3" height="50" width="80" src="./img/llamar.jpeg"><span>Consulta Externa</span></a>';		
	
	$sala1 = $localserver.'/consultaexterna/turnos_ce_sala.html"><img align="center"
			border="3" height="50" width="80" src="./img/salas.png"><span>Sala de Espera Consulta Externa </span></a>';

	$agendamiento = $server17d10.'/cstabacundo/" target="_blank"><img align="center" border="3" height="50" width="80"
			src="./img/salas.png"><span>Agendamiento CST</span></a>';		

	// Matrices en linea CST
	$pruebasRapidas = '<a href="https://docs.google.com/spreadsheets/d/1-v7eb73mGWUU_M1Q4LyDRdF9D4cvHIz_huFWQg6nnas/edit?usp=sharing" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span> Matríz Pruebas Rápidas</span></a>';

	$pedidosRx = '<a href="https://docs.google.com/forms/d/e/1FAIpQLSc5EU_Mo1z8BhXBUbNYhZqeUqhcUN7ZZLab0gWDaKtWYVKuqA/viewform" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span> Solicitud de estudio radiológico</span></a>';

	$pedidosInsumos = '<a href="https://docs.google.com/spreadsheets/d/16J4d4zbYUaeUnobt86RB-1Tp8Q6TPlrhXNoJmXTAEWs/edit?usp=sharing" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span> Solicitud de Insumos</span></a>';

	$atencionesEmergencia = '<a href="https://docs.google.com/spreadsheets/d/1oRMTVMFewlInFsGpkeQcpTlbjEeQYXUzdzKQmpUZw3w/edit#gid=757274881" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span> Parte Diario Atenciones de Emergencia</span></a>';

	$violenciaGenero = '<a href="https://docs.google.com/spreadsheets/d/1KZoXqWGzjld1ZgNUeT8XpZ8xaf004P9a/edit?usp=sharing&ouid=107508571411896702952&rtpof=true&sd=true" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span> Violencia de Género</span></a>';
	
	$obstetricia = '<a href="https://drive.google.com/drive/u/1/folders/12A1OU6TMPqTnYTQznZaEVVuhYI5U9miE" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span>Matrices Obstetricia</span></a>';

	$desnutricion =  '<a href="https://docs.google.com/spreadsheets/d/1VkG-FHRuu1UlyTNcZtm2RK_iefzFtT1WfL3PvPO2qPo/edit#gid=0" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span>Desnutrición < 59 meses</span></a>';	

	$alfa25 =  '<a href="https://docs.google.com/spreadsheets/d/1n9EcMkPZyUrDWrITsrJCUI9N91aEnhH5c1mYzGlCSiA/edit#gid=1804413424" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span>ALFA 25</span></a>';	

	$prioritarios =  '<a href="https://docs.google.com/spreadsheets/d/1O5wjZVLs_8iy2Ny8wIeFaKIAMkI7Kk3BITjoL6Wvjy4/edit?usp=sharing" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span>CONSOLIDADO PRIORITARIOS Y VULNERABLES</span></a>';

	$hearts =  '<a href="https://docs.google.com/spreadsheets/d/1cIOJaVqzJpPBHUPYNMfgUnymBnHcVckRUSozZS0kEdQ/edit?usp=sharing" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span>MATRIZ HEARTS</span></a>';

	$padron =  '<a href="https://docs.google.com/spreadsheets/d/1Ge1IJegglKy0SDuqZqHFu8dk1cU_nkpaLHwtoxp6xcs/edit?usp=sharing" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span>PADRON NOMINAL</span></a>';

	$seguimiento = '<a href="https://docs.google.com/spreadsheets/d/142fqtqRcj5hZaLXH9U_DOFSnD3NTPHo_4Co9rXbehcA/edit?usp=sharing" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span> Matriz de Seguimiento -Aislamiento Domiciliario</span></a>';
	
	$paramedicosProcedimientos = '<a href="https://docs.google.com/spreadsheets/d/1ewZ_ryJolRqu5gUY0Lz-xR6H58pNF4Rbh8bQNMJW_Us/edit?usp=sharing" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span> Procedimientos de Paramedicos</span></a>';

	$enfermerasProcedimientos = '<a href="https://docs.google.com/spreadsheets/d/1UOGv9MiI6aRSibLXXHmQG3yf7ourIGhzzY-NcBqmVJM/edit?skip_itp2_check=true&pli=1#gid=2118390253" target="_blank"><img align="center" border="3" height="50" width="100" src="img/matrices.jpeg"><span> Procedimientos de Enfermeras</span></a>';
	
		  }  

   // Enlaces para la pagina de herramientas MSP

   $phuyu = '<a href="https://msp.citas.med.ec/" target="_blank"><img align="center" border="3" height="50" width="80" 
	  src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQVfGz1N3H-k6eWdqc5FkikuKuD0lOQL1UqpY2KP_f5y31wIqOkRw"><span>Sistema de Consulta de Citas Médicas MSP</span></a>';
	  
	$pras = '<a href="https://sgrdacaa.msp.gob.ec/" target="_blank"><img align="center" border="3" height="50" width="80" src="img/pras_msp.jpg"><span>PRAS - MSP</span></a>';  

	$tamizaje = '<a href="https://tamizaje.msp.gob.ec/tamen/" target="_blank"><img align="center" border="3" height="50" width="80" src="img/tamizaje.jpg"><span> SISTEMA DE TAMIZAJE METABÓLICO NEONATAL - TAMEN MSP .</span></a>';

	$satRec = '<a href="http://181.196.107.78:7474/faces/index.xhtm/" target="_blank"><img align="center" border="3" height="50" width="80" src="img/referencias.png">
	<span>Sistema de Agendamiento de Turnos para Referencias y Contrarreferencias (SAT-REC)</span></a>';

	$nubeExterna = '<a href="http://186.47.99.108/cloud/" ><img align="center" border="3" height="50" width="80" src="img/nube.jpg"><span>Nube Externa - Owncloud 17D10</span></a>';

	

?>