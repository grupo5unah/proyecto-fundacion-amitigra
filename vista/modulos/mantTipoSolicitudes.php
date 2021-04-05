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

<?php

include "./modelo/conexionbd.php";

$id_objeto = 36;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] == 1){
?>

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
              <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i></i> Listado de tipos de Solicitudes</div>
            </div> <!-- /panel-heading -->
            <table class="table table-bordered text-center">
              <!--INICIO TABLA-->
              <div class="box-body">
                <div class="remove-messages"></div>
                <div class="div-action pull pull-right" style="padding-bottom:20px;">
                  <!-- <button  class="btn btn-default button1 btnCrearRol" id="addProductModalBtn"> <i class="glyphicon glyphi
	</button> -->
                  <button class="btn btn-default btnCreartipoSolicitud glyphicon glyphicon-plus-sign">Agregar Tipo de Solicitud</button>
                </div> <!-- /div-action -->
                <table id="tablaTipoSolicitudes" class="display responsive nowrap">
                  <thead>
                    <tr>
                      <th>Tipo de Solicitud</th>
                      <th>Precio</th>
                      <th>Creado Por</th>
                      <th>Fecha Creación</th>
                      <th>Modificado Por</th>
                      <th>Fecha Modificación</th>
                      <?php if($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0):
											
                      else:?>
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
                      $estado_eliminado=1;
                      $consult_tipo_solicitud = "SELECT * FROM tbl_tipo_solicitud 
                      WHERE estado_eliminado=$estado_eliminado";
                      $resultado = $conn->query($consult_tipo_solicitud);
                    } catch (\Exception $e) {
                      $error = $e->getMessage();
                    }
                    $vertbl = array();
                    while ($eventos = $resultado->fetch_assoc()) {
                      $traer = $eventos['tipo'];
                      $evento = array(

                        'id_tipo_solicitud' => $eventos['id_tipo_solicitud'],
                        'tipo' => $eventos['tipo'],
                        'precio_solicitud' => $eventos['precio_solicitud'],
                        'creado_por' => $eventos['creado_por'],
                        'fecha_creacion' => $eventos['fecha_creacion'],
                        'modificado_por' => $eventos['modificado_por'],
                        'fecha_modificacion' => $eventos['fecha_modificacion'],
                      );
                      $vertbl[$traer][] =  $evento;
                    }
                    foreach ($vertbl as $dia => $lista_tipo_sol) { ?>
                      <?php foreach ($lista_tipo_sol as $evento) { ?>
                        <tr>
                          <td> <?php echo $evento["tipo"]; ?></td>
                          <td> <?php echo $evento["precio_solicitud"]; ?></td>
                          <td> <?php echo $evento["creado_por"]; ?></td>
                          <td> <?php echo $evento["fecha_creacion"]; ?></td>
                          <td> <?php echo $evento["modificado_por"]; ?></td>
                          <td> <?php echo $evento["fecha_modificacion"]; ?></td>
                          <td>
                            <button class="btn btn-warning btnEditarTipoSolicitud glyphicon glyphicon-pencil" data-idtiposolicitud="<?= $evento["id_tipo_solicitud"] ?>" data-tipo="<?= $evento["tipo"] ?>" data-precio_solicitud="<?= $evento["precio_solicitud"] ?>"></button>
                            <button class="btn btn-danger btnEliminarTipoSolicitud glyphicon glyphicon-remove" data-idtiposolicitud="<?php echo $evento['id_tipo_solicitud'] ?>">
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



      <div class="modal fade" id="modalEditarTipoSolicitud" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Actualizar Tipo de Solicitud</h4>
            </div>
            <div class="modal-body">
              <form name="formEditarParametro" action="">
                <div class="ingreso-producto form-group">
                  <div class="campos" type="hidden">
                    <input autocomplete="off" class="form-control secundary" type="hidden" name="idSolcitud" value="0" disabled>
                  </div>
                  <label for="">Tipo de solicitud</label>
                  <input id="tiposol" style="width:365px" class="form-control modal-roles secundary" type="text" name="tiposol" placeholder="Precio de la solicitud" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); 
        espacio_Letras(this);" />
                  

                <div class="campos form-group">
                  <label for="">Precio</label>
                  <input id="precio" style="width:365px" class="form-control modal-roles secundary" type="text" name="precio" placeholder="Precio de la solicitud" onkeypress="return soloNumeros(event)"/>
                </div>
                <div class="campos form-group">
                  <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                </div>

              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <input id="btnEditarBD" type="button" class="btnEditarBD btn btn-primary" type="text" value="Actualizar Tipo Solicitud">
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
                <h3 class="modal-title" id="exampleModalLabel">Registrar Tipo Solicitud</h3>
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
                    <input id="tipoSolicitud" name="tipoSolicitud" maxlength="30" minlength="30" style="width:335px" class="form-control modal-roles secundary" type="text" placeholder="Tipo De Solicitud" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); 
									espacio_Letras(this);" />
                  </div>
                  <div class="campos form-group">
                    <input id="preciosolicitud" name="preciosolicitud" maxlength="4" onkeypress="return soloNumeros(event)"style="width:335px" class="form-control modal-roles secundary" type="text"  placeholder="Precio De Solicitud" />
                  </div>

                  <div class="campos form-group">
                    <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="" type="submit" name="ingresarProducto" class="btn btn-primary">Registrar Tipo Solicitud</button>
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

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>