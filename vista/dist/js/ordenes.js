$(document).ready(function(){
    //const contenedorPro =$('#contClone');
    const contenedorOrden= $('#ordenTable  .tbody');
    //const contProducto =$('#productoPricipal');
    const nombre = $('#productoOrden').val();
    const cantidad = $('#cantidadPOr').val();
    const descripcion = $('#descCanO').val();
    const listaOrden = $('.btnAgregarFila');
    let contOrden=[]; 
    let idProductoTemporal = null;
    
   $('#gestionOrdenes').DataTable({
     
        columnDefs: [
             {className: "text-center ", targets: [0]},
             {className: "text-center ", targets: [1]},
             {className: "text-center ", targets: [2]},
             {className: "text-center ", targets: [3]},
             {className: "text-center ", targets: [4]},
             {className: "text-center ", targets: [5]},
             {width    : "10px", targets: [0]},
             {width    : "10px", targets: [3]},
      ],
     
       "createdRow":function(row,data,index){
           
           if(data[4] == "PENDIENTE"){
               $('td', row).eq(4).css({
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
     if(nombre !== undefined && cantidad !== undefined&& descripcion !== undefined){
     listaOrden.on('click', agregarOrden);
     $('#btnProductUpdate').on('click', editarOrden);
     resetearFormulario()
     }
     
     function resetearFormulario(){
         const formulario = document.querySelector('#formOrden');
         formulario.reset();
     }


    $('.btnCrearOrden').on('click',function(){
        $.ajax({
            type:'GET',
            dataType:'json',
            url:'./controlador/apiOrden.php',
            success:function(res){
                $.each(res,function(i,item){
                     $('div .productoOrden').append("<option value='"+ item.id_producto +"'>"+item.nombre_producto+"</option>")
                     $('#productoPrincipal .productoOrden').select2();
                });
                
                 
            }

        });
        $('#ModalCrearOrden').modal('show');
              
    });

   // validaciones de cada orden
     function validarCampos(){
         $.validator.addMethod('descCanO', function(value,element){
             return this.optional(element) || /^[a-z]+$/i.test(value);
         });
         $("#formOrden").validate({
             rules:{
                 localidad:{
                     required:true
                 },
                 productoOrden:{
                     required:true
                 },
                 cantidadPO:{
                     required:true,
                     digits:true,
                     minlength:1,
                     maxlength:3,

                 },
                 descCanO:{
                     required:true,
                     minlength:3,
                     maxlength:8,
                     descCanO:true,

                 }
                
             }
         });
     };
     $('.btnEditarBD').on('click',async function(){
        console.log('hola mundo');
        //e.preventDefault();
         var usuario_actual = $("#usuario_actual").val();
         var localidad = $("#localidadO").val();
         if(usuario_actual !== undefined && localidad !== undefined && contOrden !== ""){
            const formData = new FormData();
                    formData.append('localidad',localidad);
                    formData.append('usuario_actual',usuario_actual);
                    formData.append('contObjetoO',JSON.stringify(contOrden));
                   // console.log(formData);
                const resp = await axios.post(`./controlador/contOrden.php?action=registroOrden`, formData);
                const data = resp;
                console.log(data);
                if(data.error){
                    return swal("Error", data.msj, "error");
                }
                return swal("Exito", data.msj, "success").then(
                (value)=>{
                    if(value){
                        // se limpia el formulario
                        location.reload();
                    }
                });


        }else{
                 swal("Avertencia!", "Es necesario rellenar todos los campos", "warning");
             }


    });
     


    

});