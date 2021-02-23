//VALIDDACIONES DE FORMULARIOS HOTEL Y CAMPING
//validacion solo acepte letras
function soloLetras(e) {
  var key = e.keyCode || e.which,
    tecla = String.fromCharCode(key).toLowerCase(),
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
    especiales = [8, 37, 39, 46],
    tecla_especial = false;
  for (var i in especiales) {
    if (key == especiales[i]) {
      tecla_especial = true;
      break;
    }
  }
  if (letras.indexOf(tecla) == -1 && !tecla_especial) {
    return false;
  }
}
//validacion solo permite  un espacio
espacioLetras = function(input) {
  input.value = input.value.replace('  ', ' ');
}
//validacion solo permite numeros
function soloNumeros(e) {
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
    e.preventDefault();
  }
}

//FUNCION PARA CALCULAR EL TOTAL EN HOTEL
function calcular()
{
  try {
    var cant_adultos=parseFloat(document.getElementById("personas").value)|| 0, 
        cant_niños=parseFloat(document.getElementById("niños").value)|| 0,
        precio_adulto=parseFloat(document.getElementById("precioAdulto").value)|| 0,
        precio_niños=parseFloat(document.getElementById("precioNiños").value)|| 0;
        //document.getElementById("TboletosE").value= e+f;
        //console.log(document.getElementById("TboletosE").value);                 
        document.getElementById("pago").value= (cant_adultos*precio_adulto)+(cant_niños*precio_niños);
  }catch(e){

  }
}

//FUNCION PARA CALCULAR EL TOTAL EN CAMPING
function calcular()
{
  try {
    var cant_adultos=parseFloat(document.getElementById("personas").value)|| 0, 
        cant_niños=parseFloat(document.getElementById("ninos").value)|| 0,
        precio_adulto=parseFloat(document.getElementById("precioAdulto").value)|| 0,
        precio_niños=parseFloat(document.getElementById("precioNiños").value)|| 0,
        cant_tienda=parseFloat(document.getElementById("cant_tienda").value)|| 0,
        precio_tienda=parseFloat(document.getElementById("precioTienda").value)|| 0,
        cant_sleeping=parseFloat(document.getElementById("cant_sleeping").value)|| 0,
        precio_sleeping=parseFloat(document.getElementById("precioSleeping").value)|| 0;
        //document.getElementById("TboletosE").value= e+f;
        //console.log(document.getElementById("TboletosE").value);                 
        document.getElementById("pago").value= (cant_adultos*precio_adulto)+(cant_niños*precio_niños)+
        (cant_tienda*precio_tienda)+(cant_sleeping*precio_sleeping);
  }catch(e){

  }
}

