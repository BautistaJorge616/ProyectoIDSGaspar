<?php 

    //Metodo para iniciar sesion
    session_start();

    //Requerir la conexion
    include 'ConexionDB/conexion.php';


    //Inicio del análisis
    if(!empty($_POST['analizar'])){
        
        //Obtener nivel del usuario
        $consulta = $conn->prepare('SELECT * FROM usuario WHERE id_usuario = :id_usuario');
        $consulta->bindParam(':id_usuario',$_SESSION['user_id']);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        $nivelDelUsuario = $resultado['rol'];

        //Obtener archivos a los que tiene acceso
        $archivos;

        if($nivelDelUsuario == 1){
            $consulta = $conn->prepare("SELECT * FROM archivo WHERE
                                id_usuario=:id_usuario AND extension='pdf'
                                OR
                                id_usuario=:id_usuario AND extension='txt'
                                OR
                                id_usuario=:id_usuario AND extension='docx'");
            $consulta->bindParam(":id_usuario",$_SESSION['user_id']);   
            $consulta->execute();
            $archivos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        }

        if($nivelDelUsuario == 2){

        }

        if($nivelDelUsuario == 3){

        }

        //Analizar archivos recuperados
        foreach($archivos as $archivo){
            echo $archivo['nombreArchivo']." -- ".$archivo['extension']."</br>";
        }
        



    }

   

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Búsqueda Avanzada</title>

  

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

    <!--Mensaje de error de incio de sesión-->
    <div class="container-fluid bg-warning text-white">
        <div class="row justify-content-center">
            <div class="col-10">
                <h3>
                    La búsqueda por contenido se aplicará a todos los archivos soportados (PDF, TXT y DOCX) a los que tiene acceso.
                </h3>
            </div>
        </div>
    </div>

    <!--Nombre de la página-->
    <div class="container-fluid my-4">
        <div class="row justify-content-center">
            <div class="col-8">
                <h1 class="display-2" >Búsqueda por contenido</h1>

            </div>
        </div>
    </div>

    <!--Fomulario para buscar un archvivo-->
    <div class="container-fluid my-2">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="container-md my-3">

                    <div class="card text-dark bg-light">
                        <div class="card-header">

                            <h4>Ingresa el texto a buscar</h4>

                        </div>
                        <div class="card-body">

                            <form action="busquedaAvanzada.php" method="POST">

                                <div class="mb-3">
                                    <input type="text" name="analizar" class="form-control"
                                        placeholder="Contenido">
                                </div>

                                <div class="d-grid gap-2">
                                    <input type="submit" value="Iniciar análisis" class="btn btn-primary">
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