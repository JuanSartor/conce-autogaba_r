<?php

session_start();
require "../fpdf/fpdf.php";
include ("../clases/conexion.php");
require_once "../clases/crud.php";
$obj= new crud();


// aca deberia insertar el consumo y generar el pdf

$datos = array(
	$_POST['montoConsumo'],
	$_POST['descripcionConsumo'],
 	$_POST['fechaing'],
	$_POST['idTipoProveedor']);

// echo $obj->agregarConsumo($datos);
	
$fechaActual= getdate();

$fechaDeHoy=$fechaActual['mday'].'-'.$fechaActual['mon'].'-'.$fechaActual['year'].'-'.$fechaActual['hours'].'h-'.$fechaActual['minutes'].'m-'.$fechaActual['seconds'].'s';

$nombreArchivo="PagoProveedores -".$fechaDeHoy.".pdf";
$cadena='./pagosRealizados/'.$nombreArchivo;

$conexion= conectar();

 	$sql= "INSERT INTO operaciones_cajas(monto,tipo_operacion,descripcion,id_usuario,fecha_ingresada_por_usuario,id_proveedor,nombre_archivo) 
	  VALUES ('$datos[0]','CONSUMO','$datos[1]','$_SESSION[idC]','$datos[2]','$datos[3]','$nombreArchivo')";
			
	mysqli_query($conexion,$sql);
	mysqli_close($conexion);

	$conexion1= conectar();

	$sql1="SELECT * from usuarios where id='$_SESSION[idC]'";

	$resultado1 = mysqli_query($conexion1,$sql1);

	$verRtdo= mysqli_fetch_array($resultado1);

	mysqli_close($conexion1);


	$conexion2= conectar();


	$sql2="SELECT id FROM operaciones_cajas WHERE tipo_operacion='CONSUMO' ORDER by id desc limit 1";


	$resultado2 = mysqli_query($conexion2,$sql2);

	$verRtdoVari= mysqli_fetch_array($resultado2);

  mysqli_close($conexion2);


  $conexion3= conectar();

	$sql3="SELECT * FROM proveedores WHERE id= $datos[3]";

	$resultado3 = mysqli_query($conexion3,$sql3);

	$verRtdoProveedor= mysqli_fetch_array($resultado3);

  mysqli_close($conexion3);
  
  $fechaActual= getdate();

  $fechaDeHoy=$fechaActual['mday'].'-'.$fechaActual['mon'].'-'.$fechaActual['year'].'-'.$fechaActual['hours'].'h-'.$fechaActual['minutes'].'m-'.$fechaActual['seconds'].'s';

$nombreArchivo="PagoProveedores -".$fechaDeHoy.".pdf";

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
$pdf->Cell(10,10,'PAGO PROVEEDORES',0,0,'L');

$pdf->SetXY(120,13);
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(40,8,'Santa Fe,  '.$fechaActual['mday'].' / '.$fechaActual['mon'].' / '.$fechaActual['year'],0,0,'L');

$pdf->SetXY(180,13);
$pdf->SetFont('Helvetica','B',9);
$pdf->Cell(10,8,'Nro.: '.$verRtdoVari['id'],0,0,'C');

$pdf->Rect(10,41,190,25);

// ACA COMIENZA DATOS CLIENTE

$pdf->SetXY(12,43);
$pdf->SetFont('Helvetica','B',9);
$pdf->Cell(30,6,utf8_decode('Apellido y Nombre / Razón Social:'),0,0,'L');

$pdf->SetX(66);
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(20,6,utf8_decode($verRtdoProveedor['descripcion']),0,0,'L');

$pdf->SetXY(12,50);
$pdf->SetFont('Helvetica','B',9);
$pdf->Cell(15,6,'DNI / CUIT:',0,0,'L');

$pdf->SetX(31);
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(15,6,'-',0,1,'L');

$pdf->SetXY(12,57);
$pdf->SetFont('Helvetica','B',9);
$pdf->Cell(12,6,utf8_decode('Domicilio:'),0,0,'L');

$pdf->SetX(18);
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(20,6,'-',0,0,'L');

// DATOS DEL PAGO REALIZADO

$pdf->Rect(10,69,190,195);

$pdf->SetXY(12,75);
$pdf->SetFont('Helvetica','B',12);
$pdf->Cell(20,6,utf8_decode("CONCEPTO"),0,0,'L');

$pdf->SetXY(20,90);
$pdf->SetFont('Helvetica','',12);
$pdf->MultiCell(170,6,utf8_decode($datos[1]),0,'L');


$pdf->SetXY(100,248);
$pdf->SetFont('Helvetica','',14);
$pdf->Cell(22,6,'Importe Abonado:',0,0,'L');

$pdf->SetX(160);
$pdf->SetFont('Helvetica','B',14);
$pdf->Cell(20,6,'$ '.number_format($datos[0],2,',','.'),0,1,'R');

// PIE DEL COMPROBANTE
$pdf->SetXY(10,268);
$pdf->SetFont('Helvetica','BI',11);
$pdf->Cell(190,8,'Mail: administracion@autogaba.com      Movil: +54 342 595-1577 ',0,1,'C');



$pdf->Close();

$cadena='./pagosRealizados/'.$nombreArchivo;
$pdf->Output("F",$cadena);





?>