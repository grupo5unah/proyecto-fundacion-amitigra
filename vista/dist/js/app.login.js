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


	//MOSTRAR CONTRASENA PANTALLA CONFIGURACION PREGUNTA
	function contrasenaPreguntas(){
		let cambioPreguntas = document.querySelector("#PassRegistroPreguntas1");

		if(cambioPreguntas.type == "password"){
			cambioPreguntas.type = "text";
			$(".icon_pregunta").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
		} else {
			cambioPreguntas.type = "password";
			$(".icon_pregunta").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
		}


		let cambioPreguntas2 = document.querySelector("#PassRegistroPreguntas2");

		if(cambioPreguntas2.type == "password"){
			cambioPreguntas2.type = "text";
			$(".icon_pregunta").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
		} else {
			cambioPreguntas2.type = "password";
			$(".icon_pregunta").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
		}


		let cambioPreguntas3 = document.querySelector("#ConfPassPreguntas");

		if(cambioPreguntas3.type == "password"){
			cambioPreguntas3.type = "text";
			$(".icon_pregunta").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
		} else {
			cambioPreguntas3.type = "password";
			$(".icon_pregunta").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
		}
	}
	//FIN MOSTRAR CONTRASENA CONFIGURACION PREGUNTAS


	//Script mostrar contrasena COPIA DE SEGURIDAD

	function contrasenaCopia(){
		var cambioCopia = document.getElementById("contraCopia");
		if(cambioCopia.type == "password"){
			cambioCopia.type = "text";
			$('.icon_copia').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambioCopia.type = "password";
			$('.icon_copia').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	} 

	function contrasenaCopia(){
		var cambioCopia = document.getElementById("contraCopia");
		if(cambioCopia.type == "password"){
			cambioCopia.type = "text";
			$('.icon_copia').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambioCopia.type = "password";
			$('.icon_copia').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	}


    // Scripts de registro de usuario

  function VerPassword(){

    var nuevaRegistro = document.getElementById("PassRegistro");
    if(nuevaRegistro.type == "password"){
      nuevaRegistro.type = "text";
      $('.icons').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }else{
      nuevaRegistro.type = "password";
      $('.icons').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
	
    var conf = document.getElementById("ConfPassR");
    if(conf.type == "password"){
      conf.type = "text";
      $('.icons').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }else{
      conf.type = "password";
      $('.icons').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
  }


  //BLOQUEAR BOTON SI LOS CAMPOS ESTAN VACIOS (datos generales)
  let btnSiguiente1 = document.getElementById('enviar');
  let correo = document.getElementById('correo');
  let telefono = document.getElementById('telefono');

  btnSiguiente1.disabled = true;

  	telefono.addEventListener('keyup',function(){
		if(this.value.length > 7){
			console.log('esta funcionando');
			btnSiguiente1.disabled = false;

		}else{
			btnSiguiente1.disabled = true;
		}
	});

  //PREGUNTA 1
  let btnSiguiente2 = document.getElementById('nexttab');
  let pregunta1 = document.getElementById('preg1');

  btnSiguiente2.disabled = true;


  	pregunta1.addEventListener('keyup', function(){

	  	if(this.value.length > 2){  
		console.log('correcto');
		btnSiguiente2.disabled = false;
		$('#resp').hide();
	  	}else{
		btnSiguiente2.disabled = true;
		$('#resp').html('Se requiere una respuesta mayor a 2 caracteres');
		$('#resp').show();
	  	}
  	});
  

  //PREGUNTA 2
  let btnSiguiente3 = document.getElementById('nexttab2');
  let pregunta2 = document.getElementById('preg2');

  btnSiguiente3.disabled = true;


  	pregunta2.addEventListener('keyup', function(){

	  	if(this.value.length > 2){
		  
		  console.log('correcto');
		  btnSiguiente3.disabled = false;
		  $('#resp2').hide();
	  	}else{
		  btnSiguiente3.disabled = true;
		  $('#resp2').html('Se requiere una respuesta mayor a 2 caracteres');
		  $('#resp2').show();
	  	}
  	});


  //PREGUNTA 3
  let btnSiguiente4 = document.getElementById('nexttab3');
  let pregunta3 = document.getElementById('preg3');

  btnSiguiente4.disabled = true;


  	pregunta3.addEventListener('keyup', function(){

	  	if(this.value.length > 2){
		  
		  console.log('correcto');
		  btnSiguiente4.disabled = false;
		  $('#resp3').hide();
	  	}else{
		  btnSiguiente4.disabled = true;
		  $('#resp3').html('Se requiere una respuesta mayor a 2 caracteres');
		  $('#resp3').show();
	  	}
  	});

  //FIN BLOQUO DE BOTONES

  
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
		//espacioRegistro=function(input){
		//input.value=input.value.replace('  ',' ');}

	 	document.getElementById("nombre").addEventListener("keydown", teclear);

		var flag = false;
		var teclaAnterior = "";

		function teclear(event) {
			teclaAnterior = teclaAnterior + " " + event.keyCode;
			var arregloTA = teclaAnterior.split(" ");
			if (event.keyCode == 32 && arregloTA[arregloTA.length - 2] == 32) {
				event.preventDefault();
			}
		}


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
    function mostPassword(){

      var conf = document.getElementById("ConfPass3");
      if(conf.type == "password"){
        conf.type = "text";
        $('.icon_confi').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
      }else{
        conf.type = "password";
        $('.icon_confi').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
      }

	  var conf = document.getElementById("ConfPass3");
      if(conf.type == "password"){
        conf.type = "text";
        $('.icon_confi').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
      }else{
        conf.type = "password";
        $('.icon_confi').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
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