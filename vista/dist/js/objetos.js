$(document).ready(function(){
   
    //registra objetos
    $("#formObjeto").submit(async function(e){
        e.preventDefault();
        
        var nombre = $("#nombreObjeto").val();
        var tipo_objeto = $("#tObjeto").val();
        var descripcion = $("#descripcion").val();
        var usuario_actual = $("#usuario_actual").val();
        var idUsuario = $("#id_usuario").val();
        var id_objeto = $("#id_objeto").val();

        if(nombre != undefined && tipo_objeto != undefined && descripcion != undefined && usuario_actual != undefined){
            const formData = new FormData();
            formData.append('objeto',nombre);
            formData.append('tipo_objeto',tipo_objeto);
            formData.append('descripcion',descripcion);
            formData.append('usuario_actual', usuario_actual);
            formData.append('id_usuario', idUsuario);
            formData.append('id_objeto', id_objeto);

            const resp = await axios.post(`./controlador/apiObjetos.php?action=registrarObjeto`, formData);

            const data = resp.data;

            if(data.error){
                return swal("Error", data.msj, "error");
            }

            return swal("Exito!", data.msj, "success",{
                buttons: false,
                timer: 3000,
            }).then(() => {
                 
                        // Se limpia el formulario
                        $("#nombreObjeto").val('');
                        $("#tObjeto").val('');
                        $("#descripcion").val('');
                        location.reload()
                    
                   
                })
        }else{
            swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
        } 
    })

    $('.btnCrearObjeto').on('click',function(){
        $('#modalCrearObjeto').modal('show');
       } ); 
       $('#nombreObjeto').blur(async function () {
        console.log('jhjsfjsh');
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/apiObjetos.php?action=obtenerObjeto&objeto=${this.value}`);
                const data = resp.data;
                if(data.objeto.length > 0){
                    console.log(data.objeto[0]);
                    $('#nombreObjeto')
                   // $('#descripcion')
                    
                    return swal('Este Objeto ya existe ');
                }else{
                    //return swal('NO existe este producto');
                }
                
            }catch(err){
                console.log('Error - ', err);
            }
        }
    });   

    //cerrar modal crear objeto
    $("#cerrarModalRe").on("click", function(){

        swal({
            icon:"warning",
            title: "¿Seguro que quieres salir?",
            text:" Si acepta se perderá la información.",
            
            buttons:[ "Cancelar","Aceptar",], 
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                              
                $("#modalCrearObjeto").modal("hide");
                location.reload();
                                
            } else {
    
                $("#modalCrearObjeto").modal("show");
            
            }
        });

    });
    
    
    //FUNCION EDITAR objeto
    $('.btnEditarObjeto').on('click', function() {
        // info previa
        const idobjeto = $(this).data('idobjeto'); 
        const nombre = $(this).data('nombreobjeto');
        const tipo_Objeto = $(this).data('tipo_objeto');
        const descripcion = $(this).data('descripcion'); 
        var usuario_actual = $("#usuario_actual").val();
        var idUsuario = $("#id_usuario").val();
        var id_objeto = $("#id_objeto").val();
        //llena los campos
        //$("#id").val(idObjeto),
        $("#nombre_Objeto").val(nombre),
        $("#tipo_Objeto").val(tipo_Objeto),
        $("#descripcionObjeto").val(descripcion)
        
        //console.log(idrol,nombrerol,descripcion);
        //mostrar el modal
        $('#modalEditarObjeto').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdObjeto = Number(idobjeto); 
            //console.log(IdRol);
            const formData = new FormData();
            formData.append('id_objeto', IdObjeto);
            formData.append('objeto',$("#nombre_Objeto").val());
            formData.append('tipo_objeto',$("#tipo_Objeto").val());
            formData.append('descripcion',$("#descripcionObjeto").val());
            formData.append('usuario_actual', usuario_actual);
            formData.append('id_usuario', idUsuario);
            formData.append('id_objetos', id_objeto);
          
            
           const resp = await axios.post('./controlador/apiObjetos.php?action=actualizarObjeto', formData);
           const data = resp.data;
           // console.log(data);
            if(data.error){
                return swal("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarObjeto').modal('hide');
                return swal("Exito!", data.msj, "success", {
                    timer:3000,
                    buttons:false
                }).then(() => {
                    // Se limpia el formulario
                    
                    $("#nombre_Objeto").val('');
                    $("#tipo_Objeto").val('');
                    $("#descripcion").val('');
                    location.reload(); 
                })
            }
                
        });
        
    });

    ////cerrar modal editar objeto
    $("#cerrarModalAO").on("click", function(){

        swal({
            icon:"warning",
            title: "¿Seguro que quieres salir?",
            text:" Si acepta se perderá la información.",
            
            buttons:[ "Cancelar","Aceptar",], 
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                              
                $("#modalEditarObjeto").modal("hide");
                location.reload();
                                
            } else {
    
                $("#modalEditarObjeto").modal("show");
            
            }
        });

    });


    //eliminar objetos
    $('.btnEliminarObjeto').on('click', function (){
        const idObjeto = $(this).data('idobjeto');
        var idUsuario = $("#id_usuario").val();
        var id_objeto = $("#id_objeto").val();
        swal("Eliminar Objeto", "Esta seguro de eliminar este Objeto?", "warning",{buttons:["Cancelar","Aceptar"] ,dangerMode:true}).then(async (value) => {
            if (value){
                const formData = new FormData();
                formData.append('id_objeto', idObjeto);
                formData.append('id_usuario', idUsuario);
                formData.append('id_objeto', id_objeto);
                const resp = await axios.post('./controlador/apiObjetos.php?action=eliminarObjetos', formData);
                const data = resp.data;
                //console.log(data);
                if(data.error){
                    return swal("Error", data.msj, "error",{
                        buttons: false,
                        timer: 3000
                    });
                }
                return swal("Exito!", data.msj, "success",{
                    buttons: false,
                    timer: 3000
                }).then(() =>{ 
                    location.reload();
                });
            }
        });
    });


    //mantenimientos de la tabla permisos
    $('.btnEditarP').on('click', function() {
        // info previa
        console.log('hola');
        const rol = $(this).data('rol');
        const mi_objeto = $(this).data('objeto');
        const idpermiso = $(this).data('idpermiso'); 
        const Insercion = $(this).data('insercion');
        const Eliminacion = $(this).data('eliminar');
        const Actualizacion = $(this).data('actualizacion');
        const Consulta = $(this).data('consulta'); 
        var usuario_actual = $("#usuario_actual").val();
        var idUsuario = $("#id_usuario").val();
        var id_objeto = $("#id_objeto").val();
        //llena los campos
        $("#Rol").val(rol);
        $("#Objeto").val(mi_objeto);
        $("#Insertar").val(Insercion);
        $("#Eliminar").val(Eliminacion);
        $("#Actualizar").val(Actualizacion);
        $("#Consulta").val(Consulta);

        console.log(typeof(idpermiso),typeof(Eliminacion),typeof(Insercion),typeof(Actualizacion),typeof(Consulta,typeof(usuario_actual)));
        //mostrar el modal
        $('#modalEditarPermisos').modal('show');
       
        $('.btnEditarBD').on('click', async function() {
            var IdPermisos = Number(idpermiso); 
          
            const formData = new FormData();
            formData.append('id_permiso', IdPermisos);
            formData.append('permiso_insercion',$("#Insertar").val());
            formData.append('permiso_eliminacion',$("#Eliminar").val());
            formData.append('permiso_actualizacion',$("#Actualizar").val());
            formData.append('permiso_consulta',$("#Consulta").val());
            formData.append('usuario_actual', usuario_actual);
            formData.append('id_usuario', idUsuario);
            formData.append('id_objetoS', id_objeto);
            
           const resp = await axios.post('./controlador/apiObjetos.php?action=actualizarPermiso', formData);
           const data = resp.data;
           // console.log(data);
            if(data.error){
                return swal("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarPermisos').modal('hide');
                return swal("Exito!", data.msj, "success", {
                    timer:1000,
                    buttons:false
                }).then(() => {
                    // Se limpia el formulario

                    $("#Insertar").val('');
                    $("#Eliminar").val('');
                    $("#Actualizar").val('');
                    $("#Consulta").val('');
                    location.reload(); 
                })
            }
                
        });
        
    });
    
    function mayusculas(e) {
        e.value = e.value.toUpperCase();
    }

}); 