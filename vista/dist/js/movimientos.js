$(document).ready(function () {
  
  const registrar = $('#registrarMovimiento');
  const contenedorProducto = $("#moviemintoTable  .tbody");
  const formulario =document.querySelector("#formM");
  const listaProduct = $("#btnMO");
  let contMov = [];
  let idProductoTemporal = null;
 
  $(".movimientoProducto").select2();
  $("#movimientoLocalidad").select2();
  // funciones de producto
  function agregarProducto(e) {
    e.preventDefault();
    const infoProducto = {
      //crea un objeto con el contenido del formulario
      nombrep: {
        id: $(".movimientoProducto").val(),
        nombre: $(".movimientoProducto option:selected").text(),
      },
      stock: $(".movimientoProducto option:selected").data("stock"),
      id_movimiento: $("input:radio[name=entrada]:checked").val(),
      movimiento: $("input:radio[name=entrada]:checked ").data("mo"),
      id_inventario: $(".movimientoProducto option:selected").data(
        "id_inventario"
      ),
      descripcion: $("#descripcion").val(),
      cantidad: $("#cantidad").val(),
      localidad: {
        id: $("#movimientoLocalidad").val(),
        nombreL: $("#movimientoLocalidad option:selected").text(),
      },
    };
    // agrergo el producto al arreglo
    contMov = [...contMov, infoProducto];
    $(".tbody tr").remove();
    llenarTabla();
    resetearFormulario();
    listaProduct.prop('disabled', true);
    registrar.prop('disabled', false);
    
  }
  function llenarTabla() {
    $(".tbody tr").remove();
    contMov.forEach((producto, index) => agregarFila(producto, index));
    
  }
  

  // btnRegistrarMovimiento
  $("#registrarMovimiento").click(async function (e) {
    e.preventDefault();
    var usuario_actual = $("#usuario_actual").val();

    if (contMov !== undefined && usuario_actual != undefined) {
      const formData = new FormData();
      formData.append(
        "contMovi",
        JSON.stringify(
          contMov.map((p) => ({
            nombreID: p.nombrep.id,
            id_movimiento: p.id_movimiento,
            descripcion: p.descripcion,
            cantidad: p.cantidad,
          }))
        )
      );
      formData.append("usuario_actual", usuario_actual);

      axios
        .post(`./controlador/api.php?action=registrarEntrada`, formData)
        .then((lastid) => {
          if (lastid) {
            const formData1 = new FormData();
            formData1.append(
              "contMovi",
              JSON.stringify(
                contMov.map((p) => ({
                  nombreID: p.nombrep.id,
                  cantidad: p.cantidad,
                  id: p.localidad.id,
                  id_inventario: p.id_inventario,
                  stock: p.stock,
                  movimiento: p.movimiento,
                }))
              )
            );

            formData1.append("usuario_actual", usuario_actual);

            axios
              .post(
                "./controlador/api.php?action=actualizarInventario",
                formData1
              )
              .then(res=>{
                console.log(res);
                const data = res.data;
                console.log(data.msj);
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
                      
                      $('.tbody tr').remove();
                     //desabilita el boton registrar
                     registrar.prop('disabled', true);
                     $("#modalCrearMovimiento").modal("hide");
                     location.reload();
                       
                    });
            });
          }
        });     
    }
  });
  // muestra el carrito de compras en el html
  function agregarFila(producto = {}, index = -1) {
    const { nombrep, movimiento, descripcion, cantidad, localidad } = producto;
    contenedorProducto.append(`
          <tr >
              <td>${index + 1}</td>
              <td>${nombrep.nombre}</td>
              <td>${movimiento}</td>
              <td>${descripcion}</td>
              <td>${cantidad}</td>
              <td>${localidad.nombreL}</td>
              
              <td>
                  <button class="btn btn-warning btnEditar Producto glyphicon glyphicon-pencil" data-id="${index}"></button>
                  <button class="btn btn-danger btnEliminarP glyphicon glyphicon-remove" data-id="${index}"></button>
              </td>  
          </tr>
          `);
    $(".btnEliminarP").on("click", (e) => {
      let id = e.target.dataset.id;
      swal(
        "Eliminar producto",
        "Esta seguro que desea eliminar este producto?",
        "warning",
        {
          buttons: ["Cancelar", "Aceptar"],
        }
      ).then((resp) => {
        if (resp) {
          contMov.splice(id, 1);
          // sincronizarStorage(articulosProducto);
          llenarTabla();
        }
      });
    });

    $(".btnEditar").on("click", (e) => {
      let id = e.target.dataset.id;
      idProductoTemporal = id;
      let productoSeleccionado = contMov[id];
      if (productoSeleccionado !== undefined) {
        $(".movimientoProducto").val(productoSeleccionado.nombrep.id);
        $("#descripcion").val(productoSeleccionado.descripcion);
        $("#cantidad").val(productoSeleccionado.cantidad);
        $("#movimientoLocalidad").val(productoSeleccionado.localidad.id);

        $("#btnProductMovimiento").attr("type", "button");
        $("#btnMO").attr("type", "hidden");
      }
    });
  }

  const editarOrden = (e) => {
    e.preventDefault();

    contMov[idProductoTemporal] = {
      ...contMov[idProductoTemporal],
      nombrep: {
        id: $(".movimientoProducto").val(),
        nombre: $(".movimientoProducto option:selected").text(),
      },
      moviemiento:$('input:radio[name=entrada]:checked ').data('mo'),
      descripcion: $("#descripcion").val(),
      cantidad: $("#cantidad").val(),
      localidad: {
        id: $("#movimientoLocalidad").val(),
        nombreL: $("#movimientoLocalidad option:selected").text(),
      },
    };
    //   sincronizarStorage(articulosProducto);
    $("#btnProductMovimiento").attr("type", "hidden");
    $("#btnMO").attr("type", "button");
    llenarTabla();
    //resetearFormulario()
    swal(
      "Producto actualizado",
      "El producto se actualizo con exito",
      "success",
      {
        buttons: false,
        timer: 2000,
      }
    );
  };

  // cuando agregas un curso presionando agragar a table
  listaProduct.on("click", agregarProducto);
  $("#btnProductMovimiento").on("click", editarOrden);

  function resetearFormulario() {
    formulario.reset();
  }

  // boton que llama al modal crear movimiento
  $("#btncrearMovimiento").on("click", function () {
    $("#modalCrearMovimiento").modal("show");
  });
  // cierre la modal de movimiento
  $("#cerrarM").on("click", function () {
    swal({
      icon: "warning",
      title: "Saliendo...",
      text: "Desea salir?",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $("#modalCrearMovimiento").modal("hide");
      } else {
        $("#modalCrearMovimiento").modal("show");
      }
    });
  });

  $("#cantidad").blur(async function () {
    const nombre_movimiento = $("input:radio[name=entrada]:checked ").data("movi");
    const idP = $(".movimientoProducto").val();
    const nombre = $(".movimientoProducto option:selected").text();
    
    if (nombre_movimiento.indexOf("SALIDA") > -1) {
      
      try {
        const resp = await axios(
          `./controlador/contOrden.php?action=obtenerCantidad&idProducto=${idP}`
        );
        const data = resp.data;
        if (data.existencias.length > 0) {
          data.existencias.forEach((p, index) => {
            const cant = $("#cantidad").val();
            // console.log(cant, idP);
            if (Number(p.existencias)  <= Number(cant) ) {
              listaProduct.prop('disabled', true);
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
            }
          });
        }
      } catch (err) {
        console.log("Error - ", err);
      }
    }
  });
   
  
  
  
 


});
