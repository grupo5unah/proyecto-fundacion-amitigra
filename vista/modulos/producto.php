<?php require './modelo/conexionbd.php'; ?>

<div class="content-wrapper" oncopy="return false" onpaste="return false">



  <section class="content-header">
    <h1> PRODUCTOS</h1>
    <ol class="breadcrumb ">
      <li class="btn btn-success uppercase fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="btn btn-success uppercase fw-bold"><a href="panel"><i class="  fa fa-user-plus"></i> Panel de control</a></li>
      <li class="btn btn-success uppercase fw-bold"><a href="existencias"><i class="fas fa-inventory"></i> Inventario General</a></li>
      <li class="btn btn-success active uppercase fw-bold "><a href="#"></a><i class="fab fa-product-hunt"></i> Producto</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">

      </div>
      <div class="box-body">
        <!--LLamar al formulario aqui-->
        <div class="row">
          <div class="col-md-12">

            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Producto</div>
              </div> <!-- /panel-heading -->
              <div class="panel-body">
                <div class="panel panel-default">

                  <div class="box-header with-border" oncopy="return false" onpaste="return false">

                    <div class="container ">
                      <div id="contenedorProducto">
                        <form method="POST" id="formProducto" role="form" class="validarFORM" style="text-align:center;">
                          <div class="row d-flex  justify-content-around" >

                            <div class="col-sm-2 form-group " id="groupP">
                              <label for="">NOMBRE DEL PRODUCTO </label>
                              <input id="nombreP" class="form-control   secundary text-uppercase" type="text"  name="nombreP" 
                              min="0"
                              maxlength="10" minlength="3"
                              placeholder="Escriba el producto" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />
                            </div>

                            <div class="col-sm-2 m-auto form-group ">
                              <label for="">PRECIO </label>
                              <input id="precioProducto" class="form-control  secundary " type="number" name="precioProducto" placeholder="Lps:1.00" onkeypress="return soloNumeros(event)" autocomplete="off" min="0" required/>

                            </div>

                            <div class="col-sm-2 form-group ">
                              <label for="">CANTIDAD </label>
                              <input id="cantProducto" class="form-control   secundary" type="number" name="cantProducto" placeholder="0" required onkeypress="return soloNumeros(event)" autocomplete="off" minlength="-" />

                            </div>
                            <div class="col-sm-2 form-group ">
                              <label>DESCRIPCION </label>
                              <input id="descripcion" class="form-control   secundary text-uppercase" type="text" name="descripcion" placeholder="Escriba la descripcion(lbs,uds)" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />
                            </div>
                            <div class="col-sm-2 form-group justify-content-between">
                              <label for=""> TIPO PRODUCTO</label>
                              <select  name="tipoProducto" id="tipoProducto" class=" input-group">
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

                            <div class="col-sm-2 m-auto form-group ">
                              <label for="">RENTA</label>
                              <input id="precioAlquiler" class="form-control  secundary " type="number" name="precio" placeholder="Lps:1.00" onkeypress="return soloNumeros(event)" autocomplete="off" min="0" disabled required />
                            </div>
                            <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                            
                          </div>

                          <div class="row d-flex ">

                            <input type="button" id="btnAddList" class=" btn btn-primary agregar-table" value=" Agregar a la Lista">
                            <input type="hidden" id="btnProductUpdate" class=" btn btn-primary agregar-table" value="Finalizar Edicion">
                            <input type="button" id="actulizar" class=" btn btn-primary agregar-table" value=" ACTUALIZAR" >
                            <input type="button" id="btnCancelar" class=" btn btn-primary " value="CANCELAR">
                       
                          </div>
                        </form>

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
                        
                        <div class=" row d-flex text-center">
                          <a href="#" id="vaciarTabla" class=" btn btn-primary u-full-width">Vaciar Table
                          </a>
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



                    </div> <!-- /panel-body -->
                  </div> <!-- /panel -->
                </div> <!-- /col-md-12 -->

              </div> <!-- /row -->


            </div>
            <!-- /.box-body -->
            <!-- /.box-footer-->
          </div>
          <!-- /.box -->
  </section>

  <!-- /.content -->
</div>