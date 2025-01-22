 <?php  
      session_start();  
      if(isset($_SESSION["usernameC"]))  
      {  
           if((time() - $_SESSION['last_login_timestamp']) > 36000 or $_SESSION["permisos"]=='4') // 900 = 15 * 60   el 60 son segundos
           {  
                header("location:logout.php");  
           }  
           else  
           {  
                $_SESSION['last_login_timestamp'] = time();  
                
           }  
      }  
      else  
      {  
           header('location:inicio.php');  
      }  
      ?>


<!DOCTYPE html>
<html>
<head>

      <?php require_once "scripts.php";
      include ("clases/conexion.php");

           $conexionLogueado= conectar();
    mysqli_set_charset($conexionLogueado,'utf8'); 
    $sqllog= "SELECT * from usuarios where id='$_SESSION[idC]'";

    $resultadologuin=mysqli_query($conexionLogueado,$sqllog);

    mysqli_close($conexionLogueado);

    $mostrarloguin=mysqli_fetch_array($resultadologuin);




        $banderaAcceso=base64_decode($_GET['datos33']);

       if($banderaAcceso=='1'){  // esto significa que va a editar
      $id=base64_decode($_GET['datos']);

        $conexionRegistroActualizar= conectar();
    mysqli_set_charset($conexionRegistroActualizar,'utf8'); 
    $sqlreg= "SELECT * from operacion_preventa where id='$id'";

    $resultadoRegistro=mysqli_query($conexionRegistroActualizar,$sqlreg);

    mysqli_close($conexionRegistroActualizar);

    $mostrarReg=mysqli_fetch_array($resultadoRegistro);


     $conexionActualizarEstadoVehiculo= conectar();
     $sqlActuEstaVehi= "UPDATE vehiculos set id_estado='1'  where id  IN ($mostrarReg[id_usados_entregados])";
     mysqli_query($conexionActualizarEstadoVehiculo,$sqlActuEstaVehi);

        mysqli_close($conexionActualizarEstadoVehiculo);
      

      }
      else{

      	$mostrarReg['id_usados_entregados']='';
      	$mostrarReg['efectivo_entregado']='';
      	$mostrarReg['monto_sellado']='';
      	$mostrarReg['monto_prendario']='';
        $mostrarReg['monto_personal']='';
      	$mostrarReg['costo_informe']='';
      	$mostrarReg['costo_transferencia']='';
      	$mostrarReg['comision_vendedor']='';
      	$mostrarReg['observaciones']='';
     
      	$mostrarReg['fecha_carga_preventa']='';
        $mostrarReg['id_cheques_entregados']='';
        $mostrarReg['id']='';
         $mostrarReg['id_vendedor']='0';
         $mostrarReg['medio_contacto']='0';
          $mostrarReg['id_cliente']='0';
           $mostrarReg['id_vehiculo_prevendido']='0';
           $mostrarReg['entidad_prendario_personal']='0';
           $mostrarReg['entidad_prendaria']='0';
      }
    

        ?>
    <!-- Required meta tags -->

 
<meta content="width=device-width, initial-scale=1.0" name="viewport" >
    
    <!-- Bootstrap CSS -->
<!--     <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"> -->
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css"> 
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <!-- <link rel="stylesheet" href="assets/vendor/charts/chartist-bundle/chartist.css"> -->
    <!--     <link rel="stylesheet" href="assets/vendor/charts/morris-bundle/morris.css"> -->
    <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <!--  <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css"> -->
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">



    <title>Concesionaria</title>

  

</head>

<body>
  <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
            <a class="navbar-brand" id="linkIndex" name="linkIndex" href="index.php">  <img src="static/img/gaba.jpeg" height="48" width="48"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                 <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                       
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/logout.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name" id="NombreLoguin"></h5>
                                    <span class="status"></span><span class="ml-2">Conectado</span>
                                </div>
                                <a class="dropdown-item" href="logout.php"><i class="fas fa-power-off mr-2"></i>Cerrar Sesion</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" id="linkUsuarios"   href="usuarios.php" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-user"></i>Usuarios</a>
                                
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="clientes.php"  aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-hands-helping"></i>Clientes</a>
                               
                            </li>
                          <!--    <li class="nav-item">
                                <a class="nav-link" href="vendedores.php"  aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-hand-holding-usd"></i>Vendedores</a>
                             
                            </li> -->
                            <!-- <li class="nav-item ">
                                <a class="nav-link" href="automoviles.php"  aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-car"></i>Automoviles</a>
                               
                            </li> -->
                            <li class="nav-item" id="linkAutomoviles" name="linkAutomoviles">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-88" aria-controls="submenu-6"><i class="fas fa-car"></i> Automoviles </a>
                                <div id="submenu-88" class="collapse submenu ">
                                    <ul class="nav flex-column">
                                          <li class="nav-item ">
                                  <a class="nav-link" href="automoviles.php"   aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-car"></i>Gestionar Automoviles</a>
                                
                            </li>

                        
                            <li class="nav-item">
                                <a class="nav-link" href="buscarInfoAuto.php"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-dollar-sign"></i>Buscar Precio Info Auto</a>
                                            
                            </li>
                 
                                                                                
                                    </ul>
                                </div>
                            </li>
                           
                            <li class="nav-divider">
                                OPERACIONES
                            </li>

                               
                            <li class="nav-item">
                                 <a class="nav-link" href="consumos.php" id="linkMovimientos"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-money-bill-wave"></i>Movimientos Varios</a>

                                                       
                            </li>
                                     <li class="nav-item">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse"  aria-expanded="true" data-target="#submenu-66" aria-controls="submenu-66"><i class="fas fa-calculator"></i> Ventas </a>
                                <div id="submenu-66" class="collapse submenu show" >
                                    <ul class="nav flex-column">
                                          <li class="nav-item">
                                  <a class="nav-link active" href="#"><i class="fab fa-wpforms"></i>Nueva Pre-Venta</a>
                                

                            </li>



                            <li class="nav-item">
                            
                                <a class="nav-link" id="linkVentasExistentes" href="gestionarPagos.php"><i class="fas fa-dollar-sign"></i>Ventas Existentes</a>

                                                       
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="aprobarPreVentas.php"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-registered"></i>Aprobar Pre-Ventas</a>

                                
                            </li>
                           <!--  <li class="nav-item">
                                <a class="nav-link" href="pagos.php"><i class="fas fa-cash-register"></i>Lista Pagos Realizados</a>

                                                       
                            </li> -->
                                                                                
                                    </ul>
                                </div>
                            </li>
                            
                            <!--  <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-calculator"></i> Cajas </a>
                                <div id="submenu-6" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link"  data-toggle="modal" data-target ="#agregarnuevosdatosmodalCaja">Alta Caja</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link"  data-toggle="modal" data-target ="#inicializarCajaModal">Inicializar Caja</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link"  data-toggle="modal" data-target ="#cerrarCajaModal">Cerrar Caja</a>
                                        </li>                                          
                                    </ul>
                                </div>
                            </li> -->
                             <li class="nav-item">
                                <a class="nav-link" href="#" id="linkOtros" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-columns"></i>Otros</a>
                                <div id="submenu-8" class="collapse submenu" >
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="entidadesBancarias.php">Entidades Bancarias</a>
                                        </li>
                                       <!--  <li class="nav-item">
                                            <a class="nav-link" href="marcasVehiculo.php">Marcas de Vehiculos</a>
                                        </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="lugarVehiculo.php">Alojamientos de Vehiculos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="estadosVehiculo.php">Estados de Vehiculos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="sucursales.php">Sucursales</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="tipoVehiculos.php">Tipos de Vehiculos</a>
                                        </li>
                                         <li class="nav-item">
                                            <a class="nav-link" href="proveedores.php">Proveedores</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="gastosVehiculo.php">Lista Gastos Vehiculo</a>
                                        </li>
                                         <li class="nav-item">
                                            <a class="nav-link" href="medio_contacto.php">Medios de Contacto</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="tipoIngresos.php">Tipos de Ingresos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="creditosPrendarios.php">Creditos Prendarios</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="creditosPersonales.php">Creditos Personales</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="cheques.php">Cheques/Pagare</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="cheques.php">Cheques</a>
                                        </li>
                                         <li class="nav-item">
                                            <a class="nav-link" href="opCajas.php">Operaciones de Cajas</a>
                                        </li> -->
                                    </ul>
                                </div>
                            </li>
                         
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            
                    
                  


                    

                    <!-- parte principal de la pagina -->


<div class="container">

        <div class="row">
            <div class="col-sm-12">
     
                <div class="card text-center">
                    <div class="card-header">
                         PRE-VENTA

                                               
                    </div>

                    <div class="card-body">
                        


<div class="row">
        

	<div class="col-sm-1" >


		<label style="font-size: 13px">Vendedor: </label>
	</div>


	<div class="col-sm-4" >
		<div class="selector-vendedor"> 
			
			<select id="selectVendedor" onchange="cargarClientes();" name="selectVendedor"style="background-color: gainsboro; width: 340px;" required="true" class='mi-selectorVendedor' onchange="cambiarBtnGenerarPreventa();" value="0"></select>
			
			
			
		</div>
	</div>



	<div class="col-sm-1" >
		<button type="button"  class="btn btn-primary mb-1" style="font-size: 10px;" id="btnNuevoVendedor" name="btnNuevoVendedor" data-toggle="modal" data-target ="#agregarnuevoVendedor"  style="width: 50px "> <span class="fas fa-plus-circle"></span> </button>
	</div>



	<div class="col-sm-1 " >
		<label style="font-size: 13px;">Fecha: </label>   
	</div>

	<div class="col-sm-2">
		<input style="height: 30px; font-size: 12px;" type="date" class="form-control input-sm" id="fechaCargaPreVenta" name="fechaCargaPreVenta"  minlength="4" maxlength="24" value="<?php echo date("Y-m-d"); ?>">
	</div>


</div>











<div class="row">
     


	<div class="col-sm-1" >


		<label style="font-size: 13px">Clientes: </label>
	</div>


	<div class="col-sm-4" >
		<div class="selector-cliente"> 
			
			<select id="selectCliente" name="selectCliente"style="background-color: gainsboro; width: 340px;" required="true" class='mi-selectorCliente' onchange ="asignarTelefono()"  value="0" ></select>
			
			
			
		</div>
	</div>


     
        <div class="col-sm-1 " >

<button type="button"  class="btn btn-primary mb-1" style="font-size: 10px; " id="btnNuevoCliente" name="btnNuevoCliente" data-toggle="modal" data-target ="#agregarnuevoCliente"  style="width: 50px "> <span class="fas fa-plus-circle"></span> </button>

</div>
<div class="col-sm-1 " >
<label style="font-size: 13px;">Telefono: </label>   
</div>

<div class="col-sm-2">
    <input  style="height: 30px" type="text" class="form-control input-sm" id="telefono" name="telefono"  maxlength="24" minlength="1"   disabled="true">
    </div>

</div>

   
<div class="row">



	<div class="col-sm-1" >


		<label style="font-size: 13px">Vehiculo: </label>
	</div>


	<div class="col-sm-4" >
		<div class="selector-vehiculo"> 
			
			<select id="selectVehiculo" name="selectVehiculo"style="background-color: gainsboro; width: 340px;" required="true" class='mi-selectorVehiculo' value="0"  onchange="asignarPrecioVentaDominio()" ></select>
			
			
			
		</div>
	</div>



            <div class="col-sm-1 " >
<button type="button"   class="btn btn-primary mb-1" style="font-size: 10px;" id="btnNuevoVehiculo" name="btnNuevoVehiculo" data-toggle="modal" data-target ="#agregarnuevosdatosmodalNuevo"  style="width: 50px "> <span class="fas fa-plus-circle"></span> </button>

</div>


<div class="col-sm-1 " >
<label style="font-size: 13px;">Precio Venta: </label>   
</div>

<div class="col-sm-2">
    <input  style="height: 30px" type="text" class="form-control input-sm" id="precioVenta" name="precioVenta"  maxlength="24" minlength="1"  pattern="[0-9]+(\.[0-9]{1,2})?%?" disabled="true">
    </div>


    <div class="col-sm-1 " >
<label style="font-size: 13px;">Dominio: </label>   
</div>

<div class="col-sm-2">
    <input  style="height: 30px" type="text" class="form-control input-sm" id="dominioPatente" name="dominioPatente"  maxlength="24" minlength="1"  pattern="[0-9]+(\.[0-9]{1,2})?%?" disabled="true">
    </div>



</div> <!-- div del row -->



<hr>

   <div class="col-sm-2 " >
<label style="font-size: 15px; text-decoration: underline black; ">Operacion</label>   
</div>
<br>






<div class="row container">
        

	<div class="col-sm-2">

     <input type="checkbox" class="form-check-input" id="checkUsado" name="checkUsado" onchange="cambiarBtnGenerarPreventa();"  >
     <label style="font-size: 13px" class="form-check-label" for="exampleCheck1">Entregar Usado</label>

</div>

<div class="col-sm-4" ></div>
	<div class="col-sm-2">  

     <input type="checkbox" class="form-check-input" onchange="cambiarBtnGenerarPreventa();"  id="checkCredito" name="checkCredito" value="0">
     <label style="font-size: 13px" class="form-check-label" for="exampleCheck1">Credito Prendario</label>

</div>
<div class="col-sm-2"></div>
<div class="col-sm-2">

     <input type="checkbox" class="form-check-input" onchange="cambiarBtnGenerarPreventa();"  id="checkCreditoPersonal" name="checkCreditoPersonal" value="0">
     <label style="font-size: 13px" class="form-check-label" for="exampleCheck1">Credito Personal</label>

</div>


</div>
<br>


		<!-- <label style="font-size: 13px">Canjes: </label> -->
	

<div class="row container">
	<div class="col-sm-4"  id="divVehiculoCanje" >
		<div class="selector-vehiculoCanje" style="font-size: 11px;"  > 
			
			<select id="selectVehiculoCanje" onchange="cambiarBtnGenerarPreventa();"  name="selectVehiculoCanje"style="background-color: gainsboro; width: 340px;" required="true" class='mi-selectorVehiculoCanje' multiple="true" disabled="true"></select>
			
			
			
		</div>
	</div>


	<div class="col-sm-1"   id="divbtnNuevoVehiculoCanje" >
		<button type="button"  class="btn btn-primary mb-1" style="font-size: 10px;" id="btnNuevoVehiculoCanje" data-toggle="modal" data-target ="#agregarnuevosdatosmodal" onclick="cargarMarcasC();" style="width: 50px " disabled="true"> <span class="fas fa-plus-circle"></span> </button>
	</div>







