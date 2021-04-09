$(document).ready(function(){

    //FUNCION INICIO DE SESION
    $("#btnInicioSesion").on('click', async function(){

        let usuario = document.querySelector("#usuario").value;
        let contrasena = document.querySelector("#P_Password").value;

        if(usuario === "" && contrasena === ""){
            swal({
                icon:"error",
                title:"Credenciales",
                text:"No haz ingresado tus credenciales."
            });
        }else if(usuario === ""){
            swal({
                icon:"error",
                title:"Credenciales",
                text:"No haz ingresado tu nombre de usuario."
            });
        }else if(contrasena === ""){
            swal({
                icon:"error",
                title:"Credenciales",
                text:"No haz ingresado tu contraseña."
            });
        }else{
            $.ajax({
                url:"../../controlador/logiin.php",
                type:"POST",
                datatype:'json',
                data:{ usuario:usuario, contrasena:contrasena },
                success: function(response){
                    let usuario_existe = JSON.parse(response);

                    if(usuario_existe.respuesta == "inicio_sesion"){

                        swal({
                            icon:"success",
                            title:"Iniciando sesion",
                            text:"Espera un momento.",
                            timer: 2500,
                            buttons:false
                            
                        })
                        .then(() => {

                            window.location.href=("../../index.php");
                        });

                    } else if (usuario_existe.respuesta == "error_contrasena"){

                        swal({
                            icon:"error",
                            title:"Lo sentimos",
                            text:"El nombre de usuario o contraseña son incorrectos."
                        }).then(() => {
                            $("#P_Password").val("");
                        });

                    } else if(usuario_existe.respuesta == "cambio_estado"){

                        Notificacion("error", "Bloqeuo", "Su usuario a sido bloqueado.");

                    } else if(usuario_existe.respuesta == "bloqueado_intentos"){

                        swal({
                            icon:"warning",
                            title:"Bloqueo usuario",
                            text:"El usuario a sido bloqueado, realizó los intentos permitidos."
                        }).then(() => {
                            location.reload();
                        });

                    } else if(usuario_existe.respuesta == "usuario_noExiste"){
                        swal({
                            icon:"error",
                            title: "Lo sentimos",
                            text:"El usuario no existe.",
                            timer: 2500,
                            buttons: false
                        }).then(() => {
                            location.reload();
                        });
                    } else if (usuario_existe.respuesta == "bloqueado"){
                        swal({
                            icon:"error",
                            title:"Bloqueado",
                            text:"El usuario en este momento se encuentra bloqueado.",
                            timer:3000,
                            buttons: false
                        }).then(() => {
                            location.reload();
                        })
                    } else if (usuario_existe.respuesta == "noCredenciales"){
                        swal({
                            icon:"warning",
                            title:"Campos requeridos",
                            text:"No haz ingresado tus credenciales.",
                            timer:4000,
                            buttons: false
                        }).then(() => {
                            location.reload();
                        })
                    } else if(usuario_existe.respuesta == "redirigiendo"){
                        swal({
                            icon:"success",
                            title: "Exito",
                            text:"Te estamos redirigiendo.",
                            timer: 4000,
                            buttons: false

                        }).then(() => {
                            window.location.href=("conf_preguntas.php");
                        })
                    } else if(usuario_existe.respuesta == "no_verificada"){
                        swal({
                            icon:"error",
                            title: "Contraseña incorrecta",
                            text:"Su contraseña es incorrecta."
                        });
                    }
                }
            });
        }

    });
    //FIN FUNCION INICIO DE SESION

    //INICIO FUNCION DE NOTIFICACION
    function Notificacion(icon, title, text){
        swal({
            icon,
            title,
            text
        });
    }
    //FIN FUNCION DE NOTIFICACION
});