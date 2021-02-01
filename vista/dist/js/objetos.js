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
                    $("#nombreObjeto").val('');
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
        const idpermiso = $(this).data('idpermisos'); 
        const Insercion = $(this).data('insertar');
        const Eliminacion = $(this).data('eliminar');
        const Actualizacion = $(this).data('AActualizar');
        const Consulta = $(this).data('PConsulta'); 
        //llena los campos
        console.log(idpermiso);
        //$("#id").val(idObjeto),
        $("#Insertar").val(Insercion),
        $("#Eliminar").val(Eliminacion),
        $("#Actualizar").val(Actualizacion),
        $("#Cosulta").val(Consulta)
        
        console.log(idpermiso,Eliminacion,Insercion);
        //mostrar el modal
        $('#modalEditarPermisos').modal('show');
        
        
        $('.btnEditarBD').on('click', async function() {
            var IdPermisos = Number(idpermiso); 
            console.log(IdPermisos);
            const formData = new FormData();
            formData.append('id_permisos', IdPermisos);
            formData.append('permiso_insercion',$("#Insertar").val());
            formData.append('permiso_eliminacion',$("#Eliminar").val());
            formData.append('permiso_actualizacion',$("#Actualizar").val());
            formData.append('permiso_consulta',$("#Consulta").val());
           // console.log(formData);
            
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
                    timer:3000,
                    buttons:false
                }).then(() => {
                    // Se limpia el formulario
                    console.log('Ya se cerro el alert');
                    $("#Insertar").val('');
                    $("#Eliminar").val('');
                    $("#Actualizar").val('');
                    $("#Consulta").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })

}); 