$(document).ready(function(){

    //FUNCION INICIO DE SESION
    $("#btn").on('click', async function(){

        let usuario = document.querySelector("#usuario").value;
        let contrasena = document.querySelector("#P_Password").value;

        if(usuario === "" && contrasena === ""){
            swal({
                icon:"error",
                title:"Credenciales",
                text:"No haz ingresado tus credenciales"
            });
        }else if(contrasena ===""){
            swal({
                icon:"error",
                title:"Credenciales",
                text:"No haz ingresado tu contrasena"
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
                            title:"Éxito",
                            text:"Te estamos redirigiendo, espera un momento",
                            timer: 4000,
                            buttons:false
                            
                        })
                        .then(() => {

                            window.location.href=("../../index.php");
                        });

                    } else if (usuario_existe.respuesta == "error_contrasena"){

                        swal({
                            icon:"error",
                            title:"Lo sentimos",
                            text:"El nombre de usuario o contraseña son incorrectos"
                        }).then(() => {
                            location.reload();
                        });

                    } else if(usuario_existe.respuesta == "cambio_estado"){

                        Notificacion("error", "Bloqeuo", "Su usuario a sido bloqueado");

                    } else if(usuario_existe.respuesta == "bloqueado_intentos"){

                        swal({
                            icon:"warning",
                            title:"Bloqueo usuario",
                            text:"Su usuario a sido bloqueado ya que realizó los intentos permitidos"
                        }).then(() => {
                            location.reload();
                        });

                    } else if(usuario_existe.respuesta == "usuario_noExiste"){
                        swal({
                            icon:"error",
                            title: "Lo sentimos",
                            text:"El usuario no existe",
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
                            text:"Te estamos redirigiendo",
                            timer: 4000,
                            buttons: false

                        }).then(() => {
                            window.location.href=("conf_preguntas.php");
                        })
                    }
                }
            });
        }

    });
    //FIN FUNCION INICIO DE SESION

    //INICIO FUNCION REGISTRO DE USUARIO
    
    //FIN FUNCION REGISTRO DE USUARIO

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