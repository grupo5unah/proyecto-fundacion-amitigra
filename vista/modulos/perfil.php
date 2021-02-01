<?php
include_once "./modelo/conexionbd.php";
$id_objeto = 4;
//$rol = $_SESSION['mi_rol'];
$rol_id = $_SESSION['rol'];
$stmt = $conn->prepare("SELECT tbl_roles.rol FROM tbl_usuarios
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

$stmt = $conn->query("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta, rol_id, objeto_id FROM tbl_permisos
WHERE rol_id = '$mi_rol' AND objeto_id = '$id_objeto'");
$columna = $stmt->fetch_assoc();

?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- INICIO DE LA INFORMACION DEL USUARIO-->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="vista/dist/img/avatar5.png" alt="Foto perfil de usuario">

              <p class="text-muted text-center">Cargo: <br> <?php echo ucwords($rol_id);?> </p>
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
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Nombre completo: </b> <a class="pull-right"><?php echo ucwords(strtolower($_SESSION['nombre_completo']));?></a>
                </li>
                <li class="list-group-item">
                  <b>Nombre de usuario: </b> <a class="pull-right"><?php echo strtoupper($usuario);?></a>
                </li>
                <li class="list-group-item">
                  <b>Correo: </b> <a class="pull-right"><?php echo $_SESSION['correo'];?></a>
                  <br>
                </li>
                <li class="list-group-item">
                  <b>Teléfono: </b> <a class="pull-right"><?php echo ucwords(strtolower($_SESSION['telefono']));?></a>
                </li>
                <li class="list-group-item">
                  <b>Contraseña Caduca: </b> <a class="pull-right"><?php echo ucwords(strtolower($_SESSION['fecha_vencimiento']));?></a>
                </li>
                <li class="list-group-item">
                  <b>Días transcurridos: </b> <a class="pull-right"><?php echo $dias_transcurridos;?></a>
                </li>
              </ul>
                 
            </div>
          </div>
          <!--FIN DE LA INFORMACION DEL USUARIO-->

        </div>    
        
        <!--INICIO DE LA TABLA-->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a href="#settings" data-toggle="tab">Configuración Cuenta</a></li>
            </ul>
            <div class="tab-content">
              <div class="" id="settings">
                <form method="POST" class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Nombre completo</label>

                    <div class="input-group col-sm-8">
                      <input type="text" name="nombre" class="form-control" id="inputName" value="<?php echo ucwords(strtolower($_SESSION['nombre_completo']));?>" placeholder="Nombre">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Nombre de usuario</label>

                    <div class="input-group col-sm-8">
                      <input type="text" name="usuario" class="form-control" id="inputName" value="<?php echo ucwords(strtolower($usuario));?>" placeholder="Nombre de usuario">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Tel./Celular</label>

                    <div class="input-group col-sm-8">
                      <input type="text" name="telefono" class="form-control" id="inputName" value="<?php echo ucwords(strtolower($_SESSION['telefono']));?>" placeholder="Numero telefono fijo o celular">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-3 control-label">Correo Electrónico</label>

                    <div class="input-group col-sm-8">
                      <input type="email" name="correo" class="form-control" id="inputEmail" value="<?php echo $_SESSION['correo'];?>" placeholder="Correo electronico">
                    </div>
                  </div>
                  <!--INPUT INGRESAR LA CONTRASENA ACTUAL-->
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-3 control-label">Contraseña actual</label>

                    <div class="input-group col-sm-8">
                      <input id="PassActual" type="password" class="form-control" name="actualPass" placeholder="Ingrese su contraseña actual">
                      <span class="input-group-btn">
                      </span>
                    </div>
                  </div>
                  <!--INPUT CONFIRMAR NUEVA CONTRASENA-->
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-3 control-label">Nueva contraseña</label>

                    <div class="input-group col-sm-8">
                      <input id="PassNuevo" type="password" class="form-control" name="nuevaPass" placeholder="Ingrese su nueva contraseña">
                      <span class="input-group-btn">
                      </span>
                    </div>
                  </div>
                  <!--INPUT CONFIRMAR NUEVA CONTRASENA-->
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-3 control-label">Confirmar contraseña</label>

                    <div class="input-group col-sm-8">
                      <input id="ConfPass" type="password" class="form-control" name="confPass" placeholder="Confirmar su contraseña">
                      <span class="input-group-btn" onclick="mostrarPassword()">
                        <button class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_conf"></i></button>
                      </span>
                    </div>
                  </div>
                  
                  <div class="text-center form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                    <input type="hidden"  name="cambio" value="act">
                    <?php if ($columna["permiso_actualizacion"] == 0) {?><button type="submit" class="btn btn-danger">Guardar cambios</button><?php }?>
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
        
                    include("./controlador/ctr.actualizarInformacion.php");

                    $actualizar = new ActualizarInfo();
                    $actualizar->ctrActualizarInfo();

                    include("./controlador/ctr.Acciones.php");

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