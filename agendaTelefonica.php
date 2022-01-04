<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;

}
th, td {
    padding: 15px;
    text-align: center;
}
table#t00 {
    width: 100%;    
    background-color:    #f2f3f4   ;
}

table#t01 {
    width: 100%;    
    background-color:  #d5f5e3 ;
}
</style>
<?php include('includes/enlaces.php') ?>
<?php include('includes/header.php') ?>

<body>

                <form  name="frmBuscar">
                  <fieldset>
                               <center><h2>Agenda Telefónica</h2></center>
                               <br>
                  				 <center><h2>Líneas convencionales</h2></center>
                                <fieldset> 
                               <br><br>
                               <?php
// Define el html para imprimir el directorio telefónico del HBC                                                                                              
                               $directoriohbc = '<table style="width:100%" id="t00">
                               <tr>
                                 <th>Ubicación</th>
                                 <th>Usuario</th> 
                                 <th>Número</th>
                               </tr>
                               <tr>
                                 <td>Línea 1 </td>
                                 <td>Central Telefónica</td>
                                 <td></td>
                               </tr>
                               <tr>
                                 <td>Línea 2</td>
                                 <td>Central Telefónica</td>
                                 <td></td>
                               </tr>
                               <tr>
                                 <td>Emergencia</td>
                                 <td>Línea Directa </td>
                                 <td></td>
                               </tr>
                             </table>
                             <br>
                            
                              <center><h2>Extensiones Externas</h2></center>
                            <br><br> 
                             <table id="t00">

                               <tr>
                                 <th>Ubicación</th>
                                 <th>Usuario</th> 
                                 <th>Extensión</th>
                               </tr>
                               <tr>
                               <td>Operadora</td>
                               <td>Operadora</td>
                               <td><11></td>
                              </tr> 

                               <tr>
                                 <td>Dirección</td>
                                 <td></td>
                                 <td></td>
                               </tr>
                               <tr>
                                 <td>Información</td>
                                 <td></td>
                                 <td></td>
                               </tr>
                               <tr>
                                 <td>Estadistica</td>
                                 <td></td>
                                 <td></td>
                               </tr>
                               <tr>
                                 <td>Emergencia</td>
                                 <td></td>
                                 <td></td>
                               </tr>
                               <tr>
                                 <td>Laboratorio</td>
                                 <td></td>
                                 <td></td>
                               </tr>
                               
                               <tr>
                                 <td>Farmacia</td>
                                 <td></td>
                                 <td></td>
                               </tr>
                               <tr>
                                 <td>Vacunas</td>
                                 <td></td>
                                 <td></td>
                               </tr>
                               <tr>
                                 <td>Rehabilitación Fìsica</td>
                                 <td></td>
                                 <td></td>
                               </tr>

                             </table>
                           
                              <br>
                               </table>';

