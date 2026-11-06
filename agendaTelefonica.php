<?php include('includes/header.php') ?>
	<main>
		<section class="panel" style="flex: 1 1 100%;">
			<h2 class="text-center">Agenda Telefónica</h2>

			<?php
			// Define el html para imprimir el directorio telefónico del HBC
			$directoriohbc = '
				<h3 class="text-center">Líneas convencionales</h3>
				<table class="data-table">
					<tr>
						<th>Ubicación</th>
						<th>Usuario</th>
						<th>Número</th>
					</tr>
					<tr>
						<td>Línea 1</td>
						<td>Central Telefónica</td>
						<td>02-2360072</td>
					</tr>
					<tr>
						<td>Línea 2</td>
						<td>Central Telefónica</td>
						<td>02-2361053</td>
					</tr>
					<tr>
						<td>Emergencia</td>
						<td>Línea Directa</td>
						<td>25</td>
					</tr>
				</table>

				<h3 class="text-center">Extensiones Internas</h3>
				<table class="data-table">
					<tr>
						<th>Servicio</th>
						<th>Extensión</th>
					</tr>
					<tr>
						<td>Secretaría</td>
						<td>11</td>
					</tr>
					<tr>
						<td>Dirección</td>
						<td>22</td>
					</tr>
					<tr>
						<td>Emergencia</td>
						<td>25</td>
					</tr>
					<tr>
						<td>Estadistica</td>
						<td>15</td>
					</tr>
					<tr>
						<td>Farmacia</td>
						<td>23</td>
					</tr>
					<tr>
						<td>Guardianía</td>
						<td>30</td>
					</tr>
					<tr>
						<td>Hospitalización</td>
						<td>19</td>
					</tr>
					<tr>
						<td>Laboratorio</td>
						<td>17</td>
					</tr>
					<tr>
						<td>Nutrición</td>
						<td>33</td>
					</tr>
					<tr>
						<td>Planillaje</td>
						<td>31</td>
					</tr>
					<tr>
						<td>Quirófano</td>
						<td>18</td>
					</tr>
					<tr>
						<td>Rayos X</td>
						<td>24</td>
					</tr>
					<tr>
						<td>Trabajo Social</td>
						<td>21</td>
					</tr>
					<tr>
						<td>Talento Humano</td>
						<td>27</td>
					</tr>
				</table>';

			echo $directoriohbc;
			?>
		</section>
	</main>
<?php include('includes/footer.php') ?>
