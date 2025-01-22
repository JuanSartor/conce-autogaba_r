
<?php


include ("clases/conexion.php");

$conexion=conectar();

$sql="SELECT id,descripcion,observaciones,eliminado FROM lugar_donde_se_encuentra_vehiculo";

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
				<td style="font-size: 12px" >Descripcion</td>
				<td style="font-size: 12px">Observaciones</td>
				<td style="font-size: 12px">Estado</td>
				<td style="font-size: 12px">Editar</td>
				<td style="font-size: 12px">Eliminar</td>
				

			</tr>


		</thead>

		
			<tbody>
				<?php
				while ($mostrar=mysqli_fetch_array($result)) {
			
		

					?>

				<tr style="background-color: white;">
					<td style="font-size: 12px"> <?php echo $mostrar[0]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[1]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[2]?></td>
	
				    <td style="font-size: 12px"> <?php 
				    	if($mostrar[3]=='0'){
				    		echo "<div class=\"alert alert-success\" role=\"alert\" style=\"height:35px\">Activo</div> "; 
				    	}
				    		else{echo "<div class=\"alert alert-danger\" role=\"alert\" style=\"height:35px\" >Inactivo</div> "; }


				   ?> </td>
					 
						<?php   if($mostrar[3]=='1'){      ?>
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
						<span class="btn btn-warning btn-sm" data-toggle="modal"   data-target="#modalEditar" onclick="actualizarLugar('<?php echo $mostrar[0] ?>')">
						<span class="fas fa-edit "></span>
						</span>
						</td>  
							<td>
						<span class="btn btn-danger btn-sm" onclick="eliminarDatosLugar('<?php echo $mostrar[0] ?>')">
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
	ignoreCols: [4,5], 
	position: 'button',  // Posicion que se muestran los botones puedes ser: (top, bottom)
	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
	fileName: "Lugares al <?php echo $fechaDeHoy;?>",    //Nombre del archivo 
});
</script>




