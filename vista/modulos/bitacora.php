<div class="content-wrapper">
    <!-- Main content -->
  <section class="content">
      <!-- Default box -->
      <!--Inicio de la TABLA-->

      <div class="box">
        <div class="box-header with-border">
        <form action="../../ReportesPDF/ReporteBT" method="POST">  
        <h3 class="box-title">Gestion Bitacora</h3>
        <br>
        <br>
          <div class="row no-print">
            <div class="col-xs-12">
              <!--<a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>-->
              <button type="button" name="irpdf" value="pdf" class="btn btn-danger pull-left">
                <i class="fa fa-download"></i> Generate PDF
              </button>
          
              <button download="" type="button" class="btn btn-success pull-left" style="margin-left: 5px;"><i class="fa fa-credit-card"></i> Submit Payment
              </button>
            </div>
          </div>
          <br>
          </form>

          <?php
        require_once('./modelo/conexionbd.php');
        ?>
          <!-- /.box-header -->
          <div class="box-body">

            <!--<a href="nuevo-registrado.php" class="btn btn-success">Añadir Nuevo</a>-->
            <table id="tablas" class="display responsive nowrap">
                <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Objeto</th>
                            <th>Fecha</th>
                            <th>Accion</th>
                            <th>Descripcion</th>
                        </tr>
                </thead>
                <tbody>

                <?php
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
                 while( $registrado = $resultado->fetch_assoc() ) { ?>
                    <tr>    
                    <td><?php echo $registrado['nombre_usuario']; ?></td>
                    <td><?php echo $registrado['objeto']; ?></td>
                    <td><?php echo $registrado['fecha']; ?></td>
                    <td><?php echo $registrado['accion']; ?></td>
                    <td><?php echo $registrado['descripcion']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                    <th>Usuario</th>
                    <th>Objeto</th>
                    <th>Fecha</th>
                    <th>Accion</th>
                    <th>Descripcion</th>
                    </tr>
                </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
          
        </div>
        <!-- /.box -->
      </div>
      <!--Fin de la TABLA-->
      <!-- /.col -->
    <!-- /.row -->
  </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->