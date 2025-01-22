<?php 

require "fpdf/fpdf.php";

include ("clases/conexion.php");

session_start();  
$fechaActual= getdate();

$fechaDeHoy=$fechaActual['mday'].'-'.$fechaActual['mon'].'-'.$fechaActual['year'].'-'.$fechaActual['hours'].'h-'.$fechaActual['minutes'].'-'.$fechaActual['seconds'];


$conexion= conectar();


// recibo valores de la orde PreVenta


$listaIdVehiculosCanje=$_POST['listaVehiculoCanje'];


$saldoFinalAPagar=$_POST['salddoApagar'];

$idVehiculo=$_POST['valorVehiculo'];
$idVendedor=$_POST['valorVendedor'];
$idCliente=$_POST['valorCliente'];

$fechaSeteadaPreVenta=$_POST['valorFechaCargaPreVenta'];



$valorCheckCredito=$_POST['valorCheckCreditoPrendario'];



	
if($valorCheckCredito!='0'){
	$idEntidadCreditoPrendario=$_POST['idEntidadCreditoPrendario'];
	$montoPrendario=$_POST['valorMontoPrendario'];
	$montoSellado=$_POST['valorMontoSellado'];

	$sqlInsCrediPrend="INSERT INTO creditos_prendarios(monto_prendario,monto_sellado,id_entidad)
	 values('$montoPrendario','$montoSellado','$idEntidadCreditoPrendario') ";

	mysqli_query($conexion,$sqlInsCrediPrend);

	$sqlUltiCrPre="SELECT id FROM creditos_prendarios   ORDER by id desc limit 1";


	$resultadopre = mysqli_query($conexion,$sqlUltiCrPre);
	$verIdCredPre= mysqli_fetch_array($resultadopre);
	$idCrediPre=$verIdCredPre[0];
}
else{
	$idEntidadCreditoPrendario='10';
	$montoPrendario='0';
	$montoSellado='0';
	$idCrediPre='0';
}







$valorCheckCreditoPersonal=$_POST['valorCheckCreditoPersonal'];



if($valorCheckCreditoPersonal!='0'){
	$idEntidadCreditoPersonal=$_POST['idEntidadCreditoPersonal'];
	$montoPersonal=$_POST['valorMontoPersonal'];
	
	$sqlInsCrediPerso="INSERT INTO creditos_personal(monto,id_entidad)
		 values('$montoPersonal','$idEntidadCreditoPersonal') ";
	
		mysqli_query($conexion,$sqlInsCrediPerso);
	
	$sqlUltiCrPer="SELECT id FROM creditos_personal   ORDER by id desc limit 1";


	$resultadoper = mysqli_query($conexion,$sqlUltiCrPer);
	$verIdCredPers= mysqli_fetch_array($resultadoper);
	$idCrediPersonal=$verIdCredPers[0];
	
	}
	else{
	$idEntidadCreditoPersonal='10';
	$montoPersonal='0';
	$idCrediPersonal='0';
	}









$efectivoEntregado=$_POST['entregaEfectivo'];	
$observaciones=$_POST['observaciones'];

if($_POST['valorMedio']=='0'){
	$medio='6';

}
else{
	$medio=$_POST['valorMedio'];

}

$costoDeLaTransferencia=$_POST['costoTransferencia'];

$costoDeInformes=$_POST['costoInforme'];
$comisionDelVendedor=$_POST['comisionVendedor'];

$valorCheckboxCheque=$_POST['valorCheckboxCheques'];
$valorCheckboxUsado=$_POST['valorCheckboxUsado'];


$chequesComoPago=$_POST['listaChequesEntregados'];

// $idCajaSetear=$_POST['idCaja'];

$idCajaSetear='1';


$idRegPreVenta=$_POST['idPreVenta'];

$valorEdicion='0';








if($valorCheckboxUsado=='inactivo'){
	$listaIdVehiculosCanje="";

}

if($valorCheckboxCheque=='inactivo'){
	$chequesComoPago="";

}





