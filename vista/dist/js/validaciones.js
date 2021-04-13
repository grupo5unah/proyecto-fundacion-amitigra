const p = document.querySelector('#p');
const de = document.querySelector('#descripcion');
const c = document.querySelector('#cantidad');
const lo = document.querySelector('#movimientoLocalidad');
const registrar = document.querySelector('registrarMovimiento');
//campos de productos

const registrarProducto = document.querySelector('#registrarInventario');
const listaProduct = document.querySelector("#btnMO");
const formulario =document.querySelector("#formM");
eventListener();
function eventListener(){
    //document.addEventListener('DOMContentLoaded', iniciarApp);
    //campos del formulario
    // validar campos de movimientos
    p.addEventListener('change',validarFormulario);
    de.addEventListener('blur',validarFormulario);
    c.addEventListener('blur',validarFormulario);
    lo.addEventListener('change',validarFormulario);

}
// function iniciarApp(){
//     listaProduct.disabled = true;
      
// }
console.log('viendo si carga la pagina en productoas');

function validarFormulario(e){
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
    };   

    if(p.value !=='' && de.value !== '' && c.value !=='' && lo !==''){
        listaProduct.disabled = false;
    };


}


function mostrarError(mensaje){
    const mensajeError = document.createElement('p');
    mensajeError.textContent = mensaje;
    mensajeError.classList.add('text-danger', 'border','border-danger','fs-3','error');
    const errores = document.querySelectorAll('.error');
    if (errores.length === 0){
        formulario.appendChild(mensajeError);
    }
  
}

function resetear(){
    formulario.reset();
}
//const m =$('#exampleRadios1');