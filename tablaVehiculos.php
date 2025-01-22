
<?php
session_start();

include ("clases/conexion.php");

$conexion=conectar();


switch ($_GET['pme']) {
	case 't':{
		
		if($_SESSION["permisos"]!='4' and $_SESSION["permisos"]!='3' ){
        $sql="SELECT v.marca,v.modelo,v.anio,v.kilometros,v.color,v.id,v.id_estado,v.dominio_patente,v.fecha_ingreso_a_stock,v.eliminado,v.fecha_vendido,v.fecha_ingreso,o.descripcion,v.precio_compra,v.precio_venta,v.info_precio,v.nombre_vehiculo_infoauto FROM vehiculos v,origenes_vehiculo o where v.eliminado='NO' and o.id=v.id_origen ";
		}
		elseif($_SESSION["permisos"]=='3'){
			$sql="SELECT v.marca,v.modelo,v.anio,v.kilometros,v.color,v.id,v.id_estado,v.dominio_patente,v.fecha_ingreso_a_stock,
			v.eliminado,v.fecha_vendido,v.fecha_ingreso,o.descripcion,v.precio_compra,v.precio_venta,v.info_precio,v.nombre_vehiculo_infoauto 
			FROM vehiculos v,origenes_vehiculo o where v.eliminado='NO' and o.id=v.id_origen and (v.id_estado='2' or v.id_estado='1' )";
	

		}
		else{
			$sql="SELECT v.marca,v.modelo,v.anio,v.kilometros,v.color,v.id,v.id_estado,v.dominio_patente,v.fecha_ingreso_a_stock,
			v.eliminado,v.fecha_vendido,v.fecha_ingreso,o.descripcion,v.precio_compra,v.precio_venta,v.info_precio,v.nombre_vehiculo_infoauto
			FROM vehiculos v,origenes_vehiculo o where v.eliminado='NO' and o.id=v.id_origen and (v.id_estado='2' or v.id_estado='1')";
	
		}

	break;}
    case 'a':
        $sql="SELECT v.marca,v.modelo,v.anio,v.kilometros,v.color,v.id,v.id_estado,v.dominio_patente,v.fecha_ingreso_a_stock,v.eliminado,v.fecha_vendido,v.fecha_ingreso,o.descripcion,v.precio_compra,v.precio_venta,v.info_precio,v.nombre_vehiculo_infoauto  FROM vehiculos v,origenes_vehiculo o WHERE v.id_estado='1' and v.eliminado='NO'  and o.id=v.id_origen";
        break;
    case 'v':
        $sql="SELECT v.marca,v.modelo,v.anio,v.kilometros,v.color,v.id,v.id_estado,v.dominio_patente,v.fecha_ingreso_a_stock,v.eliminado,v.fecha_vendido,v.fecha_ingreso,o.descripcion,v.precio_compra,v.precio_venta,v.info_precio,v.nombre_vehiculo_infoauto  FROM vehiculos v,origenes_vehiculo o WHERE v.id_estado='4' and v.eliminado='NO'  and o.id=v.id_origen ";
        break;
    case 's':
        $sql="SELECT v.marca,v.modelo,v.anio,v.kilometros,v.color,v.id,v.id_estado,v.dominio_patente,v.fecha_ingreso_a_stock,v.eliminado,v.fecha_vendido,v.fecha_ingreso,o.descripcion,v.precio_compra,v.precio_venta,v.info_precio,v.nombre_vehiculo_infoauto  FROM vehiculos v,origenes_vehiculo o WHERE v.id_estado='2' and v.eliminado='NO'  and o.id=v.id_origen";
        break;
    case 'r':
        $sql="SELECT v.marca,v.modelo,v.anio,v.kilometros,v.color,v.id,v.id_estado,v.dominio_patente,v.fecha_ingreso_a_stock,v.eliminado,v.fecha_vendido,v.fecha_ingreso,o.descripcion,v.precio_compra,v.precio_venta,v.info_precio,v.nombre_vehiculo_infoauto  FROM vehiculos v,origenes_vehiculo o WHERE v.id_estado='3' and v.eliminado='NO'  and o.id=v.id_origen";
        break;
    case 'c':
        $sql="SELECT v.marca,v.modelo,v.anio,v.kilometros,v.color,v.id,v.id_estado,v.dominio_patente,v.fecha_ingreso_a_stock,v.eliminado,v.fecha_vendido,v.fecha_ingreso,o.descripcion,v.precio_compra,v.precio_venta,v.info_precio,v.nombre_vehiculo_infoauto  FROM vehiculos v,origenes_vehiculo o WHERE v.id_estado='5' and v.eliminado='NO'  and o.id=v.id_origen";        
        break;
}



