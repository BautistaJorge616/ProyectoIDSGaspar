<?php 

    //Metodo para iniciar sesion
    session_start();

    //Requerir la conexion
    include 'ConexionDB/conexion.php'; 

    //Mostrar errores generados al registrar un nuevo usuario
    $validacion = 0;

    if(!empty($_POST['autoregistro'])){
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellido'];
        $correo = $_POST['correo'];
        $password = "000";
        $password_encriptado = password_hash($password, PASSWORD_DEFAULT);
        $tipoCuenta = intval($_POST['tipoCuenta']);
        $activo = 0;

        //Verificar los repetidos (El correo tiene que se unico)

        //Crear una consulta de los datos
        $consulta = $conn->prepare('SELECT correo FROM usuario WHERE correo=:correo');
        //Hacer la consulta con los datos que recibi
        $consulta->bindParam(':correo',$correo);
        //Ejecutamos la consulta 
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if (!empty($resultado) && count($resultado) > 0) {
            $validacion = 1;
        }
        else{
            
            //Agregar el nuevo registro
            $consulta = $conn->prepare('INSERT INTO usuario (nombre, apellidos, correo, password, rol,activo)
                VALUES (:nombre, :apellidos, :correo, :password, :rol, :activo)');

            $consulta->bindParam(':nombre',$nombre);
            $consulta->bindParam(':apellidos', $apellidos);
            $consulta->bindParam(':correo',$correo);
            $consulta->bindParam(':password', $password_encriptado);
            $consulta->bindParam(':rol', $tipoCuenta);
            $consulta->bindParam(':activo', $activo);

            $consulta->execute();

            $validacion = 2;

        }
    }

   

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>TeamWork</title>

    <!--Validación con JavaScript-->
    <script type="text/javascript " src="validaciones/validarNuevoRegistro.js"></script>

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

    <!--Validación de errores al registrar un nuevo usuario-->
    <?php if ($validacion == 1){ ?>

        <!--Mensaje de error-->
        <div class="container-fluid bg-danger text-white">
            <div class="row justify-content-center">
                <div class="col-sm-10">
                    <h3>El correo que ingreso ya existe!  :(</h3>
                </div>
            </div>
        </div>

    <?php } ?>

    <!--Confirmación de registro-->
    <?php if ($validacion == 2){ ?>

        <!--Mensaje de error-->
        <div class="container-fluid bg-success text-white">
            <div class="row justify-content-center">
                <div class="col-sm-10">
                    <h3>Tú cuenta ha sido creada, contacta al administrador para activarla!</h3>
                </div>
            </div>
        </div>

    <?php } ?>

    <!--Descripción de la página-->
    <div class="container-fluid my-4">
        <div class="row justify-content-center">
            <div class="col-6" align="center">
                <h1 class="display-3">Regístrate</h1>
            </div>
        </div>
    </div>

    <!--Fomulario para registrar un nuevo usuario-->
    <div class="container-fluid my-1">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="container-md my-3">

                    <div class="card text-dark bg-light">
                        <div class="card-header">

                            <h4>Ingresa tú información</h4>

                        </div>
                        <div class="card-body">

                            <form action="autoRegistroUsuario.php" method="POST" 
                                    onsubmit="return validarNuevoRegistro(this);">

                                <div class="mb-3">
                                    <input type="text" name="nombre" placeholder="Nombre(s)"  
                                    class="form-control" onfocus="this.select();">
                                </div>

                                 <div class="mb-3">
                                    <input type="text" name="apellido" placeholder="Apellidos"  
                                    class="form-control" onfocus="this.select();">
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="correo" placeholder="Correo electronico"  
                                    class="form-control" onfocus="this.select();">
                                </div>

                                <div class="mb-3">

                                    <select name="tipoCuenta" class="form-select">
                                        <option value="">Nivel del usuario</option>
                                        <option value="1">Nivel 1</option>
                                        <option value="2">Nivel 2</option>
                                        <option value="3">Nivel 3</option>   
                                    </select>

                                </div>

                                <div class="d-grid gap-2">
                                    <input type="submit" value="Registrarme" class="btn btn-primary"
                                        name="autoregistro">
                                </div>

                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!--Redirección a la página de inicio de sesión-->
    <div class="container-fluid my-3">
        <div class="row justify-content-center">
            <div class="col-4" align="center">

                <a href="index.php">Iniciar Sesión</a>

            </div>
        </div>
    </div>


    

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    

</body>
</html>