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

  $(".btnCrearUsuario").on("click", function () {
    $("#modalCrearUsuario").modal("show");
  });

  //FUNCION PARA EDITAR USUARIOS
  $(".btnEditarUsuario").on("click", function () {
    // info previa
    const idusuario = $(this).data("idusuario");
    const nombrecompleto = $(this).data("nombrecompleto");
    const nombre_usuario = $(this).data("nombreusuario");
    const telefono = $(this).data("telefono");
    const correo = $(this).data("correo");
    const contrasena = $(this).data("contrasena");
    const id_rol = $(this).data("id_rol");
    const id_estado = $(this).data("id_estado");

    //llena los campos
    //$("#id").val(idObjeto),
    $("#idusuario").val(idusuario),
      $("#nombrecompct").val(nombrecompleto),
      $("#nombreusuarioact").val(nombre_usuario);
    $("#telefonoact").val(telefono);
    $("#correoact").val(correo);
    $("#contrasenaact").val(contrasena);
    $("#rolact").val(id_rol);
    $("#estadoact").val(id_estado);

    //mostrar el modal
    $("#modalEditarUsuario").modal("show");

    $(".btnEditarBD").on("click", async function () {
      var Idusuario = Number(idusuario);
      //console.log(IdRol);
      const formData = new FormData();
      formData.append("id_usuario", Idusuario);
      formData.append("nombre_completo", $("#nombrecompct").val());
      formData.append("nombre_usuario", $("#nombreusuarioact").val());
      formData.append("telefono", $("#telefonoact").val());
      formData.append("correo", $("#correoact").val());
      formData.append("contrasena", $("#contrasenaact").val());
      formData.append("rol_id", $("#rolact").val());
      formData.append("estado_id", $("#estadoact").val());
      console.log(formData);

      const resp = await axios.post(
        "./controlador/apiGusuarios.php?action=actualizarUsuario",
        formData
      );
      const data = resp.data;
      console.log(data);
      if (data.error) {
        return swal("Error", data.msj, "error", {
          timer: 3000,
          buttons: false,
        });
      } else {
        $("#modalEditarUsuario").modal("hide");
        return swal("Exito!", data.msj, "success", {
          timer: 3000,
          buttons: false,
        }).then(() => {
          // Se limpia el formulario
          console.log("Ya se cerro el alert");
          $("#nombrecompct").val("");
          $("#nombreusuarioact").val("");
          $("#telefonoact").val("");
          $("#correoact").val("");
          $("#contrasenaact").val("");
          $("#rolact").val("");
          $("#estadoact").val("");
          location.reload();
        });
      }
    });
  });

  //FUNCION PARA RESETEAR CONTRASEñA SIENDO ADMINISTRADOR
  $(".btnResetearClaves").on("click", function () {
    // info previa
    const idusuario = $(this).data("idusuario");
    const contrasena = $(this).data("contrasena");
    const rep_nuevacontra=$(this).data("contrasena");

    

    //llena los campos

    $("#idusuario").val(idusuario), 
    
    //mostrar el modal
    $("#modalResetearClave").modal("show");
    $(".btnResetClave").on("click", async function () {
      var Idusuario = Number(idusuario);

      const formData = new FormData();
      formData.append("id_usuario", Idusuario);
      formData.append("contrasena", $("#nuevacontra").val());
      formData.append("contrasena", $("#rep_nuevacontra").val());
      
      
      console.log(formData);
      const resp = await axios.post(
        "./controlador/apiGusuarios.php?action=resetearClave",
        formData
      );
      const data = resp.data;
      console.log(data);
      if (data.error) {
        return swal("Error", data.msj, "error", {
          timer: 3000,
          buttons: false,
        });
      } else {
        $("#modalResetearClave").modal("hide");
        return swal("Exito!", data.msj, "success", {
          timer: 3000,
          buttons: false,
        }).then(() => {
          // Se limpia el formulario
          $("#nuevacontra").val("");
          $("#rep_nuevacontra").val("");
          location.reload();
        });
      }
    });

      //para eliminar usuario
    $(".btnEliminarUsuario").on("click", function () {
      const idusuario = $(this).data("idusuario");
      swal(
        "Eliminar Usuario",
        "Esta seguro de eliminar este Usuario",
        "warning",
        { buttons: [true, "OK"] }
      ).then(async (value) => {
        if (value) {
          const formData = new FormData();
          formData.append("id_usuario", idusuario);
          const resp = await axios.post(
            "./controlador/apiGusuarios.php?action=eliminarUsuario",
            formData
          );
          const data = resp.data;
          //console.log(data);
          if (data.error) {
            return swal("Error", data.msj, "error", {
              buttons: false,
              timer: 3000,
            });
          }
          return swal("Exito!", data.msj, "success", {
            buttons: false,
            timer: 3000,
          }).then(() => {
            location.reload();
          });
        }
      });
    });
  });
});
