$(document).ready(function(){

    //FUNCION INICIO DE SESION
    $("#eliminar_bit").on('click', async function(){

        let fecha_inicio = document.querySelector("#start_date").value;
        let fecha_final = document.querySelector("#end_date").value;

        if(fecha_inicio === "" && fecha_final === ""){
            swal({
                icon:"error",
                title:"Campos vacios",
                text:"No haz ingresado un rango de fecha para eliminar registros.",
                button: "Aceptar"
            });
        } else{
            $.ajax({
                url:"../../controlador/ctr.eliminarBitacora.php",
                type:"POST",
                datatype:'json',
                data:{ fecha_inicio:fecha_inicio, fecha_final:fecha_final },
                success: function(response){
                    let eliminar_bitacora = JSON.parse(response);

                    if(eliminar_bitacora.respuesta == "eliminar_bitacora"){

                        swal({
                            icon:"success",
                            title:"Datos eliminados",
                            text:"Se han eliminado los registros correctamente.",
                            timer: 2500,
                            buttons:false
                            
                        })
                        .then(() => {

                            window.location.href=("../../bitacora.php");
                        });

                    } else if (usuario_existe.respuesta == "no_datos"){

                        swal({
                            icon:"error",
                            title:"Lo sentimos",
                            text:"No se pudieron eliminar los registros."
                        }).then(() => {
                            $("#P_Password").val("");
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