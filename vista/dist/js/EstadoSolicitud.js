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
   $(".btnEliminarEstadoSolicitud").on("click", function () {
     const idestadosolicitud = $(this).data("idestadosolicitud");
     var usuario_actual = $("#usuario_actual").val();
     swal(
       "Eliminar Estado de Solicitud",
       "Esta seguro de eliminar este estado de solicitud",
       "warning",
       { buttons: [true, "OK"] }
     ).then(async (value) => {
       if (value) {
        
         const formData = new FormData();
         formData.append("id_estatus_solicitud", idestadosolicitud);
         formData.append('usuario_actual', usuario_actual);
       
         const resp = await axios.post(
          "controlador/apiEstadoSolicitudes.php?action=eliminarEstadoSolicitud",
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
   
  //actualiza un Estadode solicitud
   $(".btnEditarEstadoSolicitud").on("click", function () {
     // info previa
     const idestadosolicitud = $(this).data("idestadosolicitud");
     const estatus = $(this).data("estatus");
     var usuario_actual = $("#usuario_actual").val();
  
     //llena los campos
     $("#estadoSolAct").val(estatus),
      
       
       //mostrar el modal
       $("#modalEditarEstadoSolicitud").modal("show");
     $(".btnEditarBD").on("click", async function () {
       var Idestadosol = Number(idestadosolicitud);
       const formData = new FormData();
       formData.append("id_estatus_solicitud", Idestadosol);
       formData.append("estatus", $("#estadoSolAct").val());
       formData.append('usuario_actual', usuario_actual);
       
       
       const resp = await axios.post(
         "controlador/apiEstadoSolicitudes.php?action=actualizarEstSolicitud",
         formData
       );
       const data = resp.data;
       if (data.error) {
         return swal("Error", data.msj, "error", {
           timer: 3000,
           buttons: false,
         });
       } else {
         $("#modalEditarEstadoSolicitud").modal("hide");
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
  