<?php

include ("../clases/conexion.php");



$idMedio = $_POST['idMedio'];
	





$conexion= conectar();

	

		if($idMedio=='0'){

		$sql= "SELECT id,descripcion FROM medios_contacto WHERE eliminado='0'";

		echo '<option selected data-subtext="0" value="0">'."    ".'</option>';
	}

		else{

			$sql= "SELECT id,descripcion FROM medios_contacto WHERE   id='$idMedio'";
		}
		
		$resultado = mysqli_query($conexion,$sql);
		


	
    while (($ver = mysqli_fetch_array($resultado))!= NULL) {

    	 echo '<option data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["descripcion"].'</option>';
    	

}








// Liberar resultados
mysqli_free_result($resultado);
 
// Cerrar la conexión
mysqli_close($conexion);

		



?>