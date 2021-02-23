
  <!-- =============================================== -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title fa fa-bed"> Listado de reservaciones Hotel</h3>
      </div>
              <!-- /.box-header -->
      <div class="box-body">
        <a href="reservahotel" class=" btn bg-blue btn-flat ">Nueva Reservación <i class="fa fa-bed"></i></i></a>
        <table id="reservacion" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Cliente</th>
              <th>Fecha reservacion</th>
              <th>Fecha entrada</th>
              <th>Fecha salida</th>
              <th>accion</th>
            </tr>
          </thead>
          <tbody>
          <?php
            include_once ('./modelo/conexionbd.php');
          try{
            $sql = "SELECT id_reservacion, fecha_reservacion, fecha_entrada,fecha_salida,tbl_clientes.nombre_completo ";  
            $sql .= " FROM tbl_reservaciones ";
            $sql .= " INNER JOIN tbl_clientes ";
            $sql .= " ON tbl_reservaciones.cliente_id=tbl_clientes.id_cliente ";
            $sql .= " ORDER BY id_reservacion ";
            $resultado = $conn->query($sql);
          }catch (Exeption $e){
            $error = $e->getMessage();
            echo $error;
          }
          while($mostrar = $resultado->fetch_assoc()){ ?>
            <tr>
              <td><?php echo $mostrar['nombre_completo'];?></td>
              <td><?php echo $mostrar['fecha_reservacion'];?></td>
              <td><?php echo $mostrar['fecha_entrada'];?></td>
              <td><?php echo $mostrar['fecha_salida'];?></td>
              <td>
                <a href="editarreservah.php?id=<?php echo $mostrar ['id_reservacion']?>" class="btn bg-orange btn-flat margin fa fa-pencil"></a>
                <!-- hay una clase que se llama borrar esa se va a utilizar en un archivo JS -->
                <a href="#" data-id="<?php echo $mostrar ['id_reservacion'];?>" data-tipo="reservah" class="btn bg-maroon btn-flat margin borrar">
                <i class="fa fa-trash"></i>
                </a>
              </td>

            </tr>
          <?php } ?>
          </tbody>
            <tfoot>
              <tr>
                <th>Cliente</th>
                <th>Fecha reservacion</th>
                <th>Fecha entrada</th>
                <th>Fecha salida</th>
                <th>accion</th>
              </tr>
          </tfoot>
        </table>
      </div>

    </div>
  </div>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  
<!-- ./wrapper -->