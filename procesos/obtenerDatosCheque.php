<?php 


include ("../clases/conexion.php");
require_once "../clases/crud.php";

$obj= new crud();




echo json_encode($obj->obtenerDatosChequeBd($_POST['id']));

 ?>