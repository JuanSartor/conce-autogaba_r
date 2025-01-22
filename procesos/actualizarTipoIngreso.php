<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	$_POST['nombreU'],
	$_POST['idU']);




echo $obj->actualizarTipoIngresoBd($datos);





?>