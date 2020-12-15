<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SAAT | Cambio contraseña</title>
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
    <p class="texto-msg">Cambio contraseña</p>

    <form action="" method="post">
		<div class="form-group has-feedback">
        	<input id="PassActual" type="password" class="form-control" name="ConActual" placeholder="Contraseña actual">
        	<span class="input-group-btn">
        	</span>
		</div>
		<br>
		<div class="form-group has-feedback">
        	<input id="PassNueva" type="password" class="form-control" name="ConNueva" placeholder="Nueva contraseña">
        	<span class="input-group-btn">
        	</span>
		</div>
		<br>
      <div class="input-group has-feedback">
        <input id="ConfPass" type="password" class="form-control" name="ConfPass" placeholder="Confirmar contraseña">
        <span class="input-group-btn" onclick="mostrarPassword()">
          <button class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_conf"></i></button>
        </span>
      </div>
      <br>
      <div class="row">
        <!-- /.col -->
        <div class="text-center">
		<input type="hidden" name="tipo" value="login">
		<a href="login.php" type="submit" class="btn btn-primary btn-flat">regresar</a>
		<input type="hidden" name="tipo" value="cambio_contrasena">
          <button type="submit" onclick="validar()" class="btn btn-success btn-flat">Cambio contraseña</button>
        </div>
        <!-- /.col -->
	  </div>
	  
    </form>

  </div>
	<div></div>
  	<?php
	include_once('../../controlador/ctr.cambioContrasena.php');
	$login = new CambioContrasena();
	$login->ctrCambioContrasena();
	?>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

	<script>
		function validar() {
		if ($('#PassActual').val().length == "") {
			alert('Ingrese rut');
			document.body.innerHTML = "<div class='alert alert-danger'>Error</div>";
			return false;
		}
		}
	</script>

	<script type="text/javascript">
		function mostrarPassword(){
			var cambio = document.getElementById("PassActual");
			if(cambio.type == "password"){
				cambio.type = "text";
				$('.icon_actual').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				cambio.type = "password";
				$('.icon_actual').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}
		
			var nueva = document.getElementById("PassNueva");
			if(nueva.type == "password"){
				nueva.type = "text";
				$('.icon_nuevo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				nueva.type = "password";
				$('.icon_nuevo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}

			var conf = document.getElementById("ConfPass");
			if(conf.type == "password"){
				conf.type = "text";
				$('.icon_conf').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
			}else{
				conf.type = "password";
				$('.icon_conf').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
			}
		} 
	</script>

	<script>
		SinEspacio=function(input){
		input.value=input.value.replace(' ','');}
	</script>

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../plugins/iCheck/icheck.min.js"></script>
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
