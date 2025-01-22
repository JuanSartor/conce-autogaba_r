<?php


include ("clases/conexion.php");

$conexion=conectar();



$sqlV="SELECT v.marca,v.modelo,v.dominio_patente,v.precio_venta,v.precio_compra from vehiculos v where  v.id='$_POST[id]'";

$resultV = mysqli_query($conexion,$sqlV);
$mostrarV=mysqli_fetch_array($resultV);


// gastos

$sql="SELECT g.monto,g.fecha_ingresada_por_usuario,p.descripcion from gastos_vehiculo g,
 proveedores p where g.id_vehiculo='$_POST[id]' and p.id=g.id_proveedor ";

$result = mysqli_query($conexion,$sql);
$cantFilasGastos=mysqli_num_rows($result);




// con esta consulta calculo el saldo final de la preventa, es decir lo que figuraba al presionar calcular saldo
// busco los pagos y sumo al saldo actual, teniendo en cuenta q no esten eliminado y la preventa sea la ultima
// editada

///////////////////////////////////////////////////////////////
// esta consulta estaba hasta que aparecio un error porque editarion y eliminaron volvieron a cargar.... era del
// vehiculo con id 19 
//////////////////////////////////////////////////////////////////

// $sqlSaldoPreventa="SELECT saldo_final_preventa+(SELECT SUM(monto) from pagos_preventa WHERE
// pagos_preventa.id_orden_preventa=operacion_preventa.id and pagos_preventa.eliminado='NO' 
// and operacion_preventa.eliminado='0' and operacion_preventa.id_vehiculo_prevendido='$_POST[id]' 
// and operacion_preventa.edicion=(SELECT MAX(edicion) from operacion_preventa where
// id_vehiculo_prevendido='$_POST[id]' and eliminado='0')) FROM `operacion_preventa` 
// where operacion_preventa.id_vehiculo_prevendido='$_POST[id]' and operacion_preventa.eliminado='0' 
// and operacion_preventa.edicion=(SELECT MAX(edicion) from operacion_preventa where
//  id_vehiculo_prevendido='$_POST[id]' and eliminado='0')";




$sqlSaldoPreventa="SELECT saldo_final_preventa+(SELECT SUM(monto) from pagos_preventa WHERE
pagos_preventa.id_orden_preventa=operacion_preventa.id and pagos_preventa.eliminado='NO' 
and operacion_preventa.eliminado='0' and operacion_preventa.id_vehiculo_prevendido='$_POST[id]' 
and operacion_preventa.edicion=(SELECT MAX(edicion) from operacion_preventa where
id_vehiculo_prevendido='$_POST[id]' and eliminado='0')) FROM `operacion_preventa` 
where operacion_preventa.id_vehiculo_prevendido='$_POST[id]' and operacion_preventa.eliminado='0' 
and operacion_preventa.id in (SELECT max(op1.id) FROM operacion_preventa op1 group by op1.id_real_preventa having SUM(op1.eliminado)=0)
group by operacion_preventa.id_real_preventa
having SUM(operacion_preventa.eliminado)=0 ";


$resultSaldoPreventa = mysqli_query($conexion,$sqlSaldoPreventa);
$mostrarSaldoPreventa=mysqli_fetch_array($resultSaldoPreventa);



// esta consulta estaba hasta que aparecio un error porque editarion y eliminaron volvieron a cargar.... era del
// vehiculo con id 19 

// $sqlDatosPreVenta="SELECT o.id,o.id_real_preventa,o.fecha_carga_preventa,o.monto_prendario,o.monto_sellado,
// o.entidad_prendaria,o.monto_personal,o.entidad_prendario_personal,o.efectivo_entregado,
// o.costo_transferencia,o.costo_informe,o.comision_vendedor,o.edicion,c.nombre,c.apellido,c.dni,
// u.nombre,u.apellido,u.dni
// from operacion_preventa o,clientes c,usuarios u where o.id_vehiculo_prevendido='$_POST[id]' and c.id=o.id_cliente
//   and o.eliminado='0' and u.id=o.id_vendedor and
//   o.edicion=(SELECT MAX(edicion) from operacion_preventa where
//  id_vehiculo_prevendido='$_POST[id]' and eliminado='0')";


