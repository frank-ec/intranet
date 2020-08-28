<?php 
// Parametriza la UO
$unidadOperativa = 2; // 1 para HBC, 2 para CST

// Url al servidores externos
$server17d10 ='<a href="http://186.47.99.108'; // DD17D10  servidor publico
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

	$cie10 = $server17d10.'/busqueda_cie10"><img align="center"
	border="3" height="50" width="80" src="./img/cie10.png"><span>Consulta CIE10</span></a>';	
			 
	$contrareferencias = $server17d10.'/contrareferencias/"><img align="center"
			 border="3" height="50" width="80" src="./img/contrareferencia.jpeg"><span>Contrareferencias</span></a>';
	
	$fondo = $server17d10.'/fondos/actual.jpeg" target="_blank"><img align="center" border="3" height="50" width="80"
			 src="http://186.47.99.108/fondos/actual.jpeg"><span>Fondo de Pantalla Institucional</span></a>';
	
	$labPedidos = $serverorion.'/"><img align="center"
			 border="3" height="50" width="80" src="./img/pedido.jpeg"><span>Pedidos de Laboratorio</span></a>';  
		   
	$labResultados = $server17d10.'/resultados/"><img align="center"
			 border="3" height="50" width="80" src="./img/laboratorio.png"><span>Resultados de Laboratorio</span></a>';		 		 		 
	
	$controlImpresoras = '';
	
    $dirTelefonico = '<a href="agendaTelefonica.php" ><img align="center" border="3" height="50" width="80" src="./img/guia-telefonica.jpg">
    <span>Directorio Telefónico '.$uo.'</span></a>';							 
  }

  if ($unidadOperativa == 2) {
	$uo = "Centro de Salud Tabacundo Tipo C";
	$localserver ='<a href="http://172.22.67.200'; // CST servidor local
	// Tarjetero indice 
	$tarjetero = $localserver.'/tarjetero/"><img align="center"
			 border="3" height="50" width="80" src="./img/tarjetero.jpeg"><span>Tarjetero indice</span></a>';
	/// Triaje de Emergencia
	$triaje = $localserver.'/triaje/"><img align="center"
			 border="3" height="50" width="80" src="./img/triaje.png"><span>Triaje de Emergencia</span></a>';
	$triajeTV = $localserver.'/triaje/indextv.php"><img align="center"
			 border="3" height="50" width="80" src="./img/manchester.jpg"><span>Pacientes en Emergencia</span></a>';

	$rxResultados = $localserver.'/resultados/"><img align="center"
			 border="3" height="50" width="80" src="./img/rx.jpeg"><span>Resultados de RX</span></a>';
	
	$stockFarmacia = $localserver.'/resultados/index.php/s/EBHAtgaq65E857R"><img align="center"
			 border="3" height="50" width="80" src="./img/farmacia.jpeg"><span>Stock de Farmacia</span></a>';		 
			 
	$biblioteca = $localserver.'resultados/index.php/s/ZYJp9AsFNAHCsqS" target="_blank"><img align="center" border="3"
			  height="50" width="80" src="img/biblioteca1.jpg"><span>Biblioteca Virtual CST</span></a>';
	
	$recortar = $localserver.'/images/index.php"><img align="center"
			  border="3" height="50" width="80" src="./img/recortar.png"><span>Comprimir Imágenes</span></a>';
	
	$cie10 = $server17d10.'/busqueda_cie10"><img align="center"
			  border="3" height="50" width="80" src="./img/cie10.png"><span>Consulta CIE10</span></a>';		  		  		 

	$contrareferencias = $server17d10.'/contrareferencias/"><img align="center"
			 border="3" height="50" width="80" src="./img/contrareferencia.jpeg"><span>Contrareferencias</span></a>';
	
	$fondo = $server17d10.'/fondos/actual.jpeg" target="_blank"><img align="center" border="3" height="50" width="80"
			 src="http://186.47.99.108/fondos/actual.jpeg"><span>Fondo de Pantalla Institucional</span></a>';
	
	$labPedidos = $serverorion.'/"><img align="center"
			 border="3" height="50" width="80" src="./img/pedido.jpeg"><span>Pedidos de Laboratorio</span></a>';  
		   
	$labResultados = $server17d10.'/resultados/"><img align="center"
			 border="3" height="50" width="80" src="./img/laboratorio.png"><span>Resultados de Laboratorio</span></a>';		 
	
	$controlImpresoras = '<a href="https://docs.google.com/forms/d/e/1FAIpQLSdlSQaYAqcUF4ZZyXezk6z4CVSZW5XYogb1sRv5VpAW-rBtVw/viewform?usp=sf_link" ><img align="center" border="3" height="50" width="80"
	  		src="./img/control_impresoras.jpg"><span>Control de Impresoras CST.</span></a>';		 
			 
	$dirTelefonico = '<a href="agendaTelefonica.php" ><img align="center" border="3" height="50" width="80" src="./img/guia-telefonica.jpg">
	 		<span>Directorio Telefónico '.$uo.'</span></a>';							 
  }  

?>