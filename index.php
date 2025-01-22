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



    $mostrarloguin=mysqli_fetch_array($resultadologuin);



    $sqlAutosStock= "SELECT COUNT(*) FROM vehiculos WHERE id_estado IN (1,2) and eliminado='NO'";

     $resultadoAutosStock=mysqli_query($conexionLogueado,$sqlAutosStock);
 $mostrarAutosStock=mysqli_fetch_array($resultadoAutosStock);



//cheques de preventa
//  $sqlChequesProximosAvencer="SELECT c.id,c.numero_cheque,c.monto,c.fecha_cobro,o.id_real_preventa,o.edicion ,v.dominio_patente, e.descripcion
//  FROM cheques c,link_cheques_entregados_preventa l,operacion_preventa o, vehiculos v, entidades_prendarias e 
//  WHERE c.id_entidad=e.id and c.eliminado='NO' and usado='SI' /*and fecha_cobro >= CURDATE() + INTERVAL 5 DAY */
//  and c.id=l.id_cheque and l.id_real_preventa=o.id_real_preventa and l.edicion=o.edicion and v.id=o.id_vehiculo_prevendido";
//  $resultadoChequesAvencer=mysqli_query($conexionLogueado,$sqlChequesProximosAvencer);

$sqlChequesProximosAvencer="SELECT c.id,c.numero_cheque,c.monto,c.fecha_cobro,o.id_real_preventa,o.edicion ,v.dominio_patente,
 e.descripcion, c.estado
FROM cheques c,link_cheques_entregados_preventa l,operacion_preventa o, vehiculos v, entidades_prendarias e 
   WHERE c.id_entidad=e.id and c.eliminado='NO' and (c.estado='0' or c.estado='1') /*and fecha_cobro >= CURDATE() + INTERVAL 5 DAY */
  and c.id=l.id_cheque and l.id_real_preventa=o.id_real_preventa and l.edicion=o.edicion and v.id=o.id_vehiculo_prevendido";
  $resultadoChequesAvencer=mysqli_query($conexionLogueado,$sqlChequesProximosAvencer);







 
 //cheques usados como pago
//  $sqlChequesProximosAvencerPago="SELECT c.id,c.numero_cheque,c.monto,c.fecha_cobro,o.id_real_preventa,o.edicion ,v.dominio_patente, e.descripcion
//  FROM cheques c,link_cheques_como_pagos l,operacion_preventa o, vehiculos v, pagos_preventa p, entidades_prendarias e
//  WHERE c.id_entidad=e.id and c.eliminado='NO' and usado='SI' /*and fecha_cobro >= CURDATE() + INTERVAL 5 DAY */
//  and c.id=l.id_cheque and l.id_pago=p.id and p.id_orden_preventa=o.id and v.id=o.id_vehiculo_prevendido";
//  $resultadoChequesAvencerPago=mysqli_query($conexionLogueado,$sqlChequesProximosAvencerPago);
$sqlChequesProximosAvencerPago="SELECT c.id,c.numero_cheque,c.monto,c.fecha_cobro,o.id_real_preventa,o.edicion ,v.dominio_patente, e.descripcion
, c.estado FROM cheques c,link_cheques_como_pagos l,operacion_preventa o, vehiculos v, pagos_preventa p, entidades_prendarias e
WHERE c.id_entidad=e.id and c.eliminado='NO' and (c.estado='0' or c.estado='1') /*and fecha_cobro >= CURDATE() + INTERVAL 5 DAY */
and c.id=l.id_cheque and l.id_pago=p.id and p.id_orden_preventa=o.id and v.id=o.id_vehiculo_prevendido";
$resultadoChequesAvencerPago=mysqli_query($conexionLogueado,$sqlChequesProximosAvencerPago);



// obtengo los prendarios a confirmar
$sqlPrenAc="SELECT c.id,c.monto_prendario,c.monto_sellado,e.descripcion  
from creditos_prendarios c, entidades_prendarias e where
e.id=c.id_entidad and c.estado='0'";