$sqlDatosPreVenta="SELECT o.id,o.id_real_preventa,o.fecha_carga_preventa,o.monto_prendario,o.monto_sellado,
 o.entidad_prendaria,o.monto_personal,o.entidad_prendario_personal,o.efectivo_entregado,
 o.costo_transferencia,o.costo_informe,o.comision_vendedor,MAX(o.edicion),c.nombre,c.apellido,c.dni,
 u.nombre,u.apellido,u.dni
 from operacion_preventa o,clientes c,usuarios u where o.id_vehiculo_prevendido='$_POST[id]' 
 and c.id=o.id_cliente  and o.eliminado='0' and u.id=o.id_vendedor and
 o.id in (SELECT max(op1.id) FROM operacion_preventa op1 group by op1.id_real_preventa having SUM(op1.eliminado)=0)
group by o.id_real_preventa
having SUM(o.eliminado)=0 ";


$resultDatosPreventa = mysqli_query($conexion,$sqlDatosPreVenta);




$cantFilasPreventa=mysqli_num_rows($resultDatosPreventa);
$mostrarDatosPreventa=mysqli_fetch_array($resultDatosPreventa);


if($mostrarDatosPreventa[7]!='0' and $mostrarDatosPreventa[7]!=null ){
$sqlEntiPersonal="SELECT descripcion from entidades_prendarias where id='$mostrarDatosPreventa[7]'";
$resultDatosEPersonal = mysqli_query($conexion,$sqlEntiPersonal);
$mostrarDatosEPersonal=mysqli_fetch_array($resultDatosEPersonal);
}
else{

    $mostrarDatosEPersonal[0]='';

}

if($mostrarDatosPreventa[5]!='0' and $mostrarDatosPreventa[5]!=null ){
    $sqlEntiPre="SELECT descripcion from entidades_prendarias where id='$mostrarDatosPreventa[5]'";
    $resultDatosEPre = mysqli_query($conexion,$sqlEntiPre);
    $mostrarDatosEPre=mysqli_fetch_array($resultDatosEPre);
    }
    else{
    
        $mostrarDatosEPre[0]='';
    
    }






// obtengo los autos entregados como pago


$sqlAuEntre="SELECT marca,modelo,dominio_patente,precio_compra from vehiculos v, link_usados_entregados_preventa l 
where l.id_real_preventa='$mostrarDatosPreventa[1]' and l.edicion='$mostrarDatosPreventa[12]' and
v.id=l.id_vehiculo_usado and v.eliminado='NO' ";
$resultAutosEntregados = mysqli_query($conexion,$sqlAuEntre);
$cantFilasAutosEntregados=mysqli_num_rows($resultAutosEntregados);

// obtengo los cheques entregados como pago
$sqlChequesEntregados="SELECT c.fecha_cobro,c.numero_cheque,c.monto,e.descripcion from cheques c,entidades_prendarias e,
link_cheques_entregados_preventa l where c.eliminado='NO' and c.id=l.id_cheque and l.id_real_preventa='$mostrarDatosPreventa[1]'
and l.edicion='$mostrarDatosPreventa[12]' and e.id=c.id_entidad";
$resultChequesEntregados = mysqli_query($conexion,$sqlChequesEntregados);
$cantFilasChequesEntregados=mysqli_num_rows($resultChequesEntregados);


// obtengo los pagos
$sqlPagos="SELECT fecha_seteada_pago,monto,descripcion from pagos_preventa where
pagos_preventa.id_orden_preventa='$mostrarDatosPreventa[0]' and pagos_preventa.eliminado='NO'";
$resultPagos = mysqli_query($conexion,$sqlPagos);
$cantFilasPagos=mysqli_num_rows($resultPagos);


?>

<!-- modal para generar reportes -->

   <div class="modal-dialog" role="document" id="modalD" > 
    <div class="modal-content" style="width: 850px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reporte</h5>
        
      </div>  
      <div class="modal-body" id="modalb">
         <form id="frmactualizar"    action="reporteVehiculoExcel.php" method="post">  

    <input type="text" hidden id="idvehiculo" name="idvehiculo" value="<?php echo $_POST['id']; ?>">

<div class="row">
    	<div class="col-sm-4">
    <label style="font-size: 13px;">Marca</label>
	</div>
	<div class="col-sm-4">
    <label style="font-size: 13px;">Modelo</label>
