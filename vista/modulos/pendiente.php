<!DOCTYPE html>
<html>
<?php
include "../../funciones/sesiones.php"; 
$usuario = $_SESSION['usuario'];

$id_objeto = 17;

?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="../../fotoPerfil/favicon.ico">
  <title>SAAT | Cuenta no activa</title>
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
  include_once('../../modelo/conexionbd.php');
  //$usuario = $_SESSION['usuario'];
  ?>
    <div class="register-box-body">
        <p class="register-box-msg">Cuenta aún no activa</p>
        <form id="registroPreguntas" method="post">
      
            <div class="row">
                <div class="col-md-18">
                    <!--INICIO FORM-->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li><a></a></li>
                        </ul>
                        <div class="tab-content">
                            <!--INFORMACION DEL USUARIO-->
                            <div class="active tab-pane" id="activity">
                                <div class="post text-center">
						            <div class="form-group has-feedback">
                    		            <div class="color-enlaces alert alert-light" role="alert">
                     			            <h4><i class="fa fa-check-circle"> Bienvenido/a <?php echo strtoupper($usuario);?>:</i></h4>
                     			            <strong>Ahora un último paso <?php echo strtoupper($usuario); ?>, para poder hacer uso
								            del sistema el administrador debe de darte de alta. ¡¡Se paciente!!.</strong>
								            <br>
                                            <br>
								            HAZ CLIC EN EL BOTÓN <strong>LISTO</strong> PARA REGRESAR AL INICIO DE SESIÓN
                    		            </div>
                  		            </div>
					            </div>
					            <div class="form-group">
                                    <div class="text-center form-group has-feedback">
                                        <a href="login.php" class="btn btn-success">Listo</a>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
        </form>
  </div>
</div>

<!-- <script src="../dist/js/registro.js"></script> -->

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../dist/js/jquery-3.5.1.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
<!-- <script src="../dist/js/app.login.js"></script> -->
<!-- <script src="../dist/js/recargar.js"></script> -->
<!-- <script src="../dist/js/registro.js"></script> -->
<!-- <script src="../dist//js/confPreguntas.js"></script> -->
<!-- Bootstrap 3.3.7 -->

<!-- iCheck -->
<script src="../plugins/iCheck/icheck.min.js"></script>
</body>
</html>