<?php 

	$conexionEntidadPrendaria= conectar();
	mysqli_set_charset($conexionEntidadPrendaria,'utf8'); 
	$sqlc= "SELECT * from entidades_prendarias where eliminado='NO'";

	$resultadoEntidad=mysqli_query($conexionEntidadPrendaria,$sqlc);

  mysqli_set_charset($conexionEntidadPrendaria,'utf8'); 
  $sqlca= "SELECT * from entidades_prendarias where eliminado='NO'";

  $resultadoEntidada=mysqli_query($conexionEntidadPrendaria,$sqlca);

	mysqli_close($conexionEntidadPrendaria);
	
		 ?>

		 <div class="col-sm-1"></div>

		<div class="col-sm-2">
		<!-- <div style="width: 56px;  margin-left: 30px;" > -->
		<label style="font-size: 13px">Entidad:</label>
	</div>
	<div class="col-sm-2" >
<select id="idEntidad" name="idEntidad" style="background-color: gainsboro; " required="true" disabled="true">
				<?php

				while ($valoresEntidad = mysqli_fetch_array($resultadoEntidad)) {
					?>
					<option value="<?php print($valoresEntidad['id']);?>"> <?php  print($valoresEntidad['descripcion']);?> </option>

					<?php
				}
				?>
			</select>

</div>

  <div class="col-sm-1" >
<select id="idEntidadCpersonal" name="idEntidadCpersonal" style="background-color: gainsboro; " required="true" disabled="true">
        <?php

        while ($valoresEntidada = mysqli_fetch_array($resultadoEntidada)) {
          ?>
          <option value="<?php print($valoresEntidada['id']);?>"> <?php  print($valoresEntidada['descripcion']);?> </option>

          <?php
        }
        ?>
      </select>

</div>

	

	


</div>

<div class="row container">
		<div class="col-sm-6"> </div>
<div class="col-sm-2">
    <label style="font-size: 13px">Monto Prendario</label>
    </div>
    <div class="col-sm-2">
    <input style="height: 30px" type="text" class="form-control input-sm" id="montoPrendario" name="montoPrendario"  minlength="1" maxlength="15" pattern="[0-9]+(\.[0-9]{1,2})?%?" disabled="true">
         </div>
<div class="col-sm-2">
    <input style="height: 30px" type="text" class="form-control input-sm" id="montoPersonal" name="montoPersonal"  minlength="1" maxlength="15" pattern="[0-9]+(\.[0-9]{1,2})?%?" disabled="true">
         </div>
       </div>
<br>


       <div class="row container">
       	<div class="col-sm-6"> </div>
<div class="col-sm-2">
    <label style="font-size: 13px">Monto de Sellado</label>
    </div>
    <div class="col-sm-2">
    <input style="height: 30px" type="text" value="0" class="form-control input-sm" id="montoSellado" name="montoSellado"  onchange="cambiarBtnGenerarPreventa();"  minlength="1" maxlength="15" pattern="[0-9]+(\.[0-9]{1,2})?%?" disabled="true">
         
        </div>
    </div>





<div class="row container">
	<div class=" col-sm-6"></div>
	<div class=" col-sm-6"><hr> </div>
</div>


   




<div class="row container">




	<div class="col-sm-2" style="left: -20px">

     <input type="checkbox" class="form-check-input" onchange="cambiarBtnGenerarPreventa();"  id="checkCheque">
     <label style="font-size: 13px;" class="form-check-label" for="exampleCheck1">Cheques</label>

</div>
</div>
<br>
<form  id="formularioOrdenPreventa" name="formularioOrdenPreventa" >
<div class="row container">


<!-- <div class="col-sm-1" >


		<label style="font-size: 13px">Cheques: </label>
	</div> -->


	<input style="text-transform: capitalize;" type="text" class="form-control input-sm" id="idPreVenta" name="idPreVenta"   maxlength="95" hidden="true">
	<div class="col-sm-4" >
		<div class="selector-cheque " style="font-size: 11px;"> 
			
			<select id="selectCheque" onchange="cambiarBtnGenerarPreventa();"  name="selectCheque"style="background-color: gainsboro; width: 340px;" required="true" class='mi-selectorCheque' multiple="true" disabled="true" ></select>
			
			
			
		</div>
	</div>



	<div class="col-sm-1" >
		<button type="button"  class="btn btn-primary mb-1" style="font-size: 10px;" id="btnNuevoCheque" data-toggle="modal" data-target ="#agregarnuevoCheque"  style="width: 50px " disabled="true"> <span class="fas fa-plus-circle"></span> </button>
	</div>


















<!-- <div style="width: 302px"> -->
	<div class="col-sm-1"></div>
  <div class="col-sm-2" hidden>
<label style="font-size: 13px">Entrega Efectivo:</label>
</div>
<div class="col-sm-2" hidden>
<input style="height: 30px" value="0" type="text" class="form-control input-sm" id="entregaEfectivo" name="entregaEfectivo"  minlength="1" maxlength="15" value="0" pattern="[0-9]+(\.[0-9]{1,2})?%?">
</div>



  </div>



</div>

<br>



      
    
<hr>


<br>



<div class="row container ">
      <div class="col-sm-2">
    <label style="float: left;" >Medio de Contacto </label>
  </div>
</div>
<div class="row container ">
 <div class="col-sm-4">
    <div class="selector-medio"> 
      
      <select id="selectMedio" name="selectMedio"style="background-color: gainsboro; width: 340px;" required="true" class='mi-selectorMedio' value="0"></select>
      
      </div>
      </div>
    </div>
 


<br>

 <br>

<div class="col-10" >
<label style="float: left;" >Observaciones</label>
 <input style="text-transform: capitalize; height: 30px" type="text" class="form-control input-sm" id="observaciones" name="observaciones"   maxlength="249"> 

</div>


<br>



<br>
<br>





<div class="row container">
 <div class="col-sm-2 " >
<label style="font-size: 13px;">Costo Transferencia: </label>   
</div>

<div class="col-sm-2">
    <input  style="height: 30px" type="text" class="form-control input-sm" id="costoTransferencia" name="costoTransferencia"  maxlength="24" minlength="1"  value="0"  pattern="[0-9]+(\.[0-9]{1,2})?%?">
    </div>

 <div class="col-sm-2 " >
<label style="font-size: 13px;">Costo Informes: </label>   
</div>

<div class="col-sm-2">
    <input  style="height: 30px" type="text" class="form-control input-sm" id="costoInforme" name="costoInforme"  maxlength="24" minlength="1" value="0"  pattern="[0-9]+(\.[0-9]{1,2})?%?">
    </div>
 

    








</div>


<br>


<div class="row container">
 <div class="col-sm-2 " >
<label style="font-size: 13px;">Comisión Vendedor: </label>   
</div>

<div class="col-sm-2">
    <input  style="height: 30px" type="text" class="form-control input-sm" id="comisionVendedor" name="comisionVendedor"  maxlength="24" minlength="1"  value="0" pattern="[0-9]+(\.[0-9]{1,2})?%?">
    </div>
    
    
     <div class="col-sm-2 " >

     <label style="font-size: 13px;">Saldo: </label>  
</div>

<div class="col-sm-2">
    <input  style="height: 30px" type="text" class="form-control input-sm" id="saldoApagar" name="saldoApagar" disabled="true"   pattern="[0-9]+(\.[0-9]{1,2})?%?" value="0">
    </div>


</div>

<br>



<br>
    <br>


<div class="row">
<div class="col-sm-3">
</div>
<div class="col-sm-2">
                <button   onclick="aprobarPreVenta()"     class="btn btn-success" id="btnGenerarOrdenPreVenta" name="btnGenerarOrdenPreVenta">Aprobar</button>
                </div>
                
                <div class="col-sm-2">
                <button   onclick="rechazarPreVenta()"     class="btn btn-danger" id="btnGenerarOrdenPreVenta" name="btnGenerarOrdenPreVenta">Rechazar</button>
                </div>
                <div class="col-sm-2">
                <button   onclick="revisarPreVenta()"     class="btn btn-primary" id="btnGenerarOrdenPreVenta" name="btnGenerarOrdenPreVenta">Corregir</button>
                </div>
</div>
            






</form>
<br>
<br>

</div>






                        
          </div>              
                        

                    </div>
                    
                </div>


            </div>
      


        </div>


    </div>

    <!--   <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                       
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);"> <i class="fab fa-facebook-square"></i></a>
                                <a href="javascript: void(0);"><i class="fab fa-instagram"></i></a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
              
         
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
   <!--  <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script> -->
    <!-- bootstap bundle js -->
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>  
    <!-- slimscroll js -->
     <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
     <script src="assets/libs/js/main-js.js"></script> 
    <!-- chart chartist js -->
 <!--    <script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script> -->
    <!-- sparkline js -->
    <!-- <script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script> -->
    <!-- morris js -->
    <!-- <script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="assets/vendor/charts/morris-bundle/morris.js"></script> -->
    <!-- chart c3 js -->
<!--     <script src="assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="assets/vendor/charts/c3charts/C3chartjs.js"></script> -->
    <!-- <script src="assets/libs/js/dashboard-ecommerce.js"></script> -->

 

 <!-- Modal agregar caja -->
<div class="modal fade" id="agregarnuevosdatosmodalCaja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Caja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevo" onsubmit="return nuevaCaja();"  action="" method="post">
    <label>Nombre</label>
    <input type="text" class="form-control input-sm" id="nombreCaja" name="nombreCaja" required minlength="4" maxlength="29" required="true">
    <label>Descripción</label>
     <input type="text" class="form-control input-sm" id="descripcionCaja" name="descripcionCaja" required minlength="4" maxlength="59" >
   <label>Monto Inicial</label>
   <input style="height: 30px" type="text" class="form-control input-sm" id="montoInicialCajaNueva" name="montoInicialCajaNueva"  maxlength="24" minlength="1"  pattern="[0-9]+(\.[0-9]{1,2})?%?" value="0">
  
    <br>
    
       
 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnAgregarNuevo" class="btn btn-primary" >Crear Nuevo</button>
      </div>

</form>
 

      </div>
      
    </div>
  </div>
</div>

 <!-- Modal inicializar caja -->
<div class="modal fade" id="inicializarCajaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Abrir Caja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevoInicializar" onsubmit="return inicializarCaja();"  action="" method="post">


<div class="row">
          
    
   <div class="col-sm-1">
        
        <label style="font-size: 14px">Caja:</label>
    </div>

        <div class="col-sm-5">
        <div class="selector-cajaIncializar "> 
            
            <select id="selectCajaInicializar" name="selectCajaInicializar"style="background-color: gainsboro; width: 170px;" required="true" class='mi-selector' onchange ="asignarSaldoInicial()"  ></select>
            
            
            
        </div>
    </div>


      <div class="col-sm-2">
     <label style="font-size: 14px">Monto:</label>
    </div>

    <div class="col-sm-3">
   <input  style="height: 25px" type="text" class="form-control input-sm" id="montoInicialCaja" name="montoInicialCaja"  maxlength="24" minlength="1"  pattern="[0-9]+(\.[0-9]{1,2})?%?" >
</div>




</div>





   
    
  
    <br>
    
       
 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnAgregarNuevo" class="btn btn-primary" >Inicializar</button>
      </div>

</form>
 

      </div>
      
    </div>
  </div>
</div>



<!-- Modal Cerrar caja -->
<div class="modal fade" id="cerrarCajaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cerrar Caja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevoCerrarCaja" onsubmit="return cerrarCaja();"  action="" method="post">



    

<div class="row">
          
        <div class="col-sm-1">
        
        <label style="font-size: 14px">Caja:</label>
    </div>

        <div class="col-sm-5">
        <div class="selector-cajaCierre "> 
            
            <select id="selectCajaCierre" name="selectCajaCierre"style="background-color: gainsboro; width: 170px;" required="true" class='mi-selector' onchange ="asignarSaldoCierre()"  ></select>
            
            
            
        </div>
    </div>


<div class="col-sm-2">
<label style="font-size: 14px">Saldo:</label>
</div>
<div class="col-sm-3">
 <input  style="height: 25px" type="text" class="form-control input-sm" id="saldoCierre" name="saldoCierre"  maxlength="24" minlength="1"  pattern="[0-9]+(\.[0-9]{1,2})?%?" disabled="true" >
</div>

</div>



    
  
    <br>
    
       
 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnAgregarNuevo" class="btn btn-primary" >Cerrar Caja</button>
      </div>

</form>
 

      </div>
      
    </div>
  </div>
</div>


</body>

<!-- Modal agregar vendedor -->
<div class="modal fade" id="agregarnuevoVendedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Vendedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevo" onsubmit="return nuevoVendedor();"  action="" method="post">
    <label>Usuario</label>
    <input type="text" class="form-control input-sm" id="usuario" name="usuario" required minlength="4" maxlength="19">
    <label>Contraseña</label>
    <input type="text" class="form-control input-sm" id="pw" name="pw"  minlength="4" maxlength="15">
    <label>Nombre</label>
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="nombreV" name="nombreV" required minlength="4" maxlength="59" pattern="^[a-zA-Z\s]+">
    <label>Apellido</label>
    <input style="text-transform: capitalize;" type="text" class="form-control input-sm" id="apellidoV" name="apellidoV" required minlength="4" maxlength="39" pattern="^[a-zA-Z\s]+">
    <label>Email</label>
    <input type="email" class="form-control input-sm" id="correoV" name="correoV"  maxlength="59" minlength="4">
     <label>DNI</label>
    <input type="text" class="form-control input-sm" id="dniV" name="dniV"  maxlength="24" minlength="4" pattern="[0-9]+">
     <label>Telefono</label>
    <input type="text" class="form-control input-sm" id="telefonoV" name="telefonoV"  maxlength="29" minlength="4" >
    <br>
    
       
                 <div class="row">
            <div class="col-sm" hidden="true">
                <input type="radio"  id="permisos" name="permisos" checked="true"  value="Vendedor" hidden="true">Vendedor</div>
                
            </div>



 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnAgregarNuevo" class="btn btn-primary" >Crear Nuevo</button>
      </div>

</form>
 

      </div>
      
    </div>
  </div>
</div>


<!-- Modal agregar nuevo cliente -->
<div class="modal fade" id="agregarnuevoCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevoCliente" onsubmit=" return nuevoClienteDesdePreVenta();"   action="" method="post">

    <div class="row container">
        <div style="width: 190px">
    <input type="radio" name="radio" id="fisica" value="1" checked="true" onchange="habilitar(this.value)">
    <label>Persona Fisica</label> 
    </div>


     <div style="width: 190px">
         <input type="radio" name="radio" id="juridica" value="2" onchange="habilitar(this.value)">
    <label>Persona Juridica</label>
