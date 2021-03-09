$(document).ready(function () {
  $("#formGusuariosh").submit(async function (e) {
    e.preventDefault();

    var nombreCompleto = $("#nombreCompleto").val();
    var identidad = $("#identidad").val();
    var telefono = $("#telefono").val();
    var croquis = $("#croquis").val();
    var recibo = $("#recibo").val();
    var tipo_nac = $("#tipo_nac").val();
    var tipo = $("#tipo").val();
    var estatus_solicitud = $("#estatus_solicitud").val();
    var usuario_actual = $("#usuario_actual").val();

    if (
      nombreCompleto != undefined &&
      identidad != undefined &&
      telefono != undefined &&
      croquis != undefined &&
      recibo != undefined &&
      recibo != undefined &&
      tipo_nac != undefined &&
      tipo != undefined &&
      estatus_solicitud != undefined &&
      usuario_actual != undefined
    ) {
      const formData = new FormData();

      formData.append("nombreCompleto", nombreCompleto);
      formData.append("identidad", identidad);
      formData.append("telefono", telefono);
      formData.append("croquis", croquis);
      formData.append("recibo", recibo);
      formData.append("tipo_nac", tipo_nac);
      formData.append("tipo", tipo);
      formData.append("estatus_solicitud", estatus_solicitud);
      formData.append("usuario_actual", usuario_actual);

      const resp = await axios.post(
        "./controlador/apiSolicitudes.php?action=registrarSolicitud",
        formData
      );

      const data = resp.data;

      if (data.error) {
        return swal("Error", data.msj, "error");
      }

      return swal("Exito!", data.msj, "success").then((value) => {
        if (value) {
          // Se limpia el formulario de mantenimiento
          $("#nombreCompleto").val("");
          $("#identidad").val("");
          $("#telefono").val("");
          $("#croquis").val("");
          $("#recibo").val("");
          $("#tipo_nac").val("");
          $("#tipo").val("");
          $("#estatus_solicitud").val("");
          location.reload();
        }
      });
    } else {
      swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    }
  });

  $(".btnCrearSolicitud").on("click", function () {
    $("#modalCrearSolicitud").modal("show");
  });



  //mantenimiento Solicitudes
//eliminar una solicitud
 $(".btnEliminarSolicitud").on("click", function () {
   const idsolicitud = $(this).data("idsolicitud");
   swal(
     "Eliminar Solicitud",
     "Esta seguro de eliminar esta solicitud",
     "warning",
     { buttons: [true, "OK"] }
   ).then(async (value) => {
     if (value) {
      
       const formData = new FormData();
       formData.append("id_solicitud", idsolicitud);
       const resp = await axios.post(
         "controlador/apiSolicitudes.php?action=eliminarSolicitud",
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
 
//actualiza una solicitud
 $(".btnEditarSolicitud").on("click", function () {
   // info previa
   const idsolicitud = $(this).data("idsolicitud");
   const idcliente = $(this).data("idcliente");
   const id_tipo_solicitud = $(this).data("id_tipo_solicitud");
   const tipo = $(this).data("tipo");
   const id_estatus_solicitud = $(this).data("id_estatus_solicitud");
   const estatus_solicitud = $(this).data("estatus_solicitud");


   //llena los campos
   $("#idsolicitud").val(idsolicitud),
     $("#idcliente").val(idcliente),

     $("#tipo").val(id_tipo_solicitud ),
     $("#estatus_solicitud").val(id_estatus_solicitud),
      
     //mostrar el modal
     $("#modalEditarSolicitud").modal("show");
   $(".btnEditarBD").on("click", async function () {
     var Idsol = Number(idsolicitud);
     const formData = new FormData();
     formData.append("id_solicitud", Idsol);
     formData.append("estatus_solicitud", $("#estatus_solicitud").val());
     formData.append("tipo_solicitud", $("#tipo").val());
     
     //formData.append('rol',$("#rol").val())
     const resp = await axios.post(
       "controlador/apiSolicitudes.php?action=actualizarSolicitud",
       formData
     );
     const data = resp.data;
     if (data.error) {
       return swal("Error", data.msj, "error", {
         timer: 3000,
         buttons: false,
       });
     } else {
       $("#modalEditarSolicitud").modal("hide");
       return swal("Exito!", data.msj, "success", {
         timer: 3000,
         buttons: false,
       }).then(() => {
         // Se limpia el formulario
         console.log("Ya se cerro el alert");
         $("#estatus_solicitud").val("");
         $("#tipo").val("");
         location.reload();
       });
     }
   });
 });

 
});
