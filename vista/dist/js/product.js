$(document).ready(function(){
    //console.log('hola mundo');
    
    $('#manageProductTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }

     } );
<<<<<<< HEAD

    $("#formProducto").submit(async function(e){ 
=======
     //const btnsEliminar = document.querySelectorAll('.btnEliminarP');
     const contenedorProducto= $('#productTable  .tbody');
     const vaciarTablaBtn = document.querySelector('#vaciarTabla');
     const btnRegistrarInventario = $("#registrarInventario");
     const listaProduct = $('#btnAddList');
     let articulosProducto = [];
         
     
     // funciones de producto
    function agregarProducto(e){
>>>>>>> 93c854bf6443ef9b8c9c4cf17a7ee323f54cf677
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
        //limpia el html

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
        $('.btnEliminarP').on('click', ()=>{
            console.log('hiciste click');
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


   //vaciar la tabla
   vaciarTablaBtn.addEventListener('click', ()=>{
       articulosProducto = []//reseteando el arreglo
       console.log('hice click');
   })
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
    //             const resp = await axios(`./controlador/api.php?action=obtenerProducto&nombreProducto=${this.value}`);
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
    //crear roles
    

    
    //MANTENIMIENTO PARÁMETROS
    $("#formParametros").submit(async function(e){
        e.preventDefault();

        var nombre = $("#nombrePara").val();
        var valor = $("#valor").val();
        //var usuario_actual = $("#usuario_actual").val();

        
        if(nombre != undefined && valor != undefined && usuario_actual != undefined){
            const formData = new FormData();
            formData.append('parametro',nombre);
            formData.append('valor',valor);
           // formData.append('usuario_actual', usuario_actual);

            const resp = await axios.post(`./controlador/apiParam.php?action=registrarParametro`, formData);

            const data = resp.data;

            if(data.error){
                return swal("Error", data.msj, "error");
            }

            return swal("Exito!", data.msj, "success").then((value) => {
                    if (value){
                        // Se limpia el formulario
                        $("#nombrePara").val('');
                        $("#valor").val('');
                        
                    }
                })
        }else{
            swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
        } 
    });

    
    
    $('#nombrePara').blur(async function () {
        //console.log(this.value);
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/apiParam.php?action=obtenerParametro&parametro=${this.value}`);
                const data = resp.data;
                if(data.parametro.length > 0){
                    console.log(data.parametro[0]);
                    $('#nombrePara')
                    $('#valor')
                    
                    return swal('Este parametro ya existe ');
                }else{
                    //return swal('NO existe este producto');
                }
                
            }catch(err){
                console.log('Error - ', err);
            }
        }
    })
  
    //llamar al modal parametros
    $('.btnCrearParam').on('click',function(){
        $('#modalRegistrarParam').modal('show');
       } );
    
    //FUNCION EDITAR PARÁMETROS
    $('.btnEditarParam').on('click', function() {
        // info previa
        const idparametro = $(this).data('idparametro'); 
        const parametro = $(this).data('nombreparametro');
        const valor = $(this).data('valor'); 
        //llena los campos
        $("#idparametro").val(idparametro),
        $("#parametro").val(parametro),
        $("#valor").val(valor)
        
        //console.log(idrol,nombrerol,descripcion);
        //mostrar el modal
        $('#modalEditarParam').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var Idparametro = Number(idparametro); 
            console.log(Idparametro);
            const formData = new FormData();
            formData.append('id_parametro', Idparametro);
            formData.append('parametro',$("#parametro").val());
            formData.append('valor',$("#valor").val());
            console.log(formData);
            
           const resp = await axios.post('./controlador/apiParam.php?action=actualizarParametro', formData);
           const data = resp.data;
            console.log(data);
            if(data.error){
                return swal("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarParametro').modal('hide');
                return swal("Exito!", data.msj, "success", {
                    timer:3000,
                    buttons:false
                }).then(() => {
                    // Se limpia el formulario
                    console.log('Ya se cerro el alert');
                    $("#parametro").val('');
                    $("#valor").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })
    //eliminar parametro
    $('.btnEliminarParam').on('click', function (){
        const idParametro = $(this).data('idparametro');
        swal("Eliminar Parametro", "Esta seguro de eliminar este parametro?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
            if (value){
                console.log('Estoy dentro del if');
                const formData = new FormData();
                formData.append('id_parametro', idParametro);
                const resp = await axios.post('./controlador/apiParam.php?action=eliminarParametro', formData);
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

    //Mantenimiento preguntas
    $("#formPreguntas").submit(async function(e){
        e.preventDefault();

        var pregunta = $("#pregunta").val();
        
        var usuario_actual = $("#usuario_actual").val();

        
        if(pregunta != undefined && usuario_actual != undefined){
            const formData = new FormData();
            formData.append('pregunta',pregunta);
            formData.append('usuario_actual',usuario_actual);
           // formData.append('usuario_actual', usuario_actual);

            const resp = await axios.post(`./controlador/apiPregunta.php?action=registrarPregunta`, formData);

            const data = resp.data;

            if(data.error){
                return swal("Error", data.msj, "error");
            }

            return swal("Exito!", data.msj, "success").then((value) => {
                    if (value){
                        // Se limpia el formulario
                        $("#pregunta").val('');
                        $("#usuario_actual").val('');
                        
                    }
                })
        }else{
            swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
        } 
    });

    
    
    $('#pregunta').blur(async function () {
        //console.log(this.value);
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/apiPregunta.php?action=obtenerPregunta&pregunta=${this.value}`);
                const data = resp.data;
                if(data.pregunta.length > 0){
                    console.log(data.pregunta[0]);
                    $('#pregunta')
                    //$('#valor')
                    
                    return swal('Este pregunta ya existe ');
                }else{
                    //return swal('NO existe este producto');
                }
                
            }catch(err){
                console.log('Error - ', err);
            }
        }
    })
    $('.btnCrearPregunta').on('click',function(){
        $('#modalRegistrarPregunta').modal('show');
       } );
  
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
<<<<<<< HEAD
     //mantenimiento Usuario
 $(".btnEditarUsuario").on("click", function () {
    // info previa
    const idusuario = $(this).data("idusuario");
    const nombre = $(this).data("nombre");
    const apellido = $(this).data("apellido");
    const nombre_usuario = $(this).data("nombre_usuario");
    const correo = $(this).data("correo");
    const telefono = $(this).data("telefono");
    const rol = $(this).data("rol");
    const estado_usuario = $(this).data("estado_usuario");
    // const rol = $(this).data('rol');
    //llena los campos
    $("#idusuario").val(idusuario),
      $("#nombre").val(nombre),
      $("#apellido").val(apellido),
      $("#nombre_usuario").val(nombre_usuario),
      $("#correo").val(correo),
      $("#telefono").val(telefono),
      (name = $("[name=rol]").val(rol)),
      $("#estado_usuario").val(estado_usuario),

      //mostrar el modal
      $("#modalEditarUsuario").modal("show");
    $(".btnEditarBD").on("click", async function () {
      var Iduser = Number(idusuario);
      const formData = new FormData();
      formData.append("id_usuario", Iduser);
      formData.append("nombre", $("#nombre").val());
      formData.append("apellido", $("#apellido").val());
      formData.append("nombre_usuario", $("#nombre_usuario").val());
      formData.append("correo", $("#correo").val());
      formData.append("telefono", $("#telefono").val());
      formData.append("rol", $("#rol").val());
      formData.append("estado_usuario", $("#estado_usuario").val());
      //formData.append('rol',$("#rol").val())
      const resp = await axios.post(
        "controlador/api.php?action=actualizarUsuario",
        formData
      );
      const data = resp.data;
      if (data.error) {
        return swal("Error", data.msj, "error", {
          timer: 3000,
          buttons: false,
        });
      } else {
        $("#modalEditarUsuario").modal("hide");
        return swal("Exito!", data.msj, "success", {
          timer: 3000,
          buttons: false,
        }).then(() => {
          // Se limpia el formulario
          console.log("Ya se cerro el alert");
          $("#nombre").val("");
          $("#apellido").val("");
          $("#nombre_usuario").val("");
          $("#correo").val("");
          $("#telefono").val("");
          $("#rol").val("");
          $("#estado_usuario").val("");
          location.reload();
        });
      }
    });
  });
  
  // Elimina un usuario
  
  $(".btnEliminarUsuario").on("click", function () {
    const idusuario = $(this).data("idusuario");
    swal(
      "Eliminar Usuario",
      "Esta seguro de eliminar este usuario?",
      "warning",
      { buttons: [true, "OK"] }
    ).then(async (value) => {
      if (value) {
        console.log("Estoy dentro del if");
        const formData = new FormData();
        formData.append("id_usuario", idusuario);
        const resp = await axios.post(
          "controlador/api.php?action=eliminarUsuario",
          formData
        );
        const data = resp.data;
        //console.log(data);
        if (data.error) {
          return swal("Error", data.msj, "error", {
            buttons: false,
            timer: 2000,
          });
        }
        return swal("Exito!", data.msj, "success", {
          buttons: false,
          timer: 2000,
        }).then(() => {
          location.reload();
        });
      }
    });
  });
 //mantenimiento Solicitudes
 //eliminar una solicitud
  $(".btnEliminarSolicitud").on("click", function () {
    const idsolicitud = $(this).data("idsolicitud");
    swal(
      "Eliminar Solicitud",
      "Esta seguro de eliminar esta solicitud",
      "warning",
      { buttons: [true, "OK"] }
    ).then(async (value) => {
      if (value) {
        console.log("Estoy dentro del if");
        const formData = new FormData();
        formData.append("id_solicitud", idsolicitud);
        const resp = await axios.post(
          "controlador/api.php?action=eliminarSolicitud",
          formData
        );
        const data = resp.data;
        //console.log(data);
        if (data.error) {
          return swal("Error", data.msj, "error", {
            buttons: false,
            timer: 2000,
          });
        }
        return swal("Exito!", data.msj, "success", {
          buttons: false,
          timer: 2000,
        }).then(() => {
          location.reload();
        });
      }
    });
  });
  
 //actualiza una solicitud
  $(".btnEditarSolicitud").on("click", function () {
    // info previa
    const idsolicitud = $(this).data("idsolicitud");
    const idcliente = $(this).data("idcliente");
    const tipo = $(this).data("tipo");
    const estatus_solicitud = $(this).data("estatus_solicitud");
    //llena los campos
    $("#idsolicitud").val(idsolicitud),
      $("#idcliente").val(idcliente),
      $("#tipo_solicitud").val(tipo),
      $("#estatus_solicitud").val(estatus_solicitud),
      //mostrar el modal
      $("#modalEditarSolicitud").modal("show");
    $(".btnEditarBD").on("click", async function () {
      var Idsol = Number(idsolicitud);
      const formData = new FormData();
      formData.append("id_solicitud", Idsol);
      formData.append("estatus_solicitud", $("#estatus_solicitud").val());
      formData.append("tipo", $("#tipo").val());
      //formData.append('rol',$("#rol").val())
      const resp = await axios.post(
        "controlador/api.php?action=actualizarSolicitud",
        formData
      );
      const data = resp.data;
      if (data.error) {
        return swal("Error", data.msj, "error", {
          timer: 3000,
          buttons: false,
        });
      } else {
        $("#modalEditarSolicitud").modal("hide");
        return swal("Exito!", data.msj, "success", {
          timer: 3000,
          buttons: false,
        }).then(() => {
          // Se limpia el formulario
          console.log("Ya se cerro el alert");
          $("#estatus_solicitud").val("");
          $("#tipo").val("");
          location.reload();
        });
      }
    });
  });



    
=======
      
>>>>>>> 93c854bf6443ef9b8c9c4cf17a7ee323f54cf677
});