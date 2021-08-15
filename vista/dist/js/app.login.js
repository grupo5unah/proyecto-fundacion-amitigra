//SCRIPT MOSTRAR CONTRASENA PARAMETROS SEGURIDAD
function mostrarPassSeguridad(){

	let cambioSeguridad = document.querySelector("#contrasenaSeguridad");
	if(cambioSeguridad.type == "password"){
		cambioSeguridad.type ="text";
		$(".icon_seguridad").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
	}else{
		cambioSeguridad.type = "password"
		$(".icon_seguridad").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
	}
}

//SCRIPT MOSTRAR CONTRASENA EN CAMBIO DE CONTRASENA EN PERFIL
function mostrarPasswordNueva(){
                      
	var actual = document.getElementById("passActual");
	if(actual.type == "password"){
	  actual.type = "text";
	  $('.icon_p_actual').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
	}else{
	  actual.type = "password";
	  $('.icon_p_actual').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
	}

	var nueva = document.getElementById("passNueva");
	if(nueva.type == "password"){
	  nueva.type = "text";
	  $('.icon_p_actual').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
	}else{
	  nueva.type = "password";
	  $('.icon_p_actual').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
	}

	var conf = document.getElementById("passConfirmar");
	if(conf.type == "password"){
	  conf.type = "text";
	  $('.icon_p_actual').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
	}else{
	  conf.type = "password";
	  $('.icon_p_actual').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
	}
  }


  //SCRIPT DE RECUPERACIÓN POR PREGUNTA:
 //SCRIPT MOSTRAR CONTRASENA RECUPERACION POR PREGUNTA
function mostrarPassPregunta(){
	
	let cambioPregunta = document.querySelector("#PassPregunta");

	if(cambioPregunta.type == "password"){
		cambioPregunta.type = "text";
		$(".icon_pregunta").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
	}else{
		cambioPregunta.type = "password";
		$(".icon_pregunta").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
	}

	let cambioPregungaConfirmacion = document.querySelector("#ConfPassPregunta");

	if(cambioPregungaConfirmacion.type == "password"){
		cambioPregungaConfirmacion.type = "text";
		$(".icon_pregunta").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
	}else{
		cambioPregungaConfirmacion.type = "password";
		$(".icon_pregunta").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
	}

}


//FIN SCRIPT DE RECUPERACIÓN DE CONTRASEÑA POR PREGUNTA




//SCRIPT MOSTRAR CONTRASENA PARAMETROS CORREO
function mostrarPassCorreo(){
	let cambioCorreo = document.querySelector("#contrasenaCorreo");

	if(cambioCorreo.type == "password"){
		cambioCorreo.type = "text"
		$(".icon_correo").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
	}else{
		cambioCorreo.type = "password";
		$(".icon_correo").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
	}
}

//SCRIPT MOSTRAR CONTRASENA PARAMETROS BD
function mostrarPassBD(){
	
	let cambioBD = document.querySelector("#contrasenaBD")
	
	if(cambioBD.type == "password"){
		cambioBD.type = "text";
		$(".icon_bd").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
	}else{
		cambioBD.type = "password"
		$(".icon_bd").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
	}
}


//SCRIPT MOSTRAR CONTRASENA REGISTRO DE GESTION DE USUARIOS
function VerPasswordGU(){
	var nuevaRegistro = document.getElementById("Contraseña");
	if(nuevaRegistro.type == "password"){
	  nuevaRegistro.type = "text";
	  $('.icons').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
	}else{
	  nuevaRegistro.type = "password";
	  $('.icons').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
	}
	  
	var conf = document.getElementById("ConfirmarContraseña");
	if(conf.type == "password"){
	  conf.type = "text";
	  $('.icons').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
	}else{
	  conf.type = "password";
	  $('.icons').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
	}
  }

  //SCRIPT MOSTRAR CONTRASENA RESETEO DE CONTRASEñA
