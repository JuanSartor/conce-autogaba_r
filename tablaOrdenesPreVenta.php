<?php


include ("clases/conexion.php");



$conexion=conectar();



switch ($_GET['pme']) {

	case 't':{

// con esta consulta obtengo el registro con mayor edicion es decir la ultima edicion guardada

        $sql="SELECT operacion_preventa.id,clientes.nombre,clientes.apellido,vehiculos.marca,vehiculos.modelo,
clientes.dni,vehiculos.dominio_patente,operacion_preventa.saldo_final_preventa,operacion_preventa.id_real_preventa,
operacion_preventa.edicion,operacion_preventa.fecha_carga_preventa,operacion_preventa.nombre_archivo,
vehiculos.id_estado FROM vehiculos,clientes,operacion_preventa,(SELECT id_real_preventa,id 
from operacion_preventa o where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
where o.id_real_preventa=operacion_preventa.id_real_preventa group by id_real_preventa )) as r 
where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
and operacion_preventa.id_cliente=clientes.id and operacion_preventa.estado_orden='SINCANCELAR' 
and operacion_preventa.eliminado='0' and vehiculos.id_estado!='4'";

break;	
}
	case 'a':{

		$sql="SELECT operacion_preventa.id,clientes.nombre,clientes.apellido,vehiculos.marca,vehiculos.modelo,
clientes.dni,vehiculos.dominio_patente,operacion_preventa.saldo_final_preventa,operacion_preventa.id_real_preventa,
operacion_preventa.edicion,operacion_preventa.fecha_carga_preventa,operacion_preventa.nombre_archivo,
vehiculos.id_estado FROM vehiculos,clientes,operacion_preventa,(SELECT id_real_preventa,id 
from operacion_preventa o where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
where o.id_real_preventa=operacion_preventa.id_real_preventa group by id_real_preventa )) as r 
where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
and operacion_preventa.id_cliente=clientes.id and operacion_preventa.saldo_final_preventa<=0 
and operacion_preventa.eliminado='0' and vehiculos.id_estado='4'";


	break;

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
				<td style="font-size: 12px">Fecha Pre Venta</td>
				<td style="font-size: 12px">Cliente</td>
				<td style="font-size: 12px">DNI</td>
				<td style="font-size: 12px">Vehiculo</td>
				<td style="font-size: 12px">Dominio</td>		
				<td style="font-size: 12px">Saldo</td>	

				<td style="font-size: 12px">Pagos</td>	

				<td style="font-size: 12px">Comprobante Pre Venta</td>	
				<td style="font-size: 12px"></td>
				<!-- <td style="font-size: 12px">Eliminar</td> -->
				

			</tr>


		</thead>

		
			<tbody>
				<?php
				while ($mostrar=mysqli_fetch_array($result)) {
			
		

					?>

				<tr style="background-color: white;">
					<!-- <td style="font-size: 12px"> <?php echo $mostrar[0]?></td> -->
					<td style="font-size: 12px"> <?php echo $mostrar[8]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[10]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[1]." ".$mostrar[2]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[5]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[3]." ".$mostrar[4]?> </td>			
					<td style="font-size: 12px"> <?php echo $mostrar[6]?></td>
					<td style="font-size: 12px"> <?php echo  number_format($mostrar[7],2,",",".");?></td>
					
					
							<td>


					<span class="btn btn-light btn-sm"     onclick=" irAPagos('<?php echo $mostrar[0];  ?>');"> Detalles
						
						
							</td>
						


		<?php if($mostrar[11]=='0'){  ?>
						<td>
							
							<a>
No Disponible
</a>
						</td>



<?php } 




else { ?> 
					<td>

					<?php 

		$cadena='procesos/preVentas/'.$mostrar[11];
		
?>


											<a   href='<?php echo $cadena ?>'  download='<?php echo $mostrar[11]; ?>' >
Descargar
</a>

</td>
<?php } ?>

				
	
	<?php if($mostrar[12]=='4'){  ?>
						<td> 

						<span class="btn btn-danger btn-sm " title="Eliminar" onclick="eliminarOrdenPreventa('<?php echo $mostrar[0] ?>','c')">
							<span class="fas fa-trash-alt"></span>
						</span>
					</td> 

				<?php } 




else { ?> 


					<td> 

						<span class="btn btn-success btn-sm " title="Pagar" data-toggle="modal"   data-target="#modalPago" onclick="setearDatosOrdeenDePreventa('<?php echo $mostrar[0] ?>')">
						<span class="fas fa-donate"></span> 
						</span>	

						<span  class="btn btn-warning btn-sm " title="Editar" data-toggle="modal"   data-target="#modalEditar" onclick="editarOrdenPreVenta('<?php echo $mostrar[0] ?>')">
						<span  class="fas fa-edit "></span>
						</span>
						
						<span class="btn btn-danger btn-sm " title="Eliminar" onclick="eliminarOrdenPreventa('<?php echo $mostrar[0] ?>','nc')">
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
	fileName: "Ventas al <?php echo $fechaDeHoy;?>",    //Nombre del archivo 
});
</script>

<script type="text/javascript">
	
function irAPagos(id){

	
	 window.location="pagos.php?datosidP="+id;


}

</script>