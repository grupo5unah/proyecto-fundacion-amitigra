$(document).ready(function() {
    //CARGAR LA TABLA EN HOTEL JUTIAPA
 const registro = $('#registro');
 const contenido = $('#tableJutiapa .hotelju');
 //const contenidoe = $('.campinge .campe');
 //const formulario = $('#formCamping');
 const agregarN = $('#btnAgregarN');
 let conteHotelJutiapa = [];

 //para hotel jutiapa
 function agregarhoteljutiapa(e){
   e.preventDefault();

   const infojutiapa = {
     /*creacion del objeto donde llevara
     la informacion de la tabla*/
     

     habitaciones:{
       idhabi: $('#habitacionN').val(),
       nombrehabi: $('#habitacionN option:selected').text(),
     },

     adultoj: $('#cantAN').val(),
     precioaj: $('#precioAdultoN').val(),
     ninoj: $('#cantNN').val(),
     precioninoj: $('#precioNinoN').val(),
     totalj: $('#totalNJ').val(),

   };

   //agregando los datos al arreglo
   conteHotelJutiapa = [...conteHotelJutiapa, infojutiapa];
   $(".hotelju tr").remove();
   llenarTable();
   //funcion reseter formulario 
   //agregarN.prop('disabled', true);
   registro.prop('disabled', false);

   function llenarTable() {
     $(".hotelju tr").remove();
     conteHotelJutiapa.forEach((jutiapa, index ) => agregarfila(jutiapa, index));
   }
 } 


 console.log(conteHotelJutiapa);
 // funcion para registrar
 //MANDAR LOS DATOS AL ARCHIVO PHP
 $('#registro').on('click', function(){
   console.log(conteHotelJutiapa);
       var action = 'registrohotelejutiapa';
       const idusuario = document.querySelector('#id_usuario').value;
       const usuario_actual = document.querySelector('#usuario_actual').value;
       const idcliente = document.querySelector('#idCliente').value;
       const fecha_reservacion = document.querySelector("#reservacion").value;
       const fecha_entrada = document.querySelector("#entrada").value;
       const fecha_salida = document.querySelector("#salida").value;
         /*console.log(descripcion,cantidad_adultosC,cantidad_ninosC,totalC,
         reservacion,entrada,salida,idCliente,idusuario,usuario_actual);*/
    
    if( action === "" || idusuario ==="" || usuario_actual ==="" || idcliente===""|| fecha_reservacion ===""|| 
      fecha_salida ===""|| fecha_entrada ===""){
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
        url: './controlador/ctr.reservaciones.php',
        data: {action:action,idcliente:idcliente,fecha_reservacion:fecha_reservacion,fecha_entrada:fecha_entrada,
          fecha_salida:fecha_salida,
          "conteHotelJutiapa":JSON.stringify(conteHotelJutiapa.map((r) => ({
            habitaciones: r.habitaciones.idhabi,
            adultoj: r.adultoj,
            ninoj: r.ninoj,
            totalj: r.totalj,
          }))),
          idusuario:idusuario,usuario_actual:usuario_actual},
          success: function(response){
            //console.log(response);
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
    }
   
 });

 //mostrar el contenido en la tabla html
 function agregarfila(jutiapa = {}, index = -1){
   const {habitaciones, adultoj, precioaj, ninoj, precioninoj,totalj} = jutiapa;
   contenido.append(`
       <tr >
           <td>${index + 1}</td>
           <td>${habitaciones.nombrehabi}</td>
           <td>${adultoj}</td>
           <td>${precioaj}</td>
           <td>${ninoj}</td>
           <td>${precioninoj}</td>
           <td>${totalj}</td>

           <td>
             <button class="btn btn-danger btnEliminarN glyphicon glyphicon-remove" data-idar="${index}"></button>
           </td>
       </tr>
   `);

   $(".btnEliminarN").on("click", (e) => {
     e.preventDefault();
     let idar = e.target.dataset.idar;
     swal({

       icon: "warning",
       title: "Eliminar fila ",
       text: "¿Esta seguro que desea eliminar esta fila?",
       buttons: ["Cancelar", "Aceptar"],
       dangerMode: true,
     }).then((resp) => {
       if (resp) {
         console.log(resp);
        conteHotelJutiapa.splice(idar, 1);
        llenarTable();
       }
     });
   });
 }

 agregarN.on("click", agregarhoteljutiapa);

  
   
});