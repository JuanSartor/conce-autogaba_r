<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	$_POST['selectCajaCierre'],
	$_POST['saldoCierree']);

echo $obj->cerrarCajaBd($datos);





?>