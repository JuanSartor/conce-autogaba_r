<!DOCTYPE html>
<html>
<head>
    

    <?php require_once "scripts.php"; ?>



    <!--  css -->


 <link rel="stylesheet" type="text/css" href="static/css/index.css" th:href="@{/css/index.css}">
   

</head>
<body>
    <div class="modal-dialog text-center">
        <div class="col-sm-8 main-section">
            <div class="modal-content">
               <!--  <div class="col-12 user-img">
                    <img src="static/img/arcadia.png" th:src="@{/img/user.png}"/>
                    <img src="static/img/avatar.png" th:src="@{/img/user.png}"/>
                    <img src="static/img/cyd.jpg" th:src="@{/img/user.png}"/>
                </div> -->
                 <div class="col-12 user-img">
                <img src="static/img/gaba.jpeg" th:src="@{/img/user.png}"/>
                </div> 

                <form class="col-12"  action="login.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nombre de usuario" name="username" id="username" required />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Contraseña" name="password" id="password" required />
                    </div>
                    <button type="submit" class="btn btn-primary btn-buttoni" id="botoning" name="botoning"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
                </form>
               
            </div>
        </div>
    </div>
</body>
</html>

