//BUSCAR EL CLIENTE
$(document).ready(function () {

  $("#").on("click", async function() {

    let nombre = document.querySelector("#").Value;
    let usuario = document.querySelector("#").Value;
    let correo = document.querySelector("#").Value;
    let genero = document.querySelector("#").Value;
    let telefono = document.querySelector("#").Value;
    let contrasena = document.querySelector("#").Value;
    let confirmarCOntrasena = document.querySelector("#").Value;
    let pregunta_1 = document.querySelector("#").Value;
    let pregunta_2 = document.querySelector("#").Value;
    let pregunta_3 = document.querySelector("#").Value;
    let id_preg1 = document.querySelector("#").Value;
    let id_preg2 = document.querySelector("#").Value;
    let id_preg3 = document.querySelector("#").Value;

    $.ajax({
      url:"./controlador/registro.php",
      type:"POST",
      data:{},
      datatype:"json",
      success: function(response){

        let registro = JSON.parse(response);

        if(registro.respuesta == ""){
          swal({
            icon:"success",
            title:"Exito",
            text:"El usuario se registro exitosamente"
          }).then(() => {
            window.location.href = "login.php";
          });
        } else if(){

        } else if(){

        } else if(){
          
        } else if(){
          
        } else if(){
          
        }
      }
    });

  });

  function Notificacion(icon, title, text){
    swal({
      icon,
      title,
      text
    });
  }

});