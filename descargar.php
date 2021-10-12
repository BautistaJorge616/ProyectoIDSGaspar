<?php 

    //Metodo para iniciar sesion
    session_start();

    //Requerir la conexion
    include 'ConexionDB/conexion.php'; 

    $archivo = $_POST['ruta'];

    $path = 'archivos/usuarios/'.$_SESSION['user_id'].'/'.$archivo;
    

    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=".$archivo);
    readfile($path);

?>

