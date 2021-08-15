$(document).ready(function() {
  //CARGAR LA TABLA EN HOTEL JUTIAPA
const registro = $('#registre');
const contenido = $('#tableRosario .hotelro');
//const contenidoe = $('.campinge .campe');
//const formulario = $('#formCamping');
const agregarN = $('#btnAgregarNR');
let conteHotelRosario = [];

//para hotel rosario
function agregarhotelrosario(e){
 e.preventDefault();

 const inforosario = {
   /*creacion del objeto donde llevara
   la informacion de la tabla*/
   

   habitacion:{
     idhabi: $('#hnr').val(),
     nombrehabi: $('#hnr option:selected').text(),
   },

   adultoh: $('#anr').val(),
   precioah: $('#pnar').val(),
   ninoh: $('#nnr').val(),
   precioninoh: $('#pnnr').val(),
   totalh: $('#totalNR').val(),

 };

 //agregando los datos al arreglo
 conteHotelRosario = [...conteHotelRosario, inforosario];
 $(".hotelro tr").remove();
 llenarTable();
 //funcion reseter formulario 
 //agregarN.prop('disabled', true);
 registro.prop('disabled', false);

 function llenarTable() {
   $(".hotelro tr").remove();
   conteHotelRosario.forEach((rosario, index ) => agregarfila(rosario, index));
 }
} 


console.log(conteHotelRosario);
// funcion para registrar
//MANDAR LOS DATOS AL ARCHIVO PHP
$('#registre').on('click', function(){
 console.log(conteHotelRosario);
     var action = 'registrohotelerosario';
     const idusuario = document.querySelector('#id_usuario').value;
     const usuario_actual = document.querySelector('#usuario_actual').value;
     const idcliente = document.querySelector('#idCliente').value;
     const fecha_reservacion = document.querySelector("#reservacion").value;
     const fecha_entrada = document.querySelector("#entrada").value;
     const fecha_salida = document.querySelector("#salida").value;
       /*console.log(descripcion,cantidad_adultosC,cantidad_ninosC,totalC,
       reservacion,entrada,salida,idCliente,idusuario,usuario_actual);*/

 $.ajax({
   type: "POST",
   datatype: 'json',
   url: './controlador/ctr.reservarosario.php',
   data: {action:action,idcliente:idcliente,fecha_reservacion:fecha_reservacion,fecha_entrada:fecha_entrada,
     fecha_salida:fecha_salida,
     "conteHotelRosario":JSON.stringify(conteHotelRosario.map((r) => ({
       habitacion: r.habitacion.idhabi,
       adultoh: r.adultoh,
       ninoh: r.ninoh,
       totalh: r.totalh,
     }))),
     idusuario:idusuario,usuario_actual:usuario_actual},
     success: function(response){
       //console.log(response);
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

//mostrar el contenido en la tabla html
function agregarfila(rosario = {}, index = -1){
 const {habitacion, adultoh, precioah, ninoh, precioninoh,totalh} = rosario;
 contenido.append(`
     <tr >
         <td>${index + 1}</td>
         <td>${habitacion.nombrehabi}</td>
         <td>${adultoh}</td>
         <td>${precioah}</td>
         <td>${ninoh}</td>
         <td>${precioninoh}</td>
         <td>${totalh}</td>

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

agregarN.on("click", agregarhotelrosario);

 
});