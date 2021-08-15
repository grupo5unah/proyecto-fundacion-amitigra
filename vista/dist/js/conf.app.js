//PREGUNTA 1
let btnSiguiente_p1 = document.querySelector('#nexttab_re');
let respuesta_p1 = document.querySelector('#respuestaUsuario');
let preg_p1 = document.querySelector('#id_pregunta_re');

btnSiguiente_p1.disabled = true;
respuesta_p1.disabled = true;

  preg_p1.addEventListener('change',function (e) {
	  if($(this).val() != 'preg_seleccion'){
		  respuesta_p1.disabled = false

		  respuesta_p1.addEventListener('keyup', function(){
			  if(this.value.length > 2){
				  btnSiguiente_p1.disabled = false;
				  $('#resp_re').hide();
			  } else {
				  btnSiguiente_p1.disabled = true;
				  $('#resp_re').html('Se requiere una respuesta mayor a 2 caracteres');
				  $('#resp_re').show();
			  }
		  });

	  } else {
		  btnSiguiente_p1.disabled = true;
		  respuesta_p1.disabled = true;
	  }
  });



  //CONTRASEÑA

  let btnRegistro_p1 = document.querySelector("#confirmarCambio");
  let nuevaContrasena_p1 = document.querySelector("#PassPregunta");
  let confContrasena_p1 = document.querySelector("#ConfPassPregunta");

  btnRegistro_p1.disabled = true
  confContrasena_p1.disabled = true

  	nuevaContrasena_p1.addEventListener('keyup', function (){
	  	if(this.value.length < 0 || this.value.length > 7){
		  confContrasena_p1.disabled = false;
		  $("#resp1_re").hide();

		  	if(confContrasena_p1.length == 0){
				btnRegistro_p1.disabled = false;
		  	} else {
				  btnRegistro_p1.disabled = true;
			  }

		  	confContrasena_p1.addEventListener('keyup', function(){
			  	if(this.value.length < 2 || this.value.length > 7){
				  	//btnRegistro.disabled = false
				  	$("#resp1_re").hide();

				  	if(nuevaContrasena_p1.value == confContrasena_p1.value){
						btnRegistro_p1.disabled = false

						const contrasena_valida_p1 = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;
						  if(contrasena_valida_p1.test(confContrasena_p1.value)){
							  btnRegistro_p1.disabled = false;
						  } else {
							  btnRegistro_p1.disabled = true;
							$("#resp1_re").html("No cumple");
							$("#resp1_re").show();

						  }

				  	} else {
						btnRegistro_p1.disabled = true;
						$("#resp1_re").html('Las contraseñas no coinciden');
				  		$("#resp1_re").show();
					}
				}else {
				  btnRegistro_p1.disabled = true

				  $("#resp1_re").html('La contraseña es débil, debe estar formada entre 8-16 carácteres.');
				  $("#resp1_re").show();


			  	}
		  	})

	  	} else {
		  btnRegistro_p1.disabled = true
		  confContrasena_p1.disabled = true
		  $("#resp1_re").html('La contrasena es débil, debe estar formada entre 8-16 carácteres');
		  $("#resp1_re").show();

	  	}
  	});

  //FIN CONTRASEÑA



  //CONTRASEÑA POR CORREO ELECTRONICO
  let btnActualizar = document.querySelector("#NuevaContraseña");
  let nuevaContrasena_p2 = document.querySelector("#InputNuevaContrasena");
  let confContrasena_p2 = document.querySelector("#InputConfirmarNuevaContrasena");

  btnActualizar.disabled = true
  confContrasena_p2.disabled = true

  	nuevaContrasena_p2.addEventListener('keyup', function (){
	  	if(this.value.length < 0 || this.value.length > 7){
		  confContrasena_p2.disabled = false;
		  $("#resp_correo").hide();

		  	if(confContrasena_p2.length == 0){
				btnActualizar.disabled = false;
		  	} else {
				  btnActualizar.disabled = true;
			  }

		  	confContrasena_p2.addEventListener('keyup', function(){
			  	if(this.value.length < 2 || this.value.length > 7){
				  	//btnRegistro.disabled = false
				  	$("#resp_correo").hide();

				  	if(nuevaContrasena_p2.value == confContrasena_p2.value){
						btnActualizar.disabled = false

						const contrasena_valida_p2 = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;
						  if(contrasena_valida_p2.test(confContrasena_p2.value)){
							  btnActualizar.disabled = false;
						  } else {
							  btnActualizar.disabled = true;
							$("#resp_correo").html("No cumple");
							$("#resp_correo").show();

						  }

				  	} else {
						btnActualizar.disabled = true;
						$("#resp_correo").html('Las contraseñas no coinciden');
				  		$("#resp_correo").show();
					}
				}else {
				  btnActualizar.disabled = true

				  $("#resp_correo").html('La contraseña es débil, debe estar formada entre 8-16 carácteres.');
				  $("#resp_correo").show();


			  	}
		  	})

	  	} else {
		  btnActualizar.disabled = true
		  confContrasena_p2.disabled = true
		  $("#resp_correo").html('La contrasena es débil, debe estar formada entre 8-16 carácteres');
		  $("#resp_correo").show();

	  	}
  	});