</div>
<div class="col-sm-4">
	   <label style="font-size: 13px;">Dominio</label>
    </div>
</div>
<div class="row">
    <div class="col-sm-4" >
    <input  style="text-transform: capitalize; font-size: 13px; height: 25px;"   disabled value="<?php echo $mostrarV[0]; ?>" type="text" class="form-control input-sm" id="marcaR" name="marcaR"  minlength="2" maxlength="50">
</div>
    <div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled  value="<?php echo $mostrarV[1]; ?>"class="form-control input-sm" id="modeloR" name="modeloR"  maxlength="45" minlength="2" >
</div>
<div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo $mostrarV[2]; ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>
</div>
    <div class="row">
    <div class="col-sm-4">
	   <label style="font-size: 13px;">Precio Venta</label>
    </div>
    <div class="col-sm-4">
	   <label style="font-size: 13px;">Precio Compra</label>
    </div>
    
    </div>

    <div class="row">
<div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo number_format($mostrarV[3],2, "," , ".") ; ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>
<div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo number_format($mostrarV[4],2, "," , ".") ; ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>



        </div>
        <br>

        <?php
				if($cantFilasPreventa>0){
			
	
                    ?>
                    

        <div class="row">
    
    <div class="col-sm-4">
	   <label style="font-size: 13px;">Cliente</label>
    </div>
    <div class="col-sm-4">
	   <label style="font-size: 13px;">DNI</label>
    </div>
    </div>

    <div class="row">
<div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo  $mostrarDatosPreventa[13];echo" ";echo$mostrarDatosPreventa[14] ; ?>" class="form-control input-sm" >
</div>

<div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo  $mostrarDatosPreventa[15]; ?>" class="form-control input-sm" >
</div>

        </div>
        <?php
}
                
?>




<?php
				if($cantFilasGastos>0){
			
	
					?>

<br>

		<div class="col-sm-4">
    <label>Gastos</label>
	</div>
	<br>
	
<div class="row">
    	<div class="col-sm-4">
    <label style="font-size: 13px;">Fecha</label>
	</div>
	<div class="col-sm-4">
    <label style="font-size: 13px;">Monto</label>
</div>
<div class="col-sm-4">
	   <label style="font-size: 13px;">Proveedor</label>
	</div>
    </div>
<?php
				while ($mostrar=mysqli_fetch_array($result)) {
			
	
					?>




<div class="row">
    <div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" disabled value="<?php echo $mostrar[1]; ?>" type="text" class="form-control input-sm" id="marcaR" name="marcaR"  minlength="2" maxlength="50">
</div>
    <div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text"  disabled value="<?php echo number_format($mostrar[0],2, "," , "."); ?>"class="form-control input-sm" id="modeloR" name="modeloR"  maxlength="45" minlength="2" >
</div>
<div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo $mostrar[2]; ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>


		</div>

      
		<?php
}
                }
?>



