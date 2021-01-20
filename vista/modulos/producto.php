<?php
include("./modelo/conexion.php");
//include("./controlador/ctr.producto.php");
?>
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content contenedor-producto">
    <!-- Default box -->
    <div class="box">
      
      <div class="box-header with-border">
        <h3 class="box-title">Ingreso de Productos</h3>
        <div class="container ">
      
          <section class="">
            <form method="POST" id="formProducto">
              <div class="ingreso-producto form-group">
                <div class="campos" type="hidden">
                  <label for=""> </label>
                  <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled>

                </div>

                <div class="campos">
                  <label for="">Nombre del Producto </label>
                  <input id="nombreP" class="form-control secundary" type="text" name="nombreProducto" placeholde="Escriba el producto" required />

                </div>
                <div class="campos form-group">
                  <label for="">Cantidad </label>
                  <input id="cantProducto" class="form-control secundary" type="tel" name="cantidad" placeholde="Escriba el producto" required  />

                </div>
                <div class="campos form-group">
                  <label for="">Precio de Compra </label>
                  <input id="precioProducto" class="form-control secundary" type="tel" name="precio" placeholde="Escriba el producto" required  />

                </div>
                <div class="campos form-group">
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
                </div>
                <input type="submit" name="ingresarProducto" class="btn" value="Ingresar Producto" />
            </form>
            <?php 
              if(isset($_GET['msg'])){
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