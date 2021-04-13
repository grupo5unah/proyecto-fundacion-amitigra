
function soloLetrasNumeros(e){
    key=e.keycode || e.which;
    teclado = String.fromCharCode(key).toLowerCase();
    letra=" ABCDEFGHIJKMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789¿?_";
    especiales="8-16-37-38-46-63-92-95-164";
    teclado_especial=false;
    for(let i in especiales){
        if (key===especiales[i]){
            teclado_especial= true;
            break;
        }
    }
    if(letra.indexOf(teclado)==-1 && !teclado_especial){
        return false;
    }

}
function soloNumero(e){
    var key = window.event ? e.which : e.keyCode;
    teclado=String.fromCharCode(key);
    numero="1234567890.";
    especiales="8-37-38-46-48";
    teclado_especial = false;
     if (key < 48 || key > 57) {
     e.preventDefault();
    }
    for(let i in especiales){
       if(key===especiales[i]){
           teclado_especial=true;
       }
    }
    if(numero.indexOf(teclado)==-1 && !teclado_especial){
        return false;
    }
  }
  
$(document).ready(function(){
    //const contenedorPro =$('#contClone');
    const formulario=document.querySelector('#formOrden');
    const contenedorOrden= $('#ordenTable  .tbody');
    const local =$('#localidadO').val();
    const nombre = $('#productoOrden').val();
    const cantidad = $('#cantidadPOr').val();
    const descripcion = $('#descCanO').val();
    const listaOrden = $('.btnAgregarFila');
    const registrar = $('#btnRegistrar');
    let contOrden=[]; 
    let idProductoTemporal = null;
    
    var t= $('#gestionOrdenes').DataTable({
     
        columnDefs: [
             {searchable: false},
             {orderable: false},
             { targets: 0},
             {className: "text-center ", targets: [0]},
             {className: "text-center ", targets: [1]},
             {className: "text-center ", targets: [2]},
             {className: "text-center ", targets: [3]},
             {className: "text-center ", targets: [4]},
             {className: "text-center ", targets: [5]},
             {width    : "10px", targets: [0]},
             //{width    : "100px", targets: [1]},
             //{width    : "100px", targets: [2]},
             {width    : "10px", targets: [3]},
            // {width    : "100px", targets: [4]},
            // {width    : "100px", targets: [5]}
      ],
       "order": [[ 1, 'asc' ]],
      
      
     
       "createdRow":function(row,data,index){
          
           
           if(data[4] == "PENDIENTE"){
            
               $('select', row).eq(4).css({
                   'background-color':' #dd4b39',
                   'color':'white',
                   'text-align':'center',
               });
           }
           if(data[4] == "ENVIADO"){
            $('td', row).eq(4).css({
                'background-color':' #00a65a',
                'color':'white',
                'text-align':'center',
            });
           };
       }


    })
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    cargar()
    // crear orden de envio
    function agregarOrden(e){
        e.preventDefault();
        
        const orden = {
            //crea un objeto con el contenido del formulario
            proOrden :{
                id:$('#productoOrden').val(),
                nombre: $("#productoOrden option:selected").text()
            }, 
            cantidadO : $('#cantidadPOr').val(),
            descripcionO : $('#descCanO').val()
   
        } 
         // agrergo el producto al arreglo
         contOrden = [...contOrden, orden];
       
        //agrega  art a la tabla
        $('.tbody tr').remove();
        listaOrden.prop('disabled', true);
        
        llenarTabla();
        resetearFormulario()
        registrar.prop('disabled',false);
    }
    function llenarTabla(){
        //resetearFormulario();
        $('.tbody tr').remove();
        contOrden.forEach((orden, index) => agregarFila(orden, index));
    }
    //agregar producto a la orden
    
    function agregarFila(orden = {}, index=-1){
        const{proOrden, cantidadO , descripcionO} = orden;
        contenedorOrden.append(`
        <tr >
           <td>${index+1}</td>
            <td>${proOrden.nombre}</td>
            <td>${cantidadO}</td>
            <td>${descripcionO}</td>
            <td>
                <button class="btn btn-warning btnEditarOrden Producto glyphicon glyphicon-pencil" data-id="${index}"></button>
                <button class="btn btn-danger btnEliminarO glyphicon glyphicon-remove" data-id="${index}"></button>
            </td>  
        </tr>
        `);
        $('.btnEliminarO').on('click', (e)=>{
           let id = e.target.dataset.id;
           swal('Eliminar producto','Esta seguro que desea eliminar este producto?','warning',{
               buttons: ['Cancelar', 'Aceptar']
           })
            .then((resp) => {
                if(resp){
                    contOrden.splice(id, 1);
                    
                    llenarTabla();
                    resetearFormulario();
                    
                }
            })
           

        });

        $('.btnEditarOrden').on('click', e => {
          	let id = e.target.dataset.id;
            idProductoTemporal = id;
            let productoSeleccionado = contOrden[id];
            if(productoSeleccionado !== undefined){
              $('#productoOrden').val(productoSeleccionado.proOrden.id);
              $('#cantidadPOr').val(productoSeleccionado.cantidadO);
              $('#descCanO').val(productoSeleccionado.descripcionO);
              $('#btnOrdenUpdate').attr('type','button');
              $('.btnAgregarFila').attr('type','hidden');
            } 
            
        });
    }
    
    const editarOrden = e => {
        e.preventDefault();
        
        contOrden[idProductoTemporal] = {
          ...contOrden[idProductoTemporal],
          proOrden :{
                id:$('#productoOrden').val(),
                nombre: $("#productoOrden option:selected").text()
            },
          cantidadO : $('#cantidadPOr').val(),
          descripcionO : $('#descCanO').val(),
              
        };
        
        $('#btnOrdenUpdate').attr('type','hidden');
        $('.btnAgregarFila').attr('type','button');
        llenarTabla();
        resetearFormulario();
        swal('Producto actualizado','El producto se actualizo con exito','success',{
          
          buttons:false,
          timer:2000,
          
        });
      }

     // cuando agregas una presionando agragar a table
           
         listaOrden.on('click', agregarOrden);
        $('#btnOrdenUpdate').on('click', editarOrden);
        //resetearFormulario()
     
     
     function resetearFormulario(){
         
         formulario.reset();
     }
     
     $('.productoOrden').select2();
     $('#localidadO').select2();
     
    $('.btnCrearOrden').on('click',function(){
        $('#ModalCrearOrden').modal('show');
    });
    // validar cada campo
    function cargar(){
  
    $('#localidadO').on('change',validarCampos);
   $('#productoOrden').on('change',validarCampos);
   $('#cantidadPOr').on('blur',validarCampos);
   $('#descripcion').on('blur',validarCampos);
   };
   //validaciones de cada orden
   
    //  function validarCampos(){
    //      if(local.length>0){
    //         listaOrden.prop("disabled", true);
    //          if( nombre.length>0){
    //             listaOrden.prop("disabled", true);
    //              if(cantidad.length>0){
    //                 listaOrden.prop("disabled", true);
    //                  if(descripcion.length>0){
    //                      listaOrden.prop("disabled", false);
    //                 }
    //             }
    //          }  
              
    //     }else{
    //         listaOrden.prop("disabled", true);  
    //     }
    // };
    // registra la orden y el  detalle 
     $('#btnRegistrar').on('click', function(){

         var usuario_actual = $("#usuario_actual").val();
         var usuario_id = $("#id_usuario").val();
         var localidad = $("#localidadO").val();
         
                
         if(usuario_actual !== undefined && localidad !== undefined && contOrden !== undefined ){
        const formData = new FormData();
          formData.append('localidad',localidad);
          formData.append('usuario_actual',usuario_actual);
          formData.append('usuario_id',usuario_id);
        

             //primer Insert orden
             const res = axios.post(`./controlador/contOrden.php?action=registrarOrden`, formData).then(lastid =>{
            //repuesta trae el ordenId
          
             if(lastid){
                 const formData1 = new FormData();
                formData1.append('contOrden', JSON.stringify(contOrden.map(p => ({id: p.proOrden.id, cantidad: p.cantidadO, descripcion: p.descripcionO }))));
                formData1.append('usuario_actual',usuario_actual);
               
                const resp = axios.post('./controlador/contOrden.php?action=registrarDetalleOrden', formData1).then(res=>{
                    const data = res.data;
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
                            //$("#modalCrearProducto").modal("hide");
                         $('.tbody tr').remove();
                         //desabilita el boton registrar
                         registrar.prop('disabled', true);
                         location.reload();
                           
                        });
                });
                

            }
            }).catch(err=>console.log(err));
                       
           
        
        }else{
                  swal("Avertencia!", "Es necesario rellenar todos los campos", "warning");
        }
        $('.tbody tr').remove();
        //desabilita el boton registrar
      
     
    });


    // datos de la dela modal ver el detalle de los datos
    $('.btnVerd').click(async function () {

        let idOrdenes = $(this).data('idordenes');
        const usuario = $(this).data('usuario'); 
        const localidad = $(this).data('localidad');
        const fecha = $(this).data('fecha');
         const info =$('#cont');
         $('#cont div ').remove();
         info.append(
            `
             <div class="user col-3">
             <P class="local col-6"> ${localidad}</P>
             <label for="" id="fecha">FECHA: <span>${fecha}</span></label>
             <p class="userO"> USUARIO: <span>${usuario}</span></p>
             </div>
         
            `
            );
      
        if(idOrdenes){
            try{
                const data = (await axios.get(`./controlador/contOrden.php?action=traerDetalleO&idOrdenes=${Number(idOrdenes)}`)).data;
                const listaDeProductosTabla = $('#listaDeProductosTabla');
                $('#listaDeProductosTabla tr').remove();
                data.productos.forEach((p, index) => listaDeProductosTabla.append(`
                  
                <tr>
                    <td>${index+1}</td>
                    <td>${p.nombre}</td>
                    <td>${p.cantidad}</td>
                    <td>${p.descripcion}</td>
                </tr>
                `));
                $("#userO span").val(usuario);
                $(".local span").val(localidad);
                $("#fecha span").val(fecha);
                $('#modalVerDetalle').modal('show');
            }catch(err){
                console.log('Error - ', err);
            }
        }
    });
    //eliminar la orden y detalle orden
    $('.btnDeleteOrden').on('click', function (){
        const idOrden = $(this).data('orden');
        console.log(idOrden);
        swal("Eliminar la Orden", "Esta seguro de eliminar esta Orden?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
            if (value){
                const formData = new FormData();
                formData.append('id_orden', idOrden);
                const resp = await axios.post('./controlador/contOrden.php?action=eliminarOrden', formData);
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

    //validad que la cantidad requeridad no sea mayor que la que se tiene en inventario
    $("#cantidadPOr").blur(async function () {
        const idP =$('#productoOrden').val();
        const nombre= $("#productoOrden option:selected").text();
        
 
            try{
                const resp = await axios(`./controlador/contOrden.php?action=obtenerCantidad&idProducto=${idP}`);
                const data = resp.data;
                if(data.existencias.length > 0){
                data.existencias.forEach((p, index)=>{
                    const cant =$('#cantidadPOr').val(); 
                   // console.log(cant, idP); 
                   if(Number(cant) >= Number(p.existencias)){
                       console.log(cant,p.existencias);
                   swal("Lo sentimos no tenemos en Inventario esa cantidad de", nombre, "info", {
                        position: 'top-end',
                        timer:2000,
                        button: false
                    })

                   }
                });

                
                    
                    
                }
                     
                
            }catch(err){
                console.log('Error - ', err);
            }
        
    });
    
    
    $('.rowO ').on('change',function (){
       const idOrden=$(this).attr('id')
       var usuario_actual = $("#usuario_actual").val();
     
        const idEstado= Number($(this).val());        
        if (idEstado === 6 ){
            
              swal("Estas Seguros?", "Una vez cambiado el estado a Enviado, se rebajara la orden de inventario!", "warning",{buttons: [true, "OK"]})
              .then(async (value) => {
                if (value){
                    console.log(idOrden);
                    const formData = new FormData();
                    formData.append('id_orden', idOrden);
                    formData.append('id_estado', idEstado);
                    formData.append('usuario_actual', usuario_actual);
                    const resp = await axios.post('./controlador/contOrden.php?action=actualizarEstadoOrden', formData);
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
              $(".rowO option:selected").prop('disabled', true);

           
        }
        
       
    });
    
   

    

});

/*
 recordatorio de validaciones y notificacion de enviado:
   -si la tabla esta vacia el boton Registrar orden debe estar inhabilitado,
   -si re registro la orden se debe deshabilitar el boton registrar de nuevo y vaciar la tabla
   -si se engreso el producto se debe informar al usuario que se registro el producto o informar si no se registro
   -arreglar el boton de editar  y el localstorage
    
*/