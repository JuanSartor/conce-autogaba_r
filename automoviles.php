 <?php  
      session_start();  
      if(isset($_SESSION["usernameC"]))   
      {  
           if((time() - $_SESSION['last_login_timestamp']) > 36000) // 900 = 15 * 60   el 60 son segundos
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

    

        ?>
        
    <!-- Required meta tags -->
<meta content="width=device-width, initial-scale=1.0" name="viewport" >
    
    <!-- Bootstrap CSS -->

    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css"> 
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    
    <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css"> 


     <link href="librerias/bootstrap/tableexport.css" rel="stylesheet" type="text/css">

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
            <a id="linkIndex" name="linkIndex" class="navbar-brand" href="index.php">  <img src="static/img/gaba.jpeg" height="48" width="48"></a>

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
                                <a class="nav-link" id="linkUsuarios" name="linkUsuarios"   href="usuarios.php" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-user"></i>Usuarios</a>
                                
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="clientes.php"  id="linkClientes" name="linkClientes" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-hands-helping"></i>Clientes</a>
                               
                            </li>
                            <!--  <li class="nav-item">
                                <a class="nav-link" href="vendedores.php"  aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-hand-holding-usd"></i>Vendedores</a>
                             
                            </li> -->
                            <!-- <li class="nav-item ">
                                <a class="nav-link" href="#"  style="background-color: lightsteelblue;"  aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-car"></i>Automoviles</a>
                               
                            </li> -->
                            <li class="nav-item" id="linkAutomoviles" name="linkAutomoviles">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-88" aria-controls="submenu-6"><i class="fas fa-car"></i> Automoviles </a>
                                <div id="submenu-88" class="collapse submenu show">
                                    <ul class="nav flex-column">
                                          <li class="nav-item ">
                                  <a class="nav-link active" href="#"   aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-car"></i>Gestionar Automoviles</a>
                                
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="linkActualizarPrecios"   aria-expanded="false" data-toggle="modal" data-target ="#modalActualizarPrecio"  aria-controls="submenu-7"><i class="fas fa-dollar-sign"></i>Actualizar Precios</a>
                                                      
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"  id="linkBuscarPreciosTodos" href="buscarInfoAuto.php"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-dollar-sign"></i>Buscar Precio Info Auto</a>
                                
                            </li>
                 
                                                                                
                                    </ul>
                                </div>
                            </li>



                           
                            <li class="nav-divider" id="operaciones">
                                OPERACIONES
                            </li>

                                
                            <li class="nav-item">
                              <a class="nav-link" href="consumos.php"  id="linkMovimientos" name="linkMovimientos" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-money-bill-wave"></i>Movimientos Varios</a>

                                                       
                            </li>
                                     <li class="nav-item" id="linkVentas" name="linkVentas">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-calculator"></i> Ventas </a>
                                <div id="submenu-6" class="collapse submenu">
                                    <ul class="nav flex-column">
                                          <li class="nav-item ">
                                  <a class="nav-link" onclick="redirPreVenta();"  aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fab fa-wpforms"></i>Nueva Pre-Venta</a>
                                
                            </li>



                            <li class="nav-item">
                                <a class="nav-link" href="gestionarPagos.php" id="linkVentasExistentes" name="linkVentasExistentes"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-dollar-sign"></i>Ventas Existentes</a>

                                                       
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="aprobarPreVentas.php"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-registered"></i>Aprobar Pre-Ventas</a>

                                
                            </li>
                          <!--   <li class="nav-item">
                                <a class="nav-link" href="pagos.php"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-cash-register"></i>Lista Pagos Realizados</a>

                                                       
                            </li> -->
                                                                                
                                    </ul>
                                </div>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" id="linkOtros" name="linkOtros" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-columns"></i>Otros</a>
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
     
                <div class="card text-center" style="width: 1250px;">
                    <div class="card-header">
                         AUTOMOVILES

                         <div class="row">
                         <div class="col-sm-1" >
                <button type="button"  class="btn btn-primary mb-1" id="btnNuevoProductor" data-toggle="modal" data-target ="#agregarnuevosdatosmodal"  > <span class="fas fa-plus-circle"></span> Nuevo Vehiculo</button>
            </div>

            <div class="form-group row">
  
		
		

			</div>
               <div class="col-sm-8" > </div>
               <div class="col-sm-1" > 
               <label for="cars">Filtrar:</label>
           </div>
            <div class="col-sm-1" > 
               <select id="filSelect" name="filSelect" class="mi-selectorVehiculos">
                  <option  value="t" onclick="listarTodos()">Todos</option>
                  <option  value="a" onclick="listarAIngresar()">A Ingresar</option>
                  <option value="s" onclick="listarStock()">Stock</option>
                  <option  value="r" onclick="listarReservado()">Reservado</option>
                  <option  value="v" onclick="listarVendido()">Vendido</option>
                  <option  value="c" onclick="listarCancelado()">Cancelado</option>
              </select>
          </div>
         

            </div>
                            
                    </div>

                    <div class="card-body">
                        
                        
                        
                        
                        <div id="tablaDatatable"></div>

                    </div>
                    
                </div>


            </div>

        </div>


    </div>


<!--  <div class="col-sm-1" >
                <button type="button"  class="btn btn-success mb-1" style="border-radius: 8px; background-color: darkgreen;" id="btnNuevoProductor" data-toggle="modal" data-target ="#agregarnuevosdatosmodal"  > <span  class="far fa-file-excel"></span> Exportar a Excel</button>
            </div> -->

                    
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
       <!--     <div class="footer">
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
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
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
   
    <!-- slimscroll js -->
     <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
     <script src="assets/libs/js/main-js.js"></script> 
    <!-- chart chartist js -->
 
    <!-- chart c3 js -->





<!-- Modal agregar gasto automovil -->
<div class="modal fade" id="modalActualizarPrecio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualizar Precio de Venta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmActualizarPrecio"  onsubmit="actualizarPreciosTodos()"  action="" method="post">
    





    <label>Porcentaje</label>

    <input type="text" class="form-control input-sm"  required="true" id="porcentaje" name="porcentaje"  minlength="1" maxlength="5" pattern="[0-9]+(\.[0-9]{1,2})?%?">
        


       
 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnEditarNuevo"  class="btn btn-primary" >Actualizar</button>
      </div>


</form>


      </div>
      
    </div>
  </div>
</div>

























<!-- Modal agregar -->
<div class="modal fade"  id="agregarnuevosdatosmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog"  role="document">
    <div class="modal-content" style="width: 700px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Vehiculo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevo" onsubmit= " return nuevoVehiculo();"  action="" method="post">

	
	<?php 

	$conexionSucursales= conectar();
	mysqli_set_charset($conexionSucursales,'utf8'); 
	$sqlc= "SELECT * from sucursales order by LENGTH(descripcion) desc";

	$resultadoSucursales=mysqli_query($conexionSucursales,$sqlc);

	mysqli_close($conexionSucursales);
	
		 ?>


	<div class="row">
		<div class="col-sm-2" >
		<label >Sucursal: </label>
		</div>
		<div class="col-sm-4" >
<select style="width: 200px; "  id="idTipoSucursal"   name="idTipoSucursal" class="mi-selectorSucursal"   required="true">
				<?php

				while ($valoresA = mysqli_fetch_array($resultadoSucursales)) {
					?>
					<option    value="<?php print($valoresA['id']);?>"> <?php  print($valoresA['descripcion']);?> </option>

					<?php
				}
				?>
			</select>


                <!-- <button type="button"  class="btn btn-primary mb-1" id="btnNuevoProductor" data-toggle="modal" data-target ="#modalAgregarSucursal"  style="width: 50px"> <span class="fas fa-plus-circle"></span> </button> -->
            

</div>


    <div class="col-sm-2" >
        <label >Estado: </label>
    </div>
    <div class="col-sm-4" >
        <select style="width: 200px; " id="es" name="es" class="mi-selectorEstado" style="background-color: gainsboro;">
            <option value="1"> <?php  print"A Ingresar";?> </option>
            <option value="2"> <?php  print"Stock";?> </option>
        </select>

    </div> 

                
            </div>
            <br>




<?php 

	$conexionLugar= conectar();
	mysqli_set_charset($conexionLugar,'utf8'); 
	$sqlc= "SELECT * from lugar_donde_se_encuentra_vehiculo order by LENGTH(descripcion) desc";

	$resultadoLugar=mysqli_query($conexionLugar,$sqlc);

	mysqli_close($conexionLugar);
	
		 ?>


	<div class="row">
		<div class="col-sm-2" >
		<label >Ubicacion: </label>
	</div>
	<div class="col-sm-4"  >
<select style="width: 200px; "   id="idUbicacion" name="idUbicacion" class="mi-selectorUbicacion" style="background-color: gainsboro;" required="true">
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
	$sqlc= "SELECT * from origenes_vehiculo order by LENGTH(descripcion) desc";

	$resultadoOrigen=mysqli_query($conexionOrigen,$sqlc);

	mysqli_close($conexionOrigen);
	
		 ?>


		<div class="col-sm-2" >
		<label >Origen: </label>
	</div>
	<div class="col-sm-3"  >
<select style="width: 200px; " id="idOrigen" name="idOrigen" class="mi-selectorOrigen" style="background-color: gainsboro;" required="true">
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

<br>


<div class="row">

    <?php 

    $conexionTipoVehiculo= conectar();
    mysqli_set_charset($conexionTipoVehiculo,'utf8'); 
    $sqlc= "SELECT * from tipos_vehiculos order by LENGTH(descripcion) desc";

    $resultadoTipoVehiculo=mysqli_query($conexionTipoVehiculo,$sqlc);

    mysqli_close($conexionTipoVehiculo);
    
         ?>

    
        <div class="col-sm-2" >
        <label >Tipo Vehiculo:</label>
    </div>
    <div class="col-sm-4" >
<select style="width: 200px; "  id="idTipoVehiculo" name="idTipoVehiculo" onchange="habilitarCampos();"  class="mi-selectorTipoVehiculo" style="background-color: gainsboro; " required="true">
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

<div class="col-sm-6" id="divMarcaInput" hidden  >
    <input style="text-transform: capitalize;"   type="text" class="form-control input-sm" id="marca" name="marca"  minlength="2" maxlength="50">
</div>

<div class="col-sm-4" id="divModelo">
<select style="width: 200px; "   id="idModelo" name="idModelo" onchange="cargarVehiculo();" class="mi-selectorModelo" style="background-color: gainsboro; " required="true">
                
            </select>

</div>
    <div class="col-sm-6" id="divModeloInput" hidden>
    <input type="text" class="form-control input-sm"   id="modelo" name="modelo"  maxlength="45" minlength="2" >
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
<div class="col-sm-6" id="divVehiculoInput" hidden>
    <input type="text" class="form-control input-sm" id="vehiculoinput" name="vehiculoinput"  >
</div>

<div class="col-sm-4" id="divAnio">
<select style="width: 200px; "   id="idAnio" name="idAnio" onchange="mostrarPrecioInfo();"   class="mi-selectorAnioInfo" style="background-color: gainsboro; " required="true">
                
            </select>

</div> 
<div class="col-sm-6" id="divAnioInput" hidden>
    <input type="text" class="form-control input-sm" id="anio" name="anio"    maxlength="24" minlength="4" >
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
<input  disabled type="text"   class="form-control input-sm"  id="precioInforAutoD" name="precioInforAutoD" >
<input  hidden type="text"  class="form-control input-sm" id="precioInforAuto" name="precioInforAuto" >

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
    <input  type="date" class="form-control input-sm" id="fechaIngreso" name="fechaIngreso"  minlength="4" maxlength="24" value="<?php echo date("Y-m-d"); ?>">
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
     <input type="text"   class="form-control input-sm" id="precioCompra" name="precioCompra"  minlength="1" maxlength="15" pattern="[0-9]+(\.[0-9]{1,2})?%?">

</div>
<div class="col-sm-6">
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="precioVenta" name="precioVenta"  minlength="1" maxlength="24" pattern="[0-9]+(\.[0-9]{1,2})?%?">
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
 <input style="text-transform: capitalize;" type="text" class="form-control input-sm" id="observaciones" name="observaciones"   maxlength="254">


    <br>
    
      
 <input style="text-transform: capitalize;" type="text" hidden="true" value="1" class="form-control input-sm" id="bandera" name="bandera"   maxlength="95">
            

 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnAgregarNuevo" class="btn btn-primary" >Crear Nuevo</button>
      </div>

</form>
 

      </div>
      
    </div>
  </div>
</div>








<!-- Modal agregar gasto automovil -->
<div class="modal fade" id="modalGasto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Gasto Vehiculo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmGasto"  onsubmit="agregarGasto()"  action="" method="post">
    


  <?php 

  $conexionProveedores= conectar();
  mysqli_set_charset($conexionProveedores,'utf8'); 
  $sqlp= "SELECT * from proveedores order by LENGTH(descripcion) desc";

  $resultadoProveedores=mysqli_query($conexionProveedores,$sqlp);

  mysqli_close($conexionProveedores);
  
     ?>


     <label>Fecha</label>
    <input  type="date" class="form-control input-sm" id="fechaIngresoGasto" name="fechaIngresoGasto" value="<?php echo date("Y-m-d"); ?>" >

    <br>

  <div class="row">
    <div class="col-sm-2" >
        <label >Proveedor: </label>
        </div>
    <div class="col-sm-3" >
<select id="idProveedor" name="idProveedor" class="mi-selectorProveedor" style="background-color: gainsboro;">
        <?php

        while ($valoresA = mysqli_fetch_array($resultadoProveedores)) {
          ?>
          <option value="<?php print($valoresA['id']);?>"> <?php  print($valoresA['descripcion']);?> </option>

          <?php
        }
        ?>
      </select>
     

</div>
</div>

<br>

    <label>Monto <label style="color: red;">*</label></label>

    <input type="text" class="form-control input-sm" required="true" id="montoGasto" name="montoGasto"  minlength="1" maxlength="15" pattern="[0-9]+(\.[0-9]{1,2})?%?">
        

<label>Descripcion <label style="color: red;">*</label></label>
 <input style="text-transform: capitalize;" required="true" type="text" class="form-control input-sm" id="descripcionGasto" name="descripcionGasto"   maxlength="99">

<input  type="text" class="form-control input-sm" id="idGasto" name="idGasto"  hidden="true">

       
 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnEditarNuevo" class="btn btn-primary" >Agregar</button>
      </div>


</form>


      </div>
      
    </div>
  </div>
</div>





<!-- Modal editar automovil -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 700px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualizar Vehiculo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmactualizar"  onsubmit="actualizarGuardarVehiculo()"  action="" method="post">
    


	<?php 

	$conexionSucursales= conectar();
	mysqli_set_charset($conexionSucursales,'utf8'); 
	$sqlc= "SELECT * from sucursales order by LENGTH(descripcion) desc";

	$resultadoSucursales=mysqli_query($conexionSucursales,$sqlc);

	mysqli_close($conexionSucursales);
	
		 ?>


	<div class="row">
		<div class="col-sm-2" >
        <label >Sucursal: </label>
        </div>
		<div class="col-sm-4"  >
<select style="width: 200px; " id="idTipoSucursalE" name="idTipoSucursalE" class="mi-selectorSucursal" style="background-color: gainsboro;">
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


  <?php 

    $conexionEstado= conectar();
    mysqli_set_charset($conexionEstado,'utf8'); 
    $sqlc= "SELECT id,descripcion from estados_vehiculo where eliminado='0' order by LENGTH(descripcion) desc";

    $resultadoEstado=mysqli_query($conexionEstado,$sqlc);

    mysqli_close($conexionEstado);
    
         ?>   
        


         <div class="col-sm-2" >
        <label>Estado: </label>
    </div> 
    <div class="col-sm-4"  >
        <select style="width: 200px;" id="esE" name="esE" class="mi-selectorEstado" style="background-color: gainsboro;">
         <?php

                while ($valoresEstado = mysqli_fetch_array($resultadoEstado)) {
                    ?>
                    <option value="<?php print($valoresEstado['id']);?>"> <?php  print($valoresEstado['descripcion']);?> </option>

                    <?php
                }
                ?>
        </select>

    </div> 

            
            </div>

            <br>



<?php 

	$conexionLugar= conectar();
	mysqli_set_charset($conexionLugar,'utf8'); 
	$sqlc= "SELECT * from lugar_donde_se_encuentra_vehiculo order by LENGTH(descripcion) desc";

	$resultadoLugar=mysqli_query($conexionLugar,$sqlc);

	mysqli_close($conexionLugar);
	
		 ?>


	<div class="row">
		<div class="col-sm-2" >
		<label >Ubicacion: </label>
	</div>
	<div class="col-sm-4" >
<select style="width: 200px;"  id="idUbicacionE" name="idUbicacionE" class="mi-selectorUbicacion" style="background-color: gainsboro;">
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
	$sqlc= "SELECT * from origenes_vehiculo order by LENGTH(descripcion) desc";

	$resultadoOrigen=mysqli_query($conexionOrigen,$sqlc);

	mysqli_close($conexionOrigen);
	
		 ?>


		<div class="col-sm-2" >
		<label >Origen: </label>
	</div>
	<div class="col-sm-4">
<select style="width: 200px;" id="idOrigenE" name="idOrigenE"   class="mi-selectorOrigen" style="background-color: gainsboro; width: 120px;">
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


    <br>
<div class="row">
		 


<?php 

    $conexionTipoVehiculo= conectar();
    mysqli_set_charset($conexionTipoVehiculo,'utf8'); 
    $sqlc= "SELECT * from tipos_vehiculos order by LENGTH(descripcion) desc";

    $resultadoTipoVehiculo=mysqli_query($conexionTipoVehiculo,$sqlc);

    mysqli_close($conexionTipoVehiculo);
    
         ?>


    
        <div class="col-sm-2" >
        <label>Tipo Vehiculo:</label>
    </div>
    <div class="col-sm-4">
<select style="width: 200px;"  id="idTipoVehiculoE" name="idTipoVehiculoE"  class="mi-selectorTipoVehiculo" style="background-color: gainsboro; ">
                <?php

                while ($valoresTipo = mysqli_fetch_array($resultadoTipoVehiculo)) {
                    ?>
                    <option value="<?php print($valoresTipo['id']);?>"> <?php  print($valoresTipo['descripcion']);?> </option>

                    <?php
                }
                ?>
            </select>

</div>
<!-- <input style="text-transform: capitalize;" hidden type="text" class="form-control input-sm" id="idTipoVehiculoE" name="idTipoVehiculoE"  > -->


</div>


            <hr>      




            <!-- eeeeeee -->
 
            <div class="row">
    	<div class="col-sm-6">
    <label>Marca</label>
	</div>
	<div class="col-sm-6">
    <label>Modelo</label>
</div>
    </div>

<div class="row">

<div class="col-sm-6" id="divMarcaE"  >
<select style="width: 200px; "   id="idMarcaE" name="idMarcaE" onchange="cargarModelosE();" class="mi-selectorMarcaE" style="background-color: gainsboro; " required="true">
                
            </select>

</div>

<div class="col-sm-6" id="divMarcaInputE" hidden  >
    <input style="text-transform: capitalize;"   type="text" class="form-control input-sm" id="marcaE" name="marcaE"  minlength="2" maxlength="50">
</div>

<div class="col-sm-4" id="divModeloE">
<select style="width: 200px; "   id="idModeloE" name="idModeloE" onchange="cargarVehiculoE();" class="mi-selectorModeloE" style="background-color: gainsboro; " required="true">
                
            </select>

</div>
    <div class="col-sm-6" id="divModeloInputE" hidden>
    <input type="text" class="form-control input-sm"   id="modeloE" name="modeloE"  maxlength="45" minlength="2" >
</div>
     	</div>


<div class="row">
<div class="col-sm-6"  id="divLabelVehiculoE">
        <label >Vehiculo:</label>
    </div>
  
<div class="col-sm-6">
	<label>Año</label>
</div>

	</div>
     
<div class="row">
<div class="col-sm-6"  id="divVehiculoE">
<select style="width: 200px; "   id="idVehiculoInfoE" name="idVehiculoInfoE" onchange="cargarAniosE();"  class="mi-selectorVehiculoInfoE" style="background-color: gainsboro; " required="true">
                
            </select>
            
</div>

<div class="col-sm-6"  hidden>
    <input type="text" class="form-control input-sm" id="vehiculoinputE" name="vehiculoinputE" >
</div>
<div class="col-sm-4" id="divAnioE">
<select style="width: 200px; "   id="idAnioE" name="idAnioE" onchange="mostrarPrecioInfoE();"   class="mi-selectorAnioInfoE" style="background-color: gainsboro; " required="true">
                
            </select>

</div> 
<div class="col-sm-6" id="divAnioInputE" hidden>
    <input type="text" class="form-control input-sm" id="anioE" name="anioE"  maxlength="24" minlength="4" pattern="[0-9]+">
</div>

</div>





<div class="row">
<div class="col-sm-6" id="divLabelPrecioE">
	<label>Precio Info Auto</label>
</div>
<div class="col-sm-6">
	   <label>Dominio</label>
	</div>
	</div>
     
<div class="row">
<div class="col-sm-6" id="divPrecioE">
<input  disabled type="text" class="form-control input-sm" id="precioInforAutoDE" name="precioInforAutoDE">
<input  hidden type="text" class="form-control input-sm" id="precioInforAutoE" name="precioInforAutoE" >

</div>
<div class="col-sm-6">
    <input type="text" class="form-control input-sm" id="dominio_patenteE" name="dominio_patenteE"  maxlength="24" minlength="4">
</div>
</div>













<!-- aaaaaaaaaaaaaaaaaaaaaaaa -->
    
    <!-- <div class="row">
    	<div class="col-sm-6">
    <label>Marca</label>
	</div>
	<div class="col-sm-6">
    <label>Modelo</label>
</div>
    </div>

<div class="row">
    <div class="col-sm-6"> -->
    <!-- <input style="text-transform: capitalize;" disabled type="text" class="form-control input-sm" id="marcaEE" name="marcaEE"  minlength="2" maxlength="50"> -->
    <!-- <input style="text-transform: capitalize;" hidden type="text" class="form-control input-sm" id="marcaE" name="marcaE"  minlength="2" maxlength="50">
           
</div>
    <div class="col-sm-6"> -->
    <!-- <input type="text" disabled class="form-control  input-sm" id="modeloEE" name="modeloEE"  maxlength="45" minlength="2" > -->
    <!-- <input type="text"  hidden class="form-control input-sm" id="modeloE" name="modeloE"  maxlength="45" minlength="2" >
           
</div>
        </div> -->


<!-- <div class="row">
<div class="col-sm-6">
	<label>Año</label>
</div>
<div class="col-sm-6">
	   <label>Dominio</label>
	</div>
	</div>
     
<div class="row">
<div class="col-sm-6">
    <input type="text" disabled class="form-control input-sm" id="anioEE" name="anioEE"  maxlength="24" minlength="4" pattern="[0-9]+">
    <input type="text" hidden class="form-control input-sm" id="anioE" name="anioE"  maxlength="24" minlength="4" pattern="[0-9]+">
            
</div>
<div class="col-sm-6">
    <input type="text" class="form-control input-sm" id="dominio_patenteE" name="dominio_patenteE"  maxlength="24" minlength="4">
</div>
</div> -->



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
    <input type="text" class="form-control input-sm" id="kilometrosE" name="kilometrosE"  maxlength="24" minlength="1"  pattern="[0-9]+(\.[0-9]{1,2})?%?">
    </div>
<div class="col-sm-6">
    <input  type="date" class="form-control input-sm" id="fechaIngresoE" name="fechaIngresoE"  minlength="4" maxlength="24">
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
    <input type="text" class="form-control input-sm" id="precioCompraE" name="precioCompraE"  minlength="1" maxlength="15" pattern="[0-9]+(\.[0-9]{1,2})?%?">
         </div>
<div class="col-sm-6">
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="precioVentaE" name="precioVentaE"  minlength="1" maxlength="24" pattern="[0-9]+(\.[0-9]{1,2})?%?">
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
    <input type="text" class="form-control input-sm" id="colorE" name="colorE"  minlength="3" maxlength="25" pattern="^[a-zA-Z\s]+">
         </div>
<div class="col-sm-6">
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="deudasE" name="deudasE" maxlength="90">
  </div>
</div>




<label>Observaciones</label>
 <input style="text-transform: capitalize;" type="text" class="form-control input-sm" id="observacionesE" name="observacionesE"   maxlength="254">

<input  type="text" class="form-control input-sm" id="idE" name="idE"  hidden="true">

    <input  type="text" value="0" class="form-control input-sm" id="banderaEstado" name="banderaEstado"   hidden="true">

    <br>
    
             
 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnEditarNuevo" class="btn btn-primary" >Actualizar</button>
      </div>


</form>


      </div>
      
    </div>
  </div>
</div>





<!-- Modal agregar sucursal -->
<div class="modal fade" id="modalAgregarSucursal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelSucursal">Nueva Sucursal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmNuevaSucursal"  onsubmit="nuevaSucursal()"  action="" method="post">
    

    <label>Domicilio</label>
    <input style="text-transform: capitalize;" type="text" class="form-control input-sm" id="domicilioSucursal" name="domicilioSucursal" required minlength="4" maxlength="24">
    <label>Descripcion</label>
    <input style="text-transform: capitalize;" type="text" class="form-control input-sm" id="descripcionSucursal" name="descripcionSucursal" required minlength="4" maxlength="24">
    


    <div class="modal-footer">
        <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-warning" id="btnGuardar">Guardar</button>
      </div>

</form>


      </div>
      
    </div>
  </div>
</div>

		

<div class="modal fade" id="modalReporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document" id="modalD" >

    
		
	  </div> 
	</div>





    <div class="cargaaaa" id="cargaaaaid" hidden="true"></div> 

</body>
 
</html>




<script type="text/javascript">
	$(document).ready(function(){

		$('#tablaDatatable').load('tablaVehiculos.php?pme=t');
	});


</script>


<script type="text/javascript">
    function nuevoVehiculo(){



        e = document.getElementById('idAnio');


            res=e.options[e.selectedIndex].value;
        arrS=res.split('--');



        if(arrS[0]=='00'){


            alertify.warning("Seleccione un año");

            return false;
        }






else{

        datos=$('#frmnuevo').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"procesos/agregarVehiculo.php",
            success:function(){
                    
                    $('#tablaDatatable').load('tablaVehiculos.php?pme=t');
                    alertify.success("Se agrego correctamente");
                    
            },
            error:function(){

                alertify.success("No se pudo agregar correctamente");
                
            }


        });


return true;
}
    }


