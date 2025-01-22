<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	$_POST['usuarioU'],
	$_POST['pwU'],
	ucwords($_POST['nombreU']),
	ucwords($_POST['apellidoU']),
	$_POST['correoU'],
	$_POST['dniU'],
	$_POST['telefonoU'],
	$_POST['permisosE']);




echo $obj->actualizar($datos);





?>