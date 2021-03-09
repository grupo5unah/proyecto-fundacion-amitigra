eventListeners();

function eventListeners(){
    document.querySelector('#perfilInfo').addEventListener('submit', validarRegistro);
}

function validarRegistro(e){
    e.preventDefault();

    let usuario = document.querySelector('#usuario').value;
    let password = document.querySelector('#passConf').value;
    //let foto = document.querySelector('#imagen').value; 
    let tipo = document.querySelector('#cambio').value;
    let nombre = document.querySelector('#nombre').value;
    let telefono = document.querySelector('#telefono').value;
    let correo = document.querySelector('#correo').value;

    if(usuario === '' || password ===''){
        swal({
            icon: 'error',
            title: 'Lo sentimos',
            text: 'Los campos son requeridos',
            timer: 2000
        });
        console.log('si funciona');
    } else {
        //Los datos son correctos
        let datos = new FormData();

        datos.append('usuario',usuario);
        datos.append('password',password);
        datos.append('accion',tipo);
        datos.append('nombre',nombre);
        datos.append('telefono',telefono);
        datos.append('correo',correo);
        //datos.append('foto',foto);

        //Crear el llamado a AJAX
        let xhr = new XMLHttpRequest();

        //abrir la conexion
        xhr.open('POST','./controlador/ctr.passwordperfil.php');
        //xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        //Retorno de los datos
        xhr.onload = function(){
            if(this.status === 200){
                let respuesta = xhr.responseText;

                console.log(JSON.parse(respuesta));
                //console.log(respuesta);

                if (respuesta.respuesta === 'exito'){

                    if(respuesta.tipo === 'info'){
                        swal({
                            icon:'success',
                            title:'Exito',
                            text:'Se actualizo correctamente'
                        });

                    }else{

                    }

                }
                
            }
        }

        //Enviar la peticion
        //xhr.responseType='text';
        xhr.send(datos);
    }
}