</div>
    </div>
           <br>
    <label id="nombreLabel" >Nombre</label>
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="nombreCli" name="nombreCli"  minlength="4" maxlength="59"   pattern="^[a-zA-Z\s]+">
    <label id="apellidoLabel" >Apellido</label>
    <input style="text-transform: capitalize;" type="text" class="form-control input-sm" id="apellidoCli" name="apellidoCli"  minlength="4" maxlength="39"   pattern="^[a-zA-Z\s]+">
    <label id="dniLabel">DNI</label>
    <input type="text" class="form-control input-sm" id="dniCli" name="dniCli"  maxlength="24" minlength="4"    pattern="[0-9]+">



    <label id="razonSocialLabel" hidden="true">Razon Social</label>
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="razonSocial" name="razonSocial"  minlength="4" maxlength="59" disabled="true" hidden="true">
       <label id="cuitLabel" hidden="true">Cuit</label>
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="cuit" name="cuit"  minlength="4" maxlength="24" disabled="true" hidden="true"  pattern="[0-9]+">
      
    

    <label>Domicilio</label>
    <input type="text" class="form-control input-sm" id="domicilio" name="domicilio"  maxlength="39" minlength="4">
    <label>Localidad</label>
    <input type="text" class="form-control input-sm" id="localidad" name="localidad"  maxlength="39" minlength="4" pattern="^[a-zA-Z\s]+">
     <label>Provincia</label>
    <input type="text" class="form-control input-sm" id="provincia" name="provincia"  maxlength="239" minlength="4" pattern="^[a-zA-Z\s]+">
    

   
    <label>Email</label>
    <input type="email" class="form-control input-sm" id="correoCli" name="correoCli"  maxlength="59" minlength="4">
    
     <label>Telefono</label>
    <input type="text" class="form-control input-sm" id="telefonoCli" name="telefonoCli"  maxlength="24" minlength="4">
   
   
   
    <?php 

$conexionVe= conectar();
mysqli_set_charset($conexionVe,'utf8'); 
$sqlve= "SELECT id,nombre,apellido,dni from usuarios where permisos='vendedor' and eliminado='NO'
 order by LENGTH(nombre) desc";

$resultadoVe=mysqli_query($conexionVe,$sqlve);

mysqli_close($conexionVe);

     ?> 
     <br>
    <div class="row" id="filaVendedorC">
		<div class="col-sm-2" >
		<label >Vendedor: </label>
		</div>
		<div class="col-sm-4" >
<select style="width: 300px; "  id="idVendedorC"   name="idVendedorC" class="mi-selectorVendedorC"   required="true">
				<?php

				while ($valoresV = mysqli_fetch_array($resultadoVe)) {
					?>
                    <option    value="<?php print($valoresV['id']);?>"> 
                    <?php  print($valoresV['nombre']); print(" ");print($valoresV['apellido']); print(" ");print($valoresV['dni']);?> </option>

					<?php
				}
				?>
			</select>


                <!-- <button type="button"  class="btn btn-primary mb-1" id="btnNuevoProductor" data-toggle="modal" data-target ="#modalAgregarSucursal"  style="width: 50px"> <span class="fas fa-plus-circle"></span> </button> -->
            

</div>
    </div>
    <input type="text" hidden class="form-control input-sm" id="idVendedorPara" name="idVendedorPara">

 
    <br>
    
        
 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnAgregarNuevo" class="btn btn-primary" >Crear Nuevo</button>
      </div>

</form>
 

      </div>
      
    </div>
  </div>
</div>






<!-- Modal agregar vehiculo -->
 <div class="modal fade" id="agregarnuevosdatosmodalNuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 700px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Vehiculo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevoVehiculo" onsubmit="return nuevoVehiculoDesdePreVenta();"  action="" method="post">

	
	<?php 

	$conexionSucursales= conectar();
	mysqli_set_charset($conexionSucursales,'utf8'); 
	$sqlc= "SELECT * from sucursales";

	$resultadoSucursales=mysqli_query($conexionSucursales,$sqlc);

	mysqli_close($conexionSucursales);
	
		 ?>








	<div class="row">
		<div class="col-sm-2" >
		<label style="font-size: 13px">Sucursal: </label>
		</div>
		<div class="col-sm-4" style="font-size: 12px;" >
<select  style="width: 200px; "  id="idTipoSucursal" name="idTipoSucursal" style="background-color: gainsboro;" required="true">
				<?php

				while ($valoresA = mysqli_fetch_array($resultadoSucursales)) {
					?>
					<option value="<?php print($valoresA['id']);?>"> <?php  print($valoresA['descripcion']);?> </option>

					<?php
				}
				?>
			</select>


	
                <!-- <button type="button"  class="btn btn-primary mb-1" id="btnNuevoProductor" data-toggle="modal" data-target ="#modalAgregarSucursal"  style="width: 50px"> <span class="fas fa-plus-circle"></span> </button> -->
            

</div>


<div class="col-sm-2"  >
    <label style="font-size: 13px">Estado: </label>
  </div>
  <div class="col-sm-4" style="font-size: 12px;" >
    <select style="width: 200px; " id="es" name="es" style="background-color: gainsboro;">
     <option value="1"> <?php  print"Stock";?> </option>
    </select>

  </div> 


	
                
            </div>




<?php 

	$conexionLugar= conectar();
	mysqli_set_charset($conexionLugar,'utf8'); 
	$sqlc= "SELECT * from lugar_donde_se_encuentra_vehiculo";

	$resultadoLugar=mysqli_query($conexionLugar,$sqlc);

	mysqli_close($conexionLugar);
	
		 ?>


	<div class="row">
		<div class="col-sm-2"  >
		<label style="font-size: 13px">Ubicacion: </label>
	</div>
	<div class="col-sm-4" style="font-size: 12px;" >
<select style="width: 200px; " id="idUbicacion" name="idUbicacion" style="background-color: gainsboro;" required="true">
				<?php

				while ($valoresUbicacion = mysqli_fetch_array($resultadoLugar)) {
					?>
					<option value="<?php print($valoresUbicacion['id']);?>"> <?php  print($valoresUbicacion['descripcion']);?> </option>

					<?php
				}
				?>
			</select>


	
              
            </div>




   <?php 

	$conexionOrigen= conectar();
	mysqli_set_charset($conexionOrigen,'utf8'); 
	$sqlc= "SELECT * from origenes_vehiculo";

	$resultadoOrigen=mysqli_query($conexionOrigen,$sqlc);

	mysqli_close($conexionOrigen);
	
		 ?>


		<div class="col-sm-2"  >
		<label style="font-size: 13px">Origen: </label>
	</div>
	<div class="col-sm-4" style="font-size: 12px;" >


			<select style="width: 200px; " id="idOrigen" name="idOrigen" style="background-color: gainsboro;" required="true">
				<?php

				while ($valoresOrigen = mysqli_fetch_array($resultadoOrigen)) {
					?>
					<option value="<?php print($valoresOrigen['id']);?>"> <?php  print($valoresOrigen['descripcion']);?> </option>

					<?php
				}
				?>
			</select>


	
              
            </div> 
            </div> 

<div class="row">
		

<?php 

  $conexionTipoVehiculo= conectar();
  mysqli_set_charset($conexionTipoVehiculo,'utf8'); 
  $sqlc= "SELECT * from tipos_vehiculos";

  $resultadoTipoVehiculo=mysqli_query($conexionTipoVehiculo,$sqlc);

  mysqli_close($conexionTipoVehiculo);
  
     ?>


  
    <div class="col-sm-2"  >
    <label style="font-size: 13px">Tipo Vehiculo:</label>
  </div>
  <div class="col-sm-4" style="font-size: 12px;" >
<select  style="width: 200px; " id="idTipoVehiculo" name="idTipoVehiculo" onchange="habilitarCampos();" style="background-color: gainsboro; " required="true">
        <?php

        while ($valoresTipo = mysqli_fetch_array($resultadoTipoVehiculo)) {
          ?>
          <option value="<?php print($valoresTipo['id']);?>"> <?php  print($valoresTipo['descripcion']);?> </option>

          <?php
        }
        ?>
      </select>

</div>





</div>



            <hr>      

    
    <div class="row">
    	<div class="col-sm-6">
    <label>Marca</label>
	</div>
	<div class="col-sm-6">
    <label>Modelo</label>
</div>
    </div>

<div class="row">

<div class="col-sm-6" id="divMarca"  >
<select style="width: 200px; "   id="idMarca" name="idMarca" onchange="cargarModelos();" class="mi-selectorMarca" style="background-color: gainsboro; " required="true">
                
            </select>

</div>


	<div class="col-sm-6" id="divMarcaInput" hidden>
    <input style="text-transform: capitalize;" type="text" class="form-control input-sm" id="marca" name="marca"  minlength="2" maxlength="50">
</div>



<div class="col-sm-4" id="divModelo">
<select style="width: 200px; "   id="idModelo" name="idModelo" onchange="cargarVehiculo();" class="mi-selectorModelo" style="background-color: gainsboro; " required="true">
                
            </select>

</div>
    <div class="col-sm-6" id="divModeloInput" hidden>
    <input type="text" class="form-control input-sm" id="modelo" name="modelo"  maxlength="45" minlength="2" >
</div>
     	</div>


<div class="row">


<div class="col-sm-6"  id="divLabelVehiculo">
        <label >Vehiculo:</label>
    </div>




<div class="col-sm-6">
	<label>Año</label>
</div>

	</div>
     
<div class="row">

<div class="col-sm-6"  id="divVehiculo">
<select style="width: 200px; "   id="idVehiculoInfo" name="idVehiculoInfo" onchange="cargarAnios();"  class="mi-selectorVehiculoInfo" style="background-color: gainsboro; " required="true">
                
            </select>

</div>
<div class="col-sm-4" id="divAnio">
<select style="width: 200px; "   id="idAnio" name="idAnio" onchange="mostrarPrecioInfo();"   class="mi-selectorAnioInfo" style="background-color: gainsboro; " required="true">
                
            </select>

</div> 
<div class="col-sm-6"id="divAnioInput" hidden >
    <input type="text" class="form-control input-sm" id="anio" name="anio"  maxlength="24" minlength="4" pattern="[0-9]+">
</div>

</div>


<div class="row">
<div class="col-sm-6" id="divLabelPrecio">
	<label>Precio Info Auto</label>
</div>
<div class="col-sm-6">
	   <label>Dominio</label>
	</div>
	</div>
     
<div class="row">
<div class="col-sm-6" id="divPrecio">
<input  disabled type="text" class="form-control input-sm" id="precioInforAutoD" name="precioInforAutoD" >
<input  hidden type="text" class="form-control input-sm" id="precioInforAuto" name="precioInforAuto" >

</div>
<div class="col-sm-6">
    <input type="text" class="form-control input-sm" id="dominio_patente" name="dominio_patente"  maxlength="24" minlength="4">
</div>
</div>








<div class="row">
	<div class="col-sm-6">
    <label>Kms</label>
</div>
<div class="col-sm-6">
     <label>Fecha Ingreso</label>
</div>
</div>

<div class="row">
	<div class="col-sm-6">
    <input type="text" class="form-control input-sm" id="kilometros" name="kilometros"  maxlength="24" minlength="1"  pattern="[0-9]+(\.[0-9]{1,2})?%?">
    </div>
<div class="col-sm-6">
    <input  type="date" class="form-control input-sm" id="fechaIngreso" name="fechaIngreso"  minlength="4" maxlength="24">
    </div>
</div>


<div class="row">
	<div class="col-sm-6">
    <label>Precio Compra</label>
       </div>
<div class="col-sm-6">
    <label>Precio Venta</label>
        </div>
</div>



<div class="row">
	<div class="col-sm-6">
    <input type="text" class="form-control input-sm" id="precioCompra" name="precioCompra"  minlength="1" maxlength="15" pattern="[0-9]+(\.[0-9]{1,2})?%?">
         </div>
<div class="col-sm-6">
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="precioVentaN" name="precioVentaN"  minlength="1" maxlength="24" pattern="[0-9]+(\.[0-9]{1,2})?%?">
  </div>
</div>


<div class="row">
	<div class="col-sm-6">
    <label>Color</label>
       </div>
<div class="col-sm-6">
    <label>Deudas de Vehiculo</label>
        </div>
</div>



<div class="row">
	<div class="col-sm-6">
    <input type="text" class="form-control input-sm" id="color" name="color"  minlength="3" maxlength="25" pattern="^[a-zA-Z\s]+">
         </div>
<div class="col-sm-6">
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="deudas" name="deudas" maxlength="90">
  </div>
</div>




<label>Observaciones</label>
 <input style="text-transform: capitalize;" type="text" class="form-control input-sm" id="observacionesN" name="observacionesN"   maxlength="249">


    <br>
    
      

            

 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCerrarModal">Cerrar</button>
        <button type="submit" id="btnAgregarNuevo" class="btn btn-primary" >Crear Nuevo</button>
      </div>

</form>
 

      </div>
      
    </div>
  </div>
</div> 




<!-- Modal agregar credito Prendario -->
<!-- <div class="modal fade" id="agregarnuevoCredito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Credito Prendario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="xModalCredito">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevoCredito" onsubmit=""  action="" method="">

<?php 

	$conexionEntidadPrendaria= conectar();
	mysqli_set_charset($conexionEntidadPrendaria,'utf8'); 
	$sqlc= "SELECT * from entidades_prendarias where eliminado='NO'";

	$resultadoEntidad=mysqli_query($conexionEntidadPrendaria,$sqlc);

	mysqli_close($conexionEntidadPrendaria);
	
		 ?>


	<div class="row" >
		<div style="width: 60px;  margin-left: 15px;" >
		<label>Entidad:</label>
	</div>
	<div class="col-sm-1" >
<select id="idEntidad" name="idEntidad" style="background-color: gainsboro; " required="true">
				<?php

				while ($valoresEntidad = mysqli_fetch_array($resultadoEntidad)) {
					?>
					<option value="<?php print($valoresEntidad['id']);?>"> <?php  print($valoresEntidad['descripcion']);?> </option>

					<?php
				}
				?>
			</select>

</div>
</div>


	
<div class="row">
	<div class="col-sm-6">
    <label>Monto Prendario</label>
       </div>
<div class="col-sm-6">
    <label>Monto de Sellado</label>
        </div>