// Define el html para imprimir el directorio telefónico de CST                                                                                              
                               $directoriocst = '<table style="width:100%" id="t00">
                               <tr>
                                
                                 <th>Ubicación</th>
                                 <th>Usuario</th> 
                                 <th>Número</th>
                               </tr>
                               <tr>
                                 <td>Línea 1 CST</td>
                                 <td>Central Telefónica</td>
                                 <td>2366-527</td>
                               </tr>
                               <tr>
                                 <td>Línea 2 CST</td>
                                 <td>Central Telefónica</td>
                                 <td>2366-472</td>
                               </tr>
                               <tr>
                                 <td>Emergencia</td>
                                 <td>Línea Directa </td>
                                 <td>2366-709</td>
                               </tr>
                             </table>
                             <br>
                            
                              <center><h2>Extensiones Externas</h2></center>
                            <br><br> 
                             <table id="t00">
                               <tr>
                                 <th>Ubicación</th>
                                 <th>Usuario</th> 
                                 <th>Extensión</th>
                               </tr>
                               <tr>
                                 <td>Dirección</td>
                                 <td>Dr. Carlos Duán Yánez</td>
                                 <td><2></td>
                               </tr>
                               <tr>
                                 <td>Información</td>
                                 <td>Dra. Tatiana Vallejo C.</td>
                                 <td><3></td>
                               </tr>
                               <tr>
                                 <td>Estadistica</td>
                                 <td>Tlgo. Robin Aguilar T.</td>
                                 <td><4></td>
                               </tr>
                               <tr>
                                 <td>Emergencia</td>
                                 <td>Médico de Guardia</td>
                                 <td><5></td>
                               </tr>
                               <tr>
                                 <td>Laboratorio</td>
                                 <td>Lic. Silvia Palomo C.</td>
                                 <td><6></td>
                               </tr>
                               
                               <tr>
                                 <td>Farmacia</td>
                                 <td>Dra. Karen Suarez R.</td>
                                 <td><7></td>
                               </tr>
                               <tr>
                                 <td>Vacunas</td>
                                 <td>Lic. Patricia Cabascango A.</td>
                                 <td><8></td>
                               </tr>
                               <tr>
                                 <td>Rehabilitación Fìsica</td>
                                 <td>Lic. Kleber Gordon M.</td>
                                 <td><9></td>
                               </tr>
                               <tr>
                                 <td>Operador</td>
                                 <td>Operador</td>
                                 <td><0></td>
                               </tr>
                             </table>
                            
                              <br>
                              
                              <center><h2>Extensiones Internas</h2></center>
                            <br><br> 
                             <table id="t00">
                               <tr>
                                 <th>Ubicación</th>
                                 <th>Usuario</th> 
                                 <th>Extensión</th>
                               </tr>
                               <tr>
                                 <td>Dirección</td>
                                 <td>Dr. Carlos Duán Yánez</td>
                                 <td><202></td>
                               </tr>
                               <tr>
                                 <td>Información</td>
                                 <td>Dra. Tatiana Vallejo C.</td>
                                 <td><203></td>
                               </tr>
                               <tr>
                                 <td>Vacunas</td>
                                 <td>Lic. Raquel Araujo A.</td>
                                 <td><204></td>
                               </tr>
                               <tr>
                                 <td>Emergencia</td>
                                 <td>Médico de Guardia</td>
                                 <td><205></td>
                               </tr>
                               <tr>
                                 <td>Farmacia</td>
                                 <td>Dra. Karen Suarez R.</td>
                                 <td><206></td>
                               </tr>

                               <tr>
                                 <td>TICs</td>
                                 <td>Ing. Diego Paguay C.</td>
                                 <td><207></td>
                               </tr>
                               <tr>
                                 <td>Laboratorio</td>
                                 <td>Lic. Silvia Palomo C.</td>
                                 <td><209></td>
                               </tr>
                               <tr>
                                 <td>Rehabilitación Fìsica</td>
                                 <td>Lic. Kleber Gordon M.</td>
                                 <td><210></td>
                               </tr>
                               <tr>
                                 <td>Admisión Consulta Externa</td>
                                 <td>Personal de Turno.</td>
                                 <td><211></td>
                               </tr>		
                               <tr>
                                 <td>Odontología</td>
                                 <td>Dra. Cecilia Valladares V.</td>
                                 <td><212></td>
                               </tr>
                               <tr>
                                 <td>Rayos X</td>
                                 <td>Personal de Turno.</td>
                                 <td><213></td>
                               </tr>
                               <tr>
                                 <td>Obstetricia</td>
                                 <td>Obs. Anita Sanchez P.</td>
                                 <td><214></td>
                               </tr>
                               <tr>
                                 <td>Trabajo Social</td>
                                 <td>Lic. Ligia Nuñez A.</td>
                                 <td><215></td>
                               </tr>
                               <tr>
                                 <td>Estadistica</td>
                                 <td>Tlgo. Robin Aguilar T.</td>
                                 <td><216></td>
                               </tr>
                               </table>';

