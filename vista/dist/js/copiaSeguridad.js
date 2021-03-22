$(document).ready( function() {

    $("#guardarCopia").on("click", function (){

        $("#modal-copia").modal("show");
        $("#modal-copia").modal({backdrop: 'static', keyboard: false});

        $("#guardarCopiaModal").on("click", async function(){

            let contrasena = document.querySelector("#contraCopia").value;
            let usuario = document.querySelector("#usuario").value;

            if(contrasena === ""){
                Notificacion("warning", "Cuidado", "Debes de ingresar tu contrasena");
            } else if(contrasena.length <= 7){

                Notificacion("error", "Contrasena", "La contrasena no cumple los requisitos");

            } else{
                $.ajax({
                    url:"./controlador/ctr.backup.php",
                    type:"POST",
                    datatype:'json',
                    data:{ contrasena:contrasena, usuario:usuario },
                    success: function (response){
                        let copia = JSON.parse(response);

                        //SI SE REALIZO CON EXITO LA COPIA DE SEGURIDAD
                        if(copia.respuesta == "exito"){
                            swal({
                                icon:"success",
                                title:"Exito",
                                text:"Copia de seguridad creada correctamente"
                            }).then(() => {
                                location.reload();
                            });

                        //SI LA CONTRASENA NO COINCIDE CON LA DE LA BD
                        }else if(copia.respuesta == "incorrecta"){

                            Notificacion("error", "Error contrasena", "La contrasena ingresada es incorrecta");
                        
                        //SI LA CONTRASENA NO CUMPLE CON LOS PARAMETROS
                        }else if(copia.respuesta == "no_contrasena"){
                           
                            Notificacion("error", "Error contrasena", "La contrasena es incorrecta");
                        
                        }
                    }
                });
            }

        });
    });

    function Notificacion(icon, title, text){
        swal({
            icon,
            title,
            text
        });
    }

});