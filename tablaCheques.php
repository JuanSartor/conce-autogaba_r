
<?php


include ("clases/conexion.php");



// estado 0 es a confirmar
// 1 es a cobrar
// 2 es cancelado
// 3 es cobrado

$conexion=conectar();

switch ($_GET['pme']) {
	case 't':{
        // cheques entregados en la preventa
        $sql="SELECT cheques.id,cheques.numero_cheque,cheques.monto,cheques.fecha_cobro,
entidades_prendarias.descripcion,cheques.usado,cheques.estado,o.id, v.dominio_patente
FROM cheques,entidades_prendarias,operacion_preventa o,link_cheques_entregados_preventa l, vehiculos v
 where cheques.eliminado='NO' and cheques.id_entidad=entidades_prendarias.id and 
 (cheques.estado='0' or cheques.estado='1' or cheques.estado='3' or cheques.estado='2' )
 and l.id_cheque=cheques.id and l.id_real_preventa=o.id_real_preventa  and l.edicion=o.edicion
 and o.eliminado='NO'and o.id_vehiculo_prevendido=v.id  ";




        // cheques entregados como pago

        $sqlChPa="SELECT cheques.id,cheques.numero_cheque,cheques.monto,cheques.fecha_cobro,
entidades_prendarias.descripcion,cheques.usado,cheques.estado,o.id ,v.dominio_patente
FROM cheques,entidades_prendarias,operacion_preventa o,link_cheques_como_pagos l,
pagos_preventa pa, vehiculos v where pa.eliminado='NO' and pa.tipo_ingreso='2' and
l.id_pago=pa.id and l.id_cheque=cheques.id and pa.id_orden_preventa=o.id 
and o.eliminado='NO' and cheques.id_entidad=entidades_prendarias.id 
and (cheques.estado='0' or cheques.estado='1' or cheques.estado='3' or cheques.estado='2' ) and o.id_vehiculo_prevendido=v.id ";
	
	break;
}
	

	case 'a':{ // a confirmar

		     // cheques entregados en la preventa
			 $sql="SELECT cheques.id,cheques.numero_cheque,cheques.monto,cheques.fecha_cobro,
			 entidades_prendarias.descripcion,cheques.usado,cheques.estado,o.id, v.dominio_patente 
			 FROM cheques,entidades_prendarias,operacion_preventa o,link_cheques_entregados_preventa l, vehiculos v
			  where cheques.eliminado='NO' and cheques.id_entidad=entidades_prendarias.id and 
			  cheques.estado='0' 
			  and l.id_cheque=cheques.id and l.id_real_preventa=o.id_real_preventa  and l.edicion=o.edicion
			  and o.eliminado='NO'and  o.id_vehiculo_prevendido=v.id  ";
			 
			 
			 
			 
					 // cheques entregados como pago
			 
					 $sqlChPa="SELECT cheques.id,cheques.numero_cheque,cheques.monto,cheques.fecha_cobro,
			 entidades_prendarias.descripcion,cheques.usado,cheques.estado,o.id ,v.dominio_patente
			 FROM cheques,entidades_prendarias,operacion_preventa o,link_cheques_como_pagos l,
			 pagos_preventa pa, vehiculos v where pa.eliminado='NO' and pa.tipo_ingreso='2' and
			 l.id_pago=pa.id and l.id_cheque=cheques.id and pa.id_orden_preventa=o.id 
			 and o.eliminado='NO' and cheques.id_entidad=entidades_prendarias.id 
			 and cheques.estado='0' and o.id_vehiculo_prevendido=v.id ";
				 


	break;

	}
	case 's':{

		     // cheques entregados en la preventa
			 $sql="SELECT cheques.id,cheques.numero_cheque,cheques.monto,cheques.fecha_cobro,
			 entidades_prendarias.descripcion,cheques.usado,cheques.estado,o.id , v.dominio_patente
			 FROM cheques,entidades_prendarias,operacion_preventa o,link_cheques_entregados_preventa l, vehiculos v
			  where cheques.eliminado='NO' and cheques.id_entidad=entidades_prendarias.id and 
			  cheques.estado='1'
			  and l.id_cheque=cheques.id and l.id_real_preventa=o.id_real_preventa  and l.edicion=o.edicion
			  and o.eliminado='NO' and o.id_vehiculo_prevendido=v.id and o.id_vehiculo_prevendido=v.id  ";
			 
			 
			 
			 
					 // cheques entregados como pago
			 
					 $sqlChPa="SELECT cheques.id,cheques.numero_cheque,cheques.monto,cheques.fecha_cobro,
			 entidades_prendarias.descripcion,cheques.usado,cheques.estado,o.id ,v.dominio_patente
			 FROM cheques,entidades_prendarias,operacion_preventa o,link_cheques_como_pagos l,
			 pagos_preventa pa, vehiculos v where pa.eliminado='NO' and pa.tipo_ingreso='2' and
			 l.id_pago=pa.id and l.id_cheque=cheques.id and pa.id_orden_preventa=o.id 
			 and o.eliminado='NO' and cheques.id_entidad=entidades_prendarias.id 
			 and  cheques.estado='1' and o.id_vehiculo_prevendido=v.id ";
				 

	break;
	}
	case 'r':{
     // cheques entregados en la preventa
	 $sql="SELECT cheques.id,cheques.numero_cheque,cheques.monto,cheques.fecha_cobro,
	 entidades_prendarias.descripcion,cheques.usado,cheques.estado,o.id , v.dominio_patente
	 FROM cheques,entidades_prendarias,operacion_preventa o,link_cheques_entregados_preventa l, vehiculos v
	  where cheques.eliminado='NO' and cheques.id_entidad=entidades_prendarias.id and 
	  cheques.estado='3'  
	  and l.id_cheque=cheques.id and l.id_real_preventa=o.id_real_preventa  and l.edicion=o.edicion
	  and o.eliminado='NO' and o.id_vehiculo_prevendido=v.id  ";
	 
	 
	 
	 
			 // cheques entregados como pago
	 
			 $sqlChPa="SELECT cheques.id,cheques.numero_cheque,cheques.monto,cheques.fecha_cobro,
	 entidades_prendarias.descripcion,cheques.usado,cheques.estado,o.id ,v.dominio_patente
	 FROM cheques,entidades_prendarias,operacion_preventa o,link_cheques_como_pagos l,
	 pagos_preventa pa, vehiculos v where pa.eliminado='NO' and pa.tipo_ingreso='2' and
	 l.id_pago=pa.id and l.id_cheque=cheques.id and pa.id_orden_preventa=o.id 
	 and o.eliminado='NO' and cheques.id_entidad=entidades_prendarias.id 
	 and  cheques.estado='3' and o.id_vehiculo_prevendido=v.id";
		 



	break;
	}
	case 'v':{ 


     // cheques entregados en la preventa
	 $sql="SELECT cheques.id,cheques.numero_cheque,cheques.monto,cheques.fecha_cobro,
	 entidades_prendarias.descripcion,cheques.usado,cheques.estado,o.id , v.dominio_patente
	 FROM cheques,entidades_prendarias,operacion_preventa o,link_cheques_entregados_preventa l, vehiculos v
	  where cheques.eliminado='NO' and cheques.id_entidad=entidades_prendarias.id and 
	  cheques.estado='2' 
	  and l.id_cheque=cheques.id and l.id_real_preventa=o.id_real_preventa  and l.edicion=o.edicion
	  and o.eliminado='NO' and o.id_vehiculo_prevendido=v.id ";
	 
	 
	 
	 
			 // cheques entregados como pago
	 
			 $sqlChPa="SELECT cheques.id,cheques.numero_cheque,cheques.monto,cheques.fecha_cobro,
	 entidades_prendarias.descripcion,cheques.usado,cheques.estado,o.id,v.dominio_patente
	 FROM cheques,entidades_prendarias,operacion_preventa o,link_cheques_como_pagos l,
	 pagos_preventa pa, vehiculos v where pa.eliminado='NO' and pa.tipo_ingreso='2' and
	 l.id_pago=pa.id and l.id_cheque=cheques.id and pa.id_orden_preventa=o.id 
	 and o.eliminado='NO' and cheques.id_entidad=entidades_prendarias.id 
	 and cheques.estado='2'and o.id_vehiculo_prevendido=v.id ";
		 


	break;
	}



}


