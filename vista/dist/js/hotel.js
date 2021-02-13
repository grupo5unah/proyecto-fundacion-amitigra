  //FUNCION PARA REGISTRAR UN CLIENTE
  $("#formCliente").submit(async function(e){
    e.preventDefault();
    
    var identidad = $("#ideCliente").val();
    var nombre = $("#nCliente").val();
    var nacionalidad = $("#nacionalidad").val();
    var telefono = $("#tel").val();
    var usuario_actual = $("#usuario_actual").val();

    console.log(identidad,nombre, nacionalidad, telefono, usuario_actual);
    if(identidad != undefined && nombre != undefined && nacionalidad != undefined && telefono != undefined && usuario_actual != undefined){
      // formdata sirve para enviar los datos al servidor
        /*lo que va entre fuera de las comillas son las variables que declaramos 
         y lo que va dentro de las comillas es como vamos a declarar en el controlador*/ 
      const formdata = new FormData();
       formdata.append('identidad',identidad);
       formdata.append('nombre_cliente',nombre);
       formdata.append('nacionalidad',nacionalidad);
       formdata.append('telefono', telefono);
       formdata.append('usuario_actual', usuario_actual);

        const resp = await axios.post(`./controlador/ctrhotel.php?action=registrarCliente`, formdata);

        const data = resp.data;

        if(data.error){
            return swal("Error", data.msj, "error");
        }

        return swal("Exito!", data.msj, "success").then((value) => {
          if (value){
            // Se limpia el formulario
            $("#ideCliente").val('');
            $("#nCliente").val('');
            $("#nacionalidad").val('');  
            $("#tel").val(''); 
          }
        })
    }else{
        swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    } 
  })
  //funciona para verificar si el cliente ya existe
  /*$('#nCliente').blur(async function () {
    console.log(this.value);
    if(this.value.length > 0 ){
        try{
            const resp = await axios(`./controlador/ctrhotel.php?action=obtenerCliente&cliente=${this.value}`);
            const data = resp.data;
            if(data.cliente.length > 0){
            //    console.log(data.objeto[0]);
                $('#nCliente')
                $('#idCliente')
               
                return swal('El Cliente ya existe ');
            }
        }catch(err){
            console.log('Error - ', err);
        }
    }
  });*/

  //FUNCION PARA MOSTRAR VENTANA MODAL DE CLIENTES
  $('.btnCrearCliente').on('click',function(){
    $('#modalCrearCliente').modal('show');
  });

   /**RESERVACIONES HOTEL */
   /**FUNCION PARA REALIZAR LA RESERVACION */
   $("#hotel").submit(async function(e){
    e.preventDefault();

    var cliente = $("#cliente").val(), reservacion = $("#reservacion").val(),entrada = $("#entrada").val(),
        localidad = $("#localidad").val(),salida = $("#salida").val();habitacion = $("#habitacion").val(),
        cant_personas = $("#personas").val(),cant_habitacion = $("#cant_habitacion").val(),
        precioA = $("#precioAdulto").val(),precioN = $("#precioNiños").val(),
        total = $("#pago").val(),usuario_actual = $("#usuario_actual").val();

    console.log(cliente, reservacion, entrada,salida, localidad,habitacion,cant_personas,
                  cant_habitacion, precioA, precioN, total, usuario_actual);
    if(cliente != undefined && reservacion != undefined && entrada != undefined &&salida != undefined &&
        localidad != undefined && cant_personas != undefined && habitacion != undefined && cant_habitacion != undefined
        && precioA != undefined && precioN != undefined && total != undefined && usuario_actual != undefined){
        // formdata sirve para enviar los datos al servidor
        /*lo que va entre fuera de las comillas son las variables que declaramos 
         y lo que va dentro de las comillas es como vamos a declarar en el controlador*/ 
        const registro= new FormData();
        registro.append('cliente',cliente);
        registro.append('reservacion',reservacion);
        registro.append('entrada',entrada);
        registro.append('localidad', localidad);
        registro.append('salida', salida);
        registro.append('habitacion', habitacion);
        registro.append('personas', cant_personas);
        registro.append('cant_habitacion', cant_habitacion);
        registro.append('precioAdulto', precioA);
        registro.append('precioNiños', precioN);
        registro.append('pago', total);
        registro.append('usuario_actual', usuario_actual);
        

        const resp = await axios.post(`./controlador/ctrhotel.php?action=registrarHotel`, registro);

        const data = resp.data;

        if(data.error){
            return swal("Error", data.msj, "error");
        }

        return swal("Correcto", data.msj, "success").then((value) => {
          if (value){
            // Se limpia el formulario
            $("#cliente").val('');
            $("#reservacion").val('');
            $("#entrada").val('');
            $("#localidad").val('');
            $("#salida").val('');
            $("#habitacion").val('');
            $("#personas").val('');
            $("#cant_habitacion").val('');
            $("#precioA").val('');
            $("#precioN").val('');
            $("#pago").val('');
          }
        })
    }else{
      swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    } 
  });

   //BOTON EDITAR MODAL (TABLA)
   $('.btnEditarHotel ').on('click', function() {
    // info previa
    const idreservacion = $(this).data('idreservacion'); 
    const reservacion = $(this).data('reservacion');
    const entrada = $(this).data('entrada');
    const salida = $(this).data('salida');
    
    //llena los campos
    $("#idreservacion").val(idreservacion),
    $("#fReservacion").val(reservacion),
    $("#fEntrada").val(entrada),
    $("#fSalida").val(salida)

    //mostrar el modal
    $('#modalEditarHotel').modal('show');
    //BOTON PARA QUE ACTUALICE LA BASE DE DATOS
    $('.btnEditarBD').on('click', async function() {
        var IdReservacion = Number(idreservacion); 
        console.log(IdReservacion);
        const formData = new FormData();
        formData.append('id_reservacion', IdReservacion);
        formData.append('reservacion',$("#fReservacion").val());
        formData.append('entrada',$("#fEntrada").val());
        formData.append('salida',$("#fSalida").val());
       
        console.log(formData);
        
       const resp = await axios.post('./controlador/ctrhotel.php?action=actualizarHotel', formData);
       const data = resp.data;
        console.log(data);
        if(data.error){
            return swal("Error", data.msj, "error", {
                timer:3000,
                buttons:false
            });
        } else{
            $('#modalEditarHotel').modal('hide');
            return swal("Exito!", data.msj, "success", {
                timer:3000,
                buttons:false
            }).then(() => {
                // Se limpia el formulario
                console.log('Ya se cerro el alert');
                $("#fReservacion").val('');
                $("#fEntrada").val('');
                $("#fSalida").val('');
                location.reload(); 
            })
        }
            
    });
    
  })
  //BOTON PARA ELIMINAR RESERVACION (TABLA)
  $('.btnEliminarHotel').on('click', function (){
    const idReservacion = $(this).data('idreservacion');
    swal("Eliminar Reservación", "¿Esta seguro de eliminar esta Reservación?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
        if (value){
            //console.log(idReservacion);
            const formData = new FormData();
            formData.append('id_reservacion', idReservacion);
            const resp = await axios.post('./controlador/ctrhotel.php?action=eliminarHotel', formData);
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