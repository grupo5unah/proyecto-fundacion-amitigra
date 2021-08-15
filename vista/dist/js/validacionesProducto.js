const nomp = document.querySelector("#nombreP");
const pre = document.querySelector("#precioProducto");
const desc = document.querySelector('#descripcion');
const tp = document.querySelector('#tipoProducto');
//const inicial = document.querySelector('#inicial');
const minimo = document.querySelector('#minimo');
const maximo = document.querySelector('#maximo');
const add = document.querySelector('#btnAddList');
let formularios = document.querySelector('#formProducto');
eventListener();
function eventListener(){

    // validar compos de productos
    nomp.addEventListener('blur',validarProducto);
    pre.addEventListener('blur',validarProducto);
    desc.addEventListener('blur',validarProducto);
    minimo.addEventListener('blur',validarProducto);
    maximo.addEventListener('blur',validarProducto);
    tp.addEventListener('change',validarProducto);

}

function validarProducto(e){
    
    if(e.target.value.length > 0){
        //elimina los errores
        const error = document.querySelector('p.error');
        if(error){
        error.remove()}
        e.target.classList.remove('border','border-danger');
      e.target.classList.add('border','border-success');
    }else{
        e.target.classList.remove('border','border-success');
      e.target.classList.add('border','border-danger');
      mostrarError('Todos los campos son obligatorios');
    }
    if(nomp.value !=='' && pre.value !== '' && desc.value !=='' && tp !=='' && minimo !==''&& maximo !==''){
        add.disabled = false;
    };
};
function mostrarError(mensaje){
    const mensajeError = document.createElement('p');
    mensajeError.textContent = mensaje;
    mensajeError.classList.add('text-danger', 'border','border-danger','fs-3','error');
    const errores = document.querySelectorAll('.error');
    if (errores.length === 0){
        formularios.appendChild(mensajeError);
    }
  
}

function resetear(){
    formularios.reset();
}