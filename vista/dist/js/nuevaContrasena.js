$(document).ready(function (){

    $("#NuevaContrasena").on("click", async function(){
    
        let contrasena = document.querySelector("#InputNuevaContrasena").value;
        let confirmarContrasena = document.querySelector("#InputConfirmarNuevaContrasena").value;
        let idObjeto = document.querySelector("#idObjeto").value;
        let tkn = document.querySelector("#imputTkn").value;
        let eid = document.querySelector("#imputEid").value;
        let exd = document.querySelector("#imputExd").value;

        if(contrasena === "" || confirmarContrasena === ""){
            swal({
                icon:"error",
                title:"Vacio",
                text:"Todos los campos son requeridos"
            });
        }else if(contrasena.length <= 7 || confirmarContrasena.length <= 7){
            
            swal({
                icon:"error",
                title:"Requisitos",
                text:"No cumple con los requisitos"
            });

        }else{
            $.ajax({
                url:"../../controlador/nuevaContrasena.php",
                type:"POST",
                datatype:"json",
                data: { contrasena:contrasena, confirmarContrasena:confirmarContrasena, tkn:tkn,
                        eid:eid, exd:exd, idObjeto:idObjeto },
                success: function(response){

                    let nuevaContrasena = JSON.parse(response);

                    if(nuevaContrasena.respuesta == "exito"){

                        swal({
                            icon:"success",
                            title:"Exito",
                            text:"Contrasena creada con exito",
                            timer: 3200,
                            buttons: false
                        }).then(() => {
                            location.href = ("login.php");
                        });

                    } else if(nuevaContrasena.respuesta == "caduco"){

                        swal({
                            icon:"error",
                            title:"Caduco",
                            text:"Lo sentimos, el enlace ha caducado",
                            timer:3500,
                            buttons: false
                        }).then(() => {
                            location.reload();
                        });

                    } else if(nuevaContrasena.respuesta == "no_requisitos"){

                        Notificacion("error", "Contrasena", "La contrasena no cumple con los requisitos");

                    } else if(nuevaContrasena.respuesta == "ya_EnUso"){

                        Notificacion("error", "Contrasena en uso", "Contrasena ya en uso");

                    } else if(nuevaContrasena.respuesta == "no_registro"){

                        Notificacion("error", "Error actualizacion", "Hubo on problema en la actualizacion");

                    } else if(nuevaContrasena.respuesta == "fallo_conexion"){

                        Notificacion("warning", "Problemas", "La conexion fallo");

                    } else if(nuevaContrasena.respuesta == "no_coinciden"){

                        Notificacion("error", "Contrasenas", "Las contrasenas no coinciden");

                    } else if(nuevaContrasena.respuesta == "surgio_error"){

                        Notificacion("error", "Problemas informacion",
                        "Problemas con la informacion del correo");

                    } else if(nuevaContrasena.respuesta == ""){

                        Notificacion("", "", "");

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