function VerPasswordRC(){
	var nuevaRegistro = document.getElementById("Contraseña_reset");
	if(nuevaRegistro.type == "password"){
	  nuevaRegistro.type = "text";
	  $('.icons').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
	}else{
	  nuevaRegistro.type = "password";
	  $('.icons').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
	}
	  
	var conf = document.getElementById("ConfirmarContraseña_reset");
	if(conf.type == "password"){
	  conf.type = "text";
	  $('.icons').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
	}else{
	  conf.type = "password";
	  $('.icons').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
	}
  }


//SCRIPT MOSTRAR CONTRASENA PARAMETROS SISTEMA
function mostrarPassSistema(){

	let cambioSistema = document.querySelector("#contrasenaSistema");

	if(cambioSistema.type == "password"){
		cambioSistema.type ="text";
		$(".icon_sistema").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
	} else{
		cambioSistema.type = "password";
		$(".icon_sistema").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
	}
}

//SCRIPT MOSTRAR LA CONTRASENA ADMINISTRADOR
function mostrarPassSistemaParam(){
	 
	let cambioSistemaPass = document.querySelector("#contrasenaAdministrador");

	if(cambioSistemaPass.type == "password"){
		cambioSistemaPass.type = "text";
		$(".icon_PassSistema").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
	}else{
		cambioSistemaPass.type = "password";
		$(".icon_PassSistema").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
	}
}

