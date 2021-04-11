<?php
  include "../../modelo/conexionbd.php";

  $objeto = 49;

  $permiso = ("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta
                            FROM tbl_permisos
                            WHERE objeto_id = '$objeto'");

  $resultado = mysqli_query($conn, $permiso);

  while($mipermiso = mysqli_fetch_assoc($resultado)):
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SAAT | Recuperacion</title>
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
    <a href="login.php"><b>AMI</b>TIGRA</a>
  </div>
  <div class="login-box-body">
    <p class="login-box-msg">Recuperación de contraseña</p>

    <form method="post">
      <div class="form-group has-feedback">
        <input type="text" maxlength="50" id="correo" class="form-control" name="email" placeholder="Correo electrónico" value="<?php if(isset($_POST['usuario'])){echo $_POST['usuario'];}?>" onkeyup="SinEspacio(this)">
        <span class="glyphicon glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <br>
      <div class="row">
        <div class="alinear">
			<div class="form-group">
				<form method="POST">
				<input type="hidden" id="tipo_correo" name="tipo_correo" value="recuperarCorreo">
		  		<button type="button" id="btnCorreo" name="submit_correo" class="btn btn-primary btn-flat">Mediante correo</button>
				</form>  
			</div>
		  	<div class="form-group">
			  <input type="hidden" id="tipo_pregunta" name="tipo_pregunta" value="recuperarPregunta">
		  		<button type="button" id="btnPregunta" name="submit_pregunta" class="btn btn-primary btn-flat">Mediante pregunta</button>
		  	</div>
        </div>
		<div class="form-group text-center">
      <input type="hidden" id="idObjeto" value="<?php echo $objeto;?>">
		  		<i class="fa fa-arrow-left"><a href="login.php" type="submit" class="btn btn-success btn-flat">Regresar</a></i>
		  	</div>
	  </div>
	</form>
  </div>

</div>

<script type="text/javascript">

//FUNCION EVITAR COPIADO Y PEGADO EN INPUT CORREO
window.onload = function(){

  let correo = document.getElementById('correo');

  correo.onpaste = function(e){
    e.preventDefault();
  }

  correo.oncopy = function(e){
    e.preventDefault();
  }

}

  <?php endwhile;?>
</script>

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="vista/dist/js/jquery-3.5.1.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../dist/js/app.login.js"></script>
<script src="../dist/js/olvide_contrasena.js"></script>
<script src="../dist/js/verificar_correo.js"></script>
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