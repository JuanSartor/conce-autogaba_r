<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	$_POST['descripcion'],
	$_POST['observaciones']);

echo $obj->agregarLugarBd($datos);




?>