$(document).ready( function() {

    $("#restaurar").on("click", function (){

        $("#modal-restauracion").modal("show");
        $("#modal-restauracion").modal({backdrop: 'static', keyboard: false});

        $("#restaurarCopiaModal").on("click", async function(){

            let contrasena = document.querySelector("#contraRestauracion").value;
            let usuario = document.querySelector("#usuario").value;
            let path = document.querySelector("#path").value;

            if(contrasena === ""){
                Notificacion("warning", "Cuidado", "Debes de ingresar tu contrasena");
            } else if(contrasena.length <= 7){

                Notificacion("error", "Contraseña", "La contraseña esta por debajo de lo permitido");

            } else if(path === ""){
                Notificacion("error", "No seleccionado", "No haz seleccionado ningun archivo de recuperacion.");
            }else{
                $.ajax({
                    url:"./controlador/ctr.restauracion.php",
                    type:"POST",
                    datatype:"json",
                    data:{ contrasena:contrasena, usuario:usuario, path:path },
                    success: function (response){
                        let copia = JSON.parse(response)

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

                $("#CancelarRestauracion").on("click", async function(){
                    contrasena = $("#contraCopia").val('');
                });

            }

        });
    });


    //BOTON CANCELAR
    $("#CancelarRestauracion").on("click", function(){

        swal({
            icon:"warning",
            text: "Seguro que quieres salir?",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                contrasena4 = document.querySelector("#contrasenaSeguridad").value = "";
            } else {
            $("#modal-restauracion").modal("show");
            }
        });
        
    });

    $("#cerrarRest").on("click", function(){

        swal({
            icon:"warning",
            text: "Seguro que quieres salir?",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                contrasena4 = document.querySelector("#contrasenaSeguridad").value = "";
            } else {
            $("#modal-restauracion").modal("show");
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