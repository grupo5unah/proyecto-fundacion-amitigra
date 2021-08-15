$(document).ready(function () {

  $('#notificacion').hide();
  //$('#notificacion2').hide();  

  //Verifica la existencia del nombre de usuario
  $('#usuario').keyup(function(e){
    if($('#usuario').val()){
      let usuarioBuscar = document.querySelector('#usuario').value;
      //let correo = $('#correo').val();
  
      $.ajax({
        url:'../../controlador/buscar.php',
        type:'POST',
        datatype:"json",
        data: { usuarioBuscar:usuarioBuscar },
        success: function(response){
          //console.log(response)
          let existe = JSON.parse(response);
          
          existe.forEach(verificar => {
            if(!status == true){
            console.log(verificar.nombre_completo)
            $('#notificacion').html('Nombre de usuario no disponible.');
            $('#notificacion').show();
          }else{
            $('#usuario').val();
            $('#notificacion').hide();
            //console.log('No existe')
          }
          });
        }
      });
      $('#notificacion').hide();
    }
  });

});