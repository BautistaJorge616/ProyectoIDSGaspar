<?php 

    //Metodo para iniciar sesion
    session_start();

    //Requerir la conexion
    include 'ConexionDB/conexion.php'; 

    if(!empty($_POST['password_1']) && isset($_SESSION['user_id'])){

        $password = $_POST['password_1'];
        $password_encriptado = password_hash($password, PASSWORD_DEFAULT);
        $x = $_SESSION['user_id'];
        
        //Cambiar la contraseña en la base de datos
        $consulta = $conn->prepare('UPDATE usuario SET password = :password WHERE id_usuario = :id');
        //Hacer la consulta con los datos que recibi
        $consulta->bindParam(':password',$password_encriptado);
        $consulta->bindParam(':id', $_SESSION['user_id'] );
        $consulta->execute();

        //Y lo redireccionamos
        header("Status: 301 Moved Permanently");
        header("Location:espacioTrabajo.php");
        echo"<script language='javascript'>window.location='espacioTrabajo.php'</script>;";
        exit();
    }


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cambio de contraseña</title>

    <!--Validación con JavaScript-->
    <script type="text/javascript " src="validaciones/nuevoPassword.js"></script>

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


  

    <!--Mensaje para dar contexto al usuario-->
    <div class="container-fluid bg-success text-white">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <h3>Para continuar debes cambiar tu contraseña!  :)</h3>
            </div>
        </div>
    </div>

     <!--Fomulario cambiar la contraseña predeterminada-->
    <div class="container-fluid my-5">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="container-md my-5">

                    <div class="card text-dark bg-light">
                        <div class="card-header">

                            <h4>Nueva contraseña</h4>

                        </div>
                        <div class="card-body">

                            <form action="cambioPassword.php" method="POST" 
                                    onsubmit="return validarNuevoPassword(this);">

                                <div class="mb-3">
                                    <input type="password" name="password_1" placeholder="Contraseña" onfocus="this.select();" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password_2" placeholder="Confirma tu contraseña" onfocus="this.select();" class="form-control">    
                                </div>

                                <div class="d-grid gap-2">
                                    <input type="submit" value="Establecer contraseña" class="btn btn-primary">
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