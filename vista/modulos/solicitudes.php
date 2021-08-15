<script>
  function soloNumeros(e) {
    var key = window.event ? e.which : e.keyCode
    return ((key >= 48 && key <= 57) || (key == 8))
    e.preventDefault();

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

$id_objeto = 3;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if ($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador") {
  if ($columna["permiso_consulta"] == 1) {
?>

    <div class="content-wrapper">

      <section class="content-header">
        <h1>Mantenimiento<small> solicitudes</small></h1>
        <ol class="breadcrumb">
          <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
          <li><a><i class="fa fa-users"></i> mantenimiento solicitudes</a></li>
        </ol>
        <br>
      </section>

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
                  <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i></i> Listado de Solicitudes</div>
                </div> <!-- /panel-heading -->
                <table class="table table-bordered text-center">
                  <!--INICIO TABLA-->
                  <div class="box-body">
                    <div class="remove-messages"></div>
                    <div class="div-action pull pull-right" style="padding-bottom:20px;">
                      <!-- <button  class="btn btn-default button1 btnCrearRol" id="addProductModalBtn"> <i class="glyphicon glyphi
	</button> -->
                      <button class="btn btn-default btnCrearSolicitud glyphicon glyphicon-plus-sign">Agregar Solicitud</button>
                    </div> <!-- /div-action -->
                    <table id="tablaSolicitudes" class="display responsive nowrap">
                      <thead>
                        <tr style="background-color: #222d32; color: white;">
                          
                          <th>Nombre</th>
                          <th>Identidad</th>
                          <th>Telefono</th>
                          <th>Tipo de Solicitud</th>
                          <th>Total</th>
                          <th>Estado</th>
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

                          $consult_solicitud = "SELECT id_solicitud,recibo,cli.id_cliente,cli.nombre_completo,cli.identidad,
                          cli.telefono,tiponac.id_tipo_nacionalidad,tips.id_tipo_solicitud,sol.fecha_creacion,
                      est.id_estatus_solicitud,tipo,tips.precio_solicitud,total,est.estatus
                      FROM tbl_tipo_nacionalidad tiponac INNER JOIN tbl_clientes cli
                      ON tiponac.id_tipo_nacionalidad=cli.tipo_nacionalidad INNER JOIN tbl_solicitudes sol
                      ON sol.cliente_id=cli.id_cliente INNER JOIN tbl_tipo_solicitud tips
                      ON sol.tipo_solicitud=tips.id_tipo_solicitud INNER JOIN tbl_estatus_solicitud est
                      ON sol.estatus_solicitud=est.id_estatus_solicitud  where sol.estado_eliminado=1 
                      
                      ";
                          $resultado = $conn->query($consult_solicitud);
                        } catch (\Exception $e) {
                          $error = $e->getMessage();
                        }
                        $vertbl = array();
                        while ($eventos = $resultado->fetch_assoc()) {
                          $traer = $eventos['nombre_completo'];
                          $evento = array(
                            'id_solicitud' => $eventos['id_solicitud'],
                            'recibo' => $eventos['recibo'],
                            'id_cliente' => $eventos['id_cliente'],
                            'nombre_completo' => $eventos['nombre_completo'],
                            'identidad' => $eventos['identidad'],
                            'id_tipo_nacionalidad' => $eventos['id_tipo_nacionalidad'],                           
                            'telefono' => $eventos['telefono'],
                            'id_tipo_solicitud' => $eventos['id_tipo_solicitud'],                       
                            'fecha_creacion' => $eventos['fecha_creacion'],
                            'tipo' => $eventos['tipo'],
                            'precio_solicitud' => $eventos['precio_solicitud'],
                            'total' => $eventos['total'],
                            'id_estatus_solicitud' => $eventos['id_estatus_solicitud'],
                            'estatus' => $eventos['estatus'],
                          );
                          $vertbl[$traer][] =  $evento;
                        }
                        foreach ($vertbl as $dia => $lista_sol) { ?>
                          <?php foreach ($lista_sol as $evento) { ?>
                            <tr>
                              
                              <td> <?php echo $evento["nombre_completo"]; ?></td>
                              <td> <?php echo $evento["identidad"]; ?></td>
                              <td> <?php echo $evento["telefono"]; ?></td>
                              <td> <?php echo $evento["tipo"]; ?></td>
                              <td> <?php echo $evento["total"]; ?></td>
                              <td> <?php echo $evento["estatus"]; ?></td>
                              <td>
                                <button class="btn btn-warning btnEditarSolicitud glyphicon glyphicon-pencil" data-idsolicitud="<?= $evento["id_solicitud"] ?>" data-recibo="<?= $evento["recibo"] ?>" data-idcliente="<?= $evento["id_cliente"] ?>" data-nombre_completo="<?= $evento["nombre_completo"] ?>" data-telefono="<?= $evento["telefono"] ?>" data-id_tipo_solicitud="<?= $evento["id_tipo_solicitud"] ?>" data-fechacreacion="<?= $evento["fecha_creacion"] ?>" data-precio_solicitud="<?= $evento["precio_solicitud"] ?>" data-id_estatus_solicitud="<?= $evento["id_estatus_solicitud"] ?>" data-tipo="<?= $evento["tipo"] ?>"></button>
                                <button class="btn btn-danger btnEliminarSolicitud glyphicon glyphicon-remove" data-idsolicitud="<?php echo $evento['id_solicitud'] ?>">
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



          <div class="modal fade" id="modalEditarSolicitud" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" id="cerrar_act">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Actualizar Solicitud</h4>
                </div>
                <div class="modal-body">
                  <form name="formEditarParametro" action="">
                    <div class="ingreso-producto form-group">
                      <div class="campos" type="hidden">
                        <input autocomplete="off" class="form-control secundary" type="hidden" name="idSolcitud" value="0" disabled>
                      </div>

                      <div class="campos ">
                        <label for="recibo">Deposito</label>
                        <input id="recibo" autocomplete="off" style="width:365px"  minlength="1" class="form-control modal-roles 
                      	secundary" type="text" onpaste="return false" placeholder="Recibo" onkeypress="return soloNumeros(event)" required/>
                      </div><br>


                      <label for="tipo">Tipo de solicitud</label>
                      <?php
                      include("modelo/conexionbd.php");
                      $query_tip = mysqli_query($conn, "SELECT id_tipo_solicitud,tipo FROM `tbl_tipo_solicitud` 
                  where estado_eliminado=1");
                      $result = mysqli_num_rows($query_tip);
                      ?>
                      <select class="form-control secundary" id="tipo" name="tipo" class="notItemOne">
                      <option value="" disabled selected>Seleccione un tipo de solicitud</option>
                        <?php

                        if ($result > 0) {
                          while ($tipo_solictud = mysqli_fetch_array($query_tip)) {
                        ?>
                            <option value="<?php echo $tipo_solictud["id_tipo_solicitud"]; ?>"><?php echo $tipo_solictud["tipo"] ?></option>
                        <?php
                            # code...
                          }
                        }
                        ?>

                      </select>
                    </div>
                    <div class="campos">
                      <label for="estado">Estado de la solicitud </label>
                      <?php
                      include("modelo/conexionbd.php");
                      $query_estad = mysqli_query($conn, "SELECT id_estatus_solicitud,estatus
                                        FROM `tbl_estatus_solicitud` where estado_eliminado=1");
                      $result_est = mysqli_num_rows($query_estad);
                      ?>
                      <select class="form-control secundary" id="estatus_solicitud" name="estatus_solicitud" class="notItemOne">
                      <option value="" disabled selected>Seleccione un Estado</option>
                        <?php
                        echo $option;
                        if ($result_est > 0) {
                          while ($est_solictud = mysqli_fetch_array($query_estad)) {
                        ?>
                            <option value="<?php echo $est_solictud["id_estatus_solicitud"]; ?>"><?php echo $est_solictud["estatus"] ?></option>
                        <?php
                            # code...
                          }
                        }
                        ?>
                      </select>
                    </div><br>

                    <div class="campos ">
                      <label for="fecha_registro">Fecha De Registro</label>
                      <input id="fecha_registro" autocomplete="off" style="width:365px" class="form-control modal-roles 
   	                  secundary" type="text" onpaste="return false" placeholder="Fecha de registro" disabled/>
                    </div><br>

                    <div class="campos ">
                      <label for="fecha_actual">Fecha Actual</label>
                      <input id="fecha_actual" autocomplete="off" style="width:365px" class="form-control modal-roles 
                      secundary" type="text" onpaste="return false" placeholder="Fecha actual" disabled/>
                    </div>


                    <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">

                    <div class="modal-footer">
                   
                      <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarFormact">Cerrar</button>
                      <input id="btnEditarBD" type="button" class="btnEditarBD btn btn-primary" type="text" value="Actualizar Solicitud"><br>
                     
                    </div>
                   
                  </form>
                </div>
              </div>
            </div>
          </div>



        </div>

        <!--Registrar solicitud-->

        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalCrearS" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <div class="d-flex justify-content-between">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" id="cerrar_s">&times;</i>
                  </button>
                  <h3 class="modal-title" id="exampleModalLabel">Registrar Solicitud</h3>
                </div>
              </div>
              <div class="modal-body">
                <form name="" id="formSolicitudes" onpaste="return false" autocomplete="off">
                  <div class=" form-group">
                    <div class="campos form-group" type="hidden">
                      <label for=""> </label>
                      <input class="form-control modal-roles secundary" type="hidden" name="idInventario" value="0" disabled>
                    </div>

                    <div class="campos form-group">
                      <input id="identidad" name="identidad" maxlength="13" minlength="13" style="width:335px" onkeypress="return soloNumeros(event)" class="form-control modal-roles secundary" type="text" name="identidad" placeholder="Identidad" autofocus /><br>

                      <div class="campos form-group">
                        <input id="nombreCompleto" maxlength="40" minlength="40" style="width:335px" class="form-control modal-roles secundary" type="text" name="nombreCompleto" placeholder="Nombre Completo" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); 
									espacio_Letras(this);" />
                      </div>


                    </div>
                    <div class="campos form-group">
                      <input id="telefono" style="width:335px" maxlength="8" minlength="8" class="form-control modal-roles 
									secundary" type="tel" onpaste="return false" placeholder="Telefono" onkeypress="return soloNumeros(event)" /></center>
                    </div>


                    <div class="campos form-group">
                      <input id="n_recibo" style="width:335px" maxlength="30" class="form-control modal-roles secundary" type="text" name="n_recibo" onkeypress="return soloNumeros(event)" placeholder="Numero de recibo o depósito" />

                    </div>
                    <?php
                    include('./modelo/conexionbd.php');
                    $consulta_nacionalidad = mysqli_query($conn, "SELECT id_tipo_nacionalidad,nacionalidad FROM `tbl_tipo_nacionalidad`
                where estado_eliminado=1");
                    $resultados = mysqli_num_rows($consulta_nacionalidad);
                    ?>
                    <div class="campos form-group">
                      <select class="form-control" id="tipo_nac" name="tipo_nac" style="width:335px">
                        <option value="" disabled selected>Seleccione una nacionalidad</option>
                        <?php
                        if ($resultados > 0) {
                          while ($rol = mysqli_fetch_array($consulta_nacionalidad)) {
                        ?>
                            <option value="<?php echo $rol["id_tipo_nacionalidad"]; ?>"><?php echo $rol["nacionalidad"] ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>

                    <?php

                    $consulta_tip_solicitud = mysqli_query($conn, "SELECT id_tipo_solicitud,tipo,precio_solicitud FROM tbl_tipo_solicitud 
                    where estado_eliminado=1");
                    $resultados = mysqli_num_rows($consulta_tip_solicitud);
                    ?>
                    <div class="campos form-group">
                      <select class="form-control" id="tipo_sol" name="tipo_sol" style="width:335px">
                        <option value="" disabled selected>Seleccione un tipo de solicitud</option>
                        <?php
                        if ($resultados > 0) {
                          while ($rol = mysqli_fetch_array($consulta_tip_solicitud)) {
                        ?>
                            <option value="<?php echo $rol["id_tipo_solicitud"]; ?>"><?php echo $rol["tipo"] ?></option>

                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>

                    <div class="campos form-group">
                      <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                    </div>
                    <div class="modal-footer">
                      <button id="cerrar_rs" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button id="" type="submit" name="ingresarProducto" class="btn btn-primary">Registrar Solicitud</button>
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