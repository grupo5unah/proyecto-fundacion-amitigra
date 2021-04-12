<!DOCTYPE html>
<html>
<?php
include_once 'funciones/sesiones.php';
$usuario = $_SESSION['usuario'];
$rol_id = $_SESSION['rol'];
$ingreso = $_SESSION['primer_ingreso'];

/*Aqui establecemos el tiempo de la sesión en segundos
  para pasar a la pantalla de inactividad*/
$TiempoActividad = 40;
$tiempo = $TiempoActividad - 20;
// Comprobar si $_SESSION["timeout"] está establecida
if (isset($_SESSION["timeout"])) {
  // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
  $sessionTTL = time() - $_SESSION["timeout"];
  if ($sessionTTL > $tiempo) {
    //session_destroy();
    //session_unset();
    //header('location:vista/modulos/bloqueoInactividad.php');
    //die();
  }
}
// El siguiente key se crea cuando se inicia sesión
$_SESSION["timeout"] = time();
?>

<?php

$usuario_id = $_SESSION['id'];
require './modelo/conexionbd.php';

$nombre_sistema = 'NOMBRE_SISTEMA';

$nombre = $conn->prepare("SELECT parametro, valor FROM tbl_parametros WHERE usuario_id = ? AND parametro = ?;");
$nombre->bind_Param("is", $usuario_id, $nombre_sistema);
$nombre->execute();
$nombre->bind_Result($parametro, $valor);

if ($nombre->affected_rows) {
  $existe = $nombre->fetch();

  if ($existe) {
    $extraer = substr($valor, 0, 4);

?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $extraer;}}?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  
  <link rel="stylesheet" href="vista/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="vista/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="vista/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="preload" href="vista/dist/css/AdminLTE.css" as="style">
  <link rel="stylesheet" href="vista/dist/css/AdminLTE.css">
  <link rel="stylesheet" href="vista/dist/css/estiloReserva.css">
 
  <link rel="stylesheet" href="vista/dist/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="vista/dist/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="vista/dist/css/dataTables.bootstrap4.min.css">
  <!-- <link rel="stylesheet" href="vista/dist/css/sweetalert.css"> -->
  <link rel="stylesheet" href="vista/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="vista/bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="vista/bower_components/select2/dist/css/select2.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="vista/bower_components/jvectormap/jquery-jvectormap.css">  
  <!-- Date Picker -->
  <link rel="stylesheet" href="vista/dist/css/bootstrap-datepicker.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="vista/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <!-- <link rel="stylesheet" href="vista/css/sweetalert2.min.css"> -->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  
