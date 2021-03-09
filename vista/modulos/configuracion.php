<?php
require "./modelo/conexionbd.php";

  $arreglo = ['NOMBRE_DATABASE', 'PUERTO_DATABASE','NOMBRE_SISTEMA','NOMBRE_ORGANIZACION', 'PUERTO_CORREO',
              'CORREO_SISTEMA','FOTO_ORGANIZACION','USUARIO_ADMIN','USUARIO_CONTRASENA','HOST_HOSPEDADOR'];

    $extraer = "SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[5]';";
    $resultado = mysqli_query($conn, $extraer);

    while($parametro = mysqli_fetch_assoc($resultado)):
  
?>
<div class="content-wrapper">

<section class="content-header">
<h1>
  Configuracion <small>Sistema</small>
</h1>      
<ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><i class="fa fa-cog"></i> Otra configuración</li>
      </ol>
    </section>
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
              <li class="active"><a href="#activity" data-toggle="tab">Ajustes correo</a></li>
              <li><a href="#conf" data-toggle="tab">Ajustes Base de datos</a></li>
              <li><a href="#timeline" data-toggle="tab">Ajustes del sistema</a></li>
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
                            <input type="email" class="form-control" id="inputName" value="<?php echo $parametro['valor']; endwhile;?>" placeholder="Correo electrónico">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label">Puerto correo electrónico:</label>

                            <?php
                            $extraer = "SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[4]';";
                            $resultado = mysqli_query($conn, $extraer);

                            while($parametro = mysqli_fetch_assoc($resultado)):?>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?php echo $parametro['valor']; endwhile;?>" id="inputName" placeholder="Puerto">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label">Mensaje envío de correo:</label>

                            <div class="col-sm-8">
                            <input type="text" class="form-control" value="" id="mensaje" placeholder="Mensaje">
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
              <div class="tab-pane" id="conf">
              <form class="form-horizontal">
                <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Host hospedador:</label>
                    <?php
                    $extraer = "SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[9]';";
                    $resultado = mysqli_query($conn, $extraer);

                    while($parametro = mysqli_fetch_assoc($resultado)):?>
                    <div class="col-sm-8">
                    <input type="email" class="form-control" value="<?php echo $parametro['valor']; endwhile;?>" id="inputName" placeholder="Nombre del host">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Puerto base de datos:</label>
                    <?php
                    $extraer = "SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[1]';";
                    $resultado = mysqli_query($conn, $extraer);

                    while($parametro = mysqli_fetch_assoc($resultado)):?>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" value="<?php echo $parametro['valor']; endwhile;?>" id="puerto" placeholder="Puerto base de datos">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Nombre base de datos:</label>
                    <?php
                    $extraer = "SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[0]';";
                    $resultado = mysqli_query($conn, $extraer);

                    while($parametro = mysqli_fetch_assoc($resultado)):?>
                    <div class="col-sm-8">
                    <input type="email" class="form-control" id="inputName" value="<?php echo $parametro['valor']; endwhile;?>" placeholder="Nombre base de datos">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Estado de la conexion:</label>

                
                    <div class="col-sm-3 has-success">
                    <label class="control-label" for="inputSuccess"><i class="fa fa-check"></i><?php if($conn->ping()){ echo "conectado"; } else { $fallo = ("error de conexion %s\n" + $mysqli->error); echo $fallo;}?></label>
                     
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

              <div class="tab-pane" id="timeline">
                <form method="POST" class="form-horizontal" enctype="multipart/form-data">
                  <div class="form-group">
                  <label for="inputName" class="text-center col-sm-3 control-label"></label>
                  
                  <div class="input-group col-sm-8">
                    <img class="profile-user-img img-responsive img-circle" src="vista/dist/img/logo.png" alt="Foto perfil de usuario">

                    <p class="text-muted text-center">Logo</p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">logo organizacion:</label>

                    <div class="input-group col-sm-8">
                      <input type="file" id="imagen" name="imagen" accept="image/jpg, image/png" class="form-control">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Nombre organizacion:</label>

                    <?php
                    $extraer = "SELECT parametro, valor FROM tbl_parametros WHERE parametro = '$arreglo[3]';";
                    $resultado = mysqli_query($conn, $extraer);

                    while($parametro = mysqli_fetch_assoc($resultado)):?>
                    <div class="input-group col-sm-8">
                      <input type="text" name="nombre" class="form-control" id="inputName" value="<?php echo $parametro['valor']; endwhile;?>" placeholder="Nombre">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Usuario  administrador:</label>

                    <div class="input-group col-sm-8">
                      <input type="text" name="usuario" class="form-control" id="inputName" value="<?php echo ucwords(strtolower($usuario));?>" placeholder="Nombre de usuario">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-3 control-label">Correo organizacion:</label>
                    <?php
                    $extraer = "SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[0]';";
                    $resultado = mysqli_query($conn, $extraer);

                    while($parametro = mysqli_fetch_assoc($resultado)):?>
                    <div class="input-group col-sm-8">
                      <input type="email" name="correo" class="form-control" id="inputEmail" value="<?php echo $parametro['valor'];  endwhile;?>" placeholder="Correo electronico">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-3 control-label">Contraseña:</label>

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
                  <a href="#" class="badge badge-primary">Primary</a>

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