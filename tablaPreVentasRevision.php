<?php
session_start();
include ("clases/conexion.php");


// 0 -->	En revisión
// 1 -->	Aprobada
// 2 -->	Rechazada
// 3 -->	Modificar


$conexion=conectar();

if ($_SESSION["permisos"]!='3') {
    switch ($_GET['pme']) {

    case 't':{
        
// con esta consulta obtengo el registro con mayor edicion es decir la ultima edicion guardada

        $sql="SELECT operacion_preventa.id,vehiculos.modelo,vehiculos.dominio_patente,
		operacion_preventa.id_real_preventa,operacion_preventa.fecha_carga_preventa,operacion_preventa.estado_aprobacion,
		usuarios.nombre,usuarios.apellido
		 FROM vehiculos,clientes,usuarios,operacion_preventa,(SELECT id_real_preventa,id 
		from operacion_preventa o where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
		where o.id_real_preventa=operacion_preventa.id_real_preventa group by id_real_preventa )) as r 
		where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
		and operacion_preventa.id_cliente=clientes.id and operacion_preventa.estado_orden='SINCANCELAR' 
		and operacion_preventa.eliminado='0' and vehiculos.id_estado!='4' 
		 and operacion_preventa.id_vendedor=usuarios.id";

 break;
 }
    case 'en':{

        $sql="SELECT operacion_preventa.id,vehiculos.modelo,vehiculos.dominio_patente,
		operacion_preventa.id_real_preventa,operacion_preventa.fecha_carga_preventa,operacion_preventa.estado_aprobacion,
		usuarios.nombre,usuarios.apellido
		 FROM vehiculos,clientes,usuarios,operacion_preventa,(SELECT id_real_preventa,id 
		from operacion_preventa o where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
		where o.id_real_preventa=operacion_preventa.id_real_preventa group by id_real_preventa )) as r 
		where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
		and operacion_preventa.id_cliente=clientes.id and operacion_preventa.estado_orden='SINCANCELAR' 
		and operacion_preventa.eliminado='0' and vehiculos.id_estado!='4' 
		 and operacion_preventa.id_vendedor=usuarios.id and operacion_preventa.estado_aprobacion='0'";

    break;

    }
    case 'a':{

        $sql="SELECT operacion_preventa.id,vehiculos.modelo,vehiculos.dominio_patente,
		operacion_preventa.id_real_preventa,operacion_preventa.fecha_carga_preventa,operacion_preventa.estado_aprobacion,
		usuarios.nombre,usuarios.apellido
		 FROM vehiculos,clientes,usuarios,operacion_preventa,(SELECT id_real_preventa,id 
		from operacion_preventa o where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
		where o.id_real_preventa=operacion_preventa.id_real_preventa group by id_real_preventa )) as r 
		where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
		and operacion_preventa.id_cliente=clientes.id and operacion_preventa.estado_orden='SINCANCELAR' 
		and operacion_preventa.eliminado='0' and vehiculos.id_estado!='4' 
		 and operacion_preventa.id_vendedor=usuarios.id and operacion_preventa.estado_aprobacion='1'";

    break;

    }
    case 'r':{

        $sql="SELECT operacion_preventa.id,vehiculos.modelo,vehiculos.dominio_patente,
		operacion_preventa.id_real_preventa,operacion_preventa.fecha_carga_preventa,operacion_preventa.estado_aprobacion,
		usuarios.nombre,usuarios.apellido
		 FROM vehiculos,clientes,usuarios,operacion_preventa,(SELECT id_real_preventa,id 
		from operacion_preventa o where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
		where o.id_real_preventa=operacion_preventa.id_real_preventa group by id_real_preventa )) as r 
		where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
		and operacion_preventa.id_cliente=clientes.id and operacion_preventa.estado_orden='SINCANCELAR' 
		 and vehiculos.id_estado!='4' 
		 and operacion_preventa.id_vendedor=usuarios.id and operacion_preventa.estado_aprobacion='2'";

    break;

    }
    case 'm':{

        $sql="SELECT operacion_preventa.id,vehiculos.modelo,vehiculos.dominio_patente,
		operacion_preventa.id_real_preventa,operacion_preventa.fecha_carga_preventa,operacion_preventa.estado_aprobacion,
		usuarios.nombre,usuarios.apellido
		 FROM vehiculos,clientes,usuarios,operacion_preventa,(SELECT id_real_preventa,id 
		from operacion_preventa o where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
		where o.id_real_preventa=operacion_preventa.id_real_preventa group by id_real_preventa )) as r 
		where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
		and operacion_preventa.id_cliente=clientes.id and operacion_preventa.estado_orden='SINCANCELAR' 
		and operacion_preventa.eliminado='0' and vehiculos.id_estado!='4' 
		 and operacion_preventa.id_vendedor=usuarios.id and operacion_preventa.estado_aprobacion='3'";

    break;

    }

 }
}
else{ // aca ingresa si es un vendedor
	switch ($_GET['pme']) {

		case 't':{
			
	// con esta consulta obtengo el registro con mayor edicion es decir la ultima edicion guardada
	
			$sql="SELECT operacion_preventa.id,vehiculos.modelo,vehiculos.dominio_patente,
			operacion_preventa.id_real_preventa,operacion_preventa.fecha_carga_preventa,operacion_preventa.estado_aprobacion,
			usuarios.nombre,usuarios.apellido
			 FROM vehiculos,clientes,usuarios,operacion_preventa,(SELECT id_real_preventa,id 
			from operacion_preventa o where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
			where o.id_real_preventa=operacion_preventa.id_real_preventa group by id_real_preventa )) as r 
			where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
			and operacion_preventa.id_cliente=clientes.id and operacion_preventa.estado_orden='SINCANCELAR' 
			and operacion_preventa.eliminado='0' and vehiculos.id_estado!='4' 
			 and operacion_preventa.id_vendedor='$_SESSION[idC]' and usuarios.id='$_SESSION[idC]' ";
	
	 break;
	 }
		case 'en':{
	
			$sql="SELECT operacion_preventa.id,vehiculos.modelo,vehiculos.dominio_patente,
			operacion_preventa.id_real_preventa,operacion_preventa.fecha_carga_preventa,operacion_preventa.estado_aprobacion,
			usuarios.nombre,usuarios.apellido
			 FROM vehiculos,clientes,usuarios,operacion_preventa,(SELECT id_real_preventa,id 
			from operacion_preventa o where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
			where o.id_real_preventa=operacion_preventa.id_real_preventa group by id_real_preventa )) as r 
			where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
			and operacion_preventa.id_cliente=clientes.id and operacion_preventa.estado_orden='SINCANCELAR' 
			and operacion_preventa.eliminado='0' and vehiculos.id_estado!='4' 
			 and operacion_preventa.id_vendedor='$_SESSION[idC]' and usuarios.id='$_SESSION[idC]' 
			  and operacion_preventa.estado_aprobacion='0'";
	
		break;
	
		}
		case 'a':{
	
			$sql="SELECT operacion_preventa.id,vehiculos.modelo,vehiculos.dominio_patente,
			operacion_preventa.id_real_preventa,operacion_preventa.fecha_carga_preventa,operacion_preventa.estado_aprobacion,
			usuarios.nombre,usuarios.apellido
			 FROM vehiculos,clientes,usuarios,operacion_preventa,(SELECT id_real_preventa,id 
			from operacion_preventa o where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
			where o.id_real_preventa=operacion_preventa.id_real_preventa group by id_real_preventa )) as r 
			where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
			and operacion_preventa.id_cliente=clientes.id and operacion_preventa.estado_orden='SINCANCELAR' 
			and operacion_preventa.eliminado='0' and vehiculos.id_estado!='4' 
			 and operacion_preventa.id_vendedor='$_SESSION[idC]' and usuarios.id='$_SESSION[idC]' 
			  and operacion_preventa.estado_aprobacion='1'";
	
		break;
	
		}
		case 'r':{
	
			$sql="SELECT operacion_preventa.id,vehiculos.modelo,vehiculos.dominio_patente,
			operacion_preventa.id_real_preventa,operacion_preventa.fecha_carga_preventa,operacion_preventa.estado_aprobacion,
			usuarios.nombre,usuarios.apellido
			 FROM vehiculos,clientes,usuarios,operacion_preventa,(SELECT id_real_preventa,id 
			from operacion_preventa o where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
			where o.id_real_preventa=operacion_preventa.id_real_preventa group by id_real_preventa )) as r 
			where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
			and operacion_preventa.id_cliente=clientes.id and operacion_preventa.estado_orden='SINCANCELAR' 
			 and vehiculos.id_estado!='4' 
			 and operacion_preventa.id_vendedor='$_SESSION[idC]'and usuarios.id='$_SESSION[idC]' 
			  and operacion_preventa.estado_aprobacion='2'";
	
		break;
	
		}
		case 'm':{
	
			$sql="SELECT operacion_preventa.id,vehiculos.modelo,vehiculos.dominio_patente,
			operacion_preventa.id_real_preventa,operacion_preventa.fecha_carga_preventa,operacion_preventa.estado_aprobacion,
			usuarios.nombre,usuarios.apellido
			 FROM vehiculos,clientes,usuarios,operacion_preventa,(SELECT id_real_preventa,id 
			from operacion_preventa o where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
			where o.id_real_preventa=operacion_preventa.id_real_preventa  group by id_real_preventa )) as r 
			where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
			and operacion_preventa.id_cliente=clientes.id and operacion_preventa.estado_orden='SINCANCELAR' 
			and operacion_preventa.eliminado='0' and vehiculos.id_estado!='4' 
			 and operacion_preventa.id_vendedor='$_SESSION[idC]' and usuarios.id='$_SESSION[idC]' 
			 and operacion_preventa.estado_aprobacion='3'";
	
		break;
	
		}
	
	 }




}
 




