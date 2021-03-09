$(document).ready(function(){    
     /**------------------------------------------------------------------------------------------------------
      *                                                                                                      *
      *                                    Mantenimiento Nacionalidades                                      *
      *                                                                                                      *
      * ------------------------------------------------------------------------------------------------------
      */
  
    //BOTON EDITAR MODAL (TABLA NACIONALIDAD)
    $('.btnEditarNacionalidad').on('click', function() {
      // info previa
      // con el data se imprime en la modal los datos que hay en la tabla
      const idnacionalidad = $(this).data('idnacionalidad'); 
      const nacionalidad = $(this).data('nacionalidad');
      const fmodificacion = $(this).data('fmodificacion');
      const modificadoPor = $(this).data('modificadorPor');
      console.log(idnacionalidad, nacionalidad, fmodificacion, modificadoPor);
  
      //$("#idreservacion").val(idreservacion),
      $("#Nacionalidad").val(nacionalidad),
      $("#Fmodificacion").val(fmodificacion),
      $("#ModificadoPor").val(modificadoPor),
      
      //mostrar el modal
      $('#modalEditarNacionalidad').modal('show');
      //BOTON PARA QUE ACTUALICE LA BASE DE DATOS
      $('.btnEditarBD').on('click', async function() {
          var IdNacionalidad = Number(idnacionalidad); 
          console.log(IdNacionalidad);
          const formData = new FormData();
          formData.append('id_tipo_nacionalidad', IdNacionalidad);
          formData.append('nacionalidad',$("#Nacionalidad").val());
          formData.append('fecha_modificacion',$("#Femodificacion").val());
          formData.append('modificado_por',$("#ModificadoPoru").val());
         
          console.log(formData);
          
         const resp = await axios.post('./controlador/ctr.nacionalidad.php?action=actualizarNacionalidad', formData);
         const data = resp.data;
          console.log(data);
          if(data.error){
              return swal("Error", data.msj, "error", {
                  timer:3000,
                  buttons:false
              });
          } else{
              $('#modalEditarNacionalidad').modal('hide');
              return swal("Exito!", data.msj, "success", {
                  timer:3000,
                  buttons:false
              }).then(() => {
                  // Se limpia el formulario
                  console.log('Ya se cerro el alert');
                  $("#Nacionalidad").val('');
                  $("#Fmodificacion").val('');
                  $("#ModificadoPor").val('');
                  location.reload(); 
              })
          }
              
      });
      
    })  
    
     //BOTON PARA ELIMINAR NACIONALIDAD (TABLA HOTEL)
  $('.btnEliminarNacionalidad').on('click', function (){
    const idNacionalidad = $(this).data('idnacionalidad');
    swal("Eliminar la Nacionalidad", "¿Esta seguro de eliminar la Nacionalidad?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
        if (value){
            //console.log(idReservacion);
            const formData = new FormData();
            formData.append('id_tipo_nacionalidad', idNacionalidad);
            const resp = await axios.post('./controlador/ctr.nacionalidad.php?action=eliminarNacionalidad', formData);
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