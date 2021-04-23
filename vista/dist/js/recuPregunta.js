$(document).ready(function(){

    $("#confirmarCambio").on("click", function (){

        let respuestaUsuario = document.querySelector("#respuestaUsuario").value;
        let id_pregunta = document.querySelector("#id_pregunta").value;
        let idObjeto = document.querySelector("#idObjeto").value;
        let usuario = document.querySelector("#usuario").value;
        let PassPregunta = document.querySelector("#PassPregunta").value;
        let ConfPassPregunta = document.querySelector("#ConfPassPregunta").value;

        if(respuestaUsuario ==="" || id_pregunta ==="" || PassPregunta.length === "" ||
            ConfPassPregunta === ""){
            Notificacion("error", "Requerido", "Todos los campos son requeridos");
        } else if(PassPregunta.length <= 7 || ConfPassPregunta <= 7){
            Notificacion("error", "Contrasena", "La contrasena no cumple con los requisitos");
        }else{
            $.ajax({
                url:"../../controlador/nuevaPassPregunta.php",
                type:"POST",
                datatype:"json",
                data: { respuestaUsuario:respuestaUsuario, id_pregunta:id_pregunta, usuario:usuario,
                        PassPregunta:PassPregunta, ConfPassPregunta:ConfPassPregunta, idObjeto:idObjeto },
                success: function(response){

                    let recuPregunta = JSON.parse(response);

                    if(recuPregunta.respuesta == "exito"){
                        
                        swal({
                            icon:"success",
                            title:"Exito",
                            text:"Contrasena creada con exito",
                            timer: 3500,
                            buttons: false
                        }).then(() => {
                            window.location.href = ("login.php");
                        });

                    } else if(recuPregunta.respuesta == "contrasena_noCoinciden"){
                        Notificacion("error", "Contrasena", "Las contrasenas no coinciden");

                    } else if(recuPregunta.respuesta == "error_actualizacion"){
                        Notificacion("error", "Actualizacion", "Hubo un momento al actualizar.");

                    } else if(recuPregunta.respuesta == "respuesta_noCoincide"){
                        Notificacion("error", "Respuesta", "La respuesta no coincide.");

                    } else if(recuPregunta.respuesta == "respuesta_incorrecta"){
                        Notificacion("warning", "Error Respuesta", "La respuesta es incorrecta.");

                    } else if(recuPregunta.respuesta == "repetida"){
                        swal({
                            icon:"error",
                            title: "Contraseña",
                            text:"No se puede registrar una contraseña ya utilizada."
                        }).then(() => {

                            //LIMPIA LOS INPUTS DE CONTRASENA Y CONFIRMAR CONTRASENA
                            $("#PassPregunta").val("");
                            $("#ConfPassPregunta").val("");

                            //CAMBIO EL TIPO DE INPUT DE TEXTO A CONTRASENA (PASSWORD)
                            let cambio1 = document.querySelector("#PassPregunta");
                            cambio1.type = "password";
                            $(".icon_pregunta").removeClass("fa fa-eye").addClass("fa fa-eye-slash");

                            let cambio2 = document.querySelector("#ConfPassPregunta");
                            cambio2.type = "password";
                            $(".icon_pregunta").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
                        });
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
        })
    }

});