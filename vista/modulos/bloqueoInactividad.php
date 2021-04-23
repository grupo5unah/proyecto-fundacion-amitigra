<!DOCTYPE html>
<html>
<?php
require '../../funciones/sesiones.php';
//session_start();
session_regenerate_id();
$usuario = $_SESSION['usuario'];
//$nom_mayus = strtoupper($usuario);
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SAAT | bloqueo pantalla</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="../dist/css/AdminLTE.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition lockscreen">

<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="#"><b>AMI</b>TIGRA</a>
  </div>

  <div class="lockscreen-name">Usuario: <?php echo strtoupper(trim($_SESSION['usuario']));?></div>

  <div class="lockscreen-item">
    <div class="lockscreen-image">
      <img src="../dist/img/avatar5.png" alt="User Image">
    </div>

    <form method="POST" class="lockscreen-credentials">
    <input type="hidden" name="usuario" id="usuario" class="form-control" value="<?php echo strtoupper(trim($_SESSION['usuario']));?>">
      <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese su contrasena">
        <div class="input-group-btn">
        <input type="hidden" name="tipo" value="bloqueo">
          <button type="submit" name="submit" id="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>    
        </div>
      </div>
    </form>
  </div>
    <?php
        include_once('../../controlador/ctr.inactividad.php');

        $reanudarSesion = new ReanudarSesion();
        $reanudarSesion->ctrReanudarSesion();
      ?>

  <div class="help-block text-center">
    Ingrese su contrasena para recuperar la sesion
  </div>
  <div class="text-center">
    <a href="">O inicie sesion con un usuario diferente</a>
  </div>
  <?php
  if(isset($_GET["ruta"])){
      if($_GET["ruta"] == "cerrarSesion"){
        include("modulos/".$_GET["ruta"].".php");
      } else{
        //include("modulos/error404.php");
      }
    }
    ?>
  <div class="lockscreen-footer text-center">
    Copyright &copy; 2020 <b><a href="https://mocaph.wordpress.com/amitigra/" class="text-black">AMITIGRA</a></b><br>
    Todos los derechos reservados
  </div>
</div>

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
