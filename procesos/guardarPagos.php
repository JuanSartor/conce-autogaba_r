<?php


require "../fpdf/fpdf.php";
include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();


// aca deberia guardar el pago y generar el comprobate

$datos = array(
	$_POST['monto'],
	$_POST['descripcion'],
	$_POST['idOrden'],
	$_POST['tipoIngresoS'],
	$_POST['fechaCargaCobro'],
	$_POST['numeroChequeP'],
	$_POST['fechaCobroChequeP'],
	$_POST['idEntidadChequeP']);

		// obtengo el saldo de la orden

		$conexion=conectar();

$sqlOb="SELECT saldo_final_preventa  FROM operacion_preventa WHERE id='$datos[2]' ";

$resultadoO = mysqli_query($conexion,$sqlOb);

	$verSaldo= mysqli_fetch_array($resultadoO);
	

		mysqli_free_result($resultadoO);
    mysqli_close($conexion);
    
		$saldoActualizado=$verSaldo[0]-$datos[0];

		$sql= "UPDATE operacion_preventa SET saldo_final_preventa='$saldoActualizado'  WHERE id='$datos[2]'";
		// acualizo saldo de orden de preventa

		$conexion1=conectar();

		 mysqli_query($conexion1,$sql);
		 mysqli_close($conexion1);
		
 $fechaActual= getdate();

 $fechaDeHoy=$fechaActual['mday'].'-'.$fechaActual['mon'].'-'.$fechaActual['year'].'-'.$fechaActual['hours'].'h-'.$fechaActual['minutes'].'m-'.$fechaActual['seconds'].'s';

$nombreArchivo="comprobantePago-".$fechaDeHoy.".pdf";
$cadena='./pagosRealizados/'.$nombreArchivo;

		// inserto registro de pago
		
$conexion2=conectar();
$sqlinser1= "INSERT INTO pagos_preventa(monto,descripcion,id_orden_preventa,saldo_previo_a_pago,
tipo_ingreso,fecha_seteada_pago,id_usuario_logueado,nombre_archivo) 
VALUES ('$datos[0]','$datos[1]','$datos[2]','$verSaldo[0]','$datos[3]','$datos[4]','$_SESSION[idC]','$nombreArchivo')";

	 mysqli_query($conexion2,$sqlinser1);

 mysqli_close($conexion2);

// aca verifico si paga con cheque, si es asi inserto en cheques y en link_cheques_como_pago
if($datos[3]=='2'){

$conexionChe=conectar();
$sqlUltPa="SELECT id FROM pagos_preventa ORDER BY id DESC limit 1";
$resulUltPa=mysqli_query($conexionChe,$sqlUltPa);	
$verDatosUltPa= mysqli_fetch_array($resulUltPa);

$sqlInSChe="INSERT INTO cheques(id_entidad,numero_cheque,monto,fecha_cobro,usado)
values('$datos[7]','$datos[5]','$datos[0]','$datos[6]','SI')";
mysqli_query($conexionChe,$sqlInSChe);

$sqlUltCH="SELECT id FROM cheques ORDER BY id DESC limit 1";
$resulUltChe=mysqli_query($conexionChe,$sqlUltCH);	
$verDatosUltCh= mysqli_fetch_array($resulUltChe);

$sqlInSLink="INSERT INTO link_cheques_como_pagos(id_cheque,id_pago)
values('$verDatosUltCh[id]','$verDatosUltPa[id]')";
mysqli_query($conexionChe,$sqlInSLink);

$sqlEntidad="SELECT descripcion from entidades_prendarias where id=$_POST[idEntidadChequeP]";
$resultEntidad=mysqli_query($conexionChe,$sqlEntidad);
$datosEntidad=mysqli_fetch_array($resultEntidad);

}

