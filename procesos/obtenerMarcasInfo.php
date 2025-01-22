<?php


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "info_auto.gestion.online/api/custom/public/brands",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Accept: application/vnd.gestion.online+json",
    "X-Force-Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;

// var_dump(json_decode($response));
$arr=json_decode($response,true);
// var_dump($arr[1]->name);
//  var_dump($arr);

// $cadena= "<label>Seleccione Corredor: </label><select id='listaCorredorR' name='listaCorredorR'>";

$id=$_POST['nombre'];

$cadena='<option  value='.'0'.'>'.''.'</option>';

if ($id!='0') {
    foreach ($arr as &$valor) {
 
    //var_dump($valor["name"]);
        $e=explode("\"", $valor["name"]);
        //  echo $e[0];


        // echo "----------";
        $i=explode("\"", $valor["id"]);
        //  echo $i[0];
        // var_dump($valor["id"]);

      if($id==$i[0]){

        $cadena=$cadena.'<option selected  value='.$i[0].'>'.$e[0].'</option>';

      }
      else{
          $cadena=$cadena.'<option  value='.$i[0].'>'.$e[0].'</option>';
      }
    }
    // echo $cadena."</select>";

    echo $cadena;
}
else{
  foreach ($arr as &$valor) {
 
    //var_dump($valor["name"]);
        $e=explode("\"", $valor["name"]);
        //  echo $e[0];


        // echo "----------";
        $i=explode("\"", $valor["id"]);
        //  echo $i[0];
        // var_dump($valor["id"]);

      

        $cadena=$cadena.'<option  value='.$i[0].'>'.$e[0].'</option>';
    }
    // echo $cadena."</select>";

    echo $cadena;


}





?>