</div>



<div class="row">
	<div class="col-sm-3">
    <input type="text" class="form-control input-sm" id="montoPrendario" name="montoPrendario"  minlength="1" maxlength="15" pattern="[0-9]+(\.[0-9]{1,2})?%?">
         </div>
<div class="col-sm-3">
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="montoSellado" name="montoSellado"  minlength="1" maxlength="24" pattern="[0-9]+(\.[0-9]{1,2})?%?">
  </div>
</div>




    
    <br>
    
       
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarModalCredito">Cerrar</button>
        <button type="button" id="btnAgregarNuevoCredito" class="btn btn-primary" >Cargar</button>
      </div>

</form>
 

      </div>
      
    </div>
  </div>
</div> -->



<!-- Modal agregar Cheque -->
<div class="modal fade" id="agregarnuevoCheque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Cheque</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="xModalCheque">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevoCheque" onsubmit="return nuevoCheque();"  action="" method="post">

<?php 

	$conexionEntidadPrendaria= conectar();
	mysqli_set_charset($conexionEntidadPrendaria,'utf8'); 
	$sqlc= "SELECT * from entidades_prendarias where eliminado='NO'";

	$resultadoEntidad=mysqli_query($conexionEntidadPrendaria,$sqlc);

	mysqli_close($conexionEntidadPrendaria);
	
		 ?>


	<div class="row" >
		<div style="width: 60px;  margin-left: 15px;" >
		<label>Entidad:</label>
	</div>
	<div class="col-sm-1" >
<select id="idEntidadCheque" name="idEntidadCheque" style="background-color: gainsboro; " required="true">
				<?php

				while ($valoresEntidad = mysqli_fetch_array($resultadoEntidad)) {
					?>
					<option value="<?php print($valoresEntidad['id']);?>"> <?php  print($valoresEntidad['descripcion']);?> </option>

					<?php
				}
				?>
			</select>

</div>
</div>

<br>
	
<div class="row">
	<div class="col-sm-4">
    <label>Numero Cheque</label>
       </div> 
</div>
<div class="row">
	<div class="col-sm-12">
    <input type="text" class="form-control input-sm" id="numeroCheque" name="numeroCheque"  minlength="1" maxlength="69">
         </div>
</div>


<br>
       
       <div class="row">
<div class="col-sm-4">
    <label>Monto</label>
        </div>
        <div class="col-sm-5">
    <label>Fecha de Cobro</label>
        </div>
</div>



<div class="row">
	
<div class="col-sm-4">
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="montoCheque" name="montoCheque"  minlength="1" maxlength="24" pattern="[0-9]+(\.[0-9]{1,2})?%?">
  </div>

  <div class="col-sm-5">
    <input style="text-transform: capitalize;" type="date"  class="form-control input-sm" id="fechaCobroCheque" name="fechaCobroCheque"  minlength="1" maxlength="24" value="<?php echo date("Y-m-d"); ?>">
  </div>



</div>




    
    <br>
    
       
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarModalCheque">Cerrar</button>
        <button type="submit" id="btnAgregarNuevo" class="btn btn-primary" >Crear Nuevo</button>
      </div>

</form>
 

      </div>
      
    </div>
  </div>
</div>






<!-- Modal agregar vehiculo Canje -->
<div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 700px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Vehiculo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="xModal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevoVehiculoCanje" onsubmit="return nuevoVehiculoDesdePreVentaCanje();"  action="" method="post">



	
	<?php 

	$conexionSucursales= conectar();
	mysqli_set_charset($conexionSucursales,'utf8'); 
	$sqlc= "SELECT * from sucursales";

	$resultadoSucursales=mysqli_query($conexionSucursales,$sqlc);

	mysqli_close($conexionSucursales);
	
		 ?>






			


	<div class="row">
		<div class="col-sm-2"  >
		<label style="font-size: 13px">Sucursal: </label>
		</div>
		<div class="col-sm-4" style="font-size: 12px;">
<select style="width: 200px; "   id="idTipoSucursalC" name="idTipoSucursalC" style="background-color: gainsboro;" required="true">
				<?php

				while ($valoresA = mysqli_fetch_array($resultadoSucursales)) {
					?>
					<option value="<?php print($valoresA['id']);?>"> <?php  print($valoresA['descripcion']);?> </option>

					<?php
				}
				?>
			</select>
  

</div>




	
<div class="col-sm-2" >
		<label style="font-size: 13px">Estado: </label>
	</div>
  <div class="col-sm-4" style="font-size: 12px;">
    <select style="width: 200px; " id="esC" name="esC" style="background-color: gainsboro;">
    <option value="1"> <?php  print"A Ingresar";?> </option>
		 <option value="2"> <?php  print"Stock";?> </option>
		</select>

	</div>   
            </div>




<?php 

	$conexionLugar= conectar();
	mysqli_set_charset($conexionLugar,'utf8'); 
	$sqlc= "SELECT * from lugar_donde_se_encuentra_vehiculo";

	$resultadoLugar=mysqli_query($conexionLugar,$sqlc);

	mysqli_close($conexionLugar);
	
		 ?>



			
	<div class="row">
  <div class="col-sm-2" >
		<label style="font-size: 13px">Ubicacion: </label>
	</div>
  <div class="col-sm-4" style="font-size: 12px;">
<select style="width: 200px; "  id="idUbicacionC" name="idUbicacionC" style="background-color: gainsboro;" required="true">
				<?php

				while ($valoresUbicacion = mysqli_fetch_array($resultadoLugar)) {
					?>
					<option value="<?php print($valoresUbicacion['id']);?>"> <?php  print($valoresUbicacion['descripcion']);?> </option>

					<?php
				}
				?>
			</select>


	
              
            </div>





<div class="col-sm-2" >
		<label style="font-size: 13px">Origen: </label>
	</div>
  <div class="col-sm-4" style="font-size: 12px;">


			<select style="width: 200px; " id="idOrigenC" name="idOrigenC" style="background-color: gainsboro;" required="true">
				
					<option value="3"> <?php  print  "Canje";?> </option>

				
			</select>


	
              
            </div> 
            </div> 







<div class="row">
 
<?php 

$conexionTipoVehiculo= conectar();
mysqli_set_charset($conexionTipoVehiculo,'utf8'); 
$sqlc= "SELECT * from tipos_vehiculos";

$resultadoTipoVehiculo=mysqli_query($conexionTipoVehiculo,$sqlc);

mysqli_close($conexionTipoVehiculo);

   ?>



      

  <div class="col-sm-2" >
  <label style="font-size: 13px">Tipo Vehiculo:</label>
</div>
<div class="col-sm-4" style="font-size: 12px;" >
<select style="width: 200px; " id="idTipoVehiculoC" name="idTipoVehiculoC" onchange="habilitarCamposC();" style="background-color: gainsboro; " required="true">
      <?php

      while ($valoresTipo = mysqli_fetch_array($resultadoTipoVehiculo)) {
        ?>
        <option value="<?php print($valoresTipo['id']);?>"> <?php  print($valoresTipo['descripcion']);?> </option>

        <?php
      }
      ?>
    </select>

</div>
</div>



            <hr>      

    
    <div class="row">
    	<div class="col-sm-6">
    <label>Marca</label>
	</div>
	<div class="col-sm-6">
    <label>Modelo</label>
</div>
    </div>

<div class="row">

<div class="col-sm-6" id="divMarcaC"  >
<select style="width: 200px; "   id="idMarcaC" name="idMarcaC" onchange="cargarModelosC();" class="mi-selectorMarcaC" style="background-color: gainsboro; " required="true">
                
            </select>

</div>
	<div class="col-sm-6"  id="divMarcaInputC" hidden>
    <input style="text-transform: capitalize;" type="text" class="form-control input-sm" id="marcaC" name="marcaC"  minlength="2" maxlength="50">
</div>

<div class="col-sm-4" id="divModeloC">
<select style="width: 200px; "   id="idModeloC" name="idModeloC" onchange="cargarVehiculoC();" class="mi-selectorModeloC" style="background-color: gainsboro; " required="true">
                
            </select>

</div>
    <div class="col-sm-6" id="divModeloInputC" hidden>
    <input type="text" class="form-control input-sm" id="modeloC" name="modeloC"  maxlength="45" minlength="2" >
</div>
     	</div>




       <div class="row">
<div class="col-sm-6"  id="divLabelVehiculoC">
        <label >Vehiculo:</label>
    </div>
  
<div class="col-sm-6">
	<label>Año</label>
</div>

  </div>
  <div class="row">
<div class="col-sm-6"  id="divVehiculoC">
<select style="width: 200px; "   id="idVehiculoInfoC" name="idVehiculoInfoC" onchange="cargarAniosC();"  class="mi-selectorVehiculoInfoC" style="background-color: gainsboro; " required="true">
                
            </select>

</div>
<div class="col-sm-4" id="divAnioC">
<select style="width: 200px; "   id="idAnioC" name="idAnioC" onchange="mostrarPrecioInfoC();"   class="mi-selectorAnioInfoC" style="background-color: gainsboro; " required="true">
                
            </select>

</div> 
<div class="col-sm-6" id="divAnioInputC" hidden>
    <input type="text" class="form-control input-sm" id="anioC" name="anioC"  maxlength="24" minlength="4" pattern="[0-9]+">
</div>

</div>




     
<div class="row">
<div class="col-sm-6" id="divLabelPrecioC">
	<label>Precio Info Auto</label>
</div>
<div class="col-sm-6">
	   <label>Dominio</label>
	</div>
	</div>
     
<div class="row">
<div class="col-sm-6" id="divPrecioC">
<input  disabled type="text" class="form-control input-sm" id="precioInforAutoDC" name="precioInforAutoDC">
<input  hidden type="text" class="form-control input-sm" id="precioInforAutoC" name="precioInforAutoC" >

</div>
<div class="col-sm-6">
    <input type="text" class="form-control input-sm" id="dominio_patenteC" name="dominio_patenteC"  maxlength="24" minlength="4">
</div>
</div>



<div class="row">
	<div class="col-sm-6">
    <label>Kms</label>
</div>
<div class="col-sm-6">
     <label>Fecha Ingreso</label>
</div>
</div>

<div class="row">
	<div class="col-sm-6">
    <input type="text" class="form-control input-sm" id="kilometrosC" name="kilometrosC"  maxlength="24" minlength="1"  pattern="[0-9]+(\.[0-9]{1,2})?%?">
    </div>
<div class="col-sm-6">
    <input  type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control input-sm" id="fechaIngresoC" name="fechaIngresoC"  minlength="4" maxlength="24">
    </div>
</div>


<div class="row">
	<div class="col-sm-6">
    <label>Precio Compra</label>
       </div>
<div class="col-sm-6">
    <label>Precio Venta</label>
        </div>
</div>



<div class="row">
	<div class="col-sm-6">
    <input type="text" class="form-control input-sm" id="precioCompraC" value="0" name="precioCompraC"  minlength="1" maxlength="15" pattern="[0-9]+(\.[0-9]{1,2})?%?">
         </div>
<div class="col-sm-6">
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="precioVentaC" name="precioVentaC"  minlength="1" maxlength="24" pattern="[0-9]+(\.[0-9]{1,2})?%?">
  </div>
</div>


<div class="row">
	<div class="col-sm-6">
    <label>Color</label>
       </div>
<div class="col-sm-6">
    <label>Deudas de Vehiculo</label>
        </div>
</div>



<div class="row">
	<div class="col-sm-6">
    <input type="text" class="form-control input-sm" id="colorC" name="colorC"  minlength="3" maxlength="25" pattern="^[a-zA-Z\s]+">
         </div>
<div class="col-sm-6">
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="deudasC" name="deudasC" maxlength="90">
  </div>
</div>




<label>Observaciones</label>
 <input style="text-transform: capitalize;" type="text" class="form-control input-sm" id="observacionesC" name="observacionesC"   maxlength="249">


    <br>
  <!--    <input style="text-transform: capitalize;" hidden="true" type="text" class="form-control input-sm" id="bandera" name="bandera"   maxlength="95" value="1"> -->

      
      

            

 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCerrarModalCanje">Cerrar</button>
        <button type="submit" id="btnAgregarNuevo" class="btn btn-primary" >Crear Nuevo</button>
      </div>

</form>
 

      </div>
      
    </div>
  </div>
</div>







 
</html>



<script type="text/javascript">

//bloqueo para volver hacia atras post logout

    if(history.forward(1)){
        history.replace(history.forward(1));
    }
</script>



<script type="text/javascript">
  jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorVendedorC').select2();
    });
});
    jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorVendedor').select2();
    });
});

 jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorMedio').select2();
    });
});

jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorMarca').select2();
    });
});

jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorModelo').select2();
    });
});
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorVehiculoInfo').select2();
    });
});

jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorAnioInfo').select2();
    });
});
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorMarcaC').select2();
    });
});

jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorModeloC').select2();
    });
});
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorVehiculoInfoC').select2();
    });
});

jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorAnioInfoC').select2();
    });
});







       jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorCliente').select2();
    });
});
       jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorCheque').select2();
    });
});
              jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorVehiculo').select2();
    });
});
                     jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorVehiculoCanje').select2();
    });
});




</script>


<script type="text/javascript">
    function nuevoVendedor(){


  
        var usuario=document.getElementById('usuario').value;
        var pw=document.getElementById('pw').value;
        var nombre=document.getElementById('nombreV').value;	
        var apellido=document.getElementById('apellidoV').value;
        var correo=document.getElementById('correoV').value;
        var dni=document.getElementById('dniV').value;
        var telefono=document.getElementById('telefonoV').value;
        var permisos=document.getElementById('permisos').value;
        
       

        var datosUsuario='&usuario='+usuario +'&pw='+pw +'&nombre='+nombre +'&apellido='+apellido +'&correo='+correo +'&dni='+dni + '&telefono='+telefono +'&permisos='+permisos ;



          $.ajax({
    			type:'post',
    			url:'procesos/agregarUsuario.php',
    			data:datosUsuario,
    			success:function(){
    				$('#agregarnuevoVendedor').modal('hide');
    				   alertify.success("Se agrego correctamente");

    				   document.getElementById('usuario').value="";
    				   document.getElementById('pw').value="";
    				   document.getElementById('nombreV').value="";
    				   document.getElementById('apellidoV').value="";
    				   document.getElementById('correoV').value="";
    				   document.getElementById('dniV').value="";
    				   document.getElementById('telefonoV').value="";

    				    recargarVendedores();
    				   
    				  
    			
    			}


    	});


	return false;


    }


</script>


