<?php

include ("../clases/conexion.php");

 $listaIdAutos = $_POST['listaIdAutosTodos'];

 $arryListaAutos= explode(",",$listaIdAutos);



 $conexionVehiculos= conectar();
    mysqli_set_charset($conexionVehiculos,'utf8'); 

     if($_POST['ba']==1){

        

        $sqlUpdC="UPDATE vehiculos set usado_como_pago=0 where id in ($listaIdAutos)";

        mysqli_query($conexionVehiculos,$sqlUpdC);

    }



    $sqlc="SELECT id,dominio_patente,marca,modelo,color,anio,kilometros,precio_compra FROM vehiculos where usado_como_pago=0 and  eliminado='NO' and (id_estado='1' or id_estado='2' )";

    $resultadoVehiculos=mysqli_query($conexionVehiculos,$sqlc);
		



	
    while (($ver = mysqli_fetch_array($resultadoVehiculos))!= NULL){

    	
        if((in_array($ver["id"], $arryListaAutos)) and true){
            echo '<option    selected data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["marca"]." ".$ver["modelo"]." ".$ver["anio"]." ".$ver["color"]." ".$ver["dominio_patente"]."---".$ver["precio_compra"].'</option>';

            
        }
        else{

            echo '<option   data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["marca"]." ".$ver["modelo"]." ".$ver["anio"]." ".$ver["color"]." ".$ver["dominio_patente"]."---".$ver["precio_compra"].'</option>';
            
        }



    }










// Liberar resultados
mysqli_free_result($resultadoVehiculos);
 
// Cerrar la conexión
mysqli_close($conexionVehiculos);

		



?>