$result = mysqli_query($conexion,$sql);
$resultChPa = mysqli_query($conexion,$sqlChPa);


$fechaActual= getdate();

$fechaDeHoy=$fechaActual['mday'].'-'.$fechaActual['mon'].'-'.$fechaActual['year'];


?>





<div>
	
	<link href="librerias/bootstrap/tableexport.css" rel="stylesheet" type="text/css">

	<table class="table table-hover table-condensed table-bordered" id="iddatatable">

		<thead  style="background-color:#ccc; color: white; font-weight: bold; ">
			<tr>
				<td style="font-size: 12px" >ID</td>
				<td style="font-size: 12px" >Numero</td>
				<td style="font-size: 12px">Monto</td>
				<td style="font-size: 12px">Fecha Cobro</td>
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
					<td style="font-size: 12px"> <?php echo $mostrar[0]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[1]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[2]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[3]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[4]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[8]?></td>
	
				    <td style="font-size: 12px"> <?php 
				    	if($mostrar[6]=='0'){
				    		echo "<div class=\"alert alert-warning\" role=\"alert\" style=\"height:35px\">A Confirmar</div> "; 
						}
						
						elseif($mostrar[6]=='1'){echo "<div class=\"alert alert-primary\" role=\"alert\" style=\"height:35px\" >A Cobrar</div> "; }
						elseif($mostrar[6]=='3'){echo "<div class=\"alert alert-success\" role=\"alert\" style=\"height:35px\" >Cobrado</div> "; }

						else{echo "<div class=\"alert alert-danger\" role=\"alert\" style=\"height:35px\" >Cancelado</div> "; }
				  

				   ?> </td>
					 
					 <td> 
					 <?php
						if($mostrar[6]=='0'){ ?>


						<span class="btn btn-warning btn-sm"  title="Otorgar"   onclick="aceptarCheque('<?php echo $mostrar[0] ?>')">
						<span class="fas fa-check-circle"></span>
						
						</span>

					<?php }
						else{ ?>

                 		<span class="btn btn-warning btn-sm disabled"  title="Otorgar" >
						<span class="fas fa-check-circle"></span>
						
						</span>


						<?php }
						 if($mostrar[6]!='3'){ ?>

						<span class="btn btn-danger btn-sm" title="Cancelar" onclick="cancelarCheque('<?php echo $mostrar[0] ?>')">
							<span class="fas fa-times"></span>
							
						</span>
						<?php }
						
						else{ ?>
							<span class="btn btn-danger btn-sm disabled" title="Cancelar" >
							<span class="fas fa-times"></span>
							
						</span>



						<?php }
						if($mostrar[6]=='1'){ ?>
						<span class="btn btn-primary btn-sm"  title="Cobrado"   onclick="cobrarCheque('<?php echo $mostrar[0] ?>')">
						<span class="fas fa-money-check-alt"></span>
						
						
						<?php }
						else{ ?>

			<span class="btn btn-primary btn-sm disabled"   title="Cobrado"   >
						<span class="fas fa-money-check-alt"></span>
						
						</span>


						<?php } ?>

					</td> 
					

				</tr>







