<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	$_POST['idU'],
	$_POST['descripcionU'],
	$_POST['observacionesU']);




echo $obj->actualizarProveedorBd($datos);





?>