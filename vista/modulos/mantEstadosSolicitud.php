<?php
include "./modelo/conexionbd.php";
$id_objeto = 23;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if ($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador") {
  if ($columna["permiso_consulta"] == 1) {
?>
    <div class="content-wrapper">

      <section class="content-header">
        <h1>Mantenimiento<small> estado solicitud</small></h1>
        <ol class="breadcrumb">
          <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
          <li><a href="panel"><i class="fa fa-cogs"></i> panel de control</a></li>
          <li><a><i class="fa fa-users"></i> mantenimiento estado solicitud</a></li>
        </ol>
        <br>
      </section>

      <section class="content">

        <div class="box">
          <div class="box-header with-border">

          </div>

          <div class="box-body">

        <div class="row">
          <div class="col-md-12">

          <div class="panel panel-default">
              <div class="panel-heading">
                <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i></i>Estados de Solicitudes</div>
              </div> <!-- /panel-heading -->
             
                <!--INICIO TABLA-->
                <div class="panel-body">
                  <div class="remove-messages"></div>
                  <div class="div-action pull pull-right" style="padding-bottom:20px;">

                    <button class="btn btn-success btnCrearEstadoSolicitud glyphicon glyphicon-plus-sign"> AGREGAR NUEVO ESTADO</button>
                  </div> <!-- /div-action -->
                  <table id="mantEstadosSolicitudes" class="display responsive nowrap">
                    <thead>
                      <tr style="background-color: #222d32; color: white;">
                        <th>Estado de Solicitud</th>
                        <th>Creado Por</th>
                        <th>Fecha Creación</th>
                        <th>Modificado Por</th>
                        <th>Fecha Modificación</th>
                        <?php if ($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0) :

                        else : ?>
                          <th>Aciones</th>
                        <?php
                        endif;
                        ?>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      include("modelo/conexionbd.php");
                      try {
                        $estado_eliminado = 1;
                        $consult_est_solicitud = "SELECT * FROM tbl_estatus_solicitud
                      WHERE estado_eliminado=$estado_eliminado";
                        $resultado = $conn->query($consult_est_solicitud);
                      } catch (\Exception $e) {
                        $error = $e->getMessage();
                      }
                      $vertbl = array();
                      while ($eventos = $resultado->fetch_assoc()) {
                        $traer = $eventos['estatus'];
                        $evento = array(

                          'id_estatus_solicitud' => $eventos['id_estatus_solicitud'],
                          'estatus' => $eventos['estatus'],
                          'creado_por' => $eventos['creado_por'],
                          'fecha_creacion' => $eventos['fecha_creacion'],
                          'modificado_por' => $eventos['modificado_por'],
                          'fecha_modificacion' => $eventos['fecha_modificacion'],
                        );
                        $vertbl[$traer][] =  $evento;
                      }
                      foreach ($vertbl as $dia => $lista_est_sol) { ?>
                        <?php foreach ($lista_est_sol as $evento) { ?>
                          <tr>
                            <td> <?php echo $evento["estatus"]; ?></td>
                            <td> <?php echo $evento["creado_por"]; ?></td>
                            <td> <?php echo $evento["fecha_creacion"]; ?></td>
                            <td> <?php echo $evento["modificado_por"]; ?></td>
                            <td> <?php echo $evento["fecha_modificacion"]; ?></td>
                            <td>

                              <?php
                              if ($columna['permiso_actualizacion'] == 1) :
                              ?>
                                <button class="btn btn-warning btnEditarEstadoSolicitud glyphicon glyphicon-pencil" data-idestadosolicitud="<?= $evento["id_estatus_solicitud"] ?>" data-estatus="<?= $evento["estatus"] ?>"></button>
                              <?php
                              else :
                              endif;

                              if ($columna['permiso_eliminacion'] == 1) :
                              ?>
                                <button class="btn btn-danger btnEliminarEstadoSolicitud glyphicon glyphicon-remove" data-idestadosolicitud="<?php echo $evento['id_estatus_solicitud'] ?>"></button>
                              <?php
                              else :
                              endif;
                              ?>
                            </td>
                          <?php } ?>
                        <?php } ?>
                          </tr>

                    </tbody>


                  </table>
                  <!--FINAL TABLA-->
                </div> <!-- /panel-body -->
            </div> <!-- /panel -->

          </div><!-- /col-md-12 -->
        </div><!-- /row -->
    </div><!-- body -->
    <!--CIERRA DIV ROW-->


    <!--CIERRA DIV ROW-->



    <div class="modal fade" id="modalEditarEstadoSolicitud" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" id="cerrarACTES">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Actualizar Estado de Solicitud</h4>
          </div>
          <div class="modal-body">
            <form name="formEditarParametro" action="">
              <div class="ingreso-producto form-group">
                <div class="campos" type="hidden">
                  <input autocomplete="off" class="form-control secundary" type="hidden" name="idSolcitud" value="0" disabled>
                </div>
                <label for="estadoSolAct">Estado De Solicitud</label>
                <input id="estadoSolAct" class="form-control modal-roles secundary" type="text" name="estadoSolAct" placeholder="Estado De La Solicitud" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); 
        espacio_Letras(this);" />


                <div class="campos form-group">
                  <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarAct">Cerrar</button>
            <input id="btnEditarBD" type="button" class="btnEditarBD btn btn-success" type="text" value="Actualizar Estado Solicitud">
          </div>
        </div>
      </div>



    </div>

    </div>

    <div class="modal fade" id="modalCrearEstadoSolicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <div class="d-flex justify-content-between">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i aria-hidden="true" id="cerrarES">&times;</i>
              </button>
              <h3 class="modal-title" id="exampleModalLabel">Registrar Estado de Solicitud</h3>
            </div>
          </div>
          <div class="modal-body">
            <form name="" id="formEstadoSolicitudes" onpaste="return false">
              <div class=" form-group">
                <div class="campos form-group" type="hidden">
                  <label for=""> </label>
                  <input class="form-control modal-roles secundary" type="hidden" name="idInventario" value="0" disabled>
                </div>
                <div class="campos form-group">
                  <label for="estadoSolicitud">Estado De Solicitud</label>
                  <input id="estadoSolicitud" name="estadoSolicitud" maxlength="15" class="form-control modal-roles secundary" type="text" placeholder="Estado De Solicitud" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase();" />
                </div>

                <div class="campos form-group">
                  <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                </div>
                <div class="modal-footer">
                  <button id="CerrarCrearES" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button id="registrar_estado" type="submit" name="ingresarProducto" class="btn btn-success">Registrar Estado</button>
                </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /.box-footer-->
    </div>



    </section>
    <!-- /.box-footer-->
    </div>
<?php

  } else {
    echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";
  }
} ?>