
function soloLetra(e){
    key=e.keycode || e.which;
    teclado = String.fromCharCode(key).toLowerCase();
    letra=" abcdefghijklmnopqrstuvwxyz¿?_";
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
    numero="0123456789.";
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
        //if(contOrden.length > 0) sincronizarStorage(contOrden)
        //agrega  art a la tabla
        listaOrden.prop('disabled', true);
        
        llenarTabla();
        resetearFormulario()
        registrar.prop('disabled',false);
    }
    function llenarTabla(){
        resetearFormulario();
        $('.tbody tr').remove();
        contOrden.forEach((orden, index) => agregarFila(orden, index));
    }
    //agregar producto a la orden
    
    function agregarFila(orden = {}, index = -1){
        const{proOrden, cantidadO , descripcionO} = orden;
        contenedorOrden.append(`
        <tr >
           <td>${index+1}</td>
            <td>${proOrden.nombre}</td>
            <td>${cantidadO}</td>
            <td>${descripcionO}</td>
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
                    contOrden.splice(id, 1);
                    //sincronizarStorage(contOrden);
                    llenarTabla();
                    
                }
            })
           

        });

        $('.btnEditar').on('click', e => {
          	let id = e.target.dataset.id;
            idProductoTemporal = id;
            let productoSeleccionado = contOrden[id];
            if(productoSeleccionado !== undefined){
              $('#productoOrden').val(productoSeleccionado.proOrden);
              $('#cantidadPOr').val(productoSeleccionado.cantidadO);
              $('#descCanO').val(productoSeleccionado.descripcionO);
              $('#btnProductUpdate').attr('type','button');
              $('.btnAgregarFila').attr('type','hidden');
            } 
            
        });
    }
    
    const editarOrden = e => {
        e.preventDefault();
        
        contOrden[idProductoTemporal] = {
          ...contOrden[idProductoTemporal],
          proOrden : $('#productoOrden').val(),
          cantidadO : $('#cantidadPOr').val(),
          descripcionO : $('#descCanO').val(),
              
        };
        //sincronizarStorage(contOrden);
        $('#btnProductUpdate').attr('type','hidden');
        $('.btnAgregarFila').attr('type','button');
        llenarTabla();
        
        swal('Producto actualizado','El producto se actualizo con exito','success',{
            
          buttons:false,
          timer:2000,
          //resetearFormulario()
        });
      }
      
      
    //   function cargarStorage(){
    //       const productsStorage = localStorage.getItem('orden');
    //       if(!productsStorage){
    //           localStorage.setItem('orden',JSON.stringify([]));
    //       }else{
    //         contOrden = JSON.parse(productsStorage);
    //           llenarTabla();
    //       }
    //   };
   
    //   function sincronizarStorage(data=[]){
    //       if(data.length > 0) localStorage.setItem('orden',JSON.stringify(data));
    //   }
  
    //  cargarStorage();
  
     // cuando agregas una presionando agragar a table
           
         listaOrden.on('click', agregarOrden);
        $('#btnProductUpdate').on('click', editarOrden);
        resetearFormulario()
     
     
     function resetearFormulario(){
         const formulario = document.querySelector('#formOrden');
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
   
     function validarCampos(){
         if(local !== undefined ){
            listaOrden.prop("disabled", true);
             if( nombre !== undefined){
                listaOrden.prop("disabled", true);
                 if(cantidad !== undefined){
                    listaOrden.prop("disabled", true);
                     if(descripcion !== undefined){
                         listaOrden.prop("disabled", false);
                    }
                }
             }  
              
        }else{
            listaOrden.prop("disabled", true);  
        }
    };
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
               
                const resp = axios.post('./controlador/contOrden.php?action=registrarDetalleOrden', formData1);
                const datas = resp.data;

                datas.forEach((p, index)=>{
                    console.log(p.msj);
              
                });                
  
                
            }
            }).catch(err=>console.log(err));
            const data =res.data;
            console.log(data);
        
                
           
        
        }else{
                  swal("Avertencia!", "Es necesario rellenar todos los campos", "warning");
        }
        $('.tbody tr').remove();
        //desabilita el boton registrar
       registrar.prop('disabled', true);
     
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
                    console.log(cant); 
                   if( cant >= p.existencias){
                   swal("Lo sentimos no tenemos en Inventario esa cantidad de", nombre, "info", {
                        position: 'top-end',
                        //timer:3000,
                        showConfirmButton: false
                    })

                   }
                });

                
                    
                    
                }
                     
                
            }catch(err){
                console.log('Error - ', err);
            }
        
    });
    // funcion para hacer la resta en el inventario general
    /*el inventario solo se actualizara cuando la opcion se enviado, por lo que debe confirmar con el usuario si quiere realizar la accion */
    const tabla = $('.contenedorOrden tr td');

    
    $('#row ').on('change',()=>{
       
        const idEstado= $("#row").val();
        const nombre = $("#row option:selected").text();
        tabla.map(index =>{
            console.log(index+1, nombre);
        })
        console.log(tabla)
        // if (idEstado !== 6){
        //     console.log('seguro que quiere enviar el producto');
        //     // swal({
        //     //     title: "Estas Seguros?",
        //     //     text: "Una vez cambiado el estado a Enviado, se rebajara la orden de inventario!",
        //     //     icon: "warning",
        //     //     buttons: true,
        //     //     dangerMode: true,
        //     //   })
        //     //   .then((willDelete) => {
        //     //     if (willDelete) {
        //     //       swal("Exito! Orden rebajada de inventario!", {
        //     //         icon: "success",
        //     //       });
        //     //     }
        //     //   });
           
        // }else {
        //     console.log('no importa');
        //     //$('#row option').prop('disabled',true);
        // };
        
       
    })

    

     


    

});

/*
 recordatorio de validaciones y notificacion de enviado:
   -si la tabla esta vacia el boton Registrar orden debe estar inhabilitado,
   -si re registro la orden se debe deshabilitar el boton registrar de nuevo y vaciar la tabla
   -si se engreso el producto se debe informar al usuario que se registro el producto o informar si no se registro
   -arreglar el boton de editar  y el localstorage
    
*/