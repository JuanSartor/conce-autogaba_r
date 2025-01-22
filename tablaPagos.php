<?php


include ("clases/conexion.php");

$conexion=conectar();

$sql="SELECT pagos_preventa.id,operacion_preventa.id_real_preventa,pagos_preventa.descripcion,
monto,pagos_preventa.eliminado,tipo_ingreso,fecha_seteada_pago,fechar_cargar_registro,usuarios.nombre
,usuarios.apellido,usuarios.dni,pagos_preventa.nombre_archivo,operacion_preventa.saldo_final_preventa,
vehiculos.marca, vehiculos.modelo, vehiculos.dominio_patente FROM 
pagos_preventa,usuarios,operacion_preventa,vehiculos where vehiculos.id=operacion_preventa.id_vehiculo_prevendido 
and usuarios.id=pagos_preventa.id_usuario_logueado and operacion_preventa.id=pagos_preventa.id_orden_preventa
 and pagos_preventa.eliminado='NO' and operacion_preventa.id='$_GET[datosidP]'";

$result = mysqli_query($conexion,$sql);


$fechaActual= getdate();

$fechaDeHoy=$fechaActual['mday'].'-'.$fechaActual['mon'].'-'.$fechaActual['year'];

?>

<div>
	
	<link href="librerias/bootstrap/tableexport.css" rel="stylesheet" type="text/css">

	<table class="table table-hover table-condensed table-bordered" id="iddatatable">

		<thead  style="background-color:#ccc; color: white; font-weight: bold; ">
			<tr>
				<!-- <td style="font-size: 12px" >ID</td> -->
				<td style="font-size: 12px">Fecha Cargada</td>
				<!-- <td style="font-size: 12px">Nro Preventa</td> -->
				<td style="font-size: 12px">Usuario</td>
		
				<td style="font-size: 12px">Monto</td>

				<!-- <td style="font-size: 12px">Vehiculo</td>
				<td style="font-size: 12px">Dominio</td> -->
			
				<td style="font-size: 12px">Comprobante Pago</td>
				<!-- <td style="font-size: 12px">Estado</td>
				<td style="font-size: 12px">Editar</td> -->
				 <td style="font-size: 12px">Eliminar</td>
				
			</tr>

		</thead>
			<tbody>
				<?php
				while ($mostrar=mysqli_fetch_array($result)) {
			
					?>

				<tr style="background-color: white;">
					<td style="font-size: 12px"> <?php echo $mostrar[6]?> </td>
				<!-- 	<td style="font-size: 12px"> <?php echo $mostrar[0]?> </td> -->
				<!-- 	<td style="font-size: 12px"> <?php echo $mostrar[1]?> </td> -->
					
					<td style="font-size: 12px"> <?php echo $mostrar[8].' '.$mostrar[9]?> </td>

					<td style="font-size: 12px"> <?php echo number_format($mostrar[3],2,",",".");?> </td>
					
					<!-- <td style="font-size: 12px"> <?php echo $mostrar[13].' '.$mostrar[14]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[15]?> </td> -->
				    <!-- <td style="font-size: 12px"> <?php 
				    	if($mostrar[4]=='NO'){
				    		echo "<div class=\"alert alert-success\" role=\"alert\" style=\"height:35px\">Activo</div> "; 
				    	}
				    		else{echo "<div class=\"alert alert-danger\" role=\"alert\" style=\"height:35px\" >Inactivo</div> "; }


				   ?> </td>
					 
						<?php   if($mostrar[2]=='SI'){      ?>
							<td> 
						<span class="btn btn-warning btn-sm disabled" >
						<span class="fas fa-edit "></span>
						</span>
						</td> 
							<td>
						<span class="btn btn-danger btn-sm disabled" >
							<span class="fas fa-trash-alt"></span>
						</span>
					</td>
					<?php } 
					else { ?> 
						<td> 
						<span class="btn btn-warning btn-sm" data-toggle="modal"  title="Editar"  data-target="#modalEditar" onclick="actualizarEntidad('<?php echo $mostrar[0] ?>')">
						<span class="fas fa-edit "></span>
						</span>
						</td>  
							<td>
						<span class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarDatosEntidad('<?php echo $mostrar[0] ?>')">
							<span class="fas fa-trash-alt"></span>
						</span>
					</td> 

					<?php } ?> -->
											
							<td>

<?php 

		$cadena='procesos/pagosRealizados/'.$mostrar[11];
		
?>

											<a   href='<?php echo $cadena ?>'  download='<?php echo $mostrar[11]; ?>' >
Descargar Archivo
</a>
</td>



<td>
						<span class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarPago('<?php echo $mostrar[0] ?>','<?php echo $_GET['datosidP'] ?>')">   
							<span class="fas fa-trash-alt"></span>
						</span>
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
	ignoreCols: [4,5], 
	position: 'button',  // Posicion que se muestran los botones puedes ser: (top, bottom)
	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
	fileName: "Pagos al <?php echo $fechaDeHoy;?>",    //Nombre del archivo 
});
</script>



