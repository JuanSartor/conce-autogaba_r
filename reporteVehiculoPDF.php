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



 
 





			

 
/*Extraer datos de MYSQL*/
	


	$conexionLogueado= conectar();
    mysqli_set_charset($conexionLogueado,'utf8'); 
    



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
	
		

}


// falta la opcion de eliminar el gasto
$conexionLogueado= conectar();
mysqli_set_charset($conexionLogueado,'utf8'); 
$sqllog= "SELECT g.fecha_ingresada_por_usuario fechaaa,g.monto montoo,p.descripcion prov,
g.descripcion descc,u.nombre nombre,u.apellido apellido from gastos_vehiculo g,proveedores p,usuarios u 
where p.id=g.id_proveedor and u.id=g.id_usuario_logueado and  id_vehiculo='$idvehiculo' ";

$query=mysqli_query($conexionLogueado,$sqllog);



while ($row=mysqli_fetch_array($query)){
	

}






 ?> 