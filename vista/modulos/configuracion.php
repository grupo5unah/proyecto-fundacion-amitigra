<?php
include_once("./modelo/conexionbd.php");

  $PuertoCorreo = "puerto_correo";

  //$MensajeCorreo = "mensaje_correo";
  //$id = 5;
  $ExtraerInformacionCorreo = $conn->prepare("SELECT valor FROM tbl_parametros WHERE parametro = ?;");
  $ExtraerInformacionCorreo->bind_Param("s",$PuertoCorreo);
  $ExtraerInformacionCorreo->execute();
  $ExtraerInformacionCorreo->bind_Result($correoPuerto);

  while($ExtraerInformacionCorreo->fetch()){
    $Pcorreo = $correoPuerto;
  }

  $PuertoBD = "puerto_bd";
  $ExtraerInformacionBD = $conn->prepare("SELECT valor FROM tbl_parametros WHERE parametro = ?");
  $ExtraerInformacionBD->bind_Param("s",$PuertoBD);
  $ExtraerInformacionBD->execute();
  $ExtraerInformacionBD->bind_Result($bd);

  while($ExtraerInformacionBD->fetch()){
    $bdPuerto = $bd;
  }
//$id_objeto = 8;
//$rol = $_SESSION['mi_rol'];
/*$rol_id = $_SESSION['rol'];
$stmt = $conn->prepare("SELECT rol_id FROM tbl_usuarios
                        INNER JOIN tbl_roles
                        ON
                        tbl_usuarios.rol_id = tbl_roles.id_rol 
                        WHERE tbl_roles.rol = ?");
$stmt->bind_Param("s",$rol_id);
$stmt->execute();
$stmt->bind_Result($id_rol);

if($stmt->affected_rows){

  $existe = $stmt->fetch();
while($stmt->fetch()){
  $mi_rol = $id_rol;
}

if($existe){


$stmt = $conn->query("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta,id_rol,id_objeto FROM tbl_permisos
WHERE id_rol = '$mi_rol' AND id_objeto = '$id_objeto'");
$columna = $stmt->fetch_assoc();*/
?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

              <h3 class="profile-username text-center">Sobre esta configuración</h3>

              <p class="text-muted text-center">Software Engineer</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Aquí podras configurar los puertos para la conexión al correo electrónico y la base de datos.</b><a class="pull-right"></a>
                </li>
           
              </ul>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom-menu">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Configuracion correo</a></li>
              <li><a href="#timeline" data-toggle="tab">Configuracion Base de datos</a></li>
              <!--<li><a href="#settings" data-toggle="tab">Settings</a></li>-->
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                <div class="post">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label">Correo electrónico:</label>

                            <div class="col-sm-8">
                            <input type="email" class="form-control" id="inputName" placeholder="Correo electrónico">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label">Puerto correo electrónico:</label>

                            <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?php //echo $Pcorreo;?>" id="inputName" placeholder="Puerto">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label">Mensaje envío de correo:</label>

                            <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?php //echo $mensaje;?>" id="mensaje" placeholder="Mensaje">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button class="btn btn-success">Actualizar información</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
              <form class="form-horizontal">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label">Host hospedador:</label>

                            <div class="col-sm-8">
                            <input type="email" class="form-control" id="inputName" placeholder="Nombre del host">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label">Puerto base de datos:</label>

                            <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?php //echo $bdPuerto;?>" id="puerto" placeholder="Puerto base de datos">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label">Nombre base de datos:</label>

                            <div class="col-sm-8">
                            <input type="email" class="form-control" id="inputName" placeholder="Nombre base de datos">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button class="btn btn-success">Actualizar información</button>
                                </div>
                            </div>
                        </div>
                    </form>
              </div>
              <!-- /.tab-pane -->

              <!--<div class="tab-pane" id="settings">
                <form class="form-horizontal">
               
                </form>
              </div>-->
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>