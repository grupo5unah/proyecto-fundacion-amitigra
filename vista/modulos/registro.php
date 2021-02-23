<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">

  <?php
  //Como saber si se esta conectado a la base de datos
  include_once('../../modelo/conexionbd.php');
/*if($conn->ping()){
    echo "conectado";
} else {
    echo "error de conexion";
}*/
  ?>
  <div class="register-box-body">
    <form method="post" enctype="multipart/form-data">
      <p class="register-box-msg">Registro de usuario</p>
      <div class="row">
        <div class="col-md-18">
          <!--INICIO FORM-->
          
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li><a></a></li>               
                <li><a></a></li> 
                <li><a></a></li>
                <li><a></a></li>
                <li><a></a></li>
              </ul>
              <div class="tab-content">
              <!--INFORMACION DEL USUARIO-->
                <div class="active tab-pane" id="activity">
                    <div class="columna">
                      <div class="form-group has-feedback">
                        <input type="text" maxlength="50" id="nombre" name="nombre" class="form-control" placeholder="Nombre completo" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); espacio_Letras(this); verificar(this.value)">
                        <span class="fa fa-user form-control-feedback"></span>
                      </div>
                        <div class="form-group has-feedback">
                          <input type="text" maxlength="15" class="form-control" name="usuario" placeholder="Nombre de usuario" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                          <span class="fa fa-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                          <input type="text" maxlength="50" class="form-control" name="correo" placeholder="Correo electrónico" onkeyup="SinEspacio(this)">
                          <span class="fa fa-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                          <select class="form-control" name="genero" id="genero">
                            <option disabled selected>Seleccione genero</option>
                            <option value="masculino">Masculino</option>
							              <option value="femenino">Femenino</option>
                          </select>
                        </div>
                        <div class="form-group has-feedback">
                          <input type="text" maxlength="8" class="form-control" name="telefono" placeholder="Número de teléfono" onkeypress="return soloNumeros(event)">
                          <span class="fa fa-phone-square form-control-feedback"></span>
                        </div>
                        <br>

                        <div class="text-center form-group has-feedback">
                          <a href="login.php" class="btn btn-danger">Cancelar</a>
                        </div>
                        <div class="text-center form-group has-feedback">
                          <button href="#timeline" class="btn btn-success" id="enviar" data-toggle="tab">Siguiente</button>
                        </div>
                    </div> 
                  </div>
     

                <!--PRIMER PREGUNTA-->
                <div class="tab-pane" id="timeline">
                  <div class="post text-center">
                    <div class="form-group">
                      <label class="color-enlaces" for="">Pregunta número 1</label>
                      <br>
                      <label class="color-enlaces">Selecciona una pregunta</label>
                      <select name = "id_pregunta1" class="form-control">
                        <option>Seleccione una pregunta...</option>
                        <?php
                             include_once ('../../modelo/conexionbd.php');
      
                             $stmt = "SELECT id_pregunta, pregunta FROM tbl_preguntas";
                             $resultado = mysqli_query($conn,$stmt);
                            ?>
                            <?php foreach($resultado as $opciones):?>
                                <option value="<?php echo $opciones['id_pregunta']?>"><?php echo $opciones['pregunta']?></option>
                            <?php endforeach;?>
                      </select>
                    </div>
                      <div class="form-group has-feedback">
                        <input type="text" maxlength="15" id="preg1" class="form-control" name="pregunta1" placeholder="Respuesta" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                        <span class="glyphicon glyphicon glyphicon-pencil form-control-feedback"></span>
                      </div>
                      <br>
                      <div class="columna">
                      <button class="btn btn-primary" href="#activity" id="prevtab" data-toggle="tab">Anterior</button>
                      <button class="btn btn-success" href="#settings" id="nexttab" data-toggle="tab">Siguiente</button>
                    </div>
                  </div>
                </div>

                <!--SEGUNDA PREGUNTA-->
                <div class="tab-pane" id="settings">
                  <div class="post text-center">
                    <div class="form-group">
                    <label class="color-enlaces" for="">Pregunta número 2</label>
                    <br>
                      <label class="color-enlaces">Selecciona una pregunta</label>
                      <select name = "id_pregunta2" class="form-control">
                      <option>Seleccione una pregunta...</option>
                        <?php
                             include_once ('../../modelo/conexionbd.php');
      
                             $stmt = "SELECT id_pregunta, pregunta FROM tbl_preguntas";
                             $resultado = mysqli_query($conn,$stmt);
                            ?>
                            <?php foreach($resultado as $opciones):?>
                                <option value="<?php echo $opciones['id_pregunta']?>"><?php echo $opciones['pregunta']?></option>
                            <?php endforeach;?>
                      </select>
                    </div>
                      <div class="form-group has-feedback">
                        <input type="text" maxlength="15" id="preg2" class="form-control" name="pregunta2" placeholder="Respuesta" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                        <span class="glyphicon glyphicon glyphicon-pencil form-control-feedback"></span>
                      </div>
                      <br>
                      <div class="columna">
                      <button class="btn btn-primary" href="#timeline" id="prevtab" data-toggle="tab">Anterior</button>
                      <button class="btn btn-success" href="#settings1" id="nexttab" data-toggle="tab">Siguiente</button>
                    </div>
                  </div>
                </div>

                <!--TERCER PREGUNTA-->
                <div class="tab-pane" id="settings1">
                  <div class="post text-center">
                    <div class="form-group">
                    <label class="color-enlaces" for="">Pregunta número 3</label>
                    <br>
                      <label class="color-enlaces">Selecciona una pregunta</label>
                      <select name = "id_pregunta3" class="form-control">
                      <option>Seleccione una pregunta...</option>
                        <?php
                             include_once ('../../modelo/conexionbd.php');
      
                             $stmt = "SELECT id_pregunta, pregunta FROM tbl_preguntas";
                             $resultado = mysqli_query($conn,$stmt);
                            ?>
                            <?php foreach($resultado as $opciones):?>
                                <option value="<?php echo $opciones['id_pregunta']?>"><?php echo $opciones['pregunta']?></option>
                            <?php endforeach;?>
                      </select>
                    </div>
                      <div class="form-group has-feedback">
                        <input type="text" maxlength="15" id="preg3" class="form-control" name="pregunta3" placeholder="Respuesta" onkeypress="return soloLetras(event); return soloNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                        <span class="glyphicon glyphicon glyphicon-pencil form-control-feedback"></span>
                      </div>
                      <br>
                      <div class="columna">
                      <button class="btn btn-primary" href="#settings" id="prevtab" data-toggle="tab">Anterior</button>
                      <button class="btn btn-success" href="#settings2" id="nexttab" data-toggle="tab">Siguiente</button>
                    </div>
                  </div>
                </div>
                <!--CONFIGURACION DE LA CONTRASENA-->
                <div class="tab-pane" id="settings2">
                  <div class="post text-center">
                    <div class="input-group col-sm-11 has-feedback">
                    <label for="inputSkills" class="col-sm-8 control-label">Nueva contraseña</label>
                        <input id="PassNuevo" type="password" class="form-control" name="password" placeholder="Contraseña">
                        
                      </div>
                      <br>
                      <div class="input-group has-feedback">
                        <input id="ConfPass" type="password" class="form-control" name="password2" placeholder="Confirmar contraseña">
                        <span class="input-group-btn" onclick="mostrarPassword()">
                          <button class="btn btn-default" type="button"><i class="fa fa-eye-slash icon"></i></button>
                        </span>
                      </div>
                      <br>
                      <div class="columna">
                        <button class="btn btn-primary" href="#settings1" data-toggle="tab">Anterior</button>
                        <input type="hidden" name="tipo" value="registro">
                        <button type="submit" name="submit" class="btn btn-success">Registrarse</button>
                      </div>
                      
                  </div>
                </div>
                </div>
              </div>
              <!-- /.tab-content -->
            </div>
          
          <!--FIN FORM-->
        </div>   


        
      </div>
      
    </form>
    <?php
                      include("../../controlador/ctr.registro.php");

                      $registrarse = new Registro();
                      $registrarse->ctrRegistro();
                      ?>
  </div>
  <!-- /.form-box -->
</div>

<script src="../dist/js/app.login.js"></script>

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../plugins/iCheck/icheck.min.js"></script>
</body>
</html>
