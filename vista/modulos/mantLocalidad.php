<?php
require_once "./modelo/conexionbd.php";

$id_objeto = 25;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] === 1){
?>

<div class="content-wrapper">
<!-- Main content -->
<section class="content">
<!-- Default box -->
<!--Inicio de la TABLA-->

    <div class="box">
    <div class="box-header with-border"> 
    <h3 class="box-title">Mantenimiento localidad</h3>
    <br>
    <br>
    <div class="row no-print">
    <div class="col-xs-12">
    <form action="" method="POST">
    <!--<a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>-->
    <button type="submit" name="envio" value="pdf" target="_blank" class="btn btn-primary pull-left">
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
              <th>Nombre localidad</th>
              <th>Creado por</th>
              <th>Fecha creacion</th>
              <th>Modificado por</th>
              <th>Fecha modificacion</th>
              <th>Actualizar</th>
              <th>Eliminar</th>
              </tr>
      </thead>
      <tbody>

      <?php
        try {
          $stmt = "SELECT nombre_localidad, creado_por, fecha_creacion, modificado_por, fecha_modificacion FROM tbl_localidad";
          $resultado = $conn->query($stmt);
        } catch (Exception $e) {
          $error = $e->getMessage();
        }
      while( $registrado = $resultado->fetch_assoc() ) { ?>
          <tr>
          <td><?php echo $registrado['nombre_localidad']; ?></td>
          <td><?php echo $registrado['creado_por']; ?></td>    
          <td><?php echo $registrado['fecha_creacion']; ?></td>
          <td><?php echo $registrado['modificado_por']; ?></td>
          <td><?php echo $registrado['fecha_modificacion']; ?></td>
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
              <th>Nombre localidad</th>
              <th>Creado por</th>
              <th>Fecha creacion</th>
              <th>Modificado por</th>
              <th>Fecha modificacion</th>
              <th>Actualizar</th>
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


    <!--INICIO MODAL-->
    <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Editar usuario</h4>
    </div>
    <div class="modal-body">

    <div class="form-group">
          <label for="inputName" class="col-sm-2 control-label">Nombre</label>

          <div class="col-sm-10">
            <input type="text" name="nombre" class="form-control" id="inputName" value="<?php echo ucwords(strtolower($_SESSION['nombre']));?>" placeholder="Nombre">
          </div>
        </div>

      <p>Aqui van los campos a editar del usuario&hellip;</p>
      
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
      <button type="button" class="btn btn-primary">Guardar cambios</button>
    </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!--FIN MODAL-->
    <!-- /.col -->
    <!-- /.row -->
</section>
<!-- /.content -->
</div>
<?php

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>



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