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
      <input type="hidden" name="" id="id_usuario" value="<?= $_SESSION['id'] ?>">
      <?php

      $sql = "SELECT id_objeto FROM `tbl_objeto` WHERE objeto LIKE '%movimiento%'; ";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
          $id = ($row['id_objeto']);
         
      ?>

       <input type="hidden" name="" id="id_objeto" value="<?= $id ?>">    


      <?php  }
      } else {
        echo "0 results";
      }


      ?>


      <section class="content-header">
        <h1> Movimientos de inventario</h1>
        <ol class="breadcrumb ">
          <li class="  fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
         
          <li class="  fw-bold"><a href="existencia"><i class="fas fa-inventory"></i> Inventario General</a></li>
          <li class=" active  fw-bold "><a href="#"></a><i class="fab fa-product-hunt"></i> Movimientos</a></li>
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
                    <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i>Listado de Movimientos</div>
                  </div> <!-- /panel-heading -->


                  <div class="panel-body" oncopy="return false" onpaste="return false">

                    <div class="container ">
                      <div class="div-action pull pull-right" style="padding-bottom:20px;">

                        <?php if ($columna["permiso_insercion"] == 0) :

                        else : ?>

                          <button class="btn btn-success button1 text-uppercase" id="btncrearMovimiento"> <i class="glyphicon glyphicon-plus-sign"></i> Agregar movimiento </button>

                        <?php
                        endif;
                        ?>

                      </div>
                      <table data-page-length='10' class=" display table table-hover table-condensed table-bordered wrapper" id="movimientos">
                        <thead style=" background-color: #222d32; color: white;">
                          <tr>
                            <th>Producto</th>
                            <th>Movimiento</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Fecha movimiento</th>
                            <?php if ($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0) :

                            else : ?>
                              <!-- <th>Acciones</th> -->
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
                                <!-- <td> -->

                                <?php if ($columna["permiso_actualizacion"] == 1) : ?>
                                  <!-- <button class="btn btn-warning btnEditarProducto glyphicon glyphicon-pencil" data-idProduct="<?= $evento[''] ?>" data-nomProducto="<?= $evento[''] ?>" data-precioP="<?= $evento[''] ?>" data-cantProducto="<?= $evento['cantidadP'] ?>" data-desc="<?= $evento[''] ?>" data-TP="<?= $evento['tipo_producto'] ?>" data-precioAl="<?= $evento[''] ?>"></button> -->
                                <?php
                                else :
                                endif;

                                if ($columna["permiso_eliminacion"] == 1) :
                                ?>
                                  <!-- <button class="btn btn-danger btnDeleteP glyphicon glyphicon-remove" data-idP="<?php echo $evento[''] ?>"></button> -->
                                <?php
                                else :
                                endif;
                                ?>
                                <!-- </td> -->
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
                <div class="modal fade con" id="modalCrearMovimiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog mo">
                    <div class="modal-content ">
                      <div class="modal-header">
                        <div class="d-flex justify-content-between ">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true">&times;</i>
                          </button>
                          <h3 class="modal-title" id="exampleModalLabel">Registrar Movimiento</h3>
                        </div>
                      </div>
                      <div class="modal-body ">

                        <form method="POST" id="formM" role="form" class="validarFORM" style="text-align:center;">

                          <?php

                          $sql = "SELECT id_tipo_movimiento, movimiento FROM tbl_tipo_movimiento where movimiento = 'ENTRADA' OR movimiento= 'SALIDA'";
                          $result = $conn->query($sql);

                          if ($result->num_rows > 0) {
                            // output data of each row
                            while ($row = $result->fetch_assoc()) {
                              $id = ($row['id_tipo_movimiento']);
                              $movimiento = ($row['movimiento']);
                          ?>

                              <div class="form-check form-check-inline col-sm-6 form-group movimiento">
                                <input data-movi="<?php echo ($movimiento); ?>" data-mo="<?php echo ($movimiento); ?>" class="form-check " type="radio" name="entrada" id="exampleRadios1" value="<?php echo ($id); ?>">
                                <label class="form-check-label" for="exampleRadios1">
                                  <?php echo ($movimiento); ?>
                                </label>
                              </div>


                          <?php  }
                          } else {
                            echo "0 results";
                          }


                          ?>

                          <div class="form-group">
                            <label for=""> PRODUCTO</label>
                            <div class="input-group">
                              <select name="tipoProducto" id="p" class="js-example-basic-multiple js-states input-group movimientoProducto " style="width: 364pxs;">
                                <option value="">Selecciona una opción...</option>

                                <?php

                                $sql = "SELECT p.id_producto, p.nombre_producto, i.id_inventario, i.stock, i.localidad_id from tbl_producto p LEFT JOIN tbl_inventario i on p.id_producto = i.producto_id";
                                $result = $conn->query($sql);


                                if ($result->num_rows > 0) {
                                  // output data of each row
                                  while ($row = $result->fetch_assoc()) {
                                    echo "<option  data-id_inventario=" . $row['id_inventario'] . " data-localidad=" . $row['localidad_id'] . " data-stock=" . $row['stock'] . " value=" . $row['id_producto'] . ">" . $row['nombre_producto'] . "</option>";
                                  }
                                } else {
                                  echo "0 results";
                                }
                                //$conn->close();
                                ?>

                              </select>
                            </div>
                          </div>
                          <div class=" form-group ">
                            <label for="">Localidad</label>
                            <div class=" input-group ">
                              <select name="tipoProducto" id="movimientoLocalidad" style="width: 364pxs;">
                                <option value="0">Seleciona una opcion</option>
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


                          </div>
                          <div class=" form-group ">
                            <label>DESCRIPCION </label>
                            <input id="descripcion" class="form-control   secundary text-uppercase text-center" type="text" name="descripcion" placeholder=" descripcion" required onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />
                          </div>
                          <div class="form-group ">
                            <label for="">Cantidad</label>
                            <div class="">
                              <input id="cantidad" class="form-control  secundary text-center" type="number" name="precioProducto" placeholder="1" onkeypress="return soloNumero(event)" autocomplete="off" min="1" required />
                            </div>
                          </div>


                          <!-- select id_tipo_movimiento FROM tbl_tipo_movimiento where movimiento = "ENTRADA"; -->
                          <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="cerrarM">Cancelar</button>
                            <button type="submit" id="registrar" class=" btn btn-success">Registrar </button>
                          </div>

                        </form>


                        <?php
                        if (isset($_GET['msg'])) {
                          $mensaje = $_GET['msg'];
                          print_r($mensaje);
                          //echo "<script>alert(".$mensaje.");</script>";  
                        }

                        ?>


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