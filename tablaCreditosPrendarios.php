
<?php


include ("clases/conexion.php");

$conexion=conectar();

// estado 0 es a confirmar
// 1 es confirmado
// 2 es cancelado


//  este pequeña consulta trae los creditos q estan vinculados a las ultimas ventas q no esten eliminadas,
//  ni canceladas y ademas verifica que no tenga pagos hecho la preventa, porque si tiene pagos ya no se 
//  puede cancelar el credito (que dios te ayude a entender la consulta)

// $sql="select ventas.id,creditos_prendarios.id,creditos_prendarios.monto_prendario,
// creditos_prendarios.monto_sellado,creditos_prendarios.estado,entidades_prendarias.descripcion 
// from entidades_prendarias,creditos_prendarios,
// (SELECT operacion_preventa.id,operacion_preventa.id_prendario FROM vehiculos,clientes,
// operacion_preventa,(SELECT id_real_preventa,id from operacion_preventa o 
// where o.edicion=(SELECT MAX(edicion) from operacion_preventa 
// where o.id_real_preventa=operacion_preventa.id_real_preventa group by id_real_preventa )) as r 
// where r.id=operacion_preventa.id and operacion_preventa.id_vehiculo_prevendido= vehiculos.id  
// and operacion_preventa.id_cliente=clientes.id and operacion_preventa.estado_orden='SINCANCELAR' 
// and operacion_preventa.eliminado='0' and vehiculos.id_estado!='4' ) as ventas  
// where not EXISTS ( select id_orden_preventa from pagos_preventa as pag 
// where ventas.id=pag.id_orden_preventa ) and creditos_prendarios.id=ventas.id_prendario 
// and creditos_prendarios.id_entidad=entidades_prendarias.id";




 $sql="SELECT o.id,c.id,c.monto_prendario,
 c.monto_sellado,c.estado,e.descripcion, v.dominio_patente
 from entidades_prendarias e,creditos_prendarios c,operacion_preventa o, vehiculos v 
 where c.id=o.id_prendario and c.id_entidad=e.id and  (c.estado='0' or c.estado='1') and o.id_vehiculo_prevendido=v.id";



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
				<td style="font-size: 12px">Monto Prendario</td>
				<td style="font-size: 12px">Monto Sellado</td>
				<td style="font-size: 12px">Entidad</td>
				<td style="font-size: 12px">Dominio</td>
				<td style="font-size: 12px">Estado</td>	
				<td style="font-size: 12px"></td>
				
				

			</tr>


		</thead>

		
			<tbody>
				<?php
				while ($mostrar=mysqli_fetch_array($result)) {
			
		

					?>

				<tr style="background-color: white;">
					<td style="font-size: 12px"> <?php echo $mostrar[1]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[2]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[3]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[5]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[6]?> </td>
				    <td style="font-size: 12px"> <?php 
				    	if($mostrar[4]=='0'){
				    		echo "<div class=\"alert alert-warning\" role=\"alert\" style=\"height:35px\">A Confirmar</div> "; 
						}
						
						elseif($mostrar[4]=='1'){echo "<div class=\"alert alert-success\" role=\"alert\" style=\"height:35px\" >Otorgado</div> "; }
				    		else{echo "<div class=\"alert alert-danger\" role=\"alert\" style=\"height:35px\" >Cancelado</div> "; }


				   ?> </td>
					 <td> 
					 <?php 
				    	if($mostrar[4]=='0'){?>
						
						<span class="btn btn-success btn-sm"  title="Otorgar"   onclick="aceptarCredito('<?php echo $mostrar[1] ?>')">
						<span class="fas fa-check-circle"></span>
						
						</span>
					
						<span class="btn btn-danger btn-sm" title="Cancelar" onclick="cancelarCredito('<?php echo $mostrar[0] ?>')">
							<span class="fas fa-times"></span>
							
						</span>
						<?php  }
						else{?>

							<span class="btn btn-success btn-sm disabled"  title="Otorgar" >
						<span class="fas fa-check-circle"></span>
						
						</span>
					
						<span class="btn btn-danger btn-sm disabled" title="Cancelar" >
							<span class="fas fa-times"></span>
							
						</span>

						<?php  } ?>



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
	ignoreCols: [6], 
	position: 'button',  // Posicion que se muestran los botones puedes ser: (top, bottom)
	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
	fileName: "Entidades Bancarias al <?php echo $fechaDeHoy;?>",    //Nombre del archivo 
});
</script>


