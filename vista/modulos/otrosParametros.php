<?php
require "./modelo/conexionbd.php";

$id_objeto = 18;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" ){
  if($columna["permiso_consulta"] == 1){

    $arreglo = ['MOSTRAR_SOLICITUDES'];

    //TRAE EL LA CANTIDAD QUE SE PUEDE MOSTRAR EN EL INICIO DE LA PANTALLA
    $mostarSolicitudes = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[0]';");
    $resultSolicitudes = mysqli_query($conn, $mostarSolicitudes);
    $PMostrar = mysqli_fetch_assoc($resultSolicitudes);

?>
  <div class="content-wrapper">

    <section class="content-header">
      <h1>Configuración <small>Otros Parámetros</small></h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><i class="fa fa-cog"></i> Otros Parámetros</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-4">
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
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
                <img class="img-circle" src="https://image.flaticon.com/icons/png/512/95/95454.png" alt="User Avatar">
              </div>
              <h3 class="widget-user-username">Ajustes</h3>
              <h5 class="widget-user-desc"><strong>Otros Parámetros</strong></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li id="etiquetaCantidad"><a><strong>Mostrar cantidad de solicitudes:</strong>
                <div class="form-group">
                    <div class="input-group col-sm-12">
                      <input type="text" name="" class="form-control" id="mostrarSolicitudes" value="<?php echo $PMostrar['valor'];?>" placeholder="Ingrese cantidad de elementos a mostrar" onkeypress="return soloNumeros(event)">
                    </div>
                </div></a></li>

                <li><br><div class="text-center form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                    <input type="hidden" id="tipo" name="cambio_info" value="cambio_info">
                    <button type="button" id="editarSolicitudes" class="btn btn-success actualizar" data-toggle="modal" data-target="#modal-solicitudes" data-idusuario="<?= $_SESSION['id'];?>" data-nombreusuario="<?= $_SESSION['usuario'] ?>">
                    Guardar cambios</button>
                    </div>
                    <br>
                  </div></li>
                  <br>
              </ul>
            </div>
          </div>
        </div>
        <!-- FIN AJUSTES DE LA BASE DE DATOS -->

        <!-- INICIO MODAL AJUSTES DE LA BASE DE DATOS -->
        <div class="modal fade" id="modal-solicitudes" data-backdrop="static" data-keyboard="false">
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
                      <label id="etiquetaContraSoli" for="inputSkills" class="col-sm-3 control-label">Contraseña:</label>

                      <div class="input-group col-sm-8">
                        <input id="contrasenaSolicitudes" type="password" class="form-control" name="passConf" placeholder="Ingrese su contraseña">
                        <span class="input-group-btn" onclick="mostrarPassSeguridad()">
                          <button id="editarInfo" class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_seguridad"></i></button>
                        </span>
                      </div>
                    </div>
                </div>
                <!-- AQUI FINAL CODIGO -->
              </div>
              <div class="modal-footer">
                <button type="button" id="borrarSolicitudes" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="InformacionSolicitudes" class="btn btn-primary">Guardar cambios</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- FINAL MODAL AJUSTES DE LA BASE DE DATOS -->

      </div>
    </section>
    
  </div>
  <?php

}else{
echo "<script type='text/javascript'>
window.location.href='index.php';
</script>";}
}?>