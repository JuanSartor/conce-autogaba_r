<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	$_POST['idEntidadCheque'],
	$_POST['numeroCheque'],
	$_POST['montoCheque'],
	$_POST['fechaCobroCheque']);

// echo $obj->agregarCheque($datos);



echo json_encode($obj->agregarCheque($datos));




?>