//Verifica la existencia del correo
$(document).ready(function () {

    $("#notificacion2").hide();

    $('#correo').keyup(function(e){
        if($('#correo').val()){
        let correoBuscar = document.querySelector('#correo').value;
        
        $.ajax({
            url:'../../controlador/ctr.buscarCorreo.php',
            type:'POST',
            datatype:"json",
            data: { correoBuscar:correoBuscar },
            success: function(response){
            //console.log(response)
            let existente = JSON.parse(response);
            
            existente.forEach(exist_correo => {
                if(!status == true){
                console.log(exist_correo.id_usuario)
                $('#notificacion2').html('Correo electrónico no disponible.');
                $('#notificacion2').show();
            }else{
                $('#correo').val();
                $('#notificacion2').hide();
            }
            });
            }
        });
        
        $('#notificacion2').hide();
        }


    });
});

    /*window.setTimeout(function(){
    $('.alert').fadeTo(1500,00).slideDown(1000,
    function(){
    $(this).remove();
    });
    }, 3000).then((result) =>{
        window.location.href='../../index.php';
    });*/