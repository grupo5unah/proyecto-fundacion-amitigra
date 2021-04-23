<?php
include_once "./modelo/conexionbd.php";
$id_objeto = 4;
global $mi_rol;
$rol_id = $_SESSION['rol'];
$stmt = $conn->prepare("SELECT rol_id FROM tbl_usuarios
                        INNER JOIN tbl_roles
                        ON tbl_usuarios.rol_id = tbl_roles.id_rol
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

$stmt = $conn->query("SELECT permiso_actualizacion, rol_id, objeto_id FROM tbl_permisos
WHERE rol_id = '$id_rol' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();

?>
  <div class="content-wrapper">

    <section class="content-header">
      <h1>Perfil <small> ajustes</small></h1>      
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><i class="fa fa-user"></i> Perfil de usuario</li>
      </ol>
    </section>

    <section class="content">

      <?php
      include_once "./modelo/conexionbd.php";
      
      $consulta = "SELECT foto FROM tbl_usuarios WHERE nombre_usuario = '$usuario'";

      $resultadoFoto = mysqli_query($conn,$consulta);

      while($imagen = mysqli_fetch_assoc($resultadoFoto)):?>

      <div class="row">
        <div class="col-md-4">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
               <img class="img-circle" src="./fotoPerfil/<?php echo $imagen['foto']; endwhile;?>" alt="foto usuario">
              </div>

<?php }}?>
<?php

