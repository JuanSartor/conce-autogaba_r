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



    $sqlProEsta= "SELECT vehiculos.marca,vehiculos.modelo, vehiculos.dominio_patente,operacion_preventa.id_real_preventa  from operacion_preventa,vehiculos where vehiculos.id=operacion_preventa.id_vehiculo_prevendido and operacion_preventa.id='$_GET[datosidP]'";

    $resultadoProyecEstado=mysqli_query($conexionLogueado,$sqlProEsta);


    $mosEstPro=mysqli_fetch_array($resultadoProyecEstado);

    mysqli_close($conexionLogueado);

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
                                <a class="nav-link" href="clientes.php"   aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-hands-helping"></i>Clientes</a>
                               
                            </li>
                            <!--  <li class="nav-item">
                                <a class="nav-link" href="vendedores.php"  aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-hand-holding-usd"></i>Vendedores</a>
                             
                            </li> -->
                            <li class="nav-item ">
                                <a class="nav-link" href="automoviles.php"  aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-car"></i>Automoviles</a>
                               
                            </li>
                           
                            <li class="nav-divider">
                                OPERACIONES
                            </li>

                               
                            <li class="nav-item">
                                 <a class="nav-link" href="consumos.php" id="linkMovimientos"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-money-bill-wave"></i>Movimientos Varios</a>

                                                       
                            </li>
                                     <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-calculator"></i> Ventas </a>
                                <div id="submenu-6" class="collapse submenu show" >
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
                            <li class="nav-item">
                                <a class="nav-link active" href="#"  aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-cash-register"></i>Lista Pagos Realizados</a>

                                                       
                            </li>
                                                                                
                                    </ul>
                                </div>
                            </li>
                            
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
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" id="linkOtros" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-columns"></i>Otros</a>
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
                                         <li class="nav-item active">
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
                                      <!--   <li class="nav-item">
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
                         PAGOS REALIZADOS

               <!--           <div style="width: 20px" >
                <button type="button"  class="btn btn-primary mb-1" id="btnNuevoProductor" data-toggle="modal" data-target ="#agregarnuevosdatosmodal"  style="width: 50px"> <span class="fas fa-plus-circle"></span> </button>
            </div> -->
                          <br>
                          <hr>
                          <div class="row">
                            <div class="col-sm-2" style="font-size: 12px; text-decoration: underline;">
                                Nro Preventa:
                            </div>
                            <div class="col-sm-3" style="font-size: 12px;">
                                  <?php echo $mosEstPro[3]; ?>
                            </div>

                            <!-- <div class="col-sm-2"  style="font-size: 12px;" >   
                                Dominio:
                            </div>
                            <div class="col-sm-2"  style="font-size: 12px;" >
                                  <?php echo $mosEstPro[2]; ?>
                            </div> -->

                        </div>
                        <br>


                     <div class="row">
                            <div class="col-sm-2" style="font-size: 12px; text-decoration: underline;">
                                Vehiculo:
                            </div>
                            <div class="col-sm-3" style="font-size: 12px;">
                                  <?php echo $mosEstPro[0].' '.$mosEstPro[1]; ?>
                            </div>

                            <div class="col-sm-2"  style="font-size: 12px; text-decoration: underline;" >   
                                Dominio:
                            </div>
                            <div class="col-sm-2"  style="font-size: 12px;" >
                                  <?php echo $mosEstPro[2]; ?>
                            </div>

                        </div>

                    </div>

                        <br>



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
        <!--      <div class="footer">
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
   
    <!-- slimscroll js -->
     <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
     <script src="assets/libs/js/main-js.js"></script> 
 






<!-- Modal agregar -->
<div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Entidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<form id="frmnuevo" onsubmit="nuevaEntidad()"  action="" method="post">

    
          
    <label id="nombreLabel" >Descripcion</label>
    <input  type="text"  class="form-control input-sm" id="nombre" name="nombre" required minlength="2" maxlength="59"   pattern="^[a-zA-Z\s]+">
    

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




<!-- Modal editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualizar Entidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmactualizar"  onsubmit="actualizarGuardarEntidad()"  action="" method="post">
    

    <label id="nombreLabel" >Descripcion</label>
    <input  type="text"  class="form-control input-sm" id="nombreU" name="nombreU" required minlength="2" maxlength="59"   pattern="^[a-zA-Z\s]+">

    <input type="text" class="form-control input-sm" id="idU" name="idU" required   hidden="true">

    <br>





    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-warning" id="btnGuardar">Guardar</button>
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

        $('#tablaDatatable').load('tablaPagos.php?datosidP='+"<?php echo $_GET['datosidP']; ?>");

    });


