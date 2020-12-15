<?php
include_once("./modelo/conexion.php");
$id_objeto = 4;
$rol_id = 2;

/*$stmt = $conn->prepare("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta,id_rol,id_objeto FROM tbl_permisos
                        WHERE id_rol = ? AND id_objeto = ?");
$stmt->bind_Param("ii",$rol_id, $id_objeto);
$stmt->execute();*/

$stmt = $conn->query("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta,id_rol,id_objeto FROM tbl_permisos
WHERE id_rol = '$rol_id' AND id_objeto = '$id_objeto'");
$columna = $stmt->fetch_assoc();
//$stmt->bind_result($insercion,$eliminacion,$actualizacion,$consulta,$objeto, $rol);
?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Reporte Producto</h3>

        </div>
        <div class="box-body">
          <!--LLamar al formulario aqui-->
          <form>
          <?php if($columna['permiso_insercion'] == 1) {?><button name="imprimir">imprimir</button><?php }?>
          <button name="editar">Editar</button>
          </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>