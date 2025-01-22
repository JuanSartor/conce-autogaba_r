<?php

include ("../clases/conexion.php");


$idCliente= $_POST['idCliente'];

$idVendedor= $_POST['idVendedor'];




$conexionClientes= conectar();
    mysqli_set_charset($conexionClientes,'utf8'); 



    if($idCliente=='0'){
    $sqlc= "SELECT c.id as id ,c.nombre as nombre ,c.apellido as apellido from clientes c, clientes_vendedor cv
     where cv.id_cliente=c.id and cv.id_vendedor='$idVendedor' and c.eliminado='NO'";

        echo '<option selected data-subtext="0" value="0">'."    ".'</option>';

    
}


    elseif($idCliente=='-1'){  // aca ingresa si carga un nuevo vendedor, busco el id

        $idVendeCli=substr($idVendedor, 0, -2);
        
         $sqlUltimRe="SELECT id from clientes order by id desc limit 1";
        
            $resultadoUl = mysqli_query($conexionClientes,$sqlUltimRe);
            $verUlt = mysqli_fetch_array($resultadoUl);

            
            $sqlc= "SELECT * from clientes,clientes_vendedor where  eliminado='NO' and clientes.id=clientes_vendedor.id_cliente
            and clientes_vendedor.id_vendedor='$idVendeCli'";

    }




	else{  //aca entra cuando es una una edicion
		$sqlc= "SELECT * from clientes where id='$idCliente' ";

	}

    $resultadoClientes=mysqli_query($conexionClientes,$sqlc);




    if($idCliente=='-1'){    // esto indica q cargo un nuevo vendedor
    while (($ver = mysqli_fetch_array($resultadoClientes))!= NULL) {

        if($verUlt['id']==$ver['id']){
            echo '<option selected data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["nombre"]." ".$ver["apellido"].'</option>';
        }
         else{
        echo '<option data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["nombre"]." ".$ver["apellido"].'</option>';
         }
        

 }
 }




else{

  while (($ver = mysqli_fetch_array($resultadoClientes))!= NULL) {

    	 echo '<option data-subtext="'.$ver["id"].'" value="'.$ver["id"].'">'.$ver["nombre"]." ".$ver["apellido"].'</option>';
    	

}
}




// Liberar resultados
mysqli_free_result($resultadoClientes);
 
// Cerrar la conexión
mysqli_close($conexionClientes);

		



?>