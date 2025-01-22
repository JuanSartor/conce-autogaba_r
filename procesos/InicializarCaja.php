<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	$_POST['selectCajaInicializar'],
	$_POST['montoInicialCaja']);

echo $obj->inicializarCajaBd($datos);





?>