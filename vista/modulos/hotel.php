<?php
include_once('funciones/sesiones.php');
$usuario = $_SESSION['usuario'];
?>

<main>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Hotel</h3>

        </div>
        <div class="box-body">
          <!--LLamar al formulario aqui-->

          <?php
          
          include_once('../../controlador/ctr.plantilla.php');

          ?>
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
</main>