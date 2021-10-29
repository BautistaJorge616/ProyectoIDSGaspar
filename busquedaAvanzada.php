<?php 

    //Metodo para iniciar sesion
    session_start();

    //Requerir la conexion
    include 'ConexionDB/conexion.php';



   

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

    <!--Nombre de la página-->
    <div class="container-fluid my-4">
        <div class="row justify-content-center">
            <div class="col-8">
                <h1 class="display-1" >Búsqueda de archivos</h1>

            </div>
        </div>
    </div>

    <!--Fomulario para buscar un archvivo-->
    <div class="container-fluid my-2">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="container-md my-3">

                    <div class="card text-dark bg-light">
                        <div class="card-header">

                            <h4>Parametros de búsqueda</h4>

                        </div>
                        <div class="card-body">

                            <form action="#" method="POST">

                                <div class="mb-3">
                                    <input type="text" name="nombreArchivo" class="form-control"
                                        placeholder="Nombre del archivo">
                                </div>


                                <div class="d-grid gap-2">
                                    <input type="submit" value="Agregar Usuario" class="btn btn-primary">
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