</script>



<script type="text/javascript">
    

function actualizarGuardarVehiculo(){
        datos=$('#frmactualizar').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"procesos/actualizarVehiculo.php",
            success:function(){
                
                    $('#tablaDatatable').load('tablaVehiculos.php?pme=t');
                    alertify.success("Se actualizo correctamente");            

            },
            error:function(){

                alertify.success("No se pudo actualizar correctamente");
                
            }

        });

    }
</script>

<script type="text/javascript">
    

function agregarGasto(){
        datos=$('#frmGasto').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"procesos/agregarGasto.php",
            success:function(){
                
                    $('#tablaDatatable').load('tablaVehiculos.php?pme=t');
                    alertify.success("Se actualizo correctamente");
                    

            },
            error:function(){

                alertify.success("No se pudo actualizar correctamente");
                
            }

        });

    }
</script>

<script type="text/javascript">
    
   





function actualizarPreciosTodos(){

   
      document.getElementById('modalActualizarPrecio').hidden=true;
       document.getElementById('cargaaaaid').hidden=false;  
//     var cargando = $("#cargaaaa");
//     $(document).ajaxStart(function() {
//      cargando.show();
//    });




        datos=$('#frmActualizarPrecio').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"oauth-infoauto/actualizarPreciosVenta.php",
            success:function(){


                alertify.success("Se actualizo correctamente");
                
                    // $('#tablaDatatable').load('tablaVehiculos.php?pme=t');
                   
                    document.getElementById('cargaaaaid').hidden=true; 

            },
            error:function(){

                alertify.success("No se pudo actualizar correctamente");
                
            }

        });


         
