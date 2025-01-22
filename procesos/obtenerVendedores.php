<?php

include ("../clases/conexion.php");



$idVendedor = $_POST['idVendedor'];
	





$conexion= conectar();

	

		if($idVendedor=='0' or preg_match("/--/i", $idVendedor)=='1'){   // aca ingresa si va a cargar una preventa nueva

		$sql= "SELECT id,nombre,apellido,email,dni FROM usuarios WHERE permisos='vendedor' and eliminado='NO'";

		if($idVendedor=='0'){
            echo '<option selected data-subtext="0" value="0">'."    ".'</option>';
		}
		else{
			$idVendeCli=substr($idVendedor, 0, -2);

		}
		
	}

	elseif($idVendedor=='-1'){  // aca ingresa si carga un nuevo vendedor, busco el id

		
		
		 $sqlUltimRe="SELECT id from usuarios where permisos='vendedor' order by id desc limit 1";
		
		 	$resultadoUl = mysqli_query($conexion,$sqlUltimRe);
		 	$verUlt = mysqli_fetch_array($resultadoUl);

		 	
			$sql= "SELECT id,nombre,apellido,email,dni FROM usuarios WHERE permisos='vendedor' and eliminado='NO' ";

	}


		else{   // aca si va a editar una preventa

			$sql= "SELECT id,nombre,apellido,email,dni FROM usuarios WHERE permisos='vendedor' and id='$idVendedor'";
		}
		
		$resultado = mysqli_query($conexion,$sql);
		


 	if($idVendedor=='-1'){    // esto indica q cargo un nuevo vendedor
    while (($ver = mysqli_fetch_array($resultado))!= NULL) {

     	if($verUlt['id']==$ver['id']){
      		echo '<option selected data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["nombre"]." ".$ver["apellido"].'</option>';
      	}
    	 else{
     	 echo '<option data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["nombre"]." ".$ver["apellido"].'</option>';
     	 }
    	

 }
 }
 else{    
	    while (($ver = mysqli_fetch_array($resultado))!= NULL) {

			if($idVendeCli==$ver['id']){
				echo '<option selected data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["nombre"]." ".$ver["apellido"].'</option>';
			}
  			else{
     		 echo '<option data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["nombre"]." ".$ver["apellido"].'</option>';
  			}
    	

 }

}








// Liberar resultados
mysqli_free_result($resultado);
 
// Cerrar la conexión
mysqli_close($conexion);

		



?>