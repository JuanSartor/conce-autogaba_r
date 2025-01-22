<?php

require ("../oauth-infoauto/test_oauth_client.php");

$obj= new TokenAga();

$valToken=$obj->obtenerTokenAga();

//  echo $valToken;


 $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "info_auto.gestion.online/api/custom/private/vehicleCurrentPrices?vehicleId=".$_POST['vehiculo'],
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
// var_dump($arr[1]->name);
//  var_dump($arr);

// $cadena= "<label>Seleccione Corredor: </label><select id='listaCorredorR' name='listaCorredorR'>";
$id=$_POST['id'];

 $cadena='<option  value='.'00'.'>'.''.'</option>';

if ($id!='0') {
    foreach ($arr as &$valor) {
 
    //var_dump($valor["name"]);
        $e=explode(":", $valor);
        //  echo $e[0];

        if($id==key($arr)){
          $cadena=$cadena.'<option  selected value='.key($arr)."--".$e[0].'>'.key($arr).'</option>';
        }
        else{
            $cadena=$cadena.'<option  value='.key($arr)."--".$e[0].'>'.key($arr).'</option>';
        }
        next($arr);
    }
    // echo $cadena."</select>";

    echo $cadena;
}
else{
 
  foreach ($arr as &$valor) {
 
    //var_dump($valor["name"]);
        $e=explode(":", $valor);
        //  echo $e[0];

          $cadena=$cadena.'<option  value='.key($arr)."--".$e[0].'>'.key($arr).'</option>';
      
        next($arr);
    }
    // echo $cadena."</select>";

    echo $cadena;

}

?>