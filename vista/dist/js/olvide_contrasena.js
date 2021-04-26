$(document).ready(function(){

    //FUNCION PARA OLVIDE CONTRASENA
    $("#btnCorreo").on("click", async function(){
        let correo = document.querySelector("#correo").value;
        let idObjeto = document.querySelector("#idObjeto").value;

        if(correo === ""){
            Notificacion("warning", "Algo anda mal", "Debes de ingresar tu correo electronico");
        }else{

            $.ajax({
                url:"../../controlador/olvideContrasena.php",
                type:"POST",
                datatype:"json",
                data: { correo:correo, idObjeto:idObjeto },
                success: function(response){

                    let recuCorreo = JSON.parse(response);

                    if(recuCorreo.respuesta == "exito"){

                        swal({
                            icon:"success",
                            title:"Exito",
                            text:"Te hemos enviado un correo electronico."
                        }).then(() => {
                            location.reload();
                        });

                    } else if (recuCorreo.respuesta == "no_Encontrado"){
                        Notificacion("error","Error", "Correo o nombre de usuario no encontrado");
                    } else if(recuCorreo.respuesta == "tiempo"){
                        Notificacion("error", "Tiempo", "Debes de esperar 24 hrs para otro cambio");
                    } else if(recuCorreo.respuesta == "usuario_no"){
                        Notificacion("error", "Tiempo", "El usuario no se encontro");
                    }
                }
            })
        }
    });

    function Notificacion(icon, title, text){
        swal({
            icon,
            title,
            text
        });
    }

});