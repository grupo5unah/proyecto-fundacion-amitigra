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
            $('#notificacion').html('Nombre de usuario no disponible');
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

  
  //Verifica la existencia del correo
  /*$('#correo').keyup(function(e){
    if($('#correo').val()){
      let correoBuscar = $('#correo').val();
    
      $.ajax({
        url:'../../controlador/buscar.php',
        type:'POST',
        datatype:"json",
        data: { correoBuscar:correoBuscar },
        success: function(response){
          //console.log(response)
          let existente = JSON.parse(response);
          
          existente.forEach(exist_correo => {
            if(!status == true){
            console.log(exist_correo.nombre_completo)
            $('#notificacion2').html('Correo electronico no disponible');
            $('#notificacion2').show();
          }else{
            $('#correo').val();
            $('#notificacion2').hide();
            console.log('No existe')
          }
          });
        }
      });
      
      $('#notificacion2').hide();
    }
  });*/

});
