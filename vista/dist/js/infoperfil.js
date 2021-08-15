$(document).ready(function(){

    //FUNCION PARA ACTUALIZAR LA INFORMACION PERSONAL DEL USUARIO
    //ABRE EL MODAL
    $('#editar').on('click', function (){

      let idusuario = $(this).data("idusuario");
      let nombre_usuario = $(this).data("nombreusuario");
      let nombre = document.querySelector('#nombre').value;
      let usuario = document.querySelector('#usuario').value;
      let telefono = document.querySelector('#telefono').value;
      let correo = document.querySelector('#correo').value;

      if(nombre === '' || usuario === '' || telefono ==='' || correo === ''){
        Notificacion("error","Parece que hubo un error","Todos los campos son requeridos");

      }else{
        $('#modal-default').modal('show');
        $('#modal-default').modal({backdrop: 'static', keyboard: false})

        //GUARDA LOS CAMBIOS
        $("#aceptCambios").on("click", async function () {

          let verificarContrasena = document.querySelector('#passConf').value;

          //CONDICION QUE VERIFICA SI LA CONTRASENA SE INGRESO
          if(verificarContrasena === ''){
            Notificacion("error","Lo sentimos","Debes de ingresar tu contraseña");

          } else if(verificarContrasena.length <= 7){

            Notificacion("error","Problema en tu contrasena","La contraseña no es aceptable, por su extensión");
          
          }else{

            $.ajax({
              type: "POST",
              url: "./controlador/ctr.actualizarinformacion.php",
              datatype:"json",
              Cache:false,
              data: {usuario:usuario, nombre:nombre, telefono:telefono, correo:correo,
                      verificarContrasena:verificarContrasena},
              success: function (response){

                console.log(response)

                var verificar = JSON.parse(response)
                
                //SI LA ACTUALIZACION DE LA INFORMACION ES CORRECTA
                if(verificar.respuesta == "correcto"){
                  
                  swal({
                    icon: "success",
                    title: "Éxito",
                    text: "Su información se actualizó correctamente"
                  }).then (() => {
                      $('#modal-default').modal('hide');
                      window.location.reload();                      
                    });

                  //SI SE PRESENTO UN ERROR EN LA ACTUALIZACION DE LA INFORMACION
                } else if(verificar.respuesta == "error"){

                  Notificacion("error","No se pudo actualizar","Lo sentimos no se pudo actualizar.");
                
                } else if(verificar.respuesta == "error_pass"){

                  Notificacion("error","Error","La contrasena ingresada es incorrecta");

                }else if(verificar.respuesta == "error_catch"){

                  Notificacion("success","Error","Estoy en el catch");
                
                } else if(verificar.respuesta === "info_actualizada"){

                  swal({
                    icon:"success",
                    title:"Exito",
                    text:"Información actualizada correctamente"
                  })
                  .then( () =>{
                    window.location.reload();
                  })

                } else if(verificar.respuesta == "info_noActualizada"){
                  Notificacion("error", "Lo sentimos", "Su información no se pudo actualizar");
                }
                
              }
            })


          }

        });

        $('#cancelarActualizacion').on('click', async function(){
           contrasena = $("#passConf").val('');

        })
      }

    });


    $("#cancelarActualizacion").on("click", function(){

      swal({
          icon:"warning",
          title: "¿Desea salir?",
          text: "Si acepta se perderá la información",
          buttons: ["Cancelar" , "Aceptar"],
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              // contrasena4 = document.querySelector("#contraRestauracion").val("");
              $("#passConf").val("");
          } else {
          $("#modal-default").modal("show");
          }
      });
      
    });


    $("#cerrarActualizacion").on("click", function(){

      swal({
          icon:"warning",
          title: "¿Desea salir?",
          text: "Si acepta se perderá la información",
          buttons: ["Cancelar" , "Aceptar"],
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              // contrasena4 = document.querySelector("#contraRestauracion").val("");
              $("#passConf").val("");
          } else {
          $("#modal-default").modal("show");
          }
      });
      
    });    


    //FUNCION PARA ACTUALIZAR LA CONTRASENA DEL USUARIO
    $('#cambioContrasena').on('click', function () {

      $('#modal-default2').modal('show');
      $('#modal-default2').modal({backdrop: 'static', keyboard: false})

      $('#gcambios').on('click', async function () {

        let contrasenaActual = document.querySelector('#passActual').value;
        let contrasenaNueva = document.querySelector('#passNueva').value;
        let confirmarContrasena = document.querySelector('#passConfirmar').value;
        let usuario2 = document.querySelector('#usuario').value;

        if(contrasenaActual === '' || contrasenaNueva ==='' || confirmarContrasena ===''){
          swal(
            "Todos los campos son requeridos", {
              icon:'error',
              buttons: false,
              timer: 3000
          }).then(() => {
            $('#modal-default2').modal('hide');
            location.reload();
          });
  
        } else if(contrasenaActual.length <= 7 || contrasenaNueva.length <= 7 || confirmarContrasena.length <= 7){
          
          Notificacion("warning","Problemas con la contraseña","La longitud de la contraseña no es permitida");
          
        } else{

          $.ajax({
            url:'./controlador/ctr.actualizarcontrasena.php',
            type:'POST',
            datatype:'json',
            data: {contrasenaActual:contrasenaActual, contrasenaNueva:contrasenaNueva, confirmarContrasena:confirmarContrasena, usuario2:usuario2},
            success: function(response) {

              console.log(response)
              let respuestas = JSON.parse(response)

              //SI LA ACTUALIZACION DE LA CONTRASENA ES CORRECTA
              if(respuestas.respuesta == "exito"){
                
                Notificacion("success","Perfecto","Su contraseña se actualizó correctamente")
                .then(() => {
                  $('#modal-default2').modal('hide');
                  location.reload();
                });

                //SI LAS CONTRASENAS NO COINCIDEN
              } else if (respuestas.respuesta == "no_iguales"){

                Notificacion("error","Lo sentimos","Las contraseñas no coinciden");
                
                //SI LAS CONTRASENA COINCIDEN
              } else if (respuestas.respuesta == "confirmar"){
                
                Notificacion("success","Perfecto","Las contraseñas coinciden");
                
              } else if(respuestas.respuesta == "igual"){

                swal({
                  icon:"error",
                  title: "Contraseña",
                  text:"No se puede registrar una contraseña antigua."
                }).then(() => {

                  //LIMPIA LOS INPUTS DE CONTRASENA Y CONFIRMAR CONTRASENA
                  $("#passActual").val("");
                  $("#passNueva").val("");
                  $("#passConfirmar").val("");

                  //CAMBIO EL TIPO DE INPUT DE TEXTO A CONTRASENA (PASSWORD)
                  let cambio1 = document.querySelector("#passActual");
                  cambio1.type = "password";
                  $(".icon__p_actual").removeClass("fa fa-eye").addClass("fa fa-eye-slash");

                  let cambio2 = document.querySelector("#passNueva");
                  cambio2.type = "password";
                  $(".icon_p_actual").removeClass("fa fa-eye").addClass("fa fa-eye-slash");

                  let cambio3 = document.querySelector("#passConfirmar");
                  cambio3.type = "password";
                  $(".icon_p_actual").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
                });
              
              } else if(respuestas.respuesta == "no_existe"){
                
                Notificacion("error","Error en contraseña","La contraseña ingresada es incorrecta");

              } else if (respuestas.respuesta == "actualizacion"){
                
                swal({
                  icon:"success",
                  title:"Perfecto",
                  text:"Contraseña actualizada"})
                .then(() => {
                  $('#modal-default2').modal('hide');
                  window.location.reload();
                  window.location.href = "vista/modulos/login.php";
                });

              } else if (respuestas.respuesta == "noActualizacion"){
                
                Notificacion("error","Lo sentimos","La contraseña no se pudo actualizar");

              } else if(respuestas.respuesta == "existe_registro"){
                Notificacion("error", "Contrasena", "Se detecto el registro de la contrasena previamente");
              } else if(respuestas.respuesta == "requisitos"){
                Notificacion("error","Lo sentimos","la contraseña no cumple con los requisitos.");
              }

            }

          });//FIN DE LA PETICION

        }

      });

      //LIMPIA LOS INPUTS AL CERRARSE LA MODAL
      $('#cancelarCambios').on('click', async function(){

        contrasenaActual = $('#passActual').val('');
        contrasenaNueva = $('#passNueva').val('');
        confirmarContrasena = $('#passConfirmar').val('');

      })



      $("#cancelarCambios").on("click", function(){

        swal({
            icon:"warning",
            title: "¿Desea salir?",
            text: "Si acepta se perderá la información",
            buttons: ["Cancelar" , "Aceptar"],
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // contrasena4 = document.querySelector("#contraRestauracion").val("");
                $("#passConf").val("");
            } else {
            $("#modal-default2").modal("show");
            }
        });
        
      });
  
  
      $("#CerrarCambio").on("click", function(){
  
        swal({
            icon:"warning",
            title: "¿Desea salir?",
            text: "Si acepta se perderá la información",
            buttons: ["Cancelar" , "Aceptar"],
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // contrasena4 = document.querySelector("#contraRestauracion").val("");
                $("#passConf").val("");
            } else {
            $("#modal-default2").modal("show");
            }
        });
        
      });

    })
    
    function Notificacion (icon, title, text){
      swal({
        icon,
        title,
        text
      })
    }

})
