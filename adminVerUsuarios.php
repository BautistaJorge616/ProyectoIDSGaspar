<?php 

    //Metodo para iniciar sesion
    session_start();

    //Requerir la conexion
    include 'ConexionDB/conexion.php'; 

    $parametro = 0;

    if(isset($_SESSION['user_id'])){

        //Crear una consulta de los datos
        $consulta = $conn->prepare('SELECT id_usuario, nombre, apellidos, correo, rol, activo FROM usuario 
            WHERE rol > :parametro');
        //Hacer la consulta con los datos que recibi
        $consulta->bindParam(':parametro',$parametro);
        //Ejecutamos la consulta 
        $consulta->execute();
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

       
    }

    if(isset($_POST['desactivar'])){
        $sentencia = $conn->prepare('UPDATE usuario SET activo = :activo 
            WHERE id_usuario = :id_usuario');
        $des = 0;
        $sentencia->bindParam(':activo',$des);
        $sentencia->bindParam(':id_usuario',$_POST['id']);
        $sentencia->execute();

        //Y lo redireccionamos
        header("Status: 301 Moved Permanently");
        header("Location:adminVerUsuarios.php");
        echo"<script language='javascript'>window.location='adminVerUsuarios.php'</script>;";
        exit();

    }

    if(isset($_POST['activar'])){
        $sentencia = $conn->prepare('UPDATE usuario SET activo = :activo 
            WHERE id_usuario = :id_usuario');
        $des = 1;
        $sentencia->bindParam(':activo',$des);
        $sentencia->bindParam(':id_usuario',$_POST['id']);
        $sentencia->execute();

        //Y lo redireccionamos
        header("Status: 301 Moved Permanently");
        header("Location:adminVerUsuarios.php");
        echo"<script language='javascript'>window.location='adminVerUsuarios.php'</script>;";
        exit();

    }

   

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin</title>

  

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

    <!--Barra de navegación-->
    <div class="container-fluid bg-light text-dark">
        <div class="row justify-content-end">
            <div class="col-6">
                <strong>Usuario: </strong> <?php echo 'Administrador'; ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-2">
                 <a class="text-decoration-none" href="registrarUsuario.php">Agregar usuario</a> 
            </div>
            <div class="col-3">
                <div class="container-fluid text-white">
                    <div class="row justify-content-end ">
                        <div class="col-6">
                            <a class="text-decoration-none" href="cerrarSesion.php">Cerrar Sesión</a>            
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>

    <!--Nombre de la página-->
    <div class="container-fluid my-4">
        <div class="row justify-content-center">
            <div class="col-7">
                <h1 class="display-2" >Usuarios en el sistema</h1>

            </div>
        </div>
    </div>

    <!--Lista de usuarios en el sistema-->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-10">

                <table class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo electrónico</th>
                            <th><div align="center">Nivel</div></th>
                            <th><div align="center">Desactivar</div></th>
                            
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach($resultados as $resultado){ ?>

                            <tr>

                                <td>
                                    <?php echo $resultado['nombre']. " ".$resultado['apellidos']; ?>
                                </td>

                                <td>
                                    <?php echo $resultado['correo']; ?>
                                </td>

                                <td>
                                    <div align="center">
                                        <?php echo $resultado['rol']; ?>
                                    </div>
                                </td>

                               
                                <!--Desactivar y activar usuarios-->
                                <?php if($resultado['activo'] == 1){ ?>
                                    <td>
                                        <form action="adminVerUsuarios.php" method="POST">
                                            <div align="center">
                                                <input type="hidden" name="id" 
                                                value="<?php echo $resultado['id_usuario']; ?>">
                                                <input type="submit" name="desactivar" 
                                                value="Desactivar" class="btn btn-outline-danger btn-sm">
                                            </div>
                                        </form>
                                    </td>
                                <?php } else { ?>
                                     <td>
                                        <form action="adminVerUsuarios.php" method="POST">
                                            <div align="center">
                                                <input type="hidden" name="id" 
                                                value="<?php echo $resultado['id_usuario']; ?>">
                                                <input type="submit" name="activar" 
                                                value="  Activar   " class="btn btn-outline-success btn-sm">
                                            </div>
                                        </form>
                                    </td>
                                <?php } ?>



                            </tr>



                        <?php }?>

                    </tbody>

                </table>

            </div>
        </div>
    </div>



    

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    

</body>
</html>