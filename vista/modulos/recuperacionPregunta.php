<!DOCTYPE html>
<html>
<?php
include "../../funciones/sesiones.php"; 
include "../../modelo/conexionbd.php";

$usuario = $_SESSION['usuario'];
//$id_usuario = $_SESSION['id'];

  $objeto = 50;

  $permiso = "SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta
              FROM tbl_permisos
              WHERE objeto_id = '$objeto';";

  $resultado = mysqli_query($conn, $permiso);

  while($mipermiso = mysqli_fetch_assoc($resultado)):

?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="../../fotoPerfil/favicon.ico">
  <title>SAAT | Recuperacion Contrasena</title>
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

  <div class="register-box-body">
    <form method="post">
      <p class="register-box-msg">Recuperación por pregunta</p>
      <div class="row">
        <div class="col-md-18">
          <!--INICIO FORM-->
          
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li><a></a></li>               
                <li><a></a></li>
              </ul>
              <div class="tab-content">
             
                <!--TERCER PREGUNTA-->
                <div class="active tab-pane" id="activity">
                  <div class="post text-center">

                    <div class="formn-group text-center">
                      <div class="input-group">
                      <label class="color-enlaces" for="">Pregunta de recuperación</label>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <label class="color-enlaces label-form">Selecciona su pregunta</label>
                      </div>
                    </div>

                    <div class="form-group">
                                         
                      <select id="id_pregunta" name = "pregunta_id" class="form-control">
                        <option>Seleccione una pregunta...</option>
                          <?php
                            include_once '../../modelo/conexionbd.php';
      
                            $stmt = "SELECT id_pregunta, pregunta FROM tbl_preguntas";
                            $resultado = mysqli_query($conn,$stmt);
                          ?>
                          <?php foreach($resultado as $opciones):?>
                        <option value="<?php echo $opciones['id_pregunta']?>"><?php echo $opciones['pregunta']?></option>
                          <?php endforeach;?>
                      </select>
                    </div>
                      <div class="form-group has-feedback">
                        <input type="text" maxlength="15" id="respuestaUsuario" class="form-control" name="RespuestaValidar" placeholder="Respuesta" onkeypress="return soloLetras(event); return soloNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                        <span class="glyphicon glyphicon glyphicon-pencil form-control-feedback"></span>
                      </div>
                      <br>
                      <div class="columna">
                      <a class="btn btn-primary" href="cerrar.php">Regresar</a>
                      <button class="btn btn-success" href="#timeline" id="nexttab" data-toggle="tab">Siguiente</button>
                    
                    </div>
                  </div>
                </div>
                <!--CONFIGURACION DE LA CONTRASENA-->
                <div class="tab-pane" id="timeline">
                  <div class="post text-center">
                        <div class="input-group col-sm-11 has-feedback">
                        <input id="PassPregunta" type="password" class="form-control" name="password" placeholder="Contraseña">
                        </span>
                      </div>
                      <br>
                      <div class="input-group has-feedback">
                        <input id="ConfPassPregunta" type="password" class="form-control" name="password2" placeholder="Confirmar contraseña">
                        <span class="input-group-btn" onclick="mostrarPassPregunta()">
                          <button class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_pregunta"></i></button>
                        </span>
                      </div>
                      <br>
                      <div class="columna">
                        <button class="btn btn-primary" href="#activity" data-toggle="tab">Anterior</button>
                        <input type="hidden" id="usuario" value="<?php echo $usuario;?>">
                        <input type="hidden" id="idObjeto" value="<?php echo $objeto;?>">
                        <button type="button" id="confirmarCambio" name="submit" class="btn btn-success">Actualizar</button>
                      </div>
                    
                  </div>
                </div>
                </div>
              </div>
            </div>
        
          <!--FIN FORM-->
        </div>   
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">

window.onload = function(){

  let respuestas = document.getElementById('preg3');
  let contrasenas = document.getElementById('PassNuevo3');
  let confContrasenas = document.getElementById('ConfPass3');

  //NO PERMITE EL COPIADO Y PEGADO EN EL INPUT RESPUESTA

  respuestas.onpaste = function(e){
    e.preventDefault();
  }

  respuestas.oncopy = function(e){
    e.preventDefault();
  }

  contrasenas.onpaste = function(e){
    e.preventDefault();
  }

  contrasenas.oncopy = function(e){
    e.preventDefault();
  }

  confContrasenas.onpaste = function(e){
    e.preventDefault();
  }

  confContrasenas.oncopy = function(e){
    e.preventDefault();
  }

}

</script>

<script src="../dist/js/jquery-3.5.1.js"></script>
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../dist/js/app.login.js"></script>
<script src="../dist/js/recuPregunta.js"></script>
<!-- iCheck -->
<script src="../plugins/iCheck/icheck.min.js"></script>
</body>
</html>
<?php endwhile;?>