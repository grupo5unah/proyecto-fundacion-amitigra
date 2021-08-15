<?php

  include_once "../../modelo/conexionbd.php";

  $objeto = 51;

  /*$permiso = "SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta
              FROM tbl_permisos
              WHERE objeto_id = '$objeto';";

  $resultado = mysqli_query($conn, $permiso);

  while($mipermiso = mysqli_fetch_assoc($resultado)):*/

?>
<!DOCTYPE html>
<html>
<?php
$eid = $_GET["eid"];
$tkn = $_GET["tkn"];
$exd = $_GET["exd"];
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="../../fotoPerfil/favicon.ico">
  <title>SAAT | Nueva contraseña</title>
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

    <form method="post">
      <div class="form-group has-feedback">
        <!-- <div class="input-group"> -->
        <input autocomplete="off" id="InputNuevaContrasena" type="password" class="form-control" name="password" placeholder="Ingrese su contrasena">
          <span class="input-group-btn">
        </span>
          <!-- </div> -->
      </div>
      <br>

      <div class="form-group has-feedback">
        <div class="input-group">
          <input autocomplete="off" id="InputConfirmarNuevaContrasena" type="password" class="form-control" name="password2" placeholder="Confirme su contrasena">
          <span class="input-group-btn" onclick="m_Password()">
            <button class="btn btn-default" type="button"><i class="fa fa-eye-slash icon_conf"></i></button>
          </span>
        </div>
        <p id="resp_correo" class="msj_error"></p>
      </div>
      <br>

      <div class="row">
        <div class="form-group text-center">
          <div class="input-group col-sm-12">
            <input type="hidden" id="imputTkn" value="<?php echo $tkn;?>">
            <input type="hidden" id="imputEid" value="<?php echo $eid;?>">
            <input type="hidden" id="imputExd" value="<?php echo $exd;?>">
            <input type="hidden" id="idObjeto" value="<?php echo $objeto;?>">
            <button type="button" id="NuevaContrasena" class="btn btn-primary btn-flat">Cambio contraseña</button>
          </div>
        </div>
      </div>
	  
    </form>

  </div>

  <script type="text/javascript">
  
  window.onload = function(){
    let contrasena = document.querySelector("#InputNuevaContrasena");
    let confirmarContrasena = document.querySelector("#InputConfirmarNuevaContrasena");

    contrasena.onpaste = function(e){
      e.preventDefault();
    }
    contrasena.oncopy = function(e){
      e.preventDefault();
    }

    confirmarContrasena.oncopy = function(e){
      e.preventDefault();
    }
    confirmarContrasena.onpaste = function(e){
      e.preventDefault();
    }
  }
  </script>

</div>


<script src="../dist/js/jquery-3.5.1.js"></script>
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../dist/js/app.login.js"></script>
<script src="../dist/js/nuevaContrasena.js"></script>
<script src="../dist/js/conf.app.js"></script>

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
<?php
    //endwhile;
    ?>