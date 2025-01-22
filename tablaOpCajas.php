
<?php


include ("clases/conexion.php");

$conexion=conectar();

$sql="SELECT operaciones_cajas.id,operaciones_cajas.monto,operaciones_cajas.descripcion,operaciones_cajas.fechaRegistradaOperacion,cajas.nombre,operaciones_cajas.tipo_operacion,usuarios.nombre,usuarios.apellido FROM operaciones_cajas,cajas,cajas_apertura,usuarios where operaciones_cajas.id_cajas_apertura=cajas_apertura.id and cajas_apertura.id_caja=cajas.id and operaciones_cajas.id_usuario=usuarios.id"; // seguir de acaaaaa

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
				<td style="font-size: 12px">Caja</td>
				<td style="font-size: 12px">Usuario</td>
				<td style="font-size: 12px">Tipo Operacion</td>
				<td style="font-size: 12px">Monto</td>
				<td style="font-size: 12px">Fecha Operacion</td>				
				
				<!-- <td style="font-size: 12px">Eliminar</td> -->
				

			</tr>


		</thead>

		
			<tbody>
				<?php
				while ($mostrar=mysqli_fetch_array($result)) {
			
		

					?>

				<tr style="background-color: white;">
					<td style="font-size: 12px"> <?php echo $mostrar[0]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[4]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[6].' '.$mostrar[7]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[5]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[1]?></td>
					
					<td style="font-size: 12px"> <?php echo $mostrar[3]?></td>
				
					

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
	fileName: "Operaciones de Cajas al <?php echo $fechaDeHoy;?>",    //Nombre del archivo 
});
</script>



