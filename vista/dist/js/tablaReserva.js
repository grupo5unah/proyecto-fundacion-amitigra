$(document).ready(function() {
    //ESTO ES PARA QUE REALICE LA RESERVACION EN LA LOCALIDAD DE JUTIAPA
    //AGREGANDO A NACIONALES JUTIAPA
  $('#btnAgregarN').click(function(e) {
      e.preventDefault();
    var habitacionN = $('#habitacionN option:selected').text();
    var adultoN = document.getElementById("cantAN").value;
    var preadultoN = document.getElementById("precioAdultoN").value;
    var ninoN = document.getElementById("cantNN").value;
    var preninoN = document.getElementById("precioNinoN").value;
    var totalN = document.getElementById("totalNJ").value;
    var fila = '<tr><td>' + habitacionN + '</td><td>' + adultoN + '</td><td>' + preadultoN + '</td><td>'
    + ninoN + '</td><td>' + preninoN + '</td><td>'+ totalN +'</td><td><button type="button" name="remove"  class="btn btn-danger btn_eliminarNacional glyphicon glyphicon-remove"></button></td></tr>'; //esto seria lo que contendria la fila
  
  
    $('#tableJutiapa tr:first').after(fila);
      $("#lista").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
      var nFilas = $("#tableJutiapa tr").length;
      $("#lista").append(nFilas - 1);
      //le resto 1 para no contar la fila del header
      document.getElementById("habitacionN").value ="";
      document.getElementById("cantAN").value = "";
      document.getElementById("cantNN").value = "";
      document.getElementById("totalNJ").value = "";
      // document.getElementById("nombre").focus();
  });
  $(document).on('click', '.btn_eliminarNacional', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });

    //AGREGANDO A EXTRANJEROS EN JUTIAPA
    $('#btnAgregarE').click(function(e) {
        e.preventDefault();
      var habitacionE = $('#habitacionE option:selected').text();
      var adultoE = document.getElementById("cantAE").value;
      var preadultoE = document.getElementById("precioAdultoE").value;
      var ninoE = document.getElementById("cantNE").value;
      var preninoE = document.getElementById("precioNinoE").value;
      var totalE = document.getElementById("totalEJ").value;
      //var j = 1; //contador para asignar id al boton que borrara la fila
      var filaE = '<tr><td>' + habitacionE + '</td><td>' + adultoE + '</td><td>' + preadultoE + '</td><td>'
      + ninoE + '</td><td>' + preninoE+'</td><td>' + totalE +'</td><td><button type="button" name="remove" class="btn btn-danger btn_eliminarExtranjero glyphicon glyphicon-remove"></button></td></tr>'; //esto seria lo que contendria la fila
    
      //j++;
    
      $('#tableJutiapa tr:first').after(filaE);
        $("#lista").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
        var nFilasE = $("#tableJutiapa tr").length;
        $("#lista").append(nFilasE - 1);
        //le resto 1 para no contar la fila del header
        document.getElementById("habitacionE").value ="";
        document.getElementById("cantAE").value = "";
        document.getElementById("cantNE").value = "";
        document.getElementById("totalEJ").value = "";
        // document.getElementById("nombre").focus();
    });
    $(document).on('click', '.btn_eliminarExtranjero', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });

    //MANDAR LOS DATOS AL ARCHIVO PHP
    $('#registro').on('click', function(){
        $('#tableJutiapa tr').each(function () {
            var action = 'registrarJutiapa';
            const habitacion = $(this).find('td').eq(0).html();
            const cantidad_adultos = $(this).find('td').eq(1).html();
            const cantidad_ninos = $(this).find('td').eq(3).html();
            const total = $(this).find('td').eq(5).html();
            //const hotelj = document.querySelector("#tipo_hotel").value;
            const fecha_reservacion = document.querySelector("#reservacion").value;
            const fecha_entrada = document.querySelector("#entrada").value;
            const fecha_salida = document.querySelector("#salida").value;
            const idCliente= document.querySelector('#idCliente').value;
            const idusuario = document.querySelector('#id_usuario').value;
            const usuario_actual = document.querySelector('#usuario_actual').value;
            console.log(habitacion,cantidad_adultos,cantidad_ninos,total,fecha_reservacion,fecha_entrada
                ,fecha_salida,idCliente,idusuario,usuario_actual);

            $.ajax({
                type: "POST",
                datatype: 'json',
                url: './controlador/ctr.reservaciones.php',
                data: {action:action,habitacion:habitacion,cantidad_adultos:cantidad_adultos,cantidad_ninos:cantidad_ninos,total:total,
                idCliente:idCliente,fecha_reservacion:fecha_reservacion,fecha_entrada:fecha_entrada,
                fecha_salida:fecha_salida, idusuario:idusuario,usuario_actual:usuario_actual},
                success: function(response){
                    var data = JSON.parse(response);
                    if(data.respuesta == 'exito'){
                        swal({
                            icon:"success",
                            title:"Exito",
                            text:"La reservación se realizo correctamente en Jutiapa",
                            timer: 2500,
                            buttons: false
                        }).then(()=>{
                            location.reload();
                        })
                    }else if (data.respuesta == 'error'){
                        swal({
                            icon:"error",
                            title:"Error",
                            text:"se produjo un error"
                        })
                    }
                }
            });
            
        });
    });
     //ESTO ES PARA QUE REALICE LA RESERVACION EN LA LOCALIDAD DE ROSARIO
    //AGREGANDO A NACIONALES ROSARIO
  $('#btnAgregarNR').click(function(e) {
    e.preventDefault();
  var habitaNR = $('#hnr option:selected').text();
  var adulNR = document.getElementById("anr").value;
  var padultoNR = document.getElementById("pnar").value;
  var ninNR = document.getElementById("nnr").value;
  var pninoNR = document.getElementById("pnnr").value;
  var totNR = document.getElementById("totalNR").value;
  var filaNR = '<tr><td>' + habitaNR+ '</td><td>' + adulNR + '</td><td>' + padultoNR + '</td><td>'
  + ninNR + '</td><td>' + pninoNR + '</td><td>'+ totNR +'</td><td><button type="button" name="removeN"  class="btn btn-danger btn_eliminarRosarioN glyphicon glyphicon-remove"></button></td></tr>'; //esto seria lo que contendria la fila


  $('#tableRosario tr:first').after(filaNR);
    $("#listados").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
    var nFilasNR = $("#tableRosario tr").length;
    $("#listados").append(nFilasNR - 1);
    //le resto 1 para no contar la fila del header
    document.getElementById("hnr").value ="";
    document.getElementById("anr").value = "";
    document.getElementById("nnr").value = "";
    document.getElementById("totalNR").value = "";
    // document.getElementById("nombre").focus();
});
$(document).on('click', '.btn_eliminarRosarioN', function(e) {
      e.preventDefault();
      $(this).closest('tr').remove();
  });

  //AGREGANDO A EXTRANJEROS EN ROSARIO
  $('#btnAgregarER').click(function(e) {
    e.preventDefault();
    var habitacionER = $('#her option:selected').text();
    var adultoER = document.getElementById("aer").value;
    var preadultoER = document.getElementById("paer").value;
    var ninoER = document.getElementById("ner").value;
    var preninoER = document.getElementById("pner").value;
    var totalER = document.getElementById("totalER").value;
    //var j = 1; //contador para asignar id al boton que borrara la fila
    var filaER = '<tr><td>' + habitacionER + '</td><td>' + adultoER + '</td><td>' + preadultoER + '</td><td>'
    + ninoER + '</td><td>' + preninoER +'</td><td>' + totalER +'</td><td><button type="button" name="remove" class="btn btn-danger btn_eliminarRosarioE glyphicon glyphicon-remove"></button></td></tr>'; //esto seria lo que contendria la fila

    //j++;

    $('#tableRosario tr:first').after(filaER);
        $("#listados").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
        var nFilasER = $("#tableRosario tr").length;
        $("#listados").append(nFilasER - 1);
        //le resto 1 para no contar la fila del header
        document.getElementById("her").value ="";
        document.getElementById("aer").value = "";
        document.getElementById("ner").value = "";
        document.getElementById("totalER").value = "";
        // document.getElementById("nombre").focus();
});
  $(document).on('click', '.btn_eliminarRosarioE ', function(e) {
      e.preventDefault();
      $(this).closest('tr').remove();
  });

  //MANDAR LOS DATOS AL ARCHIVO PHP
  $('#registro').on('click', function(){
      $('#tableRosario tr').each(function () {
          var accion = 'registrarRosario';
          const habitacionR = $(this).find('td').eq(0).html();
          const cantidad_adultosR = $(this).find('td').eq(1).html();
          const cantidad_ninosR = $(this).find('td').eq(3).html();
          const totalR = $(this).find('td').eq(5).html();
          const hotelr = document.querySelector("#tipo_hotel").value;
          const fecha_reservacion = document.querySelector("#reservacion").value;
          const fecha_entrada = document.querySelector("#entrada").value;
          const fecha_salida = document.querySelector("#salida").value;
          const nombre_cliente = document.querySelector('#cliente').value;
          const telefono = document.querySelector('#telefono').value;
          const nacionalidad = document.querySelector('#nacionalidad').value;
          const identidad = document.querySelector('#identidad').value;
          const idCliente= document.querySelector('#idCliente').value;
          const idusuario = document.querySelector('#id_usuario').value;
          const usuario_actual = document.querySelector('#usuario_actual').value;

          $.ajax({
              type: "POST",
              datatype: 'json',
              url: './controlador/ctr.reservaciones.php',
              data: {accion:accion,habitacionR:habitacionR, hotelr:hotelr, cantidad_adultosR:cantidad_adultosR,cantidad_ninosR:cantidad_ninosR,totalR:totalR,nombre_cliente:nombre_cliente,
              idCliente:idCliente,identidad:identidad,telefono:telefono,nacionalidad:nacionalidad,fecha_reservacion:fecha_reservacion,fecha_entrada:fecha_entrada,
              fecha_salida:fecha_salida, idusuario:idusuario,usuario_actual:usuario_actual} ,
              success: function(response){
                  var data = JSON.parse(response);
                  if(data.respuesta == 'exito'){
                      swal({
                          icon:"success",
                          title:"Exito",
                          text:"La reservación se realizo correctamente en Rosario",
                          timer: 2500,
                          buttons: false
                      }).then(()=>{
                          location.reload();
                      })
                  }else if (data.respuesta == 'error'){
                      swal({
                          icon:"error",
                          title:"Error",
                          text:"se produjo un error"
                      })
                  }
              }
          });
          
      });
  });
    
});