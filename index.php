<?php include('includes/enlaces.php') ?>
<?php include('includes/header.php') ?>
			<nav>
				<div id="popup">
				<ul class="nav"><li><a href="https://www.gestiondocumental.gob.ec" target="_blank"><img align="center" border="3" height="50" width="80" src="img/quipux.jpg"><span>Sistema de Gestión Documental - QUIPUX</span></a></li>
								<li><?php echo $pras ?> </li>
								<li><?php echo $cexterna ?> </li>
								<li><?php echo $triaje ?> </li>
								<li><?php echo $cst_emergencia ?> </li>
								<li><a href="salas.php" ><img align="center" border="3" height="50" width="80" src="./img/salas.png"><span>Salas de Espera</span></a></li>								
								<li><?php echo $rxResultados ?> </li>
								<li><?php echo $stockFarmacia ?> </li>
								<li><?php echo $biblioteca ?> </li>
								<li><?php echo $recortar ?> </li>
								<li><?php echo $dirTelefonico ?> </li>
								<li><?php echo $zimbra ?> </li>
								<li><?php echo $cie10 ?> </li>
								<li><?php echo $fondo ?> </li>
                				<li><?php echo $labPedidos ?> </li>
                				<li><?php echo $labResultados ?> </li>
								<li><a href="https://docs.google.com/forms/d/e/1FAIpQLSdOSnizCI_fyj3HCViaHmnINlg6jDBd8XPZmV36ChQdopbIUQ/viewform"><img align="center" border="3" height="50" width="80" src="./img/eventos.png"><span>Eventos Adversos</span></a></li>	
