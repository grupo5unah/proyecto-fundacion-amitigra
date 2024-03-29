$(document).ready(function(){
    
   
    $("#formRol").submit(async function(e){
        e.preventDefault();
        
        var nombre = $("#nombre").val();
        var descripcion = $("#descripcion").val();
        var usuario_actual = $("#usuario_actual").val();
        var idUsuario = $("#id_usuario").val();

        //console.log(nombre, descripcion, usuario_actual);
        if(nombre != undefined && descripcion != undefined && usuario_actual != undefined){
            const formData = new FormData();
            formData.append('rol',nombre);
            formData.append('descripcion',descripcion);
            formData.append('usuario_actual', usuario_actual);
            formData.append('id_usuario', idUsuario);

            const resp = await axios.post(`./controlador/apiRol.php?action=registrarRol`, formData);

            const data = resp.data;

            if(data.error){
                return swal("Error", data.msj, "error");
            }

            return swal("Exito!", data.msj, "success",{
                buttons : 'Aceptar'
            }).then((value) => {
                    if (value){
                        // Se limpia el formulario
                        $("#nombreRol").val('');
                        $("#descripcion").val('');
                        swal({
                            icon:"warning",
                            text: "Desea asignar permisos al nuevo rol",
                            buttons: ["No" , "Sí"]
                        })
                        .then((willDelete) => {
                            if (willDelete) {

                                $("#modalPermisos").modal("show");
                                
                                // contrasena4 = document.querySelector("#contrasenaSeguridad").value = "";
                                // $("#contraRestauracion").val("");
                            } else {
                                location.reload()
                            }
                        });
                        
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
    });

       //FUNCION EDITAR ROLES
    $('.btnEditarRol').on('click', function() {
        // info previa
        const idrol = $(this).data('idrol'); 
        const nombrerol = $(this).data('nombrerol');
        const descripcion = $(this).data('descripcion');
        var usuario_actual = $("#usuario_actual").val();
        var idUsuario = $("#id_usuario").val();
 
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
            formData.append('usuario_actual', usuario_actual);
            formData.append('id_usuario', idUsuario);
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
        var idUsuario = $("#id_usuario").val();
        
        swal("Eliminar Rol", "¿Esta seguro de eliminar este Rol?", "warning",{buttons:["Cancelar","Aceptar"] ,dangerMode:true}).then(async (value) => {
            if (value){
                
                const formData = new FormData();
                formData.append('id_rol', idRol);
                formData.append('id_usuario', idUsuario);
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
    });

   //advertecia de salida para crear y editar

    //MOSTRAR MODAL DE PERMISOS
    $(".btnPermisos").on("click", function(){

        $("#modalPermisos").modal("show");
    })

    
    //MANTENIMIENTO PARÁMETROS
    $("#formParametros").submit(async function(e){
        e.preventDefault();
        var nombre = $("#nombrePara").val();
        var idUsuario = $("#id_usuario").val();
        var valor = $("#valorParam").val();
        var usuario_actual = $("#usuario_actual").val();
        
        
       
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

            return swal("Exito!", data.msj, "success",{
                buttons: false,
                timer: 3000,
            }
            ).then(() => {
                    
                        // Se limpia el formulario
                        $("#nombrePara").val('');
                        $("#valorParam").val('');
                        location.reload()
                    
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
        var usuario_actual = $("#usuario_actual").val();
        var idUsuario = $("#id_usuario").val();
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
            formData.append('parametro',$("#Param").val());
            formData.append('valor',$("#valor").val());
            formData.append('usuario_actual', usuario_actual);
            formData.append('IDusuario_actual', idUsuario);
            
            
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
                    $("#Param").val('');
                    $("#valor").val('');
                    location.reload(); 
                })
            }
                
        });
        
    });
    //eliminar parametro
    $('.btnEliminarParam').on('click', function (){
        const idParametro = $(this).data('idparametro');
        var idUsuario = $("#id_usuario").val();

        swal("Eliminar Parametro", "Esta seguro de eliminar este parametro?", "warning",{buttons:["Cancelar","Aceptar"] ,dangerMode:true}).then(async (value) => {
            if (value){
               
                const formData = new FormData();
                formData.append('id_parametro', idParametro);
                formData.append('ID_usuario', idUsuario);

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


    //advertencia de salida
    $("#cerrarModalcrearPara").on("click", function(){

        swal({
            icon:"warning",
            title: "¿Desea salir?",
            text:" Si acepta se perderá la información.",
            
            buttons:[ "Cancelar","Aceptar",], 
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                              
                $("#modalRegistrarParam").modal("hide");
                $("#nombrePara").val('');
                $("#valorParam").val('');
                
            } else {
    
                $("#modalRegistrarParam").modal("show");
            // $("#modalRegistrarRol").modal("show");
    
            }
        });
    
    });

    $("#cerrareditarParametro").on("click", function(){

        swal({
            icon:"warning",
            title: "¿Desea salir?",
            text:" Si acepta se perderá la información.",
            
            buttons:[ "Cancelar","Aceptar",], 
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                              
                $("#modalEditarParametro").modal("hide");
                
            } else {
    
                $("#modalEditarParametro").modal("show");
            // $("#modalRegistrarRol").modal("show");
    
            }
        });
    
    });

    //Mantenimiento preguntas
    $("#formPreguntas").submit(async function(e){
        e.preventDefault();

        var pregunta = $("#pregunta").val();
        var idUsuario = $("#id_usuario").val();
        
        var usuario_actual = $("#usuario_actual").val();
       
        if(pregunta != undefined && usuario_actual != undefined){
            const formData = new FormData();
            formData.append('pregunta',pregunta);
            formData.append('usuario_actual',usuario_actual);
            formData.append('id_usuario', idUsuario);

          
            const resp = await axios.post(`./controlador/apiPregunta.php?action=registrarPregunta`, formData);

            const data = resp.data;

            if(data.error){
                return swal("Error", data.msj, "error");
            }

            return swal("Exito!", data.msj, "success",{
                buttons: false,
                timer: 3000,
            }).then(() => {
                    
                        // Se limpia el formulario
                        $("#pregunta").val('');
                        $("#usuario_actual").val('');
                        location.reload();
                        
                    
                })
        }else{
            swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
        } 
    });
    //cerrar el modal crear pregunta
    $("#cerrarModarCrearPre").on("click", function(){

        swal({
            icon:"warning",
            title: "¿Desea salir?",
            text:" Si acepta se perderá la información.",
            
            buttons:[ "Cancelar","Aceptar",], 
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                              
                $("#modalRegistrarPregunta").modal("hide");
                
            } else {
    
                $("#modalRegistrarPregunta").modal("show");
            
            }
        });

    });
    
    
    $('#pregunta').blur(async function () {
        
        if(this.value.length > 0 ){
            try{
                const resp = await axios(`./controlador/apiPregunta.php?action=obtenerPregunta&pregunta=${this.value}`);
                const data = resp.data;
                if(data.pregunta.length > 0){
                    console.log(data.pregunta[0]);
                    $('#pregunta')
                    //$('#valor')
                    
                    return swal('Este pregunta ya existe ');
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
        var usuario_actual = $("#usuario_actual").val();
        var idUsuario = $("#id_usuario").val();
        //llena los campos
        $("#idpregunta").val(idpregunta),
        $("#pregunta1").val(pregunta),
     
        $('#modalEditarPregunta').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdPregunta = Number(idpregunta); 
            console.log(IdPregunta);
            const formData = new FormData();
            formData.append('id_pregunta', IdPregunta);
            formData.append('pregunta',$("#pregunta1").val());
            formData.append('usuario_actual', usuario_actual);
            formData.append('id_usuario', idUsuario);

 
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
                    
                    $("#pregunta").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })



    //cerrar editar pregunta
    $("#cerrarEditarp").on("click", function(){

        swal({
            icon:"warning",
            title: "¿Desea salir?",
            text:" Si acepta se perderá la información.",
            
            buttons:[ "Cancelar","Aceptar",], 
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                              
                $("#modalEditarPregunta").modal("hide");
                location.reload();
                                
            } else {
    
                $("#modalEditarPregunta").modal("show");
            
            }
        });

    });
   //eliminar pregunta
   $('.btnEliminarPregunta').on('click', function (){
    const idPregunta = $(this).data('idpregunta');
    var idUsuario = $("#id_usuario").val();
    swal("Eliminar Pregunta", "Esta seguro de eliminar este Pregunta?", "warning",{buttons:["Cancelar","Aceptar"] ,dangerMode:true}).then(async (value) => {
        if (value){
            console.log('Estoy dentro del if');
            const formData = new FormData();
            formData.append('id_pregunta', idPregunta);
            formData.append('id_usuario', idUsuario);

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

  // mantenimiento de tipo producto
  $("#formTP").submit(async function(e){
    e.preventDefault();

    var tipoProducto = $("#tipoP").val();
    var idUsuario = $("#id_usuario").val();
    var usuario_actual = $("#usuario_actual").val();
   
    if(tipoProducto != undefined && usuario_actual != undefined){
        const formData = new FormData();
        formData.append('tipo_Producto',tipoProducto);
        formData.append('usuario_actual',usuario_actual);
        formData.append('id_usuario', idUsuario);

      
        const resp = await axios.post(`./controlador/apiRol.php?action=registrarTProduct`, formData);

        const data = resp.data;

        if(data.error){
            return swal("Error", data.msj, "error");
        }

        return swal("Exito!", data.msj, "success",{
            buttons: false,
            timer: 3000,
        }).then(() => {
              
                    // Se limpia el formulario
                    $("#tipoP").val('');
                    $("#usuario_actual").val('');
                    location.reload();
                    
                
            })
    }else{
        swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    } 
  });



  $('#tipoP').blur(async function () {
    
    if(this.value.length > 0 ){
        try{
            const resp = await axios(`./controlador/apiRol.php?action=obtenerTipoP&tipoP=${this.value}`);
            const data = resp.data;
            if(data.tipoP.length > 0){
                $('#tipoP')
                return swal('Este tipo de producto ya existe ');
            }
            
        }catch(err){
            console.log('Error - ', err);
        }
    }
  })
   $('.btnCrearTipo').on('click', function(){
    $('#modalRegistrarTP').modal('show');
   } );

   //cerrar modal tipo Producto

   $("#cerrarModalTP").on("click", function(){

    swal({
        icon:"warning",
        title: "¿Desea salir?",
        text:" Si acepta se perderá la información.",
        
        buttons:[ "Cancelar","Aceptar",], 
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
                          
            $("#modalRegistrarTP").modal("hide");
            
        } else {

            $("#modalRegistrarTP").modal("show");
        
        }
    });

});

//FUNCION EDITAR TIPO PRODUCTO
  $('.btnEditarTP ').on('click', function() {
    // info previa
    const id = $(this).data("idtipop"); 
    const nombreTP = $(this).data("tipoproductop");
    var usuario_actual = $("#usuario_actual").val();
    var idUsuario = $("#id_usuario").val();
    //llena los campos
    //("#idtipoProducto").val(id_tipo_producto);
    $("#tipo_producto").val(nombreTP);

    $('#modalEditarTP').modal('show');
    
    $('.btnEditarBD').on('click', async function() {
        var idTP = Number(id); 
        
        const formData = new FormData();
        formData.append('id_tipoProducto', idTP);
        formData.append('tProducto',$("#tipo_producto").val()); 
        formData.append('usuario_actual', usuario_actual); 
        formData.append('id_usuario', idUsuario);


       const resp = await axios.post('./controlador/apiRol.php?action=actualizarTP', formData);
       const data = resp.data;
        
        if(data.error){
            return swal("Error", data.msj, "error", {
                timer:3000,
                buttons:false
            });
        } else{
            $('#modalEditarTP').modal('hide');
            return swal("Exito!", data.msj, "success", {
                timer:3000,
                buttons:false
            }).then(() => {
                // Se limpia el formulario
                console.log('Ya se cerro el alert');
                $("#tipo_producto").val('');
                
                location.reload(); 
            })
        }
            
    });
    
  })

  //cerrar editar tipo producto
  $("#cerrarATP").on("click", function(){

    swal({
        icon:"warning",
        title: "¿Desea salir?",
        text:" Si acepta se perderá la información.",
        
        buttons:[ "Cancelar","Aceptar",], 
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
                          
            $("#modalEditarTP").modal("hide");
            
        } else {

            $("#modalEditarTP").modal("show");
        
        }
    });

  });



//eliminar tipo producto
  $('.btnEliminarTP').on('click', function (){
    const idtp = $(this).data('idtipo');
    var idUsuario = $("#id_usuario").val();

       swal("Eliminar Tipo de Producto", "Esta seguro de eliminar este tipo de producto?", "warning",{buttons:["Cancelar","Aceptar"] ,dangerMode:true}).then(async (value) => {
    if (value){
        
        const formData = new FormData();
        formData.append('id_tipo_producto', idtp);
        formData.append('id_usuario', idUsuario);

        const resp = await axios.post('./controlador/apiRol.php?action=eliminarTipoP', formData);
        const data = resp.data;
       
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
  
  // mantenimiento de localidades
  $("#formLocalidad").submit(async function(e){
    e.preventDefault();
    var localidad = $("#nomLocalidad").val();   
    var usuario_actual = $("#usuario_actual").val();
    var idUsuario = $("#id_usuario").val();
       if(localidad != undefined && usuario_actual != undefined){
        const formData = new FormData();
        formData.append('localidad',localidad);
        formData.append('usuario_actual', usuario_actual);
        formData.append('id_usuario', idUsuario);

        const resp = await axios.post(`./controlador/apiRol.php?action=registrarLocalidad`, formData);
        const data = resp.data;
        if(data.error){
            return swal("Error", data.msj, "error");
        }
        return swal("Exito!", data.msj, "success",{
            buttons: false,
            timer: 3000,
        }).then(() => {
                
                    // Se limpia el formulario
                    $("#nombreLocalidad").val('');
                    $("#usuario_actual").val('');
                    location.reload(); 
                    
                
            })
    }else{
        swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    } 
  });



  $('#nomLocalidad').blur(async function () {
    
    if(this.value.length > 0 ){
        try{
            const resp = await axios(`./controlador/apiRol.php?action=obtenerLocalidad&localidad=${this.value}`);
            const data = resp.data;
            if(data.localidad.length > 0){
                console.log(data.localidad[0]);
                $('#nomLocalidad')
                return swal('Esta localidad ya existe ');
            }
        }catch(err){
            console.log('Error - ', err);
        }
    }
  })
     $('.btnCrearLocalidad').on('click', function(){
   $('#modalRegistrarLocalidad').modal('show');
   } );

   //cerrar modal crear localidad
   $("#cerrarModalLocal").on("click", function(){

    swal({
        icon:"warning",
        title: "¿Desea salir?",
        text:" Si acepta se perderá la información.",
        
        buttons:[ "Cancelar","Aceptar",], 
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
                          
            $("#modalRegistrarLocalidad").modal("hide");
            
        } else {

            $("#modalRegistrarLocalidad").modal("show");
        
        }
    });

  });


//FUNCION EDITAR Localidades
    $('.btnEditarLocalidad ').on('click', function() {
        // info previa
        const idLocalidad = $(this).data('idlocalidad'); 
        const local = $(this).data('nombrelocalidad');
        var usuario_actual = $("#usuario_actual").val();
        var idUsuario = $("#id_usuario").val();
        
        //llena los campos
        $("#idlocalidad").val(idLocalidad),
        $("#localidad").val(local),
    
        $('#modalEditarLocalidad').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var idlocalidad = Number(idLocalidad); 
            const formData = new FormData();
            formData.append('id_localidad', idlocalidad);
            formData.append('localidad',$("#localidad").val());
            formData.append('usuario_actual', usuario_actual);
            formData.append('id_usuario', idUsuario);

            
        const resp = await axios.post('./controlador/apiRol.php?action=actualizarLocalidad', formData);
        const data = resp.data;
            if(data.error){
                return swal("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarLocalidad').modal('hide');
                return swal("Exito!", data.msj, "success", {
                    timer:3000,
                    buttons:false
                }).then(() => {
                    // Se limpia el formulario
                    $("#localidad").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })


    //cerrar modal editar localidad
    $("#cerrarLocal").on("click", function(){

        swal({
            icon:"warning",
            title: "¿Desea salir?",
            text:" Si acepta se perderá la información.",
            
            buttons:[ "Cancelar","Aceptar",], 
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                              
                $("#modalEditarLocalidad").modal("hide");
                
            } else {
    
                $("#modalEditarLocalidad").modal("show");
            
            }
        });
    
      });
    
// //eliminar localidades
  $('.btnEliminarLocalidad').on('click', function (){
   const idlocalidad = $(this).data('idlocalidad');
   var idUsuario = $("#id_usuario").val();
       swal("Eliminar Localidad", "¿Esta seguro de eliminar esta Localidad?", "warning",{buttons:["Cancelar","Aceptar"] ,dangerMode:true}).then(async (value) => {
    if (value){
        const formData = new FormData();
        formData.append('id_localidad', idlocalidad);
        formData.append('id_usuario', idUsuario);

        const resp = await axios.post('./controlador/apiRol.php?action=eliminarLocalidad', formData);
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


  ////cerrarPermisos

  $("#cerrarPermisos").on("click", function(){

    swal({
        icon:"warning",
        title: "¿Desea salir?",
        text:" Si acepta se perderá la información.",
        
        buttons:[ "Cancelar","Aceptar",], 
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
                          
            $("#modalEditarPermisos").modal("hide");
            
        } else {

            $("#modalEditarPermisos").modal("show");
        // $("#modalRegistrarRol").modal("show");

        }
    });

  });

    

}); 

