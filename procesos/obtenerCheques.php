<?php

include ("../clases/conexion.php");


 $listaIdCheques = $_POST['listaIdCheques'];

 $arryListaCheques= explode(",",$listaIdCheques);





 $conexionCheques=conectar();


    if($_POST['ba']==1){

        

        $sqlUpdC="UPDATE cheques set usado='NO' where id in ($listaIdCheques)";

        mysqli_query($conexionCheques,$sqlUpdC);

    }




    // if($_POST['ba']==0){
        $sqlCheque="SELECT cheques.id,numero_cheque,monto,fecha_cobro,descripcion FROM cheques,entidades_prendarias where  id_entidad=entidades_prendarias.id  and entidades_prendarias.eliminado='NO' and cheques.eliminado='NO' and cheques.usado='NO'";
//     }
// else{

// $sqlCheque="SELECT cheques.id,numero_cheque,monto,fecha_cobro,descripcion FROM cheques,entidades_prendarias where  id_entidad=entidades_prendarias.id  and entidades_prendarias.eliminado='NO' and cheques.eliminado='NO'";
// }

$result = mysqli_query($conexionCheques,$sqlCheque);

 $longitud= $result->num_rows;

	
	$i=1;
    while (($ver = mysqli_fetch_array($result))!= NULL) {

    	// if(($i == $longitud) and $bandera){

        if((in_array($ver["id"], $arryListaCheques)) and true){

			echo '<option selected data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["numero_cheque"]." ".$ver["monto"]." ".$ver["fecha_cobro"]." ".$ver["descripcion"].'</option>';
			
    	}
    	else{

    	 echo '<option  data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["numero_cheque"]." ".$ver["monto"]." ".$ver["fecha_cobro"]." ".$ver["descripcion"].'</option>';
    	$i++;
    	}

}







// Liberar resultados
mysqli_free_result($result);
 
// Cerrar la conexión
mysqli_close($conexionCheques);

		



?>