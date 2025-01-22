<?php
include ("clases/conexion.php");

$idvehiculo=$_POST['idVehiculo'];







$conexionVehiculo= conectar();

 mysqli_set_charset($conexionVehiculo,'utf8'); 


    $sqlcar= "SELECT  marca,modelo,dominio_patente from vehiculos where id='$idvehiculo'";



$resultadoMosVe=mysqli_query($conexionVehiculo,$sqlcar);

$valoresVeh = mysqli_fetch_array($resultadoMosVe);



   
$sqlc= "SELECT vehiculos.marca as marca, vehiculos.modelo as modelo, vehiculos.dominio_patente 
as dominio_patentee,operacion_preventa.id_real_preventa as idRealp,operacion_preventa.edicion as ed 
from vehiculos, operacion_preventa, pagos_preventa pp, usuarios u 
where pp.id_usuario_logueado=u.id and     pp.id_orden_preventa=operacion_preventa.id 
and vehiculos.id='$idvehiculo' and operacion_preventa.id_vehiculo_prevendido='$idvehiculo' 
and operacion_preventa.edicion=(SELECT MAX(operacion_preventa.edicion) from operacion_preventa 
where id_vehiculo_prevendido='$idvehiculo' and operacion_preventa.eliminado='0')";



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

 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'FECHA')
			->setCellValue('B1', 'MONTO')
			->setCellValue('C1', 'ENTIDAD')
			->setCellValue('D1', 'MONTO PRENDARIO')
			->setCellValue('E1', 'MONTO SELLADO')
			->setCellValue('F1', 'ENTIDAD PERSONAL')
			->setCellValue('G1', 'MONTO PERSONAL')
			->setCellValue('H1', 'EFECTIVO ENTREGADO')
			->setCellValue('I1', 'COSTO TRANSFERENCIA')
			->setCellValue('J1', 'COSTO INFORME')
			->setCellValue('K1', 'COMISION VENDEDOR')
            ->setCellValue('L1', 'OBSERVACION')
			->setCellValue('M1', 'DESCRIPCION')
			->setCellValue('N1', 'USUARIO')
			->setCellValue('O1', 'TIPO');
			
// Fuente de la primera fila en negrita
$boldArray = array('font' => array('bold' => true,'size'=>9,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
 
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($boldArray);		
	




			
//Ancho de las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);	
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);	
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);		
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);	
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);	
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(14);	
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(16);	
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(16);	
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12);			
 
/*Extraer datos de MYSQL*/
	


	$conexionLogueado= conectar();
    mysqli_set_charset($conexionLogueado,'utf8'); 
    


	$cel=2;//Numero de fila donde empezara a crear  el reporte


	// credito prendario
	$sqlCrepr="SELECT op.fecha_carga_preventa,op.monto_prendario,op.monto_sellado,op.entidad_prendaria,
    u.nombre,u.apellido,op.monto_personal,op.efectivo_entregado,op.costo_transferencia,op.costo_informe,
	op.comision_vendedor,op.observaciones,op.id,op.saldo_final_preventa from operacion_preventa op,usuarios u
	where op.id_usuario_logueado=u.id  and 
	op.id_vehiculo_prevendido='$idvehiculo' and op.eliminado='0' 
	and op.edicion= (SELECT MAX(operacion_preventa.edicion) from operacion_preventa 
where id_vehiculo_prevendido='$idvehiculo' and operacion_preventa.eliminado='0')";


	$queryCPre=mysqli_query($conexionLogueado,$sqlCrepr);
	$rowCpYpr=mysqli_fetch_array($queryCPre);



	if($rowCpYpr[12]!='0' and $rowCpYpr[12]!=null ){
	$sqlCrePersonal="SELECT ent.descripcion from operacion_preventa ope,entidades_prendarias ent where 
	ope.entidad_prendario_personal=ent.id and ope.id='$rowCpYpr[12]'";
	$queryCPersonal=mysqli_query($conexionLogueado,$sqlCrePersonal);
	$rowCPerso=mysqli_fetch_array($queryCPersonal);
	}
	else{
		$rowCPerso[0]='';
	}

	if($rowCpYpr[3]!='0' and $rowCpYpr[3]!=null ){
		$sqlCrePre="SELECT ent.descripcion from operacion_preventa ope,entidades_prendarias ent where 
		ope.entidad_prendario_personal=ent.id and ope.id='$rowCpYpr[3]'";
		$queryCPre=mysqli_query($conexionLogueado,$sqlCrePre);
		$rowCPre=mysqli_fetch_array($queryCPre);
		}
		else{
			$rowCPre[0]='';
		}





	
	
		$fechaPr=$rowCpYpr[0];
		$monto=$rowCpYpr[13];
		$entidad=$rowCPre[0];
		$montoPrendario=$rowCpYpr[1];
		$montoSellado=$rowCpYpr[2];
		$entidadPersonal=$rowCPerso[0]; 
		$montoPersonal=$rowCpYpr[6];
		$efectiEntregado=$rowCpYpr[7];
		$costoTransf=$rowCpYpr[8];
		$costoInforme=$rowCpYpr[9];
		$comVendedor=$rowCpYpr[10];
		$observaci=$rowCpYpr[11];
		$descripcion=$valoresVeh['dominio_patente'];
		$usuario=$rowCpYpr[4].' '.$rowCpYpr[5];
		$tipo="PREVENTA";
			$aa="A".$cel;
			$ba="B".$cel;
			$ca="C".$cel;
			$da="D".$cel;
			$ea="E".$cel;
			$fa="F".$cel;
			$ga="G".$cel;
			$ha="H".$cel;
			$ia="I".$cel;
			$ja="J".$cel;
			$ka="K".$cel;
			$la="L".$cel;
			$ma="M".$cel;
			$na="N".$cel;
			$oa="O".$cel;
			
			// Agregar datos
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($aa, $fechaPr)
			->setCellValue($ba, $monto)
			->setCellValue($ca, $entidad)
			->setCellValue($da, $montoPrendario)
			->setCellValue($ea, $montoSellado)
			->setCellValue($fa, $entidadPersonal)
			->setCellValue($ga, $montoPersonal)
			->setCellValue($ha, $efectiEntregado)
			->setCellValue($ia, $costoTransf)
			->setCellValue($ja, $costoInforme)
			->setCellValue($ka, $comVendedor)
			->setCellValue($la, $observaci)
			->setCellValue($ma, $descripcion)
			->setCellValue($na, $usuario)
			->setCellValue($oa, $tipo);
					
			$cel+=1;
	
	

