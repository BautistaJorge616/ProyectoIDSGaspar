<?php 

    //Metodo para iniciar sesion
    session_start();

    //Requerir la conexion
    include 'ConexionDB/conexion.php';

    //Requerir el lector de pdf
    include "vendor/autoload.php";


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
            $consulta = $conn->prepare("SELECT * FROM archivo WHERE
                        id_usuario=:id_usuario AND extension='pdf'
                        OR
                        id_usuario=:id_usuario AND extension='txt'
                        OR
                        id_usuario=:id_usuario AND extension='docx'
                        OR
                        nivelArchivo=1 AND extension='pdf'
                        OR
                        nivelArchivo=1 AND extension='txt'
                        OR
                        nivelArchivo=1 AND extension='docx'
                        ");
            $consulta->bindParam(":id_usuario",$_SESSION['user_id']);   
            $consulta->execute();
            $archivos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        if($nivelDelUsuario == 3){
            $consulta = $conn->prepare("SELECT * FROM archivo WHERE
                        id_usuario=:id_usuario AND extension='pdf'
                        OR
                        id_usuario=:id_usuario AND extension='txt'
                        OR
                        id_usuario=:id_usuario AND extension='docx'
                        OR
                        nivelArchivo < 3 AND extension='pdf'
                        OR
                        nivelArchivo < 3 AND extension='txt'
                        OR
                        nivelArchivo < 3 AND extension='docx'
                        ");
            $consulta->bindParam(":id_usuario",$_SESSION['user_id']);   
            $consulta->execute();
            $archivos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        }

        //Analizar archivos recuperados
        $archivosMostrar = array();
        $numeroResultados = 0;

        //Cadena a buscar 
        $textoBuscar = $_POST['analizar'];

        //$archivosMostrar[$archivo['ruta']] = $numeroResultados;
        //$numeroResultados = $numeroResultados + 1;

        //Cuales cumplen las condiciones
        foreach($archivos as $archivo){
            $extArchActual = explode(".", $archivo['ruta'])[1];
            

            if($extArchActual == 'txt'){
                $archivoTxt = file_get_contents($archivo['ruta']);
                $pos = strpos($archivoTxt, $textoBuscar);
                if ($pos !== false) {
                    $archivosMostrar[$archivo['ruta']] = $numeroResultados;
                    $numeroResultados = $numeroResultados + 1;    
                }
            }

            if($extArchActual == 'pdf'){
                $parseador = new \Smalot\PdfParser\Parser();
                $documentoPDF = $parseador->parseFile($archivo['ruta']);
                $contenidoPDF = $documentoPDF->getText();

                $pos = strpos($contenidoPDF, $textoBuscar);
                if ($pos !== false) {
                    $archivosMostrar[$archivo['ruta']] = $numeroResultados;
                    $numeroResultados = $numeroResultados + 1;    
                }
            }

        }

        foreach ($archivosMostrar as $key => $value) {
            //echo $key." - ".$value."</br>"; 
        }



    }

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resultados</title>

  

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

                            <th>Tú búsqueda</th>
                            <th>Número de coincidencias</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        
                        <td>
                            <?php echo $_POST['analizar']; ?>
                        </td>
                        
                        <td>
                            <?php echo $numeroResultados; ?> 
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
            <div class="col-8">
                <h1 class="display-5 text-info" >Documentos con coincidencias</h1>

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
                            <th>Fecha de carga</th>
                            <th>Descargar</th>
                            <th>Analizar</th>
                            <th>Visualizar</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        
                        <?php foreach($archivosMostrar as $key => $value){   ?>

                            <?php $consulta = $conn->prepare('SELECT * FROM archivo 
                                WHERE ruta=:ruta'); ?>
                            <?php 
                            $consulta->bindParam(':ruta',$key); 
                            ?>
                            <?php $consulta->execute(); ?>
                            <?php $resultado = $consulta->fetch(PDO::FETCH_ASSOC);?>

                            <tr>
                                
                                <td>
                                    <?php echo $resultado['nombreArchivo'];?>
                                </td>

                                <td>
                                    <?php echo $resultado['extension']; ?>
                                </td>

                                <td>
                                    <?php echo $resultado['fecha']; ?>
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

                                <!--Ver si se puede analizar-->
                                <?php $consulta = $conn->prepare('SELECT * FROM usuario 
                                WHERE id_usuario=:id_usuario'); ?>
                                <?php 
                                $consulta->bindParam(':id_usuario',$resultado['id_usuario']); 
                                ?>
                                <?php $consulta->execute(); ?>
                                <?php $res = $consulta->fetch(PDO::FETCH_ASSOC);?>
                                <?php $propietario = $res['correo'];?>

                                <td>
                                    <form action="analisis.php" method="POST" 
                                            target="_blank">

                                        <input type="hidden" name="ruta" 
                                                value="<?php echo $resultado['ruta']; ?>">

                                        <input type="hidden" name="extension" value="<?php echo 
                                                $resultado['extension']; ?>">

                                        <input type="hidden" name="nombre" 
                                                value="<?php echo $resultado['nombreArchivo']?>"> 

                                        <input type="hidden" name="propietario" 
                                                value="<?php echo $propietario;?>"> 
                                                    

                                        <div align="center" >
                                            <input type="submit" name="analizar" value="Analizar"  class="btn btn-outline-primary btn-sm">
                                        </div>
                                    </form>
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