$conexion3=conectar();

	 $sqlObtenerDatos="SELECT vehiculos.marca as marca,vehiculos.modelo as modelo,vehiculos.dominio_patente as patente,clientes.nombre as nombreC,clientes.apellido as apellidoC,clientes.razonSocial as razonSocial,clientes.dni as dni,clientes.direccion as direccionC,usuarios.nombre as nombreU,usuarios.apellido as apellidoU, operacion_preventa.edicion as edicion, vehiculos.id as idVehi, pagop.id as idPago FROM clientes,operacion_preventa,usuarios,vehiculos,pagos_preventa pagop where pagop.id_orden_preventa=operacion_preventa.id and clientes.id=operacion_preventa.id_cliente AND operacion_preventa.id_vendedor=usuarios.id and operacion_preventa.id_vehiculo_prevendido=vehiculos.id   AND operacion_preventa.id=(SELECT id_orden_preventa FROM pagos_preventa ORDER BY pagos_preventa.id DESC limit 1) order by idPago desc";

	  $resultadoDatosParaCompletar=mysqli_query($conexion3,$sqlObtenerDatos);
	  $verDatosParaCompletar= mysqli_fetch_array($resultadoDatosParaCompletar);

	 // Cerrar la conexión
			mysqli_close($conexion3);



				if($saldoActualizado<=0){  // esto hago si el saldo ya da 0 o negativo paso el auto a vendido y seteo el registro de estados

					$fechaAc=date("Y-m-d");

			$sqlvend= "UPDATE vehiculos SET id_estado='4',fecha_vendido='$fechaAc'  WHERE id='$verDatosParaCompletar[idVehi]'";
	
		$conexionvend=conectar();

		 mysqli_query($conexionvend,$sqlvend);

		 $sqlInsEs="INSERT INTO cambios_estados_vehiculo(id_vehiculo,id_estado_previo,id_usuario_logueado) values('$verDatosParaCompletar[idVehi]',3,'$_SESSION[idC]') ";

		  mysqli_query($conexionvend,$sqlInsEs);


		 mysqli_close($conexionvend);

		}

			if($verDatosParaCompletar['dni']=='0'){
				$dniRazon=$verDatosParaCompletar['razonSocial'];
			}
				else{
				$dniRazon=$verDatosParaCompletar['dni'];		
				}


// creacion del pdf con formato y campos asignados
$pdf= new FPDF('P','mm','A4'); //(L horizontal P vertical,unidad de medida,tamaño A4 A3 etc)

$pdf->AddPage();

$pdf->Image('../documentation/img/logoCon.png',25,2,58,20);   // 10 del costado izquierdo y 7 de arriba

$pdf->Rect(10,4,190,36);
$pdf->Rect(97,4,15,15);
$pdf->SetFont('Helvetica','B',40);
$pdf->SetX(99);
$pdf->Cell(10,5,'X',0,0,'L');

$pdf->SetFont('Helvetica','B',9);
$pdf->SetXY(12,20);
$pdf->Cell(15,5,utf8_decode("Razón Social:"),0,0,'L');
$pdf->SetXY(35,20);
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(15,5,'AUTOGABA SRL',0,0,'L');

$pdf->SetFont('Helvetica','B',9);
$pdf->SetXY(120,30);
$pdf->Cell(15,5,utf8_decode("CUIT:"),0,0,'L');
$pdf->SetXY(130,30);
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(15,5,'33716153989',0,0,'L');

// $pdf->SetFont('Helvetica','B',9);
// $pdf->SetXY(120,30);
// $pdf->Cell(30,5,utf8_decode("Fecha de Inicio de Actividades:"),0,0,'L');
// $pdf->SetXY(168,30);
// $pdf->SetFont('Helvetica','',9);
// $pdf->Cell(15,5,'01/11/2019',0,0,'L');

$pdf->SetFont('Helvetica','B',9);
$pdf->SetXY(12,25);
$pdf->Cell(25,5,'Domicilio Comercial:',0,0,'L');
$pdf->SetXY(46,25);
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(40,5,'Gral. Lopez 3535 - Santa Fe, Santa Fe',0,0,'L');

$pdf->SetFont('Helvetica','B',9);
$pdf->SetXY(12,30);
$pdf->Cell(40,5,utf8_decode("Condición frente a IVA:"),0,0,'L');
$pdf->SetXY(50,30);
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(40,5,'IVA Responsable Inscripto',0,0,'L');

$pdf->SetFont('Helvetica','B',14);
$pdf->SetXY(120,5);
$pdf->Cell(10,10,'COMPROBANTE DE PAGO',0,0,'L');

$pdf->SetXY(120,13);
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(40,8,'Santa Fe,  '.$fechaActual['mday'].' / '.$fechaActual['mon'].' / '.$fechaActual['year'],0,0,'L');

$pdf->SetXY(180,13);
$pdf->SetFont('Helvetica','B',9);
$pdf->Cell(10,8,'Nro.: '.$verDatosParaCompletar['idPago'],0,0,'C');

$pdf->Rect(10,41,190,25);

// ACA COMIENZA DATOS CLIENTE

$pdf->SetXY(12,43);
$pdf->SetFont('Helvetica','B',9);
$pdf->Cell(30,6,utf8_decode('Apellido y Nombre / Razón Social:'),0,0,'L');

$pdf->SetX(66);
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(20,6,utf8_decode($verDatosParaCompletar['nombreC'].', '.$verDatosParaCompletar['apellidoC']),0,0,'L');