$resultadoCrePrendAc=mysqli_query($conexionLogueado,$sqlPrenAc);


// obtengo los personales a confirmar
$sqlPernAc="SELECT c.id,c.monto,e.descripcion  
from creditos_personal c, entidades_prendarias e where
e.id=c.id_entidad and c.estado='0'";

$resultadoCrePerndAc=mysqli_query($conexionLogueado,$sqlPernAc);









 $sqlAutosVendidos="SELECT COUNT(*) from vehiculos where id_estado= 4";
  $resultadoAutosVendidos=mysqli_query($conexionLogueado,$sqlAutosVendidos);
 $mostrarAutosVendidos=mysqli_fetch_array($resultadoAutosVendidos);


$sqlAutosReservados="SELECT COUNT(*) from vehiculos where id_estado= 3 and eliminado='NO'";
  $resultadoAutosReservdos=mysqli_query($conexionLogueado,$sqlAutosReservados);
 $mostrarAutosReservados=mysqli_fetch_array($resultadoAutosReservdos);

//$sqlSaldoEmpresa="SELECT SUM(saldo_final_preventa) FROM operacion_preventa where eliminado='0'";
$sqlSaldoEmpresa="SELECT sum(op.saldo_final_preventa) FROM operacion_preventa op, vehiculos v 
where v.id_estado=3 and op.id_vehiculo_prevendido=v.id and op.id in (SELECT max(op1.id) 
FROM `operacion_preventa` op1 group by op1.id_real_preventa having SUM(op1.eliminado)=0)";
  $resultadoSaldoEmpresa=mysqli_query($conexionLogueado,$sqlSaldoEmpresa);
 $mostrarSaldoEmpresa=mysqli_fetch_array($resultadoSaldoEmpresa);



$sqlCapitalStock="SELECT SUM(precio_venta) FROM vehiculos where id_estado in (1,2)  and eliminado='NO'";
  $resultadoCapStock=mysqli_query($conexionLogueado,$sqlCapitalStock);
 $mostrarCapitalStock=mysqli_fetch_array($resultadoCapStock);



$sqlCapitalVendido="SELECT SUM(v.precio_venta) FROM vehiculos v 
WHERE v.id_estado=4 and v.eliminado='NO'";
  $resultadoCapVend=mysqli_query($conexionLogueado,$sqlCapitalVendido);
 $mostrarCapitalVendido=mysqli_fetch_array($resultadoCapVend);



$sqlVentasUL5M="SELECT COUNT(*) from operacion_preventa where saldo_final_preventa <= 0 and operacion_preventa.eliminado='0' and fecha_carga_preventa >= date_sub(curdate(), interval 5 month)";
  $resultadoVenUlt5Me=mysqli_query($conexionLogueado,$sqlVentasUL5M);
 $mostrarVentUlt5Me=mysqli_fetch_array($resultadoVenUlt5Me);



// sumatoria de valores prendarios aceptados
 $sqlValCredPrend="SELECT SUM(c.monto_prendario+c.monto_sellado) from creditos_prendarios c where c.estado='1'";
 $resultadoValCredPre=mysqli_query($conexionLogueado,$sqlValCredPrend);
 $mostrarValCredPre=mysqli_fetch_array($resultadoValCredPre);


