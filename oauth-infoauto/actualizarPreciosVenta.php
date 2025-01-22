<?php
require ("../oauth-infoauto/test_oauth_client.php");

$obj= new TokenAga();

$valToken=$obj->obtenerTokenAga();







include ("../clases/conexion.php");
require_once "../clases/crud.php";





 $datos = array(
 $_POST['porcentaje']);



$conexion= conectar();



    $sqlSelect="SELECT id,info_vehiculo,info_anio FROM vehiculos where id_estado='1' or id_estado='2'";

        $resSele=mysqli_query($conexion,$sqlSelect);


        while($registrosVeh=mysqli_fetch_array($resSele)){   // macheo todos los registros

            if($registrosVeh[1]!=null and $registrosVeh[1]!='0'){  // verifico que no sea nulo o 0 el campo info_vehiculo


                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "info_auto.gestion.online/api/custom/private/vehicleCurrentPrices?vehicleId=".$registrosVeh[1],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                    "Accept: application/vnd.gestion.online+json",
                    "X-Force-Content-Type: application/json",
                    "Authorization: Bearer ". $valToken
                    ),
                ));
                
                $response = curl_exec($curl);
                
                curl_close($curl);
                $arr=json_decode($response,true);
                

                foreach ($arr as &$valor) {
 
                    //var_dump($valor["name"]);
                        $e=explode(":", $valor);
                        //  echo $e[0];
                
                        if(key($arr)==$registrosVeh[2]){
                        //   echo  $e[0];

                        $sql= "UPDATE vehiculos set precio_venta= ($e[0]*1000) +(($e[0]*1000*'$datos[0]')/100),
                        info_precio='$e[0]'*1000
                        WHERE id=$registrosVeh[0] ";
                
                        mysqli_query($conexion,$sql);


                        }
                        
                        next($arr);
                    }

 





            }




        }




   

    $sqlIns="INSERT INTO porcentajes_aumento(id_usuario,porcentaje) values('$_SESSION[idC]','$_POST[porcentaje]')";


    return mysqli_query($conexion,$sqlIns);



?>