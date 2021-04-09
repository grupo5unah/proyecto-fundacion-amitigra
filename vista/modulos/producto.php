<?php require './modelo/conexionbd.php';

$id_objeto = 12;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if ($_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador") {
  if ($columna["permiso_consulta"] == 1) {
?>

    <div class="content-wrapper" oncopy="return false" onpaste="return false">



      <section class="content-header">
        <h1> PRODUCTOS</h1>
        <ol class="breadcrumb ">
          <li class="btn btn-success uppercase fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
          <li class="btn btn-success uppercase fw-bold"><a href="panel"><i class="  fa fa-user-plus"></i> Panel de control</a></li>
          <li class="btn btn-success uppercase fw-bold"><a href="existencia"><i class="fas fa-inventory"></i> Inventario General</a></li>
          <li class="btn btn-success active uppercase fw-bold "><a href="#"></a><i class="fab fa-product-hunt"></i> Movimientos</a></li>
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
                    <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i>Movimientos</div>
                  </div> <!-- /panel-heading -->


                  <div class="panel-body" oncopy="return false" onpaste="return false">

                    <div class="container ">
                      <div class="div-action pull pull-right" style="padding-bottom:20px;">

                        <?php if ($columna["permiso_insercion"] == 0) :

                        else : ?>

                          <button class="btn btn-success button1 text-uppercase" id="btncrearMovimiento"> <i class="glyphicon glyphicon-plus-sign"></i> movimientos </button>

                        <?php
                        endif;
                        ?>

                      </div>
                      <table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="movimientos">
                        <thead style=" background-color: #222d32; color: white;">
                          <tr>
                            <th>Nombre Producto</th>
                            <th>movimiento</th>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>Fecha movimiento</th>
                            <?php if ($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0) :

                            else : ?>
                              <th>Acciones</th>
                            <?php
                            endif;
                            ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          try {

                            $sql = "SELECT  m.id_movimiento, p.nombre_producto, t.movimiento, m.cantidad, m.descripcion, m.fecha_movimiento FROM tbl_movimientos m INNER JOIN tbl_producto p on p.id_producto = m.producto_id INNER JOIN tbl_tipo_movimiento t on t.id_tipo_movimiento= m.tipo_movimiento_id where p.id_producto = m.producto_id and m.tipo_movimiento_id=t.id_tipo_movimiento ";

                            $resultado = $conn->query($sql);
                          } catch (\Exception $e) {
                            echo $e->getMessage();
                          }

                          $vertbl = array();
                          while ($eventos = $resultado->fetch_assoc()) {

                            $traer = $eventos['nombre_producto'];
                            $evento = array(
                              'nombreM' => $eventos['nombre_producto'],
                              'movimientoM' => $eventos['movimiento'],
                              'descripcionM' => $eventos['descripcion'],
                              'cantidadM' => $eventos['cantidad'],
                              'fecha_movimiento' => $eventos['fecha_movimiento'],
                              'id_m' => $eventos['id_movimiento']
                            );
                            $vertbl[$traer][] =  $evento;
                          }
                          foreach ($vertbl as $dia => $lista_articulo) { ?>


                            <?php foreach ($lista_articulo as $evento) { ?>
                              <?php  //echo $evento['nombre_arti']
                              ?>
                              <tr>
                                <td> <?php echo $evento['nombreM']; ?></td>
                                <td> <?php echo $evento['movimientoM']; ?></td>
                                <td> <?php echo $evento['descripcionM']; ?></td>
                                <td> <?php echo $evento['cantidadM']; ?></td>
                                <td> <?php echo $evento['fecha_movimiento']; ?></td>
                                <td>

                                  <?php if ($columna["permiso_actualizacion"] == 1) : ?>
                                    <button class="btn btn-warning btnEditarProducto glyphicon glyphicon-pencil" data-cantProducto="<?= $evento['cantidadM'] ?>"></button>
                                  <?php
                                  else :
                                  endif;

                                  if ($columna["permiso_eliminacion"] == 1) :
                                  ?>
                                    <button class="btn btn-danger btnDeleteP glyphicon glyphicon-remove" data-idP="<?php //echo $evento[''] ?>"></button>
                                  <?php
                                  else :
                                  endif;
                                  ?>
                                </td>
                              <?php  } ?>
                            <?php  } ?>
                              </tr>
                        </tbody>


                      </table>


                      <?php
                      if (isset($_GET['msg'])) {
                        $mensaje = $_GET['msg'];
                        print_r($mensaje);
                        //echo "<script>alert(".$mensaje.");</script>";  
                      }

                      ?>



                    </div> <!-- /panel-body -->
                  </div> <!-- /panel -->





                </div>
                <!-- /.box-body -->
                <!-- /.box-footer-->
                <!-- modal movimientos -->
                <div class="modal fade" id="modalCrearMovimiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog">
                    <div class="modal-content" style="width: 1000px;">
                      <div class="modal-header">
                        <div class="d-flex justify-content-between">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true">&times;</i>
                          </button>
                          <h3 class="modal-title" id="exampleModalLabel">Registrar Movimiento</h3>
                        </div>
                      </div>
                      <div class="modal-body">

                        <form method="POST" id="formProducto" role="form" class="validarFORM" style="text-align:center;">
                          <div class="row d-flex">
                          <?php

                      $sql = "SELECT id_tipo_movimiento, movimiento FROM tbl_tipo_movimiento where movimiento = 'ENTRADA' OR movimiento= 'SALIDA'";
                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                          $id = ($row['id_tipo_movimiento']);
                          $movimiento = ($row['movimiento']);
                           ?>
                          <input type="hidden" name="" id="entrada" value="<?php echo ($id); ?>">
                          <div class="form-check form-check-inline col-sm-2 form-group ">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="<?php echo ($id); ?>" value="<?php echo ($movimiento); ?>">
                              <label class="form-check-label" for="inlineRadio1"> <?php echo ($movimiento); ?></label>
                          </div>
                          <!-- <div class="form-check form-check-inline col-sm-2 form-group">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="<?php echo ($id); ?>" value="<?php echo ($movimiento); ?>">
                              <label class="form-check-label" for="inlineRadio2"></label>
                            </div>
                          </div> -->

                      <?php  }
                      } else {
                        echo "0 results";
                      }

                      
                      ?>
                            
                            
                          <div class="row d-flex  justify-content-around">

                            <div class="col-sm-3 form-group justify-content-between">
                              <label for=""> PRODUCTO</label>
                              <select name="tipoProducto" id="movimientoProducto" class=" input-group">
                                <option value="0">Seleciona una opción</option>
                                <?php

                                $sql = "SELECT id_producto, nombre_producto FROM tbl_producto";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                  // output data of each row
                                  while ($row = $result->fetch_assoc()) {
                                    echo "<option value=" . $row['id_producto'] . ">" . $row['nombre_producto'] . "</option>";
                                  }
                                } else {
                                  echo "0 results";
                                }
                                //$conn->close();
                                ?>

                              </select>
                            </div>
                            <div class="col-sm-3 form-group ">
                              <label>DESCRIPCION </label>
                              <input id="descripcion" class="form-control   secundary text-uppercase" type="text" name="descripcion" placeholder=" descripcion" required onkeypress="return soloLetra(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />
                            </div>
                            <div class="col-sm-2 m-auto form-group ">
                              <label for="">Cantidad</label>
                              <div class="input-group">

                                <input id="precioProducto" class="form-control  secundary " type="number" name="precioProducto" placeholder="1" onkeypress="return soloNumero(event)" autocomplete="off" min="1" required />

                              </div>
                            </div>
                            <div class="col-sm-2 form-group justify-content-between">
                              <label for="">Localidad</label>
                              <select name="tipoProducto" id="movimientoLocalidad" class=" input-group">
                                <option value="0">Seleciona...</option>
                                <?php

                                $sql = "SELECT id_localidad, nombre_localidad FROM tbl_localidad";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                  // output data of each row
                                  while ($row = $result->fetch_assoc()) {
                                    echo "<option value=" . $row['id_localidad'] . ">" . $row['nombre_localidad'] . "</option>";
                                  }
                                } else {
                                  echo "0 results";
                                }
                                $conn->close();
                                ?>
                              </select>

                            </div>
                            <div class="col-sm-1 form-group justify-content-between">
                            <input id="btnAddList" style=" width:25px; height:22px; margin-left:15px;  padding:0;" type="button" class=" input-group btn btn-success agregar-table aling-item glyphicon glyphicon-plus-sign" value="+">
                            <input type="hidden" id="btnProductUpdate" class=" glyphicon glyphicon-saved btn btn-primary agregar-table">
                            </div>
                          </div>

                      </div>

                      <!-- select id_tipo_movimiento FROM tbl_tipo_movimiento where movimiento = "ENTRADA"; -->
                      <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                     
                    
                      </form>
                      <div id="producto">
                        <table id="productTable" data-page-length='10' class=" table table-hover table-condensed table-bordered">
                          <thead>
                            <tr>
                              <td>#</td>
                              <td>Nombre Producto</td>
                              <td>Movimiento</td>
                              <td>cantidad</td>
                              <td>Descripcion</td>
                              <td>Localidad</td>

                              <?php if ($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0) :

                              else : ?>
                                <td>Acciones</td>
                              <?php
                              endif;
                              ?>
                            </tr>
                          </thead>
                          <tbody id="row1" class="tbody">
                          </tbody>
                        </table>


                      </div>

                      <?php
                      if (isset($_GET['msg'])) {
                        $mensaje = $_GET['msg'];
                        print_r($mensaje);
                        //echo "<script>alert(".$mensaje.");</script>";  
                      }

                      ?>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-Danger" id="cerrarM">Close</button>
                        <button type="button" id="registrarMovimiento" class=" btn btn-primary">Registrar </button>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>
            <!-- /.box -->
      </section>

      <!-- /.content -->
    </div>

<?php

  } else {
    echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";
  }
} ?>
<!-- tabla de productos -->
<!-- <div id="producto">
                        <table id="productTable" data-page-length='10' class=" table table-hover table-condensed table-bordered">
                          <thead>
                            <tr>
                              <td>Nombre Producto</td>
                              <td>Precio</td>
                              <td>Cantidad</td>
                              <td>Descripcion</td>
                              <td>Tipo Producto</td>
                              <td>Precio Alquiler</td>
                              <?php if ($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0) :

                              else : ?>
                              <td>Acciones</td>
                              <?php
                              endif;
                              ?>
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

<!-- //// infomacion de entrada  -->
<!-- <div id="contenedorProducto">
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
                            <input type="hidden" id="btnProductUpdate" class=" btn btn-primary " value="Finalizar Edicion">
                            <input type="button" id="actulizar" class=" btn btn-primary " value=" ACTUALIZAR" >
                            <input type="button" id="btnCancelar" class=" btn btn-primary " value="CANCELAR">
                       
                          </div>
                        </form>

                      </div>  -->