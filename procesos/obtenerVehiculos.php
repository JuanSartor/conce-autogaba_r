<?php

include ("../clases/conexion.php");


$idVehiculo = $_POST['idVehiculo'];



 $conexionVehiculos= conectar();
    mysqli_set_charset($conexionVehiculos,'utf8'); 


    	if($idVehiculo=='0'){

    $sqlc= "SELECT * from vehiculos where (id_estado=2 or id_estado=1 ) and eliminado='NO'";

        echo '<option selected data-subtext="0" value="0">'."    ".'</option>';


}

elseif($idVehiculo=='-1'){  

        
        
         $sqlUltimRe="SELECT id from vehiculos where (id_estado=2 or id_estado=1) order by id desc limit 1";
        
            $resultadoUl = mysqli_query($conexionVehiculos,$sqlUltimRe);
            $verUlt = mysqli_fetch_array($resultadoUl);

            
            $sqlc= "SELECT * from vehiculos where (id_estado=2 or id_estado=1)";

    }






else{
	 $sqlc= "SELECT * from vehiculos where  id='$idVehiculo'";
}

    $resultadoVehiculos=mysqli_query($conexionVehiculos,$sqlc);
		



if($idVehiculo=='-1'){    // esto indica q cargo un nuevo vendedor
    while (($ver = mysqli_fetch_array($resultadoVehiculos))!= NULL) {

        if($verUlt['id']==$ver['id']){
            echo '<option selected  data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["marca"]." ".$ver["modelo"]." ".$ver["anio"]." ".$ver["color"]." ".$ver["dominio_patente"].'</option>';
        }
         else{
        echo '<option data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["marca"]." ".$ver["modelo"]." ".$ver["anio"]." ".$ver["color"]." ".$ver["dominio_patente"].'</option>';
         }
        

 }
 }


else{	
    while (($ver = mysqli_fetch_array($resultadoVehiculos))!= NULL) {

    	 echo '<option data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["marca"]." ".$ver["modelo"]." ".$ver["anio"]." ".$ver["color"]." ".$ver["dominio_patente"].'</option>';	

}
}




// Liberar resultados
mysqli_free_result($resultadoVehiculos);
 
// Cerrar la conexión
mysqli_close($conexionVehiculos);

		



?>