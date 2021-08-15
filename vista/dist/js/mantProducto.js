$(document).ready(function(){

    function mayusculas(e) {
        e.value = e.value.toUpperCase();
    } 
  
    
    

   
    $('.btnEditarProducto').on('click', function() {
        // info previa
        const idproduct = $(this).data('id_producto');
        const nombre = $(this).data('nomproducto');
        const precioP = $(this).data('preciop');
        const descripcion = $(this).data('desc');
        const minimo =$(this).data('minimo');
        const maximo =$(this).data('maximo');
         const id_tipo_p =$(this).data('id_tipo_producto');
        var usuario_actual = $("#usuario_actual").val();
        var id_objeto = $("#id_objeto").val();
        var idUsuario = $("#id_usuario").val();

    
        //llena los campos
        $("#product").val(nombre);
        $("#price").val(precioP);
        $("#minimo").val(minimo);
        $("#des").val(descripcion);
        $('#typeP').val(id_tipo_p);
        $("#maximo").val(maximo);
       
           //mostrar el modal
        $('#modalEditarProductos').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdP = Number(idproduct); 

            const formData = new FormData();
            formData.append('id_product', IdP);
            formData.append('nameP',$("#product").val());
            formData.append('priceP',$("#price").val());
            formData.append('desc',$("#des").val());
            formData.append('typeP',$("#typeP").val());
            formData.append('minimo',$("#minimo").val());
            formData.append('maximo',$("#maximo").val());
            formData.append('usuario_actual', usuario_actual);
            formData.append('id_usuario', idUsuario);
            formData.append('id_objeto', id_objeto);
          
            
            axios.post('./controlador/api.php?action=actualizarProducto', formData).then(res=>{
                console.log(res);
           const data = res.data;
                if(data.error){
                    return swal("Error", data.msj, "error", {
                        timer:3000,
                        buttons:false
                    });
                } else{
                    $('#modalEditarProductos').modal('hide');
                    return swal("Exito!", data.msj, "success", {
                        timer:3000,
                        buttons:false
                    }).then(() => {
      
                        $("#minimo").val('');
                   
                        $("#maximo").val('');
                        location.reload(); 
                    })
 
            
                } 
                
        });
     })
        
    })
    //eliminar productos
    $('.btnDeleteP').on('click', function (){
        
        const idproduct = $(this).data('idp');
        var id_objeto = $("#id_objeto").val();
        var idUsuario = $("#id_usuario").val();
        
        
        swal("Eliminar Producto", "¿Esta seguro de eliminar este Producto?", "warning",{buttons:["Cancelar","Aceptar"] ,dangerMode:true}).then(async (value) => {
            if (value){   
                 
                const formData = new FormData();
                formData.append('id_producto', idproduct);
                formData.append('id_usuario', idUsuario);
                formData.append('id_objeto', id_objeto);
                const resp = await axios.post('./controlador/api.php?action=eliminarProducto', formData);
                const data = resp.data;
               
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

   /// mantenimiento a tipo movimiento
   $("#formMovi").submit(async function(e){
    e.preventDefault();
    
    var nombre = $("#movimiento").val();
    var usuario_actual = $("#usuario_actual").val();
    var id_objeto = $("#id_objeto").val();
    var idUsuario = $("#id_usuario").val();

    //console.log(nombre, descripcion, usuario_actual);
    if(nombre != undefined && usuario_actual != undefined){
        const formData = new FormData();
        formData.append('movimiento',nombre);
        formData.append('usuario_actual', usuario_actual);
        formData.append('id_usuario', idUsuario);
        formData.append('id_objeto', id_objeto);

        const resp = await axios.post(`./controlador/api.php?action=registrarTipoMovimiento`, formData);

        const data = resp.data;

        if(data.error){
            return swal("Error", data.msj, "error");
        }

        return swal("Exito!", data.msj, "success",{
            timer:2000,
            buttons:false

        }).then(() => {
               
                    // Se limpia el formulario
                    $("#movimiento").val('');
                    location.reload();
            })
            ;
    }else{
        swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    } 
   
    });    


    $('#movimiento').blur(async function () {

    if(this.value.length > 0 ){
        try{
            const resp = await axios(`./controlador/api.php?action=obtenerTipoMovimiento&movimiento=${this.value}`);
            const data = resp.data;
            if(data.movimiento.length > 0){
                $('#movimiento')
                return swal('Este Tipo Movimiento ya existe ');
               
            }
            
        }catch(err){
            console.log('Error - ', err);
        }
    }
    });
    $('.btnMovimiento').on('click',function(){
    $('#modalCrearMovimiento').modal('show');
   } );

   //cerrar modal tipo movimiento
   $("#cerrarCTM").on("click", function(){

    swal({
        icon:"warning",
        title: "¿Desea salir?",
        text:" Si acepta se perderá la información.",
        
        buttons:[ "Cancelar","Aceptar",], 
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
                          
            $("#modalCrearMovimiento").modal("hide");
            location.reload(); 
            
        } else {

            $("#modalCrearMovimiento").modal("show");
        
        }
    });

    });



   //FUNCION EDITAR tipo Movimiento
  $('.btnEditarMovimiento').on('click', function() {
    // info previa
    const id_mo = $(this).data('id_mo'); 
    const nombre_mo = $(this).data('movimientos');
    var usuario_actual = $("#usuario_actual").val();
    var id_objeto = $("#id_objeto").val();
    var idUsuario = $("#id_usuario").val();

    //llena los campos
    //$("#idrol").val(idrol),
    $("#Movi").val(nombre_mo);
    //mostrar el modal
    $('#modalEditarMovimiento').modal('show');
    
    $('.btnEditarBD').on('click', async function() {
        var IdMO = Number(id_mo); 
        const formData = new FormData();
        formData.append('id_movimiento', IdMO);
        formData.append('movimiento',$("#Movi").val());
        formData.append('usuario_actual', usuario_actual);
        formData.append('id_usuario', idUsuario);
        formData.append('id_objeto', id_objeto);
        
       const resp = await axios.post('./controlador/api.php?action=actualizarTipoMovimiento', formData);
       const data = resp.data;
        console.log(data);
        if(data.error){
            return swal("Error", data.msj, "error", {
                timer:3000,
                buttons:false
            });
        } else{
            $('#modalEditarMovimiento').modal('hide');
            return swal("Exito!", data.msj, "success", {
                timer:3000,
                buttons:false
            }).then(() => {
                $("#movimiento").val('');
                location.reload(); 
            })
        }
            
    });
    
  })

  //cerrar modal editar tipo movimiento
  $("#cerrarATM").on("click", function(){

    swal({
        icon:"warning",
        title: "¿Desea salir?",
        text:" Si acepta se perderá la información.",
        
        buttons:[ "Cancelar","Aceptar",], 
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
                          
            $("#modalEditarMovimiento").modal("hide");
            location.reload(); 
            
        } else {

            $("#modalEditarMovimiento").modal("show");
        
        }
    });

    });

//eliminar 
$('.btnEliminarmovimiento ').on('click', function (){
    const id_mo = $(this).data('idmovimiento');
    
    var id_objeto = $("#id_objeto").val();
    var idUsuario = $("#id_usuario").val();
    swal("Eliminar Tipo Movimiento", "¿Esta seguro de eliminar este Tipo de Movimiento?", "warning",{buttons:["Cancelar","Aceptar"] ,dangerMode:true}).then(async (value) => {
        if (value){
            const formData = new FormData();
            formData.append('id_movimiento', id_mo);
            formData.append('id_usuario', idUsuario);
            formData.append('id_objeto', id_objeto);
            const resp = await axios.post('./controlador/api.php?action=eliminarTipoMovimiento', formData);
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

//cerrar el modal
$("#cerrarModalcrearP").on("click", function(){

    swal({
        icon:"warning",
        title: "¿Desea salir?",
        text:" Si acepta se perderá la información.",
        
        buttons:[ "Cancelar","Aceptar",], 
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
                          
        $("#modalCrearProducto").modal("hide");
             //llena los campos
        $("#nombreP").val("");
        $("#precioProducto").val("");
        $("#descripcion").val("");
        $("#tipoProducto").val("");
        $('#minimos').val("");
        $("#maximoss").val("");
        location.reload(); 
        } else {

            $("#modalCrearProducto").modal("show");
        // $("#modalRegistrarRol").modal("show");

        }
    });

     }); 

     $("#cerrarModalActualizarP").on("click", function(){

        swal({
            icon:"warning",
            title: "¿Desea salir?",
            text:" Si acepta se perderá la información.",
            
            buttons:[ "Cancelar","Aceptar",], 
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                              
                $("#modalEditarProductos").modal("hide");
                location.reload(); 
            } else {
    
                $("#modalEditarProductos").modal("show");
            // $("#modalRegistrarRol").modal("show");
    
            }
        });
    
             });



}); 