$idsAu=trim($listaIdVehiculosCanje, ',');
			$resultadoIdsAutos = str_replace(",,", ",", $idsAu);





$resultadoIdsCheques='';


// actualizo los cheques que fueron usado en la preventa como pago

if(strlen($chequesComoPago)>0){

		mysqli_set_charset($conexion,'utf8'); 

			$idsCheq=trim($chequesComoPago, ',');
			$resultadoIdsCheques = str_replace(",,", ",", $idsCheq);


$sqlChe= "UPDATE cheques SET usado='SI' where id IN (".$resultadoIdsCheques.")";


		  mysqli_query($conexion,$sqlChe);}


// actualizo los vehiculos que fueron usado en la preventa como pago
if(strlen($listaIdVehiculosCanje)>0){

		mysqli_set_charset($conexion,'utf8'); 

			$idsAu=trim($listaIdVehiculosCanje, ',');
			$resultadoIdsA = str_replace(",,", ",", $idsAu);


$sqla= "UPDATE vehiculos SET usado_como_pago=1 where id IN (".$resultadoIdsA.")";


		  mysqli_query($conexion,$sqla);}









////////busco el ultimo registro por el id real no de la bd


 	$sqlinsertMysql1="SELECT id,id_real_preventa from operacion_preventa order by id_real_preventa DESC limit 1";


 	$resultadoUl = mysqli_query($conexion,$sqlinsertMysql1);
 	$verUlt= mysqli_fetch_array($resultadoUl);



if($idRegPreVenta==''){ //esto indica que se va generar una nuevo orden pre venta

	
	$valor= $verUlt[1]+1;







 }
 else{ //esta modificando una orden
	
	


	$sqlinsertMysql2="SELECT id,id_real_preventa,edicion,id_vendedor,id_cliente,id_vehiculo_prevendido,id_prendario,id_personal
	 from operacion_preventa where id='$idRegPreVenta'";


 	$resultado1 = mysqli_query($conexion,$sqlinsertMysql2);
	 $ver1= mysqli_fetch_array($resultado1);
	 


	 $sqlprendar= "UPDATE creditos_prendarios SET estado='2' where id='$ver1[6]'  ";


	 mysqli_query($conexion,$sqlprendar);
   
	 $sqlpersonal= "UPDATE creditos_personal SET estado='2' where id='$ver1[7]' ";


	 mysqli_query($conexion,$sqlpersonal);

	 


 	$valorEdicion=$ver1[2]+1;
 	$valor=$ver1[1];

 	$idVendedor=$ver1[3];
 	$idCliente=$ver1[4];
 	$idVehiculo=$ver1[5];


 }




 $nombreArchivo= 'orden_preventa_'.$fechaDeHoy.'.pdf';
 $cadena='./procesos/preVentas/'.$nombreArchivo;








$sql= "INSERT INTO operacion_preventa(observaciones,id_vendedor,id_cliente,id_vehiculo_prevendido,
fecha_carga_preventa,entidad_prendaria,monto_prendario,monto_sellado,efectivo_entregado,
costo_transferencia,costo_informe,comision_vendedor, id_usados_entregados,id_cheques_entregados,
id_caja,saldo_final_preventa,id_real_preventa,edicion,id_usuario_logueado,nombre_archivo,
entidad_prendario_personal,monto_personal,medio_contacto,id_prendario,id_personal) 
VALUES ('$observaciones', '$idVendedor', '$idCliente', '$idVehiculo', '$fechaSeteadaPreVenta',
		'$idEntidadCreditoPrendario', '$montoPrendario', '$montoSellado', '$efectivoEntregado',
		'$costoDeLaTransferencia', '$costoDeInformes', '$comisionDelVendedor', '$listaIdVehiculosCanje',
		'$chequesComoPago','$idCajaSetear','$saldoFinalAPagar','$valor','$valorEdicion','$_SESSION[idC]',
		'$nombreArchivo','$idEntidadCreditoPersonal','$montoPersonal','$medio','$idCrediPre','$idCrediPersonal')";



		
		  mysqli_query($conexion,$sql);


