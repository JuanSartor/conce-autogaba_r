<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	ucwords($_POST['nombreCaja']),
	ucwords($_POST['descripcionCaja']),
		$_POST['montoInicialCajaNueva']);

echo $obj->agregarCajaAbd($datos);





?>