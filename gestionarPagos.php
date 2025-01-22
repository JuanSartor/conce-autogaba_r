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
                           <!--   <li class="nav-item">
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
                              <a class="nav-link" href="consumos.php"  aria-expanded="false" id="linkMovimientos" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-money-bill-wave"></i>Movimientos Varios</a>

                                                       
                            </li>
                                     <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-calculator"></i> Ventas </a>
                                <div id="submenu-6" class="collapse submenu show" >
                                    <ul class="nav flex-column">
                                          <li class="nav-item ">
                                  <a class="nav-link" onclick="redirPreVenta();"  aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fab fa-wpforms"></i>Nueva Pre-Venta</a>
                                
                            </li>



                            <li class="nav-item">
                                <a class="nav-link active" href="#"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-dollar-sign"></i>Ventas Existentes</a>

                                                       
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="aprobarPreVentas.php"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-registered"></i>Aprobar Pre-Ventas</a>

                                
                            </li>
                           <!--  <li class="nav-item">
                                <a class="nav-link" href="pagos.php"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-cash-register"></i>Lista Pagos Realizados</a>

                                                       
                            </li> -->
                                                                                
                                    </ul>
                                </div>
                            </li>
                            
                          <!--   <li class="nav-item">
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
                                <a class="nav-link" href="#" data-toggle="collapse" id="linkOtros" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-columns"></i>Otros</a>
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
                                       <!--  <li class="nav-item">
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
                         GESTOR VENTAS

               <!--           <div style="width: 20px" >
                <button type="button"  class="btn btn-primary mb-1" id="btnNuevoProductor" data-toggle="modal" data-target ="#agregarnuevosdatosmodal"  style="width: 50px"> <span class="fas fa-plus-circle"></span> </button>
            </div> -->
                            
            <div class="row">
            <div class="col-sm-8" > </div>
               <div class="col-sm-1" > 
               <label for="cars">Filtrar:</label>
           </div>
            <div class="col-sm-1" > 
               <select id="filSelect" name="filSelect" class="mi-selectorVehiculos">
                  <option  value="t" onclick="listarTodos()">No Concretadas</option>
                  <option  value="a" onclick="listarAIngresar()">Concretadas</option>
                 
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









                    
                    
            
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
         <!--    <div class="footer">
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
   <!--  <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script> -->
    <!-- bootstap bundle js -->
     <!-- <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>  -->
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






<!-- Modal agregar -->
<div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevo" onsubmit="nuevoUsuario()"  action="" method="post">
    <label>Usuario</label>
    <input type="text" class="form-control input-sm" id="usuario" name="usuario" required minlength="4" maxlength="19">
    <label>Contraseña</label>
    <input type="text" class="form-control input-sm" id="pw" name="pw" required minlength="4" maxlength="15">
    <label>Nombre</label>
    <input style="text-transform: capitalize;" type="text"  class="form-control input-sm" id="nombre" name="nombre" required minlength="4" maxlength="59" pattern="^[a-zA-Z\s]+">
    <label>Apellido</label>
    <input style="text-transform: capitalize;" type="text" class="form-control input-sm" id="apellido" name="apellido" required minlength="4" maxlength="39" pattern="^[a-zA-Z\s]+">
    <label>Email</label>
    <input type="email" class="form-control input-sm" id="correo" name="correo" required maxlength="59" minlength="4">
     <label>DNI</label>
    <input type="text" class="form-control input-sm" id="dni" name="dni" required maxlength="24" minlength="4" pattern="[0-9]+">
     <label>Telefono</label>
    <input type="text" class="form-control input-sm" id="telefono" name="telefono" required maxlength="29" minlength="4" pattern="[0-9]+">
    <br>
    
         <p>Seleccione el permiso para su usuario:</p>

         <div class="row">
            <div class="col-sm">
                <input type="radio" name="permisos"   value="Admin">Administrador Sistema</div>
                <div class="col-sm"> <input type="radio" name="permisos" checked  value="Administrativo">Administrativo</div>
            </div>
                 <div class="row">
            <div class="col-sm">
                <input type="radio" name="permisos"  value="Vendedor">Vendedor</div>
                <div class="col-sm"> <input type="radio" name="permisos"  value="Normal">Normal</div>
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




