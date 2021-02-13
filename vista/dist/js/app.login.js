// Scripts del modulo login

    function PasswordMostrar(){
        let cambio = document.getElementById("P_Password");
        if(cambio.type == "password"){
            cambio.type = "text";
            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        }else{
            cambio.type = "password";
            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
    }


    function PasswordMostrar(){
        let cambio = document.getElementById("P_Password");
        if(cambio.type == "password"){
            cambio.type = "text";
            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        }else{
            cambio.type = "password";
            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
    }


    SinEspacio=function(input){
    input.value=input.value.replace(' ','');}

	
    function soloLetras(e) {
        let key = e.keyCode || e.which,
        tecla = String.fromCharCode(key).toLowerCase(),
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
        especiales = [8, 37, 39, 46],
        tecla_especial = false;

        for (let i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
            return false;
        }
    }

    // Scripts de registro de usuario

  function mostrarPassword(){

    var nueva = document.getElementById("PassNuevo");
    if(nueva.type == "password"){
      nueva.type = "text";
      $('.icon_nuevo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }else{
      nueva.type = "password";
      $('.icon_nuevo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }

    var conf = document.getElementById("ConfPass");
    if(conf.type == "password"){
      conf.type = "text";
      $('.icon_conf').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }else{
      conf.type = "password";
      $('.icon_conf').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
  }

//Botones
/*var btnEnviar = document.getElementById("enviar");
var btnpreg1 = document.getElementById("preg1");
var btnpreg2 = document.getElementById("preg2");
var btnpreg3 = document.getElementById("preg3");
var btnpass = document.getElementById("pass");

//Inputs
var nombre = document.getElementById("nombre");
var preg1 = document.getElementById("pregunta1");
var preg2 = document.getElementById("pregunta2");
var preg3 = document.getElementById("pregunta3");*/

btnEnviar.disabled = true;
//apellido.disabled = true;

/*function verificar2(valor) {
  if (apellido.value.length>=4){
    btnEnviar.disabled = false;
    btnEnviar.classList.remove("disabled");
  } else {
      btnEnviar.disabled = true;
  }
}*/

/*function verificar(valor) {
  if (valor.length>=4){
  	apellido.style.background = "#FFFFFF";
    apellido.disabled = false
  } else {
    //caja2.style.background = "grey";
    apellido.disabled = true;
    apellido.value = "";
    btnEnviar.disabled = true;
  }
   
}*/
  
  var $tabs = $('.nav-tabs li');

$('#prevtab').on('click', function() {
       $tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
});

$('#nexttab').on('click', function() {
       $tabs.filter('.active').next('li').find('a[data-toggle="tab"]').tab('show');
});


    // Solo numero para TELEFONO

		window.addEventListener("load", function() {
		formulario.telefono.addEventListener("keypress", soloNumeros, false);
		});

		//Solo permite introducir numeros.
		function soloNumeros(e){
		var key = window.event ? e.which : e.keyCode;
		if (key < 48 || key > 57) {
			e.preventDefault();
		}
		}


	// Solo letras CAMPOS DE NOMBRE, APELLIDO y NOMBRE_USUARIO
	function soloLetras(e) {
		var key = e.keyCode || e.which,
		tecla = String.fromCharCode(key).toLowerCase(),
		letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
		especiales = [8, 37, 39, 46],
		tecla_especial = false;

		for (var i in especiales) {
		if (key == especiales[i]) {
			tecla_especial = true;
			break;
		}
		}

		if (letras.indexOf(tecla) == -1 && !tecla_especial) {
		return false;
		}
	}
	

	//Permitir solo un ESPACIO
		espacio_Letras=function(input){
		input.value=input.value.replace('  ',' ');}

		SinEspacio=function(input){
		input.value=input.value.replace(' ','');}


    //Script de olvide_contrasena

	function mostrarPassword(){
			var cambio = document.getElementById("PPassword");
			if(cambio.type == "password"){
				cambio.type = "text";
				$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				cambio.type = "password";
				$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}
		} 

	function mostrarPassword(){
			var cambio = document.getElementById("PPassword");
			if(cambio.type == "password"){
				cambio.type = "text";
				$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				cambio.type = "password";
				$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}
		} 

		SinEspacio=function(input){
		input.value=input.value.replace(' ','');}
	
	function soloLetras(e) {
		var key = e.keyCode || e.which,
		tecla = String.fromCharCode(key).toLowerCase(),
		letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
		especiales = [8, 37, 39, 46],
		tecla_especial = false;

		for (var i in especiales) {
		if (key == especiales[i]) {
			tecla_especial = true;
			break;
		}
		}

		if (letras.indexOf(tecla) == -1 && !tecla_especial) {
		return false;
		}
	}

    //Scripts de nueva_contrasena
		function m_Password(){
			let nuevaa = document.getElementById("PassNueva");
			if(nuevaa.type == "password"){
				nuevaa.type = "text";
				$('.icon_nuevo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				nuevaa.type = "password";
				$('.icon_nuevo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}

			let confi = document.getElementById("ConfPass");
			if(confi.type == "password"){
				confi.type = "text";
				$('.icon_conf').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				confi.type = "password";
				$('.icon_conf').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}
		}

		SinEspacio=function(input){
		input.value=input.value.replace(' ','');}

        
        //Scripts de recupregunta
    function mostrarPassword(){

      var nueva = document.getElementById("PassNuevo");
      if(nueva.type == "password"){
        nueva.type = "text";
        $('.icon_nuevo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
      }else{
        nueva.type = "password";
        $('.icon_nuevo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
      }

      var conf = document.getElementById("ConfPass");
      if(conf.type == "password"){
        conf.type = "text";
        $('.icon_conf').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
      }else{
        conf.type = "password";
        $('.icon_conf').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
      }
    }

//Botones
var btnEnviar = document.getElementById("enviar");
var btnpreg1 = document.getElementById("preg1");
var btnpreg2 = document.getElementById("preg2");
var btnpreg3 = document.getElementById("preg3");
var btnpass = document.getElementById("pass");

//Inputs
var nombre = document.getElementById("nombre");
//var apellido = document.getElementById("apellido");
var preg1 = document.getElementById("pregunta1");
var preg2 = document.getElementById("pregunta2");
var preg3 = document.getElementById("pregunta3");

btnEnviar.disabled = true;
apellido.disabled = true;

function verificar2(valor) {
  if (apellido.value.length>=4){
    btnEnviar.disabled = false;
    btnEnviar.classList.remove("disabled");
  } else {
      btnEnviar.disabled = true;
  }
}

function verificar(valor) {
  if (valor.length>=4){
  	apellido.style.background = "#FFFFFF";
    apellido.disabled = false
  } else {
    //caja2.style.background = "grey";
    apellido.disabled = true;
    apellido.value = "";
    btnEnviar.disabled = true;
  }
   
}

  var $tabs = $('.nav-tabs li');

$('#prevtab').on('click', function() {
       $tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
});

$('#nexttab').on('click', function() {
       $tabs.filter('.active').next('li').find('a[data-toggle="tab"]').tab('show');
});


//   Solo numero para TELEFONO
		window.addEventListener("load", function() {
		formulario.telefono.addEventListener("keypress", soloNumeros, false);
		});

		//Solo permite introducir numeros.
		function soloNumeros(e){
		var key = window.event ? e.which : e.keyCode;
		if (key < 48 || key > 57) {
			e.preventDefault();
		}
		}

	// Solo letras CAMPOS DE NOMBRE, APELLIDO y NOMBRE_USUARIO
	function soloLetras(e) {
		var key = e.keyCode || e.which,
		tecla = String.fromCharCode(key).toLowerCase(),
		letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
		especiales = [8, 37, 39, 46],
		tecla_especial = false;

		for (var i in especiales) {
		if (key == especiales[i]) {
			tecla_especial = true;
			break;
		}
		}

		if (letras.indexOf(tecla) == -1 && !tecla_especial) {
		return false;
		}
	}

	// Permitir solo un ESPACIO
		espacioLetras=function(input){
		input.value=input.value.replace('  ',' ');}

		SinEspacio=function(input){
		input.value=input.value.replace(' ','');}

        
    //Scripts de cambio_password
		function validar() {
		if ($('#PassActual').val().length == "") {
			alert('Ingrese rut');
			document.body.innerHTML = "<div class='alert alert-danger'>Error</div>";
			return false;
		}
		}

		function mostrarPassword(){
			var cambio = document.getElementById("PassActual");
			if(cambio.type == "password"){
				cambio.type = "text";
				$('.icon_actual').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				cambio.type = "password";
				$('.icon_actual').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}
		
			var nueva = document.getElementById("PassNueva");
			if(nueva.type == "password"){
				nueva.type = "text";
				$('.icon_nuevo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				nueva.type = "password";
				$('.icon_nuevo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}

			var conf = document.getElementById("ConfPass");
			if(conf.type == "password"){
				conf.type = "text";
				$('.icon_conf').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				conf.type = "password";
				$('.icon_conf').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}
		}

		SinEspacio=function(input){
		input.value=input.value.replace(' ','');}