// aca inserto los registros en la tabla link cheques
$arregloC= explode(",", $resultadoIdsCheques);

      $cadenac='';

        foreach ($arregloC as &$valor2){


        $cadenac=$cadenac."('$valorEdicion','$valor','$valor2'),";


        }

      $myStringc = substr($cadenac, 0, -1);


      $sqlLinkC="INSERT INTO link_cheques_entregados_preventa(edicion,id_real_preventa,id_cheque) values".$myStringc;

      mysqli_query($conexion,$sqlLinkC);




// aca inserto los registros en la tabla link usados
$arreglo= explode(",", $resultadoIdsAutos);

      $cadena4='';

        foreach ($arreglo as &$valor1){


        $cadena4=$cadena4."('$valorEdicion','$valor','$valor1'),";


        }

      $myString = substr($cadena4, 0, -1);


      $sqlLink="INSERT INTO link_usados_entregados_preventa(edicion,id_real_preventa,id_vehiculo_usado) values".$myString;

      mysqli_query($conexion,$sqlLink);




		 $sqlInsEs="INSERT INTO cambios_estados_vehiculo(id_vehiculo,id_estado_previo,id_usuario_logueado) values('$idVehiculo',2,'$_SESSION[idC]') ";

		  mysqli_query($conexion,$sqlInsEs);




if($saldoFinalAPagar>'0'){

	$sqlUV ="UPDATE vehiculos SET id_estado = '3' WHERE id = '$idVehiculo'";
}
else{

	$sqlUV ="UPDATE vehiculos SET id_estado = '4' WHERE id = '$idVehiculo'";

}



		  
		

 if(mysqli_query($conexion,$sqlUV)){


    if ($_SESSION['permisos']!='3') {
        echo "<script>
 	
	 
	window.location.href='gestionarPagos.php';


	</script>";
	}
	else{
		echo "<script>
 	
	 
		window.location.href='preVenta.php?datos33='+ btoa(0);
	
	
		</script>";
	}
	// window.location.href='preVenta.php?datos33='+ btoa(0);
	
 }else{
	
	echo "<script>alert('No se pudo cargar la orden.');</script>";

 }





 $sqlParaPdf="SELECT u.nombre as nombreV,u.apellido as apellidoV,cl.nombre as nombreC,cl.apellido as apellidoC,v.dominio_patente as patente,v.modelo as modelo ,v.marca as marca, cl.telefono as telefono,v.color as color, o.id_usados_entregados as usadosEntregados, v.precio_venta as precioVenta from operacion_preventa o,usuarios u,clientes cl,vehiculos v where  o.id_vendedor=u.id  and o.id_cliente=cl.id and o.id_vehiculo_prevendido=v.id  and o.id_real_preventa='$valor' and o.edicion='$valorEdicion'";


 	


 	$resultadoParaPdf = mysqli_query($conexion,$sqlParaPdf);
 	$verEnPdf= mysqli_fetch_array($resultadoParaPdf);




 $sqlParaVehiculosEntregados="SELECT v.marca as marcaU,v.modelo as modeloU,v.dominio_patente as patenteU,v.precio_compra as pCompraU  from link_usados_entregados_preventa l,vehiculos v where l.id_vehiculo_usado=v.id and l.id_real_preventa='$valor' and l.edicion='$valorEdicion'";


 	


 	$resultadoParaVehiculosEntregados = mysqli_query($conexion,$sqlParaVehiculosEntregados);
 	


 $sqlParaChequesEntregados="SELECT v.numero_cheque as numeroCheque, v.monto as montoCheque, v.fecha_cobro as fechaCoChe  from link_cheques_entregados_preventa l,cheques v where l.id_cheque=v.id and l.id_real_preventa='$valor' and l.edicion='$valorEdicion'";


 	// te fala completar con la lista de autos que podria entregar y cheques


 	$resultadoParaChequesEntregados = mysqli_query($conexion,$sqlParaChequesEntregados);


		