//        $(document).ajaxStop(function() {
//     cargando.hide();
//    });



    }
</script>





<script type="text/javascript">

$('#btnAgregarUsuarioNuevo').click(function(){
datos=$('#frmnuevo').serialize();

            $('#usuario').val('');
            $('#pw').val('');
            $('#nombre').val('');
            $('#apellido').val('');
            $('#correo').val('');

});



function actualizarVehiculo(id){
    $.ajax({
        type:"POST",
        data:"id=" + id,
        url:"procesos/obtenerDatosVehiculo.php",
        success:function(r){
            datos=jQuery.parseJSON(r);

                if(datos['id_tipo_vehiculo']=='4'){ // aca entra si es monopatin
                    
                    document.getElementById('divMarcaE').hidden=true;
                    document.getElementById('divMarcaInputE').hidden=false;
                    document.getElementById('divModeloE').hidden=true;
                    document.getElementById('divModeloInputE').hidden=false;
                    document.getElementById('divAnioE').hidden=true;
                    document.getElementById('divAnioInputE').hidden=false;
                    document.getElementById('divLabelVehiculoE').hidden=true;
                    document.getElementById('divVehiculoE').hidden=true;
                    document.getElementById('divLabelPrecioE').hidden=true;
                    document.getElementById('divPrecioE').hidden=true;

                    document.getElementById('idTipoVehiculoE').disabled=true;    
                    document.getElementById('idMarcaE').disabled=true;    
                    document.getElementById('idModeloE').disabled=true;
                    document.getElementById('idVehiculoInfoE').disabled=true;
                    document.getElementById('idAnioE').disabled=true;


                    
                }
                else{
                    

                    var sel = document.getElementById('idTipoVehiculoE');
                        sel.remove(2);
                        // document.getElementById('idTipoVehiculoEE').disabled=false;

                        cargarMarcasE(datos['info_marca']);
                 cargarModelosE(datos['info_modelo'],datos['info_marca']);
                 cargarVehiculoE(datos['info_vehiculo'],datos['info_modelo']);
                 cargarAniosE(datos['info_anio'],datos['info_vehiculo']);
                  
                document.getElementById('precioInforAutoE').value=datos['info_precio'];
                document.getElementById('precioInforAutoDE').value=datos['info_precio'];

                document.getElementById('vehiculoinputE').value=datos['nombre_info'];
                }

               

            $('#marcaE').val(datos['marca']);
            // $('#marcaEE').val(datos['marca']);
            $('#modeloE').val(datos['modelo']);
            // $('#modeloEE').val(datos['modelo']);
            $('#anioE').val(datos['anio']);
            // $('#anioEE').val(datos['anio']);
            $('#kilometrosE').val(datos['kilometros']);
            $('#dominio_patenteE').val(datos['dominio_patente']);
            $('#fechaIngresoE').val(datos['fecha_ingreso']);
            $('#precioCompraE').val(datos['precio_compra']);
            $('#precioVentaE').val(datos['precio_venta']);
            $('#colorE').val(datos['color']);
            $('#deudasE').val(datos['deudas']);
            $('#observacionesE').val(datos['observaciones']);
            // $('#idTipoSucursalE').val(datos['id_sucursal']);
            $('#idTipoSucursalE').select2("val", datos['id_sucursal']);
            // $('#idTipoVehiculoE').val(datos['id_tipo_vehiculo']);
             $('#idTipoVehiculoE').select2("val", datos['id_tipo_vehiculo']);
            //  $('#idTipoVehiculoE').val(datos['id_tipo_vehiculo']);
            // $('#idUbicacionE').val(datos['id_lugar_donde_se_encuentra']);
              $('#idUbicacionE').select2("val", datos['id_lugar_donde_se_encuentra']);
            // $('#idOrigenE').val(datos['id_origen']);
            $('#idOrigenE').select2("val", datos['id_origen']);

            
             // $('#mi-selectorOrigen').val(datos['id_origen']);
              $('#mi-selectorOrigen').select2("val", datos['mi-id_origen']);

            // $('#esE').val(datos['id_estado']);
            $('#esE').select2("val", datos['id_estado']);

            $('#idE').val(datos['id']);
                  if(datos['id_estado'] =='2' || datos['id_estado']=='3')
                 { $('#banderaEstado').val('1');}
           
                 

               
                


        }
    });
}