<script type="text/javascript">
    function nuevoClienteDesdePreVenta(){


     
        var nombre=document.getElementById('nombreCli').value;
        var apellido=document.getElementById('apellidoCli').value;
        var dni=document.getElementById('dniCli').value;	
        var razonSocial=document.getElementById('razonSocial').value;
        var cuit=document.getElementById('cuit').value;
        var domicilio=document.getElementById('domicilio').value;
        var localidad=document.getElementById('localidad').value;
        var provincia=document.getElementById('provincia').value;
        var correo=document.getElementById('correoCli').value;
        var telefono=document.getElementById('telefonoCli').value;

        if(<?php echo $_SESSION['permisos'];?> !='3' ){ // esto indica que no es un vendedor
        var idVendedor=document.getElementById('idVendedorC').value+'--';
        }
        else{

          var idVendedor='<?php echo $_SESSION['idC'];?>'+'--';
        }


        var datosCliente='&nombre='+nombre +'&apellido='+apellido +'&dni='+dni +'&razonSocial='+razonSocial 
        +'&cuit='+cuit +'&domicilio='+domicilio + '&localidad='+localidad +'&provincia='+provincia 
        +'&correo='+correo +'&telefono='+telefono + '&idVendedorPara='+idVendedor ;


        $.ajax({
    			type:'post',
    			url:'procesos/agregarCliente.php',
    			data:datosCliente,
    			success:function(){
    				$('#agregarnuevoCliente').modal('hide');
    				   alertify.success("Se agrego correctamente");

    				   document.getElementById('nombreCli').value="";
    				   document.getElementById('apellidoCli').value="";
    				   document.getElementById('dniCli').value="";
    				   document.getElementById('razonSocial').value="";
    				   document.getElementById('cuit').value="";
    				   document.getElementById('domicilio').value="";
    				   document.getElementById('localidad').value="";
    				   document.getElementById('provincia').value="";
    				   document.getElementById('correoCli').value="";
    				   document.getElementById('telefonoCli').valu="";
    				  
    				  recargarClientes(idVendedor);

    			
    			}


    	});


	return false;


    }


</script>


<script type="text/javascript">
    function nuevoVehiculoDesdePreVenta(){


       e = document.getElementById('idAnio');


 res=e.options[e.selectedIndex].value;
 arrS=res.split('--');



 if(arrS[0]=='00'){


 alertify.warning("Seleccione un año");

return false;
 }
 else{



         var idTipoSucursal=document.getElementById('idTipoSucursal').value;
        var idTipoVehiculo=document.getElementById('idTipoVehiculo').value;
        var idUbicacion=document.getElementById('idUbicacion').value; 
        var idOrigen=document.getElementById('idOrigen').value;


        
       
        var marca=document.getElementById('marca').value;


       var  mode = document.getElementById('idModelo');
        var modelo= mode.options[mode.selectedIndex].text;



        var anio=document.getElementById('anio').value;
    	var dominio_patente=document.getElementById('dominio_patente').value;
    	var kilometros=document.getElementById('kilometros').value;
    	var deudas=document.getElementById('deudas').value;
    	var precioCompra=document.getElementById('precioCompra').value;
    	var color=document.getElementById('color').value;
    	var observaciones=document.getElementById('observacionesN').value;
    	var precioVenta=document.getElementById('precioVentaN').value;
    	var fechaIngreso=document.getElementById('fechaIngreso').value;

      

      var parIdMarca=document.getElementById('idMarca').value;
      var parIdModelo=document.getElementById('idModelo').value;
      var parIdVehiculoInfo=document.getElementById('idVehiculoInfo').value;
      var parIdAnio=document.getElementById('idAnio').value;
      var parPrecioInforAuto=document.getElementById('precioInforAuto').value;



      var obj=document.getElementById('idVehiculoInfo');
      var nombreVehiculo=obj.options[obj.selectedIndex].text;
      

    	var datoss='&idTipoSucursal='+idTipoSucursal +'&idTipoVehiculo='+idTipoVehiculo 
      +'&idUbicacion='+idUbicacion +'&idOrigen='+idOrigen +'&marca='+marca +'&modelo='+modelo 
      + '&anio='+anio +'&dominio_patente='+dominio_patente +'&kilometros='+kilometros 
      +'&deudas='+deudas +'&precioCompra='+precioCompra +'&color='+color 
      +'&observaciones='+observaciones +'&precioVenta='+precioVenta +'&fechaIngreso='+fechaIngreso
      +'&idMarca='+parIdMarca +'&idModelo='+parIdModelo +'&idVehiculoInfo='+parIdVehiculoInfo
      +'&idAnio='+parIdAnio +'&precioInforAuto='+parPrecioInforAuto+ '&vehiculoinput='+nombreVehiculo;

    	$.ajax({
    			type:'post',
    			url:'procesos/agregarVehiculo.php',
    			data:datoss,
    			success:function(){
    				$('#agregarnuevosdatosmodalNuevo').modal('hide');
    				   alertify.success("Se agrego correctamente");

    				   document.getElementById('marca').value="";
    				   document.getElementById('modelo').value="";
    				   document.getElementById('anio').value="";
    				   document.getElementById('dominio_patente').value="";
    				   document.getElementById('kilometros').value="";
    				   document.getElementById('deudas').value="";
    				   document.getElementById('precioCompra').value="";
    				   document.getElementById('color').value="";
    				   document.getElementById('observacionesN').value="";
    				   document.getElementById('precioVentaN').value="";
    				   document.getElementById('fechaIngreso').value="";

    				   recargarVehiculo();
    			
    			}


    	});


       document.getElementById('dominioPatente').value=document.getElementById('dominio_patente').value;
       document.getElementById('precioVenta').value=document.getElementById('precioVentaN').value;
      

    	return false;


 }

    }


</script>





<script type="text/javascript">
	

// si presiona el checkbox de credito llamo al modal para nuevo credito
$('input[id="checkCredito"]').on('change', function(e){
    if (this.checked) {
     	document.getElementById('idEntidad').disabled=false; 
    	document.getElementById('montoPrendario').disabled=false;
    	document.getElementById('montoSellado').disabled=false;
    } 
    else{

    	document.getElementById('idEntidad').disabled=true; 
    	document.getElementById('montoPrendario').disabled=true;
    	document.getElementById('montoSellado').disabled=true;




    }
});

$('input[id="checkCreditoPersonal"]').on('change', function(e){
    if (this.checked) {
      document.getElementById('idEntidadCpersonal').disabled=false; 
      document.getElementById('montoPersonal').disabled=false;
      
    } 
    else{

      document.getElementById('idEntidadCpersonal').disabled=true; 
      document.getElementById('montoPersonal').disabled=true;
     


    }
});



$('input[id="checkUsado"]').on('change', function(e){
    if (this.checked) {
         document.formularioOrdenPreventa.valorCheckboxUsado.value='activo';
    } 
    else{

        document.formularioOrdenPreventa.valorCheckboxUsado.value='inactivo';


    }
});

$('input[id="checkCheque"]').on('change', function(e){
    if (this.checked) {
         document.formularioOrdenPreventa.valorCheckboxCheques.value='activo';
    } 
    else{

        document.formularioOrdenPreventa.valorCheckboxCheques.value='inactivo';


    }
});




// al presionar la x en el modal destilda el checbox

$("#xModalCredito").on('click', function(e){
    
        $("#checkCredito").prop('checked',false); 
    
});




// al presionar cerrar en el modal destilda el checkbox

$("#cerrarModalCredito").on('click', function(e){
    
        $("#checkCredito").prop('checked',false); 
    
});




$("#btnAgregarNuevoCredito").on('click', function(e){
    
       
       	// cierro el modal
		$('#agregarnuevoCredito').modal('hide');

		// aca deberia setear los campos del formulario general que genera la orden de preventa y setea los campos
        
    
});



</script>


<script type="text/javascript">
	
function eliminarDatosVehiculoPreVenta(id){
    alertify.confirm('Eliminar Vehiculo', '¿Esta seguro que desea eliminar el vehiculo?',
        function(){ 
                $.ajax({
        type:"POST",
        data:"id=" + id,
        url:"procesos/eliminarVehiculo.php",
        success:function(r){
            
             
                alertify.success("Eliminado con exito");
       	
              
        },
        error: function(){

            alertify.error("No se pudo eliminar");
            

        }
    });

        }
        , function(){ });



}


</script>


<script>
function habilitar(value) {
   
    if(value=="1")
            {
                // habilitamos
                document.getElementById("nombreCli").disabled=false;
                  document.getElementById("apellidoCli").disabled=false;
                    document.getElementById("dniCli").disabled=false;
                      document.getElementById("razonSocial").disabled=true;
                      document.getElementById("razonSocial").value="";
                        document.getElementById("cuit").disabled=true;
                        document.getElementById("cuit").value="";
                        document.getElementById("cuit").hidden=true;
                        document.getElementById("cuitLabel").hidden=true;
                         document.getElementById("razonSocial").hidden=true;
                        document.getElementById("razonSocialLabel").hidden=true;

                        document.getElementById("nombreCli").hidden=false;
                        document.getElementById("nombreLabel").hidden=false;
                        document.getElementById("apellidoCli").hidden=false;
                        document.getElementById("apellidoLabel").hidden=false;
                        document.getElementById("dniCli").hidden=false;
                        document.getElementById("dniLabel").hidden=false;

            }else if(value=="2"){
                
                document.getElementById("nombreCli").disabled=true;
                document.getElementById("nombreCli").value="";
                  document.getElementById("apellidoCli").disabled=true;
                  document.getElementById("apellidoCli").value="";
                    document.getElementById("dniCli").disabled=true;
                    document.getElementById("dniCli").value="";
                      document.getElementById("razonSocial").disabled=false;
                        document.getElementById("cuit").disabled=false;
                        document.getElementById("cuit").hidden=false;
                        document.getElementById("cuitLabel").hidden=false;
                         document.getElementById("razonSocial").hidden=false;
                        document.getElementById("razonSocialLabel").hidden=false;

                        document.getElementById("nombreCli").hidden=true;
                        document.getElementById("nombreLabel").hidden=true;
                        document.getElementById("apellidoCli").hidden=true;
                        document.getElementById("apellidoLabel").hidden=true;
                        document.getElementById("dniCli").hidden=true;
                        document.getElementById("dniLabel").hidden=true;

            }


}
</script>



<script type="text/javascript">
                $(document).ready(function() {

                  if ( <?php echo $banderaAcceso;?> =='1'){

                     $.ajax({
                            type: "POST",
                            data: "idVendedor="+'<?php echo $mostrarReg['id_vendedor'];?>',
                        url: "procesos/obtenerVendedores.php",
                        success: function(response)
                            {
                                  $('.selector-vendedor select').html(response).fadeIn();
                            }
                    });



                  }  

                    
                  else if(<?php echo $_SESSION['permisos'];?> !='3' ){

                    $.ajax({
                            type: "POST",
                            data: "idVendedor="+'0',
                            url: "procesos/obtenerVendedores.php",
                            success: function(response)
                            {
                                  $('.selector-vendedor select').html(response).fadeIn();
                            }
                    });
                }
                else{

                    $.ajax({
                            type: "POST",
                            data: "idVendedor="+'<?php echo $_SESSION['idC'];?>',
                            url: "procesos/obtenerVendedores.php",
                            success: function(response)
                            {
                                  $('.selector-vendedor select').html(response).fadeIn();
                            }
                    });
                    }






                
 
                });
</script>


<script type="text/javascript">
                $(document).ready(function() {

                  if ( <?php echo $banderaAcceso;?> =='1'){

                     $.ajax({
                        type: "POST",
                        data: "idMedio="+'<?php echo $mostrarReg['medio_contacto'];?>',
                        url: "procesos/obtenerMedios.php",
                        success: function(response)
                            {
                                  $('.selector-medio select').html(response).fadeIn();
                            }
                    });



                  }  

                    
                  else{

                    $.ajax({
                            type: "POST",
                            data: "idMedio="+'0',
                            url: "procesos/obtenerMedios.php",
                            success: function(response)
                            {
                                  $('.selector-medio select').html(response).fadeIn();
                            }
                    });
                }
 
                });
</script>





<script type="text/javascript">

	
               function recargarVendedores() {
                    $.ajax({
                            type: "POST",
                            data: "idVendedor="+'-1',
                            url: "procesos/obtenerVendedores.php",
                            success: function(response)
                            {
                                $('.selector-vendedor select').html(response).fadeIn();
                            }
                    });
 
                }
            
</script>


<script type="text/javascript">
                $(document).ready(function() {

                	if ( <?php echo $banderaAcceso;?> =='1'){

                		$.ajax({
                            type: "POST",
                            data: "idCliente="+'<?php echo $mostrarReg['id_cliente'];?>'+'&idVendedor='+'<?php echo '0';?>',
                            url: "procesos/obtenerClientes.php",
                            success: function(response)
                            {
                                  $('.selector-cliente select').html(response).fadeIn();
                            }
                    });



                	} 


                	if(<?php echo $_SESSION['permisos'];?> =='3'){

                    $.ajax({
                            type: "POST",
                            data: "idCliente="+'0'+'&idVendedor='+'<?php echo $_SESSION['idC'];?>',
                            url: "procesos/obtenerClientes.php",
                            success: function(response)
                            {
                                  $('.selector-cliente select').html(response).fadeIn();
                            }
                    });
                }

                });





                function cargarClientes(){


                  idVende=document.getElementById('selectVendedor').value;

                  $.ajax({
                            type: "POST",
                            data: "idCliente="+'0'+'&idVendedor='+idVende,
                            url: "procesos/obtenerClientes.php",
                            success: function(response)
                            {
                                  $('.selector-cliente select').html(response).fadeIn();
                            }
                    });


                }













</script>


<script type="text/javascript">

	
               function recargarClientes(idVendedor) {
                    $.ajax({
                            type: "POST",
                             data: "idCliente="+'-1' + '&idVendedor='+idVendedor,
                            url: "procesos/obtenerClientes.php",
                            success: function(response)
                            {
                                $('.selector-cliente select').html(response).fadeIn();
                            }
                    });


                    $('.selector-vendedor select').html('').fadeIn();
                    $.ajax({
                          type: "POST",
                          data: "idVendedor="+idVendedor,
                          url: "procesos/obtenerVendedores.php",
                          success: function(response)
                          {
                                $('.selector-vendedor select').html(response).fadeIn();
                          }
                  });
                  
 
                }
            
</script>

