$(document).ready(function(){
   
    $("#formRol").submit(async function(e){
        e.preventDefault();
        
        var nombre = $("#nombre").val();
        var descripcion = $("#descripcion").val();
        var usuario_actual = $("#usuario_actual").val();

        console.log(nombre, descripcion, usuario_actual);
        if(nombre != undefined && descripcion != undefined && usuario_actual != undefined){
            const formData = new FormData();
            formData.append('rol',nombre);
            formData.append('descripcion',descripcion);
            formData.append('usuario_actual', usuario_actual);

            const resp = await axios.post(`./controlador/apiRol.php?action=registrarRol`, formData);

            const data = resp.data;

            if(data.error){
                return swal("Error", data.msj, "error");
            }

            return swal("Exito!", data.msj, "success").then((value) => {
                    if (value){
                        // Se limpia el formulario
                        $("#nombreRol").val('');
                        $("#descripcion").val('');
                        location.reload()
                    }
                })
                ;
        }else{
            swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
        } 
       
    });    
   
  
    $('#nombre').blur(async function () {
        console.log('jhjsfjsh');
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/apiRol.php?action=obtenerRol&rol=${this.value}`);
                const data = resp.data;
                if(data.rol.length > 0){
                    console.log(data.rol[0]);
                    $('#nombre')
                    $('#descripcion')
                    
                    return swal('Este rol ya existe ');
                }else{
                    //return swal('NO existe este producto');
                }
                
            }catch(err){
                console.log('Error - ', err);
            }
        }
    });
    $('.btnCrearRol').on('click',function(){
        $('#modalRegistrarRol').modal('show');
       } );
       //FUNCION EDITAR ROLES
    $('.btnEditarRol').on('click', function() {
        // info previa
        const idrol = $(this).data('idrol'); 
        const nombrerol = $(this).data('nombrerol');
        const descripcion = $(this).data('descripcion'); 
        //llena los campos
        $("#idrol").val(idrol),
        $("#nombreRol").val(nombrerol),
        $("#descripcionRol").val(descripcion)
        
        //console.log(idrol,nombrerol,descripcion);
        //mostrar el modal
        $('#modalEditarRol').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdRol = Number(idrol); 
            console.log(IdRol);
            const formData = new FormData();
            formData.append('id_rol', IdRol);
            formData.append('rol',$("#nombreRol").val());
            formData.append('descripcion',$("#descripcionRol").val());
            console.log(formData);
            
           const resp = await axios.post('./controlador/apiRol.php?action=actualizarRol', formData);
           const data = resp.data;
            console.log(data);
            if(data.error){
                return swal("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarProducto').modal('hide');
                return swal("Exito!", data.msj, "success", {
                    timer:3000,
                    buttons:false
                }).then(() => {
                    // Se limpia el formulario
                    console.log('Ya se cerro el alert');
                    $("#nombreRol").val('');
                    $("#descripcion").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })
    //eliminar roles
    $('.btnEliminarRol').on('click', function (){
        const idRol = $(this).data('idrol');
        swal("Eliminar Rol", "Esta seguro de eliminar este Rol?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
            if (value){
                console.log('Estoy dentro del if');
                const formData = new FormData();
                formData.append('id_rol', idRol);
                const resp = await axios.post('./controlador/apiRol.php?action=eliminarRol', formData);
                const data = resp.data;
                //console.log(data);
                if(data.error){
                    return swal("Error", data.msj, "error",{
                        buttons: false,
                        timer: 3000
                    });
                }
                return swal("Exito!", data.msj, "success",{
                    buttons: false,
                    timer: 3000
                }).then(() =>{ 
                    location.reload();
                });
            }
        });
    })

    
    //MANTENIMIENTO PARÁMETROS
    $("#formParametros").submit(async function(e){
        e.preventDefault();
        var nombre = $("#nombrePara").val();
        var valor = $("#valorParam").val();
        var usuario_actual = $("#usuario_actual").val();
        var idUsuario = $("#id_usuario").val();
       
        if(nombre != undefined && valor != undefined && usuario_actual != undefined && idUsuario != undefined){
            const formData = new FormData();
            formData.append('parametro',nombre);
            formData.append('valor',valor);
            formData.append('usuario_actual', usuario_actual);
            formData.append('id_usuario', Number(idUsuario));

           const resp = await axios.post(`./controlador/apiParam.php?action=registrarParametro`, formData);
            
            const data = resp.data;

            if(data.error){
                return swal("Error", data.msj, "error");
            }

            return swal("Exito!", data.msj, "success").then((value) => {
                    if (value){
                        // Se limpia el formulario
                        $("#nombrePara").val('');
                        $("#valorParam").val('');
                        location.reload()
                    }
                })
        }else{
            swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
        } 
    });

    
    
    $('#nombrePara').blur(async function () {
        //console.log(this.value);
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/apiParam.php?action=obtenerParametro&parametro=${this.value}`);
                const data = resp.data;
                if(data.parametro.length > 0){
                    console.log(data.parametro[0]);
                    $('#nombrePara')
                    $('#valor')
                    
                    return swal('Este parametro ya existe ');
                }else{
                    //return swal('NO existe este producto');
                }
                
            }catch(err){
                console.log('Error - ', err);
            }
        }
    })
  
    //llamar al modal parametros
    $('.btnCrearParam').on('click',function(){
        $('#modalRegistrarParam').modal('show');
       } );
    
    //FUNCION EDITAR PARÁMETROS
    $('.btnEditarParam').on('click', function() {
        // info previa
        const idparametro = $(this).data('idparametro'); 
        const parametro = $(this).data('nombreparametro');
        const valor = $(this).data('valor'); 
        //llena los campos
        $("#idparametro").val(idparametro),
        $("#Param").val(parametro),
        $("#valor").val(valor)

        //mostrar el modal
        $('#modalEditarParam').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var Idparametro = Number(idparametro); 
            console.log(Idparametro);
            const formData = new FormData();
            formData.append('id_parametro', Idparametro);
            formData.append('parametro',$("#parametro").val());
            formData.append('valor',$("#valor").val());
            console.log(formData);
            
           const resp = await axios.post('./controlador/apiParam.php?action=actualizarParametro', formData);
           const data = resp.data;
            console.log(data);
            if(data.error){
                return swal("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarParametro').modal('hide');
                return swal("Exito!", data.msj, "success", {
                    timer:3000,
                    buttons:false
                }).then(() => {
                    // Se limpia el formulario
                    console.log('Ya se cerro el alert');
                    $("#parametro").val('');
                    $("#valor").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })
    //eliminar parametro
    $('.btnEliminarParam').on('click', function (){
        const idParametro = $(this).data('idparametro');
        swal("Eliminar Parametro", "Esta seguro de eliminar este parametro?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
            if (value){
                console.log('Estoy dentro del if');
                const formData = new FormData();
                formData.append('id_parametro', idParametro);
                const resp = await axios.post('./controlador/apiParam.php?action=eliminarParametro', formData);
                const data = resp.data;
                //console.log(data);
                if(data.error){
                    return swal("Error", data.msj, "error",{
                        buttons: false,
                        timer: 3000
                    });
                }
                return swal("Exito!", data.msj, "success",{
                    buttons: false,
                    timer: 3000
                }).then(() =>{ 
                    location.reload();
                });
            }
        });
    })

    //Mantenimiento preguntas
    $("#formPreguntas").submit(async function(e){
        e.preventDefault();

        var pregunta = $("#pregunta").val();
        
        var usuario_actual = $("#usuario_actual").val();

        
        if(pregunta != undefined && usuario_actual != undefined){
            const formData = new FormData();
            formData.append('pregunta',pregunta);
            formData.append('usuario_actual',usuario_actual);
           // formData.append('usuario_actual', usuario_actual);

            const resp = await axios.post(`./controlador/apiPregunta.php?action=registrarPregunta`, formData);

            const data = resp.data;

            if(data.error){
                return swal("Error", data.msj, "error");
            }

            return swal("Exito!", data.msj, "success").then((value) => {
                    if (value){
                        // Se limpia el formulario
                        $("#pregunta").val('');
                        $("#usuario_actual").val('');
                        
                    }
                })
        }else{
            swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
        } 
    });

    
    
    $('#pregunta').blur(async function () {
        //console.log(this.value);
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/apiPregunta.php?action=obtenerPregunta&pregunta=${this.value}`);
                const data = resp.data;
                if(data.pregunta.length > 0){
                    console.log(data.pregunta[0]);
                    $('#pregunta')
                    //$('#valor')
                    
                    return swal('Este pregunta ya existe ');
                }else{
                    //return swal('NO existe este producto');
                }
                
            }catch(err){
                console.log('Error - ', err);
            }
        }
    })
    $('.btnCrearPregunta').on('click', function(){
        $('#modalRegistrarPregunta').modal('show');
       } );
  
    //FUNCION EDITAR PREGUNTA
    $('.btnEditarPreg ').on('click', function() {
        // info previa
        const idpregunta = $(this).data('idpregunta'); 
        const pregunta = $(this).data('nompregunta');
        
        //llena los campos
        $("#idpregunta").val(idpregunta),
        $("#pregunta").val(pregunta),
       
        
       // console.log(idrol,nombrerol,descripcion);
        //mostrar el modal
        $('#modalEditarPregunta').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdPregunta = Number(idpregunta); 
            console.log(IdPregunta);
            const formData = new FormData();
            formData.append('id_pregunta', IdPregunta);
            formData.append('pregunta',$("#pregunta").val());
           
            console.log(formData);
            
           const resp = await axios.post('./controlador/apiPregunta.php?action=actualizarPregunta', formData);
           const data = resp.data;
            console.log(data);
            if(data.error){
                return swal("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarPregunta').modal('hide');
                return swal("Exito!", data.msj, "success", {
                    timer:3000,
                    buttons:false
                }).then(() => {
                    // Se limpia el formulario
                    console.log('Ya se cerro el alert');
                    $("#pregunta").val('');
                    
                    location.reload(); 
                })
            }
                
        });
        
    })
//eliminar roles
$('.btnEliminarPregunta').on('click', function (){
    const idPregunta = $(this).data('idpregunta');
    swal("Eliminar Pregunta", "Esta seguro de eliminar este Pregunta?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
        if (value){
            console.log('Estoy dentro del if');
            const formData = new FormData();
            formData.append('id_pregunta', idPregunta);
            const resp = await axios.post('./controlador/apiPregunta.php?action=eliminarPregunta', formData);
            const data = resp.data;
            //console.log(data);
            if(data.error){
                return swal("Error", data.msj, "error",{
                    buttons: false,
                    timer: 3000
                });
            }
            return swal("Exito!", data.msj, "success",{
                buttons: false,
                timer: 3000
            }).then(() =>{ 
                location.reload();
            });
        }
    });
})
    

}); 

