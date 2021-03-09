$(document).ready(function(){


     //const btnsEliminar = document.querySelectorAll('.btnEliminarP');
     const contenedorProducto= $('#productTable  .tbody');
     const vaciarTablaBtn = document.querySelector('#vaciarTabla');
     const btnRegistrarInventario = $("#registrarInventario");
     const listaProduct = $('#btnAddList');
     let articulosProducto = [];       
     // funciones de producto
    function agregarProducto(e){

        e.preventDefault();
        const infoProducto = {
            //crea un objeto con el contenido del formulario
            nombreProducto : $('#nombreP').val(),
            precioP : $('#precioProducto').val(),
            cantidadP : $('#cantProducto').val(),
            tipoProducto : {
                id: $("#tipoProducto").val(),
                nombre: $("#tipoProducto option:selected").text()
            }
            // id : producto.querySelector('button').getAttribute('data-nombre')
        }
        console.log(infoProducto);
        // agrergo el producto al arreglo
        articulosProducto = [...articulosProducto, infoProducto];
        if(articulosProducto.length > 0) sincronizarStorage(articulosProducto)
        //agrega  art a la tabla
        llenarTabla();
    }
    //elimina un producto dela  tabla
    const eliminarProducto = (index = -1) => {
        console.log('Indice a eliminar: ',index);
        //articulosProducto.splice(index, 1);
        
    }
    function llenarTabla(){
        $('.tbody tr').remove();
        articulosProducto.forEach((producto, index) => agregarFila(producto, index));
    }
    // muestra el carrito de compras en el html
    function agregarFila(producto = {}, index = -1){
        const{nombreProducto, precioP, cantidadP, tipoProducto} = producto;
        contenedorProducto.append(`
        <tr>
            <td>${nombreProducto}</td>
            <td>${precioP}</td>
            <td>${cantidadP}</td>
            <td>${tipoProducto.nombre}</td>
            <td>
                <button class="btn btn-warning btnEditar Producto glyphicon glyphicon-pencil" data-id="${index}"></button>
                <button class="btn btn-danger btnEliminarP glyphicon glyphicon-remove" data-id="${index}"></button>
            </td>  
        </tr>
        `);
        $('.btnEliminarP').on('click', (e)=>{
           let id = e.target.dataset.id;
           swal('Eliminar producto','Esta seguro que desea eliminar este producto?','warning',{
               buttons: ['Cancelar', 'Aceptar']
           })
            .then((resp) => {
                if(resp){
                    articulosProducto.splice(id, 1);
                    sincronizarStorage(articulosProducto);
                    llenarTabla();
                }
            })

        });
        // agregar el producto  a local storage
        //sincronizarStorage();
    }
    function cargarStorage(){
        const productsStorage = localStorage.getItem('productos');
        if(!productsStorage){
            localStorage.setItem('productos',JSON.stringify([]));
        }else{
            articulosProducto = JSON.parse(productsStorage);
            console.log(articulosProducto);
            llenarTabla();
        }
    };
 
    function sincronizarStorage(data=[]){
        if(data.length > 0) localStorage.setItem('productos',JSON.stringify(data));
    }

    // btnsEliminar.forEach( btn => {
    //     btn.addEventListener('click', e => {
    //         console.log(e);
    //     })
    // })
    
    cargarStorage();

   // cuando agregas un curso presionando agragar a table
   listaProduct.on('click', agregarProducto);
   
   btnRegistrarInventario.on('click', function(){
    	// limpiar storage
        localStorage.removeItem('productos');
        llenarTabla();
        swal('Cache limpia');
   });


//    //vaciar la tabla
//    vaciarTablaBtn.addEventListener('click', ()=>{
//        articulosProducto = []//reseteando el arreglo
//        console.log('hice click');
//    })
   

 
    
 
    // $("#formProducto").submit(async function(e){
    //     e.preventDefault();

    //     var nombre = $("#nombreP").val();
    //     var cantidad = $("#cantProducto").val();
    //     var precio = $("#precioProducto").val();
    //     var tipoProducto = $("#tipoProducto option:selected").val();
    //     var usuario_actual = $("#usuario_actual").val();

    //     //console.log(nombre, cantidad, precio, tipoProducto, usuario_actual);
    //     if(nombre != undefined && cantidad != undefined && precio != undefined && 
    //     tipoProducto != 0 && usuario_actual != undefined){
    //         const formData = new FormData();
    //         formData.append('nombreProducto',nombre);
    //         formData.append('cantidad',cantidad);
    //         formData.append('precio',precio);
    //         formData.append('tipo_producto', tipoProducto);
    //         formData.append('usuario_actual', usuario_actual);

    //         const resp = await axios.post(`./controlador/api.php?action=registrarProducto`, formData);

    //         const data = resp.data;

    //         if(data.error){
    //             return swal("Error", data.msj, "error");
    //         }

    //         return swal("Exito!", data.msj, "success").then((value) => {
    //                 if (value){
    //                     // Se limpia el formulario
    //                     $("#nombreP").val('');
    //                     $("#cantProducto").val('');
    //                     $("#precioProducto").val('');
    //                     $("#tipoProducto").val('0');
    //                 }
    //             })
    //     }else{
    //         swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    //     } 
    // });

    
    
    // $('#nombreP').blur(async function () {
    //     //console.log(this.value);
    //     if(this.value.length > 0 ){
    //         try{
    //             const resp = await axios(`./controlador/api.php?action=obtenerProducto&    nombreProducto=${this.value}`);
    //             const data = resp.data;
    //             if(data.producto.length > 0){
    //                 console.log(data.producto[0]);
    //                 $('#cantProducto')
    //                 $('#precioProducto')
    //                 $('#tipoProducto')
    //                 $('#cantProducto')
    //                 return swal('Este producto ya existe en el inventario');
    //             }else{
    //                 //return swal('NO existe este producto');
    //             }
                
    //         }catch(err){
    //             console.log('Error - ', err);
    //         }
    //     }
    // })
  
    // Elimina un producto del inventario
//     $("#formRoles").submit(async function(e){
//         e.preventDefault();
        
//         var nombre = $("#nombreRol").val();
//         var descripcion = $("#descripcion").val();
//         var usuario_actual = $("#usuario_actual").val();

//         console.log(nombre, descripcion, usuario_actual);
//         if(nombre != undefined && descripcion != undefined && usuario_actual != undefined){
//             const formData = new FormData();
//             formData.append('rol',nombre);
//             formData.append('descripcion',descripcion);
//             formData.append('usuario_actual', usuario_actual);

//             const resp = await axios.post(`./controlador/apiRol.php?action=registrarRol`, formData);

//             const data = resp.data;

//             if(data.error){
//                 return swal("Error", data.msj, "error");
//             }

//             return swal("Exito!", data.msj, "success").then((value) => {
//                     if (value){
//                         // Se limpia el formulario
//                         $("#nombreRol").val('');
//                         $("#descripcion").val('');
                        
//                     }
//                 })
//         }else{
//             swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
//         } 
//   });    




    
    
//     $('#nombreRol').blur(async function () {
//         console.log(this.value);
//         if(this.value.length > 0 ){
//             try{
//                 const resp = await axios(`./controlador/apiRol.php?action=obtenerRol&rol=${this.value}`);
//                 const data = resp.data;
//                 if(data.rol.length > 0){
//                     console.log(data.rol[0]);
//                     $('#nombreRol')
//                     $('#descripcion')
                    
//                     return swal('Este rol ya existe ');
//                 }else{
//                     //return swal('NO existe este producto');
//                 }
                
//             }catch(err){
//                 console.log('Error - ', err);
//             }
//         }
//     });

  
    //console.log($('.btnEliminar'));<
    $('.btnEliminar').on('click', function (){
        console.log("Hola mundo");
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
    
    $('.btnEliminar').on('click', function (){
        console.log("Hola mundo");
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
  
    //FUNCION EDITAR PREGUNTA
    $('.btnEditarPreg ').on('click', function() {
        // info previa
        const idpregunta = $(this).data('idpregunta'); 
        const pregunta = $(this).data('pregunta');
        
        //llena los campos
        $("#idpregunta").val(idpregunta),
        $("#pregunta").val(pregunta),
       
        
       // console.log(idrol,nombrerol,descripcion);
        //mostrar el modal
        $('#modalEditarPregunta').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdPregunta = Number(idpregunta); 
            console.log(IdPregunta);
            const formData = new FormData();
            formData.append('id_pregunta', IdPregunta);
            formData.append('pregunta',$("#pregunta").val());
           
            console.log(formData);
            
           const resp = await axios.post('./controlador/apiPregunta.php?action=actualizarPregunta', formData);
           const data = resp.data;
            console.log(data);
            if(data.error){
                return swal("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarPregunta').modal('hide');
                return swal("Exito!", data.msj, "success", {
                    timer:3000,
                    buttons:false
                }).then(() => {
                    // Se limpia el formulario
                    console.log('Ya se cerro el alert');
                    $("#pregunta").val('');
                    
                    location.reload(); 
                })
            }
                
        });
        
    })
//eliminar roles
$('.btnEliminarPregunta').on('click', function (){
    const idPregunta = $(this).data('idpregunta');
    swal("Eliminar Pregunta", "Esta seguro de eliminar este Pregunta?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
        if (value){
            console.log('Estoy dentro del if');
            const formData = new FormData();
            formData.append('id_pregunta', idPregunta);
            const resp = await axios.post('./controlador/apiPregunta.php?action=eliminarPregunta', formData);
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