<script type="text/javascript">
                $(document).ready(function() {


                	if ( <?php echo $banderaAcceso;?> =='1'){

                    $.ajax({
                            type: "POST",
                            data: "idVehiculo="+'<?php echo $mostrarReg['id_vehiculo_prevendido'];?>',
                            url: "procesos/obtenerVehiculos.php",
                            success: function(response)
                            {
                                  $('.selector-vehiculo select').html(response).fadeIn();
                            }
                    });


                	} 


else{
                    $.ajax({
                            type: "POST",
                            data: "idVehiculo="+'0',
                            url: "procesos/obtenerVehiculos.php",
                            success: function(response)
                            {
                                  $('.selector-vehiculo select').html(response).fadeIn();
                            }
                    });
                }
 
                });
</script>

<script type="text/javascript">

	
               function recargarVehiculo() {
                    $.ajax({
                            type: "POST",
                            data: "idVehiculo="+'-1',
                            url: "procesos/obtenerVehiculos.php",
                            success: function(response)
                            {
                                $('.selector-vehiculo select').html(response).fadeIn();
                            }
                    });
 
                }
            
</script>



 <script type="text/javascript">


              if('<?php echo $mostrarReg['id_usados_entregados'];?>'!= null && '<?php echo $mostrarReg['id_usados_entregados'];?>'!=''){

                   document.getElementById('checkUsado').checked=true;
                     document.getElementById('selectVehiculoCanje').disabled=false; 

              }

            var lisParA= new Array()
             lisParA= '<?php echo $mostrarReg['id_usados_entregados'];?>';
              
             var parametroApasarA= lisParA.toString();

            

                $(document).ready(function() {
                    $.ajax({						
                            type: "POST",
                            data:"listaIdAutosTodos="+parametroApasarA+'&ba='+1,
                            url: "procesos/obtenerVehiculosCanje.php",
                            success: function(response)
                            {
                                  $('.selector-vehiculoCanje select').html(response).fadeIn();
                            }
                    });
 
                });
</script>

<script type="text/javascript">


	
               function recargarVehiculoCanje(listaIdAutosTodos) {
                    $.ajax({
                            type: "POST",
                            data:"listaIdAutosTodos="+listaIdAutosTodos+'&ba='+0,
                            url: "procesos/obtenerVehiculosCanje.php",
                            success: function(response)
                            {
                                $('.selector-vehiculoCanje select').html(response).fadeIn();
                            }
                    });
 
                }
            
</script>


<script type="text/javascript">


          if('<?php echo $mostrarReg['id_cheques_entregados'];?>'!= null && '<?php echo $mostrarReg['id_cheques_entregados'];?>'!=''){

                   document.getElementById('checkCheque').checked=true;
                     document.getElementById('selectCheque').disabled=false; 

              }




              var lisPar= new Array()
             lisPar= '<?php echo $mostrarReg['id_cheques_entregados'];?>';
              
             var parametroApasar= lisPar.toString();
              

            
                $(document).ready(function() {
                    $.ajax({
                            type: "POST",
                            data:"listaIdCheques="+parametroApasar+'&ba='+1,
                            url: "procesos/obtenerCheques.php",
                            success: function(response)
                            {
                                  $('.selector-cheque select').html(response).fadeIn();

                            }
                    });


 
                });
</script>


<script type="text/javascript">

	var bandera= true;

    				  
               function recargarCheque(listaIdCheques) {
               
                    $.ajax({
                            type: "POST",                  
                            data:"listaIdCheques="+listaIdCheques+'&ba='+0,
                            url: "procesos/obtenerCheques.php",
                            
                            success: function(response)
                            {
                                $('.selector-cheque select').html(response).fadeIn();
                                 
                                // ver donde setear el string con la lista de ids para la base de datos

                            }
                    });



                }
            
</script>	



<script type="text/javascript">

 var listaIdAutosDeseleccionados=new Array();
 var listaIdAutosSeleccionados=new Array();
 var arregloFinalAutos= new Array();


if('<?php echo $mostrarReg['id_usados_entregados'];?>'==''){var arregloPoderosoAutos= new Array();}
else{
  var arregloPoderosoAutos=  '<?php echo $mostrarReg['id_usados_entregados'];?>'.split(",");
}



 $('.mi-selectorVehiculoCanje').on("select2:unselect", function (e) {
                        	
                       		
                              var index= arregloPoderosoAutos.indexOf(e.params.data.id);
                          if(index>-1){

                            arregloPoderosoAutos.splice(index,1);
                           
                          }


                          });




 $('.mi-selectorVehiculoCanje').on("select2:select", function (e) {
                        	 
                           arregloPoderosoAutos.push(e.params.data.id);

                          });







 var listaIdAutosTodos="";




    function nuevoVehiculoDesdePreVentaCanje(){


      e = document.getElementById('idAnioC');


res=e.options[e.selectedIndex].value;
arrS=res.split('--');



if(arrS[0]=='00'){


alertify.warning("Seleccione un año");

return false;
}
else{



      cambiarBtnGenerarPreventa();
     
        //  var listaIdAutosDeseleccionadosString= listaIdAutosDeseleccionados.toString();
        // var listaIdAutosSeleccionadosString=listaIdAutosSeleccionados.toString();



        var idTipoSucursal=document.getElementById('idTipoSucursalC').value;
        var idTipoVehiculo=document.getElementById('idTipoVehiculoC').value;
        var idUbicacion=document.getElementById('idUbicacionC').value; 
        var idOrigen=document.getElementById('idOrigenC').value;

       
        var marca=document.getElementById('marcaC').value;

        var  mode = document.getElementById('idModeloC');
        var modelo= mode.options[mode.selectedIndex].text;

        


        var anio=document.getElementById('anioC').value;
    	var dominio_patente=document.getElementById('dominio_patenteC').value;
    	var kilometros=document.getElementById('kilometrosC').value;
    	var deudas=document.getElementById('deudasC').value;
    	var precioCompra=document.getElementById('precioCompraC').value;
    	var color=document.getElementById('colorC').value;
    	var observaciones=document.getElementById('observacionesC').value;
    	var precioVenta=document.getElementById('precioVentaC').value;
    	var fechaIngreso=document.getElementById('fechaIngresoC').value;


      var parIdMarcaC=document.getElementById('idMarcaC').value;
      var parIdModeloC=document.getElementById('idModeloC').value;
      var parIdVehiculoInfoC=document.getElementById('idVehiculoInfoC').value;
      var parIdAnioC=document.getElementById('idAnioC').value;
      var parPrecioInforAutoC=document.getElementById('precioInforAutoC').value;

    
      var obj=document.getElementById('idVehiculoInfoC');
      var nombreVehiculo=obj.options[obj.selectedIndex].text;
      
  

    	var datoss='&idTipoSucursal='+idTipoSucursal +'&idTipoVehiculo='+idTipoVehiculo 
      +'&idUbicacion='+idUbicacion +'&idOrigen='+idOrigen +'&marca='+marca +'&modelo='+modelo 
      + '&anio='+anio +'&dominio_patente='+dominio_patente +'&kilometros='+kilometros 
      +'&deudas='+deudas +'&precioCompra='+precioCompra +'&color='+color 
      +'&observaciones='+observaciones +'&precioVenta='+precioVenta +'&fechaIngreso='+fechaIngreso
      +'&idMarcaC='+parIdMarcaC +'&idModeloC='+parIdModeloC +'&idVehiculoInfoC='+parIdVehiculoInfoC
      +'&idAnioC='+parIdAnioC +'&precioInforAutoC='+parPrecioInforAutoC+ '&vehiculoinputC='+nombreVehiculo;

    	$.ajax({
    			type:'post',
    			url:'procesos/agregarVehiculoUsado.php',
    			data:datoss,
    			success:function(r){
    				$('#agregarnuevosdatosmodal').modal('hide');
    				   alertify.success("Se agrego correctamente");

    				     datos= jQuery.parseJSON(r);

    				   document.getElementById('marcaC').value="";
    				   document.getElementById('modeloC').value="";
    				   document.getElementById('anioC').value="";
    				   document.getElementById('dominio_patenteC').value="";
    				   document.getElementById('kilometrosC').value="";
    				   document.getElementById('deudasC').value="";
    				   document.getElementById('precioCompraC').value="";
    				   document.getElementById('colorC').value="";
    				   document.getElementById('observacionesC').value="";
    				   document.getElementById('precioVentaC').value="";
    				   document.getElementById('fechaIngresoC').value="";



               arregloPoderosoAutos.push(datos['id']);
              // listaIdChequesTodos= arregloFinal.toString();
              listaIdAutosTodos= arregloPoderosoAutos.toString();
                        
              

    		 	  recargarVehiculoCanje(listaIdAutosTodos);

    				  
    			
    			 }


    	});



    	return false;
}

    }


</script>










<script type="text/javascript">

var listaIdChequesDeseleccionados=new Array();
var listaIdChequesSeleccionados=new Array();
var arregloFinal= new Array();


if('<?php echo $mostrarReg['id_cheques_entregados'];?>'==''){var arregloPoderoso= new Array();}
else{
  var arregloPoderoso=  '<?php echo $mostrarReg['id_cheques_entregados'];?>'.split(",");
}







$('.mi-selectorCheque').on("select2:unselect", function (e) {
                        // console.log("ID deseleccionado: " + e.params.data.id);

                          
                          
                          // var index= listaIdChequesSeleccionados.indexOf(e.params.data.id);
                            var index= arregloPoderoso.indexOf(e.params.data.id);
                          if(index>-1){

                            arregloPoderoso.splice(index,1);
                            // listaIdChequesSeleccionados.splice(index,1);  esto fue lo ultimo que comente
                          //  console.log(listaIdChequesSeleccionados.length);
                          // console.log(listaIdChequesSeleccionados.toString());
                          }

                          else{

                            // listaIdChequesDeseleccionados.push(e.params.data.id); esto fue lo ultimo q comente
                            // console.log(listaIdChequesDeseleccionados.toString());

                          }


                         });




$('.mi-selectorCheque').on("select2:select", function (e) {
                        console.log("ID seleccionado: " + e.params.data.id);

                          arregloPoderoso.push(e.params.data.id);
                          // listaIdChequesSeleccionados.push(e.params.data.id);    esto fue lo ultimo q comente
                          // listaIdChequesDeseleccionados.push(e.params.data.id); esto fue lo ultimo q comente

                          // console.log(listaIdChequesSeleccionados.length);
                          // console.log(listaIdChequesSeleccionados.toString());

                         });





//	var listaIdCheques= [0];

var listaIdChequesTodos="";
// var listaIdCheques="";


    function nuevoCheque(){
      cambiarBtnGenerarPreventa();

        var idEntidadCheque=document.getElementById('idEntidadCheque').value;
        var numeroCheque=document.getElementById('numeroCheque').value;
        var montoCheque=document.getElementById('montoCheque').value;	
        var fechaCobroCheque=document.getElementById('fechaCobroCheque').value;
     
       //  var listaIdChequesDeseleccionadosString= listaIdChequesDeseleccionados.toString();
       // var listaIdChequesSeleccionadosString=listaIdChequesSeleccionados.toString();


        var datosCheque='&idEntidadCheque='+idEntidadCheque +'&numeroCheque='+numeroCheque +'&montoCheque='+montoCheque +'&fechaCobroCheque='+fechaCobroCheque;



          $.ajax({
    			type:'post',
    			url:'procesos/agregarCheque.php',
    			data:datosCheque,
    			success:function(r){
    				$('#agregarnuevoCheque').modal('hide');
    				   alertify.success("Se agrego correctamente");

    				   document.getElementById('numeroCheque').value="";
    				   document.getElementById('montoCheque').value="";
    				   document.getElementById('fechaCobroCheque').value="";

			
    				   datos= jQuery.parseJSON(r);
					  	
					  	
    				  	arregloPoderoso.push(datos['id']);
    				    // listaIdChequesTodos+=datos['id']+',';    de aca
    				    
            //          	 arreglo= listaIdChequesTodos.split(",");


            //          	  if((arreglo.length>0) && (listaIdChequesDeseleccionados.length>0)){

            //          	  	for(i=0; i < arreglo.length; i++){

            //          	  		if(listaIdChequesDeseleccionados.includes(arreglo[i])){

            //          	  		//aca esta el tema ver que las i tienen el problema

            //          	  		// decirle a fernando que pruebe estooo que le de masaaaa

            //          	 			arreglo.splice(i,1);
            //          	 			i--;
            	 			

            //          	  		}

            //          	  	}

            //          	}   hasta aca

         
                        
                      // arregloFinal= listaIdChequesSeleccionados.concat(arreglo);  esto comente


    				  // listaIdChequesTodos= arregloFinal.toString();
    				  listaIdChequesTodos= arregloPoderoso.toString();
			 	
    				  
    				 
    				   	recargarCheque(listaIdChequesTodos);

   	 			
    			
    			}


    	});



	return false;


    }

</script>




<script type="text/javascript">
	
$('input[id="checkUsado"]').on('change', function(e){
    if (this.checked) {
        document.getElementById('selectVehiculoCanje').disabled=false; 
    	document.getElementById('btnNuevoVehiculoCanje').disabled=false;
    } 

    else{

    	    document.getElementById('selectVehiculoCanje').disabled=true; 
    	document.getElementById('btnNuevoVehiculoCanje').disabled=true;
    }

});




$('input[id="checkCheque"]').on('change', function(e){
    if (this.checked) {
        document.getElementById('selectCheque').disabled=false; 
    	document.getElementById('btnNuevoCheque').disabled=false;
    } 

    else{

    	document.getElementById('selectCheque').disabled=true; 
    	document.getElementById('btnNuevoCheque').disabled=true;
    }

});


</script>


<script type="text/javascript">
	
function asignarTelefono(){

  cambiarBtnGenerarPreventa();

var idCliente= document.getElementById('selectCliente').value;

          $.ajax({
    			type:'post',
    			data:"idCliente="+idCliente,
    			url:'procesos/obtenerTelfonoCliente.php',
    			success:function(r){
    			
    				
    				  datos= jQuery.parseJSON(r);
    				  $('#telefono').val(datos['telefono']);
    			
	 
    			
    			}


    	});


}

</script>


<script type="text/javascript">
               