////////////////////////// pagos


			$sqllog= "SELECT vehiculos.marca as marca, vehiculos.modelo as modelo, vehiculos.dominio_patente 
			as dominio_patente,operacion_preventa.monto_personal,operacion_preventa.id_real_preventa as idRealp,
			operacion_preventa.edicion as ed,pp.monto as monto, pp.descripcion as desccrip,
			pp.fecha_seteada_pago as fechaus, pp.tipo_ingreso as tipoIngreso, u.nombre as nombreu,
			u.apellido as apellidou from vehiculos, operacion_preventa, pagos_preventa pp, usuarios u 
			where pp.id_usuario_logueado=u.id and    pp.id_orden_preventa=operacion_preventa.id 
			and vehiculos.id='$idvehiculo' and pp.eliminado='NO' and operacion_preventa.id_vehiculo_prevendido='$idvehiculo' 
			and operacion_preventa.edicion=(SELECT MAX(operacion_preventa.edicion) from operacion_preventa 
			where id_vehiculo_prevendido='$idvehiculo' and operacion_preventa.eliminado='0')";
		
			$query=mysqli_query($conexionLogueado,$sqllog);


	
	while ($row=mysqli_fetch_array($query)){
		$countryCode=$row['fechaus'];
		$countryName=$row['monto'];
		$currencyCode=$row['tipoIngreso'];
		$capital=$row['desccrip'];
		$continentName=$row['nombreu'].' '.$row['apellidou'];


		
			$a="A".$cel;
			$b="B".$cel;
			$c="L".$cel;
			$d="M".$cel;
			$e="N".$cel;
			$f="O".$cel;
			// Agregar datos
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($a, $countryCode)
            ->setCellValue($b, $countryName)
            ->setCellValue($c, $currencyCode)
            ->setCellValue($d, $capital)
			->setCellValue($e, $continentName)
			->setCellValue($f, "PAGO");
	$cel+=1;
	}
 





 
// autos entregados como pago
 $sqlParaVehiculosEntregados="SELECT v.marca as marcaU,v.modelo as modeloU,v.dominio_patente as patenteU,
 v.precio_compra as pCompraU, o.fecha_carga_preventa as fecha, u.nombre as nombre, u.apellido as apellido  from
  link_usados_entregados_preventa l,vehiculos v, operacion_preventa o, usuarios u 
  where u.id=o.id_usuario_logueado and  l.id_vehiculo_usado=v.id and o.eliminado='0' 
  and o.id_vehiculo_prevendido='$idvehiculo' and l.id_real_preventa=o.id_real_preventa and o.edicion=l.edicion
  and o.edicion=(SELECT MAX(operacion_preventa.edicion) from operacion_preventa 
  where id_vehiculo_prevendido='$idvehiculo' and operacion_preventa.eliminado='0')";