function cargarInforme(id){

    $.ajax({
        type:"POST",
        data:"id=" + id,
        url:"insertarGastosReporte.php",
        success:function(r){
            $('#modalReporte').html(r);
            

        }
    });
}





function eliminarDatosVehiculo(id){
    alertify.confirm('Eliminar Vehiculo', '¿Esta seguro que desea eliminar el vehiculo?',
        function(){ 
                $.ajax({
        type:"POST",
        data:"id=" + id,
        url:"procesos/eliminarVehiculo.php",
        success:function(r){
            
                $('#tablaDatatable').load('tablaVehiculos.php?pme=t');
                alertify.success("Eliminado con exito");
            
                
        },
        error: function(){

            alertify.error("No se pudo eliminar");
            

        }
    });

        }
        , function(){ });

}


function agregarGastoVehiculo(id){
  
  document.getElementById('idGasto').value=id;

}

</script>



<script type="text/javascript">

//bloqueo para volver hacia atras post logout

    if(history.forward(1)){
        history.replace(history.forward(1));
    }
</script>



<script type="text/javascript">
    function nuevaSucursal(){

        datos=$('#frmNuevaSucursal').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"procesos/agregarSucursal.php",
            success:function(){
                    
                   
                    alertify.success("Se agrego correctamente");
                    

            },
            error:function(){

                alertify.success("No se pudo agregar correctamente");
                
            }

        });

    }
