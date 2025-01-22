<?php

 /**
  * 
  */
 
 function conectar(){


 		$hostname = "localhost";
 		$database = "u691174766_autogaba";
 		$password="";
 		$username = "root";
 		



 		$conexion= new mysqli($hostname,$username,$password,$database);

 		return $conexion;
 	}
 

 ?>