
<?php

	//Pasos para cerrar sesion
	
	//Iniciamos la sesion
	session_start();

	//Quitar la sesion
	session_unset();

	//Destruir la sesion
	session_destroy();

	//Redirigimos al usuario a la pagina principal
	//Y lo redireccionamos
	header("Status: 301 Moved Permanently");
	header("Location:index.php");
	echo"<script language='javascript'>window.location='index.php'</script>;";
	exit();

?>