<?php
//include_once()
include_once('funciones/sesiones.php');
$usuario = $_SESSION['usuario'];


/*$objeto = 3;
$rol_id = $_SESSION['rol'];

$stmt =*/ 

?>
<main>
  <div class="content-wrapper">

    <section class="content-header">
      <h1>Copia de seguridad <small> Base de datos</small></h1>     
        <ol class="breadcrumb">
          <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
          <li class="active"><i class="fa fa-database"></i> Copia de seguridad</li>
        </ol>
        <br>
    </section>
      <!-- Content Header (Page header) -->

    <section class="content">
      <div class="col-md-4">
        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">

            <div class="form-group">
              <div class="alert alert-light" role="alert">
                <h4><i class="fa fa-database"> Importante:</i></h4>
                <strong>Por que una copia de seguridad de la Base de datos?</strong>
                <br>
                Es muy importante el poder contar con una copia de nuestra base de datos, ya que si en algun momento
                presentamos problemas podes reestablecer la informacion.
              </div>
            </div>
          </div>
        </div>
      </div>



      <div class="col-md-8">
        <div class="box box-primary">
          <div class="box-header with-border">

            <!-- AQUI INICIO DEL CODIGO -->

            <div class="box-body">
              <!--LLamar al formulario aqui-->
              <form method="POST">
                <div class="contenedor-cs">
                  <div class = "tam-logo">
                    <img src="vista/dist/img/logo.png" alt="Logo fundacion AMITIGRA">
                  </div>
                  <br>
                  <p class="text-center">Creación de copia de seguridad de la Base de Datos - Fundación AMITIGRA</p>
                  <br>
                  <!-- <input id="copiaSeguridad" class="buttom-center" type="password" name="password" placeholder="ingrese su contrasena"> -->
                  <p class="text-center-msg"><i class="fa fa-warning"></i> Por seguridad es necesario que ingrese su contraseña.</p>
                  <button type="button" id ="guardarCopia" class ="buttom-center btn btn-success" data-toggle="modal" data-target="" data-idusuario="<?= $_SESSION['id'];?>" data-nombreusuario="<?= $_SESSION['usuario'] ?>">
                  Crear copia de seguridad</button>
                  <p class="text-center">Es recomendable realizar una copia de seguridad.</p>
                  <p class="text-center-msg">La copia se realiza automáticamente <a href="infoBackup">saber más</a></p>         
                </div>
              </form>
              <!--Fin llamado formulario-->

              <!-- MODAL CONTRASENA -->
              <div class="modal fade" id="modal-copia" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Copia de seguridad</h4>
                    </div>
                    <div class="modal-body">
                      <!-- AQUI CODIGO -->
                      <div class="form-group">
                        <div class="alert alert-light" role="alert">
                          <h4><i class="fa fa-warning"> Importante:</i></h4>
                          Por seguridad es necesario ingresar la contraseña.
                        </div>
                      </div>

                      <input type="hidden" id="usuario" value="<?php echo $_SESSION['usuario'];?>">

                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-3 control-label">Contraseña:</label>

                        <div class="input-group col-sm-8">
                          <input id="contraCopia" type="password" class="form-control" name="passConf" placeholder="Ingrese su contraseña">
                          <span class="input-group-btn" onclick="contrasenaCopia()">
                            <button id="verContrasena" class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_copia"></i></button>
                          </span>
                        </div>
                      </div>
                      <!-- FIN CODIGO -->
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                      <button id="guardarCopiaModal" type="button" class="btn btn-primary">Guardar cambios</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- FIN MODAL CONTRASENA -->
            </div>

            <!-- AQUI FIN DEL CODIGO -->

          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      
    </section>
    <!-- /.content -->
  </div>
</main>