</script>

<script type="text/javascript">
    
function redirPreVenta(){

window.location.href='preVenta.php?datos33='+ btoa(0);
              
}

</script>

<script type="text/javascript">

    jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorVehiculos').select2();
    });


});
</script>



<script type="text/javascript">
    

$(document).ready(function(){
    $("select[name=filSelect]").change(function(){
           
        var load='tablaVehiculos.php?pme='+ $('select[name=filSelect]').val();

        $('#tablaDatatable').load(load);
            
        });
   
});

</script>


<script type="text/javascript">

    jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorSucursal').select2();
    });
});

     jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorProveedor').select2();
    });
});

  
        jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorTipoVehiculo').select2();
    });
});

    jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorUbicacion').select2();
    });
});

        jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorOrigen').select2();
    });
});

    jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorEstado').select2();
    });
});

jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorMarca').select2();
    });
});

jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorMarcaE').select2();
    });
});

jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorModelo').select2();
    });
});
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorModeloE').select2();
    });
});
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorVehiculoInfo').select2();
    });
});

jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorVehiculoInfoE').select2();
    });
});
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorAnioInfo').select2();
    });
});
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorAnioInfoE').select2();
    });
});



</script>

<script type="text/javascript">
                $(document).ready(function() {
                   
                   $('#NombreLoguin').text('<?php echo $mostrarloguin['nombre'].' '.$mostrarloguin['apellido'];?>');
                   cargarMarcas();
                });