// Define el html para imprimir el directorio telefónico de Tabacundo                                                                                              
                               $directoriocst = '<table style="width:100%" id="t00">
                               <tr>
                                
                                 <th>Ubicación</th>
                                 <th>Usuario</th> 
                                 <th>Número</th>
                               </tr>
                               <tr>
                                 <td>Línea 1 CST</td>
                                 <td>Central Telefónica</td>
                                 <td>2366-527</td>
                               </tr>
                               <tr>
                                 <td>Línea 2 CST</td>
                                 <td>Central Telefónica</td>
                                 <td>2366-472</td>
                               </tr>
                               <tr>
                                 <td>Emergencia</td>
                                 <td>Línea Directa </td>
                                 <td>2366-709</td>
                               </tr>
                             </table>
                             <br>
                            
                              <center><h2>Extensiones Externas</h2></center>
                            <br><br> 
                             <table id="t00">
                               <tr>
                                 <th>Ubicación</th>
                                 <th>Usuario</th> 
                                 <th>Extensión</th>
                               </tr>
                               <tr>
                                 <td>Dirección</td>
                                 <td>Dr. Carlos Duán Yánez</td>
                                 <td><2></td>
                               </tr>
                               <tr>
                                 <td>Información</td>
                                 <td>Dra. Tatiana Vallejo C.</td>
                                 <td><3></td>
                               </tr>
                               <tr>
                                 <td>Estadistica</td>
                                 <td>Tlgo. Robin Aguilar T.</td>
                                 <td><4></td>
                               </tr>
                               <tr>
                                 <td>Emergencia</td>
                                 <td>Médico de Guardia</td>
                                 <td><5></td>
                               </tr>
                               <tr>
                                 <td>Laboratorio</td>
                                 <td>Lic. Silvia Palomo C.</td>
                                 <td><6></td>
                               </tr>
                               
                               <tr>
                                 <td>Farmacia</td>
                                 <td>Dra. Karen Suarez R.</td>
                                 <td><7></td>
                               </tr>
                               <tr>
                                 <td>Vacunas</td>
                                 <td>Lic. Patricia Cabascango A.</td>
                                 <td><8></td>
                               </tr>
                               <tr>
                                 <td>Rehabilitación Fìsica</td>
                                 <td>Lic. Kleber Gordon M.</td>
                                 <td><9></td>
                               </tr>
                               <tr>
                                 <td>Operador</td>
                                 <td>Operador</td>
                                 <td><0></td>
                               </tr>
                             </table>
                            
                              <br>
                              
                              <center><h2>Extensiones Internas</h2></center>
                            <br><br> 
                             <table id="t00">
                               <tr>
                                 <th>Ubicación</th>
                                 <th>Usuario</th> 
                                 <th>Extensión</th>
                               </tr>
                               <tr>
                                 <td>Dirección</td>
                                 <td>Dr. Carlos Duán Yánez</td>
                                 <td><202></td>
                               </tr>
                               <tr>
                                 <td>Información</td>
                                 <td>Dra. Tatiana Vallejo C.</td>
                                 <td><203></td>
                               </tr>
                               <tr>
                                 <td>Vacunas</td>
                                 <td>Lic. Raquel Araujo A.</td>
                                 <td><204></td>
                               </tr>
                               <tr>
                                 <td>Emergencia</td>
                                 <td>Médico de Guardia</td>
                                 <td><205></td>
                               </tr>
                               <tr>
                                 <td>Farmacia</td>
                                 <td>Dra. Karen Suarez R.</td>
                                 <td><206></td>
                               </tr>

                               <tr>
                                 <td>TICs</td>
                                 <td>Ing. Diego Paguay C.</td>
                                 <td><207></td>
                               </tr>
                               <tr>
                                 <td>Laboratorio</td>
                                 <td>Lic. Silvia Palomo C.</td>
                                 <td><209></td>
                               </tr>
                               <tr>
                                 <td>Rehabilitación Fìsica</td>
                                 <td>Lic. Kleber Gordon M.</td>
                                 <td><210></td>
                               </tr>
                               <tr>
                                 <td>Admisión Consulta Externa</td>
                                 <td>Personal de Turno.</td>
                                 <td><211></td>
                               </tr>		
                               <tr>
                                 <td>Odontología</td>
                                 <td>Dra. Cecilia Valladares V.</td>
                                 <td><212></td>
                               </tr>
                               <tr>
                                 <td>Rayos X</td>
                                 <td>Personal de Turno.</td>
                                 <td><213></td>
                               </tr>
                               <tr>
                                 <td>Obstetricia</td>
                                 <td>Obs. Anita Sanchez P.</td>
                                 <td><214></td>
                               </tr>
                               <tr>
                                 <td>Trabajo Social</td>
                                 <td>Lic. Ligia Nuñez A.</td>
                                 <td><215></td>
                               </tr>
                               <tr>
                                 <td>Estadistica</td>
                                 <td>Tlgo. Robin Aguilar T.</td>
                                 <td><216></td>
                               </tr>
                               </table>';
                               if ($uo == 'Hospital Básico Cayambe') {
                                echo $directoriohbc;
                                }
                                if ($uo == 'Centro de Salud Tabacundo Tipo C') {
                                  echo $directoriocst;
                                  }
                               ?>
                               </fieldset>   
               			 </fieldset>	
                </form> 
         </body>       
         <?php include('includes/footer.php') ?>

</html>