$(document).ready(function() {

	if ( <?php echo $banderaAcceso;?> =='1'){


		 $.ajax({
    			type:'post',
    			data:"idCliente="+'<?php echo $mostrarReg['id_cliente'];?>',
    			url:'procesos/obtenerTelfonoCliente.php',
    			success:function(r){
    			
    		
    				  datos= jQuery.parseJSON(r);
    				  $('#telefono').val(datos['telefono']);
    			
	 
    			
    			}


    	});

	}

		else{

                var idCliente= document.getElementById('selectCliente').value;

          $.ajax({
    			type:'post',
    			data:"idCliente="+idCliente,
    			url:'procesos/obtenerTelfonoCliente.php',
    			success:function(r){
    			
    				
    				  datos= jQuery.parseJSON(r);
    				  $('#telefono').val(datos['telefono']);
    			
	 
    			
    			}


    	});
      }
   });


</script>




<script type="text/javascript">
               
$(document).ready(function(){



	if ( <?php echo $banderaAcceso;?> =='1'){


          $.ajax({
    			type:'post',
    			data:"idVehiculo="+'<?php echo $mostrarReg['id_vehiculo_prevendido'];?>',
    			url:'procesos/obtenerJSONVehiculo.php',
    			success:function(r){
    			
    				
    				  datos= jQuery.parseJSON(r);
    				  $('#dominioPatente').val(datos['dominio_patente']);
    				  $('#precioVenta').val(datos['precio_venta']);

    					
	 
    			
    			}


    	});
      }


	else{

var idVehiculo= document.getElementById('selectVehiculo').value;

          $.ajax({
    			type:'post',
    			data:"idVehiculo="+idVehiculo,
    			url:'procesos/obtenerJSONVehiculo.php',
    			success:function(r){
    			
    				
    				  datos= jQuery.parseJSON(r);
    				  $('#dominioPatente').val(datos['dominio_patente']);
    				  $('#precioVenta').val(datos['precio_venta']);

    					
	 
    			
    			}


    	});

      }
   });


</script>


<script type="text/javascript">
	

function asignarPrecioVentaDominio(){

cambiarBtnGenerarPreventa();


  document.getElementById('btnGenerarOrdenPreVenta').disabled=true;

var idVehiculo= document.getElementById('selectVehiculo').value;

          $.ajax({
    			type:'post',
    			data:"idVehiculo="+idVehiculo,
    			url:'procesos/obtenerJSONVehiculo.php',
    			success:function(r){
    			
    				
    				  datos= jQuery.parseJSON(r);
    				  $('#dominioPatente').val(datos['dominio_patente']);
    				  $('#precioVenta').val(datos['precio_venta']);

    					
	 
    			
    			}


    	});


}


</script>

<script type="text/javascript">
	
	function calcularSaldo(){

    

    if(document.getElementById('selectVehiculo').value>0 && document.getElementById('selectCliente').value>0 && document.getElementById('selectVendedor').value>0 ){



    






    var isCheckedAuUsado = document.getElementById('checkUsado').checked;
if(isCheckedAuUsado){
  
var datosLista='&listaIdAutosSeleccionados='+arregloPoderosoAutos;


}
else{
  var datosLista='&listaIdAutosSeleccionados='+'';
}


  var isCheckedCheque = document.getElementById('checkCheque').checked;
if(isCheckedCheque){
  
 datosLista= datosLista+'&listaIdChequesSeleccionados='+arregloPoderoso;


}
else{
   datosLista= datosLista+'&listaIdChequesSeleccionados='+'';
}



        document.getElementById('btnGenerarOrdenPreVenta').disabled=false;




        $.ajax({
          type:'post',
          url:'procesos/obtenerMontoVehiculosYCheques.php',
          data:datosLista,
          success:function(r){
          
                        datos= jQuery.parseJSON(r);

                        if(isNaN(parseFloat($('#costoTransferencia').val()))){
                          var a=0;
                        }
                        else{
                          var a=parseFloat($('#costoTransferencia').val());
                        }

                        if(isNaN(parseFloat($('#costoInforme').val()))){
                          var b=0;
                        }
                        else{
                          var b=parseFloat($('#costoInforme').val());
                        }

                         if(isNaN(parseFloat($('#comisionVendedor').val()))){
                          var c=0;
                        }
                        else{
                          var c=parseFloat($('#comisionVendedor').val());
                        }



                        saldo=$('#precioVenta').val()-$('#entregaEfectivo').val()-datos['totalUsados']-$('#montoPrendario').val()-$('#montoSellado').val()+a+b+c-$('#montoPersonal').val();

                        

              
          $('#saldoApagar').val(saldo);
                    $('#salddoApagar').val(saldo);

                                    
          
           }


      });

}



else{


 alertify.error("Debe seleccionar vendedor,cliente y vehiculo");





}













  }



</script>






<script type="text/javascript">
    
function generandoOrdenPreVenta(){



    document.formularioOrdenPreventa.valorVehiculo.value=document.getElementById('selectVehiculo').value;
    document.formularioOrdenPreventa.valorCliente.value=document.getElementById('selectCliente').value;
    document.formularioOrdenPreventa.valorVendedor.value=document.getElementById('selectVendedor').value;



    document.formularioOrdenPreventa.valorMedio.value=document.getElementById('selectMedio').value;


       

    document.formularioOrdenPreventa.listaVehiculoCanje.value=arregloPoderosoAutos;




    document.formularioOrdenPreventa.listaChequesEntregados.value=arregloPoderoso;




    //  credito 

    if(!(document.getElementById('checkCredito').checked)){
    document.formularioOrdenPreventa.valorCheckCreditoPrendario.value=0;
    document.formularioOrdenPreventa.valorMontoPrendario.value=0;
    document.formularioOrdenPreventa.valorMontoSellado.value=0;

    }
    else{ document.formularioOrdenPreventa.valorCheckCreditoPrendario=document.getElementById('checkCredito').value;
    }

    if(document.getElementById('montoPrendario') == null){
         document.formularioOrdenPreventa.valorMontoPrendario=0;
    }
    else{ document.formularioOrdenPreventa.valorMontoPrendario.value=document.getElementById('montoPrendario').value;}
   
    if(document.getElementById('montoSellado')==null){ document.formularioOrdenPreventa.valorMontoSellado=0; }
     else {document.formularioOrdenPreventa.valorMontoSellado.value=document.getElementById('montoSellado').value;}  

     document.formularioOrdenPreventa.idEntidadCreditoPrendario.value=document.getElementById('idEntidad').value;
      document.formularioOrdenPreventa.idEntidadCreditoPersonal.value=document.getElementById('idEntidadCpersonal').value;


     
    
      document.formularioOrdenPreventa.valorFechaCargaPreVenta.value=document.getElementById('fechaCargaPreVenta').value;

      
      if(!(document.getElementById('checkCreditoPersonal').checked)){
    document.formularioOrdenPreventa.valorCheckCreditoPersonal.value=0;
   
        
    }



    if(document.getElementById('montoPersonal') == null){
         document.formularioOrdenPreventa.valorMontoPersonal=0;
    }
    else{ document.formularioOrdenPreventa.valorMontoPersonal.value=document.getElementById('montoPersonal').value;}



    return true;

}


</script>




<script type="text/javascript">
    
    if('<?php echo $banderaAcceso;?>'=='1'){

document.getElementById('entregaEfectivo').value='<?php echo $mostrarReg['efectivo_entregado'];?>';


if('<?php echo $mostrarReg['monto_prendario'];?>'== '0'){
 document.getElementById('montoSellado').value='<?php echo $mostrarReg['monto_sellado'];?>';
document.getElementById('montoPrendario').value='<?php echo $mostrarReg['monto_prendario'];?>';
}
else{

document.getElementById('montoSellado').value='<?php echo $mostrarReg['monto_sellado'];?>';
document.getElementById('montoSellado').disabled=true;
document.getElementById('montoPrendario').value='<?php echo $mostrarReg['monto_prendario'];?>';
document.getElementById('montoPrendario').disabled=true;
document.getElementById('checkCredito').checked=true;
document.getElementById('idEntidad').disabled=true;
document.getElementById('idEntidad').value='<?php echo $mostrarReg['entidad_prendaria'];?>';


}



if('<?php echo $mostrarReg['monto_personal'];?>'== '0'){
  document.getElementById('montoPersonal').value='<?php echo $mostrarReg['monto_personal'];?>';
}
else{
  document.getElementById('montoPersonal').disabled=true;
document.getElementById('montoPersonal').value='<?php echo $mostrarReg['monto_personal'];?>';
 document.getElementById('checkCreditoPersonal').checked=true;
 document.getElementById('idEntidadCpersonal').disabled=true;
 document.getElementById('idEntidadCpersonal').value='<?php echo $mostrarReg['entidad_prendario_personal'];?>';


}





// document.getElementById('montoPersonal').value='<?php echo $mostrarReg['monto_personal'];?>';
document.getElementById('costoInforme').value='<?php echo $mostrarReg['costo_informe'];?>';
document.getElementById('costoTransferencia').value='<?php echo $mostrarReg['costo_transferencia'];?>';
document.getElementById('comisionVendedor').value='<?php echo $mostrarReg['comision_vendedor'];?>';
document.getElementById('observaciones').value='<?php echo $mostrarReg['observaciones'];?>';
document.getElementById('fechaCargaPreVenta').value='<?php echo $mostrarReg['fecha_carga_preventa'];?>';
document.getElementById('selectVehiculo').disabled=true;
document.getElementById('selectCliente').disabled=true;
document.getElementById('selectVendedor').disabled=true;
document.getElementById('btnNuevoVehiculo').disabled=true;
document.getElementById('btnNuevoCliente').disabled=true;
document.getElementById('btnNuevoVendedor').disabled=true;
document.getElementById('idPreVenta').value='<?php echo $mostrarReg['id'];?>';

    }



    if('<?php echo $_SESSION['permisos'];?>' =='3'){


      document.getElementById('selectVendedor').disabled=true;
      document.getElementById('btnNuevoVendedor').disabled=true;
      document.getElementById('filaVendedorC').hidden=true;
      

    }

    document.getElementById('fechaCargaPreVenta').disabled=true;



    document.getElementById('checkCreditoPersonal').disabled=true;
    document.getElementById('checkCredito').disabled=true;

    document.getElementById('selectMedio').disabled=true;
    document.getElementById('observaciones').disabled=true;
    document.getElementById('costoTransferencia').disabled=true;
    document.getElementById('costoInforme').disabled=true;
    document.getElementById('comisionVendedor').disabled=true;

    document.getElementById('checkUsado').disabled=true;
    document.getElementById('checkCheque').disabled=true;
        
    document.getElementById('saldoApagar').value='<?php echo $mostrarReg['saldo_final_preventa'];?>';
    
    document.getElementById('selectVehiculoCanje').disabled=true;
    document.getElementById('selectCheque').disabled=true;
    








</script>

<script type="text/javascript">
    function inicializarCaja(){


        datos=$('#frmnuevoInicializar').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"procesos/inicializarCaja.php",
            success:function(){
                    
                    $('#inicializarCajaModal').modal('hide');
                     
                    // alertify.success("Se agrego correctamente");

                    
                    location.reload();
                    

            },
            error:function(){

                alertify.success("No se pudo agregar correctamente");
                
            }


        });

        return false;

    }


</script>

<script type="text/javascript">
    function nuevaCaja(){


        datos=$('#frmnuevo').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"procesos/agregarCaja.php",
            success:function(){
                    // alertify.success("Se agrego correctamente");
                    $('#agregarnuevosdatosmodalCaja').modal('hide');
                     
                      location.reload();
                    
                    

            },
            error:function(){

                alertify.success("No se pudo agregar correctamente");
                
            }


        });


        return false;

    }


</script>

<script type="text/javascript">
    function cerrarCaja(){


        datos=$('#frmnuevoCerrarCaja').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"procesos/cerrarCaja.php",
            success:function(){
                    
                    $('#cerrarCajaModal').modal('hide');
                     
                    // alertify.success("Se agrego correctamente");

                    
                    location.reload();
                    

            },
            error:function(){

                alertify.success("No se pudo agregar correctamente");
                
            }


        });

        return false;

    }


</script>


<script type="text/javascript">
                $(document).ready(function() {
                   
                   $('#NombreLoguin').text('<?php echo $mostrarloguin['nombre'].' '.$mostrarloguin['apellido'];?>');
                   cargarMarcas();
                });
</script>




<script type="text/javascript">
                function cambiarBtnGenerarPreventa(){
                  document.getElementById('btnGenerarOrdenPreVenta').disabled=true;

                }
</script>

<script>
  

$(document).ready(function(){
  $("input[name=montoPrendario]").change(function(){
    cambiarBtnGenerarPreventa();
  });
 
  $("input[name=montoSellado]").change(function(){
    cambiarBtnGenerarPreventa();
  });

   $("input[name=montoPersonal]").change(function(){
    cambiarBtnGenerarPreventa();
  });

   $("input[name=entregaEfectivo]").change(function(){
    cambiarBtnGenerarPreventa();
  });



     $("input[name=costoTransferencia]").change(function(){
    cambiarBtnGenerarPreventa();
  });

       $("input[name=costoInforme]").change(function(){
    cambiarBtnGenerarPreventa();
  });

        $("input[name=comisionVendedor]").change(function(){
    cambiarBtnGenerarPreventa();
  }); 

       
  
});



  if('<?php echo $banderaAcceso;?>'==1){

           document.getElementById('btnNuevoCheque').hidden=true;
             document.getElementById('btnNuevoVehiculoCanje').hidden=true
             // document.getElementById('btnNuevoVendedor').hidden=true
             // document.getElementById('btnNuevoCliente').hidden=true
             // document.getElementById('btnNuevoVehiculo').hidden=true

          
        }




</script>

<script>

if('<?php echo $_SESSION["permisos"];?>'=='2' || '<?php echo $_SESSION["permisos"];?>'=='3' ){
    document.getElementById('linkUsuarios').hidden=true;
    linkIndex.removeAttribute('href');



}
if('<?php echo $_SESSION["permisos"];?>'=='3' ){ // esto es si es un vendedor
    document.getElementById('linkMovimientos').hidden=true;
    document.getElementById('linkOtros').hidden=true;
    
    document.getElementById('linkVentasExistentes').hidden=true;

}