</script>


<script>

if('<?php echo $_SESSION["permisos"];?>'=='2' || '<?php echo $_SESSION["permisos"];?>'=='3' ){
    document.getElementById('linkUsuarios').hidden=true;
    linkIndex.removeAttribute('href');
    document.getElementById('linkActualizarPrecios').hidden=true;
   


}
if('<?php echo $_SESSION["permisos"];?>'=='3' ){ // esto es si es un vendedor
    document.getElementById('linkMovimientos').hidden=true;
    document.getElementById('linkOtros').hidden=true;
    document.getElementById('linkActualizarPrecios').hidden=true;
    document.getElementById('linkBuscarPreciosTodos').hidden=false;

    document.getElementById('linkVentasExistentes').hidden=true;



   
    filSelect.remove(3);
    filSelect.remove(3);
    filSelect.remove(3);
   
}
if('<?php echo $_SESSION["permisos"];?>'=='4'){
    document.getElementById('linkUsuarios').hidden=true;
    linkIndex.removeAttribute('href');
    document.getElementById('linkClientes').hidden=true;
    document.getElementById('linkVentas').hidden=true;
    document.getElementById('linkMovimientos').hidden=true;
    document.getElementById('linkOtros').hidden=true;
    document.getElementById('operaciones').hidden=true;
    document.getElementById('btnNuevoProductor').hidden=true;
    document.getElementById('linkActualizarPrecios').hidden=true;
    document.getElementById('linkBuscarPreciosTodos').hidden=true;
    
    
    // filSelect.remove(0);
     filSelect.remove(3);
     filSelect.remove(4);
     filSelect.remove(3);
    // filSelect.remove(2);
    
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
     ajax.send("&nombre="+"0");

}




