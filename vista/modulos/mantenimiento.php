<script>
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

  //Solo numero para TELEFONO

  window.addEventListener("load", function() {
    formulario.telefono.addEventListener("keypress", soloNumeros, false);
  });
  //Solo permite introducir numeros.
  function soloNumeros(e) {
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
      e.preventDefault();
    }
  }

  //solo un espacio
  espacioLetras = function(input) {
    input.value = input.value.replace('  ', ' ');
  }
</script>
<?php

/*include_once("./controlador/ctr.BitacoraPDF.php");

if (isset($_POST['envio']) == 'pdf') {

  include("./controlador/ctr.ClasePdf.php");
  include("./modelo/conexion.php");

  // Creación del objeto de la clase heredada
  $pdf = new PDF('L', 'mm', 'Letter');
  $pdf->AddPage();
  $pdf->SetFont('Times', '', 12);
  //$pdf->Image('logo.png',120,4);
  $pdf->Cell(80);
  $pdf->SetFont('Arial', 'B', 15);
  $pdf->Cell(90, 10, 'Fundacion AMITIGRA.', 0, 1, 'C');
  $pdf->cell(80);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->Cell(90, 10, 'Reporte Bitacora.', 0, 1, 'C');
  $pdf->SetFont('Arial', '', 10);
  $pdf->SetFont('Times', 'B', 10);
  $pdf->SetFillColor(93, 183, 134);
  $pdf->Cell(6, 8, '', 0);
  $pdf->Cell(28, 6, 'Usuario', 1, 0, 'C', 2);
  $pdf->Cell(28, 6, 'Objeto', 1, 0, 'C', 2);
  $pdf->Cell(36, 6, 'Fecha', 1, 0, 'C', 2);
  $pdf->Cell(34, 6, 'Accion', 1, 0, 'C', 2);
  $pdf->Cell(122, 6, 'Descripcion', 1, 0, 'C', 2);
  $pdf->Ln(7);
  try {
    $stmt = "SELECT tbl_usuarios.nombre_usuario AS nombre_usuario, tbl_objeto.objeto AS objeto, fecha, accion, tbl_bitacora.descripcion AS descripcion from tbl_bitacora
                    INNER JOIN tbl_usuarios
                    ON
                    tbl_bitacora.usuario_id = tbl_usuarios.id_usuario
                    INNER JOIN tbl_objeto
                    ON
                    tbl_bitacora.objeto_id = tbl_objeto.id_objeto
                    ORDER BY id_bitacora DESC;
                    ";
    $resultado = $conn->query($stmt);
  } catch (Exception $e) {
    $error = $e->getMessage();
  }
  while ($registrado = $resultado->fetch_assoc()) {
    $pdf->Cell(6, 8, '', 0);
    $pdf->Cell(28, 6, $registrado['nombre_usuario'], 1, 0, 'C');
    $pdf->Cell(28, 6, $registrado['objeto'], 1, 0, 'C');
    $pdf->Cell(36, 6, $registrado['fecha'], 1, 0, 'C');
    $pdf->Cell(34, 6, $registrado['accion'], 1, 0, 'C');
    $pdf->Cell(122, 6, $registrado['descripcion'], 1, 0, 'C');
    $pdf->Ln(8);
  }
  $pdf->AliasNbPages();
  $pdf->Output('prueba.pdf', 'I');
}*/
?>

<script type="text/javascript" src="../js/usuarios.js?rev=<?php echo time(); ?>"></script>
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <!--Inicio de la TABLA-->

    <div class="box">
      <div class="box-header with-border">
        <div class="page-heading"> <i class="glyphicon glyphicon-user"></i></i> Listado de Usuarios</div>
        <br>
        <br>

        <div class="row no-print">
          <div class="col-xs-12">
            <a href="registroUsuario" class="btn_new">Crear Usuarios <i class="fa fa-user-plus"></i></i></a>
            <a href="reporteGUsuarios.php" class="btn_new">Generar Reporte PDF <i class="fa fa-download"></i></a>



          </div>
        </div>
        <br>

        <?php
        require_once('./modelo/conexion.php');
        ?>
        <!-- /.box-header -->
        <div class="box-body">

          <!--<a href="nuevo-registrado.php" class="btn btn-success">Añadir Nuevo</a>-->
          <table id="tabla_usuario" class="display responsive nowrap" style="width: 100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
              </tr>
            </thead>

          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <script>
      $(document).ready(function() {
        listar_usuario()
      });
    </script>
    <!--Fin de la TABLA-->


    <!--INICIO MODAL NUEVO-->

    <!--INICIO MODAL EDICION-->

    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <div class="d-flex justify-content-between">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i aria-hidden="true">&times;</i>
              </button>
              <h3 class="modal-title" id="exampleModalLabel">Actualizar Usuario</h3>
            </div>
          </div>
          <div class="modal-body">
            <form name="formEditarParametro">
              <div class="ingreso-producto form-group">
                <div class="campos" type="hidden">
                  <label for=""> </label>
                  <input autocomplete="off" class="form-control secundary" type="hidden" name="idInventario" value="0" disabled>
                </div>
                <div class="campos">
                  <label for="">Nombre: </label>
                  <input id="nombre" class="form-control secundary" type="text" name="nombre" placeholder="Nombre" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)" required required />
                </div>
                <div class="campos">
                  <label for="">Apellido: </label>
                  <input id="apellido" class="form-control secundary" type="text" name="apellido" placeholder="Apellido" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)" required required />
                </div>
                <div class="campos">
                  <label for="">Nombre Usuario: </label>
                  <input id="nombre_usuario" class="form-control secundary" type="text" name="nombre_usuario" placeholder="Nombre de usuario" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)" required required />
                </div>
                <div class="campos">
                  <label for="">Correo: </label>
                  <input id="correo" class="form-control secundary" type="email" name="correo" placeholder="Correo" onkeyup="validarEmail(this)" required />
                </div>
                <div class="campos">
                  <label for="">Telefono: </label>
                  <input id="telefono" class="form-control secundary" type="email" name="telefono" maxlength="8" placeholder="Telefono" onkeypress="return soloNumeros(event)" oninput="check_text(this);" required />
                </div>
                <div class="campos">
                  <label for="">Rol del usuario: </label>
                  <?php
                  include_once('modelo/conexion.php');
                  $query_rol = mysqli_query($conn, "SELECT id_rol,rol FROM tbl_roles");
                  $result_rol = mysqli_num_rows($query_rol);
                  ?>
                  <select name="rol" id="rol" required>
                    <option value="Seleccione un Rol">Seleccione un Rol:</option>
                    <?php
                    if ($result_rol > 0) {
                      while ($rol = mysqli_fetch_array($query_rol)) {
                    ?>
                        <option value="<?php echo $rol["id_rol"]; ?>"><?php echo $rol["rol"] ?></option>
                    <?php
                      }
                    }
                    ?>

                  </select>
                </div>
                <div class="campos">
                  <label for="">Estado del usuario: </label>
                  <select name="estado" id="estado" required>
                    <option value="">Seleccione un estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Nuevo">Nuevo</option>
                    <option value="Inactivo">Inactivo</option>
                    <option value="Bloqueado">Bloqueado</option>
                  </select>
                </div>
                <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <input id="btnEditarBD" type="button" class="btnEditarBD btn btn-primary" type="text" value="Actualizar Usuario" onclick="location.reload()">

          </div>
        </div>
      </div>
    </div>
    <!-- /.col -->
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->