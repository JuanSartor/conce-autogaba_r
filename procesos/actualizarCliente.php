<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	$_POST['domicilioU'],
	$_POST['localidadU'],
	ucwords($_POST['provinciaU']),
	$_POST['correoU'],
	$_POST['telefonoU'],
	$_POST['idU'],
	$_POST['nombreU'],
	$_POST['apellidoU'],
	$_POST['dniU'],
	$_POST['razonSocialU'],
	$_POST['cuitU'],
	$_POST['idVendedorParaE'],
	$_POST['idRegClieVend']);



echo $obj->actualizarClienteBd($datos);





?>