<?php
}
?>

<?php
				while ($mostrar=mysqli_fetch_array($resultChPa)) {
			
		
					?>

				<tr style="background-color: white;">
				<td style="font-size: 12px"> <?php echo $mostrar[0]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[1]?> </td>
					<td style="font-size: 12px"> <?php echo $mostrar[2]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[3]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[4]?></td>
					<td style="font-size: 12px"> <?php echo $mostrar[8]?></td>
				    <td style="font-size: 12px"> <?php 
				    	if($mostrar[6]=='0'){
				    		echo "<div class=\"alert alert-warning\" role=\"alert\" style=\"height:35px\">A Confirmar</div> "; 
						}
						
						elseif($mostrar[6]=='1'){echo "<div class=\"alert alert-primary\" role=\"alert\" style=\"height:35px\" >A Cobrar</div> "; }
						elseif($mostrar[6]=='3'){echo "<div class=\"alert alert-success\" role=\"alert\" style=\"height:35px\" >Cobrado</div> "; }
	
						else{echo "<div class=\"alert alert-danger\" role=\"alert\" style=\"height:35px\" >Cancelado</div> "; }
				  

				   ?> </td>
					 
					 <td> 
					 <?php
						if($mostrar[6]=='0'){ ?>


						<span class="btn btn-warning btn-sm"  title="Otorgar"   onclick="aceptarCheque('<?php echo $mostrar[0] ?>')">
						<span class="fas fa-check-circle"></span>
						
						</span>

					<?php }
						else{ ?>

                 		<span class="btn btn-warning btn-sm disabled"  title="Otorgar" >
						<span class="fas fa-check-circle"></span>
						
						</span>


						<?php } 

						

						
						 if($mostrar[6]!='3'){ ?>

						<span class="btn btn-danger btn-sm" title="Cancelar" onclick="cancelarCheque('<?php echo $mostrar[0] ?>')">
							<span class="fas fa-times"></span>
							
						</span>
						<?php }
						
						else{ ?>
							<span class="btn btn-danger btn-sm disabled" title="Cancelar" >
							<span class="fas fa-times"></span>
							
						</span>



						












						<?php  }
						if($mostrar[6]=='1'){ ?>
						<span class="btn btn-primary btn-sm"  title="Cobrado"   onclick="cobrarCheque('<?php echo $mostrar[0] ?>')">
						<span class="fas fa-money-check-alt"></span>
						
						
						<?php }
						else{ ?>

			<span class="btn btn-primary btn-sm disabled"   title="Cobrado"   >
						<span class="fas fa-money-check-alt"></span>
						
						</span>


						<?php } ?>

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
	ignoreCols: [7], 
	position: 'button',  // Posicion que se muestran los botones puedes ser: (top, bottom)
	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
	fileName: "Cheques al <?php echo $fechaDeHoy;?>",    //Nombre del archivo 
});
</script>



