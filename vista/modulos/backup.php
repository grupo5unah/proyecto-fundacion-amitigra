<?php
//include_once()
include_once('funciones/sesiones.php');
$usuario = $_SESSION['usuario'];

$id_objeto = 15;
$rol = $_SESSION["rol"];
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "asistente"){
  if($columna["permiso_consulta"] == 1){


?>

  <div class="content-wrapper">

    <section class="content-header">
      <h1>Copia y restauración base de datos <small> ajustes</small></h1>      
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><i class="fa fa-database"></i> Copia y restauración</li>
      </ol>
    </section>

    <section class="content">
      <div class="col-md-4">
        <div class="box box-primary">
          <div class="box-body box-profile">

            <div class="form-group">
              <div class="alert alert-light" role="alert">
                <h4><i class="fa fa-database"> Importante:</i></h4>
                <strong>Por que una copia de seguridad de la Base de datos?</strong>
                <br>
                Es muy importante el poder contar con una copia de nuestra base de datos, ya que si en algun momento
                presentamos problemas podes reestablecer la información.
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!--INICIO DE LA TABLA-->
      <div class="col-md-8">
        <div class="nav-tabs-custom2">
          <ul class="nav nav-tabs">
            <li><a href="#settings" data-toggle="tab">Copia de seguridad</a></li>
            <li><a href="#settings2" data-toggle="tab">Restaurar base de datos</a></li>
          </ul>
    
          <div class="tab-content">

            <!-- INICIO DEL PRIMER TAB -->
            <div class="active tab-pane" id="settings">
              <form method="POST" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">

                <!-- INICIO LOGO FUNDACION -->
                <div class="form-group">
                  <div class="input-group col-sm-12">
                    <div class = "tam-logo">
                      <img src="vista/dist/img/logo.png" alt="Logo fundacion AMITIGRA">
                    </div>
                  </div>
                </div>
                <!-- FIN LOGO FUNDACION -->

                <!-- INICIO TEXTO O INSTRUCCIONES -->
                <div class="form-group">
                  <div class="text-center alert alert-light" role="alert">
                    <h4><i class="text-center fa fa-database"></i><strong> Copia de seguridad</strong></h4>
                    Hola <strong><?php echo $_SESSION['usuario'];?></strong>
                    aquí puedes crear una copia de seguridad de la base de datos de la organización.
                    <br>
                    <br>
                    <i class="fa fa-warning"></i> Recuerda que para poder realizar la <strong>copia de seguridad de la base de datos</strong> no tiene
                    que estar en uso el sistema.
                  </div>
                </div>
                <!-- FIN TEXTO O INSTRUCCIONES -->

                <!-- INICIO BOTON DE COPIA DE SEGURIDAD -->
                <div class="text-center form-group">
                  <div class="col-sm-offset-2 col-sm-8">
                  <?php if ($columna['permiso_actualizacion'] == 1 OR $columna['permiso_actualizacion'] == 0) {?>
                  <button type="button" id="guardarCopia" class="btn btn-success actualizar editar" data-toggle="modal" data-target="" data-idusuario="<?= $_SESSION['id'];?>" data-nombreusuario="<?= $_SESSION['usuario'] ?>">
                  Guardar copia de seguridad</button><?php }?>
                  </div>
                </div>
                <!-- INICIO BOTON DE COPIA DE SEGURIDAD -->
              </form>
            </div>
            <!-- FIN DEL PRIMER TAB -->

            <!-- INICIO PRIMER MODAL -->
            <div class="modal fade" id="modal-copia" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" id="cerrarBack" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Copia de seguridad</h4>
                  </div>
                  <div class="modal-body">
                    <!-- AGREGAR CONTENIDO AQUI -->
                    <div class="form-group">
                        <div class="alert alert-light" role="alert">
                        <h4><i class="fa fa-warning"> Importante:</i></h4>
                        El ingreso de la contraseña es necesario para poder hacer efectiva la actualización de sus datos personales.
                        </div>
                      </div>
                      
                      <div class="form-group">
                          <label for="inputSkills" class="col-sm-3 control-label">Contraseña:</label>

                          <div class="input-group col-sm-8">
                            <input type="hidden" id="usuario" value="<?php echo $_SESSION['usuario'];?>">
                            <input id="contraCopia" type="password" class="form-control" name="passConf" placeholder="Ingrese su contraseña">
                            <span class="input-group-btn" onclick="contrasenaCopia()">
                              <button id="editarInfo" class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_p_actual"></i></button>
                            </span>
                          </div>
                        </div>
                    
                    <!-- FIN CONTENIDO -->
                  </div>
                  <div class="modal-footer">
                    <button id="CancelarCopia" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                    Cancelar</button>
                    <button id="guardarCopiaModal" type="button" class="btn btn-primary"><i class="fa fa-user"></i>
                    Crear copia</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
            </div>
            <!-- FIN PRIMER MODAL -->

            <!-- INICIO DEL SEGUNDO TAB -->
            <div class="tab-pane" id="settings2">
              <form method="POST" id="cambioPass" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                
                <!-- INICIO LOGO -->
                <div class="form-group">
                  <div class="input-group col-sm-12">
                    <div class = "tam-logo">
                      <img src="vista/dist/img/logo.png" alt="Logo fundacion AMITIGRA">
                    </div>
                  </div>
                </div>
                <!-- FIN LOGO -->

                <!-- INICIO DE INSTRUCCIONES -->

                <div class="form-group">
                  <div class="text-center alert alert-light" role="alert">
                    <h4><i class="text-center fa fa-database"></i><strong> Restaurar copia de seguridad</strong></h4>
                    Hola <strong><?php echo $_SESSION['usuario'];?></strong>
                    aquí puedes realizar la restauración de la copia de seguridad de la base de datos de la organización.
                    <br>
                    <i class="fa fa-warning"></i><strong>Importante:</strong> Realiza la <strong>restauración de la base de datos</strong> solo en caso de ser necesario.
                  </div>
                </div>
                <!-- FIN DE INSTRUCCIONES -->

                <!-- INICIO SELEC DE LAS COPIAS -->
                <div class="form-group">
                  <div class="text-center col-sm-offset-2 col-sm-8">
                    <label class="color-enlaces-cr">Seleccione una copia disponible para restaurar</label>
                    <select id="path" name="path" class="form-control">
                      <option value=""></option>
                      <option disabled>Seleccione la copia a restaurar...</option>
                      <?php
                        $directorio = "copiaSeguridad";
                        $dir=opendir($directorio);
                        while (($file = readdir($dir))!== false){
                          if ($file != '.' && $file != '..')       
                            echo '<option>'.$file.'</option>';      
                        }
                     
                      ?>
                    </select>
                  </div>
                </div>
                <!-- FIN SELECT DE LAS COPIAS -->

                <!-- INICIO BOTON DE RESTAURACION -->
                <div class="text-center form-group">
                  <div class="col-sm-offset-2 col-sm-8">
                  <?php if ($columna['permiso_actualizacion'] == 1 OR $columna['permiso_actualizacion'] == 0) {?>
                  <button type="button" id="restaurar" class="btn btn-success actualizar editar" data-toggle="modal" data-target="" data-idusuario="<?= $_SESSION['id'];?>" data-nombreusuario="<?= $_SESSION['usuario'] ?>">
                  Restaurar base de datos</button><?php }?>
                  </div>
                </div>
                <!-- FIN BOTON DE RESTAURACION -->
              </form>
            </div>
            <!-- FIN SEGUNDO TAB -->

            <!-- INICIO SEGUNDO MODAL -->
            <div class="modal fade" id="modal-restauracion" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" id="cerrarRest" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Restauracion</h4>
                  </div>
                  <div class="modal-body">
                    <!-- AGREGAR CONTENIDO AQUI -->
                    <div class="form-group">
                        <div class="alert alert-light" role="alert">
                        <h4><i class="fa fa-warning"> Importante:</i></h4>
                        El ingreso de la contraseña es necesario para poder hacer efectiva la actualización de sus datos personales.
                        </div>
                      </div>
                      
                      <div class="form-group">
                          <label for="inputSkills" class="col-sm-3 control-label">Contraseña:</label>

                          <div class="input-group col-sm-8">
                          <input type="hidden" id="usuario" value="<?php echo $_SESSION['usuario'];?>">
                            <input id="contraRestauracion" type="password" class="form-control" name="passConf" placeholder="Ingrese su contraseña">
                            <span class="input-group-btn" onclick="contraRestauracion()">
                              <button id="editarInfo" class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_contraRest"></i></button>
                            </span>
                          </div>
                        </div>
                    
                    <!-- FIN CONTENIDO -->
                  </div>
                  <div class="modal-footer">
                    <button id="CancelarRestauracion" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                    Cancelar</button>
                    <button id="restaurarCopiaModal" type="button" class="btn btn-primary"><i class="fa fa-user"></i>
                    Restaurar</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
            </div>
            <!-- FIN SEGUNDO MODAL -->

          </div>
        </div>
      </div>
      <!--FIN DE LA TABLA-->
  </section>

  <!-- /.content -->
  </div>
<?php

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>