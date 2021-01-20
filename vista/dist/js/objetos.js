$(document).ready(function(){
   
    $("#formObjeto").submit(async function(e){
        e.preventDefault();
        nombreObjeto
        var nombre = $("#nombreObjeto").val();
        var descripcion = $("#descripcionObjeto").val();
        var usuario_actual = $("#usuario_actual").val();

        console.log(nombre, descripcion, usuario_actual);
        if(nombre != undefined && descripcion != undefined && usuario_actual != undefined){
            const formData = new FormData();
            formData.append('objeto',nombre);
            formData.append('descripcion',descripcion);
            formData.append('usuario_actual', usuario_actual);

            const resp = await axios.post(`./controlador/apiObjetos.php?action=registrarObjeto`, formData);

            const data = resp.data;

            if(data.error){
                return swal("Error", data.msj, "error");
            }

            return swal("Exito!", data.msj, "success").then((value) => {
                    if (value){
                        // Se limpia el formulario
                        $("#nombreObjeto").val('');
                        $("#descripcionObjeto").val('');
                        
                    }
                })
        }else{
            swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
        } 
    });    
   
  
    $('#nombreObjeto').blur(async function () {
        //console.log('jhjsfjsh');
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/apiObjetos.php?action=obtenerObjeto&objeto=${this.value}`);
                const data = resp.data;
                if(data.objeto.length > 0){
                    console.log(data.objeto[0]);
                    $('#nombreObjeto')
                    $('#descripcionObjeto')
                    
                    return swal('Este Objeto ya existe ');
                }else{
                    //return swal('NO existe este producto');
                    console.log('hola');
                }
                
            }catch(err){
                console.log('Error - ', err);
            }
        }
    });
    $('.btnCrearObjeto').on('click',function(){
        $('#modalCrearObjeto').modal('show');
    } );
    //FUNCION EDITAR ROLES
    $('.btnEditarObjeto').on('click', function() {
        // info previa
        const idobjeto = $(this).data('idobjeto'); 
        const nombre = $(this).data('nombreobjeto');
        const descripcion = $(this).data('descripcion'); 
        //llena los campos
        //$("#id").val(idObjeto),
        $("#nombreObjeto").val(nombre),
        $("#descripcionObjeto").val(descripcion)
        
        //console.log(idrol,nombrerol,descripcion);
        //mostrar el modal
        $('#modalEditarObjeto').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdObjeto = Number(idobjeto); 
            //console.log(IdRol);
            const formData = new FormData();
            formData.append('id_objeto', IdObjeto);
            formData.append('objeto',$("#nombreObjeto").val());
            formData.append('descripcion',$("#descripcionObjeto").val());
            console.log(formData);
            
           const resp = await axios.post('./controlador/apiObjetos.php?action=actualizarObjeto', formData);
           const data = resp.data;
            console.log(data);
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
                    console.log('Ya se cerro el alert');
                    $("#nombreRol").val('');
                    $("#descripcion").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })
    //eliminar objetos
    $('.btnEliminarObjeto').on('click', function (){
        const idObjeto = $(this).data('idobjeto');
        swal("Eliminar Objeto", "Esta seguro de eliminar este Objeto?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
            if (value){
                console.log('Estoy dentro del if');
                const formData = new FormData();
                formData.append('id_objeto', idObjeto);
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
    })
    //mantenimientos de la tabla permisos
    $('.btnEditarPermisos').on('click', function() {
        // info previa
        const idpermiso = $(this).data('id_permisos'); 
        const PInsercion = $(this).data('PInsercion');
        const PEliminacion = $(this).data('Peliminacion'); 
        //llena los campos
        //$("#id").val(idObjeto),
        $("#PInsercion").val(PInsercion),
        $("#PEliminacion").val(PEliminacion)
        
        //console.log(idrol,nombrerol,descripcion);
        //mostrar el modal
        $('#modalEditarPermisos').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdPermisos = Number(idpermisos); 
            //console.log(IdRol);
            const formData = new FormData();
            formData.append('id_permisos', IdPermisos);
            formData.append('permiso_insercion',$("#PInsercion").val());
            formData.append('permiso_eliminacion',$("#PEliminacion").val());
            formData.append('permiso_actualizacion',$("#PActualizacion").val());
            formData.append('permiso_consulta',$("#PConsulta").val());
            console.log(formData);
            
           const resp = await axios.post('./controlador/apiObjetos.php?action=actualizarPermisos', formData);
           const data = resp.data;
            console.log(data);
            if(data.error){
                return swal("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarPermisos').modal('hide');
                return swal("Exito!", data.msj, "success", {
                    timer:3000,
                    buttons:false
                }).then(() => {
                    // Se limpia el formulario
                    console.log('Ya se cerro el alert');
                    $("#PInsercion").val('');
                    $("#PEliminacion").val('');
                    $("#PActualizacion").val('');
                    $("#PConsulta").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })

}); 