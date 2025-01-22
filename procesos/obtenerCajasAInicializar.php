<?php

include ("../clases/conexion.php");




$conexionCajas= conectar();
    mysqli_set_charset($conexionCajas,'utf8'); 
    $sqlc= "SELECT * from cajas where estado='0'";

    $resultadoCajas=mysqli_query($conexionCajas,$sqlc);


  while (($ver = mysqli_fetch_array($resultadoCajas))!= NULL) {

         echo '<option data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["nombre"].'</option>';
        

}




// Liberar resultados
mysqli_free_result($resultadoCajas);
 
// Cerrar la conexión
mysqli_close($conexionCajas);

        
		



?>