$(document).ready(function () {

  //FUNCION PARA REGISTRAR UN CLIENTE EN HOTEL Y CAMPING
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
  //FUNCION PARA MOSTRAR VENTANA MODAL PARA CREAR UN NUEVO CLIENTES
  $('.btnCrearCliente').on('click',function(){
    $('#modalCrearCliente').modal('show');
  });

   //FUNCION PARA BUSCAR EL CLIENTE
   $("#formBuscarCliente").submit(async function(e){
    e.preventDefault();
    var IdCliente = Number(idcliente);
    var identidad_Cliente= $("#identidadC").val();
    console.log(identidad_Cliente, IdCliente);
    if(identidad_Cliente != undefined){
      const buscar = new FormData();

      buscar.append('id_cliente', IdCliente);
      buscar.append('identidad',identidad_Cliente);
      const resp = await axios.post(`./controlador/ctrhotel.php?action=BuscarCliente`, buscar);
      const data = resp.data; 

        if(data.error){
            return swal("Error", data.msj, "error");
        }

        return swal("Exito!", data.msj, "success").then((value) => {
          if (value){
            // Se limpia el formulario
            $("#identidadC").val(''); 
          }
        })
    }else{
        swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    } 
  })
   
  //FUNCION PARA MOSTRAR VENTANA MODAL PARA BUSCAR UN CLIENTE
  $('.btnbuscarCliente').on('click',function(){
    $('#modalBuscarCliente').modal('show');
  });

   /**------------------------------------------------------------------------------------------------------
    *                                                                                                      *
    *                                 RESERVACIONES HOTEL                                                  *
    *                                                                                                      *
    * ------------------------------------------------------------------------------------------------------
    */
   /**FUNCION PARA REALIZAR LA RESERVACION EN HOTEL */
   $("#hotel").submit(async function(e){
    e.preventDefault();
    //console.log('funciona');

    var cliente = $("#cliente").val(), reservacion = $("#reserva").val(),entrada = $("#entrada").val(),
        localidad = $("#localidad").val(),salida = $("#salida").val(),habitacion = $("#habitacion").val(),
        cant_personas = $("#personas").val(), cant_niños = $("#niños").val(),cant_habitacion = $("#cant_habitacion").val(),
        precioA = $("#precioAdulto").val(),precioN = $("#precioNiños").val(),
        total = $("#pago").val(),usuario_actual = $("#usuario_actual").val();

    console.log(cliente, reservacion, entrada,salida, localidad,habitacion,cant_personas,
                  cant_niños, cant_habitacion, precioA, precioN, total, usuario_actual);
    if(cliente != undefined && reservacion != undefined && entrada != undefined &&salida != undefined &&
        localidad != undefined && cant_personas != undefined && cant_niños != undefined && habitacion != undefined && cant_habitacion != undefined
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
        registro.append('niños', cant_niños);
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
            $("#reserva").val('');
            $("#entrada").val('');
            $("#localidad").val('');
            $("#salida").val('');
            $("#habitacion").val('');
            $("#personas").val('');
            $("#niños").val('');
            $("#cant_habitacion").val('');
            $("#precioA").val('');
            $("#precioN").val('');
            $("#pago").val('');
          }
        })
    }else{
      swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    } 
  })

   //BOTON EDITAR MODAL (TABLA)
   $('.btnEditarHotel ').on('click', function() {
    // info previa
    // con el data se imprime en la modal los datos que hay en la tabla
    const idreservacion = $(this).data('idreservacion'); 
    const reservacion = $(this).data('reservacion');
    const entrada = $(this).data('entrada');
    const salida = $(this).data('salida');
    const cantAdultos = $(this).data('adultos');
    const cantiNinos = $(this).data('ninos');
    const pagar = $(this).data('total');

    //$("#idreservacion").val(idreservacion),
    $("#fReservacion").val(reservacion),
    $("#fEntrada").val(entrada),
    $("#fSalida").val(salida),
    $("#cAdultos").val(cantAdultos),
    $("#cNinos").val(cantiNinos),
    $("#total").val(pagar)
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
        formData.append('adultos',$("#cAdultos").val());
        formData.append('ninos',$("#cNinos").val());
        formData.append('pago',$("#total").val());
       
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

  /**------------------------------------------------------------------------------------------------------
    *                                                                                                      *
    *                                    RESERVACIONES CAMPING                                             *
    *                                                                                                      *
    * ------------------------------------------------------------------------------------------------------
    */
  /**FUNCION PARA REALIZAR LA RESERVACION EN CAMPING */
  $("#camping").submit(async function(e){
    e.preventDefault();
    //console.log('funciona');

    var cliente = $("#cliente").val(), reservacion = $("#reserva").val(),entrada = $("#entrada").val(),
        localidad = $("#localidad").val(),salida = $("#salida").val(),area = $("#area").val(),
        cant_personas = $("#personas").val(), cant_niños = $("#niños").val()
        precioA = $("#precioAdulto").val(),precioN = $("#precioNiños").val(),
        total = $("#pago").val(), cant_tienda =$("#cant_tienda").val(),precioT =$("#precioTienda").val(),cant_sleeping =$("#cant_sleeping").val(),
        precioS =$("#precioSleeping").val(),tipoT =$("#tipoT").val(),sleeping =$("#sleeping").val(), usuario_actual = $("#usuario_actual").val();

    console.log(cliente, reservacion, entrada,salida, localidad,area,cant_personas,
                  cant_niños, precioA, precioN, cant_tienda,precioT,cant_sleeping,
                  precioS, total, usuario_actual);
    if(cliente != undefined && reservacion != undefined && entrada != undefined &&salida != undefined &&
        localidad != undefined && cant_personas != undefined && cant_niños != undefined && habitacion != undefined
        && precioA != undefined && precioN != undefined && cant_tienda != undefined && total != undefined && precioT != undefined && 
        cant_sleeping != undefined && precioS != undefined && tipoT != undefined && sleeping != undefined && usuario_actual != undefined){
        // formdata sirve para enviar los datos al servidor
        /*lo que va entre fuera de las comillas son las variables que declaramos 
         y lo que va dentro de las comillas es como vamos a declarar en el controlador*/ 
        const registro= new FormData();
        registro.append('cliente',cliente);
        registro.append('reservacion',reservacion);
        registro.append('entrada',entrada);
        registro.append('localidad', localidad);
        registro.append('salida', salida);
        registro.append('area', area);
        registro.append('personas', cant_personas);
        registro.append('niños', cant_niños);
        registro.append('tipoTienda', tipoT);
        registro.append('sleeping', sleeping);
        registro.append('cant_tienda', cant_tienda);
        registro.append('cant_sleepimg', cant_sleeping);
        registro.append('precioAdulto', precioA);
        registro.append('precioNiños', precioN);
        registro.append('precioTienda', precioT);
        registro.append('precoSleeping', precioS);
        registro.append('pago', total);
        registro.append('usuario_actual', usuario_actual);
        

        const resp = await axios.post(`./controlador/ctrhotel.php?action=registrarCamping`, registro);

        const data = resp.data;

        if(data.error){
            return swal("Error", data.msj, "error");
        }

        return swal("Correcto", data.msj, "success").then((value) => {
          if (value){
            // Se limpia el formulario
            $("#cliente").val('');
            $("#reserva").val('');
            $("#entrada").val('');
            $("#localidad").val('');
            $("#salida").val('');
            $("#area").val('');
            $("#personas").val('');
            $("#niños").val('');
            $("#cant_tienda").val('');
            $("#cant_sleeping").val('');
            $("#precioA").val('');
            $("#precioTienda").val('');
            $("#precioSleeping").val('');
            $("#precioN").val('');
            $("#pago").val('');
          }
        })
    }else{
      swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    } 
  })
});