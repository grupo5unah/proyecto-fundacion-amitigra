<script>
  function soloNumeros(e) {
    var key = window.event ? e.which : e.keyCode
    return ((key >= 48 && key <= 57) || (key == 8))
    e.preventDefault();

  }

  function soloNumeros(e) {
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
      e.preventDefault();
    }
  }


  function soloLetras(e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toLowerCase(),
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
      especiales = [8, 37, 39, 46],
      tecla_especial = false;
    for (var i in especiales) {
      if (key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }
    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
    }
  }
  SinEspacio = function(input) {
    input.value = input.value.replace(' ', '');
  }

  //Permitir solo un ESPACIO
  espacio_Letras = function(input) {
    input.value = input.value.replace('  ', ' ');
  }


  function validaemail(valor) {
    re = /^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/
    if (!re.exec(valor)) {
      $res['msj'] = "Email no valido";
    }

  }

  function limpia() {
    var val = document.getElementById("telefono").value;
    var tam = val.length;
    for (i = 0; i < tam; i++) {
      if (isNaN(val[i]))
        document.getElementById("telefono").value = '';
    }
  }

  function mostrarPassword() {
    var cambio = document.getElementById("Contraseña");
    if (cambio.type == "password") {
      cambio.type = "text";
      $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    } else {
      cambio.type = "password";
      $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
  }

  function mostrarPassword2() {
    var cambio = document.getElementById("ConfirmarContraseña");
    if (cambio.type == "password") {
      cambio.type = "text";
      $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    } else {
      cambio.type = "password";
      $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
  }

  function mostrarPasswordreset() {
    var cambio = document.getElementById("Contraseña_reset");
    if (cambio.type == "password") {
      cambio.type = "text";
      $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    } else {
      cambio.type = "password";
      $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
  }

  function mostrarPassword2reset() {
    var cambio = document.getElementById("ConfirmarContraseña_reset");
    if (cambio.type == "password") {
      cambio.type = "text";
      $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    } else {
      cambio.type = "password";
      $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
  }
</script>
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <div class="">

      <!-- INICIO DE LA INFORMACION DEL USUARIO-->

      <div class="box-body">
      </div>

    </div>

    <!--INICIO TABLA -->
    <!--ABRE DIV ROW-->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-body pad table-responsive">
            <div class="panel-heading">
              <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i></i>Estados de Solicitudes</div>
            </div> <!-- /panel-heading -->
            <table class="table table-bordered text-center">
              <!--INICIO TABLA-->
              <div class="box-body">
                <div class="remove-messages"></div>
                <div class="div-action pull pull-right" style="padding-bottom:20px;">
                  <!-- <button  class="btn btn-default button1 btnCrearRol" id="addProductModalBtn"> <i class="glyphicon glyphi
	</button> -->
                  <button class="btn btn-default btnCreartipoSolicitud glyphicon glyphicon-plus-sign">Agregar Estado</button>
                </div> <!-- /div-action -->
                <table id="manageProductTable" class="display responsive nowrap">
                  <thead>
                    <tr>
                      <th>Estado de Solicitud</th>
                      <th>Creado Por</th>
                      <th>Fecha Creación</th>
                      <th>Modificado Por</th>
                      <th>Fecha Modificación</th>
                      <th>Aciones</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    include("modelo/conexionbd.php");
                    try {
                      $estado_eliminado=1;
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
                            <button class="btn btn-warning btnEditarEstadoSolicitud glyphicon glyphicon-pencil" data-idestadosolicitud="<?= $evento["id_estatus_solicitud"] ?>" data-estatus="<?= $evento["estatus"] ?>"></button>
                            <button class="btn btn-danger btnEliminarEstadoSolicitud glyphicon glyphicon-remove" data-idestadosolicitud="<?php echo $evento['id_estatus_solicitud'] ?>"></button>
                          </td>
                        <?php } ?>
                      <?php } ?>
                        </tr>

                  </tbody>


                </table>
              </div>
              <!--FINAL TABLA-->
            </table>
          </div>

        </div>
      </div>

      <!--CIERRA DIV ROW-->



      <div class="modal fade" id="modalEditarEstadoSolicitud" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Actualizar Estado de Solicitud</h4>
            </div>
            <div class="modal-body">
              <form name="formEditarParametro" action="">
                <div class="ingreso-producto form-group">
                  <div class="campos" type="hidden">
                    <input autocomplete="off" class="form-control secundary" type="hidden" name="idSolcitud" value="0" disabled>
                  </div>
                  <label for="">Estado de solicitud</label>
                  <input id="estadoSolAct"  class="form-control modal-roles secundary" type="text" name="estadoSolAct" placeholder="Estado de la solicitud" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); 
        espacio_Letras(this);" />
                
                
                <div class="campos form-group">
                  <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                </div>

              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <input id="btnEditarBD" type="button" class="btnEditarBD btn btn-primary" type="text" value="Actualizar Estado Solicitud">
            </div>
          </div>
        </div>



      </div>

      </div>

      <div class="modal fade" id="modalCreartipoSolicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <div class="d-flex justify-content-between">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i aria-hidden="true">&times;</i>
                </button>
                <h3 class="modal-title" id="exampleModalLabel">Registrar Estado de Solicitud</h3>
              </div>
            </div>
            <div class="modal-body">
              <form name="" id="formTipoSolicitudes" onpaste="return false">
                <div class=" form-group">
                  <div class="campos form-group" type="hidden">
                    <label for=""> </label>
                    <input class="form-control modal-roles secundary" type="hidden" name="idInventario" value="0" disabled>
                  </div>
                  <div class="campos form-group">
                    <input id="estadoSolicitud" name="estadoSolicitud" maxlength="15" class="form-control modal-roles secundary" type="text" placeholder="Estado De Solicitud" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); 
									espacio_Letras(this);" />
                  </div>

                  <div class="campos form-group">
                    <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="" type="submit" name="ingresarProducto" class="btn btn-primary">Registrar Estado</button>
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