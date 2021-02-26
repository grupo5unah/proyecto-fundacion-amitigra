const boton = document.querySelector('.actualizar');

boton.addEventListener('click', function(event){
    setTimeout(() => {
        location.reload();
    }, 3000);
});