<?php
include_once "./modelo/conexionbd.php";
$id_objeto = 4;
global $mi_rol;
$rol_id = $_SESSION['rol'];
$stmt = $conn->prepare("SELECT rol_id, foto FROM tbl_usuarios
                        INNER JOIN tbl_roles
                        ON tbl_usuarios.rol_id = tbl_roles.id_rol
                        WHERE tbl_roles.rol = ?");
$stmt->bind_Param("s",$rol_id);
$stmt->execute();
$stmt->bind_Result($id_rol, $foto);

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
    <!-- Main content -->
    <section class="content">

    <?php
    include_once "./modelo/conexionbd.php";
    
    $consulta = "SELECT foto FROM tbl_usuarios WHERE nombre_usuario = '$usuario'";

    $resultadoFoto = mysqli_query($conn,$consulta);

    while($imagen = mysqli_fetch_assoc($resultadoFoto)):?>

<div class="row">
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
                <img class="img-circle" src="fotoPerfil/<?php echo $imagen['foto']; endwhile;?>" alt="foto usuario">
              </div>

<?php }}?>
              <?php

              include_once("./modelo/conexionbd.php");
                  //try {
                    $stmt = $conn->prepare("SELECT nombre_completo, correo, telefono, primer_ingreso, fecha_vencimiento FROM tbl_usuarios WHERE nombre_usuario = ?");
                    $stmt->bind_Param("s",$usuario);
                    $stmt->execute();
                    $stmt->bind_Result($nombre, $correo, $telefono, $ingreso, $vencimiento);
                 
                  if($stmt->affected_rows){

                    $existe = $stmt->fetch();

                    if($existe){
                      $_SESSION['nombre_completo'] = $nombre;
                      // $_SESSION['apellido'] = $apellido;
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
      
      
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><strong>Cargo:</strong></h3>
              <h5 class="widget-user-desc"><?php echo ucwords($rol_id);?></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a><strong>Nombre completo: </strong><span class="pull-right"><?php echo ucwords(strtolower($_SESSION['nombre_completo']));?></span></a></li>
                <li><a><strong>Nombre de usuario: </strong><span class="pull-right"><?php echo strtoupper($usuario);?></span></a></li>
                <li><a><strong>Correo: </strong><span class="pull-right"><?php echo $_SESSION['correo'];?></span></a></li>
                <li><a><strong>Telefono: </strong><span class="pull-right"><?php echo ucwords(strtolower($_SESSION['telefono']));?></span></a></li>
                <li><a><strong>Contrasena caduca: </strong><span class="pull-right"><?php echo ucwords(strtolower($_SESSION['fecha_vencimiento']));?></span></a></li>
                <li><a><strong>Dias transcurridos: </strong><span class="pull-right"><?php echo $dias_transcurridos;?></span></a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>

        
        <!--INICIO DE LA TABLA-->
        <div class="col-md-8">
          <div class="nav-tabs-custom2">
            <ul class="nav nav-tabs">
              <li><a href="#settings" data-toggle="tab">Informacion general</a></li>
              <li><a href="#settings2" data-toggle="tab">Seguridad</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="settings">
                <form method="POST" class="form-horizontal" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Nombre completo:</label>

                    <div class="input-group col-sm-8">
                      <input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo ucwords(strtolower($_SESSION['nombre_completo']));?>" placeholder="Nombre">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Nombre de usuario:</label>

                    <div class="input-group col-sm-8">
                      <input type="text" name="usuario" class="form-control" id="usuario" value="<?php echo ucwords(strtolower($usuario));?>" placeholder="Nombre de usuario">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Foto de perfil:</label>

                    <div class="input-group col-sm-8">
                      <input type="file" id="imagen" name="imagen" accept="image/jpg, image/png" class="form-control">
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

                  <!--INPUT INGRESAR LA CONTRASENA ACTUAL-->
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-3 control-label">Contraseña:</label>

                    <div class="input-group col-sm-8">
                      <input id="passConf" type="password" class="form-control" name="passConf" placeholder="Confirmar su contraseña">
                      <span class="input-group-btn" onclick="a_mostrarPassword()">
                        <button class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_p_actual"></i></button>
                      </span>
                    </div>
                    <p class="text-center-msg">Ingrese su contraseña para confirmar los cambios</p>
                  </div>
                  
                  <div class="text-center form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                    <input type="hidden" name="cambio_info" value="act_info">
                    <?php if ($columna['permiso_actualizacion'] == 1 OR $columna['permiso_actualizacion'] == 0) {?>
                    <button type="submit" class="btn btn-success actualizar">Guardar cambios</button><?php }?>
                    </div>
                  </div>

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
                <form method="POST" id="cambioPass" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="input-group col-sm-8">
                      <input type="hidden" class="form-control" name="usuario" value="<?php echo $usuario;?>" placeholder="Ingrese su contraseña actual">
                      <span class="input-group-btn">
                      </span>
                    </div>
                  </div>

                  <!--INPUT INGRESAR LA CONTRASENA ACTUAL-->
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-3 control-label">Contraseña actual:</label>

                    <div class="input-group col-sm-8">
                      <input id="PassActual" type="password" class="form-control" name="actualPass" placeholder="Ingrese su contraseña actual">
                      <span class="input-group-btn">
                      </span>
                    </div>
                  </div>
                  <!--INPUT CONFIRMAR NUEVA CONTRASENA-->
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-3 control-label">Nueva contraseña:</label>

                    <div class="input-group col-sm-8">
                      <input id="PassNuevo" type="password" class="form-control" name="nuevaPass" placeholder="Ingrese su nueva contraseña">
                      <span class="input-group-btn">
                      </span>
                    </div>
                  </div>
                  <!--INPUT CONFIRMAR NUEVA CONTRASENA-->
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-3 control-label">Confirmar contraseña:</label>

                    <div class="input-group col-sm-8">
                      <input id="ConfPass" type="password" class="form-control" name="confPass" placeholder="Confirmar su contraseña">
                      <span class="input-group-btn" onclick="mostrarPassword()">
                        <button class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_conf"></i></button>
                      </span>
                    </div>
                  </div>
                  
                  <div class="text-center form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                    <input type="hidden" name="cambios" value="act">
                    <?php if ($columna['permiso_actualizacion'] == 1 OR $columna['permiso_actualizacion'] == 0) {?><button type="submit" class="btn btn-success actualizar">Guardar cambios</button><?php }?>
                    </div>
                  </div>

                  <!--FUNCION PARA MOSTRAR CONTRASENA-->
                  <script type="text/javascript">
                    function mostrarPassword(){
                      
                      var actual = document.getElementById("PassActual");
                      if(actual.type == "password"){
                        actual.type = "text";
                        $('.icon_actual').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                      }else{
                        actual.type = "password";
                        $('.icon_actual').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                      }

                      var nueva = document.getElementById("PassNuevo");
                      if(nueva.type == "password"){
                        nueva.type = "text";
                        $('.icon_nuevo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                      }else{
                        nueva.type = "password";
                        $('.icon_nuevo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                      }

                      var conf = document.getElementById("ConfPass");
                      if(conf.type == "password"){
                        conf.type = "text";
                        $('.icon_conf').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                      }else{
                        conf.type = "password";
                        $('.icon_conf').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                      }
                    } 
                  </script>

                </form>
              </div>
              
              <!-- /.tab-pane -->
            </div>
            <?php
            
              require("./controlador/ctr.passwordperfil.php");

              $actualizar = new PasswordPHP();
              $actualizar->ctrPasswordInfo();
        
                    //include("./controlador/ctr.actualizarInformacion.php");

                    //$actualizar = new ActualizarInfo();
                    //$actualizar->ctrActualizarInfo();

                    require_once("./controlador/ctr.Acciones.php");

              $perfilBitacora = new AccionesUsuario();
              $perfilBitacora->ctrPerfilBitacora();

                    ?>

            
          </div>
          <?php }}?>
          <!-- /.nav-tabs-custom -->
          
        </div>
        <!--FIN DE LA TABLA-->
      </div>
    
      

    </section>

    <!-- /.content -->
  </div>