<?php

 

 if(isset($_POST['mes'])){//Comprobamos si está disponible la variable mes
 
  //fecha de nacimiento
  
  $dia = $_POST['dia'];
  $mes = $_POST['mes']; //almacenamos en variables
  $anio = $_POST['anio'];
  
  //hoy
  $diaAC=date("j");
  $mesAC=date("n");
  $anoAC=date("Y");
  
 
 
  //si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
   
  if (($mes == $mesAC) && ($dia > $diaAC)) {
  $anoAC=($anoAC-1); }
   
  //si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
   
  if ($mes > $mesAC) {
  $anoAC=($anoAC-1);}
   
  //ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
   
  $edad=($anoAC-$anio);
  
  //echo "Tiene ".$edad;
 }
 
?>    


<div align="center">
 <form method="post" action="calculaEdad.php" action="insertar.php" />
 <h1>CALCULAR EDAD DEL PACIENTE</h1>
  <table border="4" 
  >

  <input type="number" name="dia" placeholder="d&#237a" required />
  <input type="number" name="mes" placeholder="mes" required />
  <input type="number" name="anio" placeholder="a&#241o" required />

  <input type="text" name="edad" value="<?php echo $edad;?>" >
  <input type="submit" value=" CALCULAR EDAD" />
  
<br><br><h1>
<?php

echo "El Paciente tiene ".$edad." a&#241os";
?>  </h1>
  </div>
 </form>
 </table>