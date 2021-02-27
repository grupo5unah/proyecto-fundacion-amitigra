$(document).ready(function(){
 /**SENDERO NACIONAL*/
   /**FUNCION PARA REALIZAR VENTA NACIONAL */
   $("#senderoN").submit(async function(e){
    e.preventDefault();

    var /*localidad = $("#localidad").val(),*/ cant_Badultos = $("#boletosN").val(), cant_Bninos = $("#boletosNN").val(),
        precioAdulto = $("#precioN").val(),precioNino = $("#precioNN").val(), id_usuario = $("#id_usuario").val(),
        totalP = $("#Tpagar").val(), totalBNacional = $("#TboletosN").val(), usuario_actual = $("#usuario_actual").val();

    console.log(cant_Badultos, cant_Bninos, precioAdulto, precioNino, id_usuario, totalP, totalBNacional, usuario_actual);
    if(/*localidad != undefined && */cant_Badultos != undefined && cant_Bninos != undefined && precioAdulto != undefined && 
        precioNino != undefined && totalP != undefined && totalBNacional != undefined && usuario_actual != undefined && id_usuario != undefined){
        // formdata sirve para enviar los datos al servidor
        /*lo que va entre fuera de las comillas son las variables que declaramos 
         y lo que va dentro de las comillas es como vamos a declarar en el controlador*/ 
        const registro= new FormData();        
        /*registro.append('localidad', localidad);*/
        registro.append('boletosN', cant_Badultos);
        registro.append('boletosNN', cant_Bninos);
        registro.append('precioN', precioAdulto);
        registro.append('precioNN', precioNino);
        registro.append('Tpagar', totalP);
        registro.append('TboletosN', totalBNacional);
        registro.append('usuario_actual', usuario_actual);
        registro.append('id_usuario', id_usuario);
                
        const resp = await axios.post(`./controlador/ctr.senderosN.php?action=registrarBoletos`, registro);

        const data = resp.data;

        if(data.error){
            return swal("Error", data.msj, "error");
        }

        return swal("Correcto", data.msj, "success").then((value) => {
          if (value){
            // Se limpia el formulario            
            $("#localidad").val('');
            $("#boletosN").val('');
            $("#boletosNN").val('');
            $("#Tpagar").val('');
            $("#TboletosN").val('');            
          }
        })
    }else{
      swal("Advertencia!", "Es necesario rellenar los campos de cantidades de boletos", "warning");
    } 
  });
  
  /**SENDERO EXTRANJERO*/
   /**FUNCION PARA REALIZAR VENTA EXTRANJERA */
   $("#senderoE").submit(async function(e){
    e.preventDefault();

    var /*localidad = $("#localidad").val(),*/ cant_Badultos = $("#boletosE").val(), cant_Bninos = $("#boletosNE").val(),
        precioAdulto = $("#precioE").val(),precioNino = $("#precioNE").val(), id_usuario = $("#id_usuario").val(),
        totalP = $("#TpagarE").val(), totalBExtranjero = $("#TboletosE").val(), usuario_actual = $("#usuario_actual").val();

    console.log(cant_Badultos, cant_Bninos, precioAdulto, precioNino, id_usuario, totalP, totalBExtranjero, usuario_actual);
    if(/*localidad != undefined && */cant_Badultos != undefined && cant_Bninos != undefined && precioAdulto != undefined && 
        precioNino != undefined && totalP != undefined && totalBExtranjero != undefined && usuario_actual != undefined && id_usuario != undefined){
        // formdata sirve para enviar los datos al servidor
        /*lo que va entre fuera de las comillas son las variables que declaramos 
         y lo que va dentro de las comillas es como vamos a declarar en el controlador*/ 
        const registro= new FormData();        
        /*registro.append('localidad', localidad);*/
        registro.append('boletosE', cant_Badultos);
        registro.append('boletosNE', cant_Bninos);
        registro.append('precioE', precioAdulto);
        registro.append('precioNE', precioNino);
        registro.append('TpagarE', totalP);
        registro.append('TboletosE', totalBExtranjero);
        registro.append('usuario_actual', usuario_actual);
        registro.append('id_usuario', id_usuario);
                
        const resp = await axios.post(`./controlador/ctr.senderosE.php?action=registrarBoletosE`, registro);

        const data = resp.data;

        if(data.error){
            return swal("Error", data.msj, "error");
        }

        return swal("Correcto", data.msj, "success").then((value) => {
          if (value){
            // Se limpia el formulario            
            $("#localidad").val('');
            $("#boletosE").val('');
            $("#boletosNE").val('');
            $("#TpagarE").val('');
            $("#TboletosE").val('');            
          }
        })
    }else{
      swal("Advertencia!", "Es necesario rellenar los campos de cantidades de boletos", "warning");
    } 
  });
  //BOTON PARA ELIMINAR UNA VENTA BOLETO (TABLA)
  $('.btnEliminarBoleto').on('click', function (){
    const idboleto = $(this).data('idboletoVendido');
    swal("Eliminar Boleto(s)", "¿Esta seguro de eliminar esta Facturacion?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
        if (value){
            //console.log(idReservacion);
            const formData = new FormData();
            formData.append('id_boletos_vendidos', idboleto);
            const resp = await axios.post('./controlador/ctr.senderoN.php?action=eliminarboleto', formData);
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