<?php 

    //Metodo para iniciar sesion
    session_start();

    //Requerir la conexion
    include 'ConexionDB/conexion.php'; 

    $nombreDelUsuario = "";
    $nivelDelUsuario;
    $id = $_SESSION['user_id'];

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

    //Mostrar todos los documentos

    $path = 'archivos/usuarios/'.$id;
  
    if(!file_exists($path)){
         mkdir($path);
    }
    
    $directorio = opendir($path);
 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Espacio de Trabajo</title>

  

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
        		 <a class="text-decoration-none" href="subirArchivo.php">Subir Archivo</a> 
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

    <!--Nombre de la página-->
    <div class="container-fluid my-4">
        <div class="row justify-content-center">
            <div class="col-7">
                <h1 class="display-1" >Espacio de trabajo</h1>

            </div>
        </div>
    </div>

    <!--Archivos-->
    <div class="container-fluid">
    	<div class="row justify-content-center">
    		<div class="col-10">

    			<table class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>Nombre del archivo</th>
                            <th>Extensión</th>
                            <th>Tamaño</th>
                            <th>Propietario</th>
                            <th>Descargar</th>
                            <th>Analizar</th>
                            <th>Visualizar</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        
                        <?php while($archivo = readdir($directorio)){   ?>
                            <tr>
                                <?php if(!is_dir($archivo)){ ?>
                                    <td>
                                        <?php $mostrar = explode(".", $archivo)[0];?>
                                        <?php echo $mostrar; ?> 
                                    </td>
                                    <td> <?= pathinfo($directorio.$archivo,PATHINFO_EXTENSION); ?> </td>

                                    <td>

                                        <?php $tamano = filesize($path.'/'.$archivo); ?>
                                        <?php if($tamano < 1048576){?>
                                        <?php   $tamano = $tamano / 1024;?>
                                        <?php   $tamano = round($tamano, PHP_ROUND_HALF_UP); ?>
                                        <?php       if($tamano < 1){ ?>
                                        <?php           echo "1 KB";?>
                                        <?php       } else { ?>
                                        <?php           echo $tamano." KB";?>
                                        <?php       }?>
                                        <?php } else { ?>
                                        <?php   $tamano = $tamano / 1048576;?>
                                        <?php   $tamano = round($tamano, PHP_ROUND_HALF_UP); ?>
                                        <?php   echo $tamano." MB";?>
                                        <?php } ?>

                                    </td>

                                    <td>
                                        Propietario
                                    </td>


                                    <!--Descargar-->
                                    <td>
                                        <form action="descargar.php" method="POST" 
                                        target="_blank">
                                            <input type="hidden" name="ruta" value="<?php echo $archivo; ?>">
                                            <div align="center" >
                                                <input type="submit" name="descargar" 
                                                value="Descargar"  
                                                class="btn btn-outline-primary btn-sm">
                                            </div>
                                        </form>
                                    </td>

                                    
                                    <!--Ver si se puede visualizar-->
                                    <?php $tipo = pathinfo($directorio.$archivo,PATHINFO_EXTENSION);?>
                                    <?php if($tipo == 'pdf' or $tipo == 'docx' or $tipo == 'txt'){ ?>
                                        <td>
                                            <form action="visualizar.php" method="POST" target="_blank">
                                                <input type="hidden" name="ruta" value="<?php echo $archivo; ?>">
                                                <div align="center">
                                                    <input type="submit" name="ver" value="Visualizar" class="btn btn-outline-primary btn-sm">
                                                </div>
                                            </form>
                                        </td>
                                    <?php }else{?>
                                        <td>
                                            <div class="text-danger" align="center">
                                                No soportado
                                            </div>
                                        </td>
                                    <?php } ?>

                                    <!--Ver si se puede analizar-->
                                    <?php if($tipo == 'pdf' or $tipo == 'docx' or $tipo == 'txt'){ ?>
                                        <td>
                                            <form action="analisis.php" method="POST" target="_blank">
                                                <input type="hidden" name="ruta" value="<?php echo $archivo; ?>">
                                                <input type="hidden" name="propietario" value="<?php echo "Propietario"; ?>">
                                                <div align="center" >
                                                    <input type="submit" name="analizar" value="Analizar"  class="btn btn-outline-primary btn-sm">
                                                </div>
                                            </form>
                                        </td>
                                    <?php }else{?>
                                        <td>
                                            <div class="text-danger" align="center">
                                                No soportado
                                            </div>
                                        </td>
                                    <?php } ?>


                                <?php } ?>


                            </tr>
                        <?php } ?>                           

                    </tbody>

                </table>

    		</div>
    	</div>
    </div>

    

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    

</body>
</html>