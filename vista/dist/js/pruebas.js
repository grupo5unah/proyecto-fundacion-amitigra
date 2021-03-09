
    window.setTimeout(function(){
    $('.alert').fadeTo(1500,00).slideDown(1000,
    function(){
    $(this).remove();
    });
    }, 3000).then((result) =>{
        window.location.href='../../index.php';
    });