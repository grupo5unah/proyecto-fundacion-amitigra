$(document).ready(function(){
    //REGISTRAR NUEVO CLIENTE
    $("#formEstado").submit(async function(e){
        e.preventDefault();
        
        var nombreEstado = $("#nombreE").val();
        var descripcion = $("#descrip").val();
        var usuario_actual = $("#usuario_actual").val();

        if(nombreEstado != undefined && descripcion != undefined &&usuario_actual != undefined){
            const formData = new FormData();
            formData.append('nombreE',nombreEstado);
            formData.append('descrip',descripcion);
            formData.append('usuario_actual', usuario_actual);

            const resp = await axios.post(`./controlador/ctr.mantEstado.php?action=registrarEstado`, formData);

            const data = resp.data;

            if(data.error){
                return swal("Error", data.msj, "error");
            }

            return swal("Exito!", data.msj, "success").then((value) => {
                    if (value){
                        // Se limpia el formulario
                        $("#nombreE").val('');
                        $("#descrip").val('');
                        location.reload()
                    }
                   
                })
        }else{
            swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
        } 
    }); 
    //BUSCAR CLIENTE   
    $('#nombreE').blur(async function () {
        console.log(this.value);
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/ctr.mantEstado.php?action=obtenerEstado&estado=${this.value}`);
                const data = resp.data;
                if(data.estado.length > 0){
                //    console.log(data.objeto[0]);
                    $('#nombreE')
                    $('#descrip')
                   
                    return swal('Este Estado ya existe ');
                }
            }catch(err){
                console.log('Error - ', err);
            }
        }
    })
    $('.btnCrearEstado').on('click',function(){
        $('#modalCrearEstado').modal('show');
    } );
    //FUNCION EDITAR CLIENTE
    $('.btnEditarEstado').on('click', function() {
        // info previa
        const idestado = $(this).data('idestado');
        const nombreestad = $(this).data('nombre');
        const descrip = $(this).data('descripcion');
        const usuario =$(this).data('#usuario_actual');
        //llena los campos
        //$("#id").val(idObjeto),
        $("#nombreEstado").val(nombreestad),
        $("#descripcion").val(descrip),
        $("#usuario_actual").val(usuario)
        
        //console.log(idrol,nombrerol,descripcion);
        //mostrar el modal
        $('#modalEditarEstado').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var idEstado = Number(idestado); 
            //console.log(idEstado);
            const formData = new FormData();
            formData.append('id_estado', idEstado);
            formData.append('estado',$("#nombreEstado").val());
            formData.append('descripcion',$("#descripcion").val());;
            formData.append('usuario_actual',$("#usuario_actual").val());
            console.log(formData);
            
           const resp = await axios.post('./controlador/ctr.mantEstado.php?action=actualizarEstado', formData);
           const data = resp.data;
           // console.log(data);
            if(data.error){
                return swal("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarEstado').modal('hide');
                return swal("Exito!", data.msj, "success", {
                    timer:3000,
                    buttons:false
                }).then(() => {
                    // Se limpia el formulario
                    console.log('Ya se cerro el alert');
                    $("#nombreEstado").val('');
                    $("#descripcion").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })
    //ELIMINAR CLIENTE
    $('.btnEliminarEstado').on('click', function (){
        const idEsta = $(this).data('idestad');
        swal("Eliminar Estado", "Esta seguro de eliminar este Estado?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
            if (value){
                //console.log('Estoy dentro del if');
                const formData = new FormData();
                formData.append('id_estad', idEsta);
                const resp = await axios.post('./controlador/ctr.mantEstado.php?action=eliminarEstado', formData);
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