//SCRIPT MOSTRAR LA CONTRASENA DEL CORREO
function mostrarPassCorreoParam(){
	 
	let cambioCorreoPass = document.querySelector("#contrasenaCorreo");

	if(cambioCorreoPass.type == "password"){
		cambioCorreoPass.type = "text";
		$(".icon_PassCorreo").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
	}else{
		cambioCorreoPass.type = "password";
		$(".icon_PassCorreo").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
	}
}


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

	let usuario_login = document.querySelector("#usuario");

	usuario_login.addEventListener('input',function(){
		if (this.value.length > 15)
			this.value = this.value.slice(0,15); 
	});


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

	//CONFIGURACION CAMPOS CONTRASEÑA Y PREGUNTAS
	/*let btnRegistroPreguntas = document.querySelector("#");
	let contraPrguntas = document.querySelector("#");
	let contraConfPreguntas = document.querySelector("#");

	//CONTRASEÑA
	btnRegistroPreguntas.disabled = true
  	contraConfPreguntas.disabled = true

  	contraPrguntas.addEventListener('keyup', function (){
	  	if(this.value.length < 0 || this.value.length > 7){
		  contraConfPreguntas.disabled = false;
		  $("#resp4").hide();

		  	if(contraConfPreguntas.length == 0){
				btnRegistroPreguntas.disabled = false;
		  	} else {
				  btnRegistroPreguntas.disabled = true;
			  }

		  	contraConfPreguntas.addEventListener('keyup', function(){
			  	if(this.value.length < 2 || this.value.length > 7){
				  	//btnRegistro.disabled = false
				  	$("#resp4").hide();

				  	if(contraPrguntas.value == contraConfPreguntas.value){
						btnRegistroPreguntas.disabled = false

						const contrasena_valida_preg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;
						  if(contrasena_valida_preg.test(contraConfPreguntas.value)){
							  btnRegistroPreguntas.disabled = false;
						  } else {
							  btnRegistroPreguntas.disabled = true;
							$("#resp4").html("No cumple");
							$("#resp4").show();

						  }

				  	} else {
						btnRegistroPreguntas.disabled = true;
						$("#resp4").html('Las contraseñas no coinciden');
				  		$("#resp4").show();
					}
				}else {
				  btnRegistroPreguntas.disabled = true

				  $("#resp4").html('La contraseña es débil, debe estar formada entre 8-16 carácteres.');
				  $("#resp4").show();


			  	}
		  	})

	  	} else {
		  btnRegistroPreguntas.disabled = true
		  contraConfPreguntas.disabled = true
		  $("#resp4").html('La contrasena es débil, debe estar formada entre 8-16 carácteres');
		  $("#resp4").show();

	  	}
  	});*/

	  //PREGUNTAS
	  //PREGUNTA 1
	  /*let btnSiguienteP1 = document.querySelector('#nexttab');
	  let respuesta_1 = document.querySelector('#preg_1');
	  let preg_1 = document.querySelector('#id_pregunta_1')
	  
	  btnSiguienteP1.disabled = true;
	  respuesta_1.disabled = true;

		preg_1.addEventListener('change',function (e) {
			if($(this).val() != 'preg_select'){
				respuesta_1.disabled = false

				respuesta_1.addEventListener('keyup', function(){
					if(this.value.length > 2){
						btnSiguienteP1.disabled = false;
						$('#resp').hide();
					} else {
						btnSiguienteP1.disabled = true;
						$('#resp').html('Se requiere una respuesta mayor a 2 caracteres');
						$('#resp').show();
					}
				});

			} else {
				btnSiguienteP1.disabled = true;
				respuesta_1.disabled = true;
			}
		});*/


		//PREGUNTA 2
		/*let btnSiguienteP2 = document.querySelector('#nexttab');
		let respuesta_2 = document.querySelector('#preg_1');
		let preg_2 = document.querySelector('#id_pregunta_1')
		
		btnSiguienteP2.disabled = true;
		respuesta_2.disabled = true;
  
		preg_2.addEventListener('change',function (e) {
			if($(this).val() != 'preg_select'){
				respuesta_2.disabled = false
  
				respuesta_2.addEventListener('keyup', function(){
					if(this.value.length > 2){
						btnSiguienteP2.disabled = false;
						$('#resp').hide();
					} else {
						btnSiguienteP2.disabled = true;
						$('#resp').html('Se requiere una respuesta mayor a 2 caracteres');
						$('#resp').show();
					}
				});
  
			} else {
				btnSiguienteP2.disabled = true;
				respuesta_2.disabled = true;
			}
		});*/


		//PREGUNTA 3
	  	/*let btnSiguienteP3 = document.querySelector('#nexttab');
	  	let respuesta_3 = document.querySelector('#preg_1');
	  	let preg_3 = document.querySelector('#id_pregunta_1')
	  
	  	btnSiguienteP3.disabled = true;
	  	respuesta_3.disabled = true;

		preg_3.addEventListener('change',function (e) {
			if($(this).val() != 'preg_select'){
				respuesta_3.disabled = false

				respuesta_3.addEventListener('keyup', function(){
					if(this.value.length > 2){
						btnSiguienteP3.disabled = false;
						$('#resp').hide();
					} else {
						btnSiguienteP3.disabled = true;
						$('#resp').html('Se requiere una respuesta mayor a 2 caracteres');
						$('#resp').show();
					}
				});

			} else {
				btnSiguienteP3.disabled = true;
				respuesta_3.disabled = true;
			}
		});*/

	//FIN CONFIGURACIÓN


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

	//Script mostrar contrasena RESPALDO DE BD

	function contraRestauracion(){
		var cambioCopia = document.getElementById("contraRestauracion");
		if(cambioCopia.type == "password"){
			cambioCopia.type = "text";
			$('.icon_contraRest').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambioCopia.type = "password";
			$('.icon_contraRest').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	} 

	function contraRestauracion(){
		var cambioCopia = document.getElementById("contraRestauracion");
		if(cambioCopia.type == "password"){
			cambioCopia.type = "text";
			$('.icon_contraRest').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambioCopia.type = "password";
			$('.icon_contraRest').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
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


  /*$(".sel").each(function(){
	  $(this).data('original', $(this).html());
  });
  $(document).on('change','.sel', function(){
	  $('.sel').each(function(){
		  var valor = $(this).val();
		  $(this).html($(this).data('original'));
		  $(this).val(valor);
	  });

	  $('.sel').each(function(){
		  $(this).siblings().find('option[value="'+$(this).val()+'"]').remove();
	  })
  })*/


  $(document).on('change','.sel',function(){
	$(this).siblings().find('option[value="'+$(this).val()+'"]').remove();
  });


  /*$(document).on('change','.sel',function(){

	if($(this).hasClass('uno')){
		$(this).siblings().find('option[value]').removeAttr('disabled')
			$(this).siblings().find('option[value="'+$(this).val()+'"]').attr('disabled', true);
	}
	if($(this).hasClass('dos')){
			
		$('.tres option[value]').removeAttr('disabled');
		$('.tres option[value="'+$('.uno').val()+'"]').attr('disabled', true);
		$('.tres option[value="'+$('.dos').val()+'"]').attr('disabled', true);
	   
	}
	
  });*/



  //BLOQUEAR BOTON SI LOS CAMPOS ESTAN VACIOS (datos generales)
  let btnSiguiente1 = document.querySelector('#enviar');
  let usuario = document.querySelector("#usuario");
  let nombre = document.querySelector("#nombre");
  let correo = document.querySelector('#correo');
  let telefono = document.querySelector('#telefono');

  btnSiguiente1.disabled = true;
  $("#notificacion").hide();
  
  	nombre.addEventListener('keyup',function(){
		if(this.value.length === 7){
			usuario.disabled = false;

			usuario.addEventListener('keyup', function(){
				if(this.value.length === 5){
					$("#notificacion").hide();
					
					correo.disabled = false;

					correo.addEventListener('keyup', function(){
						if(this.value.length >= 7){
							telefono.disabled = false;

							//EXPRESIONES REGULARES
							const correo_valido = /^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{1,4}$/im;
							
								if(correo_valido.test(correo.value)){
									//$("#notificacion2").html("Correo valido");
									$("#notificacion2").hide();
								} else {
									$("#notificacion2").html("Correo invalido");
									$("#notificacion2").show();
								}

							telefono.addEventListener('keyup', function(){
								if(this.value.length > 7){
									btnSiguiente1.disabled = false;
									
								} else {
									btnSiguiente1.disabled = true;
								}
							});
							
						} else {

							btnSiguiente1.disabled = true;
							
						}
					});
					
				} else {
					if(this.value.length >= 2 && this.value.length < 5){
						$("#notificacion").html("Solo se admiten nombres de usuario de cinco caracteres");
					$("#notificacion").show();
					
					}
					
					btnSiguiente1.disabled = true;
				}
			});

		} else {
			btnSiguiente1.disabled = true;
			telefono.value = '';
		}
	});


  //PREGUNTA 1
  let btnSiguiente2 = document.querySelector('#nexttab');
  let pregunta1 = document.querySelector('#preg1');
  let preg = document.querySelector('#id_pregunta1')

  btnSiguiente2.disabled = true;
  pregunta1.disabled = true;

	preg.addEventListener('change',function (e) {
		if($(this).val() != 'preg_select'){
			pregunta1.disabled = false

			pregunta1.addEventListener('keyup', function(){
				if(this.value.length > 2){
					btnSiguiente2.disabled = false;
					$('#resp').hide();
				} else {
					btnSiguiente2.disabled = true;
					$('#resp').html('Se requiere una respuesta mayor a 2 caracteres');
					$('#resp').show();
				}
			});

		} else {
			btnSiguiente2.disabled = true;
			pregunta1.disabled = true;
		}
	})


  //PREGUNTA 2
  let btnSiguiente3 = document.querySelector('#nexttab2');
  let pregunta2 = document.querySelector('#preg2');
  let preg2 = document.querySelector("#id_pregunta2");

  btnSiguiente3.disabled = true;
  pregunta2.disabled = true;

	preg2.addEventListener('change',function (e) {
		if($(this).val() != 'preg_select2'){
			pregunta2.disabled = false

			pregunta2.addEventListener('keyup', function(){
				if(this.value.length > 2){
					btnSiguiente3.disabled = false;
					$('#resp2').hide();
				} else {
					btnSiguiente3.disabled = true;
					$('#resp2').html('Se requiere una respuesta mayor a 2 caracteres');
					$('#resp2').show();
				}
			});

		} else {
			btnSiguiente3.disabled = true;
			pregunta2.disabled = true;
		}
	})


  //PREGUNTA 3
  let btnSiguiente4 = document.querySelector('#nexttab3');
  let pregunta3 = document.querySelector('#preg3');
  let preg3 = document.querySelector("#id_pregunta3");

  btnSiguiente4.disabled = true;
  pregunta3.disabled = true;

	preg3.addEventListener('change',function (e) {
		if($(this).val() != 'preg_select3'){
			pregunta3.disabled = false

			pregunta3.addEventListener('keyup', function(){
				if(this.value.length > 2){
					btnSiguiente4.disabled = false;
					$('#resp3').hide();
				} else {
					btnSiguiente4.disabled = true;
					$('#resp3').html('Se requiere una respuesta mayor a 2 caracteres');
					$('#resp3').show();
				}
			});

		} else {
			btnSiguiente4.disabled = true;
			pregunta3.disabled = true;
		}
	})

  //FIN BLOQUO DE BOTONES


  ///////////////////////////////////////////////////////////////
  /////    QUITAR PREGUNTA SELECCIONADA EN SIGUIENTE TAB   /////
  /////////////////////////////////////////////////////////////

	


  //CONTRASENA REGISTRO DE USUARIO

  let btnRegistro = document.querySelector("#btnRegistro")
  let nuevaRegistro_reg = document.querySelector("#PassRegistro");
  let conf_reg = document.querySelector("#ConfPassR");

  btnRegistro.disabled = true
  conf_reg.disabled = true

  	nuevaRegistro_reg.addEventListener('keyup', function (){
	  	if(this.value.length < 0 || this.value.length > 7){
		  conf_reg.disabled = false;
		  $("#resp4").hide();

		  	if(conf_reg.length == 0){
				btnRegistro.disabled = false;
		  	} else {
				  btnRegistro.disabled = true;
			  }

		  	conf_reg.addEventListener('keyup', function(){
			  	if(this.value.length < 2 || this.value.length > 7){
				  	//btnRegistro.disabled = false
				  	$("#resp4").hide();

				  	if(nuevaRegistro_reg.value == conf_reg.value){
						btnRegistro.disabled = false

						const contrasena_valida = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;
						  if(contrasena_valida.test(conf_reg.value)){
							  btnRegistro.disabled = false;
						  } else {
							  btnRegistro.disabled = true;
							$("#resp4").html("No cumple");
							$("#resp4").show();

						  }

				  	} else {
						btnRegistro.disabled = true;
						$("#resp4").html('Las contraseñas no coinciden');
				  		$("#resp4").show();
					}
				}else {
				  btnRegistro.disabled = true

				  $("#resp4").html('La contraseña es débil, debe estar formada entre 8-16 carácteres.');
				  $("#resp4").show();


			  	}
		  	})

	  	} else {
		  btnRegistro.disabled = true
		  conf_reg.disabled = true
		  $("#resp4").html('La contrasena es débil, debe estar formada entre 8-16 carácteres');
		  $("#resp4").show();

	  	}
  	});

  //FIN CONTRASENA

  //LOGITUD DE LOS CAMPOS DE TEXTO
  
  	nombre.addEventListener('input',function(){
	if (this.value.length > 40) 
   		this.value = this.value.slice(0,40); 
	});
 
  	usuario.addEventListener('input',function(){
	if (this.value.length > 15) 
   		this.value = this.value.slice(0,15); 
	});

	correo.addEventListener('input',function(){
		if (this.value.length > 30)
			this.value = this.value.slice(0,30); 
	});

	pregunta1.addEventListener('input',function(){
		if (this.value.length > 15)
			this.value = this.value.slice(0,15); 
	});

	pregunta2.addEventListener('input',function(){
		if (this.value.length > 15)
			this.value = this.value.slice(0,15); 
	});

	pregunta3.addEventListener('input',function(){
		if (this.value.length > 15)
			this.value = this.value.slice(0,15); 
	});

	//FIN LONGITUD CAMPOS DE TEXTO

  
  	var $tabs = $('.nav-tabs li');

	$('#prevtab').on('click', function() {
		$tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
	});

	$('#nexttab').on('click', function() {
		$tabs.filter('.active').next('li').find('a[data-toggle="tab"]').tab('show');
	});

	//PARA TELEFONO

	let num_telefono = document.querySelector("#telefono");

	num_telefono.addEventListener("keypress", (e) => {
		
		var key = window.event ? e.which : e.keyCode;
		if (key < 48 || key > 57) {
			e.preventDefault();
		}
		
		/*e.preventDefault();
		let assi = e.keyCode;
		let valor = String.fromCharCode(assi);
		let tel = parseInt(valor);

		if(tel){
			num_telefono.value += tel;
		}*/
	})


		num_telefono.addEventListener('input',function(){
  			if (this.value.length > 8) 
     		this.value = this.value.slice(0,8); 
		})


	//FIN PARA TELEFONO

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
			let nuevaa = document.getElementById("InputNuevaContrasena");
			if(nuevaa.type == "password"){
				nuevaa.type = "text";
				$('.icon_conf').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				nuevaa.type = "password";
				$('.icon_conf').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}

			let confi = document.getElementById("InputConfirmarNuevaContrasena");
			if(confi.type == "password"){
				confi.type = "text";
				$('.icon_conf').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				confi.type = "password";
				$('.icon_conf').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}
		}

		//NUEVA CONTRASEÑA (POR CORREO)

		/*let btnNuevaContra = document.querySelector("#");
		let nuevaContrasena = document.querySelector("#");
		let confNuevaContrasena = document.querySelector("#");

		btnNuevaContra.disabled = true
  		confNuevaContrasena.disabled = true

			nuevaContrasena.addEventListener('keyup', function (){
				if(this.value.length < 0 || this.value.length > 7){
					confNuevaContrasena.disabled = false;
					$("#resp4").hide();

						if(confNuevaContrasena.length == 0){
							btnNuevaContra.disabled = false;
						} else {
							btnNuevaContra.disabled = true;
						}

						confNuevaContrasena.addEventListener('keyup', function(){
							if(this.value.length < 2 || this.value.length > 7){
								//btnRegistro.disabled = false
								$("#resp4").hide();

								if(nuevaContrasena.value == confNuevaContrasena.value){
									btnNuevaContra.disabled = false

									const contrasenaValida = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;
									if(contrasenaValida.test(confNuevaContrasena.value)){
									btnNuevaContra.disabled = false;
								} else {
									btnNuevaContra.disabled = true;
									$("#resp4").html("No cumple");
									$("#resp4").show();

								}

							} else {
								btnNuevaContra.disabled = true;
								$("#resp4").html('Las contraseñas no coinciden');
								$("#resp4").show();
							}
						} else {
						btnNuevaContra.disabled = true

						$("#resp4").html('La contraseña es débil, debe estar formada entre 8-16 carácteres.');
						$("#resp4").show();

						}
					})

				} else {
				btnNuevaContra.disabled = true
				confNuevaContrasena.disabled = true
				$("#resp4").html('La contrasena es débil, debe estar formada entre 8-16 carácteres');
				$("#resp4").show();

				}
			});*/



	//FIN SCRIPT DE NUEVA CONTRASEÑA


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