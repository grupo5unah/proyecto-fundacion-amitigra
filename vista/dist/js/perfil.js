$(document).ready(function () {
  
  $("#formGusuarios").submit(async function (e) {
    e.preventDefault();

    var nombreC = $("#nombreCompleto").val();
    var nombreusuario = $("#nombreusuario").val();
    var telefono = $("#telefono").val();
    var correo = $("#correo").val();
    var Contraseña = $("#Contraseña").val();
    var ConfirmarContraseña = $("#ConfirmarContraseña").val();
    var genero = $("#genero").val();
    var rol = $("#rol").val();
    var usuario_actual = $("#usuario_actual").val();

    if (
      nombreC != undefined &&
      nombreusuario != undefined &&
      telefono != undefined &&
      correo != undefined &&
      Contraseña != undefined &&
      ConfirmarContraseña != undefined &&
      genero != undefined &&
      rol != undefined &&
      usuario_actual != undefined
    ) {
      const formData = new FormData();

      formData.append("nombreCompleto", nombreC);
      formData.append("nombreusuario", nombreusuario);
      formData.append("telefono", telefono);
      formData.append("correo", correo);
      formData.append("Contraseña", Contraseña);
      formData.append("ConfirmarContraseña", ConfirmarContraseña);
      formData.append("genero", genero);
      formData.append("rol", rol);
      formData.append("usuario_actual", usuario_actual);

      const resp = await axios.post(
        "./controlador/apiGusuarios.php?action=registrarUsuario",
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
          $("#nombreusuario").val("");
          $("#telefono").val("");
          $("#correo").val("");
          $("#Contraseña").val("");
          $("#ConfirmarContraseña").val("");
          $("#genero").val("");
          $("#rol").val("");
          location.reload();
        }
      });
    } else {
      swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    }
  });

});