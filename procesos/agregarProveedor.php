<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	ucwords($_POST['observaciones']),
	ucwords($_POST['descripcion']));

echo $obj->agregarProveedorBd($datos);




?>