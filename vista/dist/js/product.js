$(document).ready(function(){
    
    $('#manageProductTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }

     } );

    $("#formProducto").submit(async function(e){
        e.preventDefault();

        var nombre = $("#nombreP").val();
        var cantidad = $("#cantProducto").val();
        var precio = $("#precioProducto").val();
        var tipoProducto = $("#tipoProducto option:selected").val();
        var usuario_actual = $("#usuario_actual").val();

        // console.log(nombre, cantidad, precio, tipoProducto, usuario_actual);
        if(nombre != undefined && cantidad != undefined && precio != undefined && 
        tipoProducto != 0 && usuario_actual != undefined){
            const formData = new FormData();
            formData.append('nombreProducto',nombre);
            formData.append('cantidad',cantidad);
            formData.append('precio',precio);
            formData.append('tipo_producto', tipoProducto);
            formData.append('usuario_actual', usuario_actual);

            const resp = await axios.post(`./controlador/api.php?action=registrarProducto`, formData);

            const data = resp.data;

            if(data.error){
                return swal("Error", data.msj, "error");
            }

            return swal("Exito!", data.msj, "success").then((value) => {
                    if (value){
                        // Se limpia el formulario
                        $("#nombreP").val('');
                        $("#cantProducto").val('');
                        $("#precioProducto").val('');
                        $("#tipoProducto").val('0');
                    }
                })
        }else{
            swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
        } 
    });

    
    
    $('#nombreP').blur(async function () {
        //console.log(this.value);
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/api.php?action=obtenerProducto&nombreProducto=${this.value}`);
                const data = resp.data;
                if(data.producto.length > 0){
                    console.log(data.producto[0]);
                    $('#cantProducto')
                    $('#precioProducto')
                    $('#tipoProducto')
                    $('#cantProducto')
                    return swal('Este producto ya existe en el inventario');
                }else{
                    //return swal('NO existe este producto');
                }
                
            }catch(err){
                console.log('Error - ', err);
            }
        }
    })
  
    // Elimina un producto del inventario
    
    //console.log($('.btnEliminar'));
    $('.btnEliminar').on('click', function (){
        const idInventario = $(this).data('idproductodel');
        swal("Eliminar Producto", "Esta seguro de eliminar este producto?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
            if (value){
                console.log('Estoy dentro del if');
                const formData = new FormData();
                formData.append('id_inventario', idInventario);
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

    //EDITAR PRODUCTO EN EXISTENCIA
    $('.btnEditar').on('click', function() {
        // info previa
        const idproducto = $(this).data('idproducto'); 
        const nombreArti = $(this).data('nombrearti');
        const existencia = $(this).data('existencia'); 
        const costo = $(this).data('costo');
        //llena los campos
        $("#idproducto").val(idproducto),
        $("#nombreInven").val(nombreArti),
        //$("#cantInven").val(existencia),
        $("#precioInven").val(costo)
        
        
        //mostrar el modal
        $('#modalEditarProducto').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdProducto = Number(idproducto); 
            var cantSumar = Number(existencia)+Number($("#cantInven").val());            
            console.log('Estoy dentro del if', IdProducto);
            const formData = new FormData();
            formData.append('id_inventario', IdProducto);
            formData.append('nombre_inventario',$("#nombreInven").val());
            formData.append('existencia', cantSumar);
            formData.append('costo', Number($("#precioInven").val()));
            //console.log(IdProducto, $("#nombreInven").val(), $("#cantInven").val(), $("#precioInven").val())
            //console.log( 'El ID a enviar es: '+Number(idproducto);
            
            const resp = await axios.post('./controlador/api.php?action=actualizarProducto', formData);
            const data = resp.data;
            
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
                    $("#nombreInventa").val('');
                    $("#cantInven").val('');
                    $("#precioInve").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })
    
    
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
        
        
        //mostrar el modal
        $('#modalEditarRol').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdRol = Number(idrol); 
            const formData = new FormData();
            formData.append('id_rol', IdRol);
            formData.append('rol',$("#nombreRol").val());
            formData.append('rol',$("#descripcionRol").val());
            //console.log(IdProducto, $("#nombreInven").val(), $("#cantInven").val(), $("#precioInven").val())
            //console.log( 'El ID a enviar es: '+Number(idproducto);
            
            const resp = await axios.post('./controlador/api.php?action=actualizarProducto', formData);
            const data = resp.data;
            
            if(data.error){
                return alert("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarProducto').modal('hide');
                return alert("Exito!", data.msj, "success", {
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

    //MANTENIMIENTO PARÁMETROS
    //FUNCION EDITAR PARÁMETROS
    $('.btnEditarParam').on('click', function() {
        // info previa
        const idparametro = $(this).data('idparametro'); 
        const nombreparametro = $(this).data('nombreparametro');
        const valor = $(this).data('valor'); 
        //llena los campos
        $("#idparam").val(idparametro),
        $("#nombreParam").val(nombreparametro),
        $("#valorParam").val(valor)
        
        
        //mostrar el modal
        $('#modalEditarParam').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdRol = Number(idparametro); 
            const formData = new FormData();
            formData.append('id_parametro', IdRol);
            formData.append('parametro',$("#nombreParam").val());
            formData.append('valor',$("#valorParam").val());
            //console.log(IdProducto, $("#nombreInven").val(), $("#cantInven").val(), $("#precioInven").val())
            //console.log( 'El ID a enviar es: '+Number(idproducto);
            
            const resp = await axios.post('./controlador/api.php?action=actualizarProducto', formData);
            const data = resp.data;
            
            if(data.error){
                return alert("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarProducto').modal('hide');
                return alert("Exito!", data.msj, "success", {
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


    //FUNCION EDITAR PREGUNTA
    $('.btnEditarPreg').on('click', function() {
        // info previa
        const idpregunta = $(this).data('idpregunta'); 
        const pregunta = $(this).data('nompregunta'); 
        //llena los campos
        $("#idpregunta").val(idpregunta),
        $("#nombrePregunta").val(pregunta);
        
        //mostrar el modal
        $('#modalEditarPregunta').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdRol = Number(idpregunta); 
            const formData = new FormData();
            formData.append('id_pregunta', IdRol);
            formData.append('pregunta',$("#nombrePregunta").val());
            //console.log(IdProducto, $("#nombreInven").val(), $("#cantInven").val(), $("#precioInven").val())
            //console.log( 'El ID a enviar es: '+Number(idproducto);
            
            const resp = await axios.post('./controlador/api.php?action=actualizarProducto', formData);
            const data = resp.data;
            
            if(data.error){
                return alert("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarProducto').modal('hide');
                return alert("Exito!", data.msj, "success", {
                    timer:3000,
                    buttons:false
                }).then(() => {
                    // Se limpia el formulario
                    console.log('Ya se cerro el alert');
                    $("#nombrePregunta").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })


    
});