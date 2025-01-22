<?php

include 'clases/conexion.php';
 require_once "scripts.php"; 


$conexion= conectar();



session_start();  
$_SESSION["usernameC"] = $_POST["username"];

$_SESSION['last_login_timestamp'] = time(); 


$parametros= array($_POST['username'],$_POST['password']);







$sql= "SELECT id,usuario,eliminado,permisos FROM usuarios WHERE usuario='$parametros[0]' and
 DECODE(password,'Concesionaria')='$parametros[1]' and eliminado='NO' ";


$resultado=mysqli_query($conexion,$sql);


if($reg=mysqli_fetch_array($resultado) and $reg['eliminado']=='NO'){  //valido que devolvio un registro y que no esta inactivo

	 if($reg['permisos']=='administrador'  ){  // debe ser administrador 

	 	$permisos='1'; // tiene permisos para todo

	 }
	 else if($reg['permisos']=='gestor'  ){   // gestor no ve resumen, es decir el index ni usuarios
	 	$permisos='2';
		
	 }

	 else if($reg['permisos']=='vendedor'  ){   // igual q gestor, sirve para poder diferenciarlos solamente
	 	$permisos='3';
		
	 }
	 else{
		 $permisos='4';
	 }

	

	$_SESSION["idC"]=$reg['id'];
	$_SESSION["permisos"]=$permisos;
	// $param= base64_encode($permisos." ".$reg['id']);
	if($permisos=='1'){
	header("location: index.php");	
	}
	else{
		header("location: automoviles.php");
	}


}

else{

	echo "<div class=\"alert alert-danger\" role=\"alert\" >Sesion Invalida</div> ";

} 



mysqli_close($conexion);



?>