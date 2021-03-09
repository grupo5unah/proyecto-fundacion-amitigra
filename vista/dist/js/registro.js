
$(document).ready(function() {	
    $('#registro').on('blur', function() {
        $('#correo').html('<img src="images/loader.gif" />').fadeOut(1000);
 
        var correo = $(this).val();		
        var dataString = 'correo='+correo;
 
        $.ajax({
            type: "POST",
            url: "../../controlador/ctr.registro.php",
            data: dataString,
            success: function(data) {
                $('#ver').fadeIn(1000).html(data);
            }
        });
    });              
});    