</script>
<script>
function habilitarCampos(){

// metodo para habilitar y deshabilitar campos segun que tipo de vehicuklo selecciona


if(document.getElementById('idTipoVehiculo').value =='4'){
   

document.getElementById('divMarcaInput').hidden=false;
document.getElementById('divMarca').hidden=true;
document.getElementById('idMarca').required=false;
document.getElementById('idMarca').value='0';
document.getElementById('divModeloInput').hidden=false;
document.getElementById('divModelo').hidden=true;
document.getElementById('idModelo').required=false;
document.getElementById('idModelo').value='0';
document.getElementById('divLabelVehiculo').hidden=true;
document.getElementById('divVehiculo').hidden=true;
document.getElementById('idVehiculoInfo').required=false;
document.getElementById('idVehiculoInfo').value='0';

document.getElementById('divAnio').hidden=true;
document.getElementById('idAnio').required=false;
document.getElementById('idAnio').value='0';
document.getElementById('divAnioInput').hidden=false;

document.getElementById('divLabelPrecio').hidden=true;
document.getElementById('divPrecio').hidden=true;
document.getElementById('precioInforAuto').value='0';



}
else{


document.getElementById('divMarcaInput').hidden=true;
document.getElementById('divMarca').hidden=false;
document.getElementById('divModeloInput').hidden=true;
document.getElementById('divModelo').hidden=false;


document.getElementById('divLabelVehiculo').hidden=false;
document.getElementById('divVehiculo').hidden=false;

document.getElementById('divAnio').hidden=false;
document.getElementById('divAnioInput').hidden=true;
document.getElementById('divLabelPrecio').hidden=false;
document.getElementById('divPrecio').hidden=false;



}
    


}



</script>


<script type="text/javascript">
//Cargar marcas

function objetoAjax(){
	var xmlhttp = false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {

		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false; }
		}

		if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
			xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
	}

	function cargarMarcas(){

        

        //Recogemos los es introducimos en los campos de texto
    // nombre = document.formularioCorredores.inputNombreCorredor.value;
    // cuit=document.formularioCorredores.inputCuitCorredor.value;


    //instanciamos el objetoAjax
    ajax = objetoAjax();
    

    //Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
    ajax.open("POST", "procesos/obtenerMarcasInfo.php", true);
  
    //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
    ajax.onreadystatechange = function() {
        
        
             //Cuando se completa la petición, mostrará los resultados
             if (ajax.readyState == 4){

        //El método responseText() contiene el texto de nuestro 'consultar.php'. Por ejemplo, cualquier texto que mostremos por un 'echo


        $('#idMarca').html(ajax.responseText);
        // if(ajax.responseText.length<67) document.formularioCorredores.btnNuevoCorredor.disabled=false;


    }
   
}

    //Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

    //enviamos las variables a 'consulta.php'
     ajax.send("&nombre="+"asd"+"&cuit="+"asd"+"&codigoCorredorModif="+"asd")

}




function cargarModelos(){

    marca = document.getElementById('idMarca').value;
    $('#idVehiculoInfo').html('');
    $('#idAnio').html('');
    
//instanciamos el objetoAjax
ajaxModelo = objetoAjax();



//Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
ajaxModelo.open("POST", "procesos/obtenerModeloInfo.php", true);

//cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
ajaxModelo.onreadystatechange = function() {


     //Cuando se completa la petición, mostrará los resultados
     if (ajaxModelo.readyState == 4){

//El método responseText() contiene el texto de nuestro 'consultar.php'. Por ejemplo, cualquier texto que mostremos por un 'echo


$('#idModelo').html(ajaxModelo.responseText);
// if(ajax.responseText.length<67) document.formularioCorredores.btnNuevoCorredor.disabled=false;


}

}

//Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
ajaxModelo.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

//enviamos las variables a 'consulta.php'
ajaxModelo.send("&idMarca="+marca);

}






function cargarVehiculo(){

modelo = document.getElementById('idModelo').value;
$('#idAnio').html('');

// console.log(modelo);
//instanciamos el objetoAjax
ajaxVehiculo = objetoAjax();


//Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
ajaxVehiculo.open("POST", "procesos/obtenerVehiculoInfo.php", true);

//cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
ajaxVehiculo.onreadystatechange = function() {


 //Cuando se completa la petición, mostrará los resultados
 if (ajaxVehiculo.readyState == 4){

//El método responseText() contiene el texto de nuestro 'consultar.php'. Por ejemplo, cualquier texto que mostremos por un 'echo


$('#idVehiculoInfo').html(ajaxVehiculo.responseText);
// if(ajax.responseText.length<67) document.formularioCorredores.btnNuevoCorredor.disabled=false;


}

}

//Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
ajaxVehiculo.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

//enviamos las variables a 'consulta.php'
ajaxVehiculo.send("&idModelo="+modelo);

}





/// cargo los años con sus respectivos precios


function cargarAnios(){

vehi = document.getElementById('idVehiculoInfo').value;

 console.log(modelo);
//instanciamos el objetoAjax
ajaxAnio = objetoAjax();


//Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
ajaxAnio.open("POST", "oauth-infoauto/obtenerPrecioInfo.php", true);

//cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
ajaxAnio.onreadystatechange = function() {


 //Cuando se completa la petición, mostrará los resultados
 if (ajaxAnio.readyState == 4){

//El método responseText() contiene el texto de nuestro 'consultar.php'. Por ejemplo, cualquier texto que mostremos por un 'echo


$('#idAnio').html(ajaxAnio.responseText);
// if(ajax.responseText.length<67) document.formularioCorredores.btnNuevoCorredor.disabled=false;


}

}

//Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
ajaxAnio.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

//enviamos las variables a 'consulta.php'
ajaxAnio.send("&vehiculo="+vehi);

}







function mostrarPrecioInfo(){
    // obtengo el elemento de anio y seteo los precios
    e = document.getElementById('idAnio');
   res=e.options[e.selectedIndex].value;
   arrS=res.split('--');

    document.getElementById('precioInforAuto').value=arrS[1]*1000;
    document.getElementById('precioInforAutoD').value=arrS[1]*1000;


    // obtengo el elemento marca y lo seteo en el input para la bd
    mar = document.getElementById('idMarca');
    resM=mar.options[mar.selectedIndex].text;

    document.getElementById('marca').value=resM;

    // obtengo el modelo para setear en la bd q esta compuesto  por marca y vehiculo


    mode = document.getElementById('idModelo');
    resMod=mode.options[mode.selectedIndex].text;

    vehi = document.getElementById('idVehiculoInfo');
    resVehi=vehi.options[vehi.selectedIndex].text;

    document.getElementById('modelo').value=resM+' '+resVehi;


    // hago lo mismo para añoooo

    anioo = document.getElementById('idAnio');
    resA=anioo.options[anioo.selectedIndex].text;

    document.getElementById('anio').value=parseInt(resA, 10);





}

</script>








<script>
function habilitarCamposC(){

// metodo para habilitar y deshabilitar campos segun que tipo de vehicuklo selecciona


if(document.getElementById('idTipoVehiculoC').value =='4'){
   

document.getElementById('divMarcaInputC').hidden=false;
document.getElementById('divMarcaC').hidden=true;
document.getElementById('idMarcaC').required=false;
document.getElementById('idMarcaC').value='0';
document.getElementById('divModeloInputC').hidden=false;
document.getElementById('divModeloC').hidden=true;
document.getElementById('idModeloC').required=false;
document.getElementById('idModeloC').value='0';
document.getElementById('divLabelVehiculoC').hidden=true;
document.getElementById('divVehiculoC').hidden=true;
document.getElementById('idVehiculoInfoC').required=false;
document.getElementById('idVehiculoInfoC').value='0';

document.getElementById('divAnioC').hidden=true;
document.getElementById('idAnioC').required=false;
document.getElementById('idAnioC').value='0';
document.getElementById('divAnioInputC').hidden=false;

document.getElementById('divLabelPrecioC').hidden=true;
document.getElementById('divPrecioC').hidden=true;
document.getElementById('precioInforAutoC').value='0';



}
else{


document.getElementById('divMarcaInputC').hidden=true;
document.getElementById('divMarcaC').hidden=false;
document.getElementById('divModeloInputC').hidden=true;
document.getElementById('divModeloC').hidden=false;


document.getElementById('divLabelVehiculoC').hidden=false;
document.getElementById('divVehiculoC').hidden=false;

document.getElementById('divAnioC').hidden=false;
document.getElementById('divAnioInputC').hidden=true;
document.getElementById('divLabelPrecioC').hidden=false;
document.getElementById('divPrecioC').hidden=false;



}
    


}



</script>


<script type="text/javascript">
//Cargar marcas

function objetoAjax(){
	var xmlhttp = false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {

		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false; }
		}

		if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
			xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
	}

	function cargarMarcasC(){

        

        //Recogemos los es introducimos en los campos de texto
    // nombre = document.formularioCorredores.inputNombreCorredor.value;
    // cuit=document.formularioCorredores.inputCuitCorredor.value;


    //instanciamos el objetoAjax
    ajax = objetoAjax();
    

    //Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
    ajax.open("POST", "procesos/obtenerMarcasInfo.php", true);
  
    //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
    ajax.onreadystatechange = function() {
        
        
             //Cuando se completa la petición, mostrará los resultados
             if (ajax.readyState == 4){

        //El método responseText() contiene el texto de nuestro 'consultar.php'. Por ejemplo, cualquier texto que mostremos por un 'echo


        $('#idMarcaC').html(ajax.responseText);
        // if(ajax.responseText.length<67) document.formularioCorredores.btnNuevoCorredor.disabled=false;


    }
   
}

    //Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

    //enviamos las variables a 'consulta.php'
     ajax.send("&nombre="+"asd"+"&cuit="+"asd"+"&codigoCorredorModif="+"asd")

}




function cargarModelosC(){

    marca = document.getElementById('idMarcaC').value;
    $('#idVehiculoInfoC').html('');
    $('#idAnioC').html('');
    
//instanciamos el objetoAjax
ajaxModelo = objetoAjax();


//Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
ajaxModelo.open("POST", "procesos/obtenerModeloInfo.php", true);

//cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
ajaxModelo.onreadystatechange = function() {


     //Cuando se completa la petición, mostrará los resultados
     if (ajaxModelo.readyState == 4){

//El método responseText() contiene el texto de nuestro 'consultar.php'. Por ejemplo, cualquier texto que mostremos por un 'echo


$('#idModeloC').html(ajaxModelo.responseText);
// if(ajax.responseText.length<67) document.formularioCorredores.btnNuevoCorredor.disabled=false;


}

}

//Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
ajaxModelo.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

//enviamos las variables a 'consulta.php'
ajaxModelo.send("&idMarca="+marca);

}






function cargarVehiculoC(){

modelo = document.getElementById('idModeloC').value;
$('#idAnioC').html('');

// console.log(modelo);
//instanciamos el objetoAjax
ajaxVehiculo = objetoAjax();


//Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
ajaxVehiculo.open("POST", "procesos/obtenerVehiculoInfo.php", true);

//cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
ajaxVehiculo.onreadystatechange = function() {


 //Cuando se completa la petición, mostrará los resultados
 if (ajaxVehiculo.readyState == 4){

//El método responseText() contiene el texto de nuestro 'consultar.php'. Por ejemplo, cualquier texto que mostremos por un 'echo


$('#idVehiculoInfoC').html(ajaxVehiculo.responseText);
// if(ajax.responseText.length<67) document.formularioCorredores.btnNuevoCorredor.disabled=false;


}

}

//Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
ajaxVehiculo.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

//enviamos las variables a 'consulta.php'
ajaxVehiculo.send("&idModelo="+modelo);

}





/// cargo los años con sus respectivos precios


function cargarAniosC(){

vehi = document.getElementById('idVehiculoInfoC').value;

 console.log(modelo);
//instanciamos el objetoAjax
ajaxAnio = objetoAjax();


//Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
ajaxAnio.open("POST", "oauth-infoauto/obtenerPrecioInfo.php", true);

//cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
ajaxAnio.onreadystatechange = function() {


 //Cuando se completa la petición, mostrará los resultados
 if (ajaxAnio.readyState == 4){

//El método responseText() contiene el texto de nuestro 'consultar.php'. Por ejemplo, cualquier texto que mostremos por un 'echo


$('#idAnioC').html(ajaxAnio.responseText);
// if(ajax.responseText.length<67) document.formularioCorredores.btnNuevoCorredor.disabled=false;


}

}

//Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
ajaxAnio.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

//enviamos las variables a 'consulta.php'
ajaxAnio.send("&vehiculo="+vehi);

}



function mostrarPrecioInfoC(){
    // obtengo el elemento de anio y seteo los precios
    o = document.getElementById('idAnioC');
   res=o.options[o.selectedIndex].value;
   arrS=res.split('--');
  

    document.getElementById('precioInforAutoC').value=arrS[1]*1000;
    document.getElementById('precioInforAutoDC').value=arrS[1]*1000;


    // obtengo el elemento marca y lo seteo en el input para la bd
    mar = document.getElementById('idMarcaC');
    resM=mar.options[mar.selectedIndex].text;
   

    document.getElementById('marcaC').value=resM;

    // obtengo el modelo para setear en la bd q esta compuesto  por marca y vehiculo


    mode = document.getElementById('idModeloC');
    resMod=mode.options[mode.selectedIndex].text;

    vehi = document.getElementById('idVehiculoInfoC');
    resVehi=vehi.options[vehi.selectedIndex].text;

    document.getElementById('modeloC').value=resM+' '+resVehi;


    // hago lo mismo para añoooo

    anioo = document.getElementById('idAnioC');
    resA=anioo.options[anioo.selectedIndex].text;

    document.getElementById('anioC').value=parseInt(resA, 10);





}

</script>


<script>


function aprobarPreVenta(){
  id='<?php echo base64_decode($_GET['datos']);?>';
  
              $.ajax({
      type:"POST",
      data:"id=" + id,
      url:"procesos/aprobarPreVenta.php",
      success:function(r){
          
        
        window.location.href='aprobarPreVentas.php';
            
           
              alertify.success("Aprobado con exito");
              
              
      },
      error: function(){

          alertify.error("No se pudo Aprobar");
          

      }
  });

    
     


}

function revisarPreVenta(){
  id='<?php echo base64_decode($_GET['datos']);?>';
 
            $.ajax({
    type:"POST",
    data:"id=" + id,
    url:"procesos/revisarPreVenta.php",
    success:function(r){
        
      
            $('#tablaDatatable').load('tablaPreVentasRevision.php?pme=t');
          
         
            alertify.success("Aprobado con exito");
            
            
    },
    error: function(){

        alertify.error("No se pudo Aprobar");
        

    }
});

  

}


function rechazarPreVenta(){
  
  id='<?php echo base64_decode($_GET['datos']);?>';


            $.ajax({
    type:"POST",
    data:"id=" + id,
    url:"procesos/rechazarPreVenta.php",
    success:function(r){
        
      
            $('#tablaDatatable').load('tablaPreVentasRevision.php?pme=t');
          
         
            alertify.success("Aprobado con exito");
            
            
    },
    error: function(){

        alertify.error("No se pudo Aprobar");
        

    }
});

  

}



</script>