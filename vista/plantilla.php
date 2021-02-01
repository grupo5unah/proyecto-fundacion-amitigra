<!DOCTYPE html>
<html>
<?php
include_once('funciones/sesiones.php');
$usuario = $_SESSION['usuario'];
$rol_id = $_SESSION['rol'];
$ingreso = $_SESSION['primer_ingreso'];

/*Aqui establecemos el tiempo de la sesión en segundos
  para pasar a la pantalla de inactividad*/
$TiempoActividad = 40;
$tiempo = $TiempoActividad - 20;
// Comprobar si $_SESSION["timeout"] está establecida
if(isset($_SESSION["timeout"])){
    // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
    $sessionTTL = time() - $_SESSION["timeout"];
      if($sessionTTL > $tiempo){
        //session_destroy();
        //session_unset();
        //header('location:vista/modulos/bloqueoInactividad.php');
        //die();
      }
}
// El siguiente key se crea cuando se inicia sesión
$_SESSION["timeout"] = time();
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SAAT</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vista/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="vista/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="vista/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="vista/dist/css/AdminLTE.css">

  <link rel="stylesheet" href="vista/dist/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="vista/dist/css/responsible.dataTables.min.css">

  <link rel="stylesheet" href="vista/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="vista/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="vista/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="vista/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="vista/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="vista/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
</head>
<!--sidebar-collapse, hace que la barra lateral isquierda aparezca no expandida-->
<body class="hold-transition skin-green sidebar-collapse sidebar-mini" onload="startTime()">
<div class="wrapper">

  <?php

  include('vista/plantilla/header.php');
  include('vista/plantilla/menu.php');


    if(isset($_GET["ruta"])){
      if($_GET["ruta"] == "inicio"||
        $_GET["ruta"] == "camping"||
        $_GET["ruta"] == "hotel" ||
        $_GET["ruta"] == "senderos" ||
        $_GET["ruta"] == "solicitudes" ||
        $_GET["ruta"] == "producto" ||
        $_GET["ruta"] == "existencia"||
        $_GET["ruta"] == "perfil" ||
        $_GET["ruta"] == "mantenimiento" ||
        $_GET["ruta"] == "bitacora" ||
        $_GET["ruta"] == "backup" ||
        $_GET["ruta"] == "cerrarSesion" ||
        $_GET["ruta"] == "bloqueoInactividad" ||
        $_GET["ruta"] == "infoBackup" ||
        $_GET["ruta"] == "pruebaTab" ||
        $_GET["ruta"] == "carrusel" ||
        $_GET["ruta"] == "mantLocalidad" ||
        $_GET["ruta"] == "mantroles" ||
        $_GET["ruta"] == "rol" ||
        $_GET["ruta"] == "mantObjetos" ||
        $_GET["ruta"] == "mantparametros" ||
        $_GET["ruta"] == "mantpermisos" ||
        $_GET["ruta"] == "mantpreguntas" ||
        $_GET["ruta"] == "menuSolicitudes" ||
        $_GET["ruta"] == "panel" ||
        $_GET["ruta"] == "configuracion" ||
        $_GET["ruta"] == "reportes" ||
        $_GET["ruta"] == "reporteProducto"){
        include("modulos/".$_GET["ruta"].".php");
      } else{
        include("modulos/error404.php");
      }
    } else {
      include('modulos/inicio.php');
    }

    include('vista/plantilla/footer.php');
  ?>
  
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="vista/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="vista/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->

<!-- Morris.js charts -->
<script src="vista/bower_components/raphael/raphael.min.js"></script>
<script src="vista/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="vista/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="vista/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="vista/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="vista/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="vista/bower_components/moment/min/moment.min.js"></script>
<script src="vista/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="vista/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="vista/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="vista/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="vista/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="vista/dist/js/adminlte.min.js"></script>

<script src="vista/dist/js/jquery-3.5.1.js"></script>
<script src="vista/dist/js/jquery.dataTables.min.js"></script>
<script src="vista/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vista/dist/js/dataTables.responsive.min.js"></script>
<script src="vista/dist/js/tablas.js"></script>
<script src="vista/dist/js/funciones.js"></script>
<script src="vista/dist/js/mapa.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js" 
integrity="sha512-DZqqY3PiOvTP9HkjIWgjO6ouCbq+dxqWoJZ/Q+zPYNHmlnI2dQnbJ5bxAHpAMw+LXRm4D72EIRXzvcHQtE8/VQ==" crossorigin="anonymous"></script>
<script src="vista/dist/js/product.js"></script>
<script src="vista/dist/js/roles.js"></script>
<script src="vista/dist/js/objetos.js"></script>
<script src="vista/dist/js/reportes.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="vista/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="vista/dist/js/demo.js"></script>
<!--JS PARA LA TABLA-->
</body>
</html>