function cargarModelos(){

    marca = document.getElementById('idMarca').value;
    console.log('Marca->'+marca);
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
console.log('Modelo->'+modelo);
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
console.log('Vehiculo->'+vehi);
 
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

   console.log('Año->'+arrS[0]);
   

    document.getElementById('precioInforAuto').value=arrS[1]*1000;
    document.getElementById('precioInforAutoD').value=arrS[1]*1000;


    // obtengo el elemento marca y lo seteo en el input para la bd
    mar = document.getElementById('idMarca');
    resM=mar.options[mar.selectedIndex].text;

    document.getElementById('marca').value=resM;

    // obtengo el modelo para setear en la bd q esta compuesto  por marca y vehiculo


    mode = document.getElementById('idModelo');
    resMod=mode.options[mode.selectedIndex].text;
    document.getElementById('modelo').value=resMod;

    vehi = document.getElementById('idVehiculoInfo');
    resVehi=vehi.options[vehi.selectedIndex].text;

    document.getElementById('vehiculoinput').value=resVehi;


    // hago lo mismo para añoooo

    anioo = document.getElementById('idAnio');
    resA=anioo.options[anioo.selectedIndex].text;

    document.getElementById('anio').value=parseInt(resA, 10);
   


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
document.getElementById('vehiculoinput').value='Monopatin';
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
//Cargar datos infoauto para los editar

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

	function cargarMarcasE(id){

        

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


        $('#idMarcaE').html(ajax.responseText);
        // if(ajax.responseText.length<67) document.formularioCorredores.btnNuevoCorredor.disabled=false;


    }
   
}

    //Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

    //enviamos las variables a 'consulta.php'
     ajax.send("&nombre="+id);

     

}




