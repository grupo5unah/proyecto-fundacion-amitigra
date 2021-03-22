$(document).ready(function () {
    $("#formTipoSolicitudes").submit(async function (e) {
      e.preventDefault();
  
      var tipoSolicitud = $("#tipoSolicitud").val();
      var preciosolicitud = $("#preciosolicitud").val();
      var usuario_actual = $("#usuario_actual").val();
  
      if (
        tipoSolicitud != undefined &&
        preciosolicitud != undefined &&
        usuario_actual !=undefined
      ) {
        const formData = new FormData();
  
        formData.append("tipoSolicitud", tipoSolicitud);
        formData.append("preciosolicitud", preciosolicitud);
        formData.append("usuario_actual",usuario_actual);
  
        const resp = await axios.post('./controlador/apiTipSolicitudes.php?action=registrarTipSolicitud',formData);
      
  
        const data = resp.data;
  
        if (data.error) {
          return swal("Error", data.msj, "error");
        }
  
        return swal("Exito!", data.msj, "success").then((value) => {
          if (value) {
            // Se limpia el formulario de mantenimiento de tipo de solicitudes
            $("#tipoSolicitud").val("");
            $("#preciosolicitud").val("");
           
            location.reload();
          }
        });
      } else {
        swal("Advertencia!", "Es necesario rellenar todos los campos","warning");
      }
    })
  
    $(".btnCreartipoSolicitud").on("click", function () {
      $("#modalCreartipoSolicitud").modal("show");
    });
  
  
  
    //mantenimiento Solicitudes
  //eliminar una solicitud
   $(".btnEliminarTipoSolicitud").on("click", function () {
     const idtiposolicitud = $(this).data("idtiposolicitud");
     var usuario_actual = $("#usuario_actual").val();
     swal(
       "Eliminar Tipo de Solicitud",
       "Esta seguro de eliminar este tipo de solicitud",
       "warning",
       { buttons: [true, "OK"] }
     ).then(async (value) => {
       if (value) {
        
         const formData = new FormData();
         formData.append("id_tipo_solicitud", idtiposolicitud);
         formData.append('usuario_actual', usuario_actual);
       
         const resp = await axios.post(
          "controlador/apiTipSolicitudes.php?action=eliminarTipSolicitud",
           formData
         );
         const data = resp.data;
         //console.log(data);
         if (data.error) {
           return swal("Error", data.msj, "error", {
             buttons: false,
             timer: 2000,
           });
         }
         return swal("Exito!", data.msj, "success", {
           buttons: false,
           timer: 2000,
         }).then(() => {
           location.reload();
         });
       }
     });
   });
   
  //actualiza un tipo de solicitud
   $(".btnEditarTipoSolicitud").on("click", function () {
     // info previa
     const idtiposolicitud = $(this).data("idtiposolicitud");
     const tipo = $(this).data("tipo");
     const precio_solicitud = $(this).data("precio_solicitud");
     var usuario_actual = $("#usuario_actual").val();
  
     //llena los campos
     $("#tiposol").val(tipo),
       $("#precio").val(precio_solicitud ),
       
       //mostrar el modal
       $("#modalEditarTipoSolicitud").modal("show");
     $(".btnEditarBD").on("click", async function () {
       var Idtipsol = Number(idtiposolicitud);
       const formData = new FormData();
       formData.append("id_tipo_solicitud", Idtipsol);
       formData.append("tipo", $("#tiposol").val());
       formData.append("precio_solicitud", $("#precio").val());
       formData.append('usuario_actual', usuario_actual);
       
       
       const resp = await axios.post(
         "controlador/apiTipSolicitudes.php?action=actualizarTipSolicitud",
         formData
       );
       const data = resp.data;
       if (data.error) {
         return swal("Error", data.msj, "error", {
           timer: 3000,
           buttons: false,
         });
       } else {
         $("#modalEditarTipoSolicitud").modal("hide");
         return swal("Exito!", data.msj, "success", {
           timer: 3000,
           buttons: false,
         }).then(() => {
           // Se limpia el formulario
           
           $("#tipo").val("");
           $("#precio_solicitud").val("");
           location.reload();
         });
       }
     });
   });
  
   
  });
  