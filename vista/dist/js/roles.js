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

}); 
