<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	$_POST['idTipoSucursal'],
	$_POST['idTipoVehiculo'],
	$_POST['idUbicacion'],
	$_POST['idOrigen'],
	ucwords($_POST['marca']),
	ucwords($_POST['modelo']),
	$_POST['anio'],
	$_POST['dominio_patente'],
	$_POST['kilometros'],
	$_POST['deudas'],
	$_POST['precioCompra'],
	$_POST['color'],
	$_POST['observaciones'],
	$_POST['precioVenta'], 
	$_POST['fechaIngreso'],
	$_POST['idMarcaC'],
	$_POST['idModeloC'],
	$_POST['idVehiculoInfoC'],
	$_POST['idAnioC'],
	$_POST['precioInforAutoC'],
	$_POST['vehiculoinputC']);

// echo $obj->agregarVehiculo($datos);

echo json_encode($obj->agregarVehiculoUsadoBd($datos));




?>