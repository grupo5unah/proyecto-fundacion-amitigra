<?php
require "./modelo/conexionbd.php";

$id_objeto = 18;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" ){
  if($columna["permiso_consulta"] == 1){

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
      <h1>Configuración <small>Parámetros de seguridad</small></h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><i class="fa fa-cog"></i> Parámetros de seguridad</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">


      <div class="col-md-4">
        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">

            <div class="form-group">
              <div class="alert alert-light" role="alert">
                <h4><i class="fa fa-unlock-alt"> Importante:</i></h4>
                <strong>Parámetros de seguridad</strong>
                <br><strong>Que tipo de parámetros puedes configurar</strong>
                <br>
                Es muy importante el poder contar con una copia de nuestra base de datos, ya que si en algun momento
                presentamos problemas podes reestablecer la informacion.
              </div>
            </div>
          </div>
        </div>
      </div>

        <input type="hidden" id="idUsuario" value="<?php echo $_SESSION["id"];?>">
        <input type="hidden" id="usuario" value="<?php echo $_SESSION["usuario"];?>">

        <!-- INICIO AJUSTES DE LA BASE DE DATOS -->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
                <img class="img-circle" src="https://image.flaticon.com/icons/png/512/95/95454.png" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
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
          <!-- /.widget-user -->
        </div>
        <!-- FIN AJUSTES DE LA BASE DE DATOS -->

        <!-- INICIO MODAL AJUSTES DE LA BASE DE DATOS -->
        <div class="modal fade" id="modal-seguridad" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Parámetros de Seguridad</h4>
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
                        <input id="contrasenaSeguridad" type="password" class="form-control" name="passConf" placeholder="Ingrese su contraseña">
                        <span class="input-group-btn" onclick="mostrarPassSeguridad()">
                          <button id="editarInfo" class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_seguridad"></i></button>
                        </span>
                      </div>
                    </div>
                </div>
                <!-- AQUI FINAL CODIGO -->
              </div>
              <div class="modal-footer">
                <button type="button" id="borrarSeguridad" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="InformacionSeguridad" class="btn btn-primary">Guardar cambios</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- FINAL MODAL AJUSTES DE LA BASE DE DATOS -->

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