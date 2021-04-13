
$(document).ready(function (){

    function tiempo(){
        var tabla = $.ajax({
        url: "./controlador/solicitudesTiempoReal.php",
        datatype: "text",
        async: false
        }).responseText;
        
        document.querySelector("#miTabla").innerHTML = tabla;
        }
        setInterval(tiempo, 1000);

})