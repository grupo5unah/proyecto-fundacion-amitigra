//FUNCION PARA CALCULAR EL TOTAL EN NACIONALES CAMPING
function calcularCampingNacional()
{
  try {
    var cant_adultosNC=parseFloat(document.getElementById("anc").value)|| 0, 
        cant_niñosNC=parseFloat(document.getElementById("nnc").value)|| 0,
        precio_adultoNC=parseFloat(document.getElementById("pac").value)|| 0,
        precio_niñosNC=parseFloat(document.getElementById("pnnc").value)|| 0;
        cantiA=parseFloat(document.getElementById("canTi").value)|| 0;
        precioA=parseFloat(document.getElementById("miprecio").value)|| 0;       
        document.getElementById("totalNC").value= (cant_adultosNC*precio_adultoNC)+(cant_niñosNC*precio_niñosNC)+
        (cantiA*precioA);
  }catch(e){

  }
}
//FUNCION PARA CALCULAR EL TOTAL EN EXTRANJEROS CAMPING
function calcularCampingExtranjero()
{
  try {
    var cant_adultosEC=parseFloat(document.getElementById("aec").value)|| 0, 
        cant_niñosEC=parseFloat(document.getElementById("nec").value)|| 0,
        precio_adultoEC=parseFloat(document.getElementById("paec").value)|| 0,
        precio_niñosEC=parseFloat(document.getElementById("pnec").value)|| 0;
        cantiAe=parseFloat(document.getElementById("canTie").value)|| 0;
        precioAe=parseFloat(document.getElementById("miprecioe").value)|| 0;  

        document.getElementById("totalEC").value= (cant_adultosEC*precio_adultoEC)+(cant_niñosEC*precio_niñosEC)+
        (cantiAe*precioAe);
  }catch(e){

  }
}