</script>



<script type="text/javascript">
    // function nuevaEntidad(){


    //     datos=$('#frmnuevo').serialize();
    //     $.ajax({
    //         type:"POST",
    //         data:datos,
    //         url:"procesos/agregarEntidad.php",
    //         success:function(){
                    
    //                 $('#tablaDatatable').load('tablaPagos.php');
    //                 alertify.success("Se agrego correctamente");
                    

    //         },
    //         error:function(){

    //             alertify.success("No se pudo agregar correctamente");
                
    //         }


    //     });

    // }


</script>



<script type="text/javascript">
    

// function actualizarGuardarEntidad(){
//         datos=$('#frmactualizar').serialize();
//         $.ajax({
//             type:"POST",
//             data:datos,
//             url:"procesos/actualizarEntidad.php",
//             success:function(){
                
//                     $('#tablaDatatable').load('tablaPagos.php');
//                     alertify.success("Se actualizo correctamente");
                    

//             },
//             error:function(){

//                 alertify.success("No se pudo actualizar correctamente");
                
//             }

//         });

//     }
 


</script>


<script type="text/javascript">

$('#btnAgregarClienteNuevo').click(function(){
datos=$('#frmnuevo').serialize();

           
            $('#nombre').val('');
         

});





function actualizarEntidad(id){
    $.ajax({
        type:"POST",
        data:"id=" + id,
        url:"procesos/obtenerDatosEntidad.php",
        success:function(r){
            datos=jQuery.parseJSON(r);
            
            $('#nombreU').val(datos['descripcion']);
            $('#idU').val(datos['id']);
           

            

        }
    });
}



function eliminarPago(id,idPreventa){
    
    alertify.confirm('Eliminar Pago', '¿Esta seguro que desea eliminar el Pago?',
        function(){ 
                $.ajax({
        type:"POST",
        data:"id=" + id,
        url:"procesos/eliminarPago.php",
        success:function(r){
            
                $('#tablaDatatable').load('tablaPagos.php?datosidP='+idPreventa);
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

//bloqueo para volver hacia atras post logout

    if(history.forward(1)){
        history.replace(history.forward(1));
    }
</script>



<script>
function habilitar(value) {
   
    if(value=="1")
            {
                // habilitamos
                document.getElementById("nombre").disabled=false;
                  document.getElementById("apellido").disabled=false;
                    document.getElementById("dni").disabled=false;
                      document.getElementById("razonSocial").disabled=true;
                      document.getElementById("razonSocial").value="";
                        document.getElementById("cuit").disabled=true;
                        document.getElementById("cuit").value="";
                        document.getElementById("cuit").hidden=true;
                        document.getElementById("cuitLabel").hidden=true;
                         document.getElementById("razonSocial").hidden=true;
                        document.getElementById("razonSocialLabel").hidden=true;

                        document.getElementById("nombre").hidden=false;
                        document.getElementById("nombreLabel").hidden=false;
                        document.getElementById("apellido").hidden=false;
                        document.getElementById("apellidoLabel").hidden=false;
                        document.getElementById("dni").hidden=false;
                        document.getElementById("dniLabel").hidden=false;

            }else if(value=="2"){
                
                document.getElementById("nombre").disabled=true;
                document.getElementById("nombre").value="";
                  document.getElementById("apellido").disabled=true;
                  document.getElementById("apellido").value="";
                    document.getElementById("dni").disabled=true;
                    document.getElementById("dni").value="";
                      document.getElementById("razonSocial").disabled=false;
                        document.getElementById("cuit").disabled=false;
                        document.getElementById("cuit").hidden=false;
                        document.getElementById("cuitLabel").hidden=false;
                         document.getElementById("razonSocial").hidden=false;
                        document.getElementById("razonSocialLabel").hidden=false;

                        document.getElementById("nombre").hidden=true;
                        document.getElementById("nombreLabel").hidden=true;
                        document.getElementById("apellido").hidden=true;
                        document.getElementById("apellidoLabel").hidden=true;
                        document.getElementById("dni").hidden=true;
                        document.getElementById("dniLabel").hidden=true;

            }


}
</script>
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