<?php
              
              //include_once("./controlador/ctr.BitacoraPDF.php");

              if(isset($_POST['envio']) == 'pdf'){

                include("./controlador/ctr.ClasePdf.php");
                include("./modelo/conexion.php");
    
                // Creación del objeto de la clase heredada
                $pdf = new PDF('L','mm','Letter');
                $pdf->AddPage();
                $pdf->SetFont('Times','',12);
                //$pdf->Image('logo.png',120,4);
                $pdf->Cell(80);
                $pdf->SetFont('Arial','B',15);
                $pdf->Cell(90,10,'Fundacion AMITIGRA.',0,1,'C');
                $pdf->cell(80);
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell(90,10,'Reporte Bitacora.',0,1,'C');
                $pdf->SetFont('Arial','',10);
                $pdf->SetFont('Times', 'B', 10);
                $pdf->SetFillColor(93, 183, 134);
                $pdf->Cell(6, 8, '', 0);
                $pdf->Cell(28, 6, 'Usuario', 1,0,'C',2);
                $pdf->Cell(28, 6, 'Objeto', 1,0,'C',2);
                $pdf->Cell(36, 6, 'Fecha', 1,0,'C',2);
                $pdf->Cell(34, 6, 'Accion', 1,0,'C',2);
                $pdf->Cell(122, 6, 'Descripcion', 1,0,'C',2);
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
                while( $registrado = $resultado->fetch_assoc() ) {
                    $pdf->Cell(6, 8, '', 0);
                    $pdf->Cell(28, 6,$registrado['nombre_usuario'], 1,0,'C');
                    $pdf->Cell(28, 6,$registrado['objeto'], 1,0,'C');
                    $pdf->Cell(36, 6,$registrado['fecha'], 1,0,'C');
                    $pdf->Cell(34, 6,$registrado['accion'], 1,0,'C');
                    $pdf->Cell(122, 6,$registrado['descripcion'], 1,0,'C');
                    $pdf->Ln(8);
                }
                $pdf->AliasNbPages();
                $pdf->Output('prueba.pdf','I');
            }
              ?>