$result = mysqli_query($conexion,$sql);



$fechaActual= getdate();

$fechaDeHoy=$fechaActual['mday'].'-'.$fechaActual['mon'].'-'.$fechaActual['year'];



?>





<div>
	
	<table class="table table-hover table-condensed table-bordered" id="iddatatable">

		<thead  style="background-color:#ccc; color: white; font-weight: bold; ">
			<tr>
				<td style="font-size: 10px;" >Marca</td>
				<td style="font-size: 10px" >Modelo</td>
				<td style="font-size: 10px" >Tipo</td>
				<td style="font-size: 10px">Año</td>
				<td style="font-size: 10px">Dominio</td>
				<td style="font-size: 10px">Km</td>
				<td style="font-size: 10px">Color</td>
				<?php if($_SESSION["permisos"]!='4') { ?>
				<td style="font-size: 10px">Origen</td>
				
				<td style="font-size: 10px">Ingreso</td>

				<td style="font-size: 10px">Dias Stock</td>

				
				<?php } ?>
				<?php if($_SESSION["permisos"]!='4' and $_SESSION["permisos"]!='3' ) { ?>	
				<td style="font-size: 10px">Precio Compra</td>	
				<?php } ?>	
				<?php if($_SESSION["permisos"]!='4') { ?>
				<td style="font-size: 10px">Precio Info</td>
				<?php } ?>

				<td style="font-size: 10px">Precio Venta</td>

				<?php if($_SESSION["permisos"]!='4') { ?>
						
				<td style="font-size: 10px">Reporte</td>
				<?php } ?>
				<td style="font-size: 10px">Estado</td>
				<?php if($_SESSION["permisos"]!='4' and  $_SESSION["permisos"]!='3') { ?>
				<td style="font-size: 10px" id="editar"></td>
				<?php } ?>
			<!-- 	<td style="font-size: 10px">Eliminar</td>
				<td style="font-size: 10px">Gasto</td> -->
				

			</tr>


		</thead>

		
			<tbody>
				<?php
				while ($mostrar=mysqli_fetch_array($result)) {
			
	
					?>

				<tr style="background-color: white;">
					<td style="font-size: 10px"> <?php echo $mostrar[0]?> </td>
					<td style="font-size: 10px"> <?php echo $mostrar[1]?> </td>
					<td style="font-size: 10px"> <?php echo $mostrar[16]?> </td>
					<td style="font-size: 10px"> <?php echo $mostrar[2]?></td>
					<td style="font-size: 10px"> <?php echo $mostrar[7]?></td>
					<td style="font-size: 10px"> <?php echo $mostrar[3]?> </td>
					<td style="font-size: 10px"> <?php echo $mostrar[4]?></td>
					<?php if($_SESSION["permisos"]!='4') { ?>
					<td style="font-size: 10px"> <?php echo $mostrar[12]?></td>
					<td style="font-size: 10px"> <?php echo $mostrar[11]?></td>

					<td style="font-size: 10px"> 


						<?php if($mostrar[8]==NULL){echo '0';}
						elseif($mostrar[10]!=NULL){

							$dias	= (strtotime($mostrar[10])-strtotime($mostrar[8]))/86400;
							$dias 	= abs($dias); 
							$dias = floor($dias);	



						  echo $dias;

						}
						 else{ 

						 	$dias	= (strtotime(date("Y-m-d"))-strtotime($mostrar[8]))/86400;
							$dias 	= abs($dias); 
							$dias = floor($dias);	



						  echo $dias; } ?> </td>
						<?php } ?>

						<?php if($_SESSION["permisos"]!='4'  and $_SESSION["permisos"]!='3') { ?>
						  <td style="font-size: 10px"> <?php echo  number_format($mostrar[13],2, "," , "."); ?></td> 
						  <?php } ?>


						  <?php if($_SESSION["permisos"]!='4') { ?>
						  <td style="font-size: 10px">	
							<?php echo number_format($mostrar[15],2,",",".");?>
							</td>

							<?php } ?>

							
						 <td style="font-size: 10px"> <?php echo number_format($mostrar[14],2,",",".");?></td>
						 
						 <?php if($_SESSION["permisos"]!='4') { ?>

							
						 <td>


					<span class="btn btn-light btn-sm" style="font-size: 9px; width: 55px;" data-toggle="modal" title="Generar"   data-target="#modalReporte"     onclick=" cargarInforme('<?php echo $mostrar[5];  ?>');"> Generar
						
						
							</td>
						 <?php } ?>

					
				    <td style="font-size: 9px"> <?php 
				    	if($mostrar[6]=='1'){
				    		echo "<div title=\"A Ingresar\" class=\"alert alert-warning\" role=\"alert\" style=\"height:30px; width:16px;\">I</div> "; 
				    	}
				    		else if ($mostrar[6]=='2') {echo "<div title=\"Stock\" class=\"alert alert-success\" role=\"alert\" style=\"height:30px; width:16px;\" >S</div> "; }
				    		else if ($mostrar[6]=='3') {echo "<div title=\"Reservado\" class=\"alert alert-info\" role=\"alert\" style=\"height:30px; width:16px;\" >R</div> "; }
				    		else if ($mostrar[6]=='4') {echo "<div title=\"Vendido\" class=\"alert alert-dark\" role=\"alert\" style=\"height:30px; width:16px;\" >V</div> "; }
				    		else if ($mostrar[6]=='5') {echo "<div title=\"Cancelado\" class=\"alert alert-danger\" role=\"alert\" style=\"height:30px; width:16px;\" >C</div> "; }



				   ?> </td>
					 <?php if($_SESSION["permisos"]!='4' and $_SESSION["permisos"]!='3' ) { ?>
						<?php   if($mostrar[6]=='4' or $mostrar[6]=='5'  or $mostrar[9]=='SI' ){      ?>
							<td> 
						<span class="btn btn-warning btn-sm disabled" >
						<span class="fas fa-edit "></span>
						</span>
						<!-- </td> 
							<td> -->
						<span class="btn btn-danger btn-sm disabled" >
							<span class="fas fa-trash-alt"></span>
						</span>
					<!-- </td>
						<td> -->
						<span class="btn btn-secondary btn-sm disabled" >
							<span class="fas fa-donate"></span> 
						</span>
					</td>

					<?php } 

					elseif($mostrar[6]=='3'){ ?>  

						<td> 
						<span class="btn btn-warning btn-sm" data-toggle="modal" title="Editar"   data-target="#modalEditar"  onclick="actualizarVehiculo('<?php echo $mostrar[5] ?>')">
						<span class="fas fa-edit " ></span>
						</span>
						<span class="btn btn-danger btn-sm disabled" >
							<span class="fas fa-trash-alt"></span>
						</span>

						<span class="btn btn-secondary btn-sm" title="Agregar Gasto" data-toggle="modal" data-target="#modalGasto"  onclick="agregarGastoVehiculo('<?php echo $mostrar[5] ?>')">
							<span class="fas fa-donate"></span>   
						</span>
					</td> 



						<?php
					}
					else { ?> 
						<td> 
						<span class="btn btn-warning btn-sm" data-toggle="modal" title="Editar"   data-target="#modalEditar"  onclick="actualizarVehiculo('<?php echo $mostrar[5] ?>')">
						<span class="fas fa-edit " ></span>
						</span>

						<!-- </td>  
							<td> -->

						<span class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarDatosVehiculo('<?php echo $mostrar[5] ?>')">
							<span class="fas fa-trash-alt"></span>
						</span>
					<!-- </td> 

					<td> -->
						<span class="btn btn-secondary btn-sm" title="Agregar Gasto" data-toggle="modal" data-target="#modalGasto"  onclick="agregarGastoVehiculo('<?php echo $mostrar[5] ?>')">
							<span class="fas fa-donate"></span>   
						</span>
					</td> 

					<?php } ?>


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


<!-- <script src="jquery-1.12.4.min.js"></script> -->
<script src="librerias/tableExport/FileSaver.min.js"></script>
<script src="librerias/tableExport/Blob.min.js"></script>
<script src="librerias/tableExport/xls.core.min.js"></script>
<script src="librerias/tableExport/tableexport.js"></script>
<script>
	if('<?php echo $_SESSION["permisos"];?>'!='4' && '<?php echo $_SESSION["permisos"];?>'!='3' ){

$("table").tableExport({
	formats: ["xlsx"],//Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
	ignoreCols: [13,15], 
	position: 'button',  // Posicion que se muestran los botones puedes ser: (top, bottom)
	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
	fileName: "Vehiculos al <?php echo $fechaDeHoy;?>",    //Nombre del archivo 
});
}
else{
	$("table").tableExport({
	formats: ["xlsx"],//Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
	ignoreCols: [12], 
	position: 'button',  // Posicion que se muestran los botones puedes ser: (top, bottom)
	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
	fileName: "Vehiculos al <?php echo $fechaDeHoy;?>",    //Nombre del archivo 
});



}
</script>


<script type="text/javascript">
	
function irAInformeVehiculo(id){

	
	 window.location="reporteVehiculoExcel.php?datosidPp="+id;

}

</script>





