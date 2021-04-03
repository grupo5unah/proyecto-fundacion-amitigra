<!DOCTYPE html>
<html>
<?php
include "../../funciones/sesiones.php"; 
$usuario = $_SESSION['usuario'];
//$id_usuario = $_SESSION['id'];
?>
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
                <li><a></a></li>
                <li><a></a></li>
                <li><a></a></li>
              </ul>
              <div class="tab-content">
             
                <!--TERCER PREGUNTA-->
                <div class="active tab-pane" id="activity">
                  <div class="post text-center">
                    <div class="form-group">
                    <label class="color-enlaces" for="">Pregunta de recuperación</label>
                    <input type="text" value="<?php echo $usuario;?>">
                    <br>
                      <label class="color-enlaces">Selecciona su pregunta</label>
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
                      <button class="btn btn-primary" href="olvide_contrasena" id="prevtab" data-toggle="tab">Anterior</button>
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
                        <span class="input-group-btn" onclick="mostPassword()">
                          <button class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_confi"></i></button>
                        </span>
                      </div>
                      <br>
                      <div class="columna">
                        <button class="btn btn-primary" href="#activity" data-toggle="tab">Anterior</button>
                        <input type="hidden" id="usuario" value="<?php echo $usuario;?>">
                        <button type="button" id="confirmarCambio" name="submit" class="btn btn-success">Actualizar</button>
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
      <?php
        //include("../../controlador/ctr.nuevaPassPregunta.php");

        //$AtualizarPassword = new NuevaPassPregunta();
        //$AtualizarPassword->ctrNuevaPassPregunta();
      ?>
    </form>
  </div>
  <!-- /.form-box -->
</div>


<script type="text/javascript">

window.onload = function(){

  let respuesta = document.getElementById('preg3');
  let contrasena = document.getElementById('PassNuevo3');
  let confContrasena = document.getElementById('ConfPass3');

  //NO PERMITE EL COPIADO Y PEGADO EN EL INPUT RESPUESTA

  respuesta.onpaste = function(e){
    e.preventDefault();
  }

  respuesta.oncopy = function(e){
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

}

</script>

<script src="vista/dist/js/jquery-3.5.1.js"></script>
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