//creacion del pdf con formato y campos asignados
 $pdf= new FPDF('P','mm','A4'); //(L horizontal P vertical,unidad de medida,tamaño A4 A3 etc)



 $pdf->AddPage();

 $fechaActual= getdate();



 $pdf->Image('documentation/img/logoCon.png',10,7,45);   // 10 del costado izquierdo y 7 de arriba
 $yimg= $pdf->GetY();
 $ximg= $pdf->GetX();

 $pdf->SetX(40);
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(105,8,'SANTA FE,  '.$fechaActual['mday'].'-'.$fechaActual['mon'].'-'.$fechaActual['year'],0,0,'C');

 $xtxtSan=$pdf->GetX();

 $pdf->SetX($xtxtSan+10);
 $pdf->SetFont('Arial','',10);
  $pdf->Cell(60,8,'ORDEN Nro: '."$valor".'/'."$valorEdicion",0,0,'C');
 //$pdf->Cell(50,8,'ORDEN Nro: 213213 ',0,0,'C');


$pdf->SetFont('Arial','B',12);

 $pdf -> SetXY($ximg+25,$yimg+10);
 $pdf->Cell(130,8,' PRE-VENTA',0,1,'C');
 $yord= $pdf->GetY();


 $pdf->Line(10,$yord,200,$yord);
 $pdf->SetTextColor(0,0,0);
 $yline= $pdf->GetY($pdf);
// // aca empieza lo que esta debajo de la primer linea negra divisora



 $pdf->SetXY(10,$yline+2);
 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,'Vendedor:',0,0,'L');
 $xan= $pdf->GetX();


 $pdf->SetX($xan+10);
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(20,6,utf8_decode($verEnPdf['nombreV'].' '.$verEnPdf['apellidoV']),0,1,'L');
// $pdf->Cell(20,6,'detalles del vendedorrrr',0,1,'L');



// // aca comienza donde hay 2 columnas espaceadas

 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,'Cliente:',0,0,'L');
 $xagencia= $pdf->GetX();

 $pdf->SetX($xagencia+10);
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(20,6,utf8_decode($verEnPdf['nombreC'].' '.$verEnPdf['apellidoC']),0,0,'L');
// $pdf->Cell(20,6,'detalle clienteeee',0,0,'L');

 $pdf->SetX($xagencia+90);
 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(22,6,'Telefono:',0,0,'L');

 $pdf->SetX($xagencia+120);
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(20,6,$verEnPdf['telefono'],0,1,'L');

// $pdf->Cell(20,6,'telefonoo',0,1,'L');


 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Vehículo Vendido:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($verEnPdf['marca'].' '.$verEnPdf['modelo']),0,0,'L');



 $pdf->SetX($xproductor+90);
 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(22,6,'Precio Venta:',0,0,'L');

 $pdf->SetX($xproductor+120);
 $pdf->SetFont('Arial','',10);
 // $pdf->Cell(20,6,"$codProductorVendedor",0,1,'L');
 $pdf->Cell(20,6,$verEnPdf['precioVenta'],0,1,'L');




 $pdf->SetX(125);
 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(22,6,'Dominio:',0,0,'L');

 $pdf->SetX(155);
 $pdf->SetFont('Arial','',10);
// // $pdf->Cell(20,6,$mostrarCorredor['cuit'],0,1,'L');
 $pdf->Cell(20,6,utf8_decode($verEnPdf['patente']),0,1,'L');
 $ypate=$pdf->GetY();


$yord= $pdf->GetY();


 $pdf->Line(10,$yord+5,200,$yord+5);
 $pdf->SetTextColor(0,0,0);
 // $yline= $pdf->GetY($pdf);


