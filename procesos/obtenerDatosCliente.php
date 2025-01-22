<?php 


include ("../clases/conexion.php");
require_once "../clases/crud.php";

$obj= new crud();




echo json_encode($obj->obtenerDatosCliente($_POST['id']));

 ?>