
$(document).ready(function () {
  $('#managerEntrada').DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
      "order": [[ 3, "desc" ]]
    },
  });
  $('#managerSalida').DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
      "order": [[ 3, "desc" ]]
    },
  });
 // let  prueba = $('evaluar.',this).attr('td');

  $("#typeP").select2();
  $("#tipoProducto").select2();
  

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
          listaProduct.prop('disabled', true);
          return swal("Este producto ya existe en el inventario");
        } else {
          //return swal('NO existe este producto');
        }
      } catch (err) {
        console.log("Error - ", err);
      }
    }
  });
  const registrar=$('#registrarInventario');
  const contenedorProducto = $("#productTable  .tbody");
  const formulario = document.querySelector("#formProducto");
  const listaProduct = $("#btnAddList");
  let articulosProducto = [];
  let idProductoTemporal = null;



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
    listaProduct.prop('disabled', true);
    registrar.prop('disabled', false);
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
            const descripcion = "ENTRADA INICIAL"
            const formData1 = new FormData();
            formData1.append(
              "contProducto",
              JSON.stringify(
                articulosProducto.map((p) => ({ inicial: p.cantInicia }))
              )
            );
            formData1.append("usuario_actual", usuario_actual);
            formData1.append("entrada", id_entrada);
            formData1.append("descripcion", descripcion);
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
                              $('.tbody tr').remove();
                             //desabilita el boton registrar
                             registrar.prop('disabled', true);
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
  
  // cuando agregas un curso presionando agragar a table
  listaProduct.on("click", agregarProducto);
  $("#btnProductUpdate").on("click", editarProducto);

  function resetearFormulario() {
    formulario.reset();
  }

 

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

  ///////////////
  $('.btnVer').click(async function () {

    let id_producto = $(this).data('idinve');
    //const usuario = $(this).data('usuario'); 
    const nombre_producto = $(this).data('nombre');
    const fecha_movimiento = $(this).data('fecha');
    //const fecha = $(this).data('fecha');
     const info =$('#cont');
     $('#cont div ').remove();
     info.append(
        `
         <div class="6" >
         <P class="local col-6"> PRODUCTO: ${nombre_producto}</P>
         </div>
        `
        );
  
    if(id_producto){
        try{
            const data = (await axios.get(`./controlador/api.php?action=traerMovimientos&id_producto=${Number(id_producto)}`)).data;
            const listaDeProductosTabla = $('#listaDeProductosTabla');
            $('#listaDeProductosTabla tr').remove();
            data.movimiento.forEach((p, index) => listaDeProductosTabla.append(`
              
            <tr>
                <td>${index+1}</td>
                <td>${p.movimiento}</td>
                <td>${p.descripcion}</td>
                <td>${p.cantidad}</td>
                <td>${p.fecha}</td>
            </tr>
            `));
           
            $('#modalVerDetalleP').modal('show');
        }catch(err){
            console.log('Error - ', err);
        }
    }
  });

  // cambiar color
  
 
  




});