if($resultadoIdsAutos!= ''){
$pdf->SetY($ypate+10);
 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Usados Entregados:'),0,1,'L');
 $xproductor= $pdf->GetX();




///acaaa arranca lo de los vehiculos entregados

while ($verEnPdfVehiculosEntregados=mysqli_fetch_array($resultadoParaVehiculosEntregados)) {





 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Vehículo:'),0,0,'L');
 $xproductor= $pdf->GetX();



$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($verEnPdfVehiculosEntregados['marcaU'].' '.$verEnPdfVehiculosEntregados['modeloU'].' '.$verEnPdfVehiculosEntregados['patenteU']),0,0,'L');



 $pdf->SetX($xproductor+90);
 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(22,6,'Precio Toma:',0,0,'L');

 $pdf->SetX($xproductor+120);
 $pdf->SetFont('Arial','',10);
 // $pdf->Cell(20,6,"$codProductorVendedor",0,1,'L');
 $pdf->Cell(20,6,$verEnPdfVehiculosEntregados['pCompraU'],0,1,'L');
}
}



if($resultadoIdsCheques!=''){
 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Cheques Entregados:'),0,1,'L');
 $xproductor= $pdf->GetX();





while ($verEnPdfChequesEntregados=mysqli_fetch_array($resultadoParaChequesEntregados)) {





 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Cheque:'),0,0,'L');
 $xproductor= $pdf->GetX();



$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($verEnPdfChequesEntregados['numeroCheque'].'     '.$verEnPdfChequesEntregados['fechaCoChe']),0,0,'L');



 $pdf->SetX($xproductor+90);
 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(22,6,'Monto:',0,0,'L');

 $pdf->SetX($xproductor+120);
 $pdf->SetFont('Arial','',10);
 // $pdf->Cell(20,6,"$codProductorVendedor",0,1,'L');
 $pdf->Cell(20,6,$verEnPdfChequesEntregados['montoCheque'],0,1,'L');
}
}





if($montoPrendario!=0){


 $sqlParaCrePre="SELECT descripcion  from entidades_prendarias where id='$idEntidadCreditoPrendario'";


 	// te fala completar con la lista de autos que podria entregar y cheques


 	$resultadoParaCrepre = mysqli_query($conexion,$sqlParaCrePre);


 
 	$vercrePre= mysqli_fetch_array($resultadoParaCrepre);



 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Credito Prendario'),0,1,'L');
 $xproductor= $pdf->GetX();


 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Entidad:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($vercrePre['descripcion']),0,0,'L');

 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Monto Prendario:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($montoPrendario),0,0,'L');
 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Monto Sellado:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($montoSellado),0,1,'L');




}


if($montoPersonal!=0){


 $sqlParaCrePe="SELECT descripcion  from entidades_prendarias where id='$idEntidadCreditoPersonal'";


 	// te fala completar con la lista de autos que podria entregar y cheques


 	$resultadoParaCreper = mysqli_query($conexion,$sqlParaCrePe);


 
 	$vercrePe= mysqli_fetch_array($resultadoParaCreper);



 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Credito Personal'),0,1,'L');
 $xproductor= $pdf->GetX();


 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Entidad:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($vercrePe['descripcion']),0,0,'L');

 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Monto Personal:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($montoPersonal),0,1,'L');
 

}

$pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Entrega Efectivo:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($efectivoEntregado),0,1,'L');

$pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Observaciones:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($observaciones),0,1,'L');


$pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Medio de Contacto:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($medio),0,1,'L');



$pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Costo Transferencia:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($costoDeLaTransferencia),0,0,'L');

 $pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Costo Informes:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($costoDeInformes),0,1,'L');

$pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Comision Vendedor:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,utf8_decode($comisionDelVendedor),0,1,'L');

$pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Entrega Total:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);

 $entregaTotal=$verEnPdf['precioVenta']-$saldoFinalAPagar;
$pdf->Cell(20,6,utf8_decode($entregaTotal),0,1,'L');


$pdf->SetFont('Arial','U',10);
 $pdf->Cell(25,6,utf8_decode('Saldo:'),0,0,'L');
 $xproductor= $pdf->GetX();

$pdf->SetX($xproductor+10);
 $pdf->SetFont('Arial','',10);


$pdf->Cell(20,6,utf8_decode($saldoFinalAPagar),0,1,'L');








// //al nombre del archivo le podes agregar el id del usuario logueado



 $pdf->Close();


 $pdf->Output("F",$cadena);

 mysqli_close($conexion);


?>
