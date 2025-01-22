<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	$_POST['fechaIngresoGasto'],
	$_POST['idProveedor'],
	$_POST['montoGasto'],
$_POST['descripcionGasto'],
$_POST['idGasto']);

echo $obj->agregarGasto($datos);




?>