<li><a href="herramientas_msp.php"><img align="center" border="3" height="50" width="80" src="./img/herramientas.jpg"><span>Herramientas Informáticas MSP</span></a></li>	
<li><a href="seguros.php" ><img align="center" border="3" height="50" width="80" src="./img/seguros.jpg"><span>Consulta de Seguros para Planillaje</span></a></li>
<li><a href="matrices.php" ><img align="center" border="3" height="50" width="80" src="./img/matrices.jpeg"><span>Formularios en Línea</span></a></li>
<li><a href="http://186.47.99.108/cloud/index.php/s/ZmcfKDWxZffMUXJ" ><img align="center" border="3" height="50" width="80" src="./img/higiene.jpeg"><span>Plan Higiene de Manos</span></a></li>
			</ul>	
 			</div>
			</nav>
					
			<section id="contenido">
            <p style="background-color: yellow;">
            </p>
			<table border="1" >
				<td>
		 			<div class="slider">
		<ul>
					<!--<video autoplay="autoplay" height="400" width="695" src="./video/ESAMYN.mp4" ></video>-->
					<!--<video autoplay="autoplay" width="770" src="./video/AgitaTuMundo.mp4"></video>-->
					<?php 	
					if ($uo == 'Hospital Básico Cayambe') {
                        echo '<li><img src="./img/centralhbc.jpeg"></li>';
                                }
                    if ($uo == 'Centro de Salud Tabacundo Tipo C') {
                        echo '<li><img src="./img/centralcst.jpeg"></li>';
                                }
                    ?>
					
					<!--<li><img src="./img/campeonato/logoMSP.JPG"></li>
					<li><img src="./img/campeonato/1.jpg" alt="" ></li>
					<li><img src="./img/campeonato/7.jpg" alt=""></li>
					<li><img src="./img/campeonato/3.jpg" alt=""></li>
					<li><img src="./img/campeonato/4.jpg" alt=""></li> 
					<li><img src="./img/campeonato/5.jpg" alt=""></li>
					<li><img src="./img/campeonato/6.jpg" alt=""></li>
					<li><img src="./img/campeonato/2.jpg" alt=""></li>-->
					
				</ul>
					</div>

						</td>		

			</table>
	</section>
	<aside>
	<div style="text-align:justify" >
			<table border="2" >
						<td><table>
						<td>
						<center><h4>NOTAS IMPORTANTES</h4></center><br>
						<marquee direction="up" scrollamount="1" bgcolor="white"><h3>
									<div style="text-align:justify">
													<!--<p><font color="blue">IMPORTANTE: REALIZAR CURSO VIRTUAL</font><br>	 
													<hr>
													<br>
													
													Se solicita a todo el personal del CST, realizar el curso: 
													<br><br>

													<font color="blue">SALUD EN EL TRABAJO.</font>
													
													<br><br> 
													
													Fecha máxima de entrega del certificado: <font color="blue">14H00 del día Martes 31 de Julio del 2018.</font> 
													<br><br> 
													
													Como ingresar:<font color="blue">Hacer clic en el link: "Cursos."</font>
													<br><br>
													Clave de matriculación: <font color="blue">trabajo.2018</font>
													<br><br> 

													<font color="blue">
													Atentamente:
													<br><br>

													Dr. Carlos Durán Yánez.
													</font>
													<br>
													Administrador Técnico
													<br> 
													C.S. Tabacundo Tipo C.

													</p><br><br>-->

													<p><font color="blue">SIN NOTAS IMPORTANTES</font><br>	 
													
                                                    <!--
													<br>
													Se solicita a todo el personal del Centro de Salud Tabacundo Tipo C, la revisión de material ESAMyN, que se encuentra en la Biblioteca Virtual de la Intranet<br><br> 
													-->

													<!--<font color="blue">1. </font>
													Profilaxis Post-Exposición a la Rabia.
													<br><br> 
													
													Fecha máxima de entrega del certificado: <font color="blue">14H00 del día Miércoles 14 de Febrero del 2018.</font> 
													<br><br> 
													
													Como ingresar:<font color="blue">Hacer clic en el link: "Curso Profilaxis Post-Exposición a la Rabia."</font>
													<br><br>
													

													<hr>
													<br>
													<font color="blue">2. </font> 
													Test Violencia de Genero.
													<br><br> 

													Clave de matriculación: <font color="blue">Vi0l3nc1a2018</font>
													<br><br> 
													Fecha máxima de entrega del certificado: <font color="blue">14H00 del día 27 de Febrero del 2018.</font>
													<br><br> 
													
													Como ingresar:<font color="blue">Hacer clic en el link: "Test Violencia de Genero."</font>
													<br><br>
													<br><br>
													<hr><hr><hr>
													<br><br>
													



													<font color="blue">
													Atentamente:
													<br><br>

													Dra. Lorena Vizuete J.
													</font>
													<br>
													Administradora Técnica
													<br> 
													C.S. Tabacundo Tipo C.

													</p><br><br>-->
													<hr>
												</div>
													  </h3></marquee>
							</td>
					</table>	
						</td>
					</table>
					<!--<font color="blue">1. </font>
					<a href ="https://mooc.campusvirtualsp.org/enrol/index.php?id=11" target="_blank">Curso Profilaxis Post-Exposición a la Rabia.</a><br>
					<font color="blue">2. </font>
					<a href ="http://capacitacion.msp.gob.ec/" target="_blank">Test Violencia de Genero</a>
					<br>
					<font color="blue">3. </font>
					<a href ="http://localhost/admision/cursos/esamyn.php" target="_blank">Evaluación Normativa ESAMyN</a>
					<br>
					
					-->

					<a href ="http://capacitacion1.msp.gob.ec/login/index.php" target="_blank"><center><img align="center" border="3" height="40" width="200" src="http://utlajabajio.edu.mx/moodle/pluginfile.php/3691/coursecat/description/cursos.gif"></a></center></a>
					<br> 	 

					<!--<h4>1. No hay Cursos Disponibles</h4><br>-->

					<h4><a href ="http://www.salud.gob.ec/catalogo-de-normas-politicas-reglamentos-protocolos-manuales-planes-guias-y-otros-del-msp/" target="_blank">Catálogo de normas, políticas, reglamentos, protocolos, manuales, planes, guías y otros del MSP.</a></h4><br>	
					<h4><a href ="http://www.salud.gob.ec/guias-de-practica-clinica/" target="_blank">Guías de Práctica Clínica</a></h4>
					<br>
			</aside>
		
		<?php include('includes/footer.php') ?>

	</div>
		
</body>
</html>
