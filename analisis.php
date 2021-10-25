<?php


 	//Metodo para iniciar sesion
    session_start();

 	//Requerir la conexion
 	include 'ConexionDB/conexion.php'; 

    //Requerir el lector de pdf
    include "vendor/autoload.php";
    

 	$ruta = $_POST['ruta'];
	
	$nombreArchivo = $_POST['nombre'];
	$extensionArchivo = $_POST['extension'];
	$nombrePropietario = $_POST['propietario'];

    //Para el analisis
    $numeroPalabras = 0;
    $numeroLineas = 0;
    $numeroCaracteres = 0;
    $numeroParrafos = 0;


    //Funciones auxiliares
    //##############################################################################################

    //Función para limpiar letras

    function eliminar_acentos($cadena){
        
        //Reemplazamos la A y a
        $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
        );
    
        //Reemplazamos la E y e
        $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena );
    
        //Reemplazamos la I y i
        $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena );
    
        //Reemplazamos la O y o
        $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena );
    
        //Reemplazamos la U y u
        $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena );
    
        //Reemplazamos C y c
        $cadena = str_replace(
        array('Ç', 'ç'),
        array('C', 'c'),
        $cadena
        );
        
        return $cadena;
    }

    //Alfabeto
    $letras = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','ñ','o','p','q','r','s','t',
        'u','v','w','x','y','z');


    //ANALIZAR TXT
    //##############################################################################################

    if($extensionArchivo == 'txt'){

        $actual = 0;
        $anterior = 0;

        //Lineas y parrafos

        foreach(file($ruta) as $linea) {
            $actual = strlen($linea);
            if($actual == 2 and $anterior > 2){
                $numeroParrafos = $numeroParrafos + 1;
            }

            if($actual > 2){
                $numeroLineas++;
            }
            $anterior = $actual;

        } 

        if($actual > 2 ){
            $numeroParrafos = $numeroParrafos + 1;
        }

        //Caracteres y palabras
        $texto = file_get_contents($ruta);
        $limpia = eliminar_acentos($texto);
        $minusculas = mb_strtolower($limpia, 'UTF-8');
        $arrayListo = str_split($minusculas);

        //for ($i=0; $i < count($arrayListo); $i++) { 
        //    echo $arrayListo[$i];
        //}
        
        //Número de caracteres
        $numeroCaracteres =  count($arrayListo);

        //Palabras
        $diccionario = array();
        $temp = "";

        $flag = false;
        for ($i=0; $i < count($arrayListo); $i++) { 
            if(in_array($arrayListo[$i], $letras)){
                //echo $arrayListo[$i].' -> Agregado</br>';
                $temp = $temp.$arrayListo[$i];
                $flag = true;
            }else{
    
                //Al menos contiene un caracter valido
    
                if($flag){
                    //echo "Recolectado: ".$temp.'</br>';
                    $flag = false;
                    $numeroPalabras = $numeroPalabras + 1;
                    //Agregamos la palbra 
    
                    //Primera vez
                    if(!isset($diccionario[$temp])){
                        $diccionario[$temp] = 1;
                    }else{
                        //Ya existe
                        $diccionario[$temp] = $diccionario[$temp] + 1;
                    }
    
                    $temp = "";
    
                }
                //echo $arrayListo[$i].'NOP </br>';
            }
        }

        //Palabra sobrante 
        if(strlen($temp)>0){
            //echo "Recolectado: ".$temp.'</br>';
            //Agregamos la palbra 
            $numeroPalabras = $numeroPalabras + 1;
            //Primera vez
            if(!isset($diccionario[$temp])){
                $diccionario[$temp] = 1;
            }else{
                //Ya existe
                $diccionario[$temp] = $diccionario[$temp] + 1;
            }
            $temp = "";
        }

        

        
    }

    //ANALIZAR PDF
    //##############################################################################################

    if($extensionArchivo == 'pdf'){

        //Caracteres y palabras
        $parseador = new \Smalot\PdfParser\Parser();
        $documentoPDF = $parseador->parseFile($ruta);
        $contenidoPDF = $documentoPDF->getText();
        $arrayPDF = str_split($contenidoPDF);

        //Carcateres
        $numeroCaracteres =  count($arrayPDF);

        //Palabras y recurrencia
        $pegado = implode($arrayPDF);
        $limpia = eliminar_acentos($pegado);
        $minusculas = mb_strtolower($limpia, 'UTF-8');
        $arrayListo = str_split($minusculas);

        //Palabras
        $diccionario = array();
        $temp = "";

        $flag = false;
        for ($i=0; $i < count($arrayListo); $i++) { 
            if(in_array($arrayListo[$i], $letras)){
                //echo $arrayListo[$i].' -> Agregado</br>';
                $temp = $temp.$arrayListo[$i];
                $flag = true;
            }else{
    
                //Al menos contiene un caracter valido
    
                if($flag){
                    //echo "Recolectado: ".$temp.'</br>';
                    $flag = false;
                    $numeroPalabras = $numeroPalabras + 1;
                    //Agregamos la palbra 
    
                    //Primera vez
                    if(!isset($diccionario[$temp])){
                        $diccionario[$temp] = 1;
                    }else{
                        //Ya existe
                        $diccionario[$temp] = $diccionario[$temp] + 1;
                    }
    
                    $temp = "";
    
                }
                //echo $arrayListo[$i].'NOP </br>';
            }
        }

        //Palabra sobrante 
        if(strlen($temp)>0){
            //echo "Recolectado: ".$temp.'</br>';
            //Agregamos la palbra 
            $numeroPalabras = $numeroPalabras + 1;
            //Primera vez
            if(!isset($diccionario[$temp])){
                $diccionario[$temp] = 1;
            }else{
                //Ya existe
                $diccionario[$temp] = $diccionario[$temp] + 1;
            }
            $temp = "";
        }

        
    }

    //ANALIZAR DOCX
    //##############################################################################################

    if($extensionArchivo == 'docx'){
        echo "Not Available";
    }

   

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
                            <th>Caracteres</th>
                            <th>Líneas</th>
                            <th>Parrafos</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        
                        <td>
                        	<?php echo $numeroPalabras;?>
                        </td>
                        
                        <td>
                        	<?php echo $numeroCaracteres;?>
                        </td>

                        <td>
                            <?php echo $numeroLineas;?>
                        </td>

                        <td>
                        	<?php echo $numeroParrafos;?>
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

                        <?php foreach ($diccionario as $key => $value) { ?>
                        
                            <tr>
    
                                <td>
                                    <?php echo $key; ?>
                                </td>
    
                                <td>
                                    <?php echo $value; ?>
                                </td>
    
                            </tr>
                        <?php } ?>

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