<?php  
 //logout.php  
 // session_start();  
 // session_destroy();  

include 'clases/conexion.php';

session_start();


session_unset();
session_destroy();



  
echo'<script type="text/javascript">
    alert("Se Ha Cerrado Su Sesión");
    window.location.href="inicio.php";
    </script>';

 ?> 