//PREGUNTA_1
let btnSiguiente_p2 = document.querySelector('#nexttab1');
let respuesta_p2 = document.querySelector('#respuestaIni1');
let preg_p2 = document.querySelector('#id_pregIni_1');

btnSiguiente_p2.disabled = true;
respuesta_p2.disabled = true;

  preg_p2.addEventListener('change',function (e) {
	  if($(this).val() != 'select_ini1'){
		  respuesta_p2.disabled = false

		  respuesta_p2.addEventListener('keyup', function(){
			  if(this.value.length > 2){
				  btnSiguiente_p2.disabled = false;
				  $('#resp_Ini1').hide();
			  } else {
				  btnSiguiente_p2.disabled = true;
				  $('#resp_Ini1').html('Se requiere una respuesta mayor a 2 caracteres');
				  $('#resp_Ini4').show();
			  }
		  });

	  } else {
		  btnSiguiente_p2.disabled = true;
		  respuesta_p2.disabled = true;
	  }
  });


//PREGUNTA_2
let btnSiguiente_p3 = document.querySelector('#nexttab2');
let respuesta_p3 = document.querySelector('#respuestaIni2');
let preg_p3 = document.querySelector('#id_pregIni_2');

btnSiguiente_p3.disabled = true;
respuesta_p3.disabled = true;

  preg_p3.addEventListener('change',function (e) {
	  if($(this).val() != 'preg_seleccion'){
		  respuesta_p3.disabled = false

		  respuesta_p3.addEventListener('keyup', function(){
			  if(this.value.length > 2){
				  btnSiguiente_p3.disabled = false;
				  $('#resp_Ini2').hide();
			  } else {
				  btnSiguiente_p3.disabled = true;
				  $('#resp_Ini2').html('Se requiere una respuesta mayor a 2 caracteres');
				  $('#resp_Ini2').show();
			  }
		  });

	  } else {
		  btnSiguiente_p3.disabled = true;
		  respuesta_p3.disabled = true;
	  }
  });


//PREGUNTA_3
let btnSiguiente_p4 = document.querySelector('#nexttab3');
let respuesta_p4 = document.querySelector('#respuestaIni3');
let preg_p4 = document.querySelector('#id_pregIni_3');

btnSiguiente_p4.disabled = true;
respuesta_p4.disabled = true;

  preg_p4.addEventListener('change',function (e) {
	  if($(this).val() != 'preg_seleccion'){
		  respuesta_p4.disabled = false

		  respuesta_p4.addEventListener('keyup', function(){
			  if(this.value.length > 2){
				  btnSiguiente_p4.disabled = false;
				  $('#resp_Ini3').hide();
			  } else {
				  btnSiguiente_p4.disabled = true;
				  $('#resp_Ini3').html('Se requiere una respuesta mayor a 2 caracteres');
				  $('#resp_Ini3').show();
			  }
		  });

	  } else {
		  btnSiguiente_p4.disabled = true;
		  respuesta_p4.disabled = true;
	  }
  });


  //CONTRASEÑA

  let btnRegistro_p3 = document.querySelector("#confirmarCambio");
  let nuevaContrasena_p3 = document.querySelector("#PassPregunta");
  let confContrasena_p3 = document.querySelector("#ConfPassPregunta");

  btnRegistro_p3.disabled = true
  confContrasena_p3.disabled = true

  	nuevaContrasena_p3.addEventListener('keyup', function (){
	  	if(this.value.length < 0 || this.value.length > 7){
		  confContrasena_p3.disabled = false;
		  $("#resp_Ini4").hide();

		  	if(confContrasena_p3.length == 0){
				btnRegistro_p3.disabled = false;
		  	} else {
				  btnRegistro_p3.disabled = true;
			  }

		  	confContrasena_p3.addEventListener('keyup', function(){
			  	if(this.value.length < 2 || this.value.length > 7){
				  	//btnRegistro.disabled = false
				  	$("#resp_Ini4").hide();

				  	if(nuevaContrasena_p3.value == confContrasena_p3.value){
						btnRegistro_p3.disabled = false

						const contrasena_valida_p3 = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;
						  if(contrasena_valida_p3.test(confContrasena_p3.value)){
							  btnRegistro_p3.disabled = false;
						  } else {
							  btnRegistro_p3.disabled = true;
							$("#resp_Ini4").html("No cumple");
							$("#resp_Ini4").show();

						  }

				  	} else {
						btnRegistro_p3.disabled = true;
						$("#resp_Ini4").html('Las contraseñas no coinciden');
				  		$("#resp_Ini4").show();
					}
				}else {
				  btnRegistro_p3.disabled = true

				  $("#resp_Ini4").html('La contraseña es débil, debe estar formada entre 8-16 carácteres.');
				  $("#resp_Ini4").show();


			  	}
		  	})

	  	} else {
		  btnRegistro_p3.disabled = true
		  confContrasena_p3.disabled = true
		  $("#resp_Ini4").html('La contrasena es débil, debe estar formada entre 8-16 carácteres');
		  $("#resp_Ini4").show();

	  	}
  	});

  //FIN CONTRASEÑA