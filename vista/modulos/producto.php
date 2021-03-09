<?php include("./modelo/conexionbd.php"); ?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script> -->
<div class="content-wrapper">
  <section class="content-header">
  	<h1>
	Mantenimiento de Localidades y Tipo Producto
  	</h1>      
 	<ol class="breadcrumb ">
        <li class="btn btn-success uppercase fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="btn btn-success uppercase fw-bold" ><a href="panel"><i class="  fa fa-user-plus"></i> Panel de control</a></li>
        <li class="btn btn-success uppercase fw-bold"><a href="existencias"><i class="fas fa-inventory"></i> Inventario General</a></li>
		<li class="btn btn-success active uppercase fw-bold "><a href="#"></a><i class="fa fa-users"></i> Producto</a></li>
      </ol>
    </section>
  <!-- Main content -->
  <section class="content ">
    <!-- Default box -->
    <div class="box">

      <div class="box-header with-border" oncopy="return false" onpaste="return false">
        <h3 class="box-title">Ingreso de Productos</h3>
        <div class="container ">
          <div id="contenedorProducto">
            <form method="POST" id="formProducto" role="form" class="validarFORM" style="text-align:center;">
              <div class="ingreso-producto form-group  row d-flex c ">

                <div class="col-sm-3 form-group">
                  <label for="">Nombre del Producto </label>
                  <input  id="nombreP" class="form-control   secundary text-uppercase" type="text" name="nombreProducto" placeholder="Escriba el producto" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />
                </div>
                
                <div class="col-sm-2 m-auto form-group">
                  <label for="">Precio de Compra </label>
                  <input  id="precioProducto" class="form-control  secundary " type="number" name="precio" placeholder="Lps:1.00"  onkeypress="return soloNumeros(event)" autocomplete="off" min="0" require/>

                </div>

                <div class="col-sm-2 form-group">
                  <label for="">Cantidad </label>
                  <input  id="cantProducto" class="form-control   secundary" type="number" name="cantidad" placeholder="0" required onkeypress="return soloNumeros(event)" autocomplete="off" minlength="-"/>

                </div>
              </div>
                
              <div class="row d-flex ">
                <div class="col-sm-3 form-group">
                    <label >Descripcion del Producto </label>
                    <input   id="descripcion" class="form-control   secundary text-uppercase" type="text" name="nombreProducto" placeholder="Escriba la descripcion(lbs,uds)" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />
                  </div>
              
                
                <div class="col-sm-4 form-group " >
                  <label for=""> Tipo de producto</label>
                  <select style="width:300px;" name="tipo_producto" id="tipoProducto" class=" input-group">
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
                <div class="col-sm-2 m-auto form-group">
                  <label for="">Precio de Alquiler </label>
                  <input id="precioAlquiler" class="form-control  secundary " type="number" name="precio" placeholder="Lps:1.00" disabled onkeypress="return soloNumeros(event)" autocomplete="off" min="0" require/>
                </div>
                <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">

                
              </div>
            </form>
            <input type="button" id="btnAddList" class=" btn btn-primary agregar-table" value=" Agregar a la Lista"  >
                <input type="hidden" id="btnProductUpdate" class=" btn btn-primary agregar-table" value="Finalizar Edicion">
          </div>
          <div id="producto">
            <table id="productTable" data-page-length='10' class=" table table-hover table-condensed table-bordered">
              <thead>
                <tr>
                  <td>Nombre Producto</td>
                  <td>Precio</td>
                  <td>Cantidad</td>
                  <td>Descripcion</td>
                  <td>Tipo Producto</td>
                  <td>Precio Alquiler</td>
                  <td>Acciones</td>
                </tr>
              </thead>
              <tbody id="row1" class="tbody">
              </tbody>
            </table>
            <a href="#" id="vaciarTabla" class=" btn btn-primary u-full-width">Vaciar Table
            </a>
            <div>
              <button type="button" id="registrarInventario" name="ingresarProducto" class=" btn btn-success">Registrar inventario</button>
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