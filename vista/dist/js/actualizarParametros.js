$(document).ready(function(){

    //FUNCION PARA ACTUALIZAR PARAMETROS DEL CORREO ELECTRONICO
    $("#InformacionCorreo").on("click", function(){

        let correo = document.querySelector("#").value;
        let puertoCorreo = document.querySelector("#").value;
        //let = document.querySelector("#").value;
        $.ajax({
            url:"",
            datatype:"",
            data: { correo:correo, puertoCorreo:puertoCorreo },
            success: function(Response){

                let infoCorreo = JSON.parse(Response);
                
                if(infoCorreo.respuestaCorreo == ""){

                }
            }
        });
    });

    //FUNCION PARA ACTUALIZAR PARAMETROS DE LA BASE DE DATOS
    $("#InformacionBD").on("click", function(){

        let host = document.querySelector("#").value;
        let puertoBD = document.querySelector("#").value;
        let nombreBD = document.querySelector("#").value;
        $.ajax({
            url:"",
            datatype:"",
            data: { host:host, puertoBD:puertoBD, nombreBD:nombreBD },
            success: function(Response){
                
                let infoBD= JSON.parse(Response);
                
                if(infoBD.respuestaBD == ""){

                }
            }
        });
    });

    //FUNCION PARA ACTUALIZAR PARAMETROS DEL SISTEMA
    $("#InformacionSistema").on("click", function(){

        let nombreOrganizacion = document.querySelector("#").value;
        let nombreSistema = document.querySelector("#").value;
        let usuarioAdministrador = document.querySelector("#").value;
        $.ajax({
            url:"",
            datatype:"",
            data: { nombreOrganizacion:nombreOrganizacion, nombreSistema:nombreSistema, usuarioAdministrador:usuarioAdministrador },
            success: function(Response){

                let infoSistema = JSON.parse(Response);
                
                if(infoSistema.respuestaSistema == ""){

                }
            }
        });
    });
});