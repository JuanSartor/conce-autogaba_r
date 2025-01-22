<?php


include ("clases/conexion.php");

$conexion=conectar();

// obtengo los pagos relacionados con el vehiculo

$sql="SELECT pagos_preventa.fecha_seteada_pago,pagos_preventa.monto,pagos_preventa.descripcion, 
usuarios.nombre,usuarios.apellido
from operacion_preventa,vehiculos,pagos_preventa,usuarios 
where pagos_preventa.id_usuario_logueado=usuarios.id and pagos_preventa.id_orden_preventa=operacion_preventa.id 
and operacion_preventa.eliminado='0' and  operacion_preventa.id_vehiculo_prevendido='$_GET[datosidPp]'  
and vehiculos.id='$_GET[datosidPp]'";
 

$result = mysqli_query($conexion,$sql);


// obtengo los gastos relacionados al vehiculo

$sqlGastos="SELECT fecha_ingresada_por_usuario,monto,descripcion,usuarios.nombre,usuarios.apellido 
from gastos_vehiculo,usuarios 
where gastos_vehiculo.id_usuario_logueado=usuarios.id and  id_vehiculo='$_GET[datosidPp]'";
 

$resultGastos = mysqli_query($conexion,$sqlGastos);


/////////// aca arranca los detalles basados en la preventa


// credito prendario
$sqlCrepr="SELECT operacion_preventa.fecha_carga_preventa,operacion_preventa.monto_prendario,
operacion_preventa.monto_sellado,entidades_prendarias.descripcion, usuarios.nombre,usuarios.apellido
from operacion_preventa,entidades_prendarias,usuarios 
where operacion_preventa.entidad_prendaria=entidades_prendarias.id and 
operacion_preventa.id_usuario_logueado=usuarios.id  and  
operacion_preventa.id_vehiculo_prevendido='$_GET[datosidPp]'";
 

$resultCrePr = mysqli_query($conexion,$sqlCrepr);


$mostrarCrePr=mysqli_fetch_array($resultCrePr);


// credito personal
$sqlCreper="SELECT operacion_preventa.fecha_carga_preventa,operacion_preventa.monto_personal,
entidades_prendarias.descripcion, usuarios.nombre,usuarios.apellido
from operacion_preventa,entidades_prendarias,usuarios 
where operacion_preventa.entidad_prendario_personal=entidades_prendarias.id and 
operacion_preventa.id_usuario_logueado=usuarios.id  and  
operacion_preventa.id_vehiculo_prevendido='$_GET[datosidPp]'";
 

$resultCrePer = mysqli_query($conexion,$sqlCreper);


$mostrarCrePer=mysqli_fetch_array($resultCrePer);





$fechaActual= getdate();

$fechaDeHoy=$fechaActual['mday'].'-'.$fechaActual['mon'].'-'.$fechaActual['year'];

?>





<div>
	
	<link href="librerias/bootstrap/tableexport.css" rel="stylesheet" type="text/css">

	<table class="table table-hover table-condensed table-bordered" id="iddatatable">

		<thead  style="background-color:#ccc; color: white; font-weight: bold; ">
			<tr>
				<!-- <td style="font-size: 12px" >ID</td> -->
				<td style="font-size: 12px">Fecha</td>
				<!-- <td style="font-size: 12px">Nro Preventa</td> -->
				<td style="font-size: 12px">Descripcion</td>
				<td style="font-size: 12px">Monto</td>
				<td style="font-size: 12px">Usuario</td>
				<td style="font-size: 12px">Tipo</td>
			
			
				
				
				
				<!-- <td style="font-size: 12px">Vehiculo</td>
				<td style="font-size: 12px">Dominio</td> -->
			
				<!-- <td style="font-size: 12px">Comprobante Pago</td> -->
				<!-- <td style="font-size: 12px">Estado</td>
				<td style="font-size: 12px">Editar</td> -->
				<!--  <td style="font-size: 12px">Eliminar</td> -->
				

			</tr>


		</thead>

		
			<tbody>
				<?php
				while ($mostrar=mysqli_fetch_array($result)) {
			
					?>

				<tr style="background-color: white;">
					<td style="font-size: 12px"> <?php echo $mostrar[0]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[2]?> </td>

					<td style="font-size: 12px"> <?php echo $mostrar[1]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[3].' '.$mostrar[4]?> </td>
					<td style="font-size: 12px"> Pago </td>

				</tr>




<?php
}
?>
	<?php
				while ($mostrarG=mysqli_fetch_array($resultGastos)) {
			
					?>

				<tr style="background-color: white;">
					<td style="font-size: 12px"> <?php echo $mostrarG[0]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[2]?> </td>

					<td style="font-size: 12px"> <?php echo $mostrarG[1]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[3].' '.$mostrar[4]?> </td>
					<td style="font-size: 12px"> Gasto </td>
		

				</tr>




<?php
}
?>

	
<tr style="background-color: white;">
					<td style="font-size: 12px"> <?php echo $mostrarCrePr[0]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrarCrePr[3]?> </td>

					<td style="font-size: 12px"> <?php echo "Prendario: ".$mostrarCrePr[1]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrarCrePr[4].' '.$mostrarCrePr[5]?> </td>
					<td style="font-size: 12px"> Prendario </td>
		

				</tr>

				<tr style="background-color: white;">
					<td style="font-size: 12px"> <?php echo $mostrarCrePr[0]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrarCrePr[3]?> </td>

					<td style="font-size: 12px"> <?php echo "Sellado: ".$mostrarCrePr[2]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrarCrePr[4].' '.$mostrarCrePr[5]?> </td>
					<td style="font-size: 12px"> Prendario </td>
		

				</tr>

				

				<tr style="background-color: white;">
					<td style="font-size: 12px"> <?php echo $mostrarCrePer[0]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrarCrePer[2]?> </td>

					<td style="font-size: 12px"> <?php echo $mostrarCrePer[1]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrarCrePer[3].' '.$mostrarCrePer[4]?> </td>
					<td style="font-size: 12px">Personal</td>
		

				</tr>



			</tbody>


	</table>
</div>


<script type="text/javascript">
	
$(document).ready(function() {
    $('#iddatatable').DataTable();
} );

</script>


<script src="librerias/tableExport/FileSaver.min.js"></script>
<script src="librerias/tableExport/Blob.min.js"></script>
<script src="librerias/tableExport/xls.core.min.js"></script>
<script src="librerias/tableExport/tableexport.js"></script>
<script>
$("table").tableExport({
	formats: ["xlsx"],//Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
	// ignoreCols: [4,5], 
	position: 'button',  // Posicion que se muestran los botones puedes ser: (top, bottom)
	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
	fileName: "Pagos al <?php echo $fechaDeHoy;?>",    //Nombre del archivo 
});
</script>



