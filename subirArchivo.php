<?php 

    //Metodo para iniciar sesion
    session_start();

    //Requerir la conexion
    include 'ConexionDB/conexion.php'; 

    $nombreDelUsuario = "";
    $nivelDelUsuario;
    $mensaje = "";
    $estadoCarga = -1;

    //Personalizar la página
    if(isset($_SESSION['user_id'])){

        //Crear una consulta de los datos
        $consulta = $conn->prepare('SELECT nombre, apellidos,rol FROM usuario WHERE id_usuario=:id_usuario');
        //Hacer la consulta con los datos que recibi
        $consulta->bindParam(':id_usuario',$_SESSION['user_id']);
        //Ejecutamos la consulta 
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        $nombreDelUsuario = $resultado['nombre'] . " " . $resultado['apellidos'];
        $nivelDelUsuario = $resultado['rol'];
    }

    //Subir el archivo
    if(isset($_POST['enviar'])){
        $n_sesion = $_SESSION['user_id'];

        if($_FILES['archivo']['error'] > 0){
            $mensaje = "Error al cargar archivo :(";
            $estadoCarga = 0;
        }else{
    
            $limite_mb = 500;
    
            //Validar que no supere el tamaño
            if($_FILES['archivo']['size'] <= $limite_mb * 1048576){
    
                //Ruta donde se va a guardar
                $ruta ='archivos/usuarios/'.$n_sesion.'/';
                $nombre_archivo = $_FILES['archivo']['name'];
    
                $ruta_archivo = $ruta.$nombre_archivo;
    
                //Sino existe la carpeta se crea
                if(!file_exists($ruta)){
                    mkdir($ruta);
                }
    
                if(!file_exists($ruta_archivo)){
    
                    //Subir el archivo
                    $resultado = @move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo);
    
                    //Verificar que se guardo
                    if($resultado){
                        $mensaje =  "Archivo guardado correctamente :)";
                        $estadoCarga = 1;
                    }else{
                        $mensaje = "Error al guardar el archivo :(";
                        $estadoCarga = 0;
                    }
    
                }else{
                    $mensaje = "El archivo ya existe :(";
                    $estadoCarga = 0;
                }
    
            }else{
                $mensaje = "El archivo es muy grande :(";
                $estadoCarga = 0;
            }
        }
    }
    

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Subir archivo</title>

  

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
                <strong>Usuario: </strong> <?php echo $nombreDelUsuario ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>Nivel: </strong> <?php echo $nivelDelUsuario ?>
            </div>
            <div class="col-2">
                 <a class="text-decoration-none" href="espacioTrabajo.php">Espacio de trabajo</a> 
            </div>
            <div class="col-3">
                <div class="container-fluid text-white">
                    <div class="row justify-content-end ">
                        <div class="col-8">
                            <a class="text-decoration-none" href="cerrarSesion.php">Cerrar Sesión</a>            
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>

    <!--Estado al subir un archivo-->
    <?php if ($estadoCarga == 1){ ?>

        <div class="container-fluid bg-success text-white">
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <h3><?php echo $mensaje; ?></h3>
                </div>
            </div>
        </div>

    <?php } ?>

    <?php if ($estadoCarga == 0){ ?>

        <div class="container-fluid bg-danger text-white">
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <h3><?php echo $mensaje; ?></h3>
                </div>
            </div>
        </div>

    <?php } ?>


    <!--Nombre de la página-->
    <div class="container-fluid my-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <h1 class="display-5" >Comparte tus archivos con tú equipo</h1>

            </div>
        </div>
        <div class="row justify-content-center">

        </div>
    </div>


      <!--Fomulario para subir archivo-->
    <div class="container-fluid my-3">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="container-md my-1">

                    <div class="card text-dark bg-light">
                        <div class="card-header">

                            <h4>Elige el archivo</h4>

                        </div>
                        <div class="card-body">

                            <form action="subirArchivo.php" method="POST" enctype="multipart/form-data">

                                <div class="mb-3">
                                    <input type="file" name="archivo" id="archivo" class="form-control" >
                                </div>


                                <div class="d-grid gap-2">
                                    <input type="submit" name="enviar" value="Subir archivo" class="btn btn-primary">
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