</head>
<!--sidebar-collapse, hace que la barra lateral isquierda aparezca no expandida-->
<body body class="hold-transition skin-green sidebar-collapse sidebar-mini" onload="startTime()">
<div class="wrapper">

  <?php

  include('vista/plantilla/header.php');
  include('vista/plantilla/menu.php');


    if(isset($_GET["ruta"])){
      if($_GET["ruta"] == "inicio"||
        $_GET["ruta"] == "camping"||
        $_GET["ruta"] == "reservacamping"||
        $_GET["ruta"] == "hotel" ||
        $_GET["ruta"] == "senderos" ||        
        $_GET["ruta"] == "senderosN" ||
        $_GET["ruta"] == "senderosE" ||
        $_GET["ruta"] == "reservahotel" ||
        $_GET["ruta"] == "solicitudes" ||
        $_GET["ruta"] == "mantTipoSolicitudes" || 
        $_GET["ruta"] == "mantEstadosSolicitud" || 
        $_GET["ruta"] == "mantenimiento" ||
        $_GET["ruta"] == "producto" ||
        $_GET["ruta"] == "existencia"||
        $_GET["ruta"] == "ordenes"||  
        $_GET["ruta"] == "perfil" ||
        $_GET["ruta"] == "pdf" ||
        $_GET["ruta"] == "mantenimientoopciones" ||
        $_GET["ruta"] == "mantLocalidadesyTipoProducto" ||
        $_GET["ruta"] == "mantenimiento" ||
        $_GET["ruta"] == "bitacora" ||
        $_GET["ruta"] == "backup" ||
        $_GET["ruta"] == "cerrarSesion" ||
        $_GET["ruta"] == "recuperacionPregunta" ||
        $_GET["ruta"] == "bloqueoInactividad" ||
        $_GET["ruta"] == "infoBackup" ||
        $_GET["ruta"] == "conf_preguntas" ||
        $_GET["ruta"] == "pruebaTab" ||
        $_GET["ruta"] == "carrusel" ||
        $_GET["ruta"] == "mantLocalidad" ||
        $_GET["ruta"] == "mantroles" ||
        $_GET["ruta"] == "mantProducto" ||
        $_GET["ruta"] == "rol" ||
        $_GET["ruta"] == "parametrosSeguridad" ||
        $_GET["ruta"] == "mantObjetos" ||
        $_GET["ruta"] == "mantparametros" ||
        $_GET["ruta"] == "mantpermisos" ||
        $_GET["ruta"] == "mantpreguntas" ||
        $_GET["ruta"] == "mantClientes" ||
        $_GET["ruta"] == "mantReservaciones" ||
        $_GET["ruta"] == "mantEstados" ||
        $_GET["ruta"] == "mantHabiServ" ||
        $_GET["ruta"] == "menuSolicitudes" ||
        $_GET["ruta"] == "mantTipoBoletos" ||
        $_GET["ruta"] == "mantNacionalidad" ||
        $_GET["ruta"] == "panel" ||
        $_GET["ruta"] == "parametrosSistema" ||
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

<!-- Bootstrap WYSIHTML5 -->
<script src="vista/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="vista/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="vista/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="vista/dist/js/adminlte.min.js"></script>

<script src="vista/dist/js/jquery-3.5.1.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
<script src="vista/dist/js/jquery.dataTables.min.js"></script>
<script src="vista/dist/js/jquery.dataTables.js"></script>
 <script src="vista/dist/js/jquery.dataTables.js"></script>
 <!-- datepicker -->
<script src="vista/dist/js/bootstrap-datepicker.js"></script> 
 <!-- datetimepicker -->
 <script src="vista/dist/js/bootstrap-datetimepicker.js"></script> 
<script src="vista/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vista/dist/js/dataTables.responsive.min.js"></script> 
<script src="vista/dist/js/dataTables.buttons.min.js"></script>
<script src="vista/dist/js/jszip.min.js"></script>
<script src="vista/dist/js/buttons.colVis.min.js"></script>
<script src="vista/dist/js/buttons.print.min.js"></script>
<script src="vista/dist/js/pdfmake.min.js"></script>
<script src="vista/bower_components/moment/min/moment.min.js"></script>
<script src="vista/dist/assets/js/jquery.validate.min.js"></script>
<!-- <script src="vista/dist/js/bootstrap-datepicker.min.js"></script>  -->
<script src="vista/bower_components/select2/dist/js/select2.min.js"></script>
<script src="vista/bower_components/select2/dist/js/select2.full.min.js"></script>
 <!-- datepicker -->

<script src="vista/dist/js/vfs_fonts.js"></script>
<script src="vista/dist/js/buttons.html5.min.js"></script>

<script src="vista/dist/js/funciones.js"></script>
<script src="vista/dist/js/mapa.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js" 
integrity="sha512-DZqqY3PiOvTP9HkjIWgjO6ouCbq+dxqWoJZ/Q+zPYNHmlnI2dQnbJ5bxAHpAMw+LXRm4D72EIRXzvcHQtE8/VQ==" crossorigin="anonymous"></script>
<script src="vista/dist/js/tablas.js"></script>
<script src="vista/dist/js/product.js" type='module'></script>
<script src="vista/dist/js/roles.js"></script>
<script src="vista/dist/js/objetos.js"></script>
<script src="vista/dist/js/mantProducto.js"></script>
<script src="vista/dist/js/reportes.js"></script>
<script src="vista/dist/js/ordenes.js"></script>
<script src="vista/dist/js/hotel.js"></script>
<script src="vista/dist/js/camping.js"></script>
<script src="vista/dist/js/tablaReserva.js"></script>
<script src="vista/dist/js/clientes.js"></script>
<script src="vista/dist/js/reservaciones.js"></script>
<script src="vista/dist/js/estado.js"></script>
<script src="vista/dist/js/manthabserv.js"></script>
<script src="vista/dist/js/gUsuarios.js"></script>
<script src="vista/dist/js/infoperfil.js"></script>
<script src="vista/dist/js/copiaSeguridad.js"></script>
<script src="vista/dist/js/app.login.js"></script>
<script src="vista/dist/js/reloj.js"></script>
<script src="vista/dist/js/actualizarParametros.js"></script>
<!-- <script src="vista/dist/js/actualizarinfoPerfil.js"></script> -->
<!-- <script src="vista/dist/js/recargar.js"></script> -->
<script src="vista/dist/js/senderos.js"></script>
<script src="vista/dist/js/nacionalidad.js"></script>
<script src="vista/dist/js/solicitudes.js"></script>
<script src="vista/dist/js/tipoBoletos.js"></script>
<script src="vista/dist/js/tipoSolicitudes.js"></script>
<script src="vista/dist/js/EstadosSolicitud.js"></script>
<!-- <script src="vista/dist/js/sweetalert.min.js"></script> -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="vista/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="vista/dist/js/demo.js"></script>
<!-- <script src="vista/dist/js/sweetalert2.all.min.js"></script> -->
<!--JS PARA LA TABLA-->
</body>
</html>