<?php
				if($cantFilasPreventa>0){
			
	
                    ?>
                    


 <br>
    
             
 <div class="col-sm-4">
    <label>Pre Venta</label>
	</div>
  <br>



  <div class="row">
    	<div class="col-sm-4">
    <label style="font-size: 13px;">Vendedor</label>
    </div>
    <div class="col-sm-4">
	   <label style="font-size: 13px;">DNI</label>
    </div>

	
    </div>

    <div class="row">
    <div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" disabled value="<?php echo $mostrarDatosPreventa[16];echo' '; echo$mostrarDatosPreventa[17]; ?>" type="text" class="form-control input-sm" id="marcaR" name="marcaR"  minlength="2" maxlength="50">
</div> 
<div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;"  type="text" disabled value="<?php echo  $mostrarDatosPreventa[18]; ?>" class="form-control input-sm" >
</div>                                                                                    
    


		</div>











  <!-- ----------------------------------------------- -->
  
  <div class="row">
    	<div class="col-sm-4">
    <label style="font-size: 13px;">Fecha</label>
	</div>
	<div class="col-sm-4">
    <label style="font-size: 13px;">Monto PreVenta</label>
</div>
<div class="col-sm-4">
	   <label style="font-size: 13px;">Nro PreVenta</label>
	</div>
    </div>

    <div class="row">
    <div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" disabled value="<?php echo $mostrarDatosPreventa[2]; ?>" type="text" class="form-control input-sm" id="marcaR" name="marcaR"  minlength="2" maxlength="50">
</div>
    <div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text"  disabled value="<?php echo number_format($mostrarSaldoPreventa[0],2, "," , "."); ?>"class="form-control input-sm" id="modeloR" name="modeloR"  maxlength="45" minlength="2" >
</div>
<div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo $mostrarDatosPreventa[1]; ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>


		</div>



<!-- credito prendario -->
    <div class="row">
    	<div class="col-sm-3">
    <label style="font-size: 13px;">Credito</label>
	</div>
	<div class="col-sm-3">
    <label style="font-size: 13px;">Monto Prendario</label>
</div>
<div class="col-sm-3">
	   <label style="font-size: 13px;">Monto Sellado</label>
  </div>
  <div class="col-sm-3">
	   <label style="font-size: 13px;">Entidad</label>
	</div>
    </div>


    <div class="row">
    <div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" disabled value="<?php echo "Prendario"; ?>" type="text" class="form-control input-sm" id="marcaR" name="marcaR"  minlength="2" maxlength="50">
</div>
    <div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text"  disabled value="<?php echo number_format($mostrarDatosPreventa[3],2, "," , "."); ?>"class="form-control input-sm" id="modeloR" name="modeloR"  maxlength="45" minlength="2" >
</div>
<div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo number_format($mostrarDatosPreventa[4],2, "," , "."); ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>
<div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo $mostrarDatosEPre[0]; ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>

		</div>


<!-- credito personal -->


    <div class="row">
    	<div class="col-sm-4">
    <label style="font-size: 13px;">Credito</label>
	</div>
	<div class="col-sm-4">
    <label style="font-size: 13px;">Monto Personal</label>
</div>
<div class="col-sm-4">
	   <label style="font-size: 13px;">Entidad</label>
	</div>
    </div>

    <div class="row">
    <div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" disabled value="<?php echo "Personal"; ?>" type="text" class="form-control input-sm" id="marcaR" name="marcaR"  minlength="2" maxlength="50">
</div>
    <div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text"  disabled value="<?php echo number_format($mostrarDatosPreventa[6],2, "," , ".");?>"class="form-control input-sm" id="modeloR" name="modeloR"  maxlength="45" minlength="2" >
</div>
<div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo $mostrarDatosEPersonal[0]; ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>


		</div>



    <div class="row">
    	<div class="col-sm-3">
    <label style="font-size: 13px;">Efectivo Entregado</label>
	</div>
	<div class="col-sm-3">
    <label style="font-size: 13px;">Costo Transferencia</label>
</div>
<div class="col-sm-3">
	   <label style="font-size: 13px;">Costo Informe</label>
  </div>
  <div class="col-sm-3">
	   <label style="font-size: 13px;">Comision Vendedor</label>
	</div>
    </div>


    <div class="row">
    <div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" disabled value="<?php echo number_format($mostrarDatosPreventa[8],2, "," , "."); ?>" type="text" class="form-control input-sm" id="marcaR" name="marcaR"  minlength="2" maxlength="50">
</div>
    <div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text"  disabled value="<?php echo number_format($mostrarDatosPreventa[9],2, "," , "."); ?>"class="form-control input-sm" id="modeloR" name="modeloR"  maxlength="45" minlength="2" >
</div>
<div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo number_format($mostrarDatosPreventa[10],2, "," , "."); ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>
<div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo number_format($mostrarDatosPreventa[11],2, "," , "."); ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>

		</div>

		<?php
}
                
?>



