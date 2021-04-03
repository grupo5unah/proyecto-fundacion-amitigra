$(document).ready(function() {

    $("#btnPregunta").on("click", async function(){

        let correo = document.querySelector("#correo").value;
        //let = document.querySelector("#").value;

        if(correo === ""){
            swal({
                icon:"error",
                title:"Correo",
                text:"El correo es oblogatorio"
            });
        }else{

            $.ajax({
                url:"../../controlador/verificar_correo.php",
                type:"POST",
                datatype:"json",
                data: { correo:correo },
                success: function(response){
                    let verificacion = JSON.parse(response);

                    if(verificacion.respuesta == "exito"){
                        swal({
                            icon:"success",
                            title:"Exito",
                            text:"Te estamos redirigiendo",
                            timer: 3500,
                            buttons: false
                        }).then( () => {
                            window.location.href = ("recuperacionPregunta.php");
                        });
                    } else if(verificacion.respuesta == "no_existe") {
                        swal({
                            icon:"error",
                            title:"Error",
                            text:`No existe usuario con correo ${correo}`
                        })
                    }
                }
            });
        }
    });

});