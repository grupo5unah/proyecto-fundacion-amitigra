$(document).ready(function () {
  $(".movimientoProducto").select2();
  $("#movimientoLocalidad").select2();

  //btnRegistrarMovimiento
  $("#formM").submit(function (e) {
    e.preventDefault();
    const id = $("#p ").val();
    const nombre = $(".movimientoProducto option:selected").text();
    const stock = $(".movimientoProducto option:selected").data("stock");
    const id_movimiento = $("input:radio[name=entrada]:checked").val();
    const movimiento = $("input:radio[name=entrada]:checked ").data("mo");
    const id_inventario = $(".movimientoProducto option:selected").data(
      "id_inventario"
    );
    const descripcion = $("#descripcion").val();
    const cantidad = $("#cantidad").val();
    const localidad_id = $("#movimientoLocalidad").val();
    
    var usuario_actual = $("#usuario_actual").val();
    var id_objeto = $("#id_objeto").val();
    var idUsuario = $("#id_usuario").val();
    console.log(id,id_inventario,nombre,descripcion,usuario_actual,stock,);

    if (
      nombre != undefined &&
      descripcion != undefined &&
      usuario_actual != undefined &&
     
      id_movimiento != undefined &&
      movimiento != undefined &&
      id_inventario != undefined &&
      cantidad != undefined &&
      localidad_id != undefined
    ) {
      const formData = new FormData();
      formData.append("id_producto", id);
      formData.append("descripcion", descripcion);
      formData.append("cantidad", cantidad);
      formData.append("id_movimiento", id_movimiento);
      formData.append("id_inventario", id_inventario);
      formData.append("movimiento", movimiento);
      formData.append("usuario_actual", usuario_actual);
      formData.append("stock", stock);
      formData.append("nombre_movimiento", movimiento);
      formData.append('id_usuario', idUsuario);
      formData.append('id_objeto', id_objeto);

      axios
        .post(`./controlador/api.php?action=registrarEntrada`, formData)
        .then((res) => {
          const data = res.data
          if (!data.error) {
            const formData1 = new FormData();
            formData1.append("id_localidad", localidad_id);
            formData1.append("id_inventario", id_inventario);
            formData1.append("stock", stock);
            formData1.append("nombre_movimiento", movimiento);
            formData1.append("usuario_actual", usuario_actual);
            formData1.append("cantidad", cantidad);
            formData1.append('id_usuario', idUsuario);
            formData1.append('id_objeto', id_objeto);

            axios
              .post(
                "./controlador/api.php?action=actualizarInventario",
                formData1
              )
              .then((res) => {
                const data = res.data;
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
                  $("#modalCrearMovimiento").modal("hide");
                  $("#descripcion")="";
                   $("#cantidad")="";
                   $("#movimientoLocalidad")="";
                   $("#p ")="";

                  
                });
              });
          }
        });
    } else {
      swal("Advertencia!", "Es necesario rellenar todos los campos", "warning");
    }
  });

  // boton que llama al modal crear movimiento
  $("#btncrearMovimiento").on("click", function () {
    $("#modalCrearMovimiento").modal("show");
  });
  // cierre la modal de movimiento


  $("#cerrarM").on("click", function(){

    swal({
        icon:"warning",
        title: "¿Desea salir?",
        text:" Si acepta se perderá la información.",
        
        buttons:[ "Cancelar","Aceptar",], 
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
                          
          $("#modalCrearMovimiento").modal("hide");
            location.reload();
                  $("#descripcion")="";
                  $("#cantidad")="";
                  $("#movimientoLocalidad")="";
                  $("#p ")="";
            
        } else {

          $("#modalCrearMovimiento").modal("show");
       

        }
    });

         });

  $("#cantidad").blur(async function () {
    const nombre_movimiento = $("input:radio[name=entrada]:checked ").data(
      "movi"
    );
     const nombre = $(".movimientoProducto option:selected").text();
    const stock = $(".movimientoProducto option:selected").data("stock");
    const localID = $(".movimientoProducto option:selected").data("localidad");
    const localidad_id = $("#movimientoLocalidad").val();
    if (nombre_movimiento.indexOf("SALIDA") > -1) {
      const cant = $("#cantidad").val();
      
      if (Number(stock) <= Number(cant) || Number(localidad_id) !== Number(localID) ) {
        
        $('#registrar').prop('disabled', true);
        swal(
          "Lo sentimos no tenemos en Inventario esa cantidad de",
          nombre,
          "info",
          {
            position: "top-end",
            timer: 2000,
            button: false,
          }
        );
      }else{
        $('#registrar').prop('disabled', false);
      }
    }
  });

  
  
});
