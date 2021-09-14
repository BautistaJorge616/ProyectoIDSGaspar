function validarNuevoPassword(formulario){

	//Validamos el password
    var password = formulario.password_1;
    var password2 = formulario.password_2;

     //Validamos si la cadena esta vacia
    if(password.value == "" ){
        alert("Debe proporcionar un password");
        //Lo enfocamos
        password.focus();
        //Lo seleccionamos
        password.select();
        //Para que se detenga la validacion
        return false;
    }

    //Validamos que ingrese un password de mas de 8 caracteres
    if(password.value.length < 8	){
    	alert('La contraseña debe tener al menos 8 caracteres');
    	return false;
    }

    //Validamos si las cadenas son iguales
    if(password.value != password2.value ){
        alert("Las contraseñas no coinciden");
        //Lo enfocamos
        password.focus();
        //Lo seleccionamos
        password.select();
        //Para que se detenga la validacion
        return false;
    }

    //Contraseñas validadas 
    return true;

}