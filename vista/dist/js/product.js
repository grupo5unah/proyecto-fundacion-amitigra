$(document).ready(function () {
  $("#typeP").select2();
  $("#tipoProducto").select2();
  $("#movimientoProducto").select2();
  $("#movimientoLocalidad").select2();

  // Busca si el nombre existe
  $("#nombreP").blur(async function () {
    //console.log(this.value);
    if (this.value.length > 0) {
      try {
        const resp = await axios(
          `./controlador/api.php?action=obtenerProducto&nombreProducto=${this.value}`
        );
        const data = resp.data;
        if (data.producto.length > 0) {
          console.log(data.producto[0]);
          $("#cantProducto");
          $("#precioProducto");
          $("#tipoProducto");
          $("#cantProducto");
          return swal("Este producto ya existe en el inventario");
        } else {
          //return swal('NO existe este producto');
        }
      } catch (err) {
        console.log("Error - ", err);
      }
    }
  });

  const contenedorProducto = $("#productTable  .tbody");
  const habitarbtn = document.querySelector("#formProducto");
  const listaProduct = $("#btnAddList");
  let articulosProducto = [];
  let idProductoTemporal = null;

  // $("#tipoProducto").change( function() {
  //     if ($(this).val() !== '3') {
  //         $("#precioAlquiler").prop("disabled", true);
  //     } else {
  //         $("#precioAlquiler").prop("disabled", false);
  //     }
  // });

  // funciones de producto
  function agregarProducto(e) {
    e.preventDefault();
    const infoProducto = {
      //crea un objeto con el contenido del formulario
      nombreProducto: $("#nombreP").val(),
      precioP: $("#precioProducto").val(),
      descripcionP: $("#descripcion").val(),
      tipoProducto: {
        id: $("#tipoProducto").val(),
        nombre: $("#tipoProducto option:selected").text(),
      },
      cantInicia: $("#inicial").val(),
      minimo: $("#minimo").val(),
      maximo: $("#maximo").val(),
    };
    // agrergo el producto al arreglo
    articulosProducto = [...articulosProducto, infoProducto];
    // if(articulosProducto.length > 0) sincronizarStorage(articulosProducto)
    //agrega  art a la tabla

    llenarTabla();
    resetearFormulario();
  }

  function llenarTabla() {
    $(".tbody tr").remove();
    articulosProducto.forEach((producto, index) =>
      agregarFila(producto, index)
    );
  }
  // btnRegistrarInventario
  $("#registrarInventario").click(async function (e) {
    e.preventDefault();
    var usuario_actual = $("#usuario_actual").val();
    var id_entrada = Number($("#entrada").val());
    var id_local = Number($("#id_local").val());

    if (articulosProducto !== undefined && usuario_actual != undefined) {
      const formData = new FormData();
      formData.append(
        "contProducto",
        JSON.stringify(
          articulosProducto.map((p) => ({
            nombre: p.nombreProducto,
            precio: p.precioP,
            descripcion: p.descripcionP,
            id: p.tipoProducto.id,
            inicial: p.cantInicia,
            minimo: p.minimo,
            maximo: p.maximo,
          }))
        )
      );
      formData.append("usuario_actual", usuario_actual);

      axios
        .post(`./controlador/api.php?action=registrarProducto`, formData)
        .then((lastid) => {
          if (lastid) {
            const formData1 = new FormData();
            formData1.append(
              "contProducto",
              JSON.stringify(
                articulosProducto.map((p) => ({ inicial: p.cantInicia }))
              )
            );
            formData1.append("usuario_actual", usuario_actual);
            formData1.append("entrada", id_entrada);
            axios
              .post(
                "./controlador/api.php?action=registrarEntradaInicial",
                formData1
              )
              .then((id) => {
                if (id) {
                  const formData2 = new FormData();
                  formData2.append(
                    "contProducto",
                    JSON.stringify(
                      articulosProducto.map((p) => ({
                        inicial: p.cantInicia,
                        minimo: p.minimo,
                        maximo: p.maximo,
                      }))
                    )
                  );
                  formData2.append("usuario_actual", usuario_actual);
                  formData2.append("local", id_local);

                  axios
                    .post(
                      "./controlador/api.php?action=registrarInventarioInicial",
                      formData2
                    )
                    .then(res=>{
                        const data = res.data;
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
                                $("#modalCrearProducto").modal("hide");
                             //$('.tbody tr').remove();
                             //desabilita el boton registrar
                             //registrar.prop('disabled', true);
                             location.reload();
                               
                            });
                    });
                }
              });
          }
        })
        .catch((err) => console.log(err));
    }
  });
  // muestra el carrito de compras en el html
  function agregarFila(producto = {}, index = -1) {
    const {
      nombreProducto,
      precioP,
      descripcionP,
      tipoProducto,
      cantInicia,
      minimo,
      maximo,
    } = producto;
    contenedorProducto.append(`
        <tr >
            <td>${index + 1}</td>
            <td>${nombreProducto}</td>
            <td>${precioP}</td>
            <td>${descripcionP}</td>
            <td>${tipoProducto.nombre}</td>
            <td>${cantInicia}</td>
            <td>${minimo}</td>
            <td>${maximo}</td>
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
          articulosProducto.splice(id, 1);
          // sincronizarStorage(articulosProducto);
          llenarTabla();
        }
      });
    });

    $(".btnEditar").on("click", (e) => {
      let id = e.target.dataset.id;
      idProductoTemporal = id;
      let productoSeleccionado = articulosProducto[id];
      if (productoSeleccionado !== undefined) {
        $("#nombreP").val(productoSeleccionado.nombreProducto);
        $("#precioProducto").val(productoSeleccionado.precioP);
        $("#descripcion").val(productoSeleccionado.descripcionP);
        $("#tipoProducto").val(productoSeleccionado.tipoProducto.id);
        $("#descripcion").val(productoSeleccionado.cantInicia);
        $("#descripcion").val(productoSeleccionado.minimo);
        $("#descripcion").val(productoSeleccionado.maximo);
        $("#btnProductUpdate").attr("type", "button");
        $("#btnAddList").attr("type", "hidden");
      }
    });
  }

  const editarProducto = (e) => {
    e.preventDefault();

    articulosProducto[idProductoTemporal] = {
      ...articulosProducto[idProductoTemporal],
      nombreProducto: $("#nombreP").val(),
      precioP: $("#precioProducto").val(),
      descripcionP: $("#descripcion").val(),
      tipoProducto: {
        id: $("#tipoProducto").val(),
        nombre: $("#tipoProducto option:selected").text(),
      },
      cantInicia: $("#inicial").val(),
      minimo: $("#minimo").val(),
      maximo: $("#maximo").val(),
    };
    //   sincronizarStorage(articulosProducto);
    $("#btnProductUpdate").attr("type", "hidden");
    $("#btnAddList").attr("type", "button");
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

  //     function cargarStorage(){
  //         const productsStorage = localStorage.getItem('productos');
  //         if(!productsStorage){
  //             localStorage.setItem('productos',JSON.stringify([]));
  //         }else{
  //             articulosProducto = JSON.parse(productsStorage);
  //             llenarTabla();
  //         }
  //     };

  //     function sincronizarStorage(data=[]){
  //         if(data.length > 0) localStorage.setItem('productos',JSON.stringify(data));
  //     }

  //    cargarStorage();

  // cuando agregas un curso presionando agragar a table
  listaProduct.on("click", agregarProducto);
  $("#btnProductUpdate").on("click", editarProducto);

  function resetearFormulario() {
    const formulario = $("#formProducto");
    formulario.reset();
  }

  ///// prueba
  $(".btnSumarI").on("click", function () {
    // info previa
    const idInventario = $(this).data("idinve");
    const nombreP = $(this).data("nombre");
    const stock = $(this).data("stock");
    const usuario_actual = $("#usuario_actual").val();

    let pro = $("#pro");
    $("#pro p").remove();
    pro.append(`
                    <p> Agregar: <span>${nombreP}</span></p>
                    `);

    $("#agregarProducto").modal("show");

    $(".idStock").on("click", async function () {
      const valor = $("#nuevo").val();
      let nuevoStock = Number(stock) + Number(valor);
      console.log(nuevoStock);

      var id_stock = Number(idInventario);
      console.log(id_stock);
      const formData = new FormData();
      formData.append("id_inventario", id_stock),
        formData.append("stock", nuevoStock),
        formData.append("usuario_actual", usuario_actual),
        console.log(formData);
      //console.log(formData.append('usuario_actual', usuario_actual));
      const resp = await axios.post(
        "./controlador/api.php?action=actualizarInventario",
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
        $("#agregarProducto").modal("hide");
        return swal("Exito!", data.msj, "success", {
          timer: 3000,
          buttons: false,
        }).then(() => {
          // Se limpia el formulario

          location.reload();
        });
      }
    });
  });

  // llamar ala modal producto
  $("#addProductModalBtn").on("click", function () {
    $("#modalCrearProducto").modal("show");
  });
  // adviente al usuario de accion de salida de modal producto

  $("#cerrar").on("click", function () {
    swal({
      icon: "warning",
      title: "Saliendo?",
      text: "Seguro que quieres salir?",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $("#modalCrearProducto").modal("hide");
      } else {
        $("#modalCrearProducto").modal("show");
      }
    });
  });

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
});
