<?php
include ("clases/conexion.php");
if (PHP_SAPI == 'cli')
	die('Este ejemplo sólo se puede ejecutar desde un navegador Web');
 

$fechaI=$_POST['fechaInicio'];
$fechaF=$_POST['fechaFin'];






$conexionVehiculo= conectar();

 mysqli_set_charset($conexionVehiculo,'utf8'); 


    $sqlcar= "SELECT  marca,modelo,dominio_patente from vehiculos where id='$idvehiculo'";



$resultadoMosVe=mysqli_query($conexionVehiculo,$sqlcar);

$valoresVeh = mysqli_fetch_array($resultadoMosVe);





   

    $sqlc= "SELECT adsasa from pagos_preventa p,usuarios u,vehiculos v,operacion_preventa o where p.id_usuario_logueado=u.id and o.id=p.id_orden_preventa and v.id=o.id_vehiculo_prevendido  and     p.fecha_seteada_pago between '$fechaI ' and '$fechaF' ";

fecha BETWEEN '2016-03-20 15:00:00' AND '2016-03-20 18:00:00'

$resultadoV=mysqli_query($conexionVehiculo,$sqlc);

$valoresV = mysqli_fetch_array($resultadoV);

mysqli_close($conexionVehiculo);


/** Incluye PHPExcel */
// require_once dirname(__FILE__) . '/librerias/PHPExcel-1.8.php';

require_once "librerias/PHPExcel-1.8/Classes/PHPExcel.php";

// Crear nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
 
// Propiedades del documento
$objPHPExcel->getProperties()->setCreator("Obed Alvarado")
							 ->setLastModifiedBy("Obed Alvarado")
							 ->setTitle("Office 2010 XLSX Documento de prueba")
							 ->setSubject("Office 2010 XLSX Documento de prueba")
							 ->setDescription("Documento de prueba para Office 2010 XLSX, generado usando clases de PHP.")
							 ->setKeywords("office 2010 openxml php")
							 ->setCategory("Archivo con resultado de prueba");
 
 
 // primer sub tabla
// Combino las celdas desde A1 hasta E1
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:E4');
 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Desde:'.$fechaI.'   Hasta:'.$fechaF)
            ->setCellValue('A4', 'PAGOS')
            ->setCellValue('A5', 'FECHA')
            ->setCellValue('B5', 'MONTO')
            ->setCellValue('C5', 'TIPO DE INGRESO')
			->setCellValue('D5', 'DOMINIO')
			->setCellValue('E5', 'USUARIO');
			
// Fuente de la primera fila en negrita
$boldArray = array('font' => array('bold' => true,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
 
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($boldArray);		
$objPHPExcel->getActiveSheet()->getStyle('A5:E5')->applyFromArray($boldArray);	 
$objPHPExcel->getActiveSheet()->getStyle('A4:B4')->applyFromArray($boldArray);	
			
//Ancho de las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);	
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);	
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);			
 
/*Extraer datos de MYSQL*/
	


	$conexionLogueado= conectar();
    mysqli_set_charset($conexionLogueado,'utf8'); 
    $sqllog= "SELECT vehiculos.marca as marca, vehiculos.modelo as modelo, vehiculos.dominio_patente as dominio_patente,operacion_preventa.monto_personal,operacion_preventa.id_real_preventa as idRealp,operacion_preventa.edicion as ed,pp.monto as monto, pp.descripcion as desccrip, pp.fecha_seteada_pago as fechaus, pp.tipo_ingreso as tipoIngreso, u.nombre as nombreu, u.apellido as apellidou from vehiculos, operacion_preventa, pagos_preventa pp, usuarios u where pp.id_usuario_logueado=u.id and    pp.id_orden_preventa=operacion_preventa.id and vehiculos.id='$idvehiculo' and operacion_preventa.id_vehiculo_prevendido='$idvehiculo' and operacion_preventa.edicion=(SELECT MAX(operacion_preventa.edicion) from operacion_preventa where id_vehiculo_prevendido='$idvehiculo')";

    $query=mysqli_query($conexionLogueado,$sqllog);


	$cel=6;//Numero de fila donde empezara a crear  el reporte
	while ($row=mysqli_fetch_array($query)){
		$countryCode=$row['fechaus'];
		$countryName=$row['monto'];
		$currencyCode=$row['tipoIngreso'];
		$capital=$row['desccrip'];
		$continentName=$row['nombreu'].' '.$row['apellidou'];


		
			$a="A".$cel;
			$b="B".$cel;
			$c="C".$cel;
			$d="D".$cel;
			$e="E".$cel;
			// Agregar datos
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($a, $countryCode)
            ->setCellValue($b, $countryName)
            ->setCellValue($c, $currencyCode)
            ->setCellValue($d, $capital)
			->setCellValue($e, $continentName);
			
	$cel+=1;
	}
 