$pdf->SetXY(12,50);
$pdf->SetFont('Helvetica','B',9);
$pdf->Cell(15,6,'DNI / CUIT:',0,0,'L');

$pdf->SetX(31);
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(15,6,utf8_decode($dniRazon),0,1,'L');

$pdf->SetXY(12,57);
$pdf->SetFont('Helvetica','B',9);
$pdf->Cell(12,6,utf8_decode('Domicilio:'),0,0,'L');

$pdf->SetX(30);
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(20,6,utf8_decode($verDatosParaCompletar['direccionC']),0,0,'L');


// DATOS DEL VEHICULO

$pdf->Rect(10,69,190,195);

$pdf->SetXY(12,75);
$pdf->SetFont('Helvetica','B',12);
$pdf->Cell(20,6,utf8_decode("Descripción del Vehículo"),0,0,'L');

$pdf->SetXY(20,90);
$pdf->SetFont('Helvetica','B',12);
$pdf->Cell(8,6,utf8_decode("Marca: "),0,0,'L');
$pdf->SetX(38);
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(8,6,utf8_decode($verDatosParaCompletar['marca']),0,0,'L');

$pdf->SetXY(20,100);
$pdf->SetFont('Helvetica','B',12);
$pdf->Cell(8,6,utf8_decode("Modelo: "),0,0,'L');
$pdf->SetX(40);
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(30,6,utf8_decode($verDatosParaCompletar['modelo']),0,0,'L');

$pdf->SetXY(20,110);
$pdf->SetFont('Helvetica','B',12);
$pdf->Cell(8,6,utf8_decode("Dominio: "),0,0,'L');
$pdf->SetX(42);
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(15,6,utf8_decode($verDatosParaCompletar['patente']),0,0,'L');

$pdf->SetXY(12,130);
$pdf->SetFont('Helvetica','B',12);
$pdf->Cell(20,6,utf8_decode("Observaciones"),0,0,'L');

$pdf->SetXY(20,140);
$pdf->SetFont('Helvetica','',12);
if($datos[3]=='2')
{
	$contenido=$_POST['descripcion']."\n".$datosEntidad[0]."\n".'Nro.: '.$_POST['numeroChequeP']."\n".'Fecha de Cobro: '.$_POST['fechaCobroChequeP'];
}
else
{
	$contenido=$_POST['descripcion'];
};
$pdf->MultiCell(170,6,utf8_decode($contenido),0,'L');

// $pdf->SetXY(12,85);
// $pdf->SetFont('Helvetica','B',12);
// $pdf->Cell(20,6,utf8_decode($verDatosParaCompletar['marca'].' - '.$verDatosParaCompletar['modelo'].' - '.$verDatosParaCompletar['patente']),0,0,'L');

// $pdf->SetXY(8,85);
// $pdf->SetFont('Helvetica','',11);
// $pdf->Cell(20,6,$datos[2].'/'.$verDatosParaCompletar['edicion'],0,1,'L');
 
// $pdf->SetXY(80,90);
// $pdf->SetFont('Helvetica','',12);
// $pdf->Cell(22,6,'Saldo a la fecha:',0,0,'L');

// $pdf->SetX(150);
// $pdf->SetFont('Helvetica','B',12);
// $pdf->Cell(20,6,'$ '.number_format($verSaldo[0],2,',','.'),0,1,'R');

$pdf->SetXY(100,248);
$pdf->SetFont('Helvetica','',14);
$pdf->Cell(22,6,'Importe Abonado:',0,0,'L');

$pdf->SetX(160);
$pdf->SetFont('Helvetica','B',14);
$pdf->Cell(20,6,'$ '.number_format($_POST['monto'],2,',','.'),0,1,'R');

//$pdf->Rect(20,243,169,17);

// $pdf->SetXY(80,110);
// $pdf->SetFont('Helvetica','',12);
// $pdf->Cell(22,6,'Saldo Actual:',0,0,'L');

// $saldoActua=$verSaldo[0]-$_POST['monto'];

// $pdf->SetX(150);
// $pdf->SetFont('Helvetica','B',12);
// $pdf->Cell(20,6,'$ '.number_format($saldoActua,2,',','.'),0,1,'R');

// PIE DEL RECIBO
//$pdf->Rect(10,275,190,9);

$pdf->SetXY(10,268);
$pdf->SetFont('Helvetica','BI',11);
$pdf->Cell(190,8,'Mail: administracion@autogaba.com      Movil: +54 342 595-1577 ',0,1,'C');


$pdf->Close();

 
$pdf->Output('F',$cadena);


?>