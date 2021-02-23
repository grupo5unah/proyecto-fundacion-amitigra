<?php include("./modelo/conexionbd.php"); ?>
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content ">
    <!-- Default box -->
    <div class="box">

      <div class="box-header with-border">
        <h3 class="box-title">Ingreso de Productos</h3>
        <div class="container ">
          <div id="contenedorProducto">
            <form method="POST" id="formProducto">
              <div class="ingreso-producto form-group  row d-flex c ">
                
                <div class="col-sm-6 form-group">
                  <label for="">Nombre del Producto </label>
                  <input id="nombreP" class="form-control   secundary" type="text" name="nombreProducto" placeholde="Escriba el producto" required />

                </div>
               
                <div class="col-sm-6 m-auto form-group">
                  <label for="">Precio de Compra </label>
                  <input id="precioProducto" class="form-control  secundary" type="tel" name="precio" placeholde="Escriba el producto" required />

                </div>
              </div>
              <div class="row d-flex ">
                <div class="col-sm-6 form-group">
                  <label for="">Cantidad </label>
                  <input id="cantProducto" class="form-control   secundary" type="tel" name="cantidad" placeholde="Escriba el producto" required />

                </div>
                <div class="col-sm-3 form-group">
                  <label for=""> Tipo de producto</label>
                  <select name="tipo_producto" id="tipoProducto">
                    <option value="0">Seleciona una Opción</option>
                    <?php

                    $sql = "SELECT id_tipo_producto, nombre_tipo_producto FROM tbl_tipo_producto";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      // output data of each row
                      while ($row = $result->fetch_assoc()) {
                        echo "<option value=" . $row['id_tipo_producto'] . ">" . $row['nombre_tipo_producto'] . "</option>";
                      }
                    } else {
                      echo "0 results";
                    }
                    $conn->close();
                    ?>
                  </select>
                  
                </div>
                <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
              
                <input type="button" id="btnAddList" class =" btn btn-primary agregar-table"value= " Agregar a la Lista">
              </div>
            </form>
          </div>
            <div id="producto">
                    <table id="productTable"  data-page-length='10' class=" table table-hover table-condensed table-bordered">
                      <thead>
                        <tr>
                          <td>Nombre Producto</td>
                          <td>Precio</td>
                          <td>Cantidad</td>
                          <td>Tipo Producto</td>
                          <td>Acciones</td>
                        </tr>
                      </thead>
                      <tbody class="tbody">
                      </tbody>
                    </table>
                    <a href="#" id="vaciarTabla" class=" btn btn-primary u-full-width">Vaciar Table 
                    </a>
                    <div>
                    <button type="button" id="registrarInventario" name="ingresarProducto" class="btn">Registrar inventario</button>
                  </div>
            </div>

            <?php
            if (isset($_GET['msg'])) {
              $mensaje = $_GET['msg'];
              print_r($mensaje);
              //echo "<script>alert(".$mensaje.");</script>";  
            }

            ?>
          </section>
        </div>
      </div>
    </div>
  </section>
</div>