// segunda sub tabla

$celPa=$cel+3;
$p1='A'.$celPa;
$p2='E'.$celPa;

$cel2=$celPa+1;
$a2='A'.$cel2;
$b='B'.$cel2;
$c='C'.$cel2;
$d='D'.$cel2;
$e='E'.$cel2;

$objPHPExcel->setActiveSheetIndex(0)->mergeCells($p1.':'.$p2);
 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($p1, 'GASTOS')
            ->setCellValue($a2, 'FECHA')
            ->setCellValue($b, 'MONTO')
            ->setCellValue($c, 'PROVEEDOR')
			->setCellValue($d, 'DOMINIO')
			->setCellValue($e, 'USUARIO');
			
// Fuente de la primera fila en negrita
$boldArray = array('font' => array('bold' => true,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
 
$objPHPExcel->getActiveSheet()->getStyle($p1.':'.$e)->applyFromArray($boldArray);		
 
	
			
//Ancho de las columnas
// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);	
// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);	
// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);	
// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);	
// $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);			
 
/*Extraer datos de MYSQL*/
	


	$conexionLogueado= conectar();
    mysqli_set_charset($conexionLogueado,'utf8'); 
    $sqllog= "SELECT g.fecha_ingresada_por_usuario fechaaa,g.monto montoo,p.descripcion prov,g.descripcion descc,u.nombre nombre,u.apellido apellido from gastos_vehiculo g,proveedores p,usuarios u where p.id=g.id_proveedor and u.id=g.id_usuario_logueado and  id_vehiculo='$idvehiculo'";

    $query=mysqli_query($conexionLogueado,$sqllog);


	$cel3=$celPa+2;//Numero de fila donde empezara a crear  el reporte
	while ($row=mysqli_fetch_array($query)){
		$countryCode=$row['fechaaa'];
		$countryName=$row['montoo'];
		$currencyCode=$row['prov'];
		$capital=$row['descc'];
		$continentName=$row['nombre'].' '.$row['apellido'];
		
			$aa="A".$cel3;
			$ba="B".$cel3;
			$ca="C".$cel3;
			$da="D".$cel3;
			$ea="E".$cel3;
			// Agregar datos
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($aa, $countryCode)
            ->setCellValue($ba, $countryName)
            ->setCellValue($ca, $currencyCode)
            ->setCellValue($da, $capital)
			->setCellValue($ea, $continentName);
			
	$cel3+=1;
	}







/*Fin extracion de datos MYSQL*/
 $rango="A2:$e";
 $styleArray = array('font' => array( 'name' => 'Arial','size' => 10),
 'borders'=>array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('argb' => 'FFF')))
 );
 $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray);
// Cambiar el nombre de hoja de cálculo
$objPHPExcel->getActiveSheet()->setTitle('Reporte de vehiculo');
 
 
// Establecer índice de hoja activa a la primera hoja , por lo que Excel abre esto como la primera hoja
$objPHPExcel->setActiveSheetIndex(0);
 
 
// Redirigir la salida al navegador web de un cliente ( Excel5 )
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=reporteVehiculo-dominio='.$valoresVeh['dominio_patente'].'.xls');
header('Cache-Control: max-age=0');
// Si usted está sirviendo a IE 9 , a continuación, puede ser necesaria la siguiente
header('Cache-Control: max-age=1');
 
// Si usted está sirviendo a IE a través de SSL , a continuación, puede ser necesaria la siguiente
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

 ?> 