$(document).ready(function(){

    //FUNCION PARA ACTUALIZAR PARAMETROS DEL CORREO ELECTRONICO
    $("#InformacionCorreo").on("click", function(){

        let correo = document.querySelector("#correo").value;
        let puertoCorreo = document.querySelector("#puertoCorreo").value;
        let idUsuario = document.querySelector("#idUsuario").value;
        let usuario = document.querySelector("#usuario").value;
        let contrasena = document.querySelector("#contrasenaCorreo").value;
        //let = document.querySelector("#").value;

        if(correo === "" && puertoCorreo === ""){
            Notification("error","Requisito","Los campos son requeridos");
        }else if(correo === ""){
            Notification("error","Requisito","El campo correo esta vacio");
        }else if(contrasena === ""){
            Notification("error","Requisito","No haz ingresado tu contrasena");
        }else if(puertoCorreo === ""){
            Notification("error","Requisito","El campo correo esta vacio");
        }else{
            $.ajax({
                type:"POST",
                url:"./controlador/ctr.actualizarParamCorreo.php",
                datatype:"json",
                data: { correo:correo, puertoCorreo:puertoCorreo, idUsuario:idUsuario,
                        usuario:usuario, contrasena:contrasena },
                success: function(response){

                    let infoCorreo = JSON.parse(response);
                    
                    if(infoCorreo.respuesta == "exito"){
                        swal({
                            icon:"success",
                            title:"Exito",
                            text:"Se actualizo correctamente"
                        }).then(() => {
                            location.reload();
                        });
                    } else if(infoCorreo.respuesta == "error"){
                        swal({
                            icon:"error",
                            title:"Error",
                            text:"Hubo un error al actualizar"
                        })
                    } else if(infoCorreo.respuesta == "error_contrasena"){
                        swal({
                            icon:"error",
                            title:"Contrasena",
                            text:"Contrasena incorrecta"
                        })
                    }
                }
            });
        } 
    });

    $("#limpiarCorreo").on("click", function(){

        /*if(contrasena == " "){

        } else if(contrasena != ""){*/
        swal({
            icon:"warning",
            title: "Salir?",
            text: "Seguro que quieres salir?",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                contrasena = document.querySelector("#contrasenaCorreo").value="";      
            } else {
            $("#modal-correo").modal("show");
            }
        });
        //}
    
    });

    //FUNCION PARA ACTUALIZAR PARAMETROS DE LA BASE DE DATOS
    $("#InformacionBD").on("click", function(){

        let host = document.querySelector("#host").value;
        let puertoBD = document.querySelector("#puertoBD").value;
        let nombreBD = document.querySelector("#nombreBD").value;
        let idUsuario = document.querySelector("#idUsuario").value;
        let usuario = document.querySelector("#usuario").value;
        let contrasena1 = document.querySelector("#contrasenaBD").value;

        if(host === "" && puertoBD === "" && nombreBD === ""){
            Notification("error","Requisito","Los campos son requeridos");
        } else if(contrasena1 === ""){
            Notification("error","Requisito","La contrasena es requerida");
        } else if(host === ""){
            Notification("error","Requisito","El campo correo esta vacio");
        }else if(puertoBD === ""){
            Notification("error","Requisito","El campo correo esta vacio");
        }else if(nombreBD === ""){
            Notification("error","Requisito","El campo correo esta vacio");
        }else{
            $.ajax({
                type:"POST",
                url:"./controlador/ctr.actualizarParamBD.php",
                datatype:"json",
                data: { host:host, puertoBD:puertoBD, nombreBD:nombreBD, idUsuario:idUsuario,
                        usuario:usuario, contrasena1:contrasena1 },
                success: function(response){
                    
                    let infoBD= JSON.parse(response);
                    
                    if(infoBD.respuesta == "exito"){
                        swal({
                            icon:"success",
                            title:"Exito",
                            text:"Se actualizo correctamente"
                        }).then(() => {
                            location.reload();
                        });
                    } else if(infoBD.respuesta == "error"){
                        swal({
                            icon:"error",
                            title:"Error",
                            text:"Error actualizacion bd"
                        })
                    } else if(infoBD.respuesta == "error_contrasena"){
                        swal({
                            icon:"error",
                            title:"Error",
                            text:"La contrasena es incorrecta"
                        })
                    }
                }
            });
        }
    });

    $("#borrarBD").on("click", function(){

        swal({
            icon:"warning",
            title: "Saliendo?",
            text: "Seguro que quieres salir?",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                contrasena1 = document.querySelector("#contrasenaBD").value = "";      
            } else {
            $("#modal-bd").modal("show");
            }
        });
        
    });

    //FUNCION PARA ACTUALIZAR PARAMETROS DEL SISTEMA
    $("#InformacionSistema").on("click", function(){

        let nombreOrganizacion = document.querySelector("#nombreOrganizacion").value;
        let nombreSistema = document.querySelector("#nombreSistema").value;
        let usuarioAdministrador = document.querySelector("#usuarioAdministrador").value;
        let idUsuario = document.querySelector("#idUsuario").value;
        let usuario = document.querySelector("#usuario").value;
        let contrasena2 = document.querySelector("#contrasenaSistema").value;
        
        if(nombreOrganizacion === "" && nombreSistema === "" && usuarioAdministrador === ""){
            Notification("error","Requisito","Los campos son requeridos");
        }else if(contrasena2 === ""){
            Notification("error","Requisito","La contrasena es requerida");
        }
        else if(nombreOrganizacion === ""){
            Notification("error","Requisito","El campo correo esta vacio");
        }else if(nombreSistema === ""){
            Notification("error","Requisito","El campo correo esta vacio");
        }else if(usuarioAdministrador === ""){
            Notification("error","Requisito","El campo correo esta vacio");
        }else{
            $.ajax({
                type:"POST",
                url:"./controlador/ctr.actualizarParamSistema.php",
                datatype:"json",
                data: { nombreOrganizacion:nombreOrganizacion, nombreSistema:nombreSistema,
                        usuarioAdministrador:usuarioAdministrador, idUsuario:idUsuario,
                        usuario:usuario, contrasena2:contrasena2 },
                success: function(response){

                    let infoSistema = JSON.parse(response);
                    
                    if(infoSistema.respuesta == "exito"){
                        swal({
                            icon:"success",
                            title:"Exito",
                            text:"Se actualizo correctamente"
                        }).then(() => {
                            location.reload();
                        });
                    } else if(infoSistema.respuesta == "error"){
                        swal({
                            icon:"error",
                            title:"Error",
                            text:"Surgio un error al momento de actualizar"
                        })
                    } else if(infoSistema.respuesta == "error_sistema"){
                        swal({
                            icon:"error",
                            title:"Error",
                            text:"La contrasena es incorrecta"
                        })
                    }
                }
            });
        }
    });

    $("#borrarSistema").on("click", function(){

        swal({
            icon:"warning",
            title: "Saliendo?",
            text: "Seguro que quieres salir?",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                contrasena2 = document.querySelector("#contrasenaSistema").value = "";
            } else {
            $("#modal-sistema").modal("show");
            }
        });
        
    });

    //FUNCION PARA ACTUALIZAR PARAMETROS DE SEGURIDAD
    $("#InformacionSeguridad").on("click", function(){

        let intentosSesion = document.querySelector("#intentosSesion").value;
        let cantPreguntas = document.querySelector("#cantPreguntas").value;
        let vigUsuario = document.querySelector("#vigUsuario").value;
        let usuario = document.querySelector("#usuario").value;
        let contrasena4 = document.querySelector("#contrasenaSeguridad").value;
        
        if(intentosSesion === "" && cantPreguntas === "" && vigUsuario === ""){
            Notification("error","Requisito","Los campos son requeridos");
        }else if(contrasena4 === ""){
            Notification("error","Requisito","La contrasena es requerida");
        }
        else if(intentosSesion === ""){
            Notification("error","Requisito","El campo correo esta vacio");
        }else if(cantPreguntas === ""){
            Notification("error","Requisito","El campo correo esta vacio");
        }else if(vigUsuario === ""){
            Notification("error","Requisito","El campo correo esta vacio");
        }else{
            $.ajax({
                type:"POST",
                url:"./controlador/ctr.actualizarParamSeguridad.php",
                datatype:"json",
                data: { intentosSesion:intentosSesion, cantPreguntas:cantPreguntas, vigUsuario:vigUsuario,
                        usuario:usuario, contrasena4:contrasena4 },
                success: function(response){

                    let infoSeguridad = JSON.parse(response);
                    
                    if(infoSeguridad.respuesta == "exito"){
                        swal({
                            icon:"success",
                            title:"Exito",
                            text:"Se actualizo correctamente"
                        }).then(() => {
                            location.reload();
                        });
                    } else if(infoSeguridad.respuesta == "error"){
                        swal({
                            icon:"error",
                            title:"Error",
                            text:"Surgio un error al momento de actualizar"
                        })
                    } else if(infoSeguridad.respuesta == "error_contrasena"){
                        swal({
                            icon:"error",
                            title:"Error",
                            text:"La contrasena es incorrecta"
                        })
                    }
                }
            });
        }
    });

    $("#borrarSeguridad").on("click", function(){

        swal({
            icon:"warning",
            title: "Saliendo?",
            text: "Seguro que quieres salir?",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                contrasena4 = document.querySelector("#contrasenaSeguridad").value = "";
            } else {
            $("#modal-seguridad").modal("show");
            }
        });
        
    });

    //FUNCION PARA ACTUALIZAR PARAMETROS DE SOLICITUDES
    $("#InformacionSolicitudes").on("click", function(){

        let mostrarSolicitudes = document.querySelector("#mostrarSolicitudes").value;
        let usuario = document.querySelector("#usuario").value;
        let contrasena5 = document.querySelector("#contrasenaSolicitudes").value;
        
        if(mostrarSolicitudes === ""){
            Notification("error","Requisito","Los campos son requeridos");
        }else if(contrasena5 === ""){
            Notification("error","Requisito","La contrasena es requerida");
        } else {
            $.ajax({
                type:"POST",
                url:"./controlador/ctr.actualizarOtrosParametros.php",
                datatype:"json",
                data: { mostrarSolicitudes:mostrarSolicitudes, usuario:usuario, contrasena5:contrasena5 },
                success: function(response){

                    let infoSolicitudes = JSON.parse(response);
                    
                    if(infoSolicitudes.respuesta == "exito"){
                        swal({
                            icon:"success",
                            title:"Exito",
                            text:"Se actualizo correctamente"
                        }).then(() => {
                            location.reload();
                        });
                    } else if(infoSolicitudes.respuesta == "error"){
                        swal({
                            icon:"error",
                            title:"Error",
                            text:"Surgio un error al momento de actualizar"
                        })
                    } else if(infoSolicitudes.respuesta == "error_contrasena"){
                        swal({
                            icon:"error",
                            title:"Error",
                            text:"La contrasena es incorrecta"
                        })
                    }
                }
            });
        }
    });

    $("#borrarSolicitudes").on("click", function(){

        swal({
            icon:"warning",
            title: "Saliendo?",
            text: "Seguro que quieres salir?",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                contrasena4 = document.querySelector("#contrasenaSolicitudes").value = "";
            } else {
            $("#modal-solicitudes").modal("show");
            }
        });
        
    });

    function Notification(icon, title, text){
        swal({
            icon,
            title,
            text
        })
    }
});