$queryA=mysqli_query($conexionLogueado,$sqlParaVehiculosEntregados);


	
while ($row=mysqli_fetch_array($queryA)){
	$countryCode=$row['fecha'];
	$countryName=$row['pCompraU'];
	$currencyCode=$row['marcaU'].' '.$row['modeloU'];
	$capital=$row['patenteU'];
	$continentName=$row['nombre'].' '.$row['apellido'];
	
		$aa="A".$cel;
		$ba="B".$cel;
		$ca="L".$cel;
		$da="M".$cel;
		$ea="N".$cel;
		$fa="O".$cel;
		// Agregar datos
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue($aa, $countryCode)
		->setCellValue($ba, $countryName)
		->setCellValue($ca, $currencyCode)
		->setCellValue($da, $capital)
		->setCellValue($ea, $continentName)
		->setCellValue($fa, "USADO");
		$cel+=1;
		

}



// cheques entregados


$sqlParaChequesEntregados="SELECT v.numero_cheque as numeroCheque, v.monto as montoCheque, v.fecha_cobro
 as fechaCoChe, o.fecha_carga_preventa as fecha, u.nombre as nombre, u.apellido as apellido   from link_cheques_entregados_preventa l,cheques v, operacion_preventa o, usuarios u  
 where l.id_cheque=v.id and  o.id_vehiculo_prevendido='$idvehiculo' and o.eliminado='0'
 and o.edicion=l.edicion and u.id=o.id_usuario_logueado and l.id_real_preventa=o.id_real_preventa
 and o.edicion=(SELECT MAX(operacion_preventa.edicion) from operacion_preventa 
  where id_vehiculo_prevendido='$idvehiculo' and operacion_preventa.eliminado='0')";

$queryCh=mysqli_query($conexionLogueado,$sqlParaChequesEntregados);


while ($row=mysqli_fetch_array($queryCh)){
	$countryCode=$row['fecha'];
	$countryName=$row['montoCheque'];
	$currencyCode=$row['numeroCheque'];
	$capital=$row['fechaCoChe'];
	$continentName=$row['nombre'].' '.$row['apellido'];
	
		$aa="A".$cel;
		$ba="B".$cel;
		$ca="L".$cel;
		$da="M".$cel;
		$ea="N".$cel;
		$fa="O".$cel;
		// Agregar datos
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue($aa, $countryCode)
		->setCellValue($ba, $countryName)
		->setCellValue($ca, $currencyCode)
		->setCellValue($da, $capital)
		->setCellValue($ea, $continentName)
		->setCellValue($fa, "CHEQUE");
		$cel+=1;
		

}


// falta la opcion de eliminar el gasto
$conexionLogueado= conectar();
mysqli_set_charset($conexionLogueado,'utf8'); 
$sqllog= "SELECT g.fecha_ingresada_por_usuario fechaaa,g.monto montoo,p.descripcion prov,
g.descripcion descc,u.nombre nombre,u.apellido apellido from gastos_vehiculo g,proveedores p,usuarios u 
where p.id=g.id_proveedor and u.id=g.id_usuario_logueado and  id_vehiculo='$idvehiculo' ";

$query=mysqli_query($conexionLogueado,$sqllog);



while ($row=mysqli_fetch_array($query)){
	$countryCode=$row['fechaaa'];
	$countryName=$row['montoo'];
	$currencyCode=$row['prov'];
	$capital=$row['descc'];
	$continentName=$row['nombre'].' '.$row['apellido'];
	
		$aa="A".$cel;
		$ba="B".$cel;
		$ca="L".$cel;
		$da="M".$cel;
		$ea="N".$cel;
		$fa="O".$cel;
		// Agregar datos
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue($aa, $countryCode)
		->setCellValue($ba, $countryName)
		->setCellValue($ca, $currencyCode)
		->setCellValue($da, $capital)
		->setCellValue($ea, $continentName)
		->setCellValue($fa, "GASTO");
		$cel+=1;
		

}


/*Fin extracion de datos MYSQL*/
//  $rango="A2:$e";
//  $styleArray = array('font' => array( 'name' => 'Arial','size' => 10),
//  'borders'=>array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('argb' => 'FFF')))
//  );
//  $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray);
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