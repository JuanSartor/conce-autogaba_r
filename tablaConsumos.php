
<?php

include ("clases/conexion.php");

$conexion=conectar();

$sql="SELECT operaciones_cajas.id,operaciones_cajas.monto,operaciones_cajas.descripcion,operaciones_cajas.eliminado,usuarios.nombre,usuarios.apellido,usuarios.dni,operaciones_cajas.fechaRegistradaOperacion,operaciones_cajas.fecha_ingresada_por_usuario,proveedores.descripcion,operaciones_cajas.nombre_archivo FROM operaciones_cajas,usuarios,proveedores where tipo_operacion='CONSUMO' and usuarios.id=operaciones_cajas.id_usuario and proveedores.id=operaciones_cajas.id_proveedor and operaciones_cajas.eliminado='NO'";

$result = mysqli_query($conexion,$sql);

$fechaActual= getdate();

$fechaDeHoy=$fechaActual['mday'].'-'.$fechaActual['mon'].'-'.$fechaActual['year'];

?>

<div>
	
	<link href="librerias/bootstrap/tableexport.css" rel="stylesheet" type="text/css">

	<table class="table table-hover table-condensed table-bordered" id="iddatatable">

		<thead  style="background-color:#ccc; color: white; font-weight: bold; ">
			<tr>
				<td style="font-size: 12px" >ID</td>
				<td style="font-size: 12px">Fecha de Pago</td>
				<td style="font-size: 12px">Proveedor</td>
				
				<td style="font-size: 12px">Descripción</td>
				<td style="font-size: 12px">Monto</td>
				<td style="font-size: 12px">Usuario</td>
				<!-- <td style="font-size: 12px">DNI</td> -->
				<!-- <td style="font-size: 12px">Fecha Registro</td> -->
				
				
				<td style="font-size: 12px">Comprobante</td>
				<td style="font-size: 12px">Acción</td>
				<!-- <td style="font-size: 12px">Estado</td> -->
				
				<!-- <td style="font-size: 12px">Eliminar</td> -->
			</tr>
		</thead>		
			<tbody>
				<?php
				while ($mostrar=mysqli_fetch_array($result)) {
					?>

				<tr style="background-color: white;">
					<td style="font-size: 12px"> <?php echo $mostrar[0]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[8]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[9]?></td>
					
					<td style="font-size: 12px"> <?php echo $mostrar[2]?></td>
					<td style="font-size: 12px"> <?php echo '$ '.number_format($mostrar[1],2,',','.')?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[4].' '.$mostrar[5]?></td>
					<!-- <td style="font-size: 12px"> <?php echo $mostrar[6]?></td> -->
					<!-- <td style="font-size: 12px"> <?php echo $mostrar[7]?></td> -->
					
					
					<td style="font-size: 12px"> 
					<?php 
						$cadena='procesos/pagosRealizados/'.$mostrar[10];
					?>
					<a   href='<?php echo $cadena ?>'  download='<?php echo $mostrar[10]; ?>' > Ver Comprobante
					</td>
				   <!-- <td style="font-size: 12px"> <?php 
				    	if($mostrar[3]=='NO'){
				    		echo "<div class=\"alert alert-success\" role=\"alert\" style=\"height:35px\">Activo</div> "; 
				    	}
				    		else{echo "<div class=\"alert alert-danger\" role=\"alert\" style=\"height:35px\" >Inactivo</div> "; }

				   ?> </td>
					  -->
						<?php   if($mostrar[3]=='SI'){      ?>
							 
							<td>
						<span class="btn btn-danger btn-sm disabled" >
							<span class="fas fa-trash-alt"></span>
						</span>
					</td>
					<?php } 
					else { ?>  
							<td>
						<span class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarDatosConsumo('<?php echo $mostrar[0] ?>')">
							<span class="fas fa-trash-alt"></span>
						</span>
					</td> 

					<?php } ?>


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
 
	position: 'button',  // Posicion que se muestran los botones puedes ser: (top, bottom)
	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
	fileName: "Varios al <?php echo $fechaDeHoy;?>",    //Nombre del archivo 
});
</script>