$result = mysqli_query($conexion,$sql);


$fechaActual= getdate();

$fechaDeHoy=$fechaActual['mday'].'-'.$fechaActual['mon'].'-'.$fechaActual['year'];


?>








<div>
	
	<link href="librerias/bootstrap/tableexport.css" rel="stylesheet" type="text/css">

	<table class="table table-hover table-condensed table-bordered" id="iddatatablePre">

		<thead  style="background-color:#ccc; color: white; font-weight: bold; ">
			<tr>
				<!-- <td style="font-size: 12px">ID</td> -->
				<td style="font-size: 12px">Nro PreVenta</td>
				<td style="font-size: 12px">Fecha</td>
				<td style="font-size: 12px">Modelo</td>
				<td style="font-size: 12px">Dominio</td>
				<td style="font-size: 12px">Vendedor</td>
				<!-- <td style="font-size: 12px">Observaciones</td>		 -->
				<!-- <td style="font-size: 12px">Detalle</td>	 -->

				<td style="font-size: 12px">Estado</td>	
	
				<td style="font-size: 12px"></td>
				<!-- <td style="font-size: 12px">Eliminar</td> -->
				

			</tr>


		</thead>

		
			<tbody>
				<?php
				while ($mostrar=mysqli_fetch_array($result)) {
			
		

					?>

				<tr style="background-color: white;">
					<td style="font-size: 12px"> <?php echo $mostrar[3]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[4]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[1]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[2]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[6]." ".$mostrar[7]?> </td>
							
					
				


					<td style="font-size: 9px"> <?php 
				    	if($mostrar[5]=='0'){
				    		echo "<div title=\"En Revision\" class=\"alert alert-warning\" role=\"alert\" style=\"height:30px; width:53px;\">ER</div> "; 
				    	}
				    		else if ($mostrar[5]=='1') {echo "<div title=\"Aprobada\" class=\"alert alert-success\" role=\"alert\" style=\"height:30px; width:53px;\" >A</div> "; }
				    		else if ($mostrar[5]=='2') {echo "<div title=\"Rechazada\" class=\"alert alert-danger\" role=\"alert\" style=\"height:30px; width:53px;\" >R</div> "; }
							else if ($mostrar[5]=='3') {echo "<div title=\"Modificar\" class=\"alert alert-info\" role=\"alert\" style=\"height:30px; width:53px;\" >M</div> "; }



				   ?> </td>
					
					


					<td> 

						

						
						<?php 
						if($_SESSION["permisos"]!='3'){ 
							
							if($mostrar[5]!='1' and $mostrar[5]!='2'){ 
							
							?>
							<span class="btn btn-warning btn-sm" data-toggle="modal" title="Editar"   data-target="#modalEditar"  onclick="editarOrdenPreVenta('<?php echo $mostrar[0] ?>')">
						<span class="fas fa-edit " ></span>
						</span>
						<span class="btn btn-primary btn-sm" title="Decidir" onclick="decidirPreVenta('<?php echo $mostrar[0] ?>')">
							<span class="fas fa-tasks"></span>	
						</span>
								
							<?php }
							else{ ?>

				<span class="btn btn-warning btn-sm disabled" data-toggle="modal" title="Editar">
						<span class="fas fa-edit " ></span>
						</span>
					<span class="btn btn-primary btn-sm disabled" title="Decidir">
							<span class="fas fa-tasks"></span>	
						</span>




						<?php } }
	
								else{
									if($mostrar[5]!='1' and $mostrar[5]!='2'){ 
						?>


				<span class="btn btn-warning btn-sm" data-toggle="modal" title="Editar"   data-target="#modalEditar"  onclick="editarOrdenPreVenta('<?php echo $mostrar[0] ?>')">
						<span class="fas fa-edit " ></span>
						</span>


						<?php }	else{ 
								?>

		<span class="btn btn-warning btn-sm disabled" data-toggle="modal" title="Editar">
						<span class="fas fa-edit " ></span>
						</span>


<?php  } } 

?>

					</td> 
					
				</tr>


<?php
}
?>
			</tbody>


	</table>
</div>


<script type="text/javascript">
	
$(document).ready(function() {
    $('#iddatatablePre').DataTable();
} );

</script>

<script src="librerias/tableExport/FileSaver.min.js"></script>
<script src="librerias/tableExport/Blob.min.js"></script>
<script src="librerias/tableExport/xls.core.min.js"></script>
<script src="librerias/tableExport/tableexport.js"></script>
<script>
$("table").tableExport({
	formats: ["xlsx"],//Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
	ignoreCols: [8], 
	position: 'button',  // Posicion que se muestran los botones puedes ser: (top, bottom)
	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
	fileName: "PreVentas revision al <?php echo $fechaDeHoy;?>",    //Nombre del archivo 
});
</script>

