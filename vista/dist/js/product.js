//import * as Funciones from './Utils/Funciones';

$(document).ready(function(){

    $('#nombreP').blur(async function () {
        //console.log(this.value);
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/api.php?action=obtenerProducto&    nombreProducto=${this.value}`);
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
    });

     const contenedorProducto= $('#productTable  .tbody');
     const habitarbtn = document.querySelector("#formProducto");
     const listaProduct = $('#btnAddList');
     let articulosProducto = [];
     let idProductoTemporal = null;
     
       
        $("#tipoProducto").change( function() {
            if ($(this).val() !== '2') {
                $("#precioAlquiler").prop("disabled", true);
            } else {
                $("#precioAlquiler").prop("disabled", false);
            }
        });
   
    
     // funciones de producto
    function agregarProducto(e){
        e.preventDefault();
        const infoProducto = {
            //crea un objeto con el contenido del formulario
            nombreProducto : $('#nombreP').val(),
            precioP : $('#precioProducto').val(),
            cantidadP : $('#cantProducto').val(),
            descripcionP : $('#descripcion').val(),
            tipoProducto : {
                id: $("#tipoProducto").val(),
                nombre: $("#tipoProducto option:selected").text()
            },
            precioAlquiler :  $('#precioAlquiler').val() !== "" ? $('#precioAlquiler').val() : null

        } 
         // agrergo el producto al arreglo
        articulosProducto = [...articulosProducto, infoProducto];
        if(articulosProducto.length > 0) sincronizarStorage(articulosProducto)
        //agrega  art a la tabla
        
        llenarTabla();
        resetearFormulario()
    }

    function llenarTabla(){
        $('.tbody tr').remove();
        articulosProducto.forEach((producto, index) => agregarFila(producto, index));
    }
    // btnRegistrarInventario
   $("#registrarInventario").click(async function(e){
    e.preventDefault();
    console.log('hola mundo'); 
  // const objetoProducto;
         var usuario_actual = $("#usuario_actual").val();
         //console.log(articulosProducto);
         articulosProducto.forEach(function(elementos=[]){
             const arti1= elementos["nombreProducto"];
             const arti2= JSON.parse( elementos["precioP"]);
             const arti3=  JSON.parse(elementos["cantidadP"]);
             const arti4= elementos["descripcionP"];
             const arti5 = JSON.parse( elementos["tipoProducto"]['id']);
             const arti6= JSON.parse( elementos["precioAlquiler"]);
             //console.log(typeof(arti6));

          if(arti1 !== undefined && arti2 !== undefined && arti3 !== undefined && arti4 !== undefined &&  arti5 !== undefined  &&usuario_actual != undefined){
                 
            const formData = new FormData();
              formData.append('articulo1', arti1);
              formData.append('articulo2', arti2);
              formData.append('articulo3', arti3);
              formData.append('articulo4', arti4);
              formData.append('articulo5', arti5);
              formData.append('articulo6', arti6);
              formData.append('usuario_actual', usuario_actual);
                // axios.post('insertar.php', {productos: articulosProducto});
               const resp =  axios.post(`./controlador/api.php?action=registrarProducto`, formData);
                //limpia el storage
             
               const resp1= resp;
               const data = resp1.data;
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
                localStorage.removeItem('productos');
                llenarTabla();
                location.reload();
                  
               });
        }
     });
    
  
 });
    // muestra el carrito de compras en el html
    function agregarFila(producto = {}, index = -1){
        const{nombreProducto, precioP, cantidadP, descripcionP, tipoProducto,precioAlquiler} = producto;
        contenedorProducto.append(`
        <tr >
            <td>${nombreProducto}</td>
            <td>${precioP}</td>
            <td>${cantidadP}</td>
            <td>${descripcionP}</td>
            <td>${tipoProducto.nombre}</td>
            <td>${precioAlquiler !== null ? precioAlquiler : " NO APLICA "}</td>
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

        $('.btnEditar').on('click', e => {
          	let id = e.target.dataset.id;
            idProductoTemporal = id;
            let productoSeleccionado = articulosProducto[id];
            if(productoSeleccionado !== undefined){
              $('#nombreP').val(productoSeleccionado.nombreProducto);
              $('#precioProducto').val(productoSeleccionado.precioP);
              $('#cantProducto').val(productoSeleccionado.cantidadP);
              $('#descripcion').val(productoSeleccionado.descripcionP);
              $("#tipoProducto").val(productoSeleccionado.tipoProducto.id);
              $("#precio").val(productoSeleccionado.precioAlquiler);
              $('#btnProductUpdate').attr('type','button');
              $('#btnAddList').attr('type','hidden');
            } 
            
        });
    }

    const editarProducto = e => {
      e.preventDefault();
      
      articulosProducto[idProductoTemporal] = {
        ...articulosProducto[idProductoTemporal],
        nombreProducto : $('#nombreP').val(),
          precioP : $('#precioProducto').val(),
          cantidadP : $('#cantProducto').val(),
          descripcionP : $('#descripcion').val(),
          tipoProducto : {
              id: $("#tipoProducto").val(),
              nombre: $("#tipoProducto option:selected").text()
          },
          precioAlquiler : $('#precioAlquiler').val(),

      };
      sincronizarStorage(articulosProducto);
      $('#btnProductUpdate').attr('type','hidden');
      $('#btnAddList').attr('type','button');
      llenarTabla();
      resetearFormulario()
      swal('Producto actualizado','El producto se actualizo con exito','success',{
        buttons:false,
        timer:2000
      });
    }
    
    
    function cargarStorage(){
        const productsStorage = localStorage.getItem('productos');
        if(!productsStorage){
            localStorage.setItem('productos',JSON.stringify([]));
        }else{
            articulosProducto = JSON.parse(productsStorage);
            llenarTabla();
        }
    };
 
    function sincronizarStorage(data=[]){
        if(data.length > 0) localStorage.setItem('productos',JSON.stringify(data));
    }

   cargarStorage();

   // cuando agregas un curso presionando agragar a table
   listaProduct.on('click', agregarProducto);
   $('#btnProductUpdate').on('click', editarProducto);
   
   
   function resetearFormulario(){
       const formulario = document.querySelector('#formProducto');
       formulario.reset();
   }


  



     
 });


  



    