<!-- Modal pago -->
<div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cobros</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmPagos"  onsubmit="realizarPago()"  action="" method="post">

<div class="row">
        <div class="col-sm-2">
    <label style="font-size: 14px; font-weight: bold;">Vehiculo</label>
</div>

</div>
<hr>
<div class="row">
    <div class="col-sm-2"> 
       <label style="font-size: 13px">Marca</label>
</div> 
<div class="col-sm-4"> 
    <input style="height: 25px" type="text" class="form-control input-sm" id="marcaU" name="marcaU"   disabled="true"> 
</div>
 <div class="col-sm-2"> 
    <label style="font-size: 13px">Modelo</label>
</div>
 <div class="col-sm-4"> 
    <input style="height: 25px" type="text" class="form-control input-sm" id="modeloU" name="modeloU"   disabled="true">
    </div> 
</div>
 
 <div class="row">
    <div class="col-sm-2"> 
    <label style="font-size: 13px">Color</label>
</div>
<div class="col-sm-4"> 
    <input style="height: 25px" type="text" class="form-control input-sm" id="colorU" name="colorU"    disabled="true"> 
    </div>
    <div class="col-sm-2"> 
    <label style="font-size: 13px">Dominio</label>
</div>
<div class="col-sm-4"> 
    <input style="height: 25px" type="text" class="form-control input-sm" id="patenteU" name="patenteU"  disabled="true"> </div>
</div>


<hr>
<div class="row">
        <div class="col-sm-2">
    <label style="font-size: 14px; font-weight: bold;">Cliente</label>
</div>

</div>
 <div class="row">
    <div class="col-sm-2">
    <label style="font-size: 13px">Nombre</label>
</div>
<div class="col-sm-4">
    <input style="height: 25px; " type="text" class="form-control input-sm" id="nombreU" name="nombreU"    disabled="true"> </div>
    <div class="col-sm-2">
    <label style="font-size: 13px">Apellido</label>
</div>
<div class="col-sm-4">
    <input style="height: 25px; " type="text" class="form-control input-sm" id="apellidoU" name="apellidoU"  disabled="true"> 
</div>

</div>

<div class="row">
    <div class="col-sm-2">
    <label style="font-size: 13px; ">Razon/DNI</label>
</div>
  <div class="col-sm-4">
    <input style="height: 25px" type="text" class="form-control input-sm" id="razonU" name="razonU"  disabled="true"> 
</div>
 
</div>

<br>


<div class="row">
 <div class="col-sm-2">
    <label style="font-size: 14px; font-weight: bold;">Saldo</label>
</div>
  <div class="col-sm-4">
    <input style="height: 25px" type="text" class="form-control input-sm" id="saldoU" name="saldoU"  disabled="true"> 
</div>
</div>

<hr>

<div class="row" >
<div class="col-sm-4">
      <label style="font-size: 14px">Tipo Ingreso</label>
    </div>
    <div class="col-sm-1" >
     <select style="width: 200px; "  id="tipoIngresoS" onchange="activarInputs()"   name="tipoIngresoS" class="mi-selectorTipoIngreso"   required="true">
				<?php
                $conexionSucursales= conectar();
                mysqli_set_charset($conexionSucursales,'utf8'); 
                $sqlc= "SELECT * from tipo_ingreso order by LENGTH(descripcion) desc";
            
                $resultadoSucursales=mysqli_query($conexionSucursales,$sqlc);
            
                mysqli_close($conexionSucursales);
				while ($valoresA = mysqli_fetch_array($resultadoSucursales)) {
					?>
					<option    value="<?php print($valoresA['id']);?>"> <?php  print($valoresA['descripcion']);?> </option>

					<?php
				}
				?>
            </select>
     </div>
     </div>
     <br>



