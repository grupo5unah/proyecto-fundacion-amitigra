<?php
    session_start();
    //$cerrar_sesion = $_GET['cerrarSesion.php'];
    if(!isset($cerrar_sesion)){
        session_destroy();
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SAAT | Inicio Sesión</title>
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
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>AMI</b>TIGRA</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Iniciar sesión</p>

    <form id="login" method="post">
      <div class="form-group has-feedback">
        <input type="text" id="usuario" maxlength="15" class="form-control" name="usuario" placeholder="Nombre de usuario" value="<?php if(isset($_POST['usuario'])){echo $_POST['usuario'];}?>" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
        <span class="glyphicon glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="input-group has-feedback">
        <input id="P_Password" type="password" class="form-control" name="password" placeholder="Ingrese su contraseña">
        <span class="input-group-btn" onclick="PasswordMostrar()">
          <button class="btn btn-default" type="button"><i class="fa fa-eye-slash icon"></i></button>
        </span>
      </div>
      <br>
      <div class="row">
        <!-- /.col -->
        <div class="text-center">
		      <input type="hidden" id="tipo" name="tipo" value="login">
          <button type="submit" id="btn" class="btn btn-success btn-flat">Iniciar sesión</button>
        </div>
        <!-- /.col -->
	    </div>

      <script type="text/javascript">
      window.onload = function(){

        let usuario = document.getElementById('usuario');
        let contrasena = document.getElementById('P_Password');

        //BLOQUEA EL COPIADO Y PEGADO EN EL INPUT USUARIO
        usuario.onpaste = function(e){
          e.preventDefault();
        }

        usuario.oncopy = function(e){
          e.preventDefault();
        }

        //BLOQUEA EL COPIADO Y PEGADO EN EL INPUT CONTRASENA
        contrasena.onpaste = function(e){
          e.preventDefault();
        }

        contrasena.oncopy = function(e){
          e.preventDefault();
        }
        }
    
      </script>

    </form>

    <div class="text-center">
    <a class="color-enlaces" href="olvide_contrasena.php">Olvide mi contraseña</a><br>
    <a href="registro.php" class="color-enlaces">Registrarse</a>
  </div>

  <!-- </div>
  <div class="text-center">
  <a class="color-enlaces fa fa-plus-circle" href="masinformacion.php"> mas informacion</a>
  </div> -->

  <!-- /.login-box-body -->
</div>
<?php

    include_once('../../controlador/ctr.login.php');
    $login = new Login();
    $login->ctrLogin();
	?>

<!-- /.login-box -->

<script src="../dist/js/app.login.js"></script>
<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../dist/js/jquery-3.5.1.js"></script>
<script src="../plugins/iCheck/icheck.min.js"></script>

<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
<!-- <script src="../dist/js/prueba.js"></script> -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>