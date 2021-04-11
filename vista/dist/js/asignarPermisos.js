$(document).ready( function(){

    $("#btnAsignarPermisos").on("click", function(){

        let usuario = document.querySelector("#usuario").value;
        let rol = document.querySelector("#nombre").value;
        let objeto_id = document.querySelector("#objeto").value;
        let insertar = document.querySelector("#insertar").value;
        let actualizar = document.querySelector("#actualizar").value;
        let eliminar = document.querySelector("#eliminar").value;
        let consultar = document.querySelector("#consultar").value;
        
        if(objeto_id.length === 0){

            Notification("error","Seleccion","No haz seleccioando ninguna pantalla");
        
        } else if(insertar == "" || actualizar == "" || eliminar == "" || consultar ==""){
            
            Notification("error","Seleccionado","No haz seleccionado ningun permiso");
        
        } else{

            //VALIDAR EL ESTADO DEL CHECKBOX INSERTAR
            if($("#insertar").is(':checked')) {  
                insertar = 1;
              } else {
                insertar = 0;  
              }
            
              //VALIDAR EL ESTADO DEL CHECKBOX ACTUALIZAR
              if($("#actualizar").is(':checked')) {  
                actualizar = 1;
              } else {
                actualizar = 0;  
              }
    
              //VALIDAR EL ESTADO DEL CHECKBOX ELIMINAR
              if($("#eliminar").is(':checked')) {  
                eliminar = 1;
              } else {
                eliminar = 0;  
              }
    
              //VALIDAR EL ESTADO DEL CHECKBOX CONSULTAR
              if($("#consultar").is(':checked')) {  
                consultar = 1;
              } else {
                consultar = 0;  
              }

            $.ajax({
                url:"./controlador/ctr.asignarPermisos.php",
                type: "post",
                datatype: "json",
                data: { usuario:usuario, rol:rol, objeto_id:objeto_id, insertar:insertar, actualizar:actualizar,
                        eliminar:eliminar, consultar:consultar },
                success: function(response){

                    console.log(rol);
                    let asignarPermiso = JSON.parse(response);

                    if(asignarPermiso.respuesta == "exito"){

                        swal({
                            icon:"success",
                            title: "Exito",
                            text: "Se registro con exito el permiso"
                        }).then(()=>{
                            //REINICIAR LAS CAJAS DE TEXTO
                            $("#objeto").val("");
                            $("#insertar").prop("checked", false);
                            $("#actualizar").prop("checked", false);
                            $("#eliminar").prop("checked", false);
                            $("#consultar").prop("checked", false);
                        });

                    } else if(asignarPermiso.respuesta == "error"){

                        Notification("error", "Insercion", "No se pudieron registrar los permisos");

                    } else if(asignarPermiso.respuesta == "rol_noExiste"){

                        Notification("error","Usuario","El usuario no existe");

                    } else if(asignarPermiso.respuesta == "usuario_noExiste"){

                        Notification("error","Rol","El rol no existe");

                    }
                }
            });
        }
    });

    //FUNCION PARA LAS NOTIFICACIONES
    function Notification(icon,title, text){
        swal({
            icon,
            title,
            text
        })
    }

    //FUNCION PARA CERRAR LA VENTANA MODAL ASIGNAR PERMISOS
    $("#cerrarModalPermisos").on("click", function(){

        swal({
            icon:"warning",
            text: "Seguro que quieres salir?",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // contrasena4 = document.querySelector("#contrasenaSeguridad").value = "";
                // $("#contraRestauracion").val("");
                $("#modalPermisos").modal("close");
            $("#modalRegistrarRol").modal("close");
            } else {

                $("#modalPermisos").modal("show");
            // $("#modalRegistrarRol").modal("show");

            }
        });

    });

});