<div class="content-wrapper">
    <!-- Main content -->
  <section class="content">
      <!-- Default box -->
      <!--Inicio de la TABLA-->

      <div class="box">
        <div class="box-header with-border"> 
        <h3 class="box-title">Gestion de usuario</h3>
        <br>
        <br>
          <div class="row no-print">
            <div class="col-xs-12">
            <form action="" method="POST">
              <!--<a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>-->
          <?php if ($rol_id == "administrador") {?><button type="submit" name="envio" value="pdf" target="_blank" class="btn btn-primary pull-left"><?php }?>
                <i class="fa fa-download"></i> Generar PDF
              </button>
              <button type="button" class="btn btn-success pull-left" style="margin-left: 5px;"><i class="fa fa-credit-card"></i> Submit Payment
              </button>
              </form>
              
            </div>
          </div>
          <br>

          <?php
        require_once('./modelo/conexion.php');
        ?>
          <!-- /.box-header -->
          <div class="box-body">

            <!--<a href="nuevo-registrado.php" class="btn btn-success">Añadir Nuevo</a>-->
            <table id="tablas" class="display responsive nowrap">
                <thead>
                        <tr>
                        <th>Nombre</th>
                        <th>apellido</th>
                        <th>Nombre usuario</th>
                        <th>Correo</th>
                        <th>Genero</th>
                        <th>Telefono</th>
                        <th>Rol</th>
                        <th>Estado usuario</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        </tr>
                </thead>
                <tbody>

                <?php
                  try {
                    $stmt = "SELECT id_usuario, nombre, apellido, nombre_usuario, correo, genero, telefono, tbl_roles.rol AS rol, estado_usuario FROM tbl_usuarios
                    INNER JOIN tbl_roles
                    ON
                    tbl_usuarios.rol_id = tbl_roles.id_rol
                    ORDER BY id_usuario DESC;
                    ";
                    $resultado = $conn->query($stmt);
                  } catch (Exception $e) {
                    $error = $e->getMessage();
                  }
                 while( $registrado = $resultado->fetch_assoc() ) { ?>
                    <tr>
                    <td><?php echo $registrado['nombre']; ?></td>
                    <td><?php echo $registrado['apellido']; ?></td>    
                    <td><?php echo $registrado['nombre_usuario']; ?></td>
                    <td><?php echo $registrado['correo']; ?></td>
                    <td><?php echo $registrado['genero']; ?></td>
                    <td><?php echo $registrado['telefono']; ?></td>
                    <td><?php echo $registrado['rol']; ?></td>
                    <td><?php echo $registrado['estado_usuario']; ?></td>
                    <td>
                    <!--<a type="button" data-toggle="modal" data-target="#modal-default" class="btn bg-orange btn-flat"> <i class="fa fa-pencil"></i></a>-->
                   
                    <a class="btn bg-orange btn-flat" href="hotel?id = <?php echo $registrado['id_usuario'];?>"><i class="fa fa-pencil"></i></a>  
                  </td>
                    <td>
                    <input type="hidden" name="eliminarUsuario" value="id=<?php echo $registrado['id_usuario'];?>">
                    <button type="submit" class="btn bg-maroon btn-flat"><i class="fa fa-trash"></i></button>
                    <?php
                    include_once("./controlador/ctr.borrarUser.php");

                    $borrar = new borrar();
                    $borrar->ctrBorrar();
                    ?>
                    </td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                    <th>Nombre</th>
                    <th>apellido</th>
                    <th>Nombre usuario</th>
                    <th>Correo</th>
                    <th>Genero</th>
                    <th>Telefono</th>
                    <th>Rol</th>
                    <th>Estado usuario</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                    </tr>
                </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!--Fin de la TABLA-->


      <!--INICIO MODAL NUEVO-->
      <div class="modal fade" id="modal-default">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar usuario</h4>
              </div>
              <div class="modal-body">
              
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Nombre</label>
                <input type="text" class="form-control input-sm">
                <label for="inputName" class="col-sm-2 control-label">Nombre</label>
                <input type="text" class="form-control input-sm">
                <select name="area" id="area" class="form-control input-sm">
                <option value="">seleccionar...</option>  
                <option value="">hola</option>
                </select>

                <p>Aqui van los campos a editar del usuario&hellip;</p>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" id="guardar" class="btn btn-primary">Guardar nuevo</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      <!--FIN MODAL NUEVO-->

      
      <!--INICIO MODAL EDICION-->
      <div class="modal fade" id="modal-default">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar usuario</h4>
              </div>
              <div class="modal-body">
              
              <div class="form-group">
                <input type="text" hidden="" id="idCliente">
                <label for="inputName" class="col-sm-2 control-label">Nombre</label>
                <input type="text" class="form-control input-sm">
                <label for="inputName" class="col-sm-2 control-label">Nombre</label>
                <input type="text" class="form-control input-sm">
                <select name="area" id="area" class="form-control input-sm">
                <option value="">seleccionar...</option>  
                <option value="">hola</option>
                </select>

                <p>Aqui van los campos a editar del usuario&hellip;</p>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" id="guardar" class="btn btn-primary">Guardar cambios</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      <!--FIN MODAL EDICION-->


      <!-- /.col -->
    <!-- /.row -->
  </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->

  <script>
  function eliminar(idjuego){
$.ajax({type:"POST",
data:"idjuego ="+idjuego,
url:"procesos/eliminar.php",
success:function(r){
if (r == 1){
  <?php
    echo "<div class='text-center alert alert-danger' role = 'alert'>
    eliminado con exito.
    </div>";
    ?>
} else {
  <?php
  echo "<div class='text-center alert alert-danger' role = 'alert'>
  no se pudo eliminar
  </div>"; 
    ?>
}
}
})
}
</script>