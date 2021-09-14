function validarNuevoRegistro(formulario){


	//Validar nombre

	var nombre = formulario.nombre;

	if(nombre.value == ""){
		alert('El campo Nombre no puede estar vacio')
		nombre.focus();
		nombre.select();
		return false;
	}

	//Validar apellido
	var apellido = formulario.apellido;

	if(apellido.value == ""){
		alert('El campo Apellido no puede estar vacio');
		apellido.focus();
		apellido.select();
		return false;
	}

	//Validar correo

	var correo = formulario.correo;

	if(correo.value == ""){
		alert('El campo Correo electronico no puede estar vacio');
		correo.focus();
		correo.select();
		return false;
	}

	var expReg= /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    var esValido = expReg.test(correo.value);

    if(esValido == false){
    	alert("Correo electronico NO valido");
    	correo.focus();
    	correo.select();
    	return false;
    }
  

    //Validar que se seleccione un tipo de cuenta

    tipoCuenta = formulario.tipoCuenta;

    if(tipoCuenta.value == ""){
    	alert('Tiene que seleccionar un nivel para el registro');
		return false;
    }

    


	//Se valido el registro
	//alert('Datos validados!');

	return true;
}