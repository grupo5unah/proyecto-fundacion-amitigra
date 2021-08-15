$(document).ready(function(){

    //FUNCION INICIO DE SESION
    $("#btnInicioSesion").on('click', async function(){

        let usuario = document.querySelector("#usuario").value;
        let contrasena = document.querySelector("#P_Password").value;

        if(usuario === "" && contrasena === ""){
            swal({
                icon:"error",
                title:"Credenciales",
                text:"No haz ingresado tus credenciales.",
                button: "Aceptar"
            });
        }else if(usuario === ""){
            swal({
                icon:"error",
                title:"Credenciales",
                text:"No haz ingresado tu nombre de usuario.",
                button: "Aceptar"
            });
        }else if(contrasena === ""){
            swal({
                icon:"error",
                title:"Credenciales",
                text:"No haz ingresado tu contraseña.",
                button: "Aceptar"
            });
        }else{
            $.ajax({
                url:"../../controlador/ctr.login.php",
                type:"POST",
                datatype:'json',
                data:{ usuario:usuario, contrasena:contrasena },
                success: function(response){
                    let usuario_existe = JSON.parse(response);

                    if(usuario_existe.respuesta == "inicio_sesion"){

                        swal({
                            icon:"success",
                            title:"Iniciando sesión",
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
                            text:"El nombre de usuario o contraseña son incorrectos.",
                            button: "Aceptar"
                        }).then(() => {
                            $("#P_Password").val("");
                        });

                    } else if(usuario_existe.respuesta == "cambio_estado"){

                        Notificacion("error", "Bloqueo", "Su usuario ha sido bloqueado.");

                    } else if(usuario_existe.respuesta == "bloqueado_intentos"){

                        swal({
                            icon:"warning",
                            title:"Bloqueo usuario",
                            text:"El usuario ha sido bloqueado, realizó los intentos permitidos.",
                            button: "Aceptar"
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
                            text:"Su contraseña es incorrecta.",
                            button: "Aceptar"
                        });
                    } else if(usuario_existe.respuesta == "no_activo"){
                        swal({
                            icon: "success",
                            title: "Redirigiendo",
                            text: "Espera un momento, te estamos redirigiendo.",
                            timer: 3000,
                            buttons: false
                        }).then(() =>{
                            window.location.href="pendiente.php";
                        })
                    } else if(usuario_existe.respuesta == "error_no_activo"){
                        swal({
                            icon:"error",
                            title: "Contraseña",
                            text: "La contraseña es incorrecta.",
                            button: "Aceptar"
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