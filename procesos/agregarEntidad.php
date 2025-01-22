<?php

include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();

$datos = array(
	ucwords($_POST['nombre']));

echo $obj->agregarEntidad($datos);




?>