const boton = document.querySelector('.actualizar');

boton.addEventListener('click', function(event){
    setTimeout(() => {
        windows.location.reload();
    }, 3000);
});