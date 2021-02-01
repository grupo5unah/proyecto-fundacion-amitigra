$(document).ready(function(){

  $("#formReporte").submit(async function(e){
          e.preventDefault();
          const fechaInicio = $("#fecha-reporte-inicio").val();
          const fechaFinal = $("#fecha-reporte-final ").val();
    
        const reporte = $("#tipo-reporte option:selected").val();
        console.log(reporte, fechaFinal, fechaInicio);

  });

 

  




});
  //console.log('hola mundo');
  