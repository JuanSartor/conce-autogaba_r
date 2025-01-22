<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	ucwords($_POST['nombre']),
	ucwords($_POST['apellido']),
	$_POST['dni'],
	ucwords($_POST['razonSocial']),
	$_POST['cuit'],
	$_POST['domicilio'],
	$_POST['localidad'],
	$_POST['provincia'],
	$_POST['correo'],
	$_POST['telefono'],
	$_POST['idVendedorPara']);

echo $obj->agregarCliente($datos);




?>