include_once("./modelo/conexionbd.php");
    //try {
      $stmt = $conn->prepare("SELECT nombre_completo, correo, telefono, fecha_mod_contrasena, fecha_vencimiento FROM tbl_usuarios WHERE nombre_usuario = ?");
      $stmt->bind_Param("s",$usuario);
      $stmt->execute();
      $stmt->bind_Result($nombre, $correo, $telefono, $ingreso, $vencimiento);
    
    if($stmt->affected_rows){

      $existe = $stmt->fetch();

      if($existe){
        $_SESSION['nombre_completo'] = $nombre;
        $_SESSION['correo'] = $correo;
        $_SESSION['telefono'] = $telefono;
        $_SESSION['fecha_vencimiento'] = $vencimiento;

        $fecha_registro = new DateTime($ingreso);
        date_default_timezone_set("America/Tegucigalpa");
        $fecha_hoy = date('Y-m-d H:i:s', time());
        $fecha_actual = new DateTime($fecha_hoy);
        $diff = $fecha_registro->diff($fecha_actual);
        $dias_transcurridos = $diff->days;

?>

              <h3 class="widget-user-username"><strong>Cargo:</strong></h3>
              <h5 class="widget-user-desc"><?php echo ucwords($rol_id);?></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a><strong>Nombre completo: </strong><span class="pull-right"><?php echo ucwords(strtolower($_SESSION['nombre_completo']));?></span></a></li>
                <li><a><strong>Nombre de usuario: </strong><span class="pull-right"><?php echo strtoupper($usuario);?></span></a></li>
                <li><a><strong>Correo: </strong><span class="pull-right"><?php echo $_SESSION['correo'];?></span></a></li>
                <li><a><strong>Teléfono: </strong><span class="pull-right"><?php echo ucwords(strtolower($_SESSION['telefono']));?></span></a></li>
                <li><a><strong>Contraseña caduca: </strong><span class="pull-right"><?php setlocale(LC_ALL,'es_ES.UTF-8'); $caduca = strftime('%d/%b/%g. hr %I:%M %p', strtotime($_SESSION['fecha_vencimiento'])); echo $caduca;?></span></a></li>
                <li><a><strong>Días transcurridos: </strong><span class="pull-right"><?php echo $dias_transcurridos;?></span></a></li>
              </ul>
            </div>
          </div>
        </div>

        <!--INICIO DE LA TABLA-->
        <div class="col-md-8">
          <div class="nav-tabs-custom2">
            <ul class="nav nav-tabs">
              <li><a href="#settings" data-toggle="tab">Información</a></li>
              <li><a href="#settings2" data-toggle="tab">Seguridad</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="settings">
                <form method="POST" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">

                  <div class="form-group">
                    <div class="alert alert-light" role="alert">
                     <h4><i class="fa fa-user"> Información general</i></h4>
                     Hola <strong><?php echo $_SESSION['usuario'];?></strong>
                     aquí puedes configurar tu información personal, tu <strong>nombre de usuario</strong> no se puede modificar.
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Nombre completo:</label>

                    <div class="input-group col-sm-8">
                      <input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo ucwords(strtolower($_SESSION['nombre_completo']));?>" placeholder="Nombre">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Nombre de usuario:</label>

                    <div class="input-group col-sm-8">
                      <input type="text" readonly name="usuario" class="form-control" id="usuario" value="<?php echo ucwords(strtolower($usuario));?>" placeholder="Nombre de usuario" disabled>
                      <p id="notificacion"></p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Tel./Celular:</label>

                    <div class="input-group col-sm-8">
                      <input type="tel" name="telefono" class="form-control" id="telefono" value="<?php echo ucwords(strtolower($_SESSION['telefono']));?>" placeholder="Numero telefono fijo o celular">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-3 control-label">Correo Electrónico:</label>

                    <div class="input-group col-sm-8">
                      <input type="email" name="correo" class="form-control" id="correo" value="<?php echo $_SESSION['correo'];?>" placeholder="Correo electronico">
                    </div>
                  </div>
                  
                  <div class="text-center form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                      <input type="hidden" id="tipo" name="cambio_info" value="cambio_info">
                      <?php if ($columna['permiso_actualizacion'] == 1 OR $columna['permiso_actualizacion'] == 0) {?>
                      <button type="button" id="editar" class="btn btn-success actualizar editar" data-toggle="modal" data-target="" data-idusuario="<?= $_SESSION['id'];?>" data-nombreusuario="<?= $_SESSION['usuario'] ?>">
                      Guardar cambios</button><?php }?>
                    </div>
                  </div>
       
                  <!-- INICIO MODAL CONTRASENA -->
                  <div class="modal fade" id="modal-default" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" id="cerrarActualizacion" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Confirmar cambios</h4>
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
                                  <input id="passConf" type="password" class="form-control" name="passConf" placeholder="Ingrese su contraseña">
                                  <span class="input-group-btn" onclick="a_mostrarPassword()">
                                    <button id="editarInfo" class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_p_actual"></i></button>
                                  </span>
                                </div>
                              </div>
                          
                          <!-- FIN CONTENIDO -->
                        </div>
                        <div class="modal-footer">
                          <button id="cancelarActualizacion" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                          Cancelar</button>
                          <button id="aceptCambios" type="button" class="btn btn-primary"><i class="fa fa-user"></i>
                          Guardar cambios</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- FIN MODAL CONTRASENA -->

                  <script type="text/javascript">
                    window.onload = function() {
                      let telefono = document.getElementById('telefono');
                      let nombre = document.getElementById('nombre');
                      let usuario = document.getElementById('usuario');
                      let correo = document.getElementById('correo');
                      let contrasena = document.getElementById('passConf');
                      
                      telefono.onpaste = function(e) {
                        e.preventDefault();
                      }                 
                      telefono.oncopy = function(e) {
                        e.preventDefault();
                      }

                      nombre.onpaste = function(e) {
                        e.preventDefault();
                      } 
                      nombre.oncopy = function(e) {
                        e.preventDefault();
                      }

                      usuario.onpaste = function(e) {
                        e.preventDefault();
                      } 
                      usuario.oncopy = function(e) {
                        e.preventDefault();
                      }

                      contrasena.onpaste = function(e){
                        e.preventDefault();
                      }
                      contrasena.oncopy = function(e){
                        e.preventDefault();
                      }

                      correo.onpaste = function(e){
                        e.preventDefault();
                      }
                      correo.oncopy = function(e){
                        e.preventDefault();
                      }
                    }
                  </script>
                            
                  <!--FUNCION PARA MOSTRAR CONTRASENA-->
                  <script type="text/javascript">
                    function a_mostrarPassword(){
                      
                      var actual = document.getElementById("passConf");
                      if(actual.type == "password"){
                        actual.type = "text";
                        $('.icon_p_actual').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                      }else{
                        actual.type = "password";
                        $('.icon_p_actual').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                      }
                    } 
                  </script>
                </form>
              </div>

              <!-- INICIO SEGUNDO TAB -->
              <div class="tab-pane" id="settings2">
                <form method="POST" id="cambioPass" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="input-group col-sm-8">
                      <input type="hidden" class="form-control" name="usuario" value="<?php echo $usuario;?>" placeholder="Ingrese su contraseña actual">
                      <span class="input-group-btn">
                      </span>
                    </div>
                  </div>

                  <!--INPUT INGRESAR LA CONTRASENA ACTUAL-->
                  <div class="form-group">
                    <div class="alert alert-light" role="alert">
                      <h4><i class="fa fa-unlock-alt"> Cambio de contraseña</i></h4>
                      <strong><?php echo $_SESSION['usuario'];?></strong>
                      en este espacio puedes hacer cambio de tu contraseña haciendo click en el siguiente botón.
                    </div>
                  </div>
                  
                  <div class="text-center form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                      <input type="hidden" name="cambios" value="act">
                      <?php if ($columna['permiso_actualizacion'] == 1 OR $columna['permiso_actualizacion'] == 0) {?>
                      <button type="button" id="cambioContrasena" class="btn btn-success actualizar" data-toggle="modal2" data-target="#modal-default2">
                        Click aqui para cambiar la contraseña
                      </button><?php }?>
                    </div>
                  </div>

                  <!-- INICIO SEGUNDO MODAL -->
                  <div class="modal fade" id="modal-default2" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Cambio de contraseña</h4>
                        </div>
                        
                        <div class="modal-body">
                          <!-- INICIO CONTENIDO -->
                          <div class="form-floating mb-3">
                            <label for="floatingInput">Contraseña actual</label>  
                            <input id="passActual" type="password" class="form-control" name="passConf" placeholder="Contrasena actual"/>
                          </div>
                            
                          <div class="form-floating mb-6">
                            <label for="floatingInput">Nueva contraseña</label>
                              <input id="passNueva" type="password" class="form-control" name="passConf" placeholder="Nueva contraseña"/>
                          </div>

                          <div class="form-floating mb-3">
                            <label for="floatingInput">Confirmar contraseña</label>  
                            <div class="input-group">
                              <input id="passConfirmar" type="password" class="form-control" name="passConf" placeholder="Confirmar su contraseña">
                              <span class="input-group-btn" onclick="mostrarPasswordNueva()">
                                <button class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_p_actual"></i></button>
                              </span>
                            </div>
                          </div>
                          <!-- FIN CONTENIDO -->
                        </div>

                        <div class="modal-footer">
                          <button type="button" id="cancelarCambios" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                          <button type="button" id="gcambios" class="btn btn-primary"><i class="fa fa-user"></i> Guardar cambios</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- FIN SEGUNDO MODAL -->

                </form>
              </div>
              <!-- FIN SEGUNDO TAB -->
            </div>

            <?php
          
              require_once("./controlador/ctr.Acciones.php");

              $perfilBitacora = new AccionesUsuario();
              $perfilBitacora->ctrPerfilBitacora();
            ?>

          </div>
          <?php }}?>
          
        </div>
        <!--FIN DE LA TABLA-->
      </div>

    </section>
  </div>