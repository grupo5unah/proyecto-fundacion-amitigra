//MUESTA LA HORA EN LA PANTALLA PRINCIPAL

    function startTime() {
        var hora_dia = new Date();
        var hora = hora_dia.getHours();
        var minutos = hora_dia.getMinutes();
        var segundos = hora_dia.getSeconds();
        ampm = (hora < 12) ? "<span>AM</span>" : "<span>PM</span>";
        hora = (hora == 0) ? 12 : hora;
        hora = (hora > 12) ? hora - 12 : hora;
        //Add a zero in front of numbers<10
        hora = verificarHora(hora);
        minutos = verificarHora(minutos);
        segundos = verificarHora(segundos);
        document.querySelector("#clock").innerHTML = hora + " : " + minutos + " : " + segundos + " " + ampm;
        var time = setTimeout(function(){ startTime() }, 500);
    }
    function verificarHora(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }