
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
    numero="123456789.";
    especiales="8-37-38-46";
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
    //$('div .productoOrden').select2();
    
        
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
    }
    function llenarTabla(){
        $('.tbody tr').remove();
        contOrden.forEach((orden, index) => agregarFila(orden, index));
    }
    //agregar producto a la orden
    
    function agregarFila(orden = {}, index = -1){
        const{proOrden, cantidadO , descripcionO} = orden;
        contenedorOrden.append(`
        <tr >
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
    $('#localidadO').on('change',validarCampos);
   $('#productoOrden').on('change',validarCampos);
   $('#cantidadPOr').on('blur',validarCampos);
   $('#descripcion').on('blur',validarCampos);
   //validaciones de cada orden
   
     function validarCampos(){
         if(local !== "" && nombre !== " " && cantidad !== " " && descripcion !== " " ){
            listaOrden.prop("disabled", false);    
        }else{
            listaOrden.prop("disabled", true);  
        }
    };
     $('.btnEditarBD').on('click', function(){
        console.log('hola mundo');
        
         var usuario_actual = $("#usuario_actual").val();
         var usuario_id = $("#id_usuario").val();
         var localidad = $("#localidadO").val();
         
                
         if(usuario_actual !== undefined && localidad !== undefined && contOrden !== undefined ){
        const formData = new FormData();
          formData.append('localidad',localidad);
          formData.append('usuario_actual',usuario_actual);
          formData.append('usuario_id',usuario_id);
        

             //primer Insert orden
              axios.post(`./controlador/contOrden.php?action=registrarOrden`, formData).then(lastid =>{
            //repuesta trae el ordenId
            console.log(lastid);
             if(lastid){
                
                console.log(contOrden);
                const formData1 = new FormData();
                formData1.append('contOrden', JSON.stringify(contOrden.map(p => ({id: p.proOrden.id, cantidad: p.cantidadO, descripcion: p.descripcionO }))));
                formData1.append('usuario_actual',usuario_actual);
                //formData1.append('lastId',lastid);
                
                axios.post('./controlador/contOrden.php?action=registrarDetalleOrden', formData1).then(respuesta => console.log('se registraron los productos', respuesta)).catch(err=>console.log(err))
                
            }
            }).catch(err=>console.log(err));
        
                // const data = resp;s
                // console.log(data);
                // if(data.error){
                //     return swal("Error", data.msj, "error");
                // }
                // return swal("Exito", data.msj, "success").then(
                // (value)=>{
                //     if(value){
                //         // se limpia el formulario
                //         location.reload();
                //     }
                // });
           
        
        }else{
                  swal("Avertencia!", "Es necesario rellenar todos los campos", "warning");
        }
    

     
    });

    // $(".btnVerd").dblclick(function(){
    //     $('#modalVerDetalle').modal('show');
       
    // });


    // datos de la dela modal ver el detalle de los datos
    $('.btnVerd').click(async function () {
        $('#modalVerDetalle').modal('show');
      console.log('hola mundo')
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/contOrden.php?action=traerDetalleO&idOrdenes=${this.value}`);
                const data = resp.data;
                if(data.producto.length > 0){
                    console.log(data.producto[0]);
                  
                    
                }
                
            }catch(err){
                console.log('Error - ', err);
            }
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