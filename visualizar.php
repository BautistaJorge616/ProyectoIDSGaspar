<?php 

    //Metodo para iniciar sesion
    session_start();

    //Requerir la conexion
    include 'ConexionDB/conexion.php'; 

    $id = $_SESSION['user_id'];
    $path = $_POST['ruta'];

    $extension = pathinfo($path,PATHINFO_EXTENSION);

    if($extension == 'txt' or $extension == 'pdf' or $extension == 'docx'){

        if(isset($_POST['ver'])){

          
            //Ver archivo con extensión pdf
            if($extension == 'pdf'){
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=documento.pdf");
                readfile($path);
            }

            //Ver archivo con extensión docx
            if($extension == 'docx'){

            }

        }

    }
   

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Visualizar</title>

  

    <!--Bootstrap-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

</head>
<body>

    <?php if($extension == 'txt'){ ?>
    <!--Cabecero-->
        <div class="container-fluid bg-primary text-white">
            <div class="row justify-content-center">
               <div class="col-10">
                    <h1>TeamWork</h1>
               </div>
            </div>
        </div>
    
        <div class="container-fluid my-5">
            <div class="row justify-content-center">
                <div class="col-6">
                    <h1 class="display-3" >Visor de archivos TXT</h1>
                </div>
            </div>
        </div>

        <div class="container-fluid my-3">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="container-md my-1">
                        <div class="card-body bg-light">
                            <?php $ArchivoLeer = $path; ?>
                            <?php if(touch($ArchivoLeer)){ ?>
                            <?php   $archivoID = fopen($ArchivoLeer, "r"); ?>
                            <?php   while( !feof($archivoID)){ ?>
                            <?php       $linea = fgets($archivoID, 1024); ?>
                            <?php       echo $linea."</br>";?>
                            <?php   } ?>
                            <?php   fclose($archivoID); ?>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    

</body>
</html>