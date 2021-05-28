<?php

include_once("../../modelo/conexionbd.php");

$parametro = ["CANT_PREGUNTAS"];

$query = "SELECT valor FROM tbl_parametros WHERE parametro = '$parametro[0]';";
$resultParametro = mysqli_query($conn, $query);

$verparam = mysqli_fetch_assoc($resultParametro);


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="../../fotoPerfil/favicon.ico">
  <title>SAAT | Registro Usuario</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  
  <link rel="stylesheet" href="../dist/css/AdminLTE.css">
  
  <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">

  <?php
  include_once('../../modelo/conexionbd.php');

  $preguntaid = '';
  ?>
  <div class="register-box-body">
      
    <div class="row">
      <div class="col-md-18">
        <!--INICIO FORM-->
        <form id="registro" method="post">
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
              <p class="register-box-msg">Registro de usuario</p>
              <br>
                <div class="columna">
                  <div class="form-group has-feedback">
                    <input autocomplete="off" type="text" maxlength="50" id="nombre" name="nombre" value="<?php if(isset($_POST['nombre'])){echo $_POST['nombre'];}?>" class="form-control" placeholder="Nombre completo" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); verificar(this.value)">
                    <span class="fa fa-user form-control-feedback"></span>
                  </div>

                  <div class="form-group has-feedback">
                  <!-- <div class="input-group"> -->
                    <input autocomplete="off" type="text" maxlength="15" id="usuario" class="form-control" name="usuario" value="<?php if(isset($_POST['usuario'])){echo $_POST['usuario'];}?>" placeholder="Nombre de usuario" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                    <span class="fa fa-user form-control-feedback"></span>
                    <p id="notificacion" class="msj_error"></p>
                    <!-- <input type="text" id="notificacion" value=""> -->
                    <!-- </div> -->
                  </div>
                    
                  <div class="form-group has-feedback">
                  <!-- <div class="input-group"> -->
                    <input autocomplete="off" type="text" maxlength="50" id="correo" class="form-control" name="correo" value="<?php if(isset($_POST['correo'])){echo $_POST['correo'];}?>" placeholder="Correo electrónico" onkeyup="SinEspacio(this); verificar(this.value)">
                    <span class="fa fa-envelope form-control-feedback"></span>
                    <p id="notificacion2" class="msj_error"></p>
                    <!-- </div> -->
                  </div>
                    
                  <div class="form-group has-feedback">
                    <!-- <div class="input-group col-sm-10"> -->
                      <select class="form-control" name="genero" id="genero">
                        <option disabled selected>Seleccione genero</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                      </select>
                    <!-- </div> -->
                  </div>

                  <div class="form-group has-feedback">
                    <!-- <div class="input-group"> -->
                      <input autocomplete="off" type="text" id="telefono" maxlength="8" class="form-control" name="telefono" value="<?php if(isset($_POST['telefono'])){echo $_POST['telefono'];}?>" placeholder="Número de teléfono" onkeyup="verificar2(this.value)" onkeypress="return soloNumeros(event)">
                      <span class="fa fa-phone-square form-control-feedback"></span>
                    <!-- </div> -->
                  </div>
                  <br>

                  <div class="text-center form-group has-feedback">
                    <button type="button" id="btnCancelar" class="btn btn-danger">Cancelar</button>
                  </div>
                  <div class="text-center form-group has-feedback">
                    <button href="#timeline" class="btn btn-success desactivado" id="enviar" data-toggle="tab" disabled>Siguiente</button>
                  </div>
                </div>
              </div>

              <!--PRIMER PREGUNTA-->
              <div class="tab-pane" id="timeline">
              <p class="register-box-msg">Registro de usuario</p>
                <div class="post text-center">
                  <!-- <div class="form-group"> -->
                    <label class="color-enlaces" for="">Pregunta número 1</label>
                    <br>
                    <label class="color-enlaces">Selecciona una pregunta</label>
                    <select id="id_pregunta1" name = "pregunta1" class="sel form-control">
                      <option>Seleccione una pregunta...</option>
                      <?php
                            include_once ('../../modelo/conexionbd.php');
    
                            $stmt = "SELECT id_pregunta, pregunta FROM tbl_preguntas LIMIT $verparam[valor];";
                            $resultado = mysqli_query($conn,$stmt);
                          ?>
                          <?php while($opciones = mysqli_fetch_assoc($resultado)):?>
                              <option <?php echo $preguntaid === $opciones['id_pregunta'] ? 'selected' : ''; ?> value="<?php echo $opciones['id_pregunta']?>"><?php echo $opciones['pregunta']?></option>
                          <?php endwhile;?>
                    </select>
                    <script type="text/javascript">
                          window.onload = function(){
                          $(document).on('change','.sel',function(){
                            $(this).siblings().find('option[value="'+$(this).val()+'"]').remove();
                          });
                          }
                          </script>
                    
                  <!-- </div> -->
                  <br>
                    <div class="form-group has-feedback">
                      <input autocomplete="off" type="text" maxlength="15" id="preg1" class="form-control" name="pregunta1" value="<?php if(isset($_POST['pregunta1'])){echo $_POST['pregunta1'];}?>" placeholder="Respuesta" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                      <span class="glyphicon glyphicon glyphicon-pencil form-control-feedback"></span>
                      <p id="resp" class='msj_error'></p>
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
              <p class="register-box-msg">Registro de usuario</p>
                <div class="post text-center">
                  <div class="form-group">
                  <label class="color-enlaces" for="">Pregunta número 2</label>
                  <br>
                    <label class="color-enlaces">Selecciona una pregunta</label>
                    <select id="id_pregunta2" name = "pregunta2" class="sel form-control">
                    <option>Seleccione una pregunta...</option>
                      <?php
                            include ('../../modelo/conexionbd.php');
    
                            $stmt = "SELECT id_pregunta, pregunta FROM tbl_preguntas LIMIT $verparam[valor];";
                            $resultado = mysqli_query($conn,$stmt);
                          ?>
                          <?php while($opciones = mysqli_fetch_assoc($resultado)):?>
                              <option <?php if(isset($_POST[$opciones['id_pregunta']])){ echo $_POST[$opciones['id_pregunta']];}?> value="<?php echo $opciones['id_pregunta'];?>"><?php echo $opciones['pregunta'];?></option>
                          <?php endwhile;?>
                    </select>
                    <script type="text/javascript">
                          window.onload = function(){
                          $(document).on('change','.sel',function(){
                            $(this).siblings().find('option[value="'+$(this).val()+'"]').remove();
                          });
                          }
                          </script>
                  </div>
                  
                    <div class="form-group has-feedback">
                      <input autocomplete="off" type="text" maxlength="15" id="preg2" class="form-control" name="pregunta2" value="<?php if(isset($_POST['pregunta2'])){echo $_POST['pregunta2'];}?>" placeholder="Respuesta" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                      <span class="glyphicon glyphicon glyphicon-pencil form-control-feedback"></span>
                      <p id="resp2" class="msj_error"></p>
                    </div>
                    <br>
                    
                    <div class="columna">
                    <button class="btn btn-primary" href="#timeline" id="prevtab" data-toggle="tab">Anterior</button>
                    <button class="btn btn-success" href="#settings1" id="nexttab2" data-toggle="tab">Siguiente</button>
                    
                  </div>
                </div>
              </div>

              <!--TERCER PREGUNTA-->
              <div class="tab-pane" id="settings1">
              <p class="register-box-msg">Registro de usuario</p>
                <div class="post text-center">
                  <div class="form-group">
                  <label class="color-enlaces" for="">Pregunta número 3</label>
                  <br>
                    <label class="color-enlaces">Selecciona una pregunta</label>
                    <select id="id_pregunta3" name = "pregunta3" class="sel form-control">
                    <option>Seleccione una pregunta...</option>
                      <?php
                            include_once ('../../modelo/conexionbd.php');
    
                            $stmt = "SELECT id_pregunta, pregunta FROM tbl_preguntas LIMIT $verparam[valor];";
                            $resultado = mysqli_query($conn,$stmt);
                          ?>
                          <?php while($opciones = mysqli_fetch_assoc($resultado)):?>
                              <option <?php //echo $pregid === $opciones['id_pregunta'] ? 'selected' : '';?> value="<?php echo $opciones['id_pregunta'];?>"><?php echo $opciones['pregunta'];?></option>
                          <?php endwhile;?>
                          </select>
                          <script type="text/javascript">
                          window.onload = function(){
                          $(document).on('change','.sel',function(){
                            $(this).siblings().find('option[value="'+$(this).val()+'"]').remove();
                          });
                          }
                          </script>

                  </div>
                    <div class="form-group has-feedback">
                      <input autocomplete="off" type="text" maxlength="15" id="preg3" class="form-control" name="pregunta3" value="<?php if(isset($_POST['pregunta3'])){echo $_POST['pregunta3'];}?>" placeholder="Respuesta" onkeypress="return soloLetras(event); return soloNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                      <span class="glyphicon glyphicon glyphicon-pencil form-control-feedback"></span>
                      <p id="resp3" class="msj_error"></p>
                    </div>
                    <br>
                    
                    <div class="columna">
                    <button class="btn btn-primary" href="#settings" id="prevtab" data-toggle="tab">Anterior</button>
                    <button class="btn btn-success" href="#settings2" id="nexttab3" data-toggle="tab">Siguiente</button>
                    
                  </div>
                </div>
              </div>

              <!--CONFIGURACION DE LA CONTRASENA-->
              <div class="tab-pane" id="settings2">
                <p class="register-box-msg">Registro de usuario</p>
                <div class="post text-center">
                
                  <div class="form-group has-feedback">
                    <div class="input-group">
                      <label for="inputSkills" id="lblContrasena" class="control-label color-enlaces">Ingresa tu contraseña:</label>
                    </div>
                    <input autocomplete="off" id="PassRegistro" type="password" class="form-control" name="password" placeholder="Contraseña">
                      
                  </div>
                    
                    <div class="form-group has-feedback">
                      <div class="input-group">
                        <label for="inputSkills" id="lblConfContrasena" class="control-label color-enlaces">Confirme su contraseña:</label>
                      </div>
                      <div class="input-group">
                        <input autocomplete="off" id="ConfPassR" type="password" class="form-control" name="password2" placeholder="Confirmar contraseña">
                        <span class="input-group-btn" onclick="VerPassword()">
                          <button id="MostrarPass_Registro" class="btn btn-default" type="button"><i class="fa fa-eye-slash icons"></i></button>
                        </span>
                      </div>
                    </div>
                    <br>
                    <div class="columna">
                      <button id="pant_Anterior" class="btn btn-primary" href="#settings1" data-toggle="tab">Anterior</button>
                      <input type="hidden" name="tipo" value="registro">
                      <button type="button" id="btnRegistro" name="btnRegistros" class="btn btn-success">Registrarse</button>
                    </div>     
                </div>
              </div>

              
            </div>
          </div>
        
        </form>
        <!--FIN FORM-->
      </div>     
    </div>
    
  </div>
