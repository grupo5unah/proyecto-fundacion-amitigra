$(document).ready(function(){
   
    $("#formRol").submit(async function(e){
        e.preventDefault();
        
        var nombre = $("#nombre").val();
        var descripcion = $("#descripcion").val();
        var usuario_actual = $("#usuario_actual").val();

        console.log(nombre, descripcion, usuario_actual);
        if(nombre != undefined && descripcion != undefined && usuario_actual != undefined){
            const formData = new FormData();
            formData.append('rol',nombre);
            formData.append('descripcion',descripcion);
            formData.append('usuario_actual', usuario_actual);

            const resp = await axios.post(`./controlador/apiRol.php?action=registrarRol`, formData);

            const data = resp.data;

            if(data.error){
                return swal("Error", data.msj, "error");
            }

            return swal("Exito!", data.msj, "success").then((value) => {
                    if (value){
                        // Se limpia el formulario
                        $("#nombreRol").val('');
                        $("#descripcion").val('');
                        
                    }
                })
        }else{
            swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
        } 
    });    
   
  
    $('#nombre').blur(async function () {
        console.log('jhjsfjsh');
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/apiRol.php?action=obtenerRol&rol=${this.value}`);
                const data = resp.data;
                if(data.rol.length > 0){
                    console.log(data.rol[0]);
                    $('#nombre')
                    $('#descripcion')
                    
                    return swal('Este rol ya existe ');
                }else{
                    //return swal('NO existe este producto');
                }
                
            }catch(err){
                console.log('Error - ', err);
            }
        }
    });
    $('.btnCrearRol').on('click',function(){
        $('#modalRegistrarRol').modal('show');
       } );
       //FUNCION EDITAR ROLES
    $('.btnEditarRol').on('click', function() {
        // info previa
        const idrol = $(this).data('idrol'); 
        const nombrerol = $(this).data('nombrerol');
        const descripcion = $(this).data('descripcion'); 
        //llena los campos
        $("#idrol").val(idrol),
        $("#nombreRol").val(nombrerol),
        $("#descripcionRol").val(descripcion)
        
        //console.log(idrol,nombrerol,descripcion);
        //mostrar el modal
        $('#modalEditarRol').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdRol = Number(idrol); 
            console.log(IdRol);
            const formData = new FormData();
            formData.append('id_rol', IdRol);
            formData.append('rol',$("#nombreRol").val());
            formData.append('descripcion',$("#descripcionRol").val());
            console.log(formData);
            
           const resp = await axios.post('./controlador/apiRol.php?action=actualizarRol', formData);
           const data = resp.data;
            console.log(data);
            if(data.error){
                return swal("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarProducto').modal('hide');
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
    //eliminar roles
    $('.btnEliminarRol').on('click', function (){
        const idRol = $(this).data('idrol');
        swal("Eliminar Rol", "Esta seguro de eliminar este Rol?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
            if (value){
                console.log('Estoy dentro del if');
                const formData = new FormData();
                formData.append('id_rol', idRol);
                const resp = await axios.post('./controlador/apiRol.php?action=eliminarRol', formData);
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

}); 