$(document).ready(function(){
  //Date picker para fecha reservacion Jutiapa
  $('#reserva').datepicker({
    autoclose: true 
  });
  //Date picker para entrada
  $('#entra').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    startDate: '0d',
    todayHighlight: true
  });
  $('#entra').change(function(){
    
    /*esta funciona permite que el input de la fecha salida este desabilitado mientras no se haya eleguido
    la fecha de entrada*/
    
    $('#sale').attr("disabled", false);
    $('#sale').attr("readonly", false);

    //validando que mientras la fecha de entrada no se elija no muestre el calendario
    var fechaEntrada = $(this).val();
    $('#sale').datepicker({
      autoclose: true,
      startDate: fechaEntrada,
      datesDisabled: fechaEntrada,
      format: 'yyyy-mm-dd'
      
    })
  })

  //FUNCION PARA REGISTRAR UN CLIENTE EN HOTEL Y CAMPING
  $(".btnGuardarCliente").click(async function(e){
    e.preventDefault();
    //console.log('funciona');
    var identidad = $("#identi").val();
    var nombre = $("#client").val();
    var nacionalidad = $("#nacion").val();
    var telefono = $("#tele").val();
    var usuario_actual = $("#usuario_actual").val();

    console.log(identidad,nombre, nacionalidad, telefono, usuario_actual);
    if(identidad != undefined && nombre != undefined && nacionalidad != undefined && telefono != undefined && usuario_actual != undefined){
      // formdata sirve para enviar los datos al servidor
        /*lo que va entre fuera de las comillas son las variables que declaramos 
         y lo que va dentro de las comillas es como vamos a declarar en el controlador*/
      const formdata = new FormData();
       formdata.append('identidad',identidad);
       formdata.append('cliente',nombre);
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
            $("#identi").val('');
            $("#client").val('');
            $("#nacion").val('');  
            $("#tele").val(''); 
          }
        })
    }else{
        swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    } 
  });
  //CREAR UN NUEVO CLIENTE 
    //BUSCAR EL CLIENTE
    $('#identi').keyup(function (e) {
       e.preventDefault();
       //console.log('funciona');
       var ident = $(this).val();
       var action = 'buscarCliente';
       $.ajax({
         url: './controlador/ctrhotel.php',
         type:'POST',
         async: true,
         //esta es la direccion donde que tomara el ajax 
         data:{accion:action,identidad:ident},
         success: function(response){
          //console.log(response);
          if(response == 0){
            //si la respuesta es 0 va a limpiar el formulario y mostrara el boton de nuevo cliente y boton guardar
            //el 0 quiere decir que ese usuario no existe ese resultado del else del ctrhotel
            $('#idClient').val('');
            $('#client').val('');
            $('#nacion').val('');
            $('#tele').val('');
            //muestra el boton agregar
            $('.btnCrearClient').slideDown();
          }else{
            var data = JSON.parse(response);
            //las variables que van despues del data. son los nombres que estan en las columnas de la tabla de clientes
            $('#idClient').val(data.id_cliente);
            $('#client').val(data.nombre_completo);
            $('#nacion').val(data.tipo_nacionalidad);
            $('#tele').val(data.telefono);
            //oculta el boton de nuevo cliente
            $('.btnCrearClient').slideUp();
            //Bloquear campos
            $('#client').attr('disabled','disabled');
            $('#nacion').attr('disabled','disabled');
            $('#tele').attr('disabled','disabled');
            //ocultar el boton de guardar
            $('#guardarClient').slideUp();
          }
        },
         error: function(error){
           console.log(error);
         }
       });
        
    });
     //ACTIVAR CAMPOS PARA REGISTRAR CLIENTES
     $('.btnCrearClient').click(function(e){
      e.preventDefault();
      $('#client').removeAttr('disabled');
      $('#nacion').removeAttr('disabled');
      $('#tele').removeAttr('disabled');
      //mostrar el boton de guardar
      $('#guardarClient').slideDown();
      $()
     });
  //BOTON Camping
  $('#Camping').on('click', function(e) {
    console.log('funciona');
    e.preventDefault();
    //mostrar el modal
    $('#modalReservaCamping').modal('show');
  });

  //VALIDAR BOTON DE EXTRANJEROS Y NACIONALES
  $('#extra' ).on( 'click', function(e) {
    e.preventDefault();
      $('.extranjero').slideDown();
      $('.nacional').slideUp();
      $('.nacionales').slideDown();
      $('.extranjeros').slideUp();
  });
  $('#naci' ).on( 'click', function(e) {
    e.preventDefault();
    $('.extranjero').slideUp();
    $('.nacional').slideDown();
    $('.nacionales').slideUp();
    $('.extranjeros').slideDown();
  });
  $('.btnArticulos').on('click', function (e){
    e.preventDefault();
        $('#modalArticulos').modal('show');
  });

  //VALIDAR BOTONES CUANDO LOS CAMPOS ESTEN LLENOS
  $('#identi').keyup( function(e){
    e.preventDefault();
    let identi = document.querySelector("#identi").value;
    if(identi.length == 13){
      $('.selectLocal').removeAttr('disabled');
      $('.siguiente1').removeAttr('disabled');
    }else if(identi.length < 13){
      $('.selectLocal').attr('disabled','disabled');
      $('.siguiente1').atte('disabled');
    }
   });

   //BOTONES SIGUIENTES
   $('#localidad').click(function() {
    var locali = $(this).val();
    //console.log(local);
    if(locali){
      $('#sigue').removeAttr('disabled');
    }else{
      $('#sigue').attr('disabled','disabled');
    }
  });

  $('#cancelarc1').on('click', function(e){
    swal({
      icon: "warning",
      title: "cancelar",
      text: "¿Esta seguro que quiere ejecutar esta accion?",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) =>{
      if(willDelete){
        location.reload();
      }else{
        $('#modalReservaCamping').modal('show');
      }
    })
  });
  $('#cancelarc2').on('click', function(e){
    swal({
      icon: "warning",
      title: "cancelar",
      text: "¿Esta seguro que quiere ejecutar esta accion?",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) =>{
      if(willDelete){
        location.reload();
      }else{
        $('#modalReservaCamping').modal('show');
      }
    })
  });

  //BOTON camping
  $('#Camping').on('click', function(e) {
    e.preventDefault();
    //mostrar el modal
    $('#modalReservaCamping').modal('show');
    $('#tipoReserva').modal('hide');
  });

  //CARGAR PRECIOS DE ARTICULOS nacionales
  $('#miprecio').val(0);

  $('#lista1').on("change",function(){
  
  let precio = document.querySelector("#lista1").value;


  console.log(precio);
  $.ajax({
    type:"POST",
    url:'./controlador/precioA.php',
    datatype:"json",
    data:{ precio:precio},
    success:function(json){
      console.log(json);
      let convertir = JSON.parse(json)

      $('#miprecio').val(convertir.compra);
    }
  });
})
//CARGAR PRECIOS DE ARTICULOS extranjeros
$('#miprecioe').val(0);

$('#lista1e').on("change",function(){

let precio = document.querySelector("#lista1e").value;


console.log(precio);
$.ajax({
  type:"POST",
  url:'./controlador/precioA.php',
  datatype:"json",
  data:{ precio:precio},
  success:function(json){
    console.log(json);
    let convertir = JSON.parse(json)

    $('#miprecioe').val(convertir.compra);
  }
});
})
 //ESTO ES PARA QUE REALICE LA RESERVACION EN CAMPING
  //AGREGANDO NACIONALES A CAMPING
  $('#btnAgregarNC').click(function(e) {
    e.preventDefault();
    $('#registrar').removeAttr('disabled');
  var areaN = $('#area option:selected').text();
  var adulNC = document.getElementById("anc").value;
  var padultoNC = document.getElementById("pac").value;
  var ninNC = document.getElementById("nnc").value;
  var pninoNC = document.getElementById("pnnc").value;
  var tipoT = $('#lista1 option:selected').text();
  var canT = document.getElementById("canTi").value;
  var precioT = document.getElementById("miprecio").value;
  var totNC = document.getElementById("totalNC").value;
  var filaNC = '<tr><td>' + areaN  + '</td><td>' + adulNC + '</td><td>' + padultoNC + '</td><td>'
  + ninNC + '</td><td>' + pninoNC + '</td><td>'+tipoT+ '</td><td>'+canT+'</td><td>'+precioT+'</td><td>'+ totNC +
  '</td><td><button type="button" name="removeN"  class="btn btn-danger btn_eliminarCampingN glyphicon glyphicon-remove"></button></td></tr>'; //esto seria lo que contendria la fila


  $('#tableCamping tr:first').after(filaNC);
    $("#listaC").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
    var nFilasNC = $("#tableCamping tr").length;
    $("#listaC").append(nFilasNC - 1);
    //le resto 1 para no contar la fila del header
    document.getElementById("area").value = "";
    document.getElementById("anc").value = "";
    document.getElementById("nnc").value = "";
    document.getElementById("canTi").value = "";
    document.getElementById("lista1").value = "";
    document.getElementById("totalNC").value = "";
    //document.getElementById("area").focus();
});
$(document).on('click', '.btn_eliminarCampingN', function(e) {
      e.preventDefault();
      $(this).closest('tr').remove();
      $('#registrar').attr('disabled','disabled');
  });