// sumatoria de valores prendarios en espera
 $sqlValCredPrendEnEsp="SELECT SUM(c.monto_prendario+c.monto_sellado) from creditos_prendarios c where c.estado='0'";
 $resultadoValCredPreEnEsp=mysqli_query($conexionLogueado,$sqlValCredPrendEnEsp);
 $mostrarValCredPreEnEsp=mysqli_fetch_array($resultadoValCredPreEnEsp);










    mysqli_close($conexionLogueado);

        ?>


    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    
    <!-- Bootstrap CSS -->

    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css"> 
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
   
    <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
   
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
            <nav class="navbar navbar-expand-lg bg-light fixed-top">
              <!-- <a class="navbar-brand" href="index.php" style="text-transform: capitalize; font-family:sans-serif; color: firebrick; font-size: 25px;"> <i class="fas fa-car-alt" style="color: darkred;"></i> AutoGaba <i class="fas fa-car-alt" style="color: darkred;"></i></a> -->
                 <!--  <a class="navbar-brand" href="#">  <img src="static/img/gaba.jpeg" height="40" width="40"></a>
                  <i class="fas fa-car-alt" style="color: darkred;"></i> AutoGaba <i class="fas fa-car-alt" style="color: darkred;"></i> -->
                   <a class="navbar-brand" href="#">  <img src="static/img/gaba.jpeg" height="48" width="48"></a>


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
                                <a class="nav-link"   href="usuarios.php" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-user"></i>Usuarios</a>
                             	
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="clientes.php"  aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-hands-helping"></i>Clientes</a>
                               
                            </li>
                             <!-- <li class="nav-item">
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
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="creditos.php"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fab fa-contao"></i>Creditos</a> 
                              
                            </li>   -->
                               
                             <li class="nav-item">
                                <a class="nav-link" href="consumos.php"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-money-bill-wave"></i>Movimientos Varios</a>

                                                       
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-calculator"></i> Ventas </a>
                                <div id="submenu-6" class="collapse submenu" >
                                    <ul class="nav flex-column">
                                          <li class="nav-item ">
                                  <a class="nav-link" onclick="redirPreVenta();"  aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fab fa-wpforms"></i>Nueva Pre-Venta</a>
                                
                            </li>



                            <li class="nav-item">
                                <a class="nav-link" href="gestionarPagos.php"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-dollar-sign"></i>Ventas Existentes</a>

                                                       
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
                            

                            <!-- <li class="nav-item">
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
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-columns"></i>Otros</a>
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

                             <!-- <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-88" aria-controls="submenu-88"><i class="far fa-file-excel"></i>Reportes</a>
                                <div id="submenu-88" class="collapse submenu" >
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link"  data-toggle="modal" data-target ="#modalReporteGeneral">Reporte General</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link"  data-toggle="modal" data-target ="#modalReporteVehiculo">Reporte Vehiculo</a>
                                        </li>




                                       
                                    </ul>
                                </div>
                            </li> -->
                         
                        </ul>
                    </div>
                     <br>
                     <br>

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
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Informes</h2>
                                
                             
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 style="font-size: 14px;" title="Cantidad de autos en estado Stock y A Ingresar" class="text-muted">Autos en Stock / A Ingresar</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 title="Cantidad de autos en estado STOCK" style="font-size: 18px;" class="mb-1" id="autosStock"><?php echo $mostrarAutosStock[0];?></h1>
                                        </div>
                                       <!--  <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <span><i class="fa fa-fw fa-arrow-up"></i></span><span>5.86%</span>
                                        </div> -->
                                    </div>
                                    <div id="sparkline-revenue"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 title="Sumatoria de precio de venta de autos en estados en Stock e a Ingresar" class="text-muted">Capital en Stock / A Ingresar</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 title="Sumatoria de precio de venta de autos en estados en Stock e a Ingresar" style="font-size: 18px;" class="mb-1"><?php echo '$'.' '.number_format($mostrarCapitalStock[0],2,",",".");?></h1>
                                        </div>
                                        
                                    </div>
                                    <div id="sparkline-revenue2"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 title="Cantidad de autos en estado Reservado"  class="text-muted">Autos Reservados</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 title="Cantidad de autos en estado Reservado"  style="font-size: 18px;" class="mb-1"><?php echo $mostrarAutosReservados[0];?></h1>
                                        </div>
                                        
                                    </div>
                                    <div id="sparkline-revenue3"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 title="Dinero que le deben a la empresa teniendo en cuenta las preventas no canceladas en su totalidad" class="text-muted">Saldo Total</h5>
                                        <div class="metric-value d-inline-block">
                                            <!-- este saldo es lo q le deben a la empresa -->
                                            <h1 title="Dinero que le deben a la empresa teniendo en cuenta las preventas no canceladas en su totalidad" style="font-size: 18px;"  class="mb-1"><?php echo '$'.' '.number_format($mostrarSaldoEmpresa[0],2,",",".");?></h1>
                                        </div>
                                       
                                    </div>
                                    <div id="sparkline-revenue4"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 title="Cantidad de autos en estado Vendido" class="text-muted">Autos Vendidos</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 title="Cantidad de autos en estado Vendido" style="font-size: 18px;" class="mb-1"><?php echo $mostrarAutosVendidos[0];?></h1>
                                        </div>
                                        
                                    </div>
                                    <div id="sparkline-revenue2"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 title="Sumatoria de los precio de ventas de los vehiculos en estado vendido" class="text-muted">Capital Vendido</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 title="Sumatoria de los precio de ventas de los vehiculos en estado vendido" style="font-size: 18px;" class="mb-1" id="autosStock"><?php echo '$'.' '.number_format($mostrarCapitalVendido[0],2,",",".");?></h1>
                                        </div>
                                       <!--  <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <span><i class="fa fa-fw fa-arrow-up"></i></span><span>5.86%</span>
                                        </div> -->
                                    </div>
                                    <div id="sparkline-revenue"></div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 title="Cantidad de ventas concretadas en los ultimos 5 meses" class="text-muted">Prendarios Aprobados</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 title="Sumatoria del valor de los creditos prendarios aceptados" style="font-size: 18px;" class="mb-1"><?php echo '$'.' '.number_format($mostrarValCredPre[0],2,",",".");?></h1>
                                        </div>
                                        
                                    </div>
                                    <div id="sparkline-revenue3"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Prendarios en Espera</h5>
                                        <div class="metric-value d-inline-block">
                                            <!-- este saldo es lo q le deben a la empresa -->  
                                            <h1 style="font-size: 18px;" title="Sumatoria del valor de los creditos prendarios A Confirmar" class="mb-1"><?php echo '$'.' '.number_format($mostrarValCredPreEnEsp[0],2,",",".");?></h1>
                                        </div>
                                       
                                    </div>
                                    <div id="sparkline-revenue4"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ============================================================== -->
                      
                            <!-- ============================================================== -->

                                          <!-- recent orders  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header" style="color: orangered;">Cheques A Cobrar y A Confirmar</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">ID</th>
                                                        <th class="border-0">Numero Cheque</th>
                                                        <th class="border-0">Entidad</th>
                                                        <th class="border-0">Monto</th>
                                                        <th class="border-0">Fecha Cobro</th>
                                                        <th class="border-0">Pre Venta</th>
                                                        <th class="border-0">Dominio</th>
                                                        <th class="border-0">Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    while ($mostrarChequesAvencer=mysqli_fetch_array($resultadoChequesAvencer)){
                                                ?>
                                                    <tr style="background-color: white;">
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencer[0];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencer[1];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencer[7];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencer[2];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencer[3];?></td>
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencer[4];?></td>
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencer[6];?></td>
                                                        <td style="font-size: 12px"> <?php if ($mostrarChequesAvencer[8]=='0'){ echo "A CONFIRMAR";} else{echo "A COBRAR";};?></td>   
                                                    </tr>
                                                <?php
                                                     }
                                                ?>
                                                <?php
                                                    while ($mostrarChequesAvencerP=mysqli_fetch_array($resultadoChequesAvencerPago)){
                                                ?>
                                                    <tr style="background-color: white;">
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencerP[0];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencerP[1];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencerP[7];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencerP[2];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencerP[3];?></td>
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencerP[4];?></td>
                                                        <td style="font-size: 12px"> <?php echo $mostrarChequesAvencerP[6];?></td>
                                                        <td style="font-size: 12px"> <?php if ($mostrarChequesAvencerP[8]=='0'){ echo "A CONFIRMAR";} else{echo "A COBRAR";};?></td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>        
                                </div>
                            </div>
                            
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- customer acquistion  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Vendedor del Mes</h5>
                                    <div class="card-body">
                                        <div class="ct-chart ct-golden-section" style="height: 354px;"></div>
                                        <div class="text-center">
                                


                                        
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ============================================================== -->
                            <!-- end customer acquistion  -->
                            <!-- ============================================================== -->

                            <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header" style="color: orangered;">Prendarios a Confirmar</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">ID</th>
                                                        <th class="border-0">Monto Prendario</th>
                                                        <th class="border-0">Monto Sellado</th>
                                                        <th class="border-0">Entidad</th>
                                                       
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    while ($verCrePreAc=mysqli_fetch_array($resultadoCrePrendAc)){
                                                ?>
                                                  
                                                    <tr style="background-color: white;">
                                                        <td style="font-size: 12px"> <?php echo $verCrePreAc[0];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $verCrePreAc[1];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $verCrePreAc[2];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $verCrePreAc[3];?> </td>
                                                      
                                                    </tr>
                                                <?php
                                                     }
                                                ?>
                                               
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>        
                                </div>
                            </div>

                          


<div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header" style="color: orangered;">Personales a Confirmar</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">ID</th>
                                                        <th class="border-0">Monto</th>
                                                        <th class="border-0">Entidad</th>
                                                        
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    while ($verCrePerAc=mysqli_fetch_array($resultadoCrePerndAc)){
                                                ?>
                                                  
                                                    <tr style="background-color: white;">
                                                        <td style="font-size: 12px"> <?php echo $verCrePerAc[0];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $verCrePerAc[1];?> </td>
                                                        <td style="font-size: 12px"> <?php echo $verCrePerAc[2];?> </td>
                                                      
                                                    </tr>
                                                <?php
                                                     }
                                                ?>
                                               
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>        
                                </div>
                            </div>





                        </div>
                        <div class="row">
                            <!-- ============================================================== -->
              				                        <!-- product category  -->
                            <!-- ============================================================== -->
                           <!--  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"> Product Category</h5>
                                    <div class="card-body">
                                        <div class="ct-chart-category ct-golden-section" style="height: 315px;"></div>
                                        <div class="text-center m-t-40">
                                            <span class="legend-item mr-3">
                                                    <span class="fa-xs text-primary mr-1 legend-tile"><i class="fa fa-fw fa-square-full "></i></span><span class="legend-text">Man</span>
                                            </span>
                                            <span class="legend-item mr-3">
                                                <span class="fa-xs text-secondary mr-1 legend-tile"><i class="fa fa-fw fa-square-full"></i></span>
                                            <span class="legend-text">Woman</span>
                                            </span>
                                            <span class="legend-item mr-3">
                                                <span class="fa-xs text-info mr-1 legend-tile"><i class="fa fa-fw fa-square-full"></i></span>
                                            <span class="legend-text">Accessories</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- ============================================================== -->
                            <!-- end product category  -->
                                   <!-- product sales  -->
                            <!-- ============================================================== -->
                           <!--  <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                       
                                        <h5 class="mb-0"> Product Sales</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="ct-chart-product ct-golden-section"></div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- ============================================================== -->
                            <!-- end product sales  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-3 col-lg-12 col-md-6 col-sm-12 col-12">
                                <!-- ============================================================== -->
                                <!-- top perfomimg  -->
                                <!-- ============================================================== -->
                                <!-- <div class="card">
                                    <h5 class="card-header">Top Performing Campaigns</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table no-wrap p-table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">Campaign</th>
                                                        <th class="border-0">Visits</th>
                                                        <th class="border-0">Revenue</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Campaign#1</td>
                                                        <td>98,789 </td>
                                                        <td>$4563</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Campaign#2</td>
                                                        <td>2,789 </td>
                                                        <td>$325</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Campaign#3</td>
                                                        <td>1,459 </td>
                                                        <td>$225</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Campaign#4</td>
                                                        <td>5,035 </td>
                                                        <td>$856</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Campaign#5</td>
                                                        <td>10,000 </td>
                                                        <td>$1000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Campaign#5</td>
                                                        <td>10,000 </td>
                                                        <td>$1000</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <a href="#" class="btn btn-outline-light float-right">Details</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- ============================================================== -->
                                <!-- end top perfomimg  -->
                                <!-- ============================================================== -->
                            </div>
                        </div>

                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- sales  -->
                            <!-- ============================================================== -->
                          <!--   <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="card border-3 border-top border-top-primary">
                                    <div class="card-body">
                                        <h5 class="text-muted">Sales</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">$12099</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">5.86%</span>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- ============================================================== -->
                            <!-- end sales  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- new customer  -->
                            <!-- ============================================================== -->
                           <!--  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="card border-3 border-top border-top-primary">
                                    <div class="card-body">
                                        <h5 class="text-muted">New Customer</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">1245</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">10%</span>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- ============================================================== -->
                            <!-- end new customer  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- visitor  -->
                            <!-- ============================================================== -->
                           <!--  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="card border-3 border-top border-top-primary">
                                    <div class="card-body">
                                        <h5 class="text-muted">Visitor</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">13000</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">5%</span>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- ============================================================== -->
                            <!-- end visitor  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- total orders  -->
                            <!-- ============================================================== -->
                           <!--  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="card border-3 border-top border-top-primary">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Orders</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">1340</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-danger font-weight-bold">
                                            <span class="icon-circle-small icon-box-xs text-danger bg-danger-light bg-danger-light "><i class="fa fa-fw fa-arrow-down"></i></span><span class="ml-1">4%</span>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- ============================================================== -->
                            <!-- end total orders  -->
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- total revenue  -->
                            <!-- ============================================================== -->
  
                            
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- category revenue  -->
                            <!-- ============================================================== -->
                            <!-- <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Revenue by Category</h5>
                                    <div class="card-body">
                                        <div id="c3chart_category" style="height: 420px;"></div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- ============================================================== -->
                            <!-- end category revenue  -->
                            <!-- ============================================================== -->
<!-- 
                            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"> Total Revenue</h5>
                                    <div class="card-body">
                                        <div id="morris_totalrevenue"></div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="display-7 font-weight-bold"><span class="text-primary d-inline-block">$26,000</span><span class="text-success float-right">+9.45%</span></p>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12">
                                <!-- ============================================================== -->
                                <!-- social source  -->
                                <!-- ============================================================== -->
                               <!--  <div class="card">
                                    <h5 class="card-header"> Sales By Social Source</h5>
                                    <div class="card-body p-0">
                                        <ul class="social-sales list-group list-group-flush">
                                            <li class="list-group-item social-sales-content"><span class="social-sales-icon-circle facebook-bgcolor mr-2"><i class="fab fa-facebook-f"></i></span><span class="social-sales-name">Facebook</span><span class="social-sales-count text-dark">120 Sales</span>
                                            </li>
                                            <li class="list-group-item social-sales-content"><span class="social-sales-icon-circle twitter-bgcolor mr-2"><i class="fab fa-twitter"></i></span><span class="social-sales-name">Twitter</span><span class="social-sales-count text-dark">99 Sales</span>
                                            </li>
                                            <li class="list-group-item social-sales-content"><span class="social-sales-icon-circle instagram-bgcolor mr-2"><i class="fab fa-instagram"></i></span><span class="social-sales-name">Instagram</span><span class="social-sales-count text-dark">76 Sales</span>
                                            </li>
                                            <li class="list-group-item social-sales-content"><span class="social-sales-icon-circle pinterest-bgcolor mr-2"><i class="fab fa-pinterest-p"></i></span><span class="social-sales-name">Pinterest</span><span class="social-sales-count text-dark">56 Sales</span>
                                            </li>
                                            <li class="list-group-item social-sales-content"><span class="social-sales-icon-circle googleplus-bgcolor mr-2"><i class="fab fa-google-plus-g"></i></span><span class="social-sales-name">Google Plus</span><span class="social-sales-count text-dark">36 Sales</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#" class="btn-primary-link">View Details</a>
                                    </div>
                                </div> -->
                                <!-- ============================================================== -->
                                <!-- end social source  -->
                                <!-- ============================================================== -->
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <!-- ============================================================== -->
                                <!-- sales traffice source  -->
                                <!-- ============================================================== -->
                               <!--  <div class="card">
                                    <h5 class="card-header"> Sales By Traffic Source</h5>
                                    <div class="card-body p-0">
                                        <ul class="traffic-sales list-group list-group-flush">
                                            <li class="traffic-sales-content list-group-item "><span class="traffic-sales-name">Direct</span><span class="traffic-sales-amount">$4000.00  <span class="icon-circle-small icon-box-xs text-success ml-4 bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1 text-success">5.86%</span></span>
                                            </li>
                                            <li class="traffic-sales-content list-group-item"><span class="traffic-sales-name">Search<span class="traffic-sales-amount">$3123.00  <span class="icon-circle-small icon-box-xs text-success ml-4 bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1 text-success">5.86%</span></span>
                                                </span>
                                            </li>
                                            <li class="traffic-sales-content list-group-item"><span class="traffic-sales-name">Social<span class="traffic-sales-amount ">$3099.00  <span class="icon-circle-small icon-box-xs text-success ml-4 bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1 text-success">5.86%</span></span>
                                                </span>
                                            </li>
                                            <li class="traffic-sales-content list-group-item"><span class="traffic-sales-name">Referrals<span class="traffic-sales-amount ">$2220.00   <span class="icon-circle-small icon-box-xs text-danger ml-4 bg-danger-light"><i class="fa fa-fw fa-arrow-down"></i></span><span class="ml-1 text-danger">4.02%</span></span>
                                                </span>
                                            </li>
                                            <li class="traffic-sales-content list-group-item "><span class="traffic-sales-name">Email<span class="traffic-sales-amount">$1567.00   <span class="icon-circle-small icon-box-xs text-danger ml-4 bg-danger-light"><i class="fa fa-fw fa-arrow-down"></i></span><span class="ml-1 text-danger">3.86%</span></span>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#" class="btn-primary-link">View Details</a>
                                    </div>
                                </div> -->
                            </div>
                            <!-- ============================================================== -->
                            <!-- end sales traffice source  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- sales traffic country source  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-3 col-lg-12 col-md-6 col-sm-12 col-12">
                             <!--    <div class="card">
                                    <h5 class="card-header">Sales By Country Traffic Source</h5>
                                    <div class="card-body p-0">
                                        <ul class="country-sales list-group list-group-flush">
                                            <li class="country-sales-content list-group-item"><span class="mr-2"><i class="flag-icon flag-icon-us" title="us" id="us"></i> </span>
                                                <span class="">United States</span><span class="float-right text-dark">78%</span>
                                            </li>
                                            <li class="list-group-item country-sales-content"><span class="mr-2"><i class="flag-icon flag-icon-ca" title="ca" id="ca"></i></span><span class="">Canada</span><span class="float-right text-dark">7%</span>
                                            </li>
                                            <li class="list-group-item country-sales-content"><span class="mr-2"><i class="flag-icon flag-icon-ru" title="ru" id="ru"></i></span><span class="">Russia</span><span class="float-right text-dark">4%</span>
                                            </li>
                                            <li class="list-group-item country-sales-content"><span class=" mr-2"><i class="flag-icon flag-icon-in" title="in" id="in"></i></span><span class="">India</span><span class="float-right text-dark">12%</span>
                                            </li>
                                            <li class="list-group-item country-sales-content"><span class=" mr-2"><i class="flag-icon flag-icon-fr" title="fr" id="fr"></i></span><span class="">France</span><span class="float-right text-dark">16%</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="#" class="btn-primary-link">View Details</a>
                                    </div>
                                </div> -->
                            </div>
                            <!-- ============================================================== -->
                            <!-- end sales traffice country source  -->
                            <!-- ============================================================== -->
                        </div>
                    </div>
                </div>
            </div>
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
     <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
     <script src="assets/libs/js/main-js.js"></script> 






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



   <!-- Modal reporte general -->
<div class="modal fade" id="modalReporteGeneral" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reporte</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevo"   action="reporteGeneralExcel.php" method="post">
     <label>Fecha Inicio</label>
    <input  type="date" class="form-control input-sm" id="fechaInicio" name="fechaInicio" value="<?php echo date("Y-m-d"); ?>" >
     <label>Fecha Fin</label>
    <input  type="date" class="form-control input-sm" id="fechaFin" name="fechaFin" value="<?php echo date("Y-m-d"); ?>" >
  
    <br>
    
       
 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnAgregarNuevo" class="btn btn-primary" >Generar Reporte</button>
      </div>

</form>
 

      </div>
      
    </div>
  </div>
</div>





   <!-- Modal reporte Vehiculo -->
<div class="modal fade" id="modalReporteVehiculo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reporte Vehiculo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevo"   action="reporteVehiculoExcel.php" method="post">
    


  <?php 

    $conexionVehiculo= conectar();
    mysqli_set_charset($conexionVehiculo,'utf8'); 
    $sqlc= "SELECT id,marca,modelo,dominio_patente from vehiculos";

    $resultadoV=mysqli_query($conexionVehiculo,$sqlc);

    mysqli_close($conexionVehiculo);
    
         ?>

<div class="row">
        <div class="col-sm-2" >
        <label style="font-size: 14px">Vehiculo: </label>
    </div>
    <div class="col-sm-6" style="width: 160px;" >
<select style="width: 320px;" id="idVehiculo" name="idVehiculo" class="mi-selectorVRe" style="background-color: gainsboro;" required="true">
                <?php

                while ($valoresOrigen = mysqli_fetch_array($resultadoV)) {
                    ?>
                    <option value="<?php print($valoresOrigen['id']);?>"> <?php  print($valoresOrigen['marca'].' '.$valoresOrigen['modelo'].' '.$valoresOrigen['dominio_patente']);?> </option>

                    <?php
                }
                ?>
            </select>


    
              
            </div> 
        </div>











  
    <br>
    
       
 
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnAgregarNuevo" class="btn btn-primary" >Generar Reporte</button>
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
 <input  style="height: 25px" type="text" class="form-control input-sm" id="saldoCierre" name="saldoCierre"   disabled="true" >
  <input  style="height: 25px" type="text" class="form-control input-sm" id="saldoCierree" name="saldoCierree"   hidden="true" >
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
                    $.ajax({
                            type: "POST",
                            url: "procesos/obtenerCajas.php",
                            success: function(response)
                            {
                                  $('.selector-cajaCierre select').html(response).fadeIn();
                            }
                    });
 
                });
