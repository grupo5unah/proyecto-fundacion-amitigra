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

  //ALERTA DE CANCELACION
  $('.cancelacioncamping').on('click', function(e){
    swal({
      icon: "warning",
      title: "¿Desea salir?",
      text: "Si acepta se perderá la información",
      buttons: ["Cancelar","Aceptar"],
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
    $('#tipoReserva').modal('hide');
  });


  //VALIDAR BOTON DE EXTRANJEROS Y NACIONALES
  $('#extra' ).on( 'click', function(e) {
    e.preventDefault();
      
  });
  $('#naci' ).on( 'click', function(e) {
    e.preventDefault();
    
  });

  //elige la ncaionalidad para que le aparezcan los precios
  $('#nacionali').change(function() {
    const areacamp = $('#area');
      const cantiadulto = $('#anc');
      const preadulto= $('#pac');
      const cantinino = $('#nnc');
      const prenino= $('#pnnc');

     
    var tiponacionalidad = $(this).val();
    //console.log(local);
    if(tiponacionalidad ==1){
      const lempira = $('.moneda');
      lempira.empty();
      lempira.append(
        '<span>L.</span>',
      );
      $('#area').change(function() {
        let preciocamping = document.querySelector("#area").value;
        
        //console.log(precio);
        $.ajax({
          type:"POST",
          url:'./controlador/preciocamping.php',
          datatype:"json",
          data:{ preciocamping:preciocamping},
          success:function(json){
            console.log(json);
            let convertir = JSON.parse(json)

            $('#pac').val(convertir.alquiler);
            $('#pnnc').val(convertir.alquilernino);
          }
        });
      });
    }else{
      const dolar = $('.moneda');
      dolar.empty();
      dolar.append(
        '<span>$.</span>'
      );

      areacamp.val("");
      cantiadulto.val("");
      preadulto.val("");
      cantinino.val("");
      prenino.val("");
      $('#area').change(function() {
        let preciocampinge = document.querySelector("#area").value;

        //console.log(precio);
        $.ajax({
          type:"POST",
          url:'./controlador/preciocampinge.php',
          datatype:"json",
          data:{ preciocampinge:preciocampinge},
          success:function(json){
            console.log(json);
            let convertire = JSON.parse(json)

            $('#pac').val(convertire.alquilere);
            $('#pnnc').val(convertire.alquilerninoe);
          }
        });
      });
    }
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
  
  //VALIDACIONES

  $('#nacionali').change(function() {
    var nacionali = $(this).val();
    //console.log(local);
    if(nacionali){
      $('#area').removeAttr('disabled');
      $('#area').change(function(){
        var are = $(this).val();
        if(are){
          $('#anc').removeAttr('disabled');
          $('#nnc').removeAttr('disabled');
          $('#canTi').removeAttr('disabled');
          $('#lista1').removeAttr('disabled');
          
        }else{
          $('#anc').attr('disabled','disabled');
          $('#nnc').attr('disabled','disabled');
          $('#canTi').attr('disabled','disabled');
          $('#lista1').attr('disabled','disabled');
        }
        
      });
    }else{
      $('#area').attr('disabled','disabled');
    }
  });

  var cantidad = $('#anc');
  if(cantidad){
    let nacionality = $('#nacionali');
    let areacamping = $('#area');
    let adult = $('#anc');

    if(nacionality === "" && areacamping === "" && adult === ""){
      $('#btnAgregarNC').attr('disabled','disabled');
      
    }else{
      $('#btnAgregarNC').removeAttr('disabled');
    }
  }

  

  


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

  //quitar
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
  });
 

  //CARGAR LA TABLA EN CAMPING
  const registro = $('#registrar');
  const contenido = $('#tableCamping .camp');
  //const contenidoe = $('.campinge .campe');
  //const formulario = $('#formCamping');
  const agregarN = $('#btnAgregarNC');
  let conteCamping = [];

  //para nacionales
  function agregarCampingN(e){
    e.preventDefault();

    const infonacional = {
      /*creacion del objeto donde llevara
      la informacion de la tabla
      */

      arean:{
        idare: $('#area').val(),
        nombrearea: $('#area option:selected').text(),
      },

      adulto: $('#anc').val(),
      precioa: $('#pac').val(),
      nino: $('#pnnc').val(),
      precionino: $('#pnnc').val(),

      articulo:{
        idart: $('#lista1').val(),
        nomarti: $('#lista1 option:selected').text(),
      },
      cantarticulo: $('#canTi').val(),
      precioart: $('#miprecio').val(),
      totalnc: $('#totalNC').val(),

    };

    //agregando los datos al arreglo
    conteCamping = [...conteCamping, infonacional];
    $(".camp tr").remove();
    llenarTable();
    //funcion reseter formulario 
    //agregarN.prop('disabled', true);
    registro.prop('disabled', false);

    function llenarTable() {
      $(".camp tr").remove();
      conteCamping.forEach((nacionalc, index ) => agregarfila(nacionalc, index));
    }
  } 


  console.log(conteCamping);
  // funcion para registrar
  //MANDAR LOS DATOS AL ARCHIVO PHP
  $('#registrar').on('click', function(){
    console.log(conteCamping);
        var action = 'registroCamping';
        const idusuario = document.querySelector('#id_usuario').value;
        const usuario_actual = document.querySelector('#usuario_actual').value;
        const idcliente = document.querySelector('#idClient').value;
        const fecha_reservacion = document.querySelector("#reserva").value;
        const fecha_entrada = document.querySelector("#entra").value;
        const fecha_salida = document.querySelector("#sale").value;
          /*console.log(descripcion,cantidad_adultosC,cantidad_ninosC,totalC,
          reservacion,entrada,salida,idCliente,idusuario,usuario_actual);*/
    if(action === "", usuario_actual === "", idcliente === "", fecha_reservacion === "",
      fecha_entrada === "", fecha_salida === ""){
        swal({
          icon: "warning",
          title: "¡Advertencia!",
          text: "Es necesario llenar todos los campos.",
          timer:3000,
          buttons: false
        });
    
      
    }else{
      $.ajax({
        type: "POST",
        datatype: 'json',
        url: './controlador/ctrcamping.php',
        data: {action:action,idcliente:idcliente,fecha_reservacion:fecha_reservacion,fecha_entrada:fecha_entrada,
          fecha_salida:fecha_salida,
          "conteCamping":JSON.stringify(conteCamping.map((r) => ({
            areaN: r.arean.idare,
            adulto: r.adulto,
            nino: r.nino,
            articulo: r.articulo.idart,
            cantarticulo: r.cantarticulo,
            totalnc: r.totalnc,
          }))),
          idusuario:idusuario,usuario_actual:usuario_actual},
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
    }
  });

  //mostrar el contenido en la tabla html
  function agregarfila(nacionalc = {}, index = -1){
    const {arean, adulto, precioa, nino, precionino, articulo, cantarticulo,precioart,totalnc} = nacionalc;
    contenido.append(`
        <tr >
            <td>${index + 1}</td>
            <td>${arean.nombrearea}</td>
            <td>${adulto}</td>
            <td>${precioa}</td>
            <td>${nino}</td>
            <td>${precionino}</td>
            <td>${articulo.nomarti}</td>
            <td>${cantarticulo}</td>
            <td>${precioart}</td>
            <td>${totalnc}</td>

            <td>
              <button class="btn btn-danger btnEliminarN glyphicon glyphicon-remove" data-idar="${index}"></button>
            </td>
        </tr>
    `);

    $(".btnEliminarN").on("click", (e) => {
      e.preventDefault();
      let ida = e.target.dataset.idar;
      swal({

        icon: "warning",
        title: "Eliminar Reservación",
        text: "¿Esta seguro que desea eliminar esta reservación?",
        buttons: ["Cancelar", "Aceptar"],
      }).then((resp) => {
        if (resp) {
          conteCamping.splice(ida, 1);
          llenarTable();
        }
      });
    });
  }


  
    
    agregarN.on("click", agregarCampingN);
  



});