</div>

<!-- Con JQUERY -->

<!-- $(document).ready(function(){
  $("#bloquear").on('paste', function(e){
    e.preventDefault();
    alert('Esta acción está prohibida');
  })
  
  $("#bloquear").on('copy', function(e){
    e.preventDefault();
    alert('Esta acción está prohibida');
  })
}) -->

<!-- FIN CON JQUERY -->

<script type="text/javascript">

/*window.onload = function(){

  let nombre = document.getElementById('nombre');
  let usuario = document.getElementById('usuario');
  let correo = document.getElementById('correo');
  let telefono = document.getElementById('telefono');
  let pregunta1 = document.getElementById('preg1');
  let pregunta2 = document.getElementById('preg2');
  let pregunta3 = document.getElementById('preg3');
  let contrasena = document.getElementById('PassRegistro');
  let confContrasena = document.getElementById('ConfPassR');

  //Evita el copiado y pegado en el input nombre
  nombre.onpaste = function(e){
    e.preventDefault();
  }
  nombre.oncopy = function(e){
    e.preventDefault();
  }

  //Evita el copiado y pegado en el input usuario
  usuario.onpaste = function(e){
    e.preventDefault();
  }
  usuario.oncopy = function(e){
    e.preventDefault();
  }

  //Evita el copiado y pegado en el input correo
  correo.onpaste = function(e){
    e.preventDefault();
  }
  correo.oncopy = function(e){
    e.preventDefault();
  }

  telefono.onpaste = function(e){
    e.preventDefault();
  }
  telefono.oncopy = function(e){
    e.preventDefault();
  }

  pregunta1.onpaste = function(e){
    e.preventDefault();
  }
  pregunta1.oncopy = function(e){
    e.preventDefault();
  }

  pregunta2.onpaste = function(e){
    e.preventDefault();
  }
  pregunta2.oncopy = function(e){
    e.preventDefault();
  }

  pregunta3.onpaste = function(e){
    e.preventDefault();
  }
  pregunta3.oncopy = function(e){
    e.preventDefault();
  }

  contrasena.onpaste = function(e){
    e.preventDefault();
  }
  contrasena.oncopy = function(e){
    e.preventDefault();
  }

  confContrasena.onpaste = function(e){
    e.preventDefault();
  }
  confContrasena.oncopy = function(e){
    e.preventDefault();
  }
}*/

</script>


<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../dist/js/jquery-3.5.1.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
<script src="../dist/js/app.login.js"></script>
<script src="../dist/js/recargar.js"></script>
<script src="../dist/js/registro.js"></script>
<!-- <script src="../dist/js/funcionPreguntas.js"></script> -->

<script src="../plugins/iCheck/icheck.min.js"></script>
</body>
</html>