</script>



<script type="text/javascript">
                $(document).ready(function() {
                    $.ajax({
                            type: "POST",
                            url: "procesos/obtenerCajasAInicializar.php",
                            success: function(response)
                            {
                                  $('.selector-cajaIncializar select').html(response).fadeIn();
                            }
                    });
 
                });
</script>




<script type="text/javascript">
	
function asignarSaldoCierre(){

var idCaja= document.getElementById('selectCajaCierre').value;

          $.ajax({
    			type:'post',
    			data:"idCaja="+idCaja,
    			url:'procesos/obtenerDatosCaja.php',
    			success:function(r){
    			
    				
    				  datos= jQuery.parseJSON(r);
    				  $('#saldoCierre').val(datos['saldo']);
    			       $('#saldoCierree').val(datos['saldo']);   
	 
    			
    			}


    	});


}


</script>

<script type="text/javascript">
    jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>





<script type="text/javascript">
	
function asignarSaldoInicial(){

var idCaja= document.getElementById('selectCajaInicializar').value;

          $.ajax({
    			type:'post',
    			data:"idCaja="+idCaja,
    			url:'procesos/obtenerDatosCaja.php',
    			success:function(r){
    			
    				
    				  datos= jQuery.parseJSON(r);
    				  $('#montoInicialCaja').val(datos['saldo']);
    			
	 
    			
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
                $(document).ready(function() {
                   
                   $('#NombreLoguin').text('<?php echo $mostrarloguin['nombre'].' '.$mostrarloguin['apellido'];?>');
 
                });






     jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selectorVRe').select2();
    });
});







</script>