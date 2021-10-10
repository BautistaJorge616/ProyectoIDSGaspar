<?php


 	//Metodo para iniciar sesion
    session_start();

 	//Requerir la conexion
 	include 'ConexionDB/conexion.php'; 

 	$archivo = $_POST['ruta'];
	
	$nombreArchivo = explode(".", $archivo)[0];
	$extensionArchivo = explode(".", $archivo)[1];
	$nombrePropietario = $_POST['propietario'];


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analisis</title>

  

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
            <div class="col-7">
                <h1 class="display-2" >Resultado del analisis</h1>

            </div>
        </div>
    </div>

    <!--Información general del documento-->
    <div class="container-fluid my-4">
        <div class="row">
        	<div class="col-1"></div>
            <div class="col-5">
                <h1 class="display-5 text-info" >Información general</h1>

            </div>
        </div>
    </div>

    <!--Tabla con el analisis-->
    <div class="container-fluid">
    	<div class="row justify-content-center">
    		<div class="col-10">

    			<table class="table table-bordered table-hover">

                    <thead>
                        <tr>

                            <th>Nombre del archivo</th>
                            <th>Tipo de archivo</th>
                            <th>Propietario del archivo</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        
                        <td>
                        	<?php echo $nombreArchivo; ?>
                        </td>
                        
                        <td>
                        	<?php echo $extensionArchivo; ?>
                        </td>

                        <td>
                        	<?php echo $nombrePropietario; ?>
                        </td>                    

                    </tbody>

                </table>

    		</div>
    	</div>
    </div>


    <!--Contenido del documento-->
    <div class="container-fluid my-4">
        <div class="row">
        	<div class="col-1"></div>
            <div class="col-6">
                <h1 class="display-5 text-info" >Contenido del documento</h1>

            </div>
        </div>
    </div>

    <!--Tabla con el analisis-->
    <div class="container-fluid">
    	<div class="row justify-content-center">
    		<div class="col-10">

    			<table class="table table-bordered table-hover">

                    <thead>
                        <tr>

                            <th>Palabras</th>
                            <th>Líneas</th>
                            <th>Caracteres</th>
                            <th>Parrafos</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        
                        <td>
                        	0
                        </td>
                        
                        <td>
                        	0
                        </td>

                        <td>
                        	0
                        </td>

                        <td>
                        	0
                        </td>                    

                    </tbody>

                </table>

    		</div>
    	</div>
    </div>


    <!--Recurrencia de palabras-->
    <div class="container-fluid my-4">
        <div class="row">
        	<div class="col-1"></div>
            <div class="col-6">
                <h1 class="display-5 text-info" >Recurrencia de palabras</h1>

            </div>
        </div>
    </div>

     <!--Tabla con el analisis-->
    <div class="container-fluid">
    	<div class="row justify-content-center">
    		<div class="col-10">

    			<table class="table table-bordered table-hover">

                    <thead>
                        <tr>

                            <th>Palabra</th>
                            <th>Número de veces que aparece</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        
                        <td>
                        	Palabra
                        </td>
                        
                        <td>
                        	0
                        </td>
                  

                    </tbody>

                </table>

    		</div>
    	</div>
    </div>
    
    <!--Gráfica-->
    <div class="container-fluid my-4">
        <div class="row">
        	<div class="col-1"></div>
            <div class="col-6">
                <h1 class="display-5 text-info" >Gráfica</h1>

            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    

</body>
</html>