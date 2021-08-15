$(document).ready(function () {

  $("#btnRegistro").on('click', async function() {

    let Nombre = document.querySelector("#nombre").value;
    let Usuario = document.querySelector("#usuario").value;
    let Correo = document.querySelector("#correo").value;
    let Genero = document.querySelector("#genero").value;
    let Telefono = document.querySelector("#telefono").value;
    let Contrasena = document.querySelector("#PassRegistro").value;
    let ConfirmarContrasena = document.querySelector("#ConfPassR").value;
    //SELECTS
    let Pregunta_1 = document.querySelector("#id_pregunta1").value;
    let Pregunta_2 = document.querySelector("#id_pregunta2").value;
    let Pregunta_3 = document.querySelector("#id_pregunta3").value;
    //INPUTS
    let Id_preg1 = document.querySelector("#preg1").value;
    let Id_preg2 = document.querySelector("#preg2").value;
    let Id_preg3 = document.querySelector("#preg3").value;

    if(Nombre === "" || Contrasena === "" || ConfirmarContrasena ===""){
      Notificacion("error", "Error", "Todos los campos son requeridos");
    }else{

      $.ajax({
        url:"../../controlador/ctr.registro.php",
        type:"POST",
        datatype:"json",
        data: { Nombre:Nombre, Usuario:Usuario, Correo:Correo, Genero:Genero, Telefono:Telefono, Contrasena:Contrasena, ConfirmarContrasena:ConfirmarContrasena, Pregunta_1:Pregunta_1, Pregunta_2:Pregunta_2, Pregunta_3:Pregunta_3, Id_preg1:Id_preg1, Id_preg2:Id_preg2, Id_preg3:Id_preg3 },
        success: function(response){

          let registro = JSON.parse(response);

          if(registro.respuesta == "registro_exitoso"){
            swal({
              icon:"success",
              title:"Exito",
              text:"El usuario se registro exitosamente"
            }).then(() => {
              window.location.href = "login.php";
            });
          } else if(registro.respuesta == "datos_requeridos"){
            swal({
              icon: "warning",
              title:"Datos requeridos",
              text:"Todos los campos son requeridos",
              timer: 3500,
              buttons:false
            }).then(() => {
              location.reload();
            });
          } else if(registro.respuesta == "contrasena_requisitos"){

            Notificacion("error", "Contraseña", "La contraseña no cumple los requisitos");
          
          } else if(registro.respuesta == "usuario_noRequisitos"){
          
            Notificacion("error", "usuario", "El nombre de usuario no cumple con los requisitos");
          
          } else if(registro.respuesta == "error_preguntas"){
            swal({
              icon:"error",
              title:"Respuestas",
              text:"Hubo un error al momento de registrar la respuesta.",
              timer: 3500,
              buttons: false
            }).then(() => {
              location.reload();
            });
          } else if(registro.respuesta == "error_registro"){
            swal({
              icon:"error",
              title:"Registro",
              text:"El usuario no se pudo registrar",
              timer: 3500,
              buttons: false
            }).then(() => {
              location.reload();
            });
          } else if (registro.respuesta == "contrasena_NoCoinciden"){
            Notificacion("error", "Error contraseña", "Las contraseñas no coinciden");
          } else if (registro.respuesta == "usuario_existe"){
            Notificacion("warning", "Error", "El nombre de usuario o correo ya existen");
          } else if (registro.respuesta == "mal"){
            Notificacion("warning","no se puede","vamos campeon");
          }else if (registro.respuesta == "insert"){
            Notificacion("success","Biem","vamos campeon");
          }else if (registro.respuesta == "pesimo"){
            Notificacion("warning","Biem","Algo anda mal");
          }
        }
      });
    }

  });

  function Notificacion(icon, title, text){
    swal({
      icon,
      title,
      text
    });
  }


  $("#btnCancelar").on("click", function(){
    window.location.href = "login.php";
  });

});