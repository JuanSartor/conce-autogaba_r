
<?php


include ("clases/conexion.php");

$conexion=conectar();

$sql="SELECT gastos_vehiculo.id,gastos_vehiculo.descripcion,gastos_vehiculo.monto,
gastos_vehiculo.fecha_ingresada_por_usuario,proveedores.descripcion,vehiculos.dominio_patente,
usuarios.nombre,usuarios.apellido,gastos_vehiculo.eliminado FROM gastos_vehiculo,vehiculos,usuarios,proveedores 
WHERE gastos_vehiculo.id_usuario_logueado=usuarios.id   and  gastos_vehiculo.id_proveedor=proveedores.id  
and gastos_vehiculo.id_vehiculo=vehiculos.id";

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
				<td style="font-size: 12px">Descripcion</td>
				<td style="font-size: 12px">Monto</td>
				<td style="font-size: 12px">Fecha</td>
				<td style="font-size: 12px">Proveedor</td>
				<td style="font-size: 12px">Dominio</td>
				<td style="font-size: 12px">Usuario</td>
				<td style="font-size: 12px">Estado</td>
				<td style="font-size: 12px">Administrar</td>
				
				

			</tr>


		</thead>

		
			<tbody>
				<?php
				while ($mostrar=mysqli_fetch_array($result)) {
			
		

					?>

				<tr style="background-color: white;">
					<td style="font-size: 12px"> <?php echo $mostrar[0]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[1]?> </td>
					<td style="font-size: 12px"> <?php echo number_format($mostrar[2],2,",",".");?> </td>

					

					<td style="font-size: 12px"> <?php echo $mostrar[3]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[4]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[5]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[6].' '.$mostrar[7]?> </td>
				     <td style="font-size: 12px"> <?php 
				    	if($mostrar[8]=='0'){
				    		echo "<div class=\"alert alert-success\" role=\"alert\" style=\"height:35px\">Activo</div> "; 
				    	}
				    		else{echo "<div class=\"alert alert-danger\" role=\"alert\" style=\"height:35px\" >Inactivo</div> "; }


				   ?> </td>
					 
						<?php   if($mostrar[2]=='SI'){      ?>
	
							<td>
						<span class="btn btn-danger btn-sm disabled" >
							<span class="fas fa-trash-alt"></span>
						</span>
					</td>
					<?php } 
					else { ?>  
							<td>
						<span class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarDatosGastos('<?php echo $mostrar[0] ?>')">
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
	ignoreCols: [3,4], 
	position: 'button',  // Posicion que se muestran los botones puedes ser: (top, bottom)
	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
	fileName: "Entidades Bancarias al <?php echo $fechaDeHoy;?>",    //Nombre del archivo 
});
</script>


