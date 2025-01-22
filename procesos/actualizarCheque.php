
<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	$_POST['idU'],
	$_POST['idEntidadChequeU'],
	$_POST['numeroChequeU'],
	$_POST['montoChequeU'],
	$_POST['fechaCobroChequeU']);




echo $obj->actualizarChequeBd($datos);





?>