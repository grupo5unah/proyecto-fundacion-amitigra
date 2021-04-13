<?php
require "./modelo/conexionbd.php";

$id_objeto = 18;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" ){
  if($columna["permiso_consulta"] == 1){

    $arreglo = ['NOMBRE_DATABASE','PUERTO_DATABASE','NOMBRE_SISTEMA','NOMBRE_ORGANIZACION','PUERTO_CORREO',
    'CORREO_SISTEMA','FOTO_ORGANIZACION','USUARIO_ADMIN','USUARIO_CONTRASENA','HOST_HOSPEDADOR','MENSAJE_CORREO','CONTRASENA_ADMIN','CONTRASENA_CORREO'];

    //TRAE EL CORREO ELECTRONICO DE LA ORGANIZACION
    $correo = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[5]';");
    $resultCorreo = mysqli_query($conn, $correo);
    $PCorreo = mysqli_fetch_assoc($resultCorreo);

    //TRAE EL PUERTO DEL CORREO DE LA ORGANIZACION
    $puerto = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[4]';");
    $resultPuerto = mysqli_query($conn, $puerto);
    $PPuerto = mysqli_fetch_assoc($resultPuerto);

    //TRAE EL MENSAJE QUE SE ENVIA POR CORREO ELECTRONICO
    $mensajeCorreo = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[10]';");
    $resultMensaje = mysqli_query($conn, $mensajeCorreo);
    $PMensaje = mysqli_fetch_assoc($resultMensaje);

    //TRAE LA CONTRASENA DEL CORREO
    $CCorreo = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[12]';");
    $resultCCorreo = mysqli_query($conn, $CCorreo);
    $PCCorreo = mysqli_fetch_assoc($resultCCorreo);


    //TRAE EL NOMBRE DEL HOST DE LA BASE DE DATOS
    $host = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[9]';");
    $resultHost = mysqli_query($conn, $host);
    $PHost = mysqli_fetch_assoc($resultHost);

    //TRAE EL PUERTO DE LA BASE DE DATOS
    $puertobd = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[1]';");
    $resultPuertobd = mysqli_query($conn, $puertobd);
    $PPuertoBD = mysqli_fetch_assoc($resultPuertobd);

    //TRAE EL NOMBRE DE LA BASE DE DATOS
    $nombreBD = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[0]';");
    $resultNombreBD = mysqli_query($conn, $nombreBD);
    $PNombreBD = mysqli_fetch_assoc($resultNombreBD);


    //TRAE EL NOMBRE DE LA ORGANIZACION
    $NombreOrganizacion = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[3]';");
    $resultOrganizacion = mysqli_query($conn, $NombreOrganizacion);
    $PNOrganizacion = mysqli_fetch_assoc($resultOrganizacion);

    //TRAE EL NOMBRE DEL SISTEMA
    $NSistema = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[2]';");
    $resultNSistema = mysqli_query($conn, $NSistema);
    $PNSistema = mysqli_fetch_assoc($resultNSistema);

    //TRAE EL NOMBRE DEL ADMINISTRADOR
    $administrador = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[7]';");
    $resultAdmin = mysqli_query($conn, $administrador);
    $PNAdmin = mysqli_fetch_assoc($resultAdmin);

    //TRAE LA CONTRASENA DEL ADMINISTRADOR
    $Cadministrador = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[11]';");
    $resultCAdmin = mysqli_query($conn, $Cadministrador);
    $PCAdmin = mysqli_fetch_assoc($resultCAdmin);

    $arreglo = ['INTENTOS_SESION','CANT_PREGUNTAS','VIGENCIA_CUENTA'];

    //TRAE EL CORREO ELECTRONICO DE LA ORGANIZACION
    $intentosSesion = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[0]';");
    $resultIntentos = mysqli_query($conn, $intentosSesion);
    $PIntentos = mysqli_fetch_assoc($resultIntentos);

    //TRAE EL PUERTO DEL CORREO DE LA ORGANIZACION
    $cantPreguntas = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[1]';");
    $resultPreguntas = mysqli_query($conn, $cantPreguntas);
    $PPreguntas = mysqli_fetch_assoc($resultPreguntas);

    //TRAE EL MENSAJE QUE SE ENVIA POR CORREO ELECTRONICO
    $vigCuenta = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[2]';");
    $resultVigencia = mysqli_query($conn, $vigCuenta);
    $PVigencia = mysqli_fetch_assoc($resultVigencia);
  
?>
<div class="content-wrapper">

    <section class="content-header">
      <h1>Configuración <small>Parámetros del sistema</small></h1>      
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><i class="fa fa-cog"></i> Parámetros del sistema</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">

      <!-- SELECT2 EXAMPLE INICIO -->
      <div class="col-xs-12">
        <div class="box box-default">
          <div class="box-header with-border">
            <!-- <h3 class="box-title">Select2</h3> -->

            <div class="box-tools pull-right">

              <!-- INICIO INFOTMACION -->
              <div class="row">
                <div class="col-xs-12">
                  <h2 class="page-header">
                  <i class="fa fa-exclamation"></i> Sobre esta Configuración.
                  </h2>
                </div>

                <div class="col-lg-6">
                  <div class="input-group">
                    <div class="form-group">
                      <strong><i class="fa fa-gear"></i> Parámetros del Sistema</strong>
                      <br><strong>Que tipo de parámetros puedes configurar</strong>
                      <br>
                      Es muy importante el poder contar con una copia de nuestra base de datos, ya que si en algun momento
                      presentamos problemas podes reestablecer la informacion.
                    </div>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="input-group">
                    <div class="form-group">
                      <strong><i class="fa fa-unlock-alt"></i> Parámetros de seguridad</strong>
                      <br><strong>Que tipo de parámetros puedes configurar</strong>
                      <br>
                      Es muy importante el poder contar con una copia de nuestra base de datos, ya que si en algun momento
                      presentamos problemas podes reestablecer la informacion.
                    </div>
                  </div>
                </div>
              <!-- FIN INFORMACION -->

            </div>
          </div>
        </div>
      </div>
      <!-- SELECT2 EXAMPLE FIN -->

      <!-- TITULO PARAMETROS DEL SISTEMA -->
      <h2 class="content-header"><small>Parametros del Sistema</small></h2>

        <!-- AJUSTE DE CORREO -->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
                <img class="img-circle" src="https://ngnoticias.com/wp-content/uploads/2020/07/correo-electronico.png" alt="User Avatar">
              </div>
            
              <h3 class="widget-user-username">Ajustes</h3>
              <h5 class="widget-user-desc"><strong>Correo electrónico</strong></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#"><strong>Correo:</strong>
                  <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="text" autocomplete="off" name="nombre" class="form-control" id="correo" value="<?php echo $PCorreo['valor'];?>" placeholder="Nombre">
                    </div>
                  </div>
                </a></li>
                <li><a><strong>Puerto: </strong>
                  <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="text" autocomplete="off" name="nombre" class="form-control" id="puertoCorreo" value="<?php echo $PPuerto['valor'];?>" placeholder="Nombre" onkeypress="return soloNumeros(event)">
                    </div>
                  </div>
                    </a></li>
                    <li><a><strong>Contraseña correo:</strong>
                <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="password" name="nombre" disabled="true" class="form-control" id="contrasenaCorreo" value="<?php echo $PCCorreo['valor'];?>" placeholder="Nombre">
                      <span class="input-group-btn" onclick="mostrarPassCorreoParam()">
                          <button id="editarInfo" class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_PassCorreo"></i></button>
                        </span>
                    </div>
                  </div>
                  </a></li>
              
                <li><br><div class="text-center form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                    <input type="hidden" id="tipo" name="cambio_info" value="cambio_info">
                    <button type="button" id="editar" class="btn btn-success actualizar" data-toggle="modal" data-target="#modal-correo" data-idusuario="<?= $_SESSION['id'];?>" data-nombreusuario="<?= $_SESSION['usuario'] ?>">
                    Guardar cambios</button>
                    </div>
                    <br>
                  </div></li>
                  <br>
              </ul>
            </div>
          </div>
        </div>
        <!-- FIN AJUSTES DE CORREO -->

        <input type="hidden" id="idUsuario" value="<?php echo $_SESSION["id"];?>">
        <input type="hidden" id="usuario" value="<?php echo $_SESSION["usuario"];?>">

        <!-- INICIO MODAL AJUSTES DE CORREO -->
        <div class="modal fade" id="modal-correo" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Parámetros Correo</h4>
              </div>
              <div class="modal-body">
                <!-- AQUI INICIO DEL CODIGO -->
                <div class="form-group">
                    <div class="alert alert-light" role="alert">
                     <h4><i class="fa fa-warning"> Importante:</i></h4>
                     El ingreso de la contraseña es necesario para poder hacer efectiva la actualización de la informacion.
                    </div>
                  </div>
                  <div class="row">
                  <div class="form-group">
                      <label for="inputSkills" class="col-sm-3 control-label">Contraseña:</label>

                      <div class="input-group col-sm-8">
                        <input id="contrasenaCorreo" type="password" class="form-control" name="passConf" placeholder="Ingrese su contraseña">
                        <span class="input-group-btn" onclick="mostrarPassCorreo()">
                          <button id="editarInfo" class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_correo"></i></button>
                        </span>
                      </div>
                    </div>
                </div>
                <!-- AQUI FINAL DEL CODIGO -->
              </div>
              <div class="modal-footer">
                <button type="button" id="limpiarCorreo" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="InformacionCorreo" class="btn btn-primary">Guardar cambios</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- FINAL MODAL AJUSTES DE CORREO -->

        <!-- INICIO AJUSTES DE LA BASE DE DATOS -->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
                <img class="img-circle" src="https://cdn.pixabay.com/photo/2020/03/17/17/46/database-4941338_960_720.png" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Ajustes</h3>
              <h5 class="widget-user-desc"><strong>Base de datos</strong></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a><strong>Host hospedador:</strong>
                <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="text" autocomplete="off" name="nombre" class="form-control" id="host" value="<?php echo $PHost['valor'];?>" placeholder="Nombre">
                    </div>
                  </div></a></li>
                <li><a><strong>Puerto:</strong>
                <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="text" autocomplete="off" name="nombre" class="form-control" id="puertoBD" value="<?php echo $PPuertoBD['valor'];?>" placeholder="Nombre" onkeypress="return soloNumeros(event)">
                    </div>
                  </div></a></li>
                <li><a><strong>Nombre base de datos: </strong>
                <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="text" autocomplete="off" name="nombre" class="form-control" id="nombreBD" value="<?php echo $PNombreBD['valor'];?>" placeholder="Nombre">
                    </div>
                  </div></a></li>
                <li><a><strong>Estado conexión: </strong><span class="pull-right"><i class="fa fa-check has-success" for="inputSuccess"></i><?php if($conn->ping()){ echo "conectado"; } else { $fallo = ("error de conexion %s\n" + $mysqli->error); echo $fallo;}?></span></a></li>
                <li><br><div class="text-center form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                    <input type="hidden" id="tipo" name="cambio_info" value="cambio_info">
                    <button type="button" id="editar" class="btn btn-success actualizar editar" data-toggle="modal" data-target="#modal-bd" data-idusuario="<?= $_SESSION['id'];?>" data-nombreusuario="<?= $_SESSION['usuario'] ?>">
                    Guardar cambios</button>
                    </div>
                    <br>
                  </div></li>
                  <br>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- FIN AJUSTES DE LA BASE DE DATOS -->

        <!-- INICIO MODAL AJUSTES DE LA BASE DE DATOS -->
        <div class="modal fade" id="modal-bd" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Parámetros Base de datos</h4>
              </div>
              <div class="modal-body">
                <!-- AQUI INICIO CODIGO -->
                <div class="form-group">
                    <div class="alert alert-light" role="alert">
                     <h4><i class="fa fa-warning"> Importante:</i></h4>
                     El ingreso de la contraseña es necesario para poder hacer efectiva la actualización de la informacion.
                    </div>
                  </div>
                  <div class="row">
                  <div class="form-group">
                      <label for="inputSkills" class="col-sm-3 control-label">Contraseña:</label>

                      <div class="input-group col-sm-8">
                        <input id="contrasenaBD" type="password" class="form-control" name="passConf" placeholder="Ingrese su contraseña">
                        <span class="input-group-btn" onclick="mostrarPassBD()">
                          <button id="editarInfo" class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_bd"></i></button>
                        </span>
                      </div>
                    </div>
                </div>
                <!-- AQUI FINAL CODIGO -->
              </div>
              <div class="modal-footer">
                <button type="button" id="borrarBD" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="InformacionBD" class="btn btn-primary">Guardar cambios</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- FINAL MODAL AJUSTES DE LA BASE DE DATOS -->

        <!-- INICIO AJUSTES DEL SISTEMA -->
        <div class="col-md-4">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
                <img class="img-circle" src="https://cdn.pixabay.com/photo/2016/10/19/03/59/socialmedia-1752079_960_720.png" alt="User Avatar">
              </div>
              <h3 class="widget-user-username">Ajustes</h3>
              <h5 class="widget-user-desc"><strong>Sistema</strong></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a><strong>Nombre organización: </strong>
                <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="text" autocomplete="off" name="nombre" class="form-control" id="nombreOrganizacion" value="<?php echo $PNOrganizacion['valor'];?>" placeholder="Nombre">
                    </div>
                    </div>
                    </a></li>
                <li><a><strong>Nombre sistema: </strong>
                <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="text" autocomplete="off" name="nombre" class="form-control" id="nombreSistema" value="<?php echo $PNSistema['valor'];?>" placeholder="Nombre">
                    </div>
                  </div>
                  </a></li>
                <li><a><strong>Usuario administrador</strong>
                <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="text" autocomplete="off" name="nombre" disabled="true" class="form-control" id="usuarioAdministrador" value="<?php echo $PNAdmin['valor'];?>" placeholder="Nombre">
                    </div>
                  </div>
                  </a></li>
                  <li><a><strong>Contrasena administrador</strong>
                <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="password" name="nombre" disabled="true" class="form-control" id="contrasenaAdministrador" value="<?php echo $PCAdmin['valor'];?>" placeholder="Nombre">
                      <span class="input-group-btn" onclick="mostrarPassSistemaParam()">
                          <button id="editarInfo" class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_PassSistema"></i></button>
                        </span>
                    </div>
                  </div>
                  </a></li>
                <li><br><div class="text-center form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                    <input type="hidden" id="tipo" name="cambio_info" value="cambio_info">
                    <button type="button" id="editar" class="btn btn-success actualizar editar" data-toggle="modal" data-target="#modal-sistema" data-idusuario="<?= $_SESSION['id'];?>" data-nombreusuario="<?= $_SESSION['usuario'] ?>">
                    Guardar cambios</button>
                    </div>
                    <br>
                    <br>
                  </div></li>
              </ul>
            </div>
          </div> 
        </div>
        <!-- FIN AJUSTES DEL SISTEMA -->

        <!-- INICIO MODAL AJUSTES DEL SISTEMA -->
        <div class="modal fade" id="modal-sistema" data-backdrop="static" data-keyboard="false"">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Parámetros del sistema</h4>
              </div>
              <div class="modal-body">
                <!-- AQUI INICIO CODIGO -->
                <div class="form-group">
                    <div class="alert alert-light" role="alert">
                     <h4><i class="fa fa-warning"> Importante:</i></h4>
                     El ingreso de la contraseña es necesario para poder hacer efectiva la actualización de la informacion.
                    </div>
                  </div>
                  <div class="row">
                  <div class="form-group">
                      <label for="inputSkills" class="col-sm-3 control-label">Contraseña:</label>

                      <div class="input-group col-sm-8">
                        <input id="contrasenaSistema" type="password" class="form-control" name="passConf" placeholder="Ingrese su contraseña">
                        <span class="input-group-btn" onclick="mostrarPassSistema()">
                          <button id="editarInfo" class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_sistema"></i></button>
                        </span>
                      </div>
                    </div>
                </div>
                <!-- AQUI FINAL CODIGO -->
              </div>
              <div class="modal-footer">
                <button type="button" id="borrarSistema" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="InformacionSistema" class="btn btn-primary">Guardar cambios</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- FINAL MODAL AJUSTES DEL SISTEMA -->


        <!-- TITULO PARAMETROS DE SEGURIDAD -->
        <h2 class="content-header"><small>Parametros de Seguridad</small></h2>
        
        
        <!-- INICIO AJUSTES DE SEGURIDAD -->
        <div class="col-md-4">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
                <img class="img-circle" src="https://image.flaticon.com/icons/png/512/95/95454.png" alt="User Avatar">
              </div>

              <h3 class="widget-user-username">Ajustes</h3>
              <h5 class="widget-user-desc"><strong>Parámetros de seguridad</strong></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a><strong>Intentos inicio de sesión:</strong>
                <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="text" name="nombre" class="form-control" id="intentosSesion" value="<?php echo $PIntentos['valor'];?>" placeholder="Nombre" onkeypress="return soloNumeros(event)">
                    </div>
                  </div></a></li>
                <li><a><strong>Cantidad preguntas de seguridad:</strong>
                <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="text" name="nombre" class="form-control" id="cantPreguntas" value="<?php echo $PPreguntas['valor'];?>" placeholder="Nombre" onkeypress="return soloNumeros(event)">
                    </div>
                  </div></a></li>
                <li><a><strong>Vigencia cuenta usuarios: </strong>
                <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="text" name="nombre" class="form-control" id="vigUsuario" value="<?php echo $PVigencia['valor'];?>" placeholder="Nombre" onkeypress="return soloNumeros(event)">
                    </div>
                  </div></a></li>
                <li><br><div class="text-center form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                    <input type="hidden" id="tipo" name="cambio_info" value="cambio_info">
                    <button type="button" id="editar" class="btn btn-success actualizar editar" data-toggle="modal" data-target="#modal-seguridad" data-idusuario="<?= $_SESSION['id'];?>" data-nombreusuario="<?= $_SESSION['usuario'] ?>">
                    Guardar cambios</button>
                    </div>
                    <br>
                  </div></li>
                  <br>
              </ul>
            </div>
          </div>
        </div>
        <!-- FIN AJUSTES DE SEGURIDAD -->

      </div>
    
    </section>
    
    <!-- /.content -->
  </div>
  <?php

}else{
echo "<script type='text/javascript'>
window.location.href='index.php';
</script>";}
}?>