<div class="row">
<div class="col-sm-4">
    <label style="font-size: 14px;">Monto</label>
        </div>
        <div class="col-sm-3">
    <input style="text-transform: capitalize; height: 25px"  type="text"  class="form-control input-sm" id="monto" name="monto"  minlength="1" maxlength="24" pattern="[0-9]+(\.[0-9]{1,2})?%?">
  </div>
	
</div>
<br>


<div class="row">
<div class="col-sm-4">
    <label style="font-size: 14px;">Numero Cheque</label>
       </div>
       <div class="col-sm-3">
    <input type="text" style="height: 25px" class="form-control input-sm" disabled id="numeroChequeP" name="numeroChequeP"  minlength="1" maxlength="69">
         </div>
</div>
<br>
         <div class="row">
        <div class="col-sm-4">
    <label style="font-size: 14px;">Fecha de Cobro</label>
        </div>

	
  <div class="col-sm-5  ">
    <input style="text-transform: capitalize; height: 25px"  type="date" disabled class="form-control input-sm" id="fechaCobroChequeP" name="fechaCobroChequeP"  minlength="1" maxlength="24" value="<?php echo date("Y-m-d"); ?>">
  </div>
</div>
<br>
<?php 

$conexionEntidadPrendaria= conectar();
mysqli_set_charset($conexionEntidadPrendaria,'utf8'); 
$sqlc= "SELECT * from entidades_prendarias where eliminado='NO'";

$resultadoEntidad=mysqli_query($conexionEntidadPrendaria,$sqlc);

mysqli_close($conexionEntidadPrendaria);

     ?>


<div class="row" >
<div class="col-sm-4">
    <label style="font-size: 14px;">Entidad:</label>
</div>
<div class="col-sm-2" >
<select id="idEntidadChequeP" name="idEntidadChequeP" disabled class="mi-selectorEntidades"  style="background-color: gainsboro; " required="true">
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
    
    
    <label style="font-size: 14px;">Descripcion <label style="color: red;">*</label></label>
    <div class="col-sm-6">
     <textarea style="width: 460px; height: 70px;"  id="descripcion" name="descripcion" required  maxlength="249"> </textarea></div>
     

  


        <label style="font-size: 14px;">Fecha</label>    
        <input style="height: 30px" type="date" class="form-control input-sm" id="fechaCargaCobro" name="fechaCargaCobro" value="<?php echo date("Y-m-d"); ?>">
    

    <input  type="text"  class="form-control input-sm" id="idOrden" name="idOrden" hidden="true" >


    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-warning" id="btnGuardar">Pagar</button>
      </div>

</form>


      </div>
      
    </div>
  </div>
</div>




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
 
</html>




<script type="text/javascript">
    $(document).ready(function(){

        $('#tablaDatatable').load('tablaOrdenesPreVenta.php?pme=t');
    });


</script>



<script type="text/javascript">
    function nuevoUsuario(){


        datos=$('#frmnuevo').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"procesos/agregarUsuario.php",
            success:function(){
                    
                    $('#tablaDatatable').load('tablaUsuarios.php');
                    alertify.success("Se agrego correctamente");
                    

            },
            error:function(){

                alertify.success("No se pudo agregar correctamente");
                
            }


        });

    }


</script>



<script type="text/javascript">
    