//AGREGANDO A EXTRANJEROS EN CAMPING
$('#btnAgregarEC').click(function(e) {
  e.preventDefault();
  $('#registrar').removeAttr('disabled');
  var areaEC =  $('#areae option:selected').text();
  var adultoEC = document.getElementById("aec").value;
  var preadultoEC = document.getElementById("paec").value;
  var ninoEC = document.getElementById("nec").value;
  var preninoEC = document.getElementById("pnec").value;
  var tipoTe = $('#lista1e option:selected').text();
  var canTe = document.getElementById("canTie").value;
  var precioTe = document.getElementById("miprecioe").value;
  var totalEC = document.getElementById("totalEC").value;
  //var j = 1; //contador para asignar id al boton que borrara la fila
  var filaEC = '<tr><td>' + areaEC + '</td><td>' + adultoEC + '</td><td>' + preadultoEC + '</td><td>'
  + ninoEC + '</td><td>' + preninoEC +'</td><td>' +tipoTe+'</td><td>'+ canTe+'</td><td>'+precioTe+'</td><td>'+ totalEC + 
  '</td><td><button type="button" name="remove" class="btn btn-danger btn_eliminarCampingE glyphicon glyphicon-remove"></button></td></tr>' //esto seria lo que contendria la fila
  //j++;

  $('#tableCamping tr:first').after(filaEC);
    $("#listaC").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
    var nFilasEC = $("#tableCamping tr").length;
    $("#listaC").append(nFilasEC - 1);

    //le resto 1 para no contar la fila del header
    document.getElementById("areae").value ="";
    document.getElementById("aec").value="";
    document.getElementById("nec").value="";
    document.getElementById("canTie").value = "";
    document.getElementById("lista1e").value = "";
    document.getElementById("totalEC").value="";
    // document.getElementById("nombre").focus();

  });


  $(document).on('click', '.btn_eliminarCampingE ', function(e) {
    e.preventDefault();
    $(this).closest('tr').remove();
  });

  //MANDAR LOS DATOS AL ARCHIVO PHP
  $('#registrar').on('click', function(){
      //falta que registre y agregar el elssleping bag
      $('#tableCamping tr').each(function (e) {
      
          // var action = 'registroCamping';
          const descripcion = $(this).find('td').eq(0).html();
          const cantidad_adultosC = $(this).find('td').eq(1).html();
          const cantidad_ninosC = $(this).find('td').eq(3).html();
          const articulo =$(this).find('td').eq(5).html();
          const cantarti = $(this).find('td').eq(6).html();
          const totalC = $(this).find('td').eq(8).html();
          // const camping = document.querySelector("#tipo_camping").value;
          const reservacion = document.querySelector("#reserva").value;
          const entrada = document.querySelector("#entra").value;
          const salida = document.querySelector("#sale").value;
          const idCliente= document.querySelector('#idClient').value;
          const idusuario = document.querySelector('#id_usuario').value;
          const usuario_actual = document.querySelector('#usuario_actual').value;
           console.log(descripcion,cantidad_adultosC,cantidad_ninosC,totalC,
          reservacion,entrada,salida,idCliente,idusuario,usuario_actual);

          $.ajax({
              type: "POST",
              datatype: 'json',
              url: './controlador/ctrcamping.php',
              data: { descripcion:descripcion,cantidad_adultosC:cantidad_adultosC,articulo:articulo,cantarti:cantarti,
                cantidad_ninosC:cantidad_ninosC,totalC:totalC,idCliente:idCliente,reservacion:reservacion,entrada:entrada,
              salida:salida, idusuario:idusuario,usuario_actual:usuario_actual},
              success: function(response){
                console.log(response);
                  var data = JSON.parse(response);
                  
                  if(data.respuesta == 'exito'){
                      swal({
                          icon:"success",
                          title:"Exito",
                          text:"La reservación se realizo correctamente en Camping",
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