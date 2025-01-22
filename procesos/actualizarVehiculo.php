<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	$_POST['idTipoSucursalE'],
	$_POST['idTipoVehiculoE'],
	$_POST['idUbicacionE'],
	$_POST['idOrigenE'],
	ucwords($_POST['marcaE']),
	ucwords($_POST['modeloE']),
	$_POST['anioE'],
	$_POST['dominio_patenteE'],
	$_POST['kilometrosE'],
	$_POST['deudasE'],
	$_POST['precioCompraE'],
	$_POST['colorE'],
	$_POST['observacionesE'],
	$_POST['precioVentaE'], 
	$_POST['fechaIngresoE'],
	$_POST['esE'],
	$_POST['idE'],
	$_POST['banderaEstado'],
	$_POST['idMarcaE'],
	$_POST['idModeloE'],
	$_POST['idVehiculoInfoE'],
	$_POST['idAnioE'],
	$_POST['precioInforAutoE'],
	$_POST['vehiculoinputE']);




echo $obj->actualizarVehiculoBd($datos);





?>