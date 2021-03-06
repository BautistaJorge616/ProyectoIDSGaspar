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

    //Archivos que se muestran

    if(!empty($_POST['filtrar'])){

        //Variables

        $nombreBuscar = $_POST['nombreBuscar'];
        $tipoBuscar = $_POST['tipoArchivo'];

        //Ambos campos vacíos

        if($nombreBuscar == "" && $tipoBuscar == ""){
            //Y lo redireccionamos
            header("Status: 301 Moved Permanently");
            header("Location:espacioTrabajo.php");
            echo"<script language='javascript'>window.location='espacioTrabajo.php'</script>;";
            exit();
        }

        //Solo nombre

        if($nombreBuscar != "" && $tipoBuscar == ""){

            if($nivelDelUsuario == 1){
                $consulta = $conn->prepare("SELECT * FROM archivo 
                WHERE id_usuario=:id_usuario AND nombreArchivo LIKE '%' :nombreBuscar '%'
                ORDER BY fecha DESC"); 

                $consulta->bindParam(":nombreBuscar",$nombreBuscar);  
                $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                $consulta->execute();
                $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);  

            }

            if($nivelDelUsuario == 2){
                $consulta = $conn->prepare("SELECT * FROM archivo 
                WHERE id_usuario=:id_usuario AND nombreArchivo LIKE '%' :nombreBuscar '%'
                OR
                nivelArchivo = 1 AND nombreArchivo LIKE '%' :nombreBuscar '%'
                ORDER BY fecha DESC"); 
                $consulta->bindParam(":nombreBuscar",$nombreBuscar);  
                $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                $consulta->execute();
                $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);   
            }

            if($nivelDelUsuario == 3){
                $consulta = $conn->prepare("SELECT * FROM archivo 
                WHERE nivelArchivo < 3 AND nombreArchivo LIKE '%' :nombreBuscar '%'
                OR
                id_usuario=:id_usuario AND nombreArchivo LIKE '%' :nombreBuscar '%'
                ORDER BY fecha DESC");
                $consulta->bindParam(":nombreBuscar",$nombreBuscar);  
                $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                $consulta->execute();
                $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
            }

        }

        //Solo tipo 

        if($nombreBuscar == "" && $tipoBuscar != ""){

            if($nivelDelUsuario == 1){
                
                if($tipoBuscar == "todas"){

                    $consulta = $conn->prepare("SELECT * FROM archivo 
                    WHERE id_usuario=:id_usuario ORDER BY fecha DESC"); 
                    $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                    $consulta->execute();
                    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                } else{

                    $consulta = $conn->prepare("SELECT * FROM archivo 
                    WHERE id_usuario=:id_usuario 
                    AND extension = :tipoBuscar
                    ORDER BY fecha DESC"); 
                    $consulta->bindParam(":tipoBuscar",$tipoBuscar);  
                    $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                    $consulta->execute();
                    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                } 

            }

            if($nivelDelUsuario == 2){

                if($tipoBuscar == "todas"){

                    $consulta = $conn->prepare('SELECT * FROM archivo 
                    WHERE id_usuario=:id_usuario OR nivelArchivo = 1
                    ORDER BY fecha DESC'); 
                    $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                    $consulta->execute();
                    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                }else{

                   $consulta = $conn->prepare('SELECT * FROM archivo 
                    WHERE id_usuario=:id_usuario AND extension = :tipoBuscar
                    OR 
                    nivelArchivo = 1 AND extension = :tipoBuscar
                    ORDER BY fecha DESC'); 
                    $consulta->bindParam(":tipoBuscar",$tipoBuscar);
                    $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                    $consulta->execute();
                    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC); 

                }

            }

            if($nivelDelUsuario == 3){

                if($tipoBuscar == "todas"){

                    $consulta = $conn->prepare('SELECT * FROM archivo 
                    WHERE nivelArchivo < 3 OR id_usuario=:id_usuario
                    ORDER BY fecha DESC'); 
                    $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                    $consulta->execute();
                    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                }else{

                    $consulta = $conn->prepare('SELECT * FROM archivo 
                    WHERE nivelArchivo < 3 AND extension = :tipoBuscar
                    OR
                    id_usuario=:id_usuario AND extension = :tipoBuscar
                    ORDER BY fecha DESC');
                    $consulta->bindParam(":tipoBuscar",$tipoBuscar);   
                    $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                    $consulta->execute();
                    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                }

            }
        }

        //Ambos

        if($nombreBuscar != "" && $tipoBuscar != ""){

            if($nivelDelUsuario == 1){
                
                if($tipoBuscar == "todas"){

                    $consulta = $conn->prepare("SELECT * FROM archivo 
                    WHERE id_usuario=:id_usuario 
                    AND nombreArchivo LIKE '%' :nombreBuscar '%'
                    ORDER BY fecha DESC"); 
                    $consulta->bindParam(":nombreBuscar",$nombreBuscar); 
                    $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                    $consulta->execute();
                    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                } else{

                    $consulta = $conn->prepare("SELECT * FROM archivo 
                    WHERE id_usuario=:id_usuario 
                    AND extension = :tipoBuscar
                    AND nombreArchivo LIKE '%' :nombreBuscar '%'
                    ORDER BY fecha DESC"); 
                    $consulta->bindParam(":nombreBuscar",$nombreBuscar); 
                    $consulta->bindParam(":tipoBuscar",$tipoBuscar);  
                    $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                    $consulta->execute();
                    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                } 

            }   

            if($nivelDelUsuario == 2){

                if($tipoBuscar == "todas"){
                    $consulta = $conn->prepare("SELECT * FROM archivo 
                    WHERE id_usuario=:id_usuario AND nombreArchivo LIKE '%' :nombreBuscar '%'
                    OR
                    nivelArchivo = 1 AND nombreArchivo LIKE '%' :nombreBuscar '%'
                    ORDER BY fecha DESC"); 
                    $consulta->bindParam(":nombreBuscar",$nombreBuscar);  
                    $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                    $consulta->execute();
                    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC); 
                }else{

                    $consulta = $conn->prepare("SELECT * FROM archivo 
                    WHERE id_usuario=:id_usuario AND nombreArchivo LIKE '%' :nombreBuscar '%'
                    AND extension = :tipoBuscar
                    OR
                    nivelArchivo = 1 AND nombreArchivo LIKE '%' :nombreBuscar '%' 
                    AND extension = :tipoBuscar
                    ORDER BY fecha DESC"); 
                    $consulta->bindParam(":tipoBuscar",$tipoBuscar);  
                    $consulta->bindParam(":nombreBuscar",$nombreBuscar);  
                    $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                    $consulta->execute();
                    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                }

            }

            if($nivelDelUsuario == 3){

                if($tipoBuscar == "todas"){
                    
                    $consulta = $conn->prepare("SELECT * FROM archivo 
                    WHERE nivelArchivo < 3 AND nombreArchivo LIKE '%' :nombreBuscar '%'
                    OR
                    id_usuario=:id_usuario AND nombreArchivo LIKE '%' :nombreBuscar '%'
                    ORDER BY fecha DESC");
                    $consulta->bindParam(":nombreBuscar",$nombreBuscar);  
                    $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                    $consulta->execute();
                    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                }else{

                    $consulta = $conn->prepare("SELECT * FROM archivo 
                    WHERE nivelArchivo < 3 AND nombreArchivo LIKE '%' :nombreBuscar '%'
                    AND extension = :tipoBuscar
                    OR
                    id_usuario=:id_usuario AND nombreArchivo LIKE '%' :nombreBuscar '%'
                    AND extension = :tipoBuscar
                    ORDER BY fecha DESC");
                    $consulta->bindParam(":tipoBuscar",$tipoBuscar);  
                    $consulta->bindParam(":nombreBuscar",$nombreBuscar);  
                    $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
                    $consulta->execute();
                    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                }

            }         


        }
      

    }else{

        //Archivos por default limitado a 5 resultados en función de la fecha de carga más reciente

        if($nivelDelUsuario == 1){
            $consulta = $conn->prepare('SELECT * FROM archivo 
            WHERE id_usuario=:id_usuario
            ORDER BY fecha DESC LIMIT 5'); 
            $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
            $consulta->execute();
            $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);  

        }

        if($nivelDelUsuario == 2){
            $consulta = $conn->prepare('SELECT * FROM archivo 
            WHERE id_usuario=:id_usuario OR nivelArchivo = 1
            ORDER BY fecha DESC LIMIT 5'); 
            $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
            $consulta->execute();
            $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        if($nivelDelUsuario == 3){

            $consulta = $conn->prepare('SELECT * FROM archivo 
            WHERE nivelArchivo < 3 OR id_usuario=:id_usuario
            ORDER BY fecha DESC LIMIT 5'); 
            $consulta->bindParam(":id_usuario",$_SESSION['user_id']);  
            $consulta->execute();
            $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
            
        }

    }

 
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
        	<div class="col-4 ">
        		<strong>Usuario: </strong> <?php echo $nombreDelUsuario ?>
        		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        		<strong>Nivel: </strong> <?php echo $nivelDelUsuario ?>
        	</div>
            <div class="col-3 ">
                 <a class="text-decoration-none" href="busquedaAvanzada.php" target="_blank">Búsqueda Avanzada</a> 
            </div>
        	<div class="col-2 ">
        		 <a class="text-decoration-none" href="subirArchivo.php">Subir Archivo</a> 
        	</div>
            <div class="col-2">
                <a class="text-decoration-none" href="cerrarSesion.php">Cerrar Sesión</a>            
           </div>
        </div>
    </div>

    <!--Búsqueda sencilla-->
    <div class="container-fluid  my-3">

        <div class="row justify-content-center">

            <div class="col-10">
                
                <form action="espacioTrabajo.php" method="POST">
                    <div class="row">

                        <div class="col fs-5">
                            Búsqueda sencilla
                        </div>

                        <div class="col">
                            <select name="tipoArchivo" class="form-select form-select-sm">
                                <option value="">Extensión del archivo</option>
                                <option value="pdf">PDF</option>
                                <option value="txt">TXT</option>
                                <option value="docx">DOCX</option>   
                                <option value="todas">TODAS</option>   
                            </select>
                        </div>

                        <div class="col">
                            <input class="form-control form-control-sm" type="text" 
                            placeholder="Nombre del archivo" name="nombreBuscar">

                        </div>

                        <div class="col">
                            <input type="submit" value="Buscar archivo" class="btn btn-primary  btn-sm"
                                name="filtrar">
                        </div>

                    </div>
                </form>

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
    		<div class="col-11">

    			<table class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>Nombre del archivo</th>
                            <th>Extensión</th>
                            <th>Tamaño</th>
                            <th>Propietario</th>
                            <th>Nivel</th>
                            <th>Fecha de carga</th>
                            <th>Descargar</th>
                            <th>Analizar</th>
                            <th>Visualizar</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        
                        <?php foreach($resultados as $resultado){   ?>
                            <tr>
                                <?php if(true){ ?>
                                    <td>
                                        <?php echo $resultado['nombreArchivo'];?>
                                    </td>
                                    <td> 
                                        <?php echo $resultado['extension']; ?>
                                    </td>

                                    <td>

                                        <?php $tamano = $resultado['tamano']; ?>
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
                                        <?php $propietario;  ?>
                                        <?php $consulta = $conn->prepare('SELECT correo FROM usuario 
                                        WHERE id_usuario=:id_usuario'); ?>

                                        <?php $consulta->bindParam(':id_usuario',$resultado['id_usuario']
                                        ); ?>
                                        <?php $consulta->execute(); ?>
                                        <?php $res = $consulta->fetch(PDO::FETCH_ASSOC);?>
                                        <?php $propietario = $res['correo'];?>
                                        <?php echo $res['correo'];?>
                                        
                                    </td>

                                    <td>
                                        <div align="center">
                                            <?php echo $resultado['nivelArchivo']; ?>
                                        </div>
                                    </td>

                                    <td>
                                        <?php echo $resultado['fecha'];?>
                                    </td>


                                    <!--Descargar-->
                                    <td>
                                        <div align="center">
                                            <a href="<?php echo $resultado['ruta'];?>"
                                                class="btn btn-outline-primary btn-sm"
                                                role="button" download>
                                                Descargar
                                            </a>
                                        </div>
                                    </td>

                                    
                                    <!--Ver si se puede visualizar-->
                                    <?php $tipo = $resultado['extension'];?>
                                    <?php if($tipo == 'pdf' or $tipo == 'docx' or $tipo == 'txt'){ ?>
                                        <td>
                                            <form action="visualizar.php" method="POST" target="_blank">
                                                <input type="hidden" name="ruta" 
                                                    value="<?php echo $resultado['ruta']; ?>">
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
                                            <form action="analisis.php" method="POST" 
                                            target="_blank">

                                                <input type="hidden" name="ruta" 
                                                    value="<?php echo $resultado['ruta']; ?>"
                                                >

                                                <input type="hidden" name="extension" value="<?php echo 
                                                    $resultado['extension']; ?>">

                                                <input type="hidden" name="nombre" 
                                                    value="<?php echo $resultado['nombreArchivo']?>"
                                                > 

                                                 <input type="hidden" name="propietario" 
                                                    value="<?php echo $propietario;?>"
                                                > 
                                                    

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