function realizarPago(){
        datos=$('#frmPagos').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"procesos/guardarPagos.php",
            success:function(){
                
                    $('#tablaDatatable').load('tablaOrdenesPreVenta.php?pme=t');
                    alertify.success("Se realizo el pago correctamente");
                    

            },
            error:function(){

                alertify.success("No se pudo realizar correctamente");
                
            }

        });

    }



    function setearDatosOrdeenDePreventa(id){
         $.ajax({
        type:"POST",
        data:"id=" + id,
        url:"procesos/obtenerDatosCobro.php",
        success:function(r){
            datos=jQuery.parseJSON(r);

            $('#idOrden').val(datos['id']);
            $('#marcaU').val(datos['marca']);
             $('#modeloU').val(datos['modelo']);
              $('#colorU').val(datos['color']);
               $('#patenteU').val(datos['patente']);
                $('#nombreU').val(datos['nombre']);
                 $('#apellidoU').val(datos['apellido']);
                  $('#saldoU').val(datos['saldo']);

                  if( datos['dni']=='0' ){
                    $('#razonU').val(datos['razonSocial']);
                  }
                    else{  $('#razonU').val(datos['dni']);}



                   
                  
            
            
        }
    });


  
    
}
 


function eliminarOrdenPreventa(id,p){
  
    alertify.confirm('Eliminar PreVenta', '¿Esta seguro que desea eliminar la orden?                    ¡Se eliminaran todos los pagos realizados previamente!',
        function(){ 
                $.ajax({
        type:"POST",
        data:"id=" + id,
        url:"procesos/eliminarPreVenta.php",
        success:function(r){
            
            if(p=='nc'){
                $('#tablaDatatable').load('tablaOrdenesPreVenta.php?pme=t');}
                else{$('#tablaDatatable').load('tablaOrdenesPreVenta.php?pme=a');}
             
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


<script type="text/javascript">

$('#btnAgregarUsuarioNuevo').click(function(){
datos=$('#frmnuevo').serialize();

            $('#usuario').val('');
            $('#pw').val('');
            $('#nombre').val('');
            $('#apellido').val('');
            $('#correo').val('');

});



function editarOrdenPreVenta(id){
  window.location.href='preVenta.php?datos='+btoa(id) +'&datos33='+btoa(1);

}



function eliminarDatos(id){
    alertify.confirm('Eliminar Usuario', '¿Esta seguro que desea eliminar el usuario?',
        function(){ 
                $.ajax({
        type:"POST",
        data:"id=" + id,
        url:"procesos/eliminarUsuario.php",
        success:function(r){
            
                $('#tablaDatatable').load('tablaUsuarios.php');
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



<!-- <script type="text/javascript">

//bloqueo para volver hacia atras post logout

    if(history.forward(1)){
        history.replace(history.forward(1));
    }
</script> -->


<script type="text/javascript">
	
function redirPreVenta(){


window.location.href='preVenta.php?datos33='+ btoa(0);

				 
}

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
 
                });
</script>

<script>

if('<?php echo $_SESSION["permisos"];?>'=='2' || '<?php echo $_SESSION["permisos"];?>'=='3' ){
    document.getElementById('linkUsuarios').hidden=true;
    linkIndex.removeAttribute('href');



}
if('<?php echo $_SESSION["permisos"];?>'=='3' ){ // esto es si es un vendedor
    document.getElementById('linkMovimientos').hidden=true;
    document.getElementById('linkOtros').hidden=true;


}


</script>
<script type="text/javascript">

    jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorTipoIngreso').select2();
    });

    $(document).ready(function() {
        $('.mi-selectorEntidades').select2();
    });

});
</script>
<script>
function activarInputs(){

    if(document.getElementById('tipoIngresoS').value !='2'){
        document.getElementById('idEntidadChequeP').disabled=true;
        document.getElementById('numeroChequeP').disabled=true;
        document.getElementById('fechaCobroChequeP').disabled=true;

        
    }
    else{
        document.getElementById('idEntidadChequeP').disabled=false;
        document.getElementById('numeroChequeP').disabled=false;
        document.getElementById('fechaCobroChequeP').disabled=false;

    }

    


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
           
        var load='tablaOrdenesPreVenta.php?pme='+ $('select[name=filSelect]').val();

        $('#tablaDatatable').load(load);
            
        });
   
});

</script>