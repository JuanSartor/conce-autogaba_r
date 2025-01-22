<?php


// poner aca q reciba el parametro
$urlpar="info_auto.gestion.online/api/custom/public/vehicleProperties?vehicleId=".$_POST['vehiculo'];
$curl = curl_init();


curl_setopt_array($curl, array(
  CURLOPT_URL => $urlpar,
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
$arreeo=json_decode($response);

$traccion=$arr["Motor y Transmision"]["traccion"]["value"];
$potencia=$arr["Motor y Transmision"]["Potencia"]["value"];
$combustible=$arr["Motor y Transmision"]["Combustible"]["value"];
$velMaxima=$arr["Motor y Transmision"]["Velocidad maxima"]["value"];
$alimentacion=$arr["Motor y Transmision"]["Alimentacion"]["value"];
$cilindrada=$arr["Motor y Transmision"]["cilindrada"]["value"];

if($arr["Comodidades"]["Computadora"]["value"]=='1'){$computadora='Si';}
else{$computadora='No';}
if($arr["Comodidades"]["Faros antiniebla"]["value"]=='1'){$farosAntiniebla='Si';}
else{$farosAntiniebla='No';}
if($arr["Comodidades"]["Cuero"]["value"]=='1'){$cuero='Si';}
else{$cuero='No';}
if($arr["Comodidades"]["Caja automatica"]["value"]=='1'){$cajaAutomatica='Si';}
else{$cajaAutomatica='No';}
if($arr["Comodidades"]["Asientos electricos"]["value"]=='1'){$asientosElectricos='Si';}
else{$asientosElectricos='No';}
if($arr["Comodidades"]["Bluetooth"]["value"]=='1'){$bluetooth='Si';}
else{$bluetooth='No';}
if($arr["Comodidades"]["Sensor estacionamiento"]["value"]=='1'){$sensorEstacionamiento='Si';}
else{$sensorEstacionamiento='No';}
if($arr["Comodidades"]["Asientos calefaccionados"]["value"]=='1'){$asientosCalefaccionados='Si';}
else{$asientosCalefaccionados='No';}
if($arr["Comodidades"]["Llantas de aleacion"]["value"]=='1'){$llantasDeAleacion='Si';}
else{$llantasDeAleacion='No';}
if($arr["Comodidades"]["Aire acondicionado"]["value"]=='1'){$aireAcondicionado='Si';}
else{$aireAcondicionado='No';}

$climatizador=$arr["Comodidades"]["Climatizador"]["value"];
if($arr["Comodidades"]["Levas al volante"]["value"]=='1'){$levasAlVolante='Si';}
else{$levasAlVolante='No';}
if($arr["Comodidades"]["Camara estacionamiento"]["value"]=='1'){$camaraEstacionamiento='Si';}
else{$camaraEstacionamiento='No';}
if($arr["Comodidades"]["Techo solar panoramico"]["value"]=='1'){$techoSolarPanoramico='Si';}
else{$techoSolarPanoramico='No';}
if($arr["Comodidades"]["Techo corredizo"]["value"]=='1'){$techoCorredizo='Si';}
else{$techoCorredizo='No';}


// var_dump($arreeo->Comodidades->key());

//  foreach ($arr[0]->Comodidades as $k=>$v){
//   var_dump( "$k : $v\n");
//  }


$imprimi="
<br>
<label>Motor y Transmision:</label>

<hr>
<div class='row'>
<div class='col-sm-2'> 
<label>'$eee':</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$traccion'>
</div>
<div class='col-sm-2' > 
<label>Potencia:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$potencia'>
</div>
<div class='col-sm-2' > 
<label>Combustible:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$combustible'>
</div>
</div>

<br>
<div class='row'>
<div class='col-sm-2' > 
<label>Velocidad Maxima:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$velMaxima'>
</div>
<div class='col-sm-2' > 
<label>Alimentacion:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$alimentacion'>
</div>
<div class='col-sm-2' > 
<label>Cilindrada:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$cilindrada'>
</div>
</div>

<br>

<label>Comodidades:</label>

<hr>
<div class='row'>
<div class='col-sm-2' > 
<label>Computadora:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$computadora'>
</div>
<div class='col-sm-2' > 
<label>Faros Antiniebla:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$farosAntiniebla'>
</div>
<div class='col-sm-2' > 
<label>Cuero:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$cuero'>
</div>
</div>

<br>
<div class='row'>
<div class='col-sm-2' > 
<label>Caja Automatica:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$cajaAutomatica'>
</div>
<div class='col-sm-2' > 
<label>Asientos Electricos:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$asientosElectricos'>
</div>
<div class='col-sm-2' > 
<label>Bluetooth:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$bluetooth'>
</div>
</div>

<br>

<div class='row'>
<div class='col-sm-2' > 
<label>Sensor Estacionamiento:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$sensorEstacionamiento'>
</div>
<div class='col-sm-2' > 
<label>Asientos Calefaccionados:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$asientosCalefaccionados'>
</div>
<div class='col-sm-2' > 
<label>Llantas de Aleacion:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$llantasDeAleacion'>
</div>
</div>

<br>
<div class='row'>
<div class='col-sm-2' > 
<label>Aire Acondicionado:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$aireAcondicionado'>
</div>
<div class='col-sm-2' > 
<label>Climatizador:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$climatizador'>
</div>
<div class='col-sm-2' > 
<label>Levas al Volante:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$levasAlVolante'>
</div>
</div>

<br>
<div class='row'>
<div class='col-sm-2' > 
<label>Camara Estacionamiento:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$camaraEstacionamiento'>
</div>
<div class='col-sm-2' > 
<label>Techo Solar Panoramico:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$techoSolarPanoramico'>
</div>
<div class='col-sm-2' > 
<label>Techo Corredizo:</label>
</div>
<div class='col-sm-2'>
<input  disabled type='text' class='form-control input-sm' value='$techoCorredizo'>
</div>
</div>






";

echo($imprimi);
//  var_dump($arr);

// $cadena= "<label>Seleccione Corredor: </label><select id='listaCorredorR' name='listaCorredorR'>";


// $cadena="";
// foreach ($arr as &$valor){
  
     
  
  //  $e=explode("\"",$valor["name"]);
  //  echo $e[0];


  // echo "----------";
  //  $i=explode("\"",$valor["id"]);
  //  echo $i[0];
    // var_dump($valor["id"]);


    // $cadena=$cadena.'<option  value='.$i[0].'>'.$e[0].'</option>';

  // }
  // echo $cadena."</select>";

  // echo $cadena;
?>