<?php
				if($cantFilasAutosEntregados>0){
			
	
					?>

        <br>
    
             
    <div class="col-sm-4">
       <label>Usados Entregados</label>
       </div>
     <br>


     <div class="row">
    	<div class="col-sm-3">
    <label style="font-size: 13px;">Marca</label>
	</div>
	<div class="col-sm-3">
    <label style="font-size: 13px;">Modelo</label>
</div>
<div class="col-sm-3">
	   <label style="font-size: 13px;">Dominio</label>
  </div>
  <div class="col-sm-3">
	   <label style="font-size: 13px;">Precio Compra</label>
	</div>
    </div>


    <?php
				while ($mostrarAutosEntregados=mysqli_fetch_array($resultAutosEntregados)) {
			
	
					?>

    <div class="row">
    <div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" disabled value="<?php echo $mostrarAutosEntregados[0]; ?>" type="text" class="form-control input-sm" id="marcaR" name="marcaR"  minlength="2" maxlength="50">
</div>
    <div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text"  disabled value="<?php echo $mostrarAutosEntregados[1]; ?>"class="form-control input-sm" id="modeloR" name="modeloR"  maxlength="45" minlength="2" >
</div>
<div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo $mostrarAutosEntregados[2]; ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>
<div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo number_format($mostrarAutosEntregados[3],2, "," , ".") ; ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>

		</div>


		<?php
}
                }
?>


<?php
				if($cantFilasChequesEntregados>0){
			
	
					?>

     <br>
    
             
    <div class="col-sm-4">
       <label>Cheques Entregados</label>
       </div>
     <br>


     <div class="row">
    	<div class="col-sm-3">
    <label style="font-size: 13px;">Fecha Cobro</label>
	</div>
	<div class="col-sm-3">
    <label style="font-size: 13px;">Numero</label>
</div>
<div class="col-sm-3">
	   <label style="font-size: 13px;">Monto</label>
  </div>
  <div class="col-sm-3">
	   <label style="font-size: 13px;">Entidad</label>
	</div>
    </div>


    <?php
				while ($mostrarChequesEntregados=mysqli_fetch_array($resultChequesEntregados)) {
			
	
					?>

    <div class="row">
    <div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" disabled value="<?php echo $mostrarChequesEntregados[0]; ?>" type="text" class="form-control input-sm" id="marcaR" name="marcaR"  minlength="2" maxlength="50">
</div>
    <div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text"  disabled value="<?php echo $mostrarChequesEntregados[1]; ?>"class="form-control input-sm" id="modeloR" name="modeloR"  maxlength="45" minlength="2" >
</div>
<div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo number_format($mostrarChequesEntregados[2],2, "," , "."); ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>
<div class="col-sm-3">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo $mostrarChequesEntregados[3]; ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>

		</div>


		<?php
}
                }
?>



<?php
				if($cantFilasPagos>0){
			
	
					?>
<br>
<div class="col-sm-4">
       <label>Pagos</label>
       </div>
     <br>


     <div class="row">
    	<div class="col-sm-4">
    <label style="font-size: 13px;">Fecha</label>
	</div>
	<div class="col-sm-4">
    <label style="font-size: 13px;">Monto</label>
</div>
<div class="col-sm-4">
	   <label style="font-size: 13px;">Descripcion</label>
  </div>
 
    </div>


    <?php
				while ($mostrarPagos=mysqli_fetch_array($resultPagos)) {
			
	
					?>

    <div class="row">
    <div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" disabled value="<?php echo $mostrarPagos[0]; ?>" type="text" class="form-control input-sm" id="marcaR" name="marcaR"  minlength="2" maxlength="50">
</div>
    <div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text"  disabled value="<?php echo number_format($mostrarPagos[1],2, "," , "."); ?>"class="form-control input-sm" id="modeloR" name="modeloR"  maxlength="45" minlength="2" >
</div>
<div class="col-sm-4">
    <input style="text-transform: capitalize; font-size: 13px; height: 25px;" type="text" disabled value="<?php echo $mostrarPagos[2]; ?>" class="form-control input-sm" id="dominio_patenteR" name="dominio_patenteR"  maxlength="24" minlength="4">
</div>


		</div>


		<?php
}
                }
?>





	<div class="modal-footer">
		  <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cerrar</button>
		   <!-- <button type="submit" id="btnEditarNuevo" class="btn btn-primary" >Generar Excel</button>  -->
		</div>
  
  
   </form> 
  
  
		 </div>
		
	  </div>
	</div> 
  





<script>

function cerrarModal() {
  $("#modalReporte").modal('hide');//ocultamos el modal
  $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
  $('.modal-backdrop').remove();//eliminamos el backdrop del modal
  $("#modalB").modal('hide');
  $("#modalD").modal('hide');
  
}
</script>