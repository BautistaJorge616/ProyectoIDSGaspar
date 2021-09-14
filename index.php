<?php 

    //Metodo para iniciar sesion
    session_start();

    //Requerir la conexion
    include 'ConexionDB/conexion.php'; 

    //Validar errores al iniciar sesión 
    $validacion = 0;

    if(!empty($_POST['correo']) && !empty($_POST['password']) ){

        echo "Validado";

    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>TeamWork</title>

    <!--Validación con JavaScript-->
    <script type="text/javascript " src="validaciones/inicioSesion.js"></script>

    <!--Bootstrap-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

</head>
<body>

    <!--Cabecero-->
    <div class="container-fluid bg-primary text-white">
        <div class="row justify-content-center">
           <div class="col-10">
                <h1>TeamWork</h1>
           </div>
        </div>
    </div>

    <!--Validación de errores al iniciar sesión-->
    <?php if ($validacion == 1){ ?>

        <!--Mensaje de error de incio de sesión-->
        <div class="container-fluid bg-danger text-white">
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <h3>Correo o contraseña no validos!  :(</h3>
                </div>
            </div>
        </div>

    <?php } ?>

    <!--Fomulario para iniciar sesión-->
    <div class="container-fluid my-5">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="container-md my-5">

                    <div class="card text-dark bg-light">
                        <div class="card-header">

                            <h4>Inicio de Sesión</h4>

                        </div>
                        <div class="card-body">

                            <form action="index.php" method="POST" onsubmit="return validarSesion(this);">

                                <div class="mb-3">
                                    <input type="text" name="correo" placeholder="Correo electronico"  
                                    class="form-control" onfocus="this.select();">
                                </div>

                                <div class="mb-3">
                                    <input type="password" name="password" placeholder="Contraseña"  
                                    class="form-control" onfocus="this.select();">
                                </div>

                                <div class="d-grid gap-2">
                                    <input type="submit" value="Iniciar Sesion" class="btn btn-primary">
                                </div>

                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    

</body>
</html>