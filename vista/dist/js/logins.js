$(document).ready(function(){

    //FUNCION INICIO DE SESION
    $("#formLogin").on('click', async function(){

        let usuario = document.querySelector("#usuario").value;
        let contrasena = document.querySelector("#").value;

        $.ajax({
            url:"../.php",
            type:"POST",
            data:{ usuario:usuario, contrasena:contrasena },
            success: function(response){
                let usuario_existe = JSON.parse(response);

                if(usuario_existe.respuesta == "inicio_sesion"){

                    swal({
                        icon:"success",
                        title:"Exito",
                        text:"Te estamos redirigiendo, espera un momento",
                        timer: 2000
                    })
                    .then(() => {
                        window.location.href=("vista/modulos/inicio");
                    });

                }else if(usuario_existe.respuesta ==""){

                    Notificacion("", "", "");

                } else if(usuario_existe.respuesta ==""){

                    Notificacion("", "", "");

                }
            }
        });

    });
    //FIN FUNCION INICIO DE SESION

    //INICIO FUNCION REGISTRO DE USUARIO
    $("#FormRegistro").on("click", async function(){

        let usuario = document.querySelector("#usuario").value;
        let nombre = document.querySelector("#nombre").value;
        let contrasena = document.querySelector("#password").value;
        let correo = document.querySelector("#correo").value;
        let telefono = document.querySelector("#telefono").value;
        let genero = document.querySelector("#genero").value;
        //let estado = document.querySelector("#estado").value;
        let pregunta1 = document.querySelector("#preg1").value;
        let pregunta2 = document.querySelector("#preg2").value;
        let pregunta3 = document.querySelector("#preg3").value;


        $.ajax({
            url:"../ctr.php",
            type:"POST",
            data: {usuario:usuario, nombre:nombre, contrasena:contrasena, correo:correo, telefono:telefono, genero:genero,
                    pregunta1:pregunta1, pregunta2:pregunta2, pregunta3:pregunta3},
            success: function(response){
                let registro = JSON.parse(response);

                if(registro.respuesta == "exito_regitro"){

                    swal({
                        icon:"success",
                        title:"Exito",
                        text:"Se registro correctamente"
                    }).then(() => {
                        window,location.href = ("login.php");
                    });

                } else if(registro.respuesta == "existe"){

                    Notificacion("eror", "Hubo un error", "El correo ya existe");

                }else if(registro.respuesta == "requerido"){
                    swal({
                        icon:"error",
                        title:"Hubo un error",
                        text:"Todos los campos son requeridos",
                        timer: 2000
                    });
                } else if(registro.respuesta ==""){
                    Notificacion("", "", "");
                }
            }
        });

    });
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