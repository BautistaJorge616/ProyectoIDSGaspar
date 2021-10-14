<?php 

    //Metodo para iniciar sesion
    session_start();

    //Requerir la conexion
    include 'ConexionDB/conexion.php'; 

    //Mostrar errores generados al registrar un nuevo usuario
    $validacion = 0;

    if(!empty($_POST['tipoCuenta'])){
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellido'];
		$correo = $_POST['correo'];
		$password = "000";
		$password_encriptado = password_hash($password, PASSWORD_DEFAULT);
		$tipoCuenta = intval($_POST['tipoCuenta']);
        $activo = 1;
		
		//Verificar los repetidos (El correo tiene que se unico)

		//Crear una consulta de los datos
		$consulta = $conn->prepare('SELECT correo FROM usuario WHERE correo=:correo');
		//Hacer la consulta con los datos que recibi
		$consulta->bindParam(':correo',$correo);
		//Ejecutamos la consulta 
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

		if (!empty($resultado) && count($resultado) > 0) {
			$validacion = 1;
		}
		else{
			
			//Agregar el nuevo registro
			$consulta = $conn->prepare('INSERT INTO usuario (nombre, apellidos, correo, password, rol,activo)
				VALUES (:nombre, :apellidos, :correo, :password, :rol, :activo)');

			$consulta->bindParam(':nombre',$nombre);
			$consulta->bindParam(':apellidos', $apellidos);
			$consulta->bindParam(':correo',$correo);
			$consulta->bindParam(':password', $password_encriptado);
            $consulta->bindParam(':rol', $tipoCuenta);
			$consulta->bindParam(':activo', $activo);

			if ($consulta->execute()) {
     			//Y lo redireccionamos
				header("Status: 301 Moved Permanently");
				header("Location:adminVerUsuarios.php");
				echo"<script language='javascript'>window.location='adminVerUsuarios.php'</script>;";
				exit();
    		} 

		}
	}
  

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registro de usuarios</title>

  	<!--Validación con JavaScript-->
	<script type="text/javascript " src="validaciones/validarNuevoRegistro.js"></script>

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
                <strong>Usuario: </strong> <?php echo 'Administrador'; ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-2">
                 <a class="text-decoration-none" href="adminVerUsuarios.php">
                    Usuarios del sistema
                </a> 
            </div>
            <div class="col-3">
                <div class="container-fluid text-white">
                    <div class="row justify-content-end ">
                        <div class="col-6">
                            <a class="text-decoration-none" href="cerrarSesion.php">Cerrar Sesión</a>            
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>

     <!--Validación de errores al registrar un nuevo usuario-->
    <?php if ($validacion == 1){ ?>

        <!--Mensaje de error-->
        <div class="container-fluid bg-danger text-white">
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <h3>El correo que ingreso ya existe!  :(</h3>
                </div>
            </div>
        </div>

    <?php } ?>


     <!--Fomulario para registrar un nuevo usuario-->
    <div class="container-fluid my-5">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="container-md my-5">

                    <div class="card text-dark bg-light">
                        <div class="card-header">

                            <h4>Datos del nuevo usuario</h4>

                        </div>
                        <div class="card-body">

                            <form action="registrarUsuario.php" method="POST" 
                            		onsubmit="return validarNuevoRegistro(this);">

                            	<div class="mb-3">
                                    <input type="text" name="nombre" placeholder="Nombre(s)"  
                                    class="form-control" onfocus="this.select();">
                                </div>

                                 <div class="mb-3">
                                    <input type="text" name="apellido" placeholder="Apellidos"  
                                    class="form-control" onfocus="this.select();">
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="correo" placeholder="Correo electronico"  
                                    class="form-control" onfocus="this.select();">
                                </div>

                                <div class="mb-3">

                                	<select name="tipoCuenta" class="form-select">
       								    <option value="">Nivel del usuario</option>
       								    <option value="1">Nivel 1</option>
       								    <option value="2">Nivel 2</option>
       								    <option value="3">Nivel 3</option>   
       								</select>

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