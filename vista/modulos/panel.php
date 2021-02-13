<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

    <!--CAJAS INICIO PRIMERA LINEA-->
    <div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->

          <?php
          include_once("./modelo/conexionbd.php");
            //TOTAL DE USUARIOS
            $registros = "SELECT COUNT(*) total FROM tbl_usuarios";
            $result = mysqli_query($conn, $registros);
            $fila = mysqli_fetch_assoc($result);
            
            //TOTAL ACTIVIDADES REALIZADAS
            $actividades = "SELECT COUNT(*) total FROM tbl_bitacora";
            $result = mysqli_query($conn, $actividades);
            $total = mysqli_fetch_assoc($result);
            
            //TOTAL ROLES
            $rol_admin = "SELECT COUNT(*) admon FROM tbl_usuarios
                      WHERE rol_id = 2";
            $verificar = mysqli_query($conn, $rol_admin);
            $total_roles = mysqli_fetch_assoc($verificar);

            $rol_sec = "SELECT COUNT(*) sec FROM tbl_usuarios
                      WHERE rol_id = 3";
            $verificar_sec = mysqli_query($conn, $rol_sec);
            $total_sec = mysqli_fetch_assoc($verificar_sec);
          ?>     
          <div class="small-box bg-blue">
            <div class="inner">
            <h2><?php echo $fila['total'];?></h2>

              <p>Usuarios registrados</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="mantenimiento" class="small-box-footer">
              Click aquí para mantenimiento <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h2><?php echo $total['total'];?></h2>
              <p>actividades realizadas</p>
            </div>
            <div class="icon">
              <i class="fa fa-mouse-pointer"></i>
            </div>
            <a href="bitacora" class="small-box-footer">
              Click aquí para consultar la bitácora <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <p>ROLES</p>
              <p>Administracion: <?php echo $total_roles['admon'];?></p>
              <p>Asistentes: <?php echo $total_sec['sec'];?></p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <a href="mantroles" class="small-box-footer">
              Click aquí para mantenimiento roles <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h4>65</h4>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="fa  fa-gears"></i>
            </div>
            <a href="mantparametros" class="small-box-footer">
              Click aqui para consultar parametros <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    <!--CAJAS FINAL PRIMERA LINEA-->

    <!--CAJAS INICIO SEGUNDA LINEA-->
    <div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->

          <?php
          include_once("./modelo/conexionbd.php");
            //TOTAL DE USUARIOS
            $registros = "SELECT COUNT(*) total FROM tbl_usuarios";
            $result = mysqli_query($conn, $registros);
            $fila = mysqli_fetch_assoc($result);
            
            //TOTAL ACTIVIDADES REALIZADAS
            $actividades = "SELECT COUNT(*) total FROM tbl_bitacora";
            $result = mysqli_query($conn, $actividades);
            $total = mysqli_fetch_assoc($result);
            
            //TOTAL ROLES
            $rol_admin = "SELECT COUNT(*) admon FROM tbl_usuarios
                      WHERE rol_id = 1";
            $verificar = mysqli_query($conn, $rol_admin);
            $total_roles = mysqli_fetch_assoc($verificar);

            $rol_sec = "SELECT COUNT(*) sec FROM tbl_usuarios
                      WHERE rol_id = 2";
            $verificar_sec = mysqli_query($conn, $rol_sec);
            $total_sec = mysqli_fetch_assoc($verificar_sec);
          ?>     
          <div class="small-box bg-aqua">
            <div class="inner">
            <h2><?php echo $fila['total'];?></h2>

              <p>Preguntas registradas</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-powerpoint-o"></i>
            </div>
            <a href="mantpreguntas" class="small-box-footer">
              Click aquí para preguntas <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-maroon">
            <div class="inner">
              <h2><?php echo $total['total'];?></h2>
              <p>actividades realizadas</p>
            </div>
            <div class="icon">
              <i class="fa  fa-ban"></i>
            </div>
            <a href="mantpermisos" class="small-box-footer">
              Click aquí para consultar permisos <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <p>ROLES</p>
              <p>Administradores(as): <?php echo $total_roles['admon'];?></p>
              <p>Asistentes: <?php echo $total_sec['sec'];?></p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <a href="mantroles" class="small-box-footer">
              Click aquí para mantenimiento roles <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
              <h4>65</h4>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    <!--CAJAS FINAL SEGUNDA LINEA-->

      <!--INICIO DE OTRA INFORMACION-->
      <div class="row">
        <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="vista/dist/img/logo.png" alt="Foto perfil de usuario">

              <p class="text-muted text-center">INFORMACIÓN</br>sobre la fundacion</p>

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
                  <b>Organización: </b> <a class="pull-right"><?php echo ucwords(strtolower($_SESSION['nombre_completo']));?></a>
                </li>
                <li class="list-group-item">
                  <b>Usuario admin: </b> <a class="pull-right"><?php echo strtoupper($usuario);?></a>
                </li>
                <li class="list-group-item">
                  <b>Correo: </b> <a class="pull-right"><?php echo $_SESSION['correo'];?></a>
                  <br>
                </li>
                <li class="list-group-item">
                  <b>Teléfono: </b> <a class="pull-right"><?php echo ucwords(strtolower($_SESSION['telefono']));?></a>
                </li>
              </ul>           
            </div>
          </div>
        </div>  
        <!--FIN DE OTRA INFORMACION-->  
        
        <!--INICIO DE LA TABLA-->
        <div class="col-md-8">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a>Configuración Información <?php echo "Fundacion AMITIGRA";?></a></li>
            </ul>
            <div class="tab-content">
              <div class="" id="settings">
                <form method="POST" class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Nombre</label>

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
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-3 control-label">Contraseña actual</label>

                    <div class="input-group col-sm-8">
                      <input id="ConfPass" type="password" class="form-control" name="password" placeholder="Ingrese su contrasena">
                      <span class="input-group-btn" onclick="mostrarPassword()">
                        <button class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_conf"></i></button>
                      </span>
                    </div>
                    <p class="text-center-msg">Ingrese su contraseña para confirmar los cambios</p>
                  </div>
          
                  <div class="text-center form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" name="cambio" value="act" class="btn btn-danger">Guardar cambios</button>
                    </div>
                  </div>

                  <script type="text/javascript">
	function mostrarPassword(){
			var cambio = document.getElementById("ConfPass");
			if(cambio.type == "password"){
				cambio.type = "text";
				$('.icon_conf').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				cambio.type = "password";
				$('.icon_conf').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}
		} 
	</script>

                  <?php
        
                    include("./controlador/ctr.actualizarInformacion.php");

                    $actualizar = new ActualizarInfo();
                    $actualizar->ctrActualizarInfo();

                    ?>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <?php }}?>
          <!-- /.nav-tabs-custom -->
        </div>
        <!--FIN DE LA TABLA-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>