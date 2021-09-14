
function validarSesion(formulario){


	//Validar que el correo no este vacio

	var correo = formulario.correo;

	if(correo.value == ""){
		alert('El campo correo NO puede estar vacio');
		correo.focus();
		correo.select();
		return false;
	}

	//Validar forma del correo electronico

	if( correo.value != 'admin' ){
		
		var expReg= /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
	    var esValido = expReg.test(correo.value);

	    if(esValido == false){
	    	alert("Correo electronico NO valido");
	    	correo.focus();
	    	correo.select();
	    	return false;
	    }

	}

	

    //Validar que el campo contraseña no este vacio

    var password = formulario.password;

    if(password.value == ""){
    	alert('El campo contaseña NO puede estar vacio')
    	password.focus();
    	password.select();
    	return false;
    }


    //alert('Datos validados');
	return true;
}