function cargarModelosE(id,marcaIni){

     marcaSe = document.getElementById('idMarcaE').value;
   
    if(marcaSe!=''){
        marca=marcaSe;
    }
    else{
        marca=marcaIni;
    }
    $('#idVehiculoInfoE').html('');
    $('#idAnioE').html('');


    
//instanciamos el objetoAjax
ajaxModelo = objetoAjax();


//Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
ajaxModelo.open("POST", "procesos/obtenerModeloInfo.php", true);

//cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
ajaxModelo.onreadystatechange = function() {


     //Cuando se completa la petición, mostrará los resultados
     if (ajaxModelo.readyState == 4){

//El método responseText() contiene el texto de nuestro 'consultar.php'. Por ejemplo, cualquier texto que mostremos por un 'echo


$('#idModeloE').html(ajaxModelo.responseText);
// if(ajax.responseText.length<67) document.formularioCorredores.btnNuevoCorredor.disabled=false;


}

}

//Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
ajaxModelo.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

//enviamos las variables a 'consulta.php'
ajaxModelo.send("&idMarca="+marca+"&id="+id);

}






function cargarVehiculoE(id,modeloIni){

modeloSe = document.getElementById('idModeloE').value;
$('#idAnioE').html('');

if(modeloSe!=''){
        modelo=modeloSe;
    }
    else{
        modelo=modeloIni;
    }

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


$('#idVehiculoInfoE').html(ajaxVehiculo.responseText);
// if(ajax.responseText.length<67) document.formularioCorredores.btnNuevoCorredor.disabled=false;


}

}

//Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
ajaxVehiculo.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

//enviamos las variables a 'consulta.php'
ajaxVehiculo.send("&idModelo="+modelo+"&id="+id);

}





/// cargo los años con sus respectivos precios

function cargarAniosE(id,vehiIni){

vehiSe = document.getElementById('idVehiculoInfoE').value;

if(vehiSe!=''){
    vehi=vehiSe;
    }
    else{
        vehi=vehiIni;
    }



 
//instanciamos el objetoAjax
ajaxAnio = objetoAjax();


//Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
ajaxAnio.open("POST", "oauth-infoauto/obtenerPrecioInfo.php", true);

//cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
ajaxAnio.onreadystatechange = function() {


 //Cuando se completa la petición, mostrará los resultados
 if (ajaxAnio.readyState == 4){

//El método responseText() contiene el texto de nuestro 'consultar.php'. Por ejemplo, cualquier texto que mostremos por un 'echo


$('#idAnioE').html(ajaxAnio.responseText);
// if(ajax.responseText.length<67) document.formularioCorredores.btnNuevoCorredor.disabled=false;


}

}

//Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
ajaxAnio.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

//enviamos las variables a 'consulta.php'
ajaxAnio.send("&vehiculo="+vehi+"&id="+id);

}



function mostrarPrecioInfoE(){
    // obtengo el elemento de anio y seteo los precios
   e = document.getElementById('idAnioE');
  
   res=e.options[e.selectedIndex].value;

 
    arrS=res.split('--');

  
    document.getElementById('precioInforAutoE').value=arrS[1]*1000;
    document.getElementById('precioInforAutoDE').value=arrS[1]*1000;

    

    // obtengo el elemento marca y lo seteo en el input para la bd
     mar = document.getElementById('idMarcaE');
     
     resM=mar.options[mar.selectedIndex].text;
     console.log(resM);
     document.getElementById('marcaE').value=resM;

    // obtengo el modelo para setear en la bd q esta compuesto  por marca y vehiculo


     mode = document.getElementById('idModeloE');
     resMod=mode.options[mode.selectedIndex].text;
     console.log(resMod);
     document.getElementById('modeloE').value=resMod;


     vehi = document.getElementById('idVehiculoInfoE');
     resVehi=vehi.options[vehi.selectedIndex].text;


    document.getElementById('vehiculoinputE').value=resVehi;


    // hago lo mismo para añoooo

     anioo = document.getElementById('idAnioE');
     resA=anioo.options[anioo.selectedIndex].text;

     document.getElementById('anioE').value=parseInt(resA, 10);



}

</script>
<script>

    function setIDTipoVeh(){

        ee = document.getElementById('idTipoVehiculoEE');
        console.log(ee);
        ress=ee.options[ee.selectedIndex];
        console.log(ress);
        document.getElementById('idTipoVehiculoE').value=ress;
       

    }
</script>

