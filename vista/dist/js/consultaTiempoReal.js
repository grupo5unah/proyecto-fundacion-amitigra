
$(document).ready(function (){

    function tiempo(){
        var tablaTiempo = $.ajax({
        url: "./controlador/solicitudesTiempoReal.php",
        datatype: "text",
        async: false
        }).responseText;
        
        document.querySelector("#miTabla").innerHTML = tablaTiempo;
        }
        setInterval(tiempo, 1000);

})