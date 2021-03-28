$(document).ready( function(){

    $("#btnRegistroPreguntas").on("click", async function(){

        //let id_usuario = document.querySelector("#usuario_id").value;
        let usuario = document.querySelector("#nombre_usuario").value;
        let contrasenaActual = document.querySelector("#PassRegistroPreguntas1").value;
        let contrasena = document.querySelector("#PassRegistroPreguntas2").value;
        let confirmarContrasena = document.querySelector("#ConfPassPreguntas").value;
        //SELECTS
        let pregunta_1 = document.querySelector("#id_pregunta_1").value;
        let pregunta_2 = document.querySelector("#id_pregunta_2").value;
        let pregunta_3 = document.querySelector("#id_pregunta_3").value;
        //INPUTS
        let id_preg1 = document.querySelector("#preg_1").value;
        let id_preg2 = document.querySelector("#preg_2").value;
        let id_preg3 = document.querySelector("#preg_3").value;

        if(usuario ==="" || contrasenaActual ==="" || contrasena === "" ||
        confirmarContrasena ===""){
            
            swal({
                icon:"error",
                title:"Requisitos",
                text:"Todos los campos son requeridos"
            }).then(() => {
                location.reload();
            })

        }else if( contrasenaActual.length <= 7 || confirmarContrasena.length <= 7){
            swal({
                icon:"error",
                title:"Contrasena",
                text:"Las contrasenas no cumplen el requisito",
                timer: 2500,
                buttons: false
            }).then (() => {
                location.reload();
            });
            
        }else {

            $.ajax({
                url:"../../controlador/ctr.configurarPreguntas.php",
                type:"POST",
                data:{ usuario:usuario, contrasenaActual:contrasenaActual, contrasena:contrasena,
                        confirmarContrasena:confirmarContrasena, pregunta_1:pregunta_1,
                        pregunta_2:pregunta_2, pregunta_3:pregunta_3, id_preg1:id_preg1,
                        id_preg2:id_preg2, id_preg3:id_preg3 },
                datatype:"json",
                success: function(response){

                    let conf_pregunta = JSON.parse(response);

                    if(conf_pregunta.respuesta == "registro_exitoso"){
                        
                        swal({
                            icon:"success",
                            title:"Exito",
                            text:"Preguntas configuradas con exito.",
                            timer: 2500,
                            buttons: false
                        }).then(() => {
                            window.location.href = ("login.php");
                        });

                    } else if(conf_pregunta.respuesta == "error_registro"){
                        Notificacion("error", "Error", "Surgio un error en el registro.");

                    } else if(conf_pregunta.respuesta == "usuario_noExiste"){
                        Notificacion("error", "Error", "El usuario no existe");

                    } else if(conf_pregunta.respuesta == "error_registro"){
                        Notificacion("error", "Error", "Hubo un error al momento de registrar");

                    } else if(conf_pregunta.respuesta == "no_coincide"){
                        Notificacion("error", "Error", "La contraseña es incorrecta");

                    } else if (conf_pregunta.respuesta == "contrasena_NoCoinciden"){
                        Notificacion("error", "Error contraseña", "Las contraseñas no coinciden");

                    } else if (conf_pregunta.respuesta == "contrasena_requisitos"){
                        Notificacion("error", "Contrasena", "La contrasena no cumple con los requsitos");
                    }
                }

            });
        }
    });

    function Notificacion (icon, title, text){
        swal({
            icon,
            title,
            text
        });
    }

});