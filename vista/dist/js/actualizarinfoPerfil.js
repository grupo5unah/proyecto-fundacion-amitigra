eventListeners();

function eventListeners(){
    document.querySelector('#infoPerfil').addEventListener('submit', verificarInformacion);
}

function verificarInformacion(e) {
    e.preventDefault();

    let nombre_completo = document.querySelector('#nombre').Value;
    let nombre_usuario = document.querySelector('#usuario').Value;

    if(nombre_completo === '' || nombre_usuario === ''){
        swall({
            icon:'error',
            title: 'Error',
            text: 'Todos los campos son requeridos'
        })
    }else{
        swal({
            icon:'success',
            title:'Correcto',
        })
    }
}