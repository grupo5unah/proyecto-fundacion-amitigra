$(document).ready(function(){
    //image: 'sampleImage.jpg', 

    
   
    function mayusculas(e) {
        e.value = e.value.toUpperCase();
    } 
    $("#typeP").change( function() {
        if ($(this).val() !== '3') {
            $("#Rprice").prop("disabled", true);
        } else {
            $("#Rprice").prop("disabled", false);
        }
    });
    

   
    $('.btnEditarProducto').on('click', function() {
        // info previa
        const idproduct = $(this).data('idproduct'); 
        const nombre = $(this).data('nomproducto');
        const precioP = $(this).data('preciop');
        const cantidadP = $(this).data('cantproducto');
        const descripcion = $(this).data('desc');
        const tipoProduct = $(this).data('tp');
        const precioAl = $(this).data('precioal');
        var usuario_actual = $("#usuario_actual").val();
        //llena los campos
        
        $("#product").val(nombre);
        $("#price").val(precioP);
        $("#count").val(cantidadP);
        $("#des").val(descripcion);
        $(' option[value="0"]').val(tipoProduct);
        $("#Rprice").val(precioAl);
               
     
        //mostrar el modal
        $('#modalEditarProductos').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdP = Number(idproduct); 
            //console.log(IdRol);
            const formData = new FormData();
            formData.append('id_product', IdP);
            formData.append('nameP',$("#product").val());
            formData.append('priceP',$("#price").val());
            formData.append('countP',$("#count").val());
            formData.append('desc',$("#des").val());
            formData.append('typeP',$("#typeP").val());
            formData.append('rentalP',$("#Rprice").val());
            formData.append('usuario_actual', usuario_actual);
          
            
           const resp = await axios.post('./controlador/api.php?action=actualizarProducto', formData);
           const data = resp.data;
           // console.log(data);
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
                    
                    $("#product").val('');
                    $("#price").val('');
                    $("#count").val('');
                    $("#des").val('');
                    //$("#opcion").val('');
                    $("#Rprice").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })
    //eliminar productos
    $('.btnDeleteP').on('click', function (){
        
        const idproduct = $(this).data('idp');
        console.log(idproduct);
        swal("Eliminar Producto", "Esta seguro de eliminar este Producto?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
            if (value){
                
                const formData = new FormData();
                formData.append('id_producto', idproduct);
                const resp = await axios.post('./controlador/api.php?action=eliminarProducto', formData);
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

    // Botones de reporte
     
   

}); 