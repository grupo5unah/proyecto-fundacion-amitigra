//BUSCAR EL CLIENTE
$('#usuario').keyup(function (e) {
    e.preventDefault();
    //console.log('funciona');
    var ident = $(this).val();
    var action = 'buscarCliente';
    $.ajax({
      url: './controlador/consulta.php',
      type:'POST',
      async: false,
      //esta es la direccion donde que tomara el ajax 
      data:{action:action,identidad:ident},
      success: function(response){
       //console.log(response);
       if(response == 0){
         //si la respuesta es 0 va a limpiar el formulario y mostrara el boton de nuevo cliente y boton guardar
         //el 0 quiere decir que ese usuario no existe ese resultado del else del ctrhotel
         $('#usuario').val('');
         //muestra el boton agregar
       }else{
         var data = JSON.parse(response);
         //las variables que van despues del data. son los nombres que estan en las columnas de la tabla de clientes
         $('#usuario').val(data.usuario)
         document.getElementById("notificacion").innerHTML = usuario;
       }